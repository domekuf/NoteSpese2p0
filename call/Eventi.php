<?

$rs_usr=$_POST['rs_usr'];
$htmlpath= module_path().'html/eventi/';
$qrypath= module_path().'qry/eventi/';

$interface=carica_file($htmlpath.'eventi.html');
$evento_tmp=carica_file($htmlpath.'evento.html');

$eventi='';
$qry_eventi=carica_file($qrypath.'eventi.sql');

$res=$db->get_data($qry_eventi);
foreach($res as $v){
	
	$eventi.=
	str_replace('[id_gruppo]',$v['id_gruppo']
	,str_replace('[descrizione]',$v['descrizione']
	,$evento_tmp));
}

$interface=str_replace('[eventi]',$eventi,$interface);

//$ret=$_SERVER['DOCUMENT_ROOT'].'/test.js';
//$ret=exec('C:/test.js');
//$ret=system("C:/test.js");
$pr->add_html('container',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
