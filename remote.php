<?
	session_start();
	if(!isset($_POST["Pi_Root_Path"])){die('Portal 1 Root non trovato');}
	include $_POST['Pi_Root_Path'].'../lib/php.response.php';
	$pr = new PI_Respose($_POST,$_SESSION);
	if(file_exists('./call/_common.php')){ include './call/_common.php' ; }
	
	$pr->set('CallBack',true);
	
	while($pr->get('CallBack')){
		$pr->set('CallBack',false);
		if(!file_exists('./call/'.$pr->get('NextCall').'.php')){ 
			$pr->add_msg('error','Tipo Operazione "'.$pr->get('NextCall').'" non previsto.')->response(); 
		}
		include './call/'.$pr->get('NextCall').'.php';
	}
	
	$pr->add_msg('error','Situazione Anomala: Questo messaggio NON si dovrebbe visualizzare... Chiama <b>SUBITO</b> l\'amministratore di sistema!')->response();
?>