<?
//
//$id_trasf = $_POST['id_trasf'];
//$data = $_POST['data'];
//$id_dett = $_POST['id_dett'];
//$id_natura = $_POST['id_natura'];
//$rs_usr = $_POST['rs_usr'];
//$lista_negozi_trasf=genera_lista_negozi_trasferta($id_trasf);

$htmlpath= module_path().'html/dettEdit/';
$qrypath= module_path().'qry/dettEdit/';
$jspath= module_path().'js/dettEdit/';

$qry1=carica_file($qrypath.'update.sql');
$qry3=carica_file($qrypath.'updateHotelFigli.sql');


$qry2=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($qry2);
foreach($res2 as $v2){
	$nomecampo=trim(strtolower($v2['column_name']));
	$qry1=str_replace('['.$nomecampo.']',$_POST[$nomecampo],$qry1);
	$qry3=str_replace('['.$nomecampo.']',$_POST[$nomecampo],$qry3);
}
$db->put_data($qry1);
$db->put_data($qry3);
//$out=$qry1;

$pr->add_script('pi.requestQLoaderOpen(\'wallet\',\'DettLoad\')')->response();
//$pr->add_html('container',$qry3)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>