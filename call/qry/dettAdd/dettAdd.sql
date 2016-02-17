insert into psofa.pso_rs_dett
    (id_dett
	,id_trasf
	,data
	,id_natura
	,id_pagamento
	,tipo_giustificativo
	,soglia)
values
    ([id_dett]
	,[id_trasf]
	,to_date('[data]','dd/mm/yyyy')
	,[id_natura]
	,0
	,0
	,[soglia]
	)