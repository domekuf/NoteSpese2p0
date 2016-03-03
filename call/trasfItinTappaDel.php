<?
$qrypath	  =module_path().'qry/trasfItin/';
$qry_del_tappa=carica_file($qrypath.'trasfItinDelTappa.sql');
$qry_del_tappa=	str_replace('[id_tappa]',$_POST['id_tappa'],
				$qry_del_tappa);
$db->get_data($qry_del_tappa);

$pr->add_script('pi.win.close()');
//$pr->add_win(1000,0,true,'Gestisci Itinerario',$qry_del_tappa)->response();
include('TrasfItinLoad.php');
//$pr->response();
?>