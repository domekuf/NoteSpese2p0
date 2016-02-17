<?

$login_utente = $_POST['login_utente'];
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$id_natura = $_POST['id_natura'];
$data = $_POST['data'];
$rs_usr = $_POST['rs_usr'];
$lista_negozi_trasf=genera_lista_negozi_trasferta($id_trasf);

$htmlpath= module_path().'html/dettEdit/';
$qrypath= module_path().'qry/dettEdit/';
$jspath= module_path().'js/dettEdit/';
$allpath='https://portal1.poltronesofa.com/extension/RimborsiSpese/Ced/';

//$p=$htmlpath.$rs_usr.'dettEdit.html';
//$f=fopen($p,'r');
//$dettEdit=fread($f,filesize($p));
if(file_exists($htmlpath.$rs_usr.'dettEdit'.$id_natura.'.html')){
	$dettEdit=carica_file($htmlpath.$rs_usr.'dettEdit'.$id_natura.'.html');
}else{
	$dettEdit=carica_file($htmlpath.$rs_usr.'dettEdit.html');
}
$dettEdit=str_replace('[voce_menu]',get_natura($id_natura),$dettEdit);
$dettEdit=str_replace('[del]','pi.requestQ(\'wallet\',\'DettDel\')',$dettEdit);
$dettEdit=str_replace('[del_hotel]','pi.requestQ(\'container\',\'DettDelHotel\')',$dettEdit);
$dettEdit=str_replace('[go]','pi.requestQ(\'container\',\'DettEditDb\')',$dettEdit);
$dettEdit=str_replace('[cancel]','pi.requestQ(\'wallet\',\'DettLoad\')',$dettEdit);
$dettEdit=str_replace('[go_hotel]','pi.requestQ(\'container\',\'DettEditHotelDb\')',$dettEdit);
$dettEdit=str_replace('[costokm]','pi.requestQ(\'wallet\',\'WinDettItin\')',$dettEdit);
$dettEdit=str_replace('[detthotel]','pi.requestQ(\'wallet\',\'WinDettHotel\')',$dettEdit);
$dettEdit=str_replace('[dett_fattura]','pi.requestQ(\'wallet\',\'WinDettFatt\')',$dettEdit);

//gestione soglie personalizzate
$qry_soglie=carica_file($qrypath.'sogliePers.sql');
$qry_soglie=str_replace('[login_utente]',$login_utente,$qry_soglie);
$qry_soglie=str_replace('[id_natura]',$id_natura,$qry_soglie);
$qry_soglie=str_replace('[id_trasf]',$id_trasf,$qry_soglie);
$res_soglie=$db->get_data($qry_soglie);
foreach($res_soglie as $v){
	$dettEdit=str_replace('[soglia]',$v['soglia'],$dettEdit);
}


$qry=carica_file($qrypath.'DettEdit.sql');
$qry=str_replace('[id_dett]',$id_dett,$qry);
$results=$db->get_data($qry);

$qry2=carica_file($qrypath.'colonne.sql');
$res2=$db->get_data($qry2);
foreach($results as $v){
	$dettEdit=str_replace('[no_giustificativo_checked]',$v['no_giustificativo']=='Y'?'checked':'',$dettEdit);
	$dettEdit=str_replace('[tipo_giustificativo_select]',lista_giustificativi($v['tipo_giustificativo']),$dettEdit);
	$dettEdit=str_replace('[id_pagamento_select]',lista_pagamenti($v['id_pagamento']),$dettEdit);
	$dettEdit=str_replace('[select_luogo]',$lista_negozi_trasf,$dettEdit);
	$dettEdit=str_replace('[login_utente]',$login_utente,$dettEdit);
foreach($res2 as $v2){
	$nomecampo=trim(strtolower($v2['column_name']));
	$dettEdit=str_replace('['.$nomecampo.']',$v[$nomecampo],$dettEdit);
}
}

$out0=$dettEdit;

