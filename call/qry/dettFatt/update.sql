update 
	psofa.pso_rs_dett
set 
	dt_fatt 	= to_date('[dt_fatt]','dd/mm/yyyy')
	,nro_fatt 	= trim('[nro_fatt]')
	,mastro_ft 	= trim('[mastro_ft]')
	,partit_ft 	= trim('[partit_ft]')
	,cod_iva 	= (
					select 
						cod_iva_pref 
					from
						psofa.pso_rs_id_natura
					where 
						id_natura=(	select 
										id_natura
									from 
										psofa.pso_rs_dett
									where 
										id_dett=[id_dett]
				)
	)
where 
	id_dett=[id_dett]