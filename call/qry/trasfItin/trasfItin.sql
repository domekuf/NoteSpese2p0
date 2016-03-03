select
	id_trasf
	,id_tappa
	,case when luogo is not null then luogo else '' end luogo
	,to_char(data,'dd/mm/yyyy') as data
	,data as data_2
	,case when luogo_a is not null then luogo_a else '' end luogo_a
from
	psofa.pso_rs_trasf_itin
where
	id_trasf='[id_trasf]'
	order by id_tappa
