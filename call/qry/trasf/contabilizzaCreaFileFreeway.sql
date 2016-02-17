select regexp_substr((select trim(rrbsp)||','||trim(rrbsp_2)||','||trim(rrbsp_ft)||','||trim(rrbsp_2_ft)
from
psofa.pso_rs_trasf
where
id_trasf = [id_trasf]),'[^,]+', 1, level) nro_reg 
from dual 
connect by 
regexp_substr((select trim(rrbsp)||','||trim(rrbsp_2)||','||trim(rrbsp_ft)||','||trim(rrbsp_2_ft)
from
psofa.pso_rs_trasf
where
id_trasf = [id_trasf]), '[^,]+', 1, level) is not null
union
select distinct trim(nro_reg_ft) nro_reg_ft
from
psofa.pso_rs_dett
where id_trasf=[id_trasf]
and nro_reg_ft > 0
