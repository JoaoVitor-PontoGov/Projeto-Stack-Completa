<?php
  require_once "../lib/libDatabase.php";
  require_once "../model/mdlTbEquipamento.php";

  if(isset($_GET["action"]) && $_GET["action"]=="winConsulta"){
    require_once "../view/viwConsultaEquipamento.php";
  }

  if(isset($_GET["action"]) && $_GET["action"]=="incluir"){
    require_once "../view/viwCadastroEquipamento.php";
  }