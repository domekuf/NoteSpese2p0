<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_trans'];
$rs_usr = $_POST['rs_usr'];

$lista_negozi_trasf=genera_lista_negozi_trasferta($id_trasf);
$result=$db->get_data('
	select a.id_dett, a.id_trasf, to_char(data, \'dd-mm-yyyy\')as data, a.id_natura, a.luogo, a.importo,
       a.importo_richiesto, a.limite_spesa, a.id_pagamento,
       a.tipo_giustificativo, a.giustificativo, a.pre_approvazione,
       a.approvazione_sforo, a.note, a.importo_approvato, a.id_hotel, a.qta_soglia
	from psofa.pso_rs_dett a 
	where id_dett='.$id_dett);
foreach($result as $v){
$data 				= $v['data'];
$id_natura 			= $v['id_natura'];
$luogo 				= $v['luogo'];
$importo 			= db2pi($v['importo']);
$importo_richiesto 	= db2pi($v['importo_richiesto']);
$limite_spesa 		= db2pi($v['limite_spesa']);
$id_pagamento 		= $v['id_pagamento'];
$tipo_giustificativo= $v['tipo_giustificativo'];
$giustificativo		= $v['giustificativo'];
$pre_approvazione   = $v['pre_approvazione'];
$approvazione_sforo = $v['approvazione_sforo'];
$note				= $v['note'];				
$importo_approvato  = $v['importo_approvato'];
$id_hotel			= $v['id_hotel'];
$qta_soglia			= $v['qta_soglia'];
$diff_over_budget = $importo_richiesto-$limite_spesa;
}
$lista_natura=lista_natura_usr($id_natura,$rs_usr,0);
$out='
<div id="transazione">
	<script>
		$("#nuova_transazione").css("display","block");
	</script>
	<input style="display:none" type="text" name="id_trasf" value="'.$id_trasf.'">
	<input style="display:none" type="text" name="id_trans" value="'.$id_dett.'">
	<input style="display:none" type="text" 	id="id_hotel" name="id_hotel" value="'.$id_hotel.'">
	<table class="fix orange" width="100%">
		<tbody>
			<tr>
				<th colspan=2>Data</th>
				<td colspan=4><input readonly value="'.$data.'" name="data" type="text"></td>
			</tr>
			<tr>
				<th colspan=2>Natura</th>
				<td colspan=3>'.$lista_natura.crea_pulsante($id_natura).'</td>
				<th colspan=3>Quantit&agrave; (se prevista) : '.$qta_soglia.'</th>
			</tr>
			<tr>
				<th colspan=2 id="luogo_itin_intestazione" style="width:100px">
					Luogo
				</th>
				<td colspan=4>
				<select name="luogo">
				<option id="luogo_dett_id" selected value="">Luogo di Riferimento</option>
				'.$lista_negozi_trasf.'
				</select>
				</td>
				
			</tr>
			<tr>
				<th>
					Importo [&euro;] 
				</th>
				<td>
					<input readonly value="'.$importo.'" id="importo" name="importo" type="text">
				</td>
			</tr>
			<tr>
				<th>Importo chiesto a rimborso [&euro;] </th>
				<td><input readonly value="'.$importo_richiesto.'" name="importo_richiesto" type="text" onchange="calcola_sforo($(this).val())">
				</td>
			</tr>
			<tr>
				<th>Oltre limite spesa [&euro;]</th>
				<td><input class="red_if_more_than_0" id="limite_sforo" type="text" readonly value="'.(($diff_over_budget)>0?($diff_over_budget):'').'"></td>
			</tr>
			<tr>
				<th>Metodo di pagamento</th>
				<td>
				<select name="id_pagamento">
				'.
				lista_pagamenti($id_pagamento).
				'
				</select>
				</td>
				<th>Fattura / Scontrino</th>
				<td>
				<select name="tipo_giustificativo">'.
				lista_giustificativi($tipo_giustificativo).
				'</select>
				</td>
				<th>Allegato Fattura/Scontrino</th>
				<td>
				<input value="'.$giustificativo.'" name="giustificativo" type="text"  id="file_0">
				<form class="file-form" method="post" enctype="multipart/form-data">
					Carica File:
					<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
					<input id="upload-button0" type="submit" value="Carica" name="submit">
				</form>
				</td>
			</tr>
			<tr>
				<th>pre-Approvazione Allegata</th>
				<td>
				<input value="'.$pre_approvazione.'" name="pre_approvazione" type="text"  id="file_1">
				<form class="file-form" method="post" enctype="multipart/form-data">
					Carica Mail:
					<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
					<input id="upload-button1" type="submit" value="Carica" name="submit">
				</form>
				</td>
				<th id="id_sforo0">Approvazione sforo Allegata</th>
				<td id="id_sforo1">
				<input value="'.$approvazione_sforo.'" name="approvazione_sforo"  type="text" id="file_2">
				<form class="file-form" method="post" enctype="multipart/form-data">
					Carica Mail:
					<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
					<input id="upload-button2" type="submit" value="Carica" name="submit">
				</form>
				</td>
			</tr>
			<tr>
				<th>Note</th>
				<td>
				<input value="'.$note.'" type="text" name="note">
				</td>
			</tr>
			<tr>
			<td style="text-align:center;display:none" colspan=6>
				<button onclick="pi.requestQ(\'transazione\',\'Amm_Trans_Edit_Db\')" style="cursor:pointer;" class="save"><div>Salva</div></button>
				<button onclick="pi.requestQ(\'wallet\',\'Amm_Trans_Del\')" style="cursor:pointer;" class="del"><div>Elimina</div></button>
				<button onclick="pi.requestQ(\'wallet\',\'Amm_Trans_Load\')" style="cursor:pointer;" class="cancel"><div>Annulla</div></button>
			</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
if($(".red_if_more_than_0").val()>0)
{
	$(".red_if_more_than_0").css("background-color","#C32D34").css("color", "white");
}

key_prevent("key_prevented");
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


$(\'#f2\').datepicker();

update_wallet(\'wall_id_trasf\','.$id_trasf.');
update_wallet(\'wall_id_trans\','.$id_dett.');

</script>
<script>
var form = [];
var fileSelect = [];
var uploadButton = [];';
// questo for scrive il codice javascript per gestire l'upload ajax dei tre form
for($i=0;$i<3;$i++){
$out.='
form['.$i.'] = document.getElementsByClassName("file-form")['.$i.'];
console.log(form['.$i.']);
fileSelect['.$i.'] = document.getElementsByClassName("file-select")['.$i.'];
uploadButton['.$i.'] = $("#upload-button'.$i.'");
form['.$i.'].onsubmit = function (event) {
  event.preventDefault();

	// Update button text.
	uploadButton['.$i.'].val("Caricamento...");
	// Get the selected files from the input.
	var files = fileSelect['.$i.'].files;
	// Create a new FormData object.
	var formData = new FormData();
	// Loop through each of the selected files.
	for (var i = 0; i < files.length; i++) {
	var file = files[i];
	
	// Check the file type.
	//if (!file.type.match(\'image.*\')) {
	//	continue;
	//}
	
	// Add the file to the request.
	var final_filename=$("#wall_login_utente").val()+"_"+"all'.$i.'_"+$("#wall_id_trasf").val()+"_"+$("#wall_id_trans").val()+"_"+file.name;
	formData.append("files[]", file, final_filename);
	$("#file_'.$i.'").val(final_filename);
	}
	// Files
	formData.append(name, file);
	
	// Blobs
	//formData.append(name, blob, filename);
	
	// Strings
	//formData.append(name, value, filename);    
	// Set up the request.
	var xhr = new XMLHttpRequest();
	
	// Open the connection.
	xhr.open("POST", "/upload/upload4.php", true);
	// Set up a handler for when the request finishes.
	xhr.onload = function () {
		//alert("open");
	if (xhr.status === 200) {
		//alert("File Caricati");
		// File(s) uploaded.
		uploadButton['.$i.'].val("File Caricato!");
	} else {
		alert("Errore, contattare il CED!");
	}
	};
	// Send the Data.
	xhr.send(formData);
  
}';}

$out.='</script>
';
$utente=$_POST['utente'];
$pr->add_script('pi.requestQLoaderOpen("wallet","Amm_Trans_Load_2_Refresh");');
$pr->add_html('container1',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>