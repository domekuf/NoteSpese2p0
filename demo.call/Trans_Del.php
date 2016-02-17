<?
$id_trans = $_POST['id_trans'];
//$luogo = $_POST['luogo'];
//$luogo = 'Parma';
//$datatime = $_POST['datatime'];
//$datatime = '2015-12-02';
$qry='delete from psofa.pso_rs_dett
      where id_dett='.$id_trans;
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("trasf_id","Trans_Load");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
