<?
$id_trasf 	= $_POST['id_trasf'];
$luogo 		= $_POST['luogo'];
$luogo_a 	= $_POST['luogo_a'];
$data 		= $_POST['data'];
$qrypath	=module_path().'qry/trasfItin/';
$qry_salva_tappa_tmp=carica_file($qrypath.'trasfItinSalvaTappa.sql');

foreach($luogo as $key => $l){
	$qry_salva_tappa=str_replace('[data]',$data[$key]
					,str_replace('[luogo]',$luogo[$key]
					,str_replace('[luogo_a]',$luogo_a[$key]
					,str_replace('[id_trasf]',$id_trasf
					,str_replace('[id_tappa]',$key
					,$qry_salva_tappa_tmp)))));
	$qry.='-----'.$qry_salva_tappa;
	$db->put_data($qry_salva_tappa);
}
//$pr->add_html('container',$qry)->response();
$pr->add_script('pi.requestQLoaderOpen("wallet","TrasfLoad");')->response();
//$pr->add_html('container2',$qry)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
