<?//
$login_utente = $_POST['usr_to_edit'];
$desc_login = $_POST['usr_to_edit_desc'];


$htmlpath= module_path().'html/utenti/';
$qrypath= module_path().'qry/utenti/';
$qrypath_common= module_path().'_common/qry/';
$jspath= module_path().'js/utenti/';
$interface=carica_file($htmlpath.'utenti.html');
$voce_soglia_tmp=carica_file($htmlpath.'voceSoglia.html');
$qry_soglie_utenti=carica_file($qrypath.'soglieUtenti.sql');
$qry_soglie_utenti=str_replace('[login_utente]',$login_utente,$qry_soglie_utenti);

//$colonne=carica_file($qrypath.'colonne.sql');
//$res2=$db->get_data($colonne);
$res=$db->get_data($qry_soglie_utenti);


$interface=str_replace('[desc_login]',$desc_login,$interface);
$interface=str_replace('[id_container]','wincontainer',$interface);
$interface=str_replace('[save]','pi.requestWinOpen(\'wincontainer\')',$interface);
$interface=str_replace('[save_call]','WinUtenteEditDb',$interface);
$lista_soglie='';
foreach($res as $v){
	$lista_soglie.=str_replace(
						'[voce_menu]'
						,$v['voce_menu']
						,str_replace(
						'[soglia]'
						,$v['soglia']
						,str_replace(
						'[id_natura]'
						,$v['id_natura']
						,$voce_soglia_tmp)));
}

$qry_select=carica_file($qrypath_common.'nature.sql');
$interface=str_replace('[lista_soglie]',$lista_soglie,$interface);
$interface=str_replace('[login_utente]',$login_utente,$interface);
$interface=str_replace('[desc_login]',$desc_login,$interface);
$interface=str_replace('[del_soglia_call]','WinUtenteDelSoglia',$interface);
$interface=str_replace('[del_soglia]',"pi.requestWinOpen('wincontainer');",$interface);
$interface=str_replace('[add_soglia_call]','WinUtenteAddSoglia',$interface);
$interface=str_replace('[add_soglia]',"pi.requestWinOpen('wincontainer');",$interface);
$interface=str_replace('[select_nature]', qry2sel($qry_select,'voce_menu','id_natura',0),$interface);
$pr->add_win(1000,0,true,'Dettaglio Soglie Utente',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>