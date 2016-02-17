<?
$login_utente = $_POST['login_utente'];
$out='
<div id="trasferta">
	<input type="hidden" name="id_trasf">
	<input type="hidden" name="Q" value="Init_Trasf_Add">
	<table width="100%">
		<tbody>
		<tr>
			<th>Nome</th>
			<td><input name="login_utente" type="text" value="'.$login_utente.'"></input></td>
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
$utente=$_POST['utente'];
$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
