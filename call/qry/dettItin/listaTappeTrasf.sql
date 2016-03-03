select 
    luogo
from 
    psofa.pso_rs_trasf_itin 
where id_trasf=[id_trasf]
union
select 
    luogo_a
from 
    psofa.pso_rs_trasf_itin 
where id_trasf=[id_trasf]