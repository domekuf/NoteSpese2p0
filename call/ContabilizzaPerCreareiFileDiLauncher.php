<?
$qrypath= module_path().'qry/trasf/';
$id_trss=array(
382
,397
,203
,378
,381
,387
,389
,398
,400
,406
,407
,408
,409
,481
,383
,385
,386
,402
,404
,405
,81 
,384
,390
,391
,392
,393
,394
,395
,401
,403
,223
,281
,388
,396
,581
);

$bat_tmp=carica_file('/var/www/extension/FWlauncher/fwtmp.bat');
$qry_rrt=carica_file($qrypath.'contabilizzaCreaFileFreeway.sql');

foreach($id_trss as $id_trasf){
	$qry_rr=str_replace('[id_trasf]',$id_trasf,$qry_rrt);
	$res2=$db->get_data($qry_rr);
	foreach($res2 as $v2){
		$myfile = fopen('/var/www/extension/FWlauncher/fw'.$v2['nro_reg'].'.bat', "w");
		$bat0=str_replace('[nro_reg]',$v2['nro_reg'],$bat_tmp);
		fwrite($myfile, $bat0);
	}
}
$pr->add_script('pi.requestQ("wallet","AmmTrasfLoad");');
$pr->add_win(400,0,true,'Risultato','<h2>ok</h2>')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
