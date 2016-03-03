<?//
$id_trasf = $_POST['id_trasf'];
$htmlpath= 	module_path().'html/trasfItin/';
$qrypath= 	module_path().'qry/trasfItin/';
$commonqry= 	module_path().'_common/qry/';
$jspath= 	module_path().'js/trasfItin/';
$interface=carica_file($htmlpath.'trasfItin.html');
$tappa_tmp=carica_file($htmlpath.'tappa.html');
$qry_itin=carica_file($qrypath.'trasfItin.sql');
$qry_negozi=carica_file($commonqry.'negozi.sql');
$qry_itin=str_replace('[id_trasf]',$id_trasf,$qry_itin);
$interface=str_replace('[id_trasf]',$id_trasf,$interface);
$interface=str_replace('[id_container]','wincontainer',$interface);
$interface=str_replace('[save]','pi.requestWinOpen(\'wincontainer\')',$interface);
$interface=str_replace('[save_call]','trasfItinTappaSave',$interface);
$res_itin=$db->get_data($qry_itin);
$lista_tappe='';


foreach($res_itin as $tappa){
	
	$select_negozi_p=qry2sel_filtrabile($qry_negozi,'voce_menu','value',$tappa['luogo'],'select-negozi-'.$tappa['id_tappa'].'p','voce_menu');
	$select_negozi_a=qry2sel_filtrabile($qry_negozi,'voce_menu','value',$tappa['luogo'],'select-negozi-'.$tappa['id_tappa'].'a','voce_menu');
	$lista_tappe.=
	str_replace('[id_tappa]',$tappa['id_tappa'],
	str_replace('[id_trasf]',$tappa['id_trasf'],
	str_replace('[luogo]',$tappa['luogo'],
	str_replace('[luogo_a]',$tappa['luogo_a'],
	str_replace('[data]',$tappa['data'],
	str_replace('[luogo_select_p]',$select_negozi_p,
	str_replace('[luogo_select_a]',$select_negozi_a,
	$tappa_tmp)))))));

}

$interface=str_replace('[lista_tappe]',$lista_tappe,$interface);

$pr->add_script('pi.win.close()');
$pr->add_win(1000,0,true,'Gestisci Itinerario',$interface)->response();





/*

Questo serve per numerare le tappe
$qry_to_upd='
select luogo, to_char(data,\'yyyymmdd\') data from psofa.pso_rs_trasf_itin
where 1=1
order by data
';

$res_to_upd=$db->get_data($qry_to_upd);

foreach($res_to_upd as $row){
	$qry_upd="update psofa.pso_rs_trasf_itin set id_tappa = psofa.pso_seq_rs_trasf_itin.nextval where luogo='".$row['luogo']."' and data=to_date('".$row['data']."','yyyymmdd')";
	$db->put_data($qry_upd);
}


*/
?>