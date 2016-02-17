<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$lista_natura='
<select name="id_natura" onchange="natura_select($(this).val())">
<option value="0">Colazione</option>
<option value="1">Pranzo</option>
<option value="2">Cena</option>
<option value="3">Hotel</option>
<option value="4">Rimborso KM</option>
<option value="5">Autostrada</option>
<option value="6">Viaggio aereo</option>
<option value="7">Viaggio treno</option>
<option value="8">Altro</option>
</select>';
$out='
<div id="transazione">
	<input type="hidden" name="id_trasf" value="'.$id_trasf.'">
	<input type="hidden" name="Q" value="Init_Trans_Add">
	<input type="hidden" name="datatime" value="2015-12-06">
	<table class="fix red" width="100%">
		<tbody>
		<tr>
			<th>Data</th>
			<td><input name="data" type="text" id="f2"></td>
			<th>Natura</th>
			<td>'.$lista_natura.'</td>
			<th id="luogo_itin_intestazione" style="width:100px">
			<select onchange="$(\'#luogo_dett_id\').val($(this).val())"><option selected value="">Luogo di Riferimento</option>
			'.$lista_negozi.'
			</select>
			</th>
			<td><input id="luogo_dett_id" name="luogo" type="text" ></input>
			</td>
		</tr>
		<tr>
			<th>Importo [&euro;] </th>
			<td><input name="importo" type="text" value=0></td>
			<th>Importo chiesto a rimborso [&euro;] </th>
			<td><input name="importo_richiesto" type="text" onchange="calcola_sforo($(this).val())" value=0></td>
			<th>Sforo [&euro;]</th>
			<td><input id="limite_sforo" type="text" readonly value=""></td>
		</tr>
		<tr>
			<th>Metodo di pagamento</th>
			<td>
			<select name="id_pagamento">
			<option value=0>Carta Aziendale</option>
			<option value=1>Carta Personale</option>
			<option value=2>Contanti</option>
			</select>
		</tr>
		<tr>
			</td>
			<th>Tipo Documento</th>
			<td>
			<select name="tipo_giustificativo">
			<option value=0>Fattura</option>
			<option value=1>Scontrino</option>
			<option value=2>Altro</option>
			</select>
			</td>
			<th>Allegato</th>
			<td>
			<input name="giustificativo" type="text">
			</td>
		</tr>
		<tr>
			<th id="id_app0" style="visibility:hidden">pre-Approvazione Allegata</th>
			<td id="id_app1"  style="visibility:hidden">
			<input name="pre_approvazione" type="text">
			</td>
			<th id="id_sforo0" style="visibility:hidden">Approvazione sforo Allegata</th>
			<td id="id_sforo1"  style="visibility:hidden">
			<input name="approvazione_sforo" type="text">
			</td>
		</tr>
		<tr>
			<th>Note</th>
			<td>
			<input type="text" name="note">
			</td>
		</tr>
		<tr>
			<td style="text-align:center" colspan=6><button onclick="pi.request(\'transazione\')" style="cursor:pointer;" class="save"><div>Crea transazione</div></button></td>
		</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
function calcola_sforo(importo_richiesto){
	var soglia=100;
	if(importo_richiesto>soglia){
		$("#limite_sforo").css("background-color","red","color","white").val(importo_richiesto-soglia);
		$("#id_sforo0").css("visibility","visible");
		$("#id_sforo1").css("visibility","visible");
	}else{
		$("#limite_sforo").css("background-color","white","color","black").val("");
		$("#id_sforo0").css("visibility","hidden");
		$("#id_sforo1").css("visibility","hidden");
		
	}
}
function natura_select(id_natura){
	if (id_natura>2){
		$("#id_app0").css("visibility","visible");
		$("#id_app1").css("visibility","visible");
		switch (id_natura)
		{
		case 3:
			pi.requestQ(\'asd\',\'Dett_Win_Hotel\');
			break;
		case 4:
			pi.requestQ(\'asd\',\'Dett_Win_Auto\');
			break;
		case 5:
			pi.requestQ(\'asd\',\'Dett_Win_Auto\');
			break;
		}
	}else{
		$("#id_app0").css("visibility","hidden");
		$("#id_app1").css("visibility","hidden");
	}
}
$(\'#f2\').datepicker();
</script>
';
$utente=$_POST['utente'];
$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
