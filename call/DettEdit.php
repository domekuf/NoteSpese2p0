<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$id_natura = $_POST['id_natura'];
$data = $_POST['data'];
$rs_usr = $_POST['rs_usr'];
$desc_trasf = $_POST['desc_trasf'];
$lista_negozi_trasf=genera_lista_negozi_trasferta($id_trasf);

$htmlpath= module_path().'html/dettEdit/';
$qrypath= module_path().'qry/dettEdit/';
$jspath= module_path().'js/dettEdit/';
$allpath='https://portal1.poltronesofa.com/extension/RimborsiSpese/Ced/';

//$p=$htmlpath.$rs_usr.'dettEdit.html';
//$f=fopen($p,'r');
//$dettEdit=fread($f,filesize($p));
if(file_exists($htmlpath.'dettEdit'.$id_natura.'.html')){
	$dettEdit=carica_file($htmlpath.'dettEdit'.$id_natura.'.html');
}else{
	$dettEdit=carica_file($htmlpath.'dettEdit.html');
}
$dettEdit=str_replace('[voce_menu]',get_natura($id_natura),$dettEdit);
$dettEdit=str_replace('[del]','pi.requestQ(\'container\',\'DettDel\')',$dettEdit);
$dettEdit=str_replace('[del_hotel]','pi.requestQ(\'container\',\'DettDelHotel\')',$dettEdit);
$dettEdit=str_replace('[go]','pi.requestQ(\'container\',\'DettEditDb\')',$dettEdit);
$dettEdit=str_replace('[cancel]','pi.requestQ(\'container\',\'DettLoad\')',$dettEdit);
$dettEdit=str_replace('[go_hotel]','pi.requestQ(\'container\',\'DettEditHotelDb\')',$dettEdit);
$dettEdit=str_replace('[costokm]','pi.requestQ(\'wallet\',\'WinDettItin\')',$dettEdit);
$dettEdit=str_replace('[detthotel]','pi.requestQ(\'wallet\',\'WinDettHotel\')',$dettEdit);
$dettEdit=str_replace('[dett_fattura]','pi.requestQ(\'wallet\',\'WinDettFatt\')',$dettEdit);

//gestione soglie personalizzate
$qry_soglie=carica_file($qrypath.'sogliePers.sql');
$qry_soglie=str_replace('[login_utente]',$login_utente,$qry_soglie);
$qry_soglie=str_replace('[id_natura]',$id_natura,$qry_soglie);
$qry_soglie=str_replace('[id_trasf]',$id_trasf,$qry_soglie);
$res_soglie=$db->get_data($qry_soglie);
foreach($res_soglie as $v){
	$dettEdit=str_replace('[soglia]',$v['soglia'],$dettEdit);
}


$qry=carica_file($qrypath.'DettEdit.sql');
$qry=str_replace('[id_dett]',$id_dett,$qry);
$results=$db->get_data($qry);

$qry2=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($qry2);
foreach($results as $v){
	$dettEdit=str_replace('[no_giustificativo_checked]',$v['no_giustificativo']=='Y'?'checked':'',$dettEdit);
	$dettEdit=str_replace('[tipo_giustificativo_select]',lista_giustificativi($v['tipo_giustificativo']),$dettEdit);
	$dettEdit=str_replace('[id_pagamento_select]',lista_pagamenti($v['id_pagamento']),$dettEdit);
	$dettEdit=str_replace('[select_luogo]',$lista_negozi_trasf,$dettEdit);
	$dettEdit=str_replace('[login_utente]',$login_utente,$dettEdit);
	$dettEdit=str_replace('[rs_usr]',$rs_usr,$dettEdit);
	$dettEdit=str_replace('[desc_trasf]',$desc_trasf,$dettEdit);
foreach($res2 as $v2){
	$nomecampo=trim(strtolower($v2['column_name']));
	$dettEdit=str_replace('['.$nomecampo.']',$v[$nomecampo],$dettEdit);
}
}

$out0=$dettEdit;

$pr->add_html('container',$out0)->response();
?>