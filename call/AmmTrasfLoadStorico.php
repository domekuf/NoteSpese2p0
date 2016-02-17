<?
$login_utente=$_POST['amm_utente'];
$login_utente_amm=$_POST['login_utente'];
$data_da=$_POST['data_da'];
$data_a=$_POST['data_a'];
$rs_usr=$_POST['rs_usr'];
$htmlpath= module_path().'html/trasf/';
$jspath= module_path().'js/trasf/';
$qrypath= module_path().'qry/trasf/';
$batpath= '/extension/FWlauncher/';

$p=$htmlpath.'trasfStorico.html';
$f=fopen($p,'r');
$s=fread($f,filesize($p));
$s=str_replace('[button_cancella]',str_replace('[contabilizza_cancella_call]','pi.requestQ(\'trasf_id[id_trasf]\',\'ContabilizzaCancella\')',carica_file($htmlpath.'buttonContabilizzaCancella.html')),$s);
$s=str_replace('[login_utente_amm]',$login_utente_amm,$s);
$s=str_replace('[label_amm]','Apri Freeway:',$s);

$button_freeway=carica_file($htmlpath.'buttonContabilizzaFreeway.html');
$button_freeway=str_replace('[path]',$batpath,$button_freeway);

$p=$htmlpath.'intestazione.html';
$f=fopen($p,'r');
$intestazione=fread($f,filesize($p));

$p=$qrypath.'TrasfLoadStorico.sql';
$f=fopen($p,'r');
$qry=fread($f,filesize($p));
$qry=str_replace('[login_utente]',$login_utente,$qry);

$p=$qrypath.'colonne.sql';
$f=fopen($p,'r');
$qry2=fread($f,filesize($p));

//apertura tabella e utente
$lista_trasferte = str_replace('[login_utente]',$login_utente,$intestazione);
$results=$db->get_data($qry);
foreach($results as $v){
	
	//compilazione campi
	$res2=$db->get_data($qry2);
	$s_tmp=$s;
	
	
	
	
	foreach($res2 as $v2){
		$nomecampo=trim(strtolower($v2['column_name']));
		$s_tmp=str_replace('['.$nomecampo.']',trim($v[$nomecampo]),$s_tmp);
	}
	
	//questa sezione crea su ogni riga trasferta i pulsanti per aprire il file in freeway
	$qry_rr=carica_file($qrypath.'contabilizzaCreaFileFreeway.sql');
	$qry_rr=str_replace('[id_trasf]',$v['id_trasf'],$qry_rr);
	$res3=$db->get_data($qry_rr);
	$buttons='';
	foreach($res3 as $v3){
		$buttons.=str_replace('[rr_placeholder]',$v3['nro_reg'],$button_freeway);
	}
	$s_tmp=str_replace('[button_freeway_placeholder]',$buttons,$s_tmp);
	//finisce qui
	
	
	//gestione itinerario
	$p=$qrypath.'TrasfItin.sql';
	$f=fopen($p,'r');
	$qry3=fread($f,filesize($p));
	$qry3=str_replace('[id_trasf]',$v['id_trasf'],$qry3);
	$res3=$db->get_data($qry3);
	
	$p=$htmlpath.'lista_tappe.html';
	$f=fopen($p,'r');
	$li=fread($f,filesize($p));
	$lista='';
	foreach($res3 as $v3){
		$li_tmp=$li;
		$li_tmp=str_replace('[luogo]',$v3['luogo'],$li_tmp);
		$li_tmp=str_replace('[data]',$v3['data'],$li_tmp);
		$lista.=$li_tmp;
	}
	$s_tmp=str_replace('[lista_tappe]',$lista,$s_tmp);
	
	//buttons
	$s_tmp=str_replace('[del]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'TrasfDel\',\'Eliminare Questa Trasferta?\')',$s_tmp);
	$s_tmp=str_replace('[open]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'DettLoadStorico\')',$s_tmp);
	$s_tmp=str_replace('[edit_itin]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'TrasfItinLoad\')"',$s_tmp);
	$s_tmp=str_replace('[submit]','alert(\'submit\')',$s_tmp);
	
	//ulteriori parametri
	$s_tmp=str_replace('[rs_usr]',$rs_usr,$s_tmp);
	
	$lista_trasferte.=$s_tmp;
}
$lista_trasferte.=carica_file($jspath.'run_fw.js');
$pr->add_html('menu_1','');
$pr->add_html('menu_2','');
$pr->add_html('menu_3','');
$pr->add_html('container',$lista_trasferte)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
