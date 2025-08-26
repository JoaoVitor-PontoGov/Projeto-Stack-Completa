<?php

  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbAlocacao.php";
  require_once "../../model/mdlTbColaborador.php";
  require_once "../../model/mdlTbEquipamento.php";

  $objTbAlocacao = new TbAlocacao();
  $objTbEquipamento = new TbEquipamento();
  $fmt = new Format();
  $objMsg = new Message();

  //------------------------------------------------------------------------------------------------------------------//
  // Ação de Abertura da Tela de Consulta
  //------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
      
    $objTbEquipamento = TbEquipamento::LoadByIdEquipamento($_GET["idEquipamento"]);

    require_once "../../view/alocacao/viwConsultaAlocacao.php";
  }
  //------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de inclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "incluir") {

    $objTbAlocacao->Set("idequipamento", $_GET["idEquipamento"]);

    $blEquipamentoInformado = $_GET["idEquipamento"] != "";

    require_once "../../view/alocacao/viwCadastroAlocacao.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de edição de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "editar"){
    $objTbAlocacao = TbAlocacao::LoadByIdAlocacao($_GET["idAlocacao"]);

    require_once "../../view/alocacao/viwCadastroAlocacao.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de consulta de registro
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]=="ListAlocacao"){
    $objFilter = new Filter($_GET);
    
    global $_intTotalAlocacao;

    $aroTbAlocacao = TbAlocacao::ListByCondicao($objFilter->GetWhere(), $objFilter->GetOrderBy());

    if(is_array($aroTbAlocacao) && count($aroTbAlocacao)> 0){
      $arrLinhas = [];
      $arrTempor =[];

      foreach($aroTbAlocacao as $objTbAlocacao){
        $arrTempor["idalocacao"] = $objTbAlocacao->Get("idalocacao");
        $arrTempor["idequipamento"] = utf8_encode($objTbAlocacao->Get("idequipamento"));
        $arrTempor["nmequipamento"] = utf8_encode($objTbAlocacao->GetObjTbEquipamento()->Get("nmequipamento"));
        $arrTempor["idcolaboradorequipamento"] = utf8_encode($objTbAlocacao->Get("idcolaboradorequipamento"));
        $arrTempor["nmcolaborador"] = utf8_encode($objTbAlocacao->GetObjTbColaborador()->Get("nmcolaborador"));
        $arrTempor["dtinicio"] = $fmt->data($objTbAlocacao->Get("dtinicio"));
        $arrTempor["dtdevolucao"] = $fmt->data($objTbAlocacao->Get("dtdevolucao"));

        array_push($arrLinhas, $arrTempor);
      }

      echo '{"jsnAlocacao": '.json_encode($arrLinhas).', "jsnTotal": '.  $_intTotalAlocacao . '}';

    } else if(!is_array($aroTbAlocacao) && trim($aroTbAlocacao)!= ""){// Sinal de erro na busca
      echo '{"error": ' .$aroTbAlocacao. '}';
    } else {// Nenhum registro encontrado
      echo '{"jsnAlocacao": null}';
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação para a gravação de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "gravar"){
    $objTbAlocacao->Set("idalocacao",$_POST["idAlocacao"]);
    $objTbAlocacao->Set("idequipamento",$_POST["idEquipamento"]);
    $objTbAlocacao->Set("idcolaboradorequipamento",$_POST["idColaborador"]);
    $objTbAlocacao->Set("dtinicio",$_POST["dtInicio"]);
    $objTbAlocacao->Set("dtdevolucao",$_POST["dtDevolucao"]);

    $strMessage = "";

    if(empty($objTbAlocacao->Get("idequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Equipamento</strong> é obrigatório<br>";
    }

    if(empty($objTbAlocacao->Get("idcolaboradorequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Colaborador</strong> é obrigatório<br>";
    }

    if(empty($objTbAlocacao->Get("dtinicio"))){
      $strMessage .= "&raquo; O campo <strong>Data de Inicio</strong> é obrigatório<br>";
    }
    

    if($strMessage != ""){
      $objMsg->Alert("dlg", $strMessage);
    } else {
      if($objTbAlocacao->Get("idalocacao")!=""){
        $arrResult = $objTbAlocacao->Update($objTbAlocacao);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro atualizado com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbAlocacao = new TbAlocacao();
        }
      } else {
        $arrResult = $objTbAlocacao->Insert($objTbAlocacao);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro inserido com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbAlocacao = new TbAlocacao();
        }
      }
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//
  
  //-------------------------------------------------------------------------------------------------------------------//
  // Ação para a exclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "excluir"){
    $objTbAlocacao = TbAlocacao::LoadByIdAlocacao($_POST["idAlocacao"]);

    $arrResult = $objTbAlocacao->Delete($objTbAlocacao);
  
    if($arrResult["dsMsg"]=="ok"){
      $objMsg->Succes("ntf","Registro excluido com sucesso!");
    }else{
      $objMsg->LoadMessage($arrResult);
      $objTbAlocacao = new TbAlocacao();
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação para auto complete
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "AutoCompleteEquipamento"){
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

  if(isset($_GET["action"]) && $_GET["action"] == "AutoCompleteColaborador"){
    $strFiltro = "and upper(clear(nmcolaborador)) like upper(clear('%".utf8_decode($_GET["filter"]["filters"][0]["value"])."%'))";
    $strOrdenacao = " nmcolaborador asc";

    $aroTbColaborador = TbColaborador::ListByCondicao($strFiltro, $strOrdenacao);

    if($aroTbColaborador && is_array($aroTbColaborador)){
      $arrTempor = array();
      $arrLinhas = array();

      foreach($aroTbColaborador as $key => $colaborador){
        $arrTempor["idcolaboradorequipamento"] = utf8_encode($colaborador->Get("idcolaboradorequipamento"));
        $arrTempor["nmcolaborador"] = utf8_encode($colaborador->Get("nmcolaborador"));
        array_push($arrLinhas, $arrTempor);
      }
    }

    header("Content-type:application/json");
    echo "{\"data\":" . json_encode($arrLinhas) . "}";
  } 
  //-------------------------------------------------------------------------------------------------------------------//