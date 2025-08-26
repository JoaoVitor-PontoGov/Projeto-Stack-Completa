<?php

  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbAlocacao.php";
  require_once "../../model/mdlTbColaborador.php";
  require_once "../../model/mdlTbEquipamento.php";

  $objTbAlocacao = new TbAlocacao();
  $objTbEquipamento = new TbEquipamento();
  $objTbColaborador = new TbColaborador();
  $fmt = new Format();
  $objMsg = new Message();

  //------------------------------------------------------------------------------------------------------------------//
  // A��o de Abertura da Tela de Consulta
  //------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
      
    if($_GET["idEquipamento"] != ""){
      $objTbEquipamento = TbEquipamento::LoadByIdEquipamento($_GET["idEquipamento"]);
    } else {
      $objTbEquipamento = new TbEquipamento;
    }

    if($_GET["idColaborador"] != ""){
      $objTbColaborador = TbColaborador::LoadByIdColaborador($_GET["idColaborador"]);
    } else {
      $objTbColaborador = new TbColaborador;
    }

    require_once "../../view/alocacao/viwConsultaAlocacao.php";
  }
  //------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  A��o de inclus�o de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "incluir") {

    $objTbAlocacao->Set("idequipamento", $_GET["idEquipamento"]);

    $blEquipamentoInformado = $_GET["idEquipamento"] != "";

    require_once "../../view/alocacao/viwCadastroAlocacao.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  A��o de edi��o de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "editar"){
    $objTbAlocacao = TbAlocacao::LoadByIdAlocacao($_GET["idAlocacao"]);

    require_once "../../view/alocacao/viwCadastroAlocacao.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  A��o de consulta de registro
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]=="ListAlocacao"){
    $objFilter = new Filter($_GET);
    $strFilter = $objFilter->GetWhere();
    
    if($_GET["idEquipamento"] != ""){
      $strFilter .= " AND idequipamento = " . $_GET["idEquipamento"];
    }

    if($_GET["idColaborador"] != ""){
      $strFilter .= " AND idcolaboradorequipamento = " . $_GET["idColaborador"];
    }

    global $_intTotalAlocacao;

    $aroTbAlocacao = TbAlocacao::ListByCondicao($strFilter, $objFilter->GetOrderBy());

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
  //  A��o para a grava��o de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "gravar"){
    $objTbAlocacao->Set("idalocacao",$_POST["idAlocacao"]);
    $objTbAlocacao->Set("idequipamento",$_POST["idEquipamento"]);
    $objTbAlocacao->Set("idcolaboradorequipamento",$_POST["idColaborador"]);
    $objTbAlocacao->Set("dtinicio",$_POST["dtInicio"]);
    $objTbAlocacao->Set("dtdevolucao",$_POST["dtDevolucao"]);

    $strMessage = "";

    if(empty($objTbAlocacao->Get("idequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Equipamento</strong> � obrigat�rio<br>";
    }

    if(empty($objTbAlocacao->Get("idcolaboradorequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Colaborador</strong> � obrigat�rio<br>";
    }

    if(empty($objTbAlocacao->Get("dtinicio"))){
      $strMessage .= "&raquo; O campo <strong>Data de Inicio</strong> � obrigat�rio<br>";
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
  // A��o para a exclus�o de registros
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
