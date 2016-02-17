<?//
$id_trasf = $_POST['id_trasf'];
$i=0;
$out='
<div style="display:none" id="itin_wallet">
	Debug Purpose:
	luogo : <input id="luogo_str" type = "text" name="luogo">
	data : <input id="data_str" type = "text" name="data">
	Q: <input type = "text" name="Q" value="TrasfItinDb">
	IdTrasf: <input type = "text" name="id_trasf" value="'.$id_trasf.'">
</div>
	<table width="100%">
		<tbody id="list">';
		$qry2='	select
			id_trasf
			,id_tappa
			,luogo
			,to_char(data,\'dd/mm/yyyy\') as data
			,data as data_2
			from
				psofa.pso_rs_trasf_itin
			where
				id_trasf='.$id_trasf.'
				order by data_2';
		$results2=$db->get_data($qry2);
		foreach($results2 as $v2){
		$id_tappa=$v2['id_tappa'];
		$luogo=$v2['luogo'];
		$data=$v2['data'];
		$out.='
			<tr id="tappa_id_'.$i.'">
			<th>Luogo</th>
			<td><input class="key_prevented" onchange="tappa_edit('.$i.')" id="luogo_id_'.$i.'" name="luogo" type="text" value="'.$luogo.'" /></td>
			<td>
			<select id="sel_neg_trasf_itin_'.$i.'" onchange="Trasf_Itin_Load_Select('.$i.')"><option selected value="">Negozio</option>
			'.$lista_negozi.'
			</select>
			</td>
			<th>Data</th>
			<td><input onchange="tappa_edit('.$i.')"  id="data_id_'.$i.'" name="datatime" type="text" value="'.$data.'"/></td>
			<script>configure('.$i.',\''.$luogo.'\',\''.$data.'\');</script>
			<td>
			<button onclick="tappa_del('.$i.')" style="cursor:pointer;" class="del icon">
			<div></div>
			</button>
			</td>
			</tr>';
		$i++;
		}
		$out.='
		</tbody>
		
	</table>
	<table  width="100%" style="text:align:center">
	<tbody><tr>
	<td id="button_cont">
	<button onclick="tappa_add('.$i.')" style="cursor:pointer;" class="plus">
		<div>Nuova tappa</div>
	</button>
	</td>
	<td >
	<button onclick="pi.requestWinOpen(\'itin_wallet\')" style="cursor:pointer;" class="save">
		<div>Salva Itinerario</div>
	</button>
	</td></tr></tbody>
	</table>

<script type="text/javascript">
key_prevent("key_prevented");
function intializer(){
	luogo=$("#luogo_str").val().split(":");
	data=$("#data_str").val().split(":");
	console.log(data);
	console.log(luogo);
}

var luogo;
var data;
intializer();


function assign_go(id,q){
	$(\'#qq\').val(q);
	//$(\'#data_hid_\'+id).val($(\'#data_id_\'+id).val());
	//alert($(\'#data_hid_\'+id).val());
	//$(\'#luogo_hid_\'+id).val($(\'#luogo_id_\'+id).val())
	pi.requestWinOpen(\'itin_wallet\'+id)
}
</script>
';
$pr->add_win(1000,0,true,'Gestisci Itinerario',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>