<?
$login_utente=$_POST['login_utente'];
$data_da=$_POST['data_da'];
$data_a=$_POST['data_a'];
$rs_usr=$_POST['rs_usr'];
$htmlpath= module_path().'html/gruppi/';
$qrypath= module_path().'qry/gruppi/';

$interface=carica_file($htmlpath.'gruppi.html');
$gruppo_tmp=carica_file($htmlpath.'gruppo.html');
$utente_tmp=carica_file($htmlpath.'utente.html');
$utenti_gruppo_tmp=carica_file($htmlpath.'utenti_gruppo.html');

$gruppi='';
$utenti='';
$qry_gruppi=carica_file($qrypath.'gruppi.sql');
$qry_utenti=carica_file($qrypath.'utenti.sql');
$qry_utenti_gruppo_tmp=carica_file($qrypath.'utenti_gruppo.sql');

$res=$db->get_data($qry_gruppi);
foreach($res as $v){
	
	$qry_utenti_gruppo=str_replace('[id_gruppo]',$v['id_gruppo'],$qry_utenti_gruppo_tmp);
	$re2=$db->get_data($qry_utenti_gruppo);
	$utenti_gruppo='';
	foreach($re2 as $v2){
		$utenti_gruppo.=str_replace('[login_utente]',trim($v2['login_utente']),str_replace('[desc_login]',ucwords(trim(strtolower($v2['desc_login']))),$utenti_gruppo_tmp));
	}
	$gruppi.=
	str_replace('[id_gruppo]',$v['id_gruppo']
	,str_replace('[descrizione]',$v['descrizione']
	,str_replace('[utenti_gruppo]',$utenti_gruppo
	,$gruppo_tmp)));
}
$res=$db->get_data($qry_utenti);
foreach($res as $v){
	$utenti.=str_replace('[login_utente]',trim($v['login_utente']),str_replace('[desc_login]',ucwords(trim(strtolower($v['desc_login']))),$utente_tmp));
}

$utenti_gruppo='';

$interface=str_replace('[utenti]',$utenti,$interface);
$interface=str_replace('[gruppi]',$gruppi,$interface);

//$ret=$_SERVER['DOCUMENT_ROOT'].'/test.js';
//$ret=exec('C:/test.js');
//$ret=system("C:/test.js");
$pr->add_html('container',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
