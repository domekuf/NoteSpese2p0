select
    case when totale is null or totale=0 then '0.00' else trim(to_char(totale,'999999.99')) end  totale
    ,case when totale_ob is null or totale_ob=0 then '0.00' else trim(to_char(totale_ob,'999999.99')) end  totale_ob
from
    psofa.pso_rs_trasf
where
    id_trasf=[id_trasf]