<?
$id_tappa = $_POST['id_tappa'];
$luogo = $_POST['luogo'];
//$luogo = 'Parma';
$data = $_POST['data'];
//$datatime = '2015-12-02';
$qry='
update  psofa.pso_rs_trasf_itin
   set luogo=\''.$luogo.'\'
       ,data=to_date(\''.$data.'\',\'dd-mm-yyyy\')
 where id_tappa='.$id_tappa;
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("wallet","Trasf_Load");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
