update 
	psofa.pso_rs_dett
set 
	tipo_giustificativo	= '[tipo_giustificativo]'
	,pre_approvazione  	= '[pre_approvazione]'
	,note              	= '[note]'
	,no_giustificativo 	= case when '[no_giustificativo]' = 1 then 'Y' else 'N' end
	,luogo             	= 'Hotel a [luogo]'
	,id_pagamento      	= '[id_pagamento]'
	,giustificativo    	= '[giustificativo]'
	,dt_fatt		   	= (	select
								dt_fatt
							from
								psofa.pso_rs_dett
							where
								id_hotel_padre=[id_hotel_padre])
	,nro_fatt    		= (	select
								nro_fatt
							from
								psofa.pso_rs_dett
							where
								id_hotel_padre=[id_hotel_padre])
	,mastro_ft    		= (	select
								mastro_ft
							from
								psofa.pso_rs_dett
							where
								id_hotel_padre=[id_hotel_padre])
	,partit_ft    		= (	select
								partit_ft
							from
								psofa.pso_rs_dett
							where
								id_hotel_padre=[id_hotel_padre])
where 
	id_hotel=[id_hotel_padre]