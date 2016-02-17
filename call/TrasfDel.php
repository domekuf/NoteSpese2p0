<?
$id_trasf = $_POST['id_trasf'];

$qry1='delete from psofa.pso_rs_dett_hotel
      where id_dett in(
		select id_dett from psofa.pso_rs_dett
		where id_trasf='.$id_trasf.')';
$db->put_data($qry1);
$qry2='delete from psofa.pso_rs_dett_itin
      where id_trasf='.$id_trasf;
$db->put_data($qry2);
$qry3='delete from psofa.pso_rs_dett
      where id_trasf='.$id_trasf;
$db->put_data($qry3);
$qry4='delete from psofa.pso_rs_trasf_itin
      where id_trasf='.$id_trasf;
$db->put_data($qry4);
$qry5='delete from psofa.pso_rs_trasf
      where id_trasf='.$id_trasf;
$db->put_data($qry5);
$pr->add_script('pi.requestQLoaderOpen("wallet","TrasfLoad");')->response();
//$pr->add_html('container',$qry1)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
