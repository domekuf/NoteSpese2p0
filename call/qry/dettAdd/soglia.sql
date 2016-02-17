select
    case when soglia is null or soglia=0 then '-1.00' else trim(to_char(soglia,'999999.99')) end soglia
from
    psofa.pso_rs_id_natura
where 
	id_natura=[id_natura]