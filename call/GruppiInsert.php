<?
$login_utente=$_POST['login_utente'];
$id_gruppo=$_POST['id_gruppo'];

$qrypath= module_path().'qry/gruppi/';
$qry_insert=carica_file($qrypath.'insertGruppo.sql');
$qry_insert=str_replace('[login_utente]',$login_utente,$qry_insert);
$qry_insert=str_replace('[id_gruppo]',$id_gruppo,$qry_insert);
$db->put_data($qry_insert);

$pr->add_html('container','');
$pr->add_script('pi.requestQLoaderOpen(\'wallet\',\'Gruppi\')')->response();

//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
