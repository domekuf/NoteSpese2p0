<?
$login_utente = $_POST['login_utente_amm'];
$id_trasf = $_POST['id_trasf'];
$qry='
select 
pso_pkg_cow_utility.sf_canc_contab_trasf_rimb_sp(\''.$id_trasf.'\',\''.$login_utente.'\') as res
from dual
';
$res=$db->get_data($qry)[0]['res'];
//$pr->add_script('pi.requestQ("wallet","Amm_Trasf_Load");')->response();
$pr->add_script('pi.requestQ("wallet","AmmTrasfLoadStorico");');
$pr->add_win(400,0,true,'Risultato','<h2>'.$res.'</h2>')->response();

//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
