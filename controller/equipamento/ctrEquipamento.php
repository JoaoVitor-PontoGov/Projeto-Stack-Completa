<?php
  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbEquipamento.php";

  $objTbEquipamento = new TbEquipamento();
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
        $arrTempor["flstatus"] = $objTbEquipamento->Get("flstatus");

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
    $objTbEquipamento->Set("dtaquisicao",$_POST["dtAquisicao"]);
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

    $arrResult = $objTbEquipamento->Delete($objTbEquipamento);
  
    if($arrResult["dsMsg"]=="ok"){
      $objMsg->Succes("ntf","Registro excluido com sucesso!");
    }else{
      $objMsg->LoadMessage($arrResult);
      $objTbEquipamento = new TbEquipamento();
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//
