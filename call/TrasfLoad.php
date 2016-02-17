<?
$login_utente=$_POST['login_utente'];
$data_da=$_POST['data_da'];
$data_a=$_POST['data_a'];
$rs_usr=$_POST['rs_usr'];
$htmlpath= module_path().'html/trasf/';
$qrypath= module_path().'qry/trasf/';

$p=$htmlpath.'trasf.html';
$f=fopen($p,'r');
$s=fread($f,filesize($p));
$s=str_replace('[contabilizza]','',$s);

$p=$htmlpath.'intestazione.html';
$f=fopen($p,'r');
$intestazione=fread($f,filesize($p));

$p=$htmlpath.'new.html';
$f=fopen($p,'r');
$new=fread($f,filesize($p));
$new=str_replace('[add]','pi.requestQ(\'wallet\',\'TrasfAdd\')',$new);

$p=$qrypath.'TrasfLoad.sql';
$f=fopen($p,'r');
$qry=fread($f,filesize($p));
$qry=str_replace('[login_utente]',$login_utente,$qry);

$p=$qrypath.'colonne.sql';
$f=fopen($p,'r');
$qry2=fread($f,filesize($p));

//apertura tabella e utente
$lista_trasferte = str_replace('[login_utente]',$login_utente,$intestazione);
$results=$db->get_data($qry);
foreach($results as $v){
	
	//compilazione campi
	$res2=$db->get_data($qry2);
	$s_tmp=$s;
	foreach($res2 as $v2){
		$nomecampo=trim(strtolower($v2['column_name']));
		$s_tmp=str_replace('['.$nomecampo.']',trim($v[$nomecampo]),$s_tmp);
	}
	
	//gestione itinerario
	$p=$qrypath.'TrasfItin.sql';
	$f=fopen($p,'r');
	$qry3=fread($f,filesize($p));
	$qry3=str_replace('[id_trasf]',$v['id_trasf'],$qry3);
	$res3=$db->get_data($qry3);
	
	$p=$htmlpath.'lista_tappe.html';
	$f=fopen($p,'r');
	$li=fread($f,filesize($p));
	$lista='';
	foreach($res3 as $v3){
		$li_tmp=$li;
		$li_tmp=str_replace('[luogo]',$v3['luogo'],$li_tmp);
		$li_tmp=str_replace('[data]',$v3['data'],$li_tmp);
		$lista.=$li_tmp;
	}
	$s_tmp=str_replace('[lista_tappe]',$lista,$s_tmp);
	
	//buttons
	$s_tmp=str_replace('[del]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'TrasfDel\',\'Eliminare Questa Trasferta?\')',$s_tmp);
	$s_tmp=str_replace('[open]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'DettLoad\')',$s_tmp);
	$s_tmp=str_replace('[edit_itin]','pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'TrasfItinLoad\')"',$s_tmp);
	$s_tmp=str_replace('[submit]','alert(\'submit\')',$s_tmp);
	$s_tmp=str_replace('[allegato]','',$s_tmp);
	
	//ulteriori parametri
	$s_tmp=str_replace('[rs_usr]',$rs_usr,$s_tmp);
	
	$lista_trasferte.=$s_tmp;
	
	//$lista_trasferte .= '<tr class ="blu">
	//	<td>'.$v['desc_trasf'].'</td>
	//	<td>'.$v['data_da'].'</td>
	//	<td>'.$v['data_a'].'</td>
	//	<td onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Itin_Load\')" style="cursor:pointer;" colspan=2>
	//		<div id="trasf_id'.$v['id_trasf'].'"><input type="hidden" name="id_trasf" value="'.$v['id_trasf'].'"/></div>
	//		<table class="std">
	//			<tbody>';
		//$qry2='	select
		//			*
		//		from
		//			psofa.pso_rs_trasf_itin
		//		where
		//		id_trasf='.$v['id_trasf'].'
		//		order by data';
		//$results2=$db->get_data($qry2);
		//foreach($results2 as $v2){		
		//$lista_trasferte.='
		//			<tr>
		//				<td>'.$v2['luogo'].'</td>
		//				<td>'.$v2['data'].'</td>
		//			</tr>';
		//}
		//$lista_trasferte.='
		//		</tbody>
		//	</table>
		//</td>
		//<td style="text-align:center">
		//<button class="search" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trans_Load\')" style="cursor:pointer;"><div>Vedi Dettaglio</div></button>
		//<button class="del" onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Del\',\'Eliminare Questa Trasferta?\')" style="cursor:pointer;"><div>Elimina</div></button>
		//<button onclick="pi.requestQ(\'trasf_id'.$v['id_trasf'].'\',\'Trasf_Itin_Load\')" class="edit" style="cursor:pointer;"><div>Modifica Itinerario</div></button>
		//</td>
	//</tr>';
}
//chiusura tabella e pulsante crea
$lista_trasferte .=$new;
//	<tr onclick="pi.requestQ(\'wallet\',\'Trasf_Add\')" style="cursor:pointer;" class ="fix green">
//		<td style="text-align:center" colspan=8><button onclick="pi.requestQ(\'wallet\',\'Trasf_Add\')" style="cursor:pointer;" class="plus"><div>Inserisci Nuova</div></button></td>
//	</tr>
//	</tbody></table>
//	';
//$pr->add_html('container5',(string)print_r($nature_id));

$pr->add_html('menu_1','');
$pr->add_html('menu_2','');
$pr->add_html('menu_3','');
$pr->add_html('container',$lista_trasferte)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
