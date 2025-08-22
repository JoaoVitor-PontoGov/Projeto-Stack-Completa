<?php

  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbAlocacao.php";
  require_once "../../model/mdlTbColaborador.php";
  require_once "../../model/mdlTbEquipamento.php";

  $objTbAlocacao = new TbAlocacao();
  $fmt = new Format();
  $objMsg = new Message();

  //------------------------------------------------------------------------------------------------------------------//
  // A��o de Abertura da Tela de Consulta
  //------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
    require_once "../../view/alocacao/viwConsultaAlocacao.php";
  }
  //------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  A��o de inclus�o de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "incluir") {
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
  //  A��o para a grava��o de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "gravar"){
    $objTbAlocacao->Set("idalocacao",$_POST["idAlocacao"]);
    $objTbAlocacao->Set("idequipamento",$_POST["idEquipamento"]);
    $objTbAlocacao->Set("nmequipamento",utf8_decode($_POST["nmAlocacao"]));
    $objTbAlocacao->Set("dstipo",$_POST["dsTipo"]);
    $objTbAlocacao->Set("nrserie",$_POST["nrSerie"]);
    $objTbAlocacao->Set("dtaquisicao",$_POST["dtAquisicao"]);
    $objTbAlocacao->Set("flstatus",$_POST["flStatus"]);

    $strMessage = "";

    if(empty($objTbAlocacao->Get("nmequipamento"))){
      $strMessage .= "&raquo; O campo <strong>Nome</strong> � obrigat�rio<br>";
    }

    if(empty($objTbAlocacao->Get("dstipo"))){
      $strMessage .= "&raquo; O campo <strong>Tipo</strong> � obrigat�rio<br>";
    }

    if(empty($objTbAlocacao->Get("nrserie"))){
      $strMessage .= "&raquo; O campo <strong>Num Serie</strong> � obrigat�rio<br>";
    }
    if(empty($objTbAlocacao->Get("dtaquisicao"))){
      $strMessage .= "&raquo; O campo <strong>Data de Aquisicao</strong> � obrigat�rio<br>";
    }
    if(empty($objTbAlocacao->Get("flstatus"))){
      $strMessage .= "&raquo; O campo <strong>Status</strong> � obrigat�rio<br>";
    }

    if($strMessage != ""){
      $objMsg->Alert("dlg", $strMessage);
    } else {
      if($objTbAlocacao->Get("idequipamento")!=""){
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