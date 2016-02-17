<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$id_trans = $_POST['id_trans'];
$result=$db->get_data('select * from psofa.pso_rs_dett where id_dett='.$id_trans);
foreach($result as $v){
$data 				= $v['data'];
$id_natura 			= $v['id_natura'];
$luogo 				= $v['luogo'];
$importo 			= $v['importo'];
$importo_richiesto 	= $v['importo_richiesto'];
$limite_spesa 		= $v['limite_spesa'];
$id_pagamento 		= $v['id_pagamento'];
$tipo_giustificativo= $v['tipo_giustificativo'];
$giustificativo		= $v['giustificativo'];
$pre_approvazione   = $v['pre_approvazione'];
$approvazione_sforo = $v['approvazione_sforo'];
$note				= $v['note'];				
$importo_approvato  = $v['importo_approvato'];
}
$lista_natura='
<select name="id_natura" onchange="alert($(this).val())">
<option value="0">auto</option>
<option value="1">auto</option>
<option value="2">auto</option>
<option value="3">auto</option>
</select>';
$out='
<div id="transazione">
	<input type="hidden" name="id_trasf" value="'.$id_trasf.'">
	<input type="hidden" name="id_trans" value="'.$id_trans.'">
	<input type="hidden" name="datatime" value="'.$data.'">
	<table class="fix red" width="100%">
		<tbody>
		<tr>
			<th>Data</th>
			<td><input name="data" type="date"></td>
			<th>Natura</th>
			<td>'.$lista_natura.'</td>
			<th id="luogo_itin_intestazione" style="width:100px">
			<select onchange="$(\'#luogo_dett_id\').val($(this).val())"><option selected value="">Luogo di Riferimento</option>
			'.$lista_negozi.'
			</select>
			</th>
			<td><input id="luogo_dett_id" name="luogo" type="text" value="'.$luogo.'" ></input>
			</td>
		</tr>
		<tr>
			<th>Importo [&euro;] </th>
			<td><input name="importo" type="text" value="'.$importo.'"></td>
			<th>Importo chiesto a rimborso [&euro;] </th>
			<td><input name="importo_richiesto" type="text" onchange="calcola_sforo($(this).val())" value="'.$importo_richiesto.'"></td>
			<th>Sforo [&euro;]</th>
			<td><input id="limite_sforo" type="text" readonly value=""></td>
		</tr>
		<tr>
			<th>Metodo di pagamento</th>
			<td>
			<select name="id_pagamento" value="'.$id_pagamento.'">
			<option value=0>Carta Aziendale</option>
			<option value=1>Carta Personale</option>
			<option value=2>Contanti</option>
			</select>
		</tr>
		<tr>
			</td>
			<th>Tipo Documento</th>
			<td>
			<select name="tipo_giustificativo" value="'.$tipo_giustificativo.'">
			<option value=0>Fattura</option>
			<option value=1>Scontrino</option>
			<option value=2>Altro</option>
			</select>
			</td>
			<th>Allegato</th>
			<td>
			<input name="giustificativo" type="text" value="'.$giustificativo.'">
			</td>
		</tr>
		<tr>
			<th>pre-Approvazione Allegata</th>
			<td>
			<input name="pre_approvazione" type="text" value="'.$pre_approvazione.'">
			</td>
			<th id="id_sforo0" style="visibility:hidden">Approvazione sforo Allegata</th>
			<td id="id_sforo1"  style="visibility:hidden">
			<input name="approvazione_sforo" value="'.$approvazione_sforo.'" type="text">
			</td>
		</tr>
		<tr>
			<th>Note</th>
			<td>
			<input type="text" name="note" value="'.$note.'">
			</td>
		</tr>
		<tr>
			<td style="text-align:center" colspan=6>
			<button onclick="pi.requestQ(\'transazione\',\'Init_Trans_Edit\')" style="cursor:pointer;" class="save"><div>Salva</div></button>
			<button onclick="pi.requestQ(\'transazione\',\'Trans_Del\')" style="cursor:pointer;" class="del"><div>Elimina</div></button>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
function calcola_sforo(importo_richiesto){
	var soglia=100;
	if(importo_richiesto>soglia){
		$("#limite_sforo").css("background-color","red");
		$("#limite_sforo").css("color","white");
		$("#limite_sforo").val(importo_richiesto-soglia);
		$("#id_sforo0").css("visibility","visible");
		$("#id_sforo1").css("visibility","visible");
	}else{
		$("#limite_sforo").val("");
		$("#id_sforo0").css("visibility","hidden");
		$("#id_sforo1").css("visibility","hidden");
		
	}
}
</script>
';
$utente=$_POST['utente'];
$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
