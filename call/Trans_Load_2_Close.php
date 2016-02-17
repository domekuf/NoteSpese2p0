<?
$id_trasf = $_POST['id_trasf'];
$div_dati_hid=div_id('trasf_id',input('text','id_trasf','id_trasf',$id_trasf)); 
//queste sono nella _commmon.php, utility per velocizzare html
$n_righe = 5;
$n_colonne = 8;
$qry='
select
    *
from
    psofa.pso_rs_dett
where
	id_trasf='.$id_trasf;
$out='
<style>
.trans{
	width:100px;
	height:100px;
}
</style>
<table class="fix">
<tbody>
<tr><th colspan='.$n_colonne.'>Elenco Transazioni, Trasferta: '.$id_trasf.'</th></tr>
  ';
$results=$db->get_data($qry);
$i=0;
$linea_finita=1;

foreach($results as $v){
if($i==0){$out.='<tr>';}
	$editable=$v['importo_approvato']<=0;
	$out.='
	<td class="trans '.($editable?($v['id_hotel']!=' --- ' || get_natura($v['id_natura'])=="Hotel")?'purple':'orange':'red').'"
	'.($editable?'
	onclick="trans_Edit('.$v['id_dett'].')" 
	style="cursor:pointer"
	':'
	onclick="transAlert()" 
	style="cursor:not-allowed"
	').'
	>
	<table style="text-align:left"
	>
	<tbody>
	<tr><th colspan=2>'.$v['data'].'</th></tr>
	<tr><th colspan=2>'.$nature_id[$v['id_natura']]['voce_menu'].'</th></tr>
	<tr><th colspan=2></th></tr>
	<tr>
	<td>
	'.$v['importo_richiesto'].' &euro;
	</td>
	<td style="text-align:right">'
	//($v['importo_approvato']<=0?'<button class="edit icon" onclick="trans_Edit('.$v['id_dett'].')" style="cursor:pointer;"><div></div></button>':'').
	.'</td>
	</tr>
	</tbody>
	</table>
	</td>';
	$div_dati_hid.=div_id('trans_id'.$v['id_dett'],
	input('text','id_trasf','id_trasf',$id_trasf).
	input('text','id_trans','id_trans',$v['id_dett']));
	//queste sono nella _commmon.php, utility per velocizzare html
$i++;
if($i==$n_colonne){$out.='</tr>';$i=0;$linea_finita=1;}else{$linea_finita=0;}
}
if($linea_finita){
	$out.='<tr>';
}
$out.='
	<td id="nuova_transazione" class="trans green">
	<table style="text-align:left">
	<tbody>
	<tr><th colspan=2>Nuova</th></tr>
	<tr><th colspan=2>Transazione</th></tr>
	<tr><th colspan=2></th></tr>
	<tr>
	<td><button class="plus icon" onclick="pi.requestQ(\'wallet\',\'Trans_Add\')" style="cursor:pointer;"><div></div></button>
	</td>
	<td style="text-align:right"></td>
	</tr>
	</tbody>
	</table>
	</td>
    </tr>';
$out.='</tbody>
</table>';
$pr->add_html('container1','');    //UNICA DIFFERENZA TRA Load_2_Close e Load_2_Refresh
//$pr->add_html('container3',$div_dati_hid);
$pr->add_html('container2',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
