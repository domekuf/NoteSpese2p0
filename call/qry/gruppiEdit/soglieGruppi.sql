select
    prid.id_natura
    ,prid.voce_menu
    ,trim(to_char(prsg.soglia,'999999.99')) soglia
from 
    psofa.pso_rs_soglie_gruppi prsg
join
    psofa.pso_rs_soglie_gruppi_desc prsgd
on 
    prsg.id_gruppo=prsgd.id_gruppo
join
    psofa.pso_rs_id_natura prid
on 
    prid.id_natura=prsg.id_natura
where 
	prsg.id_gruppo=[id_gruppo]