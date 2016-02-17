<?
$id_dett = $_POST['id_dett'];
$id_hotel_padre = $_POST['id_hotel_padre'];
//$id_hotel = $_POST['id_hotel'];
//$luogo = $_POST['luogo'];
//$luogo = 'Parma';
//$datatime = $_POST['datatime'];
//$datatime = '2015-12-02';
if($id_hotel==''){
	$id_hotel='0';
}
$qry='delete from psofa.pso_rs_dett
      where id_hotel='.$id_hotel_padre.'
	  and id_hotel>0
	  '
	  ;
$db->put_data($qry);
$qry='delete from psofa.pso_rs_dett_hotel
      where id_dett='.$id_dett;
$db->put_data($qry);
$qry='delete from psofa.pso_rs_dett
      where id_dett='.$id_dett;
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("wallet","DettLoad");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
