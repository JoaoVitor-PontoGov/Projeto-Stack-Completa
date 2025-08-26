<?php

class TbEquipamento{
  private $idequipamento;
  private $nmequipamento;
  private $dstipo;
  private $nrserie;
  private $dtaquisicao;
  private $flstatus;
  private $dtbLink;

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

  public function SetDtbLink($dtbLink){
    $this->dtbLink = $dtbLink;
  }

  public function LoadObject($resSet){
    $objTbEquipamento = new TbEquipamento();

    $objTbEquipamento->Set("idequipamento", $resSet["idequipamento"]);
    $objTbEquipamento->Set("nmequipamento", $resSet["nmequipamento"]);
    $objTbEquipamento->Set("dstipo", $resSet["dstipo"]);
    $objTbEquipamento->Set("nrserie", $resSet["nrserie"]);
    $objTbEquipamento->Set("dtaquisicao", $resSet["dtaquisicao"]);
    $objTbEquipamento->Set("flstatus", $resSet["flstatus"]);
    
    if(!isset($GLOBALS["_intTotalEquipamento"])){
      $GLOBALS["_intTotalEquipamento"] = $resSet["_inttotal"];
    }
    return $objTbEquipamento;
  }

  public function Insert($objTbEquipamento){
    if($this->dtbLink == null){
      $this->dtbLink = new DtbServer();
    }
    $fmt = new Format();

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
                  '".$fmt->escSqlQuotes($objTbEquipamento->Get("nmequipamento")) ."',
                  '".$fmt->escSqlQuotes($objTbEquipamento->Get("dstipo")) ."',
                  ".$objTbEquipamento->Get("nrserie") .",
                  '".$objTbEquipamento->Get("dtaquisicao") ."',
                  '".$objTbEquipamento->Get("flstatus") ."'
                );";

    if(!$this->dtbLink->Exec($dsSql)){
      $arrMsg = $this->dtbLink->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }

  public function Update($objTbEquipamento){
    if($this->dtbLink == null){
      $this->dtbLink = new DtbServer();
    }

    $fmt = new Format();

    $dsSql = "UPDATE 
                shtreinamento.tbequipamento
              SET 
                idequipamento = ".$objTbEquipamento->Get("idequipamento") .", 
                nmequipamento = '".$fmt->escSqlQuotes($objTbEquipamento->Get("nmequipamento")) ."', 
                dstipo = '".$fmt->escSqlQuotes($objTbEquipamento->Get("dstipo")) ."', 
                nrserie = ".$objTbEquipamento->Get("nrserie") .", 
                dtaquisicao = ". $fmt->DataBd($objTbEquipamento->Get("dtaquisicao")) .", 
                flstatus = '".$objTbEquipamento->Get("flstatus") ."'
              WHERE
                idequipamento = ".$objTbEquipamento->Get("idequipamento") .";";

    if(!$this->dtbLink->Exec($dsSql)){
      $arrMsg = $this->dtbLink->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }

  public function Delete($objTbEquipamento){
    if($this->dtbLink == null){
      $this->dtbLink = new DtbServer();
    }
  
    $dsSql = "DELETE FROM
                shtreinamento.tbequipamento
              WHERE
                idequipamento = " . $objTbEquipamento->Get("idequipamento") .";";

    if(!$this->dtbLink->Exec($dsSql)){
      $arrMsg = $this->dtbLink->getMessage();
    }else{
      $arrMsg = ["dsMsg"=>"ok"];
    }
    return $arrMsg;
  }

  public static function LoadByIdEquipamento($idEquipamento){
    $dtbServer = new DtbServer();
    $objTbEquipamento = new TbEquipamento();

    $dsSql = "SELECT * FROM
                shtreinamento.tbequipamento
              WHERE idequipamento = " . $idEquipamento . " ";

    if(!$dtbServer->Query($dsSql)){
      return $dtbServer->getMessage()["dsMsg"];
    }else{
      $resSet = $dtbServer->FetchArray();
      $objTbEquipamento = $objTbEquipamento->LoadObject($resSet);
      return $objTbEquipamento;
    }
  }

  public static function ListByCondicao($strCondicao, $strOrdenacao){
    $dtbServer = new DtbServer();
    $objTbEquipamento = new TbEquipamento();

    $dsSql = "SELECT
                *,
              COUNT(*) OVER() _inttotal
              FROM
                shtreinamento.tbequipamento
              WHERE
                1 = 1 ";
    
    if($strCondicao){
      $dsSql .= $strCondicao;
    }

    if($strOrdenacao){
      $dsSql .= " ORDER BY ". $strOrdenacao;
    }

    if(!$dtbServer->Query($dsSql)){
      return $dtbServer->getMessage()["dsMsg"];
    }else{
      while($resSet = $dtbServer->FetchArray()){
        $aroTbEquipamento[] = $objTbEquipamento->LoadObject($resSet);
      }
      return $aroTbEquipamento;
    }
  }
}

