<?php

  class TbAlocacao{
    private $idalocacao;
    private $idequipamento;
    private $idcolaboradorequipamento;
    private $dtinicio;
    private $dtdevolucao;
    private $dtbLink;
    
    public function __construct(){
      $this->idalocacao = "";
      $this->idequipamento = "";
      $this->idcolaboradorequipamento = "";
      $this->dtinicio = "";
      $this->dtdevolucao = "";
    }

    public function Set($prpTbAlocacao, $valTbAlocacao){
      $this->$prpTbAlocacao = $valTbAlocacao;
    }

    public function Get($prpTbAlocacao){
      return $this->$prpTbAlocacao;
    }

    public function SetDtbLink($dtbLink){
      $this->dtbLink = $dtbLink;
    }

    public function LoadObject($resSet){
      $objTbAlocacao = new TbAlocacao();

      $objTbAlocacao->Set("idalocacao", $resSet["idalocacao"]);
      $objTbAlocacao->Set("idequipamento", $resSet["idequipamento"]);
      $objTbAlocacao->Set("idcolaboradorequipamento", $resSet["idcolaboradorequipamento"]);
      $objTbAlocacao->Set("dtinicio", $resSet["dtinicio"]);
      $objTbAlocacao->Set("dtdevolucao", $resSet["dtdevolucao"]);

      if(!isset($GLOBALS["_intTotalAlocacao"])){
        $GLOBALS["_intTotalAlocacao"] = $resSet["_inttotal"];
      }

      return $objTbAlocacao;
    }

    public function GetObjTbEquipamento(){
      if($this->objTbEquipamento == null){
        $this->objTbEquipamento = new TbEquipamento();

        if($this->Get("idequipamento")!=""){
          $this->objTbEquipamento = TbEquipamento::LoadByIdEquipamento($this->Get("idequipamento"));
        }
      }

      return $this->objTbEquipamento;
    }

    public function GetObjTbColaborador(){
      if($this->objTbColaborador == null){
        $this->objTbColaborador = new TbColaborador();
        
        if($this->Get("idcolaboradorequipamento")!=""){
          $this->objTbColaborador = TbColaborador::LoadByIdColaborador($this->Get("idcolaboradorequipamento"));
        }
      }

      return $this->objTbColaborador;
    }

    public function Insert($objTbAlocacao){
      if($this->dtbLink == null){
        $this->dtbLink = new DtbServer();
      }

      $fmt = new Format();

      $dsSql = "INSERT INTO
                  shtreinamento.tbalocacao(
                    idalocacao,
                    idequipamento,
                    idcolaboradorequipamento,
                    dtinicio,
                    dtdevolucao
                  )
                  VALUES(
                    (SELECT NEXTVAL('shtreinamento.sqidalocacao')),
                    ". $objTbAlocacao->Get("idequipamento") .",
                    ". $objTbAlocacao->Get("idcolaboradorequipamento") .",
                    '". ($objTbAlocacao->Get("dtinicio")) ."',
                    ". $fmt->DataBd($objTbAlocacao->Get("dtdevolucao")) ."
                  );
                ";

      if(!$this->dtbLink->Exec($dsSql)){
        $arrMsg = $this->dtbLink->getMessage();
      } else {
        $arrMsg = ["dsMsg"=> "ok"];
      }

      return $arrMsg; 
    }

    public function Update($objTbAlocacao){
      if($this->dtbLink == null){
        $this->dtbLink = new DtbServer();
      }

      $fmt = new Format();

      $dsSql = "UPDATE 
                  shtreinamento.tbalocacao
                SET 
                  idalocacao = '". $objTbAlocacao->Get("idalocacao") ."',
                  idequipamento = '". $objTbAlocacao->Get("idequipamento") ."',
                  idcolaboradorequipamento = '". $objTbAlocacao->Get("idcolaboradorequipamento") ."',
                  dtinicio = '". ($objTbAlocacao->Get("dtinicio")) ."',
                  dtdevolucao = ". $fmt->DataBd($objTbAlocacao->Get("dtdevolucao")) ."
                WHERE 
                  idalocacao = ". $objTbAlocacao->Get("idalocacao") . ";
                ";

      if(!$this->dtbLink->Exec($dsSql)){
        $arrMsg = $this->dtbLink->getMessage();
      } else {
        $arrMsg = ["dsMsg"=> "ok"];
      }
      return $arrMsg;
    }

    public function Delete($objTbAlocacao){
      if($this->dtbLink == null){
        $this->dtbLink = new DtbServer();
      }

      $dsSql = "DELETE FROM 
                  shtreinamento.tbalocacao
                WHERE 
                  idalocacao = ". $objTbAlocacao->Get("idalocacao")
              ;
      
      if(!$this->dtbLink->Exec($dsSql)){
        $arrMsg = $this->dtbLink->getMessage();
      } else {
        $arrMsg = ["dsMsg"=> "ok"];
      }
      return $arrMsg;
    }

    public static function LoadByIdAlocacao($idalocacao){
      $dtbServer = new DtbServer();
      $objTbAlocacao = new TbAlocacao();

      $dsSql = "SELECT
                  *
                FROM
                  shtreinamento.tbalocacao
                WHERE idalocacao = " . $idalocacao . " ";

      if(!$dtbServer->Query($dsSql)){
        return $dtbServer->getMessage()["dsMsg"];
      }else{
        $resSet = $dtbServer->FetchArray();
        $objTbAlocacao = $objTbAlocacao->LoadObject($resSet);
        return $objTbAlocacao;
      }
    }

    public static function ListByCondicao($strCondicao, $strOrdenacao){
      $dtbServer = new DtbServer();
      $objTbAlocacao = new TbAlocacao();

      $dsSql = "SELECT 
                  *,
                  COUNT(*) OVER() _inttotal
                FROM
                  shtreinamento.tbalocacao
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
          $aroTbAlocacao[] = $objTbAlocacao->LoadObject($resSet);
        }
        return $aroTbAlocacao;
      }
    }

  }