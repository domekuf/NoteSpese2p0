<?//
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];


$htmlpath= module_path().'html/dettFatt/';
$qrypath= module_path().'qry/dettFatt/';
$jspath= module_path().'js/dettFatt/';
$interface=carica_file($htmlpath.'dettFatt.html');
$qry_fatt=carica_file($qrypath.'loadFatt.sql');
$qry_fatt=str_replace('[id_dett]',$id_dett,$qry_fatt);
$colonne=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($colonne);
$res=$db->get_data($qry_fatt);


$qry_fornitori=carica_file($qrypath.'fornitori.sql');
$interface=str_replace('[id_dett]',$id_dett,$interface);
$interface=str_replace('[id_container]','wincontainer',$interface);
$interface=str_replace('[save]','pi.requestWinOpen(\'wincontainer\')',$interface);
$interface=str_replace('[save_call]','WinDettFattDb',$interface);
foreach($res as $v){
	foreach($res2 as $v2){
		$nomecampo=trim(strtolower($v2['column_name']));
		$interface=str_replace('['.$nomecampo.']',$v[$nomecampo],$interface);
	}
	$selected_mastro_partitario=$v['mastro_ft'].'-'.$v['partit_ft'];
}

$select=qry2sel_filtrabile($qry_fornitori,'descrizione','codice',$selected_mastro_partitario,'select-fornitori','descrizione');
$interface=str_replace('[fornitore_select]',$select,$interface);
$pr->add_win(1000,0,true,'Dettaglio Fattura',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>