<?
$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$desc_trasf = $_POST['desc_trasf'];
$rs_usr=$_POST['rs_usr'];
$htmlpath= module_path().'html/dett/';
$qrypath= module_path().'qry/dett/';
$jspath= module_path().'js/dett/';
$allpath='https://portal1.poltronesofa.com/extension/RimborsiSpese/Ced/';

$p=$qrypath.'DettLoad.sql';
$f=fopen($p,'r');
$qry=fread($f,filesize($p));
$qry=str_replace('[id_trasf]',$id_trasf,$qry);

$p=$qrypath.'colonne.sql';
$f=fopen($p,'r');
$qry2=fread($f,filesize($p));

$s_tmp_0=carica_file($htmlpath.$rs_usr.'dett_tmp.html');
$s_tmp_0=str_replace('[desc_trasf]',$desc_trasf,$s_tmp_0);



$s  =str_replace('[luogo_placeholder]','<h3>[luogo]</h3>'
	,str_replace('[class_color]','almond'
	,$s_tmp_0));

$p=$jspath.$rs_usr.'dett.js';
$f=fopen($p,'r');
$js=fread($f,filesize($p));

$s.=$js;

//gestione dettagli differenziati per nature
$rimborsoKm=str_replace
			('[luogo_placeholder]'
			,carica_file($htmlpath.$rs_usr.'dettRimKm.html')
			,str_replace
			('[class_color]'
			,'almond'
			,$s_tmp_0));
$rimborsoKm.=$js;

$hotel=str_replace
			('[luogo_placeholder]'
			,'<h3>[luogo]</h3>'
			,str_replace
			('[class_color]'
			,'grey'
			,$s_tmp_0));
$hotel.=$js;

$hotel_figlio=$hotel;

$p=$htmlpath.$rs_usr.'intestazione.html';
$f=fopen($p,'r');
$intestazione=fread($f,filesize($p));
$intestazione=str_replace('[desc_trasf]',$desc_trasf,$intestazione);

$p=$htmlpath.$rs_usr.'new.html';
$f=fopen($p,'r');
$new=fread($f,filesize($p));


//recupero i totali dal db e non più dal wallet
$qry_totali=carica_file($qrypath.'totali.sql');
$qry_totali=str_replace('[id_trasf]',$id_trasf,$qry_totali);
$res_totali=$db->get_data($qry_totali);
$totale='0.00';
$totale_ob='0.00';
foreach($res_totali as $r_t){
	$totale=$r_t['totale'];
	$totale_ob=$r_t['totale_ob'];
}
$new=str_replace('[totale]',$totale,$new);
$new=str_replace('[totale_ob]',$totale_ob,$new);
$new=str_replace('[add]','pi.requestQ(\'new_dett\',\'DettAdd\')',$new);
$new=str_replace('[login_utente]',$login_utente,$new);
$new=str_replace('[id_trasf]',$id_trasf,$new);
$new=str_replace('[desc_trasf]',$desc_trasf,$new);
$new=str_replace('[id_dett]',$id_dett,$new);
$new=str_replace('[rs_usr]',$rs_usr,$new);


$results=$db->get_data($qry);

