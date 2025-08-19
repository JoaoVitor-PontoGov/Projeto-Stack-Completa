<?php

class TbEquipamento{
  private $idequipamento;
  private $nmequipamento;
  private $dstipo;
  private $nrserie;
  private $dtaquisicao;
  private $flstatus;

  public function __construct(){
    $this->idequipamento = "";
    $this->nmequipamento = "";
    $this->dstipo = "";
    $this->nrserie = "";
    $this->dtaquisicao = "";
    $this->flstatus = "";
  }

  public function Set($prpTbEquipamento, $valTbEquipamento){
    $this->$prpTbEquipamento = $valTbEquipamento;
  }

  public function Get($prpTbEquipamento){
    return $this->$prpTbEquipamento;
  }

  public function LoadObject($resSet){
    $objTbEquipamento = new TbEquipamento();

    $objTbEquipamento->Set("idequipamento", $resSet["idequipamento"]);
    $objTbEquipamento->Set("nmequipamento", $resSet["nmequipamento"]);
    $objTbEquipamento->Set("dstipo", $resSet["dstipo"]);
    $objTbEquipamento->Set("nrserie", $resSet["nrserie"]);
    $objTbEquipamento->Set("dtaquisicao", $resSet["dtaquisicao"]);
    $objTbEquipamento->Set("flstatus", $resSet["flstatus"]);

    return $objTbEquipamento;
  }

  public function Insert($objTbEquipamento){
    $dsSql = "INSERT INTO 
                shtreinamento.tbequipamento(
                  idequipamento,
                  nmequipamento,
                  dstipo,
                  nrserie,
                  dtaquisicao,
                  flstatus
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidequipamento')),
                  '".$objTbEquipamento->Get("nmequipamento") ."',
                  '".$objTbEquipamento->Get("dstipo") ."',
                  ".$objTbEquipamento->Get("nrserie") .",
                  '".$objTbEquipamento->Get("dtaquisicao") ."',
                  '".$objTbEquipamento->Get("flstatus") ."'
                );";

    $dtbServer = new DtbServer();

    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }

  public function Update($objTbEquipamento){
    $dsSql = "UPDATE 
        shtreinamento.tbequipamento
        SET 
          idequipamento = ".$objTbEquipamento->Get("idequipamento") .",
          nmequipamento = '".$objTbEquipamento->Get("nmequipamento") ."',
          dstipo = '".$objTbEquipamento->Get("dstipo") ."',
          nrserie = ".$objTbEquipamento->Get("nrserie") .",
          dtaquisicao = '".$objTbEquipamento->Get("dtaquisicao") ."',
          flstatus = '".$objTbEquipamento->Get("flstatus") ."'
        WHERE idequipamento = ".$objTbEquipamento->Get("idequipamento") .";";

    $dtbServer = new DtbServer();

    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }

  public function Delete($objTbEquipamento){
    $dsSql = "DELETE FROM
                shtreinamento.tbequipamento
              WHERE id = " . $objTbEquipamento->Get("idequipamento") .";";

    $dtbServer = new DtbServer();

    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }
  
}

