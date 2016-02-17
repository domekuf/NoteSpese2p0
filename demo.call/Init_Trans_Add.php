<?
$login_utente = $_POST['login_utente'];
$id_trasf 			= $_POST['id_trasf'];
$data 				= $_POST['data'];
$id_natura 			= $_POST['id_natura'];
$luogo 				= $_POST['luogo'];
$importo 			= $_POST['importo'];
$importo_richiesto 	= $_POST['importo_richiesto'];
$limite_spesa 		= $_POST['limite_spesa'];
$id_pagamento 		= $_POST['id_pagamento'];
$tipo_giustificativo= $_POST['tipo_giustificativo'];
$giustificativo		= $_POST['giustificativo'];
$pre_approvazione   = $_POST['pre_approvazione'];
$approvazione_sforo = $_POST['approvazione_sforo'];
$note				= $_POST['note'];				
$importo_approvato  = $_POST['importo_approvato'];

$qry='
insert into psofa.pso_rs_dett
            (id_dett
			,id_trasf
			,data
			,id_natura
			,luogo
			,importo
			,importo_richiesto
			,limite_spesa
			,id_pagamento
			,tipo_giustificativo
			,giustificativo
			,pre_approvazione
			,approvazione_sforo
			,note
			,importo_approvato)
     values
           (psofa.pso_seq_rs_dett.nextval
           ,\''.$id_trasf 				.'\'
           ,to_date(\''.$data.'\',\'dd--mm-yyyy\')
           ,\''.$id_natura 				.'\'
           ,\''.$luogo 					.'\'
           ,\''.$importo 				.'\'
           ,\''.$importo_richiesto		.'\'
           ,\''.$limite_spesa 			.'\'
           ,\''.$id_pagamento 			.'\'
           ,\''.$tipo_giustificativo	.'\'
           ,\''.$giustificativo			.'\'
           ,\''.$pre_approvazione 		.'\'
		   ,\''.$approvazione_sforo		.'\'
		   ,\''.$note				    .'\'
		   ,\''.$importo_approvato      .'\'
		   )
		   
';
$db->put_data($qry);
$pr->add_html('container2','');
$pr->add_html('container1','');
$pr->add_script('pi.requestQLoaderOpen("trasf_id","Trans_Load");')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
