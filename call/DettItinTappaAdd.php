<?
$qrypath	  =module_path().'qry/dettItin/';
$qry_add_tappa=carica_file($qrypath.'dettItinAggTappa.sql');
$qry_add_tappa=	str_replace('[id_trasf]',$_POST['id_trasf'],
				str_replace('[luogo]','',
				str_replace('[luogo_a]','',
				str_replace('[id_dett]',$_POST['id_dett'],
				str_replace('[data]',$_POST['data_new'],
				$qry_add_tappa)))));
$res_sf=$db->get_data($qry_add_tappa);
include('WinDettItin.php');
//$pr->set('CloseWin',false)->add_html('wincontainer',$qry_add_tappa)->response();
?>