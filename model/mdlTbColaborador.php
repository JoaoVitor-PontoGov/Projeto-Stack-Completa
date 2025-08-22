<?php

class TbColaborador{
  private $idcolaboradorequipamento;
  private $nmcolaborador;
  private $dsemail;
  private $dssetor;
  private $dscargo;

  public function __construct(){
    $this->idcolaboradorequipamento = "";
    $this->nmcolaborador = "";
    $this->dsemail = "";
    $this->dssetor = "";
    $this->dscargo = "";
  }

  public function Set($prpTbColaborador, $valTbColaborador){
    $this->$prpTbColaborador = $valTbColaborador;
  }

  public function Get($prpTbColaborador){
    return $this->$prpTbColaborador;
  }

  public function LoadObject($resSet){
    $objTbColaborador = new TbColaborador();

    $objTbColaborador->Set("idcolaboradorequipamento", $resSet["idcolaboradorequipamento"]);
    $objTbColaborador->Set("nmcolaborador", $resSet["nmcolaborador"]);
    $objTbColaborador->Set("dsemail", $resSet["dsemail"]);
    $objTbColaborador->Set("dssetor", $resSet["dssetor"]);
    $objTbColaborador->Set("dscargo", $resSet["dscargo"]);

    if(!isset($GLOBALS["_intTotalColaborador"])){
      $GLOBALS["_intTotalColaborador"] = $resSet["_inttotal"];
    }

    return $objTbColaborador;
  }

  public function Insert($objTbColaborador){
    $dtbServer = new DtbServer();

    $dsSql = "INSERT INTO
                shtreinamento.tbcolaboradorequipamento(
                  idcolaboradorequipamento,
                  nmcolaborador,
                  dsemail,
                  dssetor,
                  dscargo
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidcolaboradorequipamento')),
                  '". $objTbColaborador->Get("nmcolaborador") ."',
                  '". $objTbColaborador->Get("dsemail") ."',
                  '". $objTbColaborador->Get("dssetor") ."',
                  '". $objTbColaborador->Get("dscargo") ."'
                );
              ";

    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    } else {
      $arrMsg = ["dsMsg"=> "ok"];
    }

    return $arrMsg;
  }

  public function Update($objTbColaborador){
    $dtbServer = new DtbServer();

    $dsSql = "UPDATE 
                shtreinamento.tbcolaboradorequipamento
              SET 
                idcolaboradorequipamento = '". $objTbColaborador->Get("idcolaboradorequipamento") ."',
                nmcolaborador = '". $objTbColaborador->Get("nmcolaborador") ."',
                dsemail = '". $objTbColaborador->Get("dsemail") ."',
                dssetor = '". $objTbColaborador->Get("dssetor") ."',
                dscargo = '". $objTbColaborador->Get("dscargo") ."'
              WHERE 
                idcolaboradorequipamento = ". $objTbColaborador->Get("idcolaboradorequipamento") . ";
              ";

    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    } else {
      $arrMsg = ["dsMsg"=> "ok"];
    }
    return $arrMsg;
  }

  public function Delete($objTbColaborador){
    $dtbServer = new DtbServer();

    $dsSql = "DELETE FROM 
                shtreinamento.tbcolaboradorequipamento
              WHERE 
                idcolaboradorequipamento = ". $objTbColaborador->Get("idcolaboradorequipamento")
            ;
    
    if(!$dtbServer->Exec($dsSql)){
      $arrMsg = $dtbServer->getMessage();
    } else {
      $arrMsg = ["dsMsg"=> "ok"];
    }
    return $arrMsg;
  }

  public static function LoadByIdColaborador($idcolaboradorequipamento){
    $dtbServer = new DtbServer();
    $objTbColaborador = new TbColaborador();

    $dsSql = "SELECT * FROM
                shtreinamento.tbcolaboradorequipamento
              WHERE idcolaboradorequipamento = " . $idcolaboradorequipamento . " ";

    if(!$dtbServer->Query($dsSql)){
      return $dtbServer->getMessage()["dsMsg"];
    }else{
      $resSet = $dtbServer->FetchArray();
      $objTbColaborador = $objTbColaborador->LoadObject($resSet);
      return $objTbColaborador;
    }
  }

  public static function ListByCondicao($strCondicao, $strOrdenacao){
    $dtbServer = new DtbServer();
    $objTbColaborador = new TbColaborador();

    $dsSql = "SELECT 
                *,
                COUNT(*) OVER() _inttotal
              FROM
                shtreinamento.tbcolaboradorequipamento
              WHERE 
                1 = 1
              ";

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
        $aroTbColaborador[] = $objTbColaborador->LoadObject($resSet);
      }
      return $aroTbColaborador;
    }
  }
}