<?
$id_trasf = $_POST['id_trasf'];
$id_dett = $_POST['id_dett'];
$id_hotel = $_POST['id_hotel'];
$n_notti=$_POST['n_notti'];
$n_colazioni=$_POST['n_colazioni'];
$n_pranzi=$_POST['n_pranzi'];
$n_cene=$_POST['n_cene'];
$tot_notti=$_POST['tot_notti'];
$tot_colazioni=$_POST['tot_colazioni'];
$tot_pranzi=$_POST['tot_pranzi'];
$tot_cene=$_POST['tot_cene'];
$altro=$_POST['altro'];
$totale_fattura=$_POST['totale_fattura'];
$totale=$_POST['totale'];

$qry='
update psofa.pso_rs_dett_hotel
set
n_notti='.$n_notti.',
n_colazioni='.$n_colazioni.',
n_pranzi='.$n_pranzi.',
n_cene='.$n_cene.',
tot_notti='.$tot_notti.',
tot_colazioni='.$tot_colazioni.',
tot_pranzi='.$tot_pranzi.',
tot_cene='.$tot_cene.',
altro='.$altro.',
totale_fattura='.$totale_fattura.',
totale='.$totale.'
where id_dett='.$id_dett;
$db->put_data($qry);

$qry_del='
delete from psofa.pso_rs_dett
where id_hotel='.$id_hotel;

$db->put_data($qry_del);

$qry_ins='';
//get_soglia('colazione');
//get_id('colazione');

