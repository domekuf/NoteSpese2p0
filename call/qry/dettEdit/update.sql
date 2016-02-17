update 
	psofa.pso_rs_dett
set 
	tipo_giustificativo = '[tipo_giustificativo]'
	,soglia             = to_number('[soglia]','999999999.99')
	,qta_soglia         = '[qta_soglia]'
	,pre_approvazione   = '[pre_approvazione]'
	,note               = '[note]'
	,no_giustificativo  = case when '[no_giustificativo]' = 1 then 'Y' else 'N' end
	,luogo              = '[luogo]'
	,limite_spesa       = to_number('[limite_spesa]','999999999.99')
	,importo_richiesto  = to_number('[importo_richiesto]','999999999.99')
	,importo_approvato  = to_number('[importo_approvato]','999999999.99')
	,importo            = to_number('[importo]','999999999.99')
	,id_pagamento       = '[id_pagamento]'
	,id_natura          = '[id_natura]'
	,id_hotel_padre     = '[id_hotel_padre]'
	,id_hotel           = '[id_hotel]'
	,giustificativo     = '[giustificativo]'
	,cod_iva		    = (select 
								trim(to_char(cod_iva_pref)) 
							from 
								psofa.pso_rs_id_natura
							where
								id_natura='[id_natura]')
where 
	id_dett=[id_dett]