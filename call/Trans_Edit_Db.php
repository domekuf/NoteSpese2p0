<?
$login_utente = $_POST['login_utente'];
$id_trasf 			= $_POST['id_trasf'];
$id_trans			= $_POST['id_trans'];
$id_hotel			= $_POST['id_hotel'];
$id_hotel_padre		= $_POST['id_hotel_padre'];
$data 				= $_POST['data'];
$id_natura 			= $_POST['id_natura'];
$luogo 				= $_POST['luogo'];
$importo 			= $_POST['importo'];
$importo_richiesto 	= $_POST['importo_richiesto'];
$limite_spesa 		= $_POST['limite_spesa'];
$id_pagamento 		= $_POST['id_pagamento'];
$tipo_giustificativo= $_POST['tipo_giustificativo'];
$giustificativo		= $_POST['giustificativo'];
$pre_approvazione   = $_POST['pre_approvazione'];
$approvazione_sforo = $_POST['approvazione_sforo'];
$note				= $_POST['note'];				
$importo_approvato  = $_POST['importo_approvato'];
$tmp_no_giustificativo  = $_POST['no_giustificativo'];
if($tmp_no_giustificativo){
	$no_giustificativo='Y';
}else{
	$no_giustificativo='N';
}

$qry='
update  psofa.pso_rs_dett
   set 		id_trasf					=\''.$id_trasf 				.'\'
			,data                       =to_date(\''.$data.'\',\'dd-mm-yyyy\')
			,id_natura                  =\''.$id_natura 				.'\'
			,luogo                      =\''.$luogo 					.'\'
			,importo                    =to_number(\''.$importo 		 .'\',\'999999999.99\')
			,importo_richiesto          =to_number(\''.$importo_richiesto.'\',\'999999999.99\')
			,id_pagamento               =\''.$id_pagamento 			.'\'
			,tipo_giustificativo        =\''.$tipo_giustificativo	.'\'
			,giustificativo             =\''.$giustificativo			.'\'
			,pre_approvazione           =\''.$pre_approvazione 		.'\'
			,approvazione_sforo         =\''.$approvazione_sforo		.'\'
			,note                       =\''.$note				    .'\'
			,importo_approvato	        =0
			,qta_soglia					=1
			'.(get_soglia(get_natura($id_natura))!=' --- '?('
			,soglia						='.get_soglia(get_natura($id_natura)).'
			,limite_spesa				='.get_soglia(get_natura($id_natura)).'
			'):
			('
			,soglia						=to_number(\''.$importo.'\',\'999999999.99\')
			,limite_spesa				=to_number(\''.$importo.'\',\'999999999.99\')
			')).'
			,no_giustificativo			=\''.$no_giustificativo.'\'
		   where id_dett='.$id_trans;
$db->put_data($qry);

if($id_natura==get_id('hotel')){
	$qry1='
	update psofa.pso_rs_dett	
		set 
			luogo                      =\'Hotel a '.$luogo 					.'\'
			,id_pagamento               =\''.$id_pagamento 			.'\'
			,tipo_giustificativo        =\''.$tipo_giustificativo	.'\'
			,giustificativo             =\''.$giustificativo			.'\'
			,pre_approvazione           =\''.$pre_approvazione 		.'\'
			,approvazione_sforo         =\''.$approvazione_sforo		.'\'
			,importo_approvato	        =0
			,no_giustificativo			=\''.$no_giustificativo.'\'
		where 
			id_hotel='.$id_hotel_padre;
		$db->put_data($qry1);
	$qry2='
	update psofa.pso_rs_dett	
		set 
			id_hotel_padre='.$id_hotel_padre.'
			,no_giustificativo			=\''.$no_giustificativo.'\'
		where id_dett='.$id_trans;
	$db->put_data($qry2);
		
}
//$pr->add_html('container2','');
$pr->add_html('container1','');
$pr->add_html('container5','');
$pr->add_html('container4','' );
//$pr->add_script('pi.requestQLoaderOpen("wallet","Trans_Edit");'); unica differenza con Trans_Edit_Db_New
$pr->add_script('pi.requestQLoaderOpen("wallet","Trans_Load_2_Refresh");')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();


//,soglia						='.get_soglia((get_natura($id_natura))).'
//,limite_spesa				='.get_soglia((get_natura($id_natura))).'
?>
