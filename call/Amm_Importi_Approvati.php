<?
$id_importi_approv = $_POST['id_importi_approv'];
$importi_approv = $_POST['importi_approv'];
$arr_id_importo_approv = explode(':',$id_importi_approv);
$arr_importo_approv = explode(':',$importi_approv);
//$out.=serialize($_POST);
$out.='<div onclick="pi.win.close()"><br><br>';
if(count($arr_id_importo_approv)==count($arr_importo_approv)){
	$i=0;
	foreach($arr_id_importo_approv as $id_importo_approv){
		$qry='
		update  psofa.pso_rs_dett
			set importo_approvato=to_number(\''.$arr_importo_approv[$i].'\',\'99999999999999999.99\')
		where id_dett='.$id_importo_approv;
		$db->put_data($qry);
		//$out.=$qry.'<br>';
		$i++;
	}
}else{
	$out.=count($arr_id_importo_approv);
	$out.=' x ';
	$out.=count($arr_importo_approv);
	$pr->add_win(600,0,true,'Problema generico con i dati inseriti',$out)->add_script(" $('#focusme').focus(); ")->response();
}
$out.='

<img  src="/modules/CED/NoteSpese/ok1.png" />
<h1>
Salvataggio Corretto! 
</h1>
';
$out.='<br><br></div>';
$pr->add_win(600,0,true,'OK',$out)->add_script(" $('#focusme').focus(); ")->response();





//$pr->add_script('pi.requestQLoaderOpen("wallet","Trasf_Load");')->response();
//$pr->add_html('container3',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
