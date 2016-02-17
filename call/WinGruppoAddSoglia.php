<?//
$id_gruppo = $_POST['id_gruppo'];
$id_natura = $_POST['id_natura'];
$soglia = $_POST['value'];


$htmlpath= module_path().'html/gruppiEdit/';
$qrypath= 	module_path().'qry/gruppiEdit/';
$jspath=     module_path().'js/gruppiEdit/';
$qry_add_soglie_gruppi=carica_file($qrypath.'addSoglieGruppi.sql');
$qry_add_soglie_gruppi=str_replace('[id_gruppo]',$id_gruppo,$qry_add_soglie_gruppi);
$qry_add_soglie_gruppi=str_replace('[id_natura]',$id_natura,$qry_add_soglie_gruppi);
$qry_add_soglie_gruppi=str_replace('[soglia]',$soglia,$qry_add_soglie_gruppi);

//$pr->add_html('container',$qry_add_soglie_gruppi)->response();

$res=$db->put_data($qry_add_soglie_gruppi);

$pr->add_script('pi.requestQLoaderOpen(\'container\',\'WinGruppoEdit\')')->response();


//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>