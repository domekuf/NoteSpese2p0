<?
$login_utente = $_POST['login_utente_amm'];
$id_trasf = $_POST['id_trasf'];
$qrypath= module_path().'qry/trasf/';
$qry='
select 
pso_pkg_cow_utility.sf_contab_trasf_rimb_spese(\''.$id_trasf.'\',\''.$login_utente.'\') as res
from dual
';
$res=$db->get_data($qry)[0]['res'];
//$pr->add_script('pi.requestQ("wallet","Amm_Trasf_Load");')->response();
if(strtolower(substr($res,0,2))=='ok'){
	$bat_tmp=carica_file('/var/www/extension/FWlauncher/fwtmp.bat');
	$qry_rr=carica_file($qrypath.'contabilizzaCreaFileFreeway.sql');
	$qry_rr=str_replace('[id_trasf]',$id_trasf,$qry_rr);
	$res2=$db->get_data($qry_rr);
	foreach($res2 as $v2){
		$myfile = fopen('/var/www/extension/FWlauncher/fw'.$v2['nro_reg'].'.bat', "w");
		$bat0=str_replace('[nro_reg]',$v2['nro_reg'],$bat_tmp);
		fwrite($myfile, $bat0);
	}
}
$pr->add_script('pi.requestQ("wallet","AmmTrasfLoad");');
$pr->add_win(400,0,true,'Risultato','<h2>'.$res.'</h2>')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