foreach($results as $v){
	$res2=$db->get_data($qry2);
	
	//compilazione campi
	$s_tmp=$s;

	if($v['id_natura']==4 || $v['id_natura']==5){
		$s_tmp=$rimborsoKm;
		$p=$qrypath.'DettItin.sql';
		$f=fopen($p,'r');
		$qry3=fread($f,filesize($p));
		$qry3=str_replace('[id_dett]',$v['id_dett'],$qry3);
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
	}
	if($v['id_natura']==3){
		$s_tmp=$hotel;
	}
	if( $v['id_hotel']>0){
		$s_tmp=$hotel_figlio;
	}
	
	$s_tmp=str_replace('[lista_tappe]',$lista,$s_tmp);
	$s_tmp=str_replace('[path]',$htmlpath,$s_tmp);
	$s_tmp=str_replace('[dett_edit]','pi.requestQ(\'id_dett[id_dett]\',\'DettEdit\')',$s_tmp);
	$s_tmp=str_replace('[rs_usr]',$rs_usr,$s_tmp);
	$s_tmp=str_replace('[login_utente]',$login_utente,$s_tmp);
	$s_tmp=str_replace('[allpath]',$allpath,$s_tmp);	
	$outer_select_iva=carica_file($htmlpath.$rs_usr.'outer_select_iva.html');
	
	if($v['tipo_giustificativo']==0){
		$s_tmp=str_replace('[outer_select_iva]','',$s_tmp);
	}else{
		$s_tmp=str_replace('[outer_select_iva]',$outer_select_iva,$s_tmp);
	}
	

	
	
	
	foreach($res2 as $v2){
		$nomecampo=trim(strtolower($v2['column_name']));
		$s_tmp=str_replace('['.$nomecampo.']',$v[$nomecampo],$s_tmp);
		
		if($nomecampo=='giustificativo'){
			if(strlen($v[$nomecampo])>5){
				$s_tmp=str_replace('[giustificativo_display]','block',$s_tmp);
			}else{
				$s_tmp=str_replace('[giustificativo_display]','none',$s_tmp);
			}
		}
		if($nomecampo=='pre_approvazione'){
			if(strlen($v[$nomecampo])>5){
				$s_tmp=str_replace('[pre_approvazione_display]','block',$s_tmp);
			}else{
				$s_tmp=str_replace('[pre_approvazione_display]','none',$s_tmp);
			}
		}
		if($nomecampo=='approvazione_sforo'){
			if(strlen($v[$nomecampo])>5){
				$s_tmp=str_replace('[approvazione_sforo_display]','block',$s_tmp);
			}else{
				$s_tmp=str_replace('[approvazione_sforo_display]','none',$s_tmp);
			}
		}
	}
	
	$s_tmp=str_replace('[select_iva]',qry2sel(carica_file($qrypath.'iva.sql'),'cod_iva','cod_iva',$v['cod_iva']),$s_tmp);
	$importo_approvato_proposto='0.00';
	if($v['importo_approvato']>0){
		$s_tmp=str_replace('[class_approved_color]','approved-green',$s_tmp);
		$s_tmp=str_replace('[importo_approvato_proposto]',$v['importo_approvato'],$s_tmp);
	}else{
		$s_tmp=str_replace('[class_approved_color]','',$s_tmp);
		if($v['importo_richiesto']>$v['limite_spesa']){
			$s_tmp=str_replace('[importo_approvato_proposto]',$v['limite_spesa'],$s_tmp);
		}else{
			$s_tmp=str_replace('[importo_approvato_proposto]',$v['importo_richiesto'],$s_tmp);
		}
	}
	
	
	
	$lista_tappe.=$s_tmp;
}

$p=$jspath.'update_wallet.js';
$f=fopen($p,'r');
$js0=fread($f,filesize($p));
$js0=str_replace('[id_trasf]',$id_trasf,$js0);
$js0=str_replace('[totale]',$totale,$js0);
$js0=str_replace('[totale_ob]',$totale_ob,$js0);

$lista_dettagli=$intestazione.$lista_tappe.$new.$js0;

//gestione totali per nature
$subtotali_begin=carica_file($htmlpath.'subtotali_begin.html');
$subtotali_end=carica_file($htmlpath.'subtotali_end.html');
$subtotali_li=carica_file($htmlpath.'subtotali_li.html');
$qry_subtotali=carica_file($qrypath.'subtotali.sql');
$qry_subtotali=str_replace('[id_trasf]',$id_trasf,$qry_subtotali);
$res_subtotali=$db->get_data($qry_subtotali);
$subtotali=$subtotali_begin;
foreach($res_subtotali as $v){
	$subtotali.=$subtotali_li;
	$subtotali=str_replace('[voce_menu]',$v['voce_menu'],$subtotali);
	$subtotali=str_replace('[subtotale]',$v['subtotale'],$subtotali);
}
$subtotali.=$subtotali_end;


$pr->add_html('menu_1',$subtotali);
$pr->add_html('container',$lista_dettagli)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
