update  
	psofa.pso_rs_dett
set 
	importo_approvato=to_number('[importo_approvato]','99999999999999999.99')
	,cod_iva=trim('[cod_iva]')
where 
	id_dett=[id_dett]