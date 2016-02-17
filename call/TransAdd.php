<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_trans'];
$rs_usr = $_POST['rs_usr'];
$lista_negozi_trasf=genera_lista_negozi_trasferta($id_trasf);

$data_da_qry=('select concat(concat(to_char(data_da,\'yyyy,\'),to_number(to_char(data_da,\'mm\'))-1),to_char(data_da,\',dd\')) as data_da
from psofa.pso_rs_trasf where id_trasf='.$id_trasf);

$data_a_qry=('select concat(concat(to_char(data_a,\'yyyy,\'),to_number(to_char(data_a,\'mm\'))-1),to_char(data_a,\',dd\')) as data_a
from psofa.pso_rs_trasf where id_trasf='.$id_trasf);

$data_da_1_qry=('select concat(concat(to_char(data_da,\'yyyy,\'),to_number(to_char(data_da,\'mm\'))),to_char(data_da,\',dd\')) as data_da_1
from psofa.pso_rs_trasf where id_trasf='.$id_trasf);

$data_a_res=$db->get_data($data_a_qry);
$data_a=$data_a_res[0]['data_a'];

$data_da_res=$db->get_data($data_da_qry);
$data_da=$data_da_res[0]['data_da'];

$data_da_1_res=$db->get_data($data_da_1_qry);
$data_da_1=$data_da_1_res[0]['data_da_1'];
$data_da_2=date_create_from_format('Y,m,d',$data_da_1)->format('d/m/Y');

$dB_ret=$db->get_data('
select
	psofa.pso_seq_rs_dett.nextval as id_dett
from
	dual');
$id_dett=$dB_ret[0]['id_dett'];
$qry='
insert into psofa.pso_rs_dett
            (id_dett
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
			,importo_approvato)
     values
           (\''.$id_dett.'\'
           ,\''.$id_trasf 				.'\'
           ,to_date(\''.$data_da_2.'\',\'dd-mm-yyyy\')
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
           ,\'\'
		   ,\'\'
		   ,\'\'
		   ,\'\'
		   )
		   
';
$db->put_data($qry);
$lista_natura=lista_natura_usr('',$rs_usr);
$out1='

<div id="transazione">
<table class="fix green" width="100%">
		<tbody>
		<tr>
			<th colspan=2>Data</th>
			<td colspan=4><input name="data" value="'.$data_da_2.'" type="text" id="f2"></td>
			<th colspan=2>Natura</th>
			<td colspan=4>'.$lista_natura.'</td>
		</tr>
		</tbody>
</table>
</div>
<script>

$(\'#f2\').datepicker({maxDate: new Date('.$data_a.'),minDate: new Date('.$data_da.'),});

update_wallet(\'wall_id_trasf\','.$id_trasf.');
update_wallet(\'wall_id_trans\','.$id_dett.');

</script>
';

$out='
<div id="transazione">
	<script>
		//$("#nuova_transazione").css("display","none");
	</script>
	<input style="display:none" type="text" name="id_trasf" value="'.$id_trasf.'">
	<input style="display:none" type="text" name="id_trans" value="'.$id_dett.'">
	<table class="fix green" width="100%">
		<tbody>
		<tr>
			<th colspan=1>Data</th>
			<td colspan=2><input name="data" value="'.$data_da_2.'" type="text" id="f2"></td>
			<th colspan=1>Natura</th>
			<td colspan=2>'.$lista_natura.'</td>
		</tr>
		<tr style="display:none">
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
		<tr style="display:none">
			<th>
				Importo [&euro;] 
			</th>
			<td>
				<input id="importo" name="importo" type="text" value=0>
			</td>
		</tr>
		<tr style="display:none">
			<th>Importo chiesto a rimborso [&euro;] </th>
			<td><input name="importo_richiesto" id="importo_richiesto" type="text" onchange="calcola_sforo($(this).val())" value=0></td>
		</tr>
		<tr style="display:none">
			<th>Oltre limite spesa [&euro;]</th>
			<td><input id="limite_sforo" type="text" readonly value=""></td>
		</tr>
		<tr style="display:none">
			<th>Metodo di pagamento</th>
			<td>
			<select name="id_pagamento">
			'.
				lista_pagamenti(0).
			'
			</select>
			</td>
			<th>Fattura / Scontrino</th>
			<td>
			<select name="tipo_giustificativo">'.
			lista_giustificativi(0).
			'</select>
			</td>
			<th>Allegato Fattura/Scontrino</th>
			<td>
			<input name="giustificativo" type="text"  id="file_0">
			<form class="file-form" method="post" enctype="multipart/form-data">
				Carica File:
				<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
				<input id="upload-button0" type="submit" value="Carica" name="submit">
			</form>
			</td>
		</tr>
		<tr style="display:none">
			<th>pre-Approvazione Allegata</th>
			<td>
			<input name="pre_approvazione" type="text"  id="file_1">
			<form class="file-form" method="post" enctype="multipart/form-data">
				Carica Mail:
				<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
				<input id="upload-button1" type="submit" value="Carica" name="submit">
			</form>
			</td>
			<th id="id_sforo0">Approvazione sforo Allegata</th>
			<td id="id_sforo1">
			<input name="approvazione_sforo"  type="text" id="file_2">
			<form class="file-form" method="post" enctype="multipart/form-data">
				Carica Mail:
				<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
				<input id="upload-button2" type="submit" value="Carica" name="submit">
			</form>
			</td>
		</tr>
		<tr style="display:none">
			<th>Note</th>
			<td>
			<input class="key_prevented" type="text" name="note">
			</td>
		</tr>
		<tr>
		<td style="text-align:center" colspan=6>
			<button style="display:none" onclick="pi.requestQ(\'transazione\',\'Trans_Edit_Db\')" style="cursor:pointer;" class="save"><div>Salva</div></button>
			<button onclick="pi.requestQ(\'wallet\',\'Trans_Del\')" style="cursor:pointer;" class="del"><div>Annulla</div></button>
		</td>
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


$(\'#f2\').datepicker({maxDate: new Date('.$data_a.'),minDate: new Date('.$data_da.'),});

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
$pr->add_script('pi.requestQLoaderOpen("trasf_id","Trans_Load_2_Refresh");');
$pr->add_html('container',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
