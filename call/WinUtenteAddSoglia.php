<?//
$login_utente = $_POST['login_utente'];
$desc_login = $_POST['desc_login'];
$id_natura = $_POST['id_natura'];
$soglia = $_POST['value'];


$htmlpath= module_path().'html/utenti/';
$qrypath= module_path().'qry/utenti/';
$jspath= module_path().'js/utenti/';
$qry_add_soglie_utenti=carica_file($qrypath.'addSoglieUtenti.sql');
$qry_add_soglie_utenti=str_replace('[login_utente]',$login_utente,$qry_add_soglie_utenti);
$qry_add_soglie_utenti=str_replace('[id_natura]',$id_natura,$qry_add_soglie_utenti);
$qry_add_soglie_utenti=str_replace('[soglia]',$soglia,$qry_add_soglie_utenti);

//$pr->add_html('container',$qry_add_soglie_utenti)->response();

$res=$db->put_data($qry_add_soglie_utenti);

$pr->add_script('pi.requestQLoaderOpen(\'container\',\'WinUtenteEdit\')')->response();


//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>