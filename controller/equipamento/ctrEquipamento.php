<?php
  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbEquipamento.php";
  require_once "../../model/mdlTbAlocacao.php";

  $objTbEquipamento = new TbEquipamento();
  $objTbAlocacao = new TbAlocacao();
  $fmt = new Format();
  $objMsg = new Message();
  

  //-------------------------------------------------------------------------------------------------------------------//
  // Ação de Abertura da Tela de Consulta
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "winConsulta"){

    if(isset($_GET["frmResult"]) && $_GET["frmResult"] != "") {
      $frmResult = "#".$_GET["frmResult"];
    }

    require_once "../../view/equipamento/viwConsultaEquipamento.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//
  
  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de inclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "incluir"){
    require_once "../../view/equipamento/viwCadastroEquipamento.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de edição de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "editar"){
    $objTbEquipamento = TbEquipamento::LoadByIdEquipamento($_GET["idEquipamento"]);

    require_once "../../view/equipamento/viwCadastroEquipamento.php";
    
  }
  //-------------------------------------------------------------------------------------------------------------------//

  
  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de consulta de registro
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]=="ListEquipamento"){
    $objFilter = new Filter($_GET);
    
    global $_intTotalEquipamento;

    $aroTbEquipamento = TbEquipamento::ListByCondicao($objFilter->GetWhere(), $objFilter->GetOrderBy());

    if(is_array($aroTbEquipamento) && count($aroTbEquipamento)> 0){
      $arrLinhas = [];
      $arrTempor =[];

      foreach($aroTbEquipamento as $objTbEquipamento){
        $arrTempor["idequipamento"] = $objTbEquipamento->Get("idequipamento");
        $arrTempor["nmequipamento"] = utf8_encode($objTbEquipamento->Get("nmequipamento"));
        $arrTempor["dstipo"] = utf8_encode($objTbEquipamento->Get("dstipo"));
        $arrTempor["nrserie"] = $objTbEquipamento->Get("nrserie");
        $arrTempor["dtaquisicao"] = $fmt->data($objTbEquipamento->Get("dtaquisicao"));
        switch($objTbEquipamento->Get("flstatus")){
          case "DP":
            $arrTempor["dsstatus"] =  utf8_encode("Disponível");
            break;
          case "EU":
            $arrTempor["dsstatus"] =  utf8_encode("Em uso");
            break;
          case "EM":
            $arrTempor["dsstatus"] =  utf8_encode("Em manutenção");
            break;
        }
        array_push($arrLinhas, $arrTempor);
      }

      echo '{"jsnEquipamento": '.json_encode($arrLinhas).', "jsnTotal": '.  $_intTotalEquipamento . '}';

    } else if(!is_array($aroTbEquipamento) && trim($aroTbEquipamento)!= ""){// Sinal de erro na busca
      echo '{"error": ' .$aroTbEquipamento. '}';
    } else {// Nenhum registro encontrado
      echo '{"jsnEquipamento": null}';
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação para a gravação de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "gravar"){
    $objTbEquipamento->Set("idequipamento",$_POST["idEquipamento"]);
    $objTbEquipamento->Set("nmequipamento",utf8_decode($_POST["nmEquipamento"]));
    $objTbEquipamento->Set("dstipo",utf8_decode($_POST["dsTipo"]));
    $objTbEquipamento->Set("nrserie",$_POST["nrSerie"]);
    $objTbEquipamento->Set("dtaquisicao",$fmt->data($_POST["dtAquisicao"]));
    $objTbEquipamento->Set("flstatus",$_POST["flStatus"]);

    $strMessage = "";

    if(empty($objTbEquipamento->Get("nmequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Nome</strong> é obrigatório<br>";
    }

    if(empty($objTbEquipamento->Get("dstipo"))){
      $strMessage .= "&raquo; O campo <strong>Tipo</strong> é obrigatório<br>";
    }

    if(empty($objTbEquipamento->Get("nrserie"))){
      $strMessage .= "&raquo; O campo <strong>Num Serie</strong> é obrigatório<br>";
    }
    if(empty($objTbEquipamento->Get("dtaquisicao"))){
      $strMessage .= "&raquo; O campo <strong>Data de Aquisicao</strong> é obrigatório<br>";
    }
    if(empty($objTbEquipamento->Get("flstatus"))){
      $strMessage .= "&raquo; O campo <strong>Status</strong> é obrigatório<br>";
    }

    if($strMessage != ""){
      $objMsg->Alert("dlg", $strMessage);
    } else {
      if($objTbEquipamento->Get("idequipamento")!=""){
        $arrResult = $objTbEquipamento->Update($objTbEquipamento);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro atualizado com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbEquipamento = new TbEquipamento();
        }
      } else {
        $arrResult = $objTbEquipamento->Insert($objTbEquipamento);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro inserido com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbEquipamento = new TbEquipamento();
        }
      }
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  // Ação para a exclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "excluir"){
    $objTbEquipamento = TbEquipamento::LoadByIdEquipamento($_POST["idEquipamento"]);

    $aroTbAlocacao = TbAlocacao::ListByCondicao("AND idequipamento=" . $_POST["idEquipamento"], "");
    $dtbLink = new DtbServer();
    
    $dtbLink->Begin();
    
    if(is_array($aroTbAlocacao)){
      foreach($aroTbAlocacao as $key => $objTbAlocacao){
        $objTbAlocacao->SetDtbLink($dtbLink);
        
        $arrResult = $objTbAlocacao->Delete($objTbAlocacao);
        
        if($arrResult["dsMsg"]!="ok"){
          $dtbLink->Rollback();
          $objMsg->LoadMessage($arrResult);
          exit;
        }
      }
    }
    $objTbEquipamento->SetDtbLink($dtbLink);
    
    $arrResult = $objTbEquipamento->Delete($objTbEquipamento);
  
    if($arrResult["dsMsg"]=="ok"){
      $dtbLink->Commit();
      $objMsg->Succes("ntf","Registro excluido com sucesso!");
    }else{
      $dtbLink->Rollback();
      $objMsg->LoadMessage($arrResult);
      $objTbEquipamento = new TbEquipamento();
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação para auto complete
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "AutoComplete"){
    $strFiltro = " and upper(clear(nmequipamento)) like upper(clear('%".utf8_decode($_GET["filter"]["filters"][0]["value"])."%'))";
    $strOrdenacao = " nmequipamento asc";

    $aroTbEquipamento = TbEquipamento::ListByCondicao($strFiltro, $strOrdenacao);

    if($aroTbEquipamento && is_array($aroTbEquipamento)){
      $arrTempor = array();
      $arrLinhas = array();

      foreach($aroTbEquipamento as $key => $objTbEquipamento){
        $arrTempor["idequipamento"] = utf8_encode($objTbEquipamento->Get("idequipamento"));
        $arrTempor["nmequipamento"] = utf8_encode($objTbEquipamento->Get("nmequipamento"));
        array_push($arrLinhas, $arrTempor);
      }
    }

    header("Content-type:application/json");
    echo "{\"data\":" . json_encode($arrLinhas) . "}";
  }  