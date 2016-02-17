<?
$login_utente = $_POST['login_utente'];
$desc_trasf = $_POST['desc_trasf'];
$qry='
insert into psofa.pso_rs_trasf a
            (id_trasf
           ,login_utente
           ,desc_trasf)
     values
           (psofa.pso_seq_rs_trasf.nextval
           ,\''.$login_utente.'\'
           ,\''.$desc_trasf.'\')
		   
';
$db->put_data($qry);
$pr->add_script('pi.requestQLoaderOpen("login","Trasf_Load");')->response();
//$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
