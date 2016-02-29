<?

$htmlpath= module_path().'html/dettEdit/';
$qrypath= module_path().'qry/dettEdit/';
$jspath= module_path().'js/dettEdit/';

$qry1=carica_file($qrypath.'update.sql');


$qry2=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($qry2);

//gestione limite_spesa

$soglia=$_POST['soglia'];
if($_POST['no_giustificativo']){
	$soglia=0;
}
if($soglia<0){
	$soglia=$_POST['importo_richiesto'];
}
$limite_spesa=$_POST['qta_soglia']*$soglia;
$qry1=str_replace('[limite_spesa]',$limite_spesa,$qry1);
$qry1=str_replace('[soglia]',$soglia,$qry1);

foreach($res2 as $v2){
	$nomecampo=trim(strtolower($v2['column_name']));
	$qry1=str_replace('['.$nomecampo.']',$_POST[$nomecampo],$qry1);
}
$db->put_data($qry1);
//$out=$qry1;
$pr->add_script('pi.requestQLoaderOpen(\'container\',\'DettLoad\')')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>