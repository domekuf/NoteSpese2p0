<?//
$id_gruppo = $_POST['id_gruppo'];
$id_natura = $_POST['id_natura'];


$htmlpath= module_path().'html/gruppiEdit/';
$qrypath= 	module_path().'qry/gruppiEdit/';
$jspath=     module_path().'js/gruppiEdit/';
$qry_delete_soglie_gruppi=carica_file($qrypath.'deleteSoglieGruppi.sql');
$qry_delete_soglie_gruppi=str_replace('[id_gruppo]',$id_gruppo,$qry_delete_soglie_gruppi);
$qry_delete_soglie_gruppi=str_replace('[id_natura]',$id_natura,$qry_delete_soglie_gruppi);

//$pr->add_html('container',$qry_delete_soglie_gruppi)->response();
$res=$db->put_data($qry_delete_soglie_gruppi);
$pr->add_script('pi.requestQLoaderOpen(\'container\',\'WinGruppoEdit\')')->response();


//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>