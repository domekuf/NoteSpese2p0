<?
$id_trasf = $_POST['id_trasf'];
$luogo = $_POST['luogo'];
//$luogo = 'Parma';
$data = $_POST['data'];
//$datatime = '2015-12-02';
$qry='
insert into psofa.pso_rs_trasf_itin
            (id_trasf
            ,id_tappa
            ,luogo
            ,data)
    values
           (
           \''.$id_trasf.'\'
           ,psofa.pso_seq_rs_trasf_itin.nextval
           ,\''.$luogo.'\'
           ,to_date(\''.$data.'\',\'dd-mm-yyyy\'))';
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("wallet","Trasf_Load");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
