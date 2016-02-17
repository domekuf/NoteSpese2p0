<?//
$id_trasf = $_POST['id_trasf'];
$id_trans = $_POST['id_trans'];
//$qry1='select
//    *
//from
//    www.www_negozi';
//$results=$db->get_data($qry1);
//$lista_negozi='';
//foreach($results as $v1){
//	$lista_negozi.='<option 
//	value="'.trim($v1['codice']).', '
//			.$v1['citta'].'">'
//			.$v1['citta'].'</option>';
//}
$out='
<div id="hotel_wallet">
Q: <input type="text" name="Q" value="Dett_Hotel_Add">
Importo: <input type="text" id="hotel_importo" name="hotel_importo" value="0">
</div>
	<table style="text-align:left" width="100%">
		<tbody>';
		$out.='
			<tr>
			<th>
				Imponibile Albergo [&euro;]
			</th>
			<td class="orange">
				<input id="Imponibile_Albergo" type="number" onchange="hotel_Calc()" />
			</td>
			</tr>
			
			<tr>
			<th>
				Totale Colazioni [&euro;]
			</th>
			<td class="orange">
				<input id="Totale_Colazioni" type="number" onchange="hotel_Calc()" />
			</td>
			</tr>
			
			<tr>
			<th>
				Altro [&euro;]
			</th>
			<td class="orange">
				<input id="Altro" type="number" onchange="hotel_Calc()" />
			</td>
			</tr>
			
			<tr>
				<th>
					Numero Notti
				</th>
				<td class="orange">
					<input id="Numero_Notti" type="number" onchange="hotel_Calc()" />
				</td>
			</tr>
			
			<tr>
				<th>
					Costo Netto [&euro;]
				</th>
				<td>
					<input id="Costo_Netto" type="number" readonly />
				</td>
			</tr>
			
			<tr>
				<th>
					Costo Netto per Notte [&euro;]
				</th>
				<td>
					<input id="Costo_Netto_Notte" type="number" readonly />
				</td>
			</tr>
			
			<tr>
				<td colspan="6">
					<button onclick="pi.requestWinOpen(\'hotel_wallet\')" style="cursor:pointer;" class="save icon"><div></div></button>
				</td>
			</tr>
		</tbody>
	</table>
<script type="text/javascript">
function assign_go(id){
	//alert(id);
	$(\'#luogo_hid_\'+id).val($(\'#luogo_id_\'+id).val())
	$(\'#data_hid_\'+id).val($(\'#data_id_\'+id).val())
	pi.requestWinOpen(\'tappa_edit\'+id)
}
</script>
';
$pr->add_win(1000,0,true,'Gestisci Itinerario',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>