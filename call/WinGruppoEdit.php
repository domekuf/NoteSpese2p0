<?//
$id_gruppo = $_POST['grp_to_edit'];
$descrizione = $_POST['grp_to_edit_desc'];

$htmlpath= module_path().'html/gruppiEdit/';
$qrypath= module_path().'qry/gruppiEdit/';
$qrypath_common= module_path().'_common/qry/';
$jspath= module_path().'js/gruppiEdit/';
$interface=carica_file($htmlpath.'gruppiEdit.html');
$voce_soglia_tmp=carica_file($htmlpath.'voceSoglia.html');
$qry_soglie_gruppi=carica_file($qrypath.'soglieGruppi.sql');
$qry_soglie_gruppi=str_replace('[id_gruppo]',$id_gruppo,$qry_soglie_gruppi);

//$colonne=carica_file($qrypath.'colonne.sql');
//$res2=$db->get_data($colonne);
$res=$db->get_data($qry_soglie_gruppi);


$interface=str_replace('[id_gruppo]',$id_gruppo,$interface);
$interface=str_replace('[descrizione]',$descrizione,$interface);
$interface=str_replace('[id_container]','wincontainer',$interface);
$lista_soglie='';
foreach($res as $v){
	$lista_soglie.=str_replace(
						'[voce_menu]'
						,$v['voce_menu']
						,str_replace(
						'[soglia]'
						,$v['soglia']
						,str_replace(
						'[id_natura]'
						,$v['id_natura']
						,$voce_soglia_tmp)));
}

$qry_select=carica_file($qrypath_common.'nature.sql');
$interface=str_replace('[lista_soglie]',$lista_soglie,$interface);
$interface=str_replace('[del_soglia_call]','WinGruppoDelSoglia',$interface);
$interface=str_replace('[del_soglia]',"pi.requestWinOpen('wincontainer');",$interface);
$interface=str_replace('[add_soglia_call]','WinGruppoAddSoglia',$interface);
$interface=str_replace('[add_soglia]',"pi.requestWinOpen('wincontainer');",$interface);
$interface=str_replace('[select_nature]', qry2sel($qry_select,'voce_menu','id_natura',0),$interface);
$pr->add_win(800,0,true,'Dettaglio Soglie Gruppo',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>