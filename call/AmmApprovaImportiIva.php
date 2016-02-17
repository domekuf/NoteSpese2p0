<?
$cod_iva=$_POST['cod_iva'];
$importo_approvato=$_POST['importo_approvato'];
$id_dett_arr=$_POST['id_dett_arr'];
$qrypath= module_path().'qry/dett/';

$out='';
foreach($id_dett_arr as $i){
	$qry=carica_file($qrypath.'updateApprova.sql');
	$qry=str_replace('[cod_iva]',$cod_iva[$i],$qry);
	$qry=str_replace('[importo_approvato]',$importo_approvato[$i],$qry);
	$qry=str_replace('[id_dett]',$i,$qry);
	$db->put_data($qry);
}
//$pr->add_win(600,0,true,'OK',$out)->add_script(" $('#focusme').focus(); ")->response();


$pr->add_script('pi.requestQLoaderOpen("wallet","AmmTrasfLoad");')->response();
//$pr->add_html('container',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