//$data_da_qry=('select concat(concat(to_char(data_da,\'yyyy,\'),to_number(to_char(data_da,\'mm\'))-1),to_char(data_da,\',dd\')) as data_da
//from psofa.pso_rs_trasf where id_trasf='.$id_trasf);
//
//$data_a_qry=('select concat(concat(to_char(data_a,\'yyyy,\'),to_number(to_char(data_a,\'mm\'))-1),to_char(data_a,\',dd\')) as data_a
//from psofa.pso_rs_trasf where id_trasf='.$id_trasf);
//
//$data_a_res=$db->get_data($data_a_qry);
//$data_a=$data_a_res[0]['data_a'];
//
//$data_da_res=$db->get_data($data_da_qry);
//$data_da=$data_da_res[0]['data_da'];
//$qry='
//select a.id_dett, a.id_trasf, to_char(data, \'dd-mm-yyyy\')as data, a.id_natura, a.luogo, a.importo,
//       a.importo_richiesto, a.limite_spesa, a.id_pagamento,
//       a.tipo_giustificativo, a.giustificativo, a.pre_approvazione,
//       a.approvazione_sforo, a.note, a.importo_approvato, a.id_hotel, a.id_hotel_padre, a.no_giustificativo
//	from psofa.pso_rs_dett a 
//	where id_dett='.$id_dett;
//$result=$db->get_data($qry);
//foreach($result as $v){
//$data 				= $v['data'];
//$id_natura 			= $v['id_natura'];
//$luogo 				= $v['luogo'];
//$importo 			= db2pi($v['importo']);
//$importo_richiesto 	= db2pi($v['importo_richiesto']);
//$limite_spesa 		= db2pi($v['limite_spesa']);
//$id_pagamento 		= $v['id_pagamento'];
//$tipo_giustificativo= $v['tipo_giustificativo'];
//$giustificativo		= $v['giustificativo'];
//$pre_approvazione   = $v['pre_approvazione'];
//$approvazione_sforo = $v['approvazione_sforo'];
//$note				= $v['note'];				
//$importo_approvato  = db2pi($v['importo_approvato']);
//$id_hotel			= $v['id_hotel'];
//$id_hotel_padre		= $v['id_hotel_padre'];
//$tmp_no_giustificativo	= $v['no_giustificativo'];
//$no_giustificativo = ($tmp_no_giustificativo==' --- '?'N':$tmp_no_giustificativo);
//$id_hotel_padre = ($id_hotel_padre==' --- '?0:$id_hotel_padre);
//$id_hotel = ($id_hotel==' --- '?0:$id_hotel);
//$diff_over_budget = $importo_richiesto-$limite_spesa;
//}
//$lista_natura=lista_natura_usr($id_natura,$rs_usr,0);
//$out='
//<div id="transazione">
//	<script>
//		$("#nuova_transazione").css("display","block");
//	</script>
//	<input style="display:block" type="text" name="id_trasf" value="'.$id_trasf.'">
//	<input style="display:block" type="text" name="id_trans" value="'.$id_dett.'">
//	<input style="display:block" type="text" 	id="id_hotel" name="id_hotel" value="'.$id_hotel.'">
//	<input style="display:block" type="text" 	id="id_hotel_padre" name="id_hotel_padre" value="'.$id_hotel_padre.'">
//	<table class="fix orange" width="100%">
//		<tbody>
//			<tr>
//				<th colspan=2>Data</th>
//				<td colspan=4><input readonly value="'.$data.'" name="data" type="text"></td>
//			</tr>
//			<tr>
//				<th colspan=2>Natura</th>
//				<td colspan=4>'.$lista_natura.crea_pulsante($id_natura).'</td>
//			</tr>
//			<tr '.visibility($id_natura,'luogo').' >
//				<th colspan=2 id="luogo_itin_intestazione" style="width:100px">
//					Luogo
//				</th>
//				<td colspan=4>
//				<select name="luogo">
//				<option id="luogo_dett_id" selected value="">Luogo di Riferimento</option>
//				'.$lista_negozi_trasf.'
//				</select>
//				</td>
//				
//			</tr>
//			<tr '.visibility($id_natura,'importo').'>
//				<th >
//					Importo [&euro;] 
//				</th>
//				<td >
//					<input class="numeric" value="'.$importo.'" id="importo" name="importo" type="text">
//				</td>
//			</tr>
//			<tr '.visibility($id_natura,'importo_richiesto').'>
//				<th>Importo chiesto a rimborso [&euro;] </th>
//				<td><input class="numeric" value="'.$importo_richiesto.'" name="importo_richiesto" id="importo_richiesto" type="text" onchange="calcola_sforo($(this).val())">
//				</td>
//			</tr>
//			<tr '.visibility($id_natura,'limite_spesa').'>
//				<th>Oltre limite spesa [&euro;]</th>
//				<td><input class="red_if_more_than_0" id="limite_sforo" type="text" readonly value="'.(($diff_over_budget)>0?($diff_over_budget):'').'"></td>
//			</tr>
//			<tr>
//				<th '.visibility($id_natura,'id_pagamento').'>Metodo di pagamento</th>
//				<td '.visibility($id_natura,'id_pagamento').'>
//				<select name="id_pagamento">
//				'.
//				lista_pagamenti($id_pagamento).
//				'
//				</select>
//				</td>
//				<th '.visibility($id_natura,'tipo_giustificativo').'>Fattura / Scontrino <br>
//				<input type="checkbox" '.($no_giustificativo=='Y'?'checked':'').' name="no_giustificativo">Manca Giustificativo
//				</th>
//				<td '.visibility($id_natura,'tipo_giustificativo').'>
//				<select name="tipo_giustificativo">'.
//				lista_giustificativi($tipo_giustificativo).
//				'</select>
//				</td>
//				<th '.visibility($id_natura,'giustificativo').'>Allegato Fattura/Scontrino</th>
//				<td '.visibility($id_natura,'giustificativo').'>
//					<input  value="'.$giustificativo.'" name="giustificativo" type="text"  id="file_0">
//					<form class="file-form" method="post" enctype="multipart/form-data">
//						Carica File:
//						<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
//						<input id="upload-button0" type="submit" value="Carica" name="submit">
//					</form>
//				</td>
//			</tr>
//			<tr>
//				<th '.visibility($id_natura,'pre_approvazione').'>pre-Approvazione Allegata</th>
//				<td '.visibility($id_natura,'pre_approvazione').'>
//					<input value="'.$pre_approvazione.'" name="pre_approvazione" type="text"  id="file_1">
//					<form class="file-form" method="post" enctype="multipart/form-data">
//						Carica Mail:
//						<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
//						<input id="upload-button1" type="submit" value="Carica" name="submit">
//					</form>
//				</td>
//				<th '.visibility($id_natura,'approvazione_sforo').' id="id_sforo0">Approvazione sforo Allegata</th>
//				<td '.visibility($id_natura,'approvazione_sforo').' id="id_sforo1">
//				<input value="'.$approvazione_sforo.'" name="approvazione_sforo"  type="text" id="file_2">
//				<form class="file-form" method="post" enctype="multipart/form-data">
//					Carica Mail:
//					<input class="file-select" type="file" name="files[]" id="fileToUpload" multiple>
//					<input id="upload-button2" type="submit" value="Carica" name="submit">
//				</form>
//				</td>
//			</tr>
//			<tr '.visibility($id_natura,'note').'>
//				<th>Note</th>
//				<td>
//				<input class ="key_prevented" value="'.$note.'" type="text" name="note">
//				</td>
//			</tr>
//			<tr>
//			<td style="text-align:center" colspan=6>'.($id_hotel==0?'
//				<button onclick="pi.requestQ(\'transazione\',\'Trans_Edit_Db\')" style="cursor:pointer;" class="save"><div>Salva</div></button>
//				<button onclick="pi.requestQ(\'wallet\',\'Trans_Del\')" style="cursor:pointer;" class="del"><div>Elimina</div></button>
//			':'').'
//				<button onclick="pi.requestQ(\'wallet\',\'Trans_Load_2_Close\')" style="cursor:pointer;" class="cancel"><div>Annulla</div></button>
//			</td>
//			</tr>
//		</tbody>
//	</table>
//</div>
//
//<script type="text/javascript">
//if($(".red_if_more_than_0").val()>0)
//{
//	$(".red_if_more_than_0").css("background-color","#C32D34").css("color", "white");
//}
//
//key_prevent("key_prevented");
//function calcola_sforo(importo_richiesto){
//	var soglia=100;
//	if(importo_richiesto>soglia){
//		$("#limite_sforo").css("background-color","red","color","white").val(importo_richiesto-soglia);
//		$("#id_sforo0").css("visibility","visible");
//		$("#id_sforo1").css("visibility","visible");
//	}else{
//		$("#limite_sforo").css("background-color","white","color","black").val("");
//		$("#id_sforo0").css("visibility","hidden");
//		$("#id_sforo1").css("visibility","hidden");
//		
//	}
//}
//
//
//$(\'#f2\').datepicker({maxDate: new Date('.$data_a.'),minDate: new Date('.$data_da.'),});
//
//update_wallet(\'wall_id_trasf\','.$id_trasf.');
//update_wallet(\'wall_id_trans\','.$id_dett.');
//update_wallet(\'wall_id_hotel\','.$id_hotel.');
//update_wallet(\'wall_id_hotel_padre\','.$id_hotel_padre.');
//
//number_only();
//</script>
//<script>
//var form = [];
//var fileSelect = [];
//var uploadButton = [];';
//// questo for scrive il codice javascript per gestire l'upload ajax dei tre form
//for($i=0;$i<3;$i++){
//$out.='
//form['.$i.'] = document.getElementsByClassName("file-form")['.$i.'];
//console.log(form['.$i.']);
//fileSelect['.$i.'] = document.getElementsByClassName("file-select")['.$i.'];
//uploadButton['.$i.'] = $("#upload-button'.$i.'");
//form['.$i.'].onsubmit = function (event) {
//  event.preventDefault();
//
//	// Update button text.
//	uploadButton['.$i.'].val("Caricamento...");
//	// Get the selected files from the input.
//	var files = fileSelect['.$i.'].files;
//	// Create a new FormData object.
//	var formData = new FormData();
//	// Loop through each of the selected files.
//	for (var i = 0; i < files.length; i++) {
//	var file = files[i];
//	
//	// Check the file type.
//	//if (!file.type.match(\'image.*\')) {
//	//	continue;
//	//}
//	
//	// Add the file to the request.
//	var final_filename=$("#wall_login_utente").val()+"_"+"all'.$i.'_"+$("#wall_id_trasf").val()+"_"+$("#wall_id_trans").val()+"_"+file.name;
//	formData.append("files[]", file, final_filename);
//	$("#file_'.$i.'").val(final_filename);
//	}
//	// Files
//	formData.append(name, file);
//	
//	// Blobs
//	//formData.append(name, blob, filename);
//	
//	// Strings
//	//formData.append(name, value, filename);    
//	// Set up the request.
//	var xhr = new XMLHttpRequest();
//	
//	// Open the connection.
//	xhr.open("POST", "/upload/upload4.php", true);
//	// Set up a handler for when the request finishes.
//	xhr.onload = function () {
//		//alert("open");
//	if (xhr.status === 200) {
//		//alert("File Caricati");
//		// File(s) uploaded.
//		uploadButton['.$i.'].val("File Caricato!");
//	} else {
//		alert("Errore, contattare il CED!");
//	}
//	};
//	// Send the Data.
//	xhr.send(formData);
//  
//}';}
//
//$out.='</script>
//';
//$utente=$_POST['utente'];
//$pr->add_script('pi.requestQLoaderOpen("wallet","Trans_Load_2_Refresh");');
$pr->add_html('container',$out0)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>