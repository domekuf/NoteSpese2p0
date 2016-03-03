select 
	id_tappa
    ,to_char(data,'dd/mm/yyyy') data
    ,luogo
    ,luogo_a
from 
    table(psofa.pso_pkg_rs_utility.sf_get_itin([id_trasf],[id_dett]))
order by id_tappa