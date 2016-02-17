select 
concat(concat(to_char(data_da,'yyyy,'),to_number(to_char(data_da,'mm'))),to_char(data_da,',dd')) as data_da
,concat(concat(to_char(data_a,'yyyy,'),to_number(to_char(data_a,'mm'))),to_char(data_a,',dd')) as data_a
,to_char(data_da,'dd/mm/yyyy') as data_da_2
from 
    psofa.pso_rs_trasf 
where 
    id_trasf=[id_trasf]