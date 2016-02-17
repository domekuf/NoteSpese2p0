<?
$id_tappa = $_POST['id_tappa'];
//$luogo = $_POST['luogo'];
//$luogo = 'Parma';
//$datatime = $_POST['datatime'];
//$datatime = '2015-12-02';
$qry='delete from psofa.pso_rs_trasf_itin
      where id_tappa='.$id_tappa;
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("login","Trasf_Load");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
