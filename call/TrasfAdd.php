<?
$login_utente = $_POST['login_utente'];
$out='
<div id="trasferta">
	<input type="hidden" name="id_trasf">
	<input type="hidden" name="Q" value="TrasfAddDb">
	<table width="100%">
		<tbody>
		<tr>
			<th>Nome</th>
			<td><input name="login_utente" type="text" value="'.$login_utente.'" readonly></input></td>
		</tr>
		<tr>
			<th>Breve Desrizione / Scopo Missione</th>
			<td><input name="desc_trasf" type="text" ></input></td>
		</tr>
		<tr>
			<td colspan=2><button onclick="pi.requestWinOpen(\'trasferta\')" style="cursor:pointer;" class="save"><div>Salva Trasferta</div></button></td>
		</tr>
		</tbody>
	</table>
</div>
';
$htmlpath= module_path().'html/trasf/';
$qrypath= module_path().'qry/trasf/';
$qry_radio=carica_file($qrypath.'radioButton.sql');
$interface=carica_file($htmlpath.'trasfAdd.html');
$interface=str_replace('[id_container]','trasferta',$interface);
$interface=str_replace('[save_call]','TrasfAddDb',$interface);
$interface=str_replace('[save]','pi.requestWinOpen(\'trasferta\')',$interface);
$interface=str_replace('[face]','alert',$interface);
$interface=str_replace('[content]','Sembra che tu non abbia inserito la descrizione...',$interface);
$interface=str_replace('[err]','alert("Sembra che tu non abbia inserito la descrizione...")',$interface);
$interface=str_replace('[radio_button]',qry2rad($qry_radio,'id_gruppo','descrizione','id_gruppo'),$interface);
$interface=str_replace('[login_utente]',$login_utente,$interface);

$utente=$_POST['utente'];

$pr->add_win(600,0,true,'Inserisci nuova trasferta',$interface)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
