<?
$login_utente = $_POST['login_utente'];
$id_trasf 			= $_POST['id_trasf'];
$id_trans			= $_POST['id_trans'];
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
update  psofa.pso_rs_dett
   set 		id_trasf					=\''.$id_trasf 				.'\'
			,data                       =\''.$data 					.'\'
			,id_natura                  =\''.$id_natura 				.'\'
			,luogo                      =\''.$luogo 					.'\'
			,importo                    =\''.$importo 				.'\'
			,importo_richiesto          =\''.$importo_richiesto		.'\'
			,limite_spesa               =\''.$limite_spesa 			.'\'
			,id_pagamento               =\''.$id_pagamento 			.'\'
			,tipo_giustificativo        =\''.$tipo_giustificativo	.'\'
			,giustificativo             =\''.$giustificativo			.'\'
			,pre_approvazione           =\''.$pre_approvazione 		.'\'
			,approvazione_sforo         =\''.$approvazione_sforo		.'\'
			,note                       =\''.$note				    .'\'
			,importo_approvato	        =\''.$importo_approvato      .'\'
		   where id_dett='.$id_trans;
$db->put_data($qry);
$pr->add_html('container2','');
$pr->add_html('container1','');
//$pr->add_html('container4',$qry)->response();
$pr->add_script('pi.requestQLoaderOpen("trasf_id","Trans_Load");')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
