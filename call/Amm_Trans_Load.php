<?
$id_trasf = $_POST['id_trasf'];
$id_trans = $_POST['id_trans'];
//queste sono nella _commmon.php, utility per velocizzare html
$n_righe = 5;
$n_colonne = 15;
$qry='
select
    id_dett
	,id_trasf
	,data
	,id_natura
	,luogo
	,importo
	,importo_richiesto
	,limite_spesa
	,id_pagamento
	,tipo_giustificativo
	,giustificativo
	,pre_approvazione
	,approvazione_sforo
	,note
	,importo_approvato
	,soglia	
	,id_hotel
from
    psofa.pso_rs_dett
where
	id_trasf='.$id_trasf;
$out='
<div id="AmmElencoTrans">
<table class="std fix">
<tbody>
<tr><th colspan='.$n_colonne.'>Elenco Transazioni, Trasferta: '.$id_trasf.'</th></tr>
  <tr>
	<th>
		Data
	</th>
	<th>
		Natura
	</th>
	<th>
		Descrizione/Mastro/Partitario
	</th>
	<th>
		Pagato Con
	</th>
	<th>
		Scontrino/Fattura
	</th>
	<th>
		Note
	</th>
	<th>
		All. Documento
	</th>
	<th>
		All. Mail Pre
	</th>
	<th>
		All. Mail Post
	</th>
	<th>
		Importo
	</th>
	<th>
		Importo Richiesto
	</th>
	<th>
		Soglia Calcolata
	</th>	
	<th  class="red">
		Over Budget
	</th>	
	<th class="red">
		Importo Approvato
	</th>
	<th>
		Apri
	</th>	
  </tr>
  <script>
	$("#wall_id_importi_approv").val("");
  </script>
  ';
$results=$db->get_data($qry);
$i=0;
$linea_finita=1;

foreach($results as $v){
	$out.='
	<tr class="'.(($v['id_hotel']!=' --- ' || get_natura($v['id_natura'])=="Hotel")?'purple':'orange') . ' ">
		<script>
			append_id("wall_id_importi_approv",'.$v['id_dett'].');
		</script>
		<td>
		'.$v['data'].'
		</td>
		<td>
		'.$nature_id[$v['id_natura']]['voce_menu'].'
		</td>
		<td>
		'.$nature_id[$v['id_natura']]['descrizione'].'/
		'.$nature_id[$v['id_natura']]['mastro'].'/
		'.$nature_id[$v['id_natura']]['partitario'].'
		</td>
		<td>
		'.$pagamenti_id[$v['id_pagamento']]['voce_menu'].'
		</td>
		<td>
		'.$giustificativi_id[$v['tipo_giustificativo']]['voce_menu'].'
		</td>
		<td>
		'.$v['note'].'
		</td>
		<td>'.
		(strlen($v['giustificativo'])>5?
		'<a href="/extension/RimborsiSpese/Ced/'.$v['giustificativo'].'" target="_blank" ><i class="fa fa-paperclip fa-3x" ></i></a>':'').'
		</td>
		<td>'.
		(strlen($v['pre_approvazione'])>5?
		'<a href="/extension/RimborsiSpese/Ced/'.$v['pre_approvazione'].'" target="_blank" ><i class="fa fa-paperclip fa-3x" ></i></a>':'').'
		</td>
		<td>'.
		(strlen($v['approvazione_sforo'])>5?
		'<a href="/extension/RimborsiSpese/Ced/'.$v['approvazione_sforo'].'" target="_blank" ><i class="fa fa-paperclip fa-3x" ></i></a>':'').'
		</td>
		<td>
		'.db2pi($v['importo']).'
		</td>
		<td>
		'.db2pi($v['importo_richiesto']).'
		</td>
		<td>
		'.db2pi($v['limite_spesa']).'
		</td>
		<td '.(((db2pi($v['importo_richiesto'])-db2pi($v['limite_spesa']))>0)?' style="background-color:red;color:white"':'').' >
		'.(((db2pi($v['importo_richiesto'])-db2pi($v['limite_spesa']))>0)?(db2pi($v['importo_richiesto'])-db2pi($v['limite_spesa'])).' <i class="fa fa-exclamation-triangle"></i>':'').'
		</td>
		<td>
			<input type="text" name="importo_approvato_'.$v['id_dett'].'" id="importo_approvato_'.$v['id_dett'].'" value="'.db2pi($v['importo_approvato']).'"/>
		</td>
		<td>
		<button style="cursor:pointer" class="search icon" onclick="amm_Trans_Edit('.$v['id_dett'].')">
		<div>
		</div>
		</button>
		</td>
		
	</tr>';
}
	
$out.='
<tr style="text-align:center">
<td colspan="'.$n_colonne.'">
<button style="cursor:pointer" class="save" onmouseover="update_importi()" onclick="pi.requestQ(\'wallet\',\'Amm_Importi_Approvati\');">
<div>
Salva Importi Approvati
</div>
</button>
</td>
</tr>
</tbody>
</table>
</div>
<script>
update_wallet(\'wall_id_trasf\','.$id_trasf.');
update_wallet(\'wall_id_trans\',0);
</script>
';
$pr->add_html('container1','');
//$pr->add_html('container3',$div_dati_hid);
$pr->add_html('container2',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
