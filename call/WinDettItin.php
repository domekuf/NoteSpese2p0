<?//
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];
$i=0;
$qry1='select count(*) as c from
psofa.pso_rs_dett_itin
where id_dett='.$id_dett;
$results1=$db->get_data($qry1);
$count=$results1[0]['c'];
if($count==0){
	$qry_ins='insert into psofa.pso_rs_dett_itin
	(id_trasf, id_dett, id_tappa, luogo, latitudine,
       longitudine, data, km, costo_km, pedaggio)
	select \''.$id_trasf.'\',\''.$id_dett.'\',psofa.pso_seq_rs_dett_itin.nextval,luogo,\'0\',
            \'0\',data,\'0\',to_number(\'0.21\',\'9.99\'),\'0\'
	from psofa.pso_rs_trasf_itin
	where id_trasf='.$id_trasf;
	$db->put_data($qry_ins);
}
$out='
<div  style="display:none" id="itin_wallet">
	Debug Purpose:
	luogo : <input id="luogo_str" type = "text" name="luogo">
	data : <input id="data_str" type = "text" name="data">
	kms : <input id="kms_str" type = "text" name="kms">
	Q: <input type = "text" name="Q" value="WinDettItinDb">
	IdTrasf: <input type = "text" name="id_trasf" value="'.$id_trasf.'">
	IdDett: <input type = "text" name="id_dett" value="'.$id_dett.'">
	Count: <input type = "text" name="count" value="'.$count.'">
	Query: <input type = "text" name="qry3" value="'.$qry3.'">
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
				psofa.pso_rs_dett_itin
			where
				id_dett='.$id_dett.'
				order by data_2';
		$results2=$db->get_data($qry2);
		foreach($results2 as $v2){
		$id_tappa=$v2['id_tappa'];
		$luogo=$v2['luogo'];
		$data=$v2['data'];
		$out.='
			<tr id="tappa_id_'.$i.'">
			<th>Luogo</th>
			<td><input readonly class="key_prevented" onchange="tappa_edit('.$i.')" id="luogo_id_'.$i.'" name="luogo" type="text" value="'.$luogo.'" /></td>
			<td>
			<select id="sel_neg_trasf_itin_'.$i.'" onchange="Trasf_Itin_Load_Select('.$i.')"><option selected value="">Negozio</option>
			'.genera_lista_negozi_trasferta($id_trasf).'
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
	<td style="display:none" id="button_cont">
	<button onclick="dett_tappa_add('.$i.')" style="cursor:pointer;" class="plus">
		<div>Nuova tappa</div>
	</button>
	</td>
	<td>
	Totale [Km] : <input type="text" id="tot_km"></input>
	<button id="calc" class="reload" style="cursor:pointer;">
		<div>Calcola Km</div>
	</button>
	</td>
	<td>'.($rs_usr!=0?'
	<button id="win_auto_save" onclick="pi.requestWinOpen(\'itin_wallet\')" style="cursor:pointer;display:none" class="save">
		<div>Salva Itinerario</div>
	</button>':'
	
		<div id="win_auto_save"></div>
	').'
	</td></tr>
	<tr><td>
	
	</td></tr></tbody>
	</table>
	<div style="height:550px" id="map">
	
	</div>

<script type="text/javascript">
key_prevent("key_prevented");
function intializer(){
	luogo=$("#luogo_str").val().split(":");
	data=$("#data_str").val().split(":");
	kms=$("#kms_str").val().split(":");
	console.log(data);
	console.log(luogo);
}

var luogo;
var data;
var kms;
intializer();


function assign_go(id,q){
	$(\'#qq\').val(q);
	//$(\'#data_hid_\'+id).val($(\'#data_id_\'+id).val());
	//alert($(\'#data_hid_\'+id).val());
	//$(\'#luogo_hid_\'+id).val($(\'#luogo_id_\'+id).val())
	pi.requestWinOpen(\'itin_wallet\'+id)
}

//var googleResp=invokeWs("http://maps.googleapis.com/maps/api/directions/json?origin=ravenna&destination=cesena&key=AIzaSyCKAjdzzT93RxNe5LjAigHNCQtVTGGAba8");
initMap();
</script>



';
$pr->add_win(1000,0,true,'Gestisci Itinerario',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>