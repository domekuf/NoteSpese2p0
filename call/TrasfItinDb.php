<?
$id_trasf = $_POST['id_trasf'];
$luogo = $_POST['luogo'];
//$luogo = 'Parma';
$data = $_POST['data'];
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
	$qry_del='delete from psofa.pso_rs_trasf_itin where id_trasf='.$id_trasf;
	$db->put_data($qry_del);
	
	if(sizeof($date)>0){
		$qry='insert all';
for($i=0;$i<sizeof($date);$i++){
	$ko='ko';
	$qry.='
	into psofa.pso_rs_trasf_itin
            (id_trasf
            ,id_tappa
            ,luogo
            ,data)
    values
           (
           \''.$id_trasf.'\'
           ,psofa.pso_seq_rs_trasf_itin.nextval
           ,\''.utf8_decode($luoghi[$i]).'\'
           ,to_date(\''.$date[$i].'\',\'dd-mm-yyyy\'))';
	}

$qry.='select * from dual';
$db->put_data($qry);
	}
}else{
	//gestire errore??
}

$qry2='
update
    psofa.pso_rs_trasf
set
    data_da=(select * from(
select
    data
from
    psofa.pso_rs_trasf_itin
where id_trasf='.$id_trasf.'
order by data asc)
where rownum=1)
    ,data_a=(select * from(
select
    data
from
    psofa.pso_rs_trasf_itin
where id_trasf='.$id_trasf.'
order by data desc)
where rownum=1)
where id_trasf='.$id_trasf;

$db->put_data($qry2);


//$pr->add_html('container2',sizeof($date).'------------'.$data.'---------'.$ko);
$pr->add_script('pi.requestQLoaderOpen("wallet","TrasfLoad");')->response();
//$pr->add_html('container2',$qry)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
