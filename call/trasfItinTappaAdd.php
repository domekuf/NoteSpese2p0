<?
$qrypath	  =module_path().'qry/trasfItin/';
$qry_add_tappa=carica_file($qrypath.'trasfItinAggTappa.sql');
$qry_add_tappa=	str_replace('[id_trasf]',$_POST['id_trasf'],
				str_replace('[luogo]','',
				str_replace('[luogo_a]','',
				str_replace('[data]',$_POST['data_new'],
				$qry_add_tappa))));
$db->get_data($qry_add_tappa);
include('TrasfItinLoad.php');
//$pr->response();
?>