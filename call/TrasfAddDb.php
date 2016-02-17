<?
$login_utente = $_POST['login_utente'];
$desc_trasf = $_POST['desc_trasf'];
$id_gruppo = $_POST['id_gruppo'];
$qry='
insert into psofa.pso_rs_trasf a
            (id_trasf
           ,login_utente
           ,desc_trasf
		   ,id_gruppo)
     values
           (psofa.pso_seq_rs_trasf.nextval
           ,\''.$login_utente.'\'
           ,\''.utf8_decode($desc_trasf).'\'
           ,\''.$id_gruppo.'\'
		   )
		   
';
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("wallet","TrasfLoad");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
