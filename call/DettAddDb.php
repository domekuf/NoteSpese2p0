<?

$id_natura = $_POST['id_natura'];
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];
$data = $_POST['data'];

$htmlpath= module_path().'html/dettAdd/';
$qrypath= module_path().'qry/dettAdd/';
$jspath= module_path().'js/dettAdd/';

$qryAdd=carica_file($qrypath.'dettAdd.sql');
$qryAdd=str_replace('[id_dett]',$id_dett,$qryAdd);
$qryAdd=str_replace('[id_trasf]',$id_trasf,$qryAdd);
$qryAdd=str_replace('[data]',$data,$qryAdd);
$qryAdd=str_replace('[id_natura]',$id_natura,$qryAdd);

//gestione soglia
$qrySoglia=carica_file($qrypath.'soglia.sql');
$qrySoglia=str_replace('[id_natura]',$id_natura,$qrySoglia);
$res=$db->get_data($qrySoglia);
foreach($res as $v){
	$soglia=$v['soglia'];
}

$qryAdd=str_replace('[soglia]',$soglia,$qryAdd);


$db->put_data($qryAdd);

$pr->add_script('pi.requestQLoaderOpen(\'container\',\'DettEdit\')')->response();
//$pr->add_html('container',$qryAdd)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
