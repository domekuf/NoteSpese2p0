<?
$descrizione=$_POST['nuovo_gruppo_desc'];

$qrypath= module_path().'qry/eventiAdd/';

$qry_insert=carica_file($qrypath.'eventiInsert.sql');
$qry_insert=str_replace('[descrizione]',$descrizione,$qry_insert);

$db->put_data($qry_insert);

$pr->add_script('pi.requestQLoaderOpen(\'container\',\'Eventi\')')->response();

?>