<?//
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];


$htmlpath= module_path().'html/dettFatt/';
$qrypath= module_path().'qry/dettFatt/';
$jspath= module_path().'js/dettFatt/';
$qry_update=carica_file($qrypath.'update.sql');

$qry2=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($qry2);

foreach($res2 as $v2){
	$nomecampo=trim(strtolower($v2['column_name']));
	$qry_update=str_replace('['.$nomecampo.']',$_POST[$nomecampo],$qry_update);
}
$db->put_data($qry_update);

//$pr->add_msg('alert','Ecco la query : <br>'.$qry_update)->response();

$pr->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>