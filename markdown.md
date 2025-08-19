//Conectando no banco
$conn = pg_connect("host=192.168.2.11 port=5432 dbname=dbsisgov user=ussisgov password=pgdesenv");

// Sql de Inser
$dsSql = "SELECT * FROM
            shtreinamento.tbequipamento";

// Executando SQL
$result = @pg_query($conn, $dsSql);

// Tratamento mensagem de erro
if (!$result) {
  $msg = pg_last_error($conn);

  echo $msg;
}else{
  while ($resSet = pg_fetch_array($result)) {
    var_dump($resSet);
  }
}