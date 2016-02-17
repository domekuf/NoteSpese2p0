<?
$usr_to_remove=$_POST['usr_to_remove'];

$qrypath= module_path().'qry/gruppi/';
$qry_remove=carica_file($qrypath.'removeGruppo.sql');
$qry_remove=str_replace('[usr_to_remove]',$usr_to_remove,$qry_remove);
$db->put_data($qry_remove);

$pr->add_html('container','');
$pr->add_script('pi.requestQLoaderOpen(\'wallet\',\'Gruppi\')')->response();

//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
