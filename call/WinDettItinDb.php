<?
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$luogo = $_POST['luogo'];
//$luogo = 'Parma';
$data = $_POST['data'];
$kms = $_POST['kms'];
//$datatime = '2015-12-02';

//questo serve a gestire la stringa passata con gli argomenti e creare i due array che usiamo nelle queri di insert
$data = preg_replace('/:+/', ':', $data);
$luogo = preg_replace('/:+/', ':', $luogo);
if($data == ':' || $luogo == ':'){
	$data='';
	$luogo='';
	$date=[];
	$luoghi=[];
}else{
if($luogo[strlen($luogo)-1]==':'){
	$luogo=substr($luogo, 0, strlen($luogo)-1);
}
if($luogo[0]==':'){
	$luogo=substr($luogo, 1, strlen($luogo));
}
if($data[strlen($data)-1]==':'){
	$data=substr($data, 0, strlen($data)-1);
}
if($data[0]==':'){
	$data=substr($data, 1, strlen($data));
}
$date=explode(':',$data);
$luoghi=explode(':',$luogo);
}
if(sizeof($date)==sizeof($luoghi)){
	$qry_del='delete from psofa.pso_rs_dett_itin where id_dett='.$id_dett;
	$db->put_data($qry_del);
//	
	if(sizeof($date)>0){
		$qry='insert all';
for($i=0;$i<sizeof($date);$i++){
//	$ko='ko';
	$qry.='
	into psofa.pso_rs_dett_itin
            (id_trasf
			,id_dett
            ,id_tappa
            ,luogo
            ,data
			,km
			,latitudine
			,longitudine
			,costo_km
			,pedaggio)
    values
           (
           \''.$id_trasf.'\'
		   ,\''.$id_dett.'\'
           ,psofa.pso_seq_rs_dett_itin.nextval
           ,\''.$luoghi[$i].'\'
           ,to_date(\''.$date[$i].'\',\'dd-mm-yyyy\')
		   ,to_number(\''.$kms.'\',\'999999.999999999999999999999999\')
		   ,\'0\'
		   ,\'0\'
		   ,to_number(\'0.21\',\'9.99\')
		   ,\'0\'
		   )';
	}
//
$qry.='select * from dual';
$db->put_data($qry);
	}
}else{
	//gestire errore??
}
//$pr->add_script('$("#luogo_itin_intestazione").html("Inserito Itinerario")');
//$pr->add_script('$("#luogo_dett_id").val("'.$luoghi[0].'")');
//$pr->add_script('$("#luogo_dett_id").attr("readonly",true)');
//$pr->add_script('$("#importo_richiesto").val(\''.$debug.'\')');
//$pr->add_script('console.log(\'log : \'+\''.$id_dett.'\')');


//$pr->add_script('console.log(asd)')->response();

//quelli veri
//$pr->add_html('container3','');
$pr->add_script('$("#importo_richiesto").val(Math.round('.($kms*0.21).'*100)/100)');
$pr->add_script('$("#importo").val(Math.round('.($kms*0.21).'*100)/100)')->response();


//$pr->add_script('pi.requestQLoaderOpen("wallet","Trasf_Load");')->response();
//$pr->add_html('container3',$qry)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
