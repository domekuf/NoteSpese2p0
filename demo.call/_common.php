<?
	include $pr->get('root').'../lib/php.db.php';
	include $pr->get('root').'../lib/php.custom.php';
	
	$db = new PI_DB($_SESSION[$pr->get('MSID')]['db']);
	$db->set_opt('rowindex',false);
	$db->set_opt('lowercase',true);
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
		return $db->get_data($qry);
	}

?>