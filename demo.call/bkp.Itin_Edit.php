<?//
$id_trasf = $_POST['id_trasf'];
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
<div id="tappa_add">
	<table width="100%">
		<tbody>';
		$qry2='	select
			id_trasf
			,id_tappa
			,luogo
			,to_char(data,\'yyyy-mm-dd\') as data
			from
				psofa.pso_rs_trasf_itin
			where
				id_trasf='.$id_trasf.'
				order by data';
		$results2=$db->get_data($qry2);
		foreach($results2 as $v2){		
		$out.='<tr>
			<th>Luogo</th>
			<td><input id="luogo_id_'.$v2['id_tappa'].'" name="luogo" type="text" value="'.$v2['luogo'].'" /></td>
			<td>
			<select onchange="$(\'#luogo_id_'.$v2['id_tappa'].'\').val($(this).val())"><option selected value="">Negozio</option>
			'.$lista_negozi.'
			</select>
			</td>
			<th>Data</th>
			<td><input id="data_id_'.$v2['id_tappa'].'" name="data" type="date" value="'.$v2['data'].'" /></td>
			<td><button onclick="assign_go('.$v2['id_tappa'].')" style="cursor:pointer;" class="save icon"><div></div></button><button onclick="pi.requestWinOpen(\'tappa_del'.$v2['id_tappa'].'\')" style="cursor:pointer;" class="del icon"><div></div></button></td>
			<div id="tappa_edit'.$v2['id_tappa'].'">
			<input type="hidden" name="id_tappa" value="'.$v2['id_tappa'].'">
			<input type="hidden" name="luogo" 	id="luogo_hid_'.$v2['id_tappa'].'">
			<input type="hidden" name="datatime" 	id="data_hid_'.$v2['id_tappa'].'">
			<input type="hidden" name="Q" value="Init_Tappa_Edit">
			</div>
			<div id="tappa_del'.$v2['id_tappa'].'">
			<input type="hidden" name="Q" value="Init_Tappa_Del">
			<input type="hidden" name="id_tappa" value="'.$v2['id_tappa'].'">
			</div>
		</tr>';
		}
		$out.='
			<tr >
			<input type="hidden" name="id_trasf" value="'.$id_trasf.'">
			<input type="hidden" name="Q" value="Init_Tappa_Add">
			<th>Luogo</th>
			<td class="orange"><input id="luogo_id" name="luogo" type="text" value="Nuova Tappa" /></td>
			<td class="orange">
			<select onchange="$(\'#luogo_id\').val($(this).val())"><option selected value="">Negozio</option>
			'.$lista_negozi.'
			</select>
			</td>
			<th>Data</th>
			<td class="orange"><input type="hidden" name="datatime" value="2015-12-12" id="data_hid"><input id="data_id" onchange="$(\'#data_hid\').val($(\'#data_id\').val())" type="date" value="" /></td>
			<td><button onclick="pi.requestWinOpen(\'tappa_add\')" style="cursor:pointer;" class="plus icon"><div></div></button></td>
			
		</tr>
		</tbody>
	</table>
</div>
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