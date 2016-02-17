<?//
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];

$htmlpath= module_path().'html/dettHotel/';
$qrypath= module_path().'qry/dettHotel/';
$jspath= module_path().'js/dettHotel/';
$interface=carica_file($htmlpath.'dettHotel.html');
$qry_hotel=carica_file($qrypath.'loadHotel.sql');
$qry_hotel=str_replace('[id_dett]',$id_dett,$qry_hotel);
$colonne=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($colonne);



$i=0;
$qry1='select count(*) as c from
psofa.pso_rs_dett_hotel
where id_dett='.$id_dett;
$results1=$db->get_data($qry1);
$count=$results1[0]['c'];
if($count==0){
	$qry_ins='
	insert into psofa.pso_rs_dett_hotel a
	(a.id_hotel,
	a.id_dett, a.n_notti, a.n_colazioni, a.n_pranzi, a.n_cene,
            a.tot_notti, a.tot_colazioni, a.tot_pranzi, a.tot_cene, 
             a.altro, a.totale_fattura, a.totale, a.id_trasf)
	values
	(psofa.pso_seq_rs_dett_hotel.nextval,
	'.$id_dett.', 	1,1,1,1,
			0,0,0,0,
			0,0,0,'.$id_trasf.')';
	$db->put_data($qry_ins);
}
$res=$db->get_data($qry_hotel);

foreach($res as $v){
	foreach($res2 as $v2){
		$nomecampo=trim(strtolower($v2['column_name']));
		$interface=str_replace('['.$nomecampo.']',$v[$nomecampo],$interface);
	}
}


$pr->add_win(1000,0,true,'Gestisci Hotel',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>