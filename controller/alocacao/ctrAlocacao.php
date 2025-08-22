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
  // Ação de Abertura da Tela de Consulta
  //------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
    require_once "../../view/alocacao/viwConsultaAlocacao.php";
  }
  //------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de inclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "incluir") {
    require_once "../../view/colaborador/viwCadastroAlocacao.php";
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