<?
$id_trasf 	= $_POST['id_trasf'];
$id_dett 	= $_POST['id_dett'];
$luogo 		= $_POST['luogo'];
$luogo_a 	= $_POST['luogo_a'];
$data 		= $_POST['data'];
$qrypath	=module_path().'qry/dettItin/';
$qry_salva_tappa_tmp=carica_file($qrypath.'dettItinSalvaTappa.sql');

foreach($luogo as $key => $l){
	$qry_salva_tappa=str_replace('[luogo]',$luogo[$key]
					,str_replace('[luogo_a]',$luogo_a[$key]
					,str_replace('[id_trasf]',$id_trasf
					,str_replace('[id_tappa]',$key
					,str_replace('[id_dett]',$id_dett
					,$qry_salva_tappa_tmp)))));
	$qry.='-----'.$qry_salva_tappa;
	$db->put_data($qry_salva_tappa);
}
$pr->response();
//include('DettEdit.php');
//$pr->add_script('pi.requestQLoaderOpen("wallet","DettLoad");')->response();
//$pr->add_html('container2',$qry)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
