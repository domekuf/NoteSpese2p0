<?//
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$rs_usr = $_POST['rs_usr'];
/* numerare le tappe
$qry_to_upd='
select luogo, to_char(data,\'yyyymmdd\') data from psofa.pso_rs_dett_itin
where 1=1
order by data
';

$res_to_upd=$db->get_data($qry_to_upd);

foreach($res_to_upd as $row){
	$qry_upd="update psofa.pso_rs_dett_itin set id_tappa = psofa.pso_seq_rs_dett_itin.nextval where luogo='".$row['luogo']."' and data=to_date('".$row['data']."','yyyymmdd')";
	$db->put_data($qry_upd);
}*/

$htmlpath= 	module_path().'html/dettItin/';
$qrypath= 	module_path().'qry/dettItin/';
$interface=carica_file($htmlpath.'dettItin.html');
$interface=str_replace('[id_trasf]',$id_trasf,$interface);
$interface=str_replace('[id_dett]',$id_dett,$interface);
$interface=str_replace('[save]','pi.requestWinOpen(\'[id_container]\')',$interface);
$interface=str_replace('[save_call]','DettItinTappaSave',$interface);
$interface=str_replace('[id_container]','wincontainer',$interface);
$tappa_tmp=carica_file($htmlpath.'tappa.html');
$qry_dett_itin=carica_file($qrypath."dettItin.sql");
$qry_lista_tappe_trasf=carica_file($qrypath."listaTappeTrasf.sql");
$qry_lista_tappe_trasf=str_replace('[id_trasf]',$id_trasf,$qry_lista_tappe_trasf);
$qry_dett_itin=str_replace('[id_trasf]',$id_trasf,$qry_dett_itin);
$qry_dett_itin=str_replace('[id_dett]',$id_dett,$qry_dett_itin);
$res=$db->get_data($qry_dett_itin);
foreach($res as $tappa){
	$select_negozi_p=qry2sel_filtrabile($qry_lista_tappe_trasf,'luogo','luogo',$tappa['luogo'],'select-negozi-'.$tappa['id_tappa'].'p','voce_menu');
	$select_negozi_a=qry2sel_filtrabile($qry_lista_tappe_trasf,'luogo','luogo',$tappa['luogo'],'select-negozi-'.$tappa['id_tappa'].'a','voce_menu');
	$lista_tappe.=
	str_replace('[id_tappa]',$tappa['id_tappa'],
	str_replace('[id_trasf]',$id_trasf,
	str_replace('[id_dett]',$id_dett,
	str_replace('[luogo]',$tappa['luogo'],
	str_replace('[luogo_a]',$tappa['luogo_a'],
	str_replace('[data]',$tappa['data'],
	str_replace('[luogo_select_p]',$select_negozi_p,
	str_replace('[luogo_select_a]',$select_negozi_a,
	str_replace('[km]',$tappa['km'],
	$tappa_tmp)))))))));
}
$interface=str_replace('[lista_tappe]',$lista_tappe,$interface);
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

$pr->add_script('pi.win.close()');
$pr->add_win(1000,0,true,'Gestisci Itinerario',$interface)->response(); //.serialize($res_sf) risultato della store!
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>