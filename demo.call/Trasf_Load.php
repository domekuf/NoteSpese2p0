<?
$login_utente=$_POST['login_utente'];
$qry='
select
    *
from
    psofa.pso_rs_trasf
where
    login_utente=\''.$login_utente.'\'
order by
    id_trasf
';
//apertura tabella e utente
$lista_trasferte = '
	<table class="std  blu">
	<tbody>
	<tr>
		<th style="text-align:center" colspan=6>Storico Trasferte '.$login_utente.'</th>
	</tr>
	<tr>
		<th rowspan=2>Descrizione</th>
		<th colspan=2>Itinerario</th>
		<th rowspan=2>Modifica</th>
	</tr>
	<tr>
		<th>Luogo:</th>
		<th>Data:</th>
	</tr>';
$results=$db->get_data($qry);
foreach($results as $v){
	$lista_trasferte .= '<tr class ="blu">
		<td>'.$v['desc_trasf'].'</td>
		<td onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Itin_Load\')" style="cursor:pointer;" colspan=2>
			<div id="trasf_id'.$v['id_trasf'].'"><input type="hidden" name="id_trasf" value="'.$v['id_trasf'].'"/></div>
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
		<td style="text-align:center">
		<button class="confirm icon"><div></div></button>
		<button class="edit icon" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trans_Load\')" style="cursor:pointer;"><div></div></button>
		<button class="del icon" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Del\',\'Eliminare Questa Trasferta?\')" style="cursor:pointer;"><div></div></button>
		</td>
	</tr>';
}
//chiusura tabella e pulsante crea
$lista_trasferte .='
	<tr onclick="pi.requestQ(\'login\',\'Trasf_Add\')" style="cursor:pointer;" class ="fix green">
		<td style="text-align:center" colspan=4><button onclick="pi.requestQ(\'login\',\'Trasf_Add\')" style="cursor:pointer;" class="plus"><div>Inserisci Nuova</div></button></td>
	</tr>
	</tbody></table>
	';
$pr->add_html('container0',$lista_trasferte)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
