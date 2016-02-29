<?
	include $pr->get('root').'../lib/php.db.php';
	include $pr->get('root').'../lib/php.custom.php';
	
	$qrypath_='/var/www/modules/CED/NoteSpese2p0/call/_common/qry/';
	$htmlpath_='/var/www/modules/CED/NoteSpese2p0/call/_common/html/';
	$db = new PI_DB($_SESSION[$pr->get('MSID')]['db']);
	$db->set_opt('rowindex',false);
	$db->set_opt('lowercase',true);
	$usr_list = 'asd';//parse_ini_file($pr->get('root').'../settings/users.ini',true);
	//$nature_id=parse_ini_file($pr->get('root').'../modules/CED/NoteSpese/nature.ini',true);
	$nature_id=genera_nature_id();
	$pagamenti_id=genera_pagamenti_id();
	$giustificativi_id=genera_giustificativi_id();
	//ksort($usr_list);
	$img_war='<img src=\'/modules/CED/NoteSpese/war.png\'/>';
	$qry0='select
    *
		from
    www.www_negozi';
	$results0=$db->get_data($qry0);
	$lista_negozi='';
	foreach($results0 as $v0){
	$lista_negozi.='<option 
	value="'.trim($v0['codice']).', '
			.$v0['citta'].'">'
			.$v0['citta'].'</option>';
	}
	
	function genera_lista_negozi_trasferta($id_trasf){
		global $db;
		$qry='	select *
				from psofa.pso_rs_trasf_itin
				where id_trasf='.$id_trasf;
		$results=$db->get_data($qry);
		$lista_negozi_trasferta='';
		foreach($results as $v){
			$lista_negozi_trasferta.='<option 
			value="'.trim($v['luogo']).'">'
			.$v['luogo'].'</option>';
		}
		return $lista_negozi_trasferta;
	}
	
	
	function div($arg_1)
	{
    return '<div>'.$arg_1.'</div>';
	}
	function div_id($id_,$arg_1)
	{
    return '<div id="'.$id_.'">'.$arg_1.'</div>';
	}
	function input($type,$id,$name,$value)
	{
    return '<input id="'.$id.'" type="'.$type.'" name="'.$name.'" value="'.$value.'">';
	}
	
	function get_data_qry($qry){
		global $db;
		return $db->get_data($qry);
	}
	
	function lista_natura($sel){
	global $nature_id;
	$out='
	<select name="id_natura" id="sel_natura" oninput="natura_select($(this).val(),$(\'wall_id_trans\').val())">
	<option value="-1">-- seleziona --</option>';
	$results=get_data_qry('select * from psofa.pso_rs_id_natura where nascosta <> \'Y\' order by voce_menu');
	foreach($results as $n){
		$nature_id[$n['id_natura']]=$n['voce_menu'];
		$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
	}
	$out.='</select>';
	//$out2=print_r($nature_id);
	return $out;
	}
	
	function lista_natura_usr($sel,$rs_usr,$enabled=1){
	global $nature_id;
	$out='
	<select '.($enabled?'':'disabled="true"').' name="id_natura" id="sel_natura" oninput="natura_select($(this).val())">
	<option value="-1">-- seleziona --</option>';
	foreach($nature_id as $k => $n){	
		if(($n['id_natura'] != 4 && $n['id_natura'] != 5)){
		$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
		if($n['id_natura'] == '4' && ($rs_usr=='1' || $rs_usr=='0')){
			$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
		if($n['id_natura'] == '5' && ($rs_usr=='2'|| $rs_usr=='0')){
			$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
	}
	$out.='</select>';
	//$out2=print_r($nature_id);
	return $out;
	}
	
	function lista_natura_usr_man($sel,$rs_usr,$enabled=1){
	global $nature_id;
	$out='
	<select '.($enabled?'':'disabled="true"').' name="id_natura" id="sel_natura">
	<option value="-1">-- seleziona --</option>';
	foreach($nature_id as $k => $n){	
		if(($n['id_natura'] != 4 && $n['id_natura'] != 5)){
		$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
		if($n['id_natura'] == '4' && ($rs_usr=='1' || $rs_usr=='0')){
			$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
		if($n['id_natura'] == '5' && ($rs_usr=='2'|| $rs_usr=='0')){
			$out.='<option '. ($sel==$n['id_natura']?'selected':'').' value="'.$n['id_natura'].'">'.$n['voce_menu'].'</option>';
		}
	}
	$out.='</select>';
	//$out2=print_r($nature_id);
	return $out;
	}
	
	
	function lista_giustificativi($sel){
		global $giustificativi_id;
		$out='';
		foreach($giustificativi_id as $n => $k){
			$out.='
			<option value="'.$k['id_giustificativo'].'" 
			'. ($sel==$k['id_giustificativo']?'selected':'').'
			>'.$k['voce_menu'].'</option> ';
		}
		return $out;
	}
	
	function lista_pagamenti($sel){
		global $pagamenti_id;
		$out='';
		foreach($pagamenti_id as $n => $k){
			$out.='
			<option value="'.$k['id_pagamento'].'" 
			'. ($sel==$k['id_pagamento']?'selected':'').'
			>'.$k['voce_menu'].'</option> ';
		}
		return $out;
	}
	
	function genera_nature_id(){
	$results=get_data_qry('select * from psofa.pso_rs_id_natura a join psofa.pso_rs_id_natura_interf b on a.id_natura=b.id_natura where a.nascosta<>\'Y\'  order by voce_menu');
	foreach($results as $n){
		$nature_id[$n['id_natura']]['id_natura']=$n['id_natura'];
		$nature_id[$n['id_natura']]['voce_menu']=$n['voce_menu'];
		$nature_id[$n['id_natura']]['descrizione']=$n['descrizione'];
		$nature_id[$n['id_natura']]['mastro']=$n['mastro'];
		$nature_id[$n['id_natura']]['partitario']=$n['partitario'];
		$nature_id[$n['id_natura']]['soglia']=$n['soglia'];
		//AGGIUNTO 09/12
		$nature_id[$n['id_natura']]['luogo']=$n['luogo'];
		$nature_id[$n['id_natura']]['importo']=$n['importo'];
		$nature_id[$n['id_natura']]['importo_richiesto']=$n['importo_richiesto'];
		$nature_id[$n['id_natura']]['limite_spesa']=$n['limite_spesa'];
		$nature_id[$n['id_natura']]['id_pagamento']=$n['id_pagamento'];
		$nature_id[$n['id_natura']]['tipo_giustificativo']=$n['tipo_giustificativo'];
		$nature_id[$n['id_natura']]['giustificativo']=$n['giustificativo'];
		$nature_id[$n['id_natura']]['pre_approvazione']=$n['pre_approvazione'];
		$nature_id[$n['id_natura']]['approvazione_sforo']=$n['approvazione_sforo'];
		$nature_id[$n['id_natura']]['note']=$n['note'];
		$nature_id[$n['id_natura']]['importo_approvato']=$n['importo_approvato'];
		$nature_id[$n['id_natura']]['qta_soglia']=$n['qta_soglia'];
	}
	//$out2=print_r($nature_id);
	return $nature_id;
	}
	function get_id($natura){
		global $nature_id;
		foreach($nature_id as $v=>$k){
			if(strtolower($k['voce_menu'])==strtolower($natura)){
				return $k['id_natura'];
			}
		}
	}
	
	function get_soglia($natura,$id_trasf){
		global $db, $qrypath_, $htmlpath_;
		$qry_soglie=carica_file($qrypath_.'soglie.sql');
		$qry_soglie=str_replace('[id_trasf]',$id_trasf,$qry_soglie);
		$qry_soglie=str_replace('[id_natura]',get_id($natura),$qry_soglie);
		$res=$db->get_data($qry_soglie);
		return $res[0]['soglia'];
	}
	
	function get_natura($n_id){
		global $nature_id;
		foreach($nature_id as $v=>$k){
			if(strtolower($k['id_natura'])==strtolower($n_id)){
				return $k['voce_menu'];
			}
		}
	}
	
	function visibility($id_n,$campo){
		global $nature_id;
		if($nature_id[$id_n][$campo]=='N'){
			return 'style="display:none"';
		}else{
			return '';
		}
	}
	
	function genera_pagamenti_id(){
	$results=get_data_qry('select * from psofa.pso_rs_id_pagamento');
	foreach($results as $n){
		$pagamento_id[$n['id_pagamento']]['id_pagamento']=$n['id_pagamento'];
		$pagamento_id[$n['id_pagamento']]['voce_menu']=$n['voce_menu'];
	}
	//$out2=print_r($nature_id);
	return $pagamento_id;
	}
	
	function genera_giustificativi_id(){
	$results=get_data_qry('select * from psofa.pso_rs_id_giustificativo');
	foreach($results as $n){
		$giustificativo_id[$n['id_giustificativo']]['id_giustificativo']=$n['id_giustificativo'];
		$giustificativo_id[$n['id_giustificativo']]['voce_menu']=$n['voce_menu'];
	}
	//$out2=print_r($nature_id);
	return $giustificativo_id;
	}
	
	function carica_file($path){
		$p=$path;
		$f=fopen($p,'r');
		$ret=fread($f,filesize($p));
		fclose($f);
		return $ret;
	}
	
	function lista_natura2($sel){
		return'
	<select name="id_natura" onchange="natura_select($(this).val())">
	<option '. ($sel==0?'selected':'').' value="0">Colazione</option>
	<option '. ($sel==1?'selected':'').' value="1">Pranzo</option>
	<option '. ($sel==2?'selected':'').' value="2">Cena</option>
	<option '. ($sel==3?'selected':'').' value="3">Hotel</option>
	<option '. ($sel==4?'selected':'').' value="4">Rimborso KM</option>
	<option '. ($sel==5?'selected':'').' value="5">Viaggio aereo</option>
	<option '. ($sel==6?'selected':'').' value="6">Viaggio treno</option>
	<option '. ($sel==7?'selected':'').' value="7">Altro</option>
	</select>';
	}
	
	function crea_pulsante($id_n){
		global $nature_id;
		$out='';
		if($nature_id[$id_n]['voce_menu']=='Rimborso Km'){
		$out.='<button onclick="pi.requestQ(\'wallet\',\'Dett_Win_Auto\');">';
		$out.='<i class="fa fa-car fa-2x"></i> Calcola Km';
		$out.='</button>';
		}
		if($nature_id[$id_n]['voce_menu']=='Hotel'){
		$out.='<button onclick="pi.requestQ(\'wallet\',\'Dett_Win_Hotel\');">';
		$out.='<i class="fa fa-bed fa-2x"></i> Dettagli Hotel';
		$out.='</button>';
		}
		return $out;
	}
	
	function db2pi($in){
		if($in==' --- '){
			return floatval(0);
		}else{
			return floatval(str_replace(',','.',$in));
		}
	}
	
	function genera_combo_da_qry($qry,$voce_menu,$value,$name,$id,$selected_value,$onchange){
		//questa funzione genera un menu select a partire da una query,
		//usa la variablie $voce_menu per prendere il nome della colonna da mettere come voce menu
		//e la variablie $value pes prendere il nome della colonna da mettere come value, gli altri sono attributi html
		//selected_value, lo si può usare per mettere un valore preselezionato
		global $db, $qrypath_, $htmlpath_;
		$select=carica_file($htmlpath_.'select/begin.html');
		$select=str_replace('[onchange]',$onchange,$select);
		$select=str_replace('[name]',$name,$select);
		$select=str_replace('[id]',$id,$select);
		$opt_tmp=carica_file($htmlpath_.'select/option.html');
		$res=$db->get_data($qry);
		foreach($res as $v){
			$select.=str_replace('[voce_menu]',$v[$voce_menu],str_replace('[value]',$v[$value],$opt_tmp));
		}
		$select.=carica_file($htmlpath_.'select/end.html');
		return $select;
	}
	
	function qry2sel($qry,$voce_menu,$value,$selected_value){
		//questa funzione genera un menu select a partire da una query,
		//usa la variablie $voce_menu per prendere il nome della colonna da mettere come voce menu
		//e la variablie $value pes prendere il nome della colonna da mettere come value
		//selected_value, lo si può usare per mettere un valore preselezionato
		global $db, $qrypath_, $htmlpath_;
		$opt_tmp=carica_file($htmlpath_.'select/option.html');
		$res=$db->get_data($qry);
		$select='';
		foreach($res as $v){
			$opt=$opt_tmp;
			if (trim(strtolower($v[$value]))==trim(strtolower($selected_value))){
				$opt=str_replace('[selected]','selected',$opt);
			}else{
				$opt=str_replace('[selected]','',$opt);
			}
			$select.=str_replace('[voce_menu]',$v[$voce_menu],str_replace('[value]',$v[$value],$opt));
		}
		return $select;
		
	}
	
	function qry2sel_filtrabile($qry,$voce_menu,$value,$selected_value,$class,$colonna_id){
		//questa funzione genera un menu select a partire da una query,
		//usa la variablie $voce_menu per prendere il nome della colonna da mettere come voce menu
		//e la variablie $value pes prendere il nome della colonna da mettere come value
		//selected_value, lo si può usare per mettere un valore preselezionato
		global $db, $qrypath_, $htmlpath_;
		$opt_tmp=carica_file($htmlpath_.'select/option_filtrabile.html');
		$res=$db->get_data($qry);
		$select='';
		foreach($res as $v){
			$opt=$opt_tmp;
			if (trim(strtolower($v[$value]))==trim(strtolower($selected_value))){
				$opt=str_replace('[selected]','selected',$opt);
			}else{
				$opt=str_replace('[selected]','',$opt);
			}
			$select.=str_replace('[voce_menu]',$v[$voce_menu]
					,str_replace('[value]',$v[$value]
					,str_replace('[class]',$class
					,str_replace('[id_filtro]',$v[$colonna_id]
					,$opt))));
		}
		return $select;
		
	}
	
	function qry2rad($qry,$value,$voce_menu,$name){
		global $db, $qrypath_, $htmlpath_;
		$opt_tmp=carica_file($htmlpath_.'radio.html');
		$res=$db->get_data($qry);
		$select='';
		foreach($res as $v){
			$opt=$opt_tmp;
			$opt=str_replace('[name]',$name,$opt);
			if (trim(strtolower($v[$value]))==trim(strtolower($selected_value))){
				$opt=str_replace('[selected]','selected',$opt);
			}else{
				$opt=str_replace('[selected]','',$opt);
			}
			$select.=str_replace('[voce_menu]',$v[$voce_menu],str_replace('[value]',$v[$value],$opt));
		}
		return $select;
	}
	function module_path(){
		return '/var/www/modules/CED/NoteSpese2p0/call/';
	}
	

?>