if($n_colazioni+$n_pranzi+$n_cene>0){
$qry_ins.='
insert all
';
if($n_colazioni>0){
$q_num='select psofa.pso_seq_rs_dett.nextval as num from dual';
$num=$db->get_data($q_num)[0]['num'];
$qry_ins.='
	into psofa.pso_rs_dett(
				id_dett,
				id_trasf,
				data,
				id_natura,
				luogo,
				importo,
				importo_richiesto,
				limite_spesa,
				id_pagamento,
				tipo_giustificativo,
				giustificativo,
				pre_approvazione,
				approvazione_sforo,
				note,
				importo_approvato,
				soglia,
				qta_soglia,
				id_hotel) 
	values (
				'.$num.',
				'.$id_trasf.',
				(select data from psofa.pso_rs_dett where id_dett='.$id_dett.'),
				'.get_id('colazione').',
				\'Hotel\',
				'.$tot_colazioni.',
				'.$tot_colazioni.',
				'.get_soglia('colazione',$id_trasf)*$n_colazioni.',
				\'\',
				\'\',
				\'\',
				\'\',
				\'\',
				\'Relativa a Hotel: '.$id_hotel.'\',
				0,
				'.get_soglia('colazione',$id_trasf).',
				'.$n_colazioni.',
				'.$id_hotel.')';
}
if($n_pranzi>0){
$q_num='select psofa.pso_seq_rs_dett.nextval as num from dual';
$num=$db->get_data($q_num)[0]['num'];
$qry_ins.='
	into psofa.pso_rs_dett(
				id_dett,
				id_trasf,
				data,
				id_natura,
				luogo,
				importo,
				importo_richiesto,
				limite_spesa,
				id_pagamento,
				tipo_giustificativo,
				giustificativo,
				pre_approvazione,
				approvazione_sforo,
				note,
				importo_approvato,
				soglia,
				cod_iva,
				qta_soglia,
				id_hotel) 
	values (
				'.$num.',
				'.$id_trasf.',
				(select data from psofa.pso_rs_dett where id_dett='.$id_dett.'),
				'.get_id('pasto').',
				\'Hotel\',
				'.$tot_pranzi.',
				'.$tot_pranzi.',
				'.get_soglia('pasto',$id_trasf)*$n_pranzi.',
				\'\',
				\'\',
				\'\',
				\'\',
				\'\',
				\'Relativa a Hotel: '.$id_hotel.'\',
				0,
				'.get_soglia('pasto',$id_trasf).',
				(select trim(to_char(cod_iva_pref)) from psofa.pso_rs_id_natura where id_natura=	'.get_id('pasto').'),
				'.$n_pranzi.',
				'.$id_hotel.')';
}

if($n_cene>0){
$q_num='select psofa.pso_seq_rs_dett.nextval as num from dual';
$num=$db->get_data($q_num)[0]['num'];
$qry_ins.='
	into psofa.pso_rs_dett(
				id_dett,
				id_trasf,
				data,
				id_natura,
				luogo,
				importo,
				importo_richiesto,
				limite_spesa,
				id_pagamento,
				tipo_giustificativo,
				giustificativo,
				pre_approvazione,
				approvazione_sforo,
				note,
				importo_approvato,
				soglia,
				qta_soglia,
				id_hotel) 
	values (
				'.$num.',
				'.$id_trasf.',
				(select data from psofa.pso_rs_dett where id_dett='.$id_dett.'),
				'.get_id('generi alimentari').',
				\'Hotel\',
				'.$tot_cene.',
				'.$tot_cene.',
				'.get_soglia('generi alimentari',$id_trasf)*$n_cene.',
				\'\',
				\'\',
				\'\',
				\'\',
				\'\',
				\'Relativa a Hotel: '.$id_hotel.'\',
				0,
				'.get_soglia('generi alimentari',$id_trasf).',
				'.$n_cene.',
				'.$id_hotel.')';
}
if($altro>0){
$q_num='select psofa.pso_seq_rs_dett.nextval as num from dual';
$num=$db->get_data($q_num)[0]['num'];
$qry_ins.='
	into psofa.pso_rs_dett(
				id_dett,
				id_trasf,
				data,
				id_natura,
				luogo,
				importo,
				importo_richiesto,
				limite_spesa,
				id_pagamento,
				tipo_giustificativo,
				giustificativo,
				pre_approvazione,
				approvazione_sforo,
				note,
				importo_approvato,
				soglia,
				cod_iva,
				qta_soglia,
				id_hotel) 
	values (
				'.$num.',
				'.$id_trasf.',
				(select data from psofa.pso_rs_dett where id_dett='.$id_dett.'),
				15,
				\'Hotel\',
				'.$altro.',
				'.$altro.',
				'.$altro.',
				\'\',
				\'\',
				\'\',
				\'\',
				\'\',
				0,
				0,
				'.$altro.',
				(select trim(to_char(cod_iva_pref)) from psofa.pso_rs_id_natura where id_natura=15),
				1,
				'.$id_hotel.')';
}
$qry_ins.='				
select * from dual
';

$db->put_data($qry_ins);
}
$qry_upd='
update
	psofa.pso_rs_dett
set 
	importo='.$tot_notti.',
	importo_richiesto='.$tot_notti.',
	qta_soglia='.$n_notti.',
	soglia='.get_soglia('hotel',$id_trasf).',
	limite_spesa='.$n_notti*get_soglia('hotel',$id_trasf).',
	id_hotel_padre='.$id_hotel.'
where 
	id_dett='.$id_dett;
//$db->put_data($qry_upd);
//$pr->add_msg('alert',$qry_upd);
//$pr->add_html('container5',$qry_upd);
$pr->add_script('$("#limite_spesa").val(Math.round('.$n_notti*get_soglia('hotel',$id_trasf).'*100)/100)');
$pr->add_script('$("#qta_soglia").val(Math.round('.$n_notti.'))');
$pr->add_script('$("#soglia").val(Math.round('.get_soglia('hotel',$id_trasf).'))');
$pr->add_script('$("#id_hotel_padre").val(\''.$id_hotel.'\')');
$pr->add_script('$("#importo").val(Math.round('.$tot_notti.'*100)/100)');
$pr->add_script('$("#importo_richiesto").val(Math.round('.$tot_notti.'*100)/100)')->response();
//$pr->add_script('pi.requestQLoaderOpen("wallet","Trasf_Load");')->response();
//$pr->add_html('container5','')->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->response();
//$pr->add_win(600,0,true,'Inserisci nuova trasferta',$out)->add_script(" $('#focusme').focus(); ")->response();
?>
