<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$desc_trasf = $_POST['desc_trasf'];
$rs_usr = $_POST['rs_usr'];

$htmlpath= module_path().'html/dettAdd/';
$qrypath= module_path().'qry/dettAdd/';
$jspath= module_path().'js/dettAdd/';

$p=$htmlpath.'dettAdd.html';
$f=fopen($p,'r');
$dettAdd=fread($f,filesize($p));

$p=$qrypath.'date.sql';
$f=fopen($p,'r');
$qry_date=fread($f,filesize($p));
$qry_date=str_replace('[id_trasf]',$id_trasf,$qry_date);
$date_res=$db->get_data($qry_date);
$data_a=$date_res[0]['data_a'];
$data_da=$date_res[0]['data_da'];
$data_da_2=$date_res[0]['data_da_2'];

$p=$qrypath.'getIdDett.sql';
$f=fopen($p,'r');
$qry_id=fread($f,filesize($p));
$dB_ret=$db->get_data($qry_id);
$id_dett=$dB_ret[0]['id_dett'];

$lista_natura=lista_natura_usr_man('',$rs_usr);
$dettAdd=str_replace('[login_utente]',$login_utente,$dettAdd);
$dettAdd=str_replace('[desc_trasf]',$desc_trasf,$dettAdd);
$dettAdd=str_replace('[lista_natura]',$lista_natura,$dettAdd);
$dettAdd=str_replace('[id_dett]',$id_dett,$dettAdd);
$dettAdd=str_replace('[id_trasf]',$id_trasf,$dettAdd);
$dettAdd=str_replace('[data_da]',$data_da,$dettAdd);
$dettAdd=str_replace('[data_a]',$data_a,$dettAdd);
$dettAdd=str_replace('[data_da_2]',$data_da_2,$dettAdd);
$dettAdd=str_replace('[del]','pi.requestQ(\'container\',\'DettDel\')',$dettAdd);
$dettAdd=str_replace('[go]','pi.requestQ(\'container\',\'DettAddDb\')',$dettAdd);
$dettAdd=str_replace('[rs_usr]',$rs_usr,$dettAdd);

$out0=$dettAdd;

//$qryAdd=carica_file($qrypath.'dettAdd.sql');
//$qryAdd=str_replace('[id_dett]',$id_dett,$qryAdd);
//$qryAdd=str_replace('[id_trasf]',$id_trasf,$qryAdd);
//$qryAdd=str_replace('[data]',$data_da_2,$qryAdd);
//$db->put_data($qryAdd);

$pr->add_html('container',$out0)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
