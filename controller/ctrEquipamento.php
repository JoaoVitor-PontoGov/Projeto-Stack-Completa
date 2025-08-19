<?php
  require_once "../lib/libDatabase.php";
  require_once "../model/mdlTbEquipamento.php";

  $objTbEquipamento = new TbEquipamento();

    $objTbEquipamento->Set("nmequipamento", "geladeira");
    $objTbEquipamento->Set("dstipo", "cosinha");
    $objTbEquipamento->Set("nrserie", 777);
    $objTbEquipamento->Set("dtaquisicao", "2025-07-20");
    $objTbEquipamento->Set("flstatus", "DP");

 $arrResult = $objTbEquipamento->Insert($objTbEquipamento);

 var_dump($arrResult);