select
    *
from
    psofa.pso_rs_soglie_gruppi_desc
where 
	selezionabile is null 
or 
	selezionabile <> 'Y'