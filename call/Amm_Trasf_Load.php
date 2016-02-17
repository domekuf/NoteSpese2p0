<?
$amm_utente=$_POST['amm_utente'];
$login_utente=$_POST['login_utente'];
$data_da=$_POST['data_da'];
$data_a=$_POST['data_a'];

$qry='
select  
    *
from
    psofa.pso_rs_trasf
where 
login_utente=\''.$amm_utente.'\'
and(
(rrbsp is null and rrbsp_2 is null)
or
(data_da <= to_date(\''.$data_a.'\',\'dd-mm-yyyy\')
and data_a >= to_date(\''.$data_da.'\',\'dd-mm-yyyy\'))
)
order by
data_da';

//apertura tabella e utente
$lista_trasferte = '

<style>

</style>
	<table class="std  blu">
	<tbody>
	<tr>
		<th style="text-align:center" colspan=6>Storico Trasferte '.$amm_utente.'</th>
	</tr>
	<tr>
		<th rowspan=2>Descrizione</th>
		<th colspan=2>Itinerario</th>
		<th rowspan=2>Modifica</th>
		<th rowspan=2>Riepilogo</th>
	</tr>
	<tr>
		<th>Luogo:</th>
		<th>Data:</th>
	</tr>';
$results=$db->get_data($qry);
foreach($results as $v){
	$lista_trasferte .= '<tr class ="blu">
		<td onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Amm_Trans_Load\')" style="cursor:pointer;">'.$v['desc_trasf'].'</td>
		<td onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Itin_Load\')" style="cursor:pointer;" colspan=2>
			<div id="trasf_id'.$v['id_trasf'].'"><input type="hidden" name="id_trasf" value="'.$v['id_trasf'].'"/><input type="hidden" name="login_utente" value="'.$login_utente.'"/></div>
			<table class="std">
				<tbody>';
		$qry2='	select
					*
				from
					psofa.pso_rs_trasf_itin
				where
				id_trasf='.$v['id_trasf'].'
				order by data';
		$results2=$db->get_data($qry2);
		foreach($results2 as $v2){		
		$lista_trasferte.='
					<tr>
						<td>'.$v2['luogo'].'</td>
						<td>'.$v2['data'].'</td>
					</tr>';
		}
		$lista_trasferte.='
				</tbody>
			</table>
		</td>
		<td style="text-align:center">'.
//		<button class="confirm icon"><div></div></button>
		'<button class="search" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Amm_Trans_Load\')" style="cursor:pointer;"><div>Apri</div></button>'.
//		<button class="del icon" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Del\',\'Eliminare Questa Trasferta?\')" style="cursor:pointer;"><div></div></button>
		((strlen((trim($v['rrbsp'])))<4 and strlen((trim($v['rrbsp_2'])))<4)?
		('<button class="confirm" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Contabilizza\',\'Questo contabilizzer&agrave; tutta la trasferta, procedere?\')" style="cursor:pointer;"><div>Contabilizza</div></button>')
		:'Numero Registrazione Contabile: '.$v['rrbsp'].', '.$v['rrbsp_2'])
		//strlen((trim($v['rrbsp'])))
		//.strlen((trim($v['rrbsp_2']))).' - '
		//.(strlen((trim($v['rrbsp'])))<4 and strlen((trim($v['rrbsp_2'])))<4)
		.'
		</td>
		<td>
		<table class="std">
			<tbody>
		<tr><th>Totale		</th><td>'.(db2pi($v['totale_contanti'])+db2pi($v['totale_carta'])).'	</td></tr>
		<tr><th>Carta 		</th><td>'.db2pi($v['totale_carta']).' 								</td></tr>
		<tr><th>Contanti 	</th><td>'.db2pi($v['totale_contanti']).' 							</td></tr>
		<tr><th>OverBudget 	</th><td>'.db2pi($v['totale_ob']).'								</td></tr>
			</tbody>
		</table>
		</td>
	</tr>';
}
//chiusura tabella e pulsante crea
$lista_trasferte .=''.
//		<tr onclick="pi.requestQ(\'login\',\'Trasf_Add\')" style="cursor:pointer;" class ="fix green">
//			<td style="text-align:center" colspan=4><button onclick="pi.requestQ(\'login\',\'Trasf_Add\')" style="cursor:pointer;" class="plus"><div>Inserisci Nuova</div></button></td>
//		</tr>
	'</tbody></table>
	';
//$pr->add_html('container5',(string)print_r($nature_id));

$pr->add_html('container1','');
$pr->add_html('container2','');
$pr->add_html('container3','');
$pr->add_html('container4','');
$pr->add_html('container5','');
$pr->add_html('container0',$lista_trasferte)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
