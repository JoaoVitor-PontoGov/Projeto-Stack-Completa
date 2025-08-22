<?php
  require_once "../../lib/libDatabase.php";
  require_once "../../lib/libUtils.php";
  require_once "../../model/mdlTbColaborador.php";

  $objTbColaborador = new TbColaborador();
  $objMsg = new Message();

  //-------------------------------------------------------------------------------------------------------------------//
  // Ação de Abertura da Tela de Consulta
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
    require_once "../../view/colaborador/viwConsultaColaborador.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//
  
  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de inclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if (isset($_GET["action"]) && $_GET["action"] == "incluir") {
    require_once "../../view/colaborador/viwCadastroColaborador.php";
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de edição de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "editar"){
    $objTbColaborador = TbColaborador::LoadByIdColaborador($_GET["idColaborador"]);

    require_once "../../view/colaborador/viwCadastroColaborador.php";
    
  }

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de consulta de registro
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]=="ListColaborador"){
    $objFilter = new Filter($_GET);
    
    global $_intTotalColaborador;

    $aroTbColaborador = TbColaborador::ListByCondicao($objFilter->GetWhere(), $objFilter->GetOrderBy());

    if(is_array($aroTbColaborador) && count($aroTbColaborador)> 0){
      $arrLinhas = [];
      $arrTempor =[];

      foreach($aroTbColaborador as $objTbColaborador){
        $arrTempor["idcolaboradorequipamento"] = $objTbColaborador->Get("idcolaboradorequipamento");
        $arrTempor["nmcolaborador"] = utf8_encode($objTbColaborador->Get("nmcolaborador"));
        $arrTempor["dsemail"] = utf8_encode($objTbColaborador->Get("dsemail"));
        $arrTempor["dssetor"] = utf8_encode($objTbColaborador->Get("dssetor"));
        $arrTempor["dscargo"] = utf8_encode($objTbColaborador->Get("dscargo"));

        array_push($arrLinhas, $arrTempor);
      }

      echo '{"jsnColaborador": '.json_encode($arrLinhas).', "jsnTotal": '.  $_intTotalColaborador . '}';

    } else if(!is_array($aroTbColaborador) && trim($aroTbColaborador)!= ""){// Sinal de erro na busca
      echo '{"error": ' .$aroTbColaborador. '}';
    } else {// Nenhum registro encontrado
      echo '{"jsnColaborador": null}';
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  //  Ação de gravação de registro
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"]== "gravar"){
    $objTbColaborador->Set("idcolaboradorequipamento",utf8_decode($_POST["idColaborador"]));
    $objTbColaborador->Set("nmcolaborador",utf8_decode($_POST["nmColaborador"]));
    $objTbColaborador->Set("dsemail",utf8_decode($_POST["dsEmail"]));
    $objTbColaborador->Set("dssetor",utf8_decode($_POST["dsSetor"]));
    $objTbColaborador->Set("dscargo",utf8_decode($_POST["dsCargo"]));

    $strMessage = "";

    if(empty($objTbColaborador->Get("nmcolaborador"))){
      $strMessage .= "&raquo; O campo <strong>Nome</strong> é obrigatório<br>";
    }

    if(empty($objTbColaborador->Get("dsemail"))){
      $strMessage .= "&raquo; O campo <strong>E-mail</strong> é obrigatório<br>";
    }

    if(empty($objTbColaborador->Get("dssetor"))){
      $strMessage .= "&raquo; O campo <strong>Num Setor</strong> é obrigatório<br>";
    }
    if(empty($objTbColaborador->Get("dscargo"))){
      $strMessage .= "&raquo; O campo <strong>Cargo</strong> é obrigatório<br>";
    }


    if($strMessage != ""){
      $objMsg->Alert("dlg", $strMessage);
    } else {
      if($objTbColaborador->Get("idcolaboradorequipamento")!=""){
        $arrResult = $objTbColaborador->Update($objTbColaborador);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro atualizado com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbColaborador = new TbColaborador();
        }
      } else {
        $arrResult = $objTbColaborador->Insert($objTbColaborador);
        if($arrResult["dsMsg"]=="ok"){
          $objMsg->Succes("ntf","Registro inserido com sucesso!");
        }else{
          $objMsg->LoadMessage($arrResult);
          $objTbColaborador = new TbColaborador();
        }
      }
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//

  //-------------------------------------------------------------------------------------------------------------------//
  // Ação para a exclusão de registros
  //-------------------------------------------------------------------------------------------------------------------//
  if(isset($_GET["action"]) && $_GET["action"] == "excluir"){
    $objTbColaborador = TbColaborador::LoadByIdColaborador($_POST["idColaborador"]);

    $arrResult = $objTbColaborador->Delete($objTbColaborador);
  
    if($arrResult["dsMsg"]=="ok"){
      $objMsg->Succes("ntf","Registro excluido com sucesso!");
    }else{
      $objMsg->LoadMessage($arrResult);
      $objTbColaborador = new TbColaborador();
    }
  }
  //-------------------------------------------------------------------------------------------------------------------//