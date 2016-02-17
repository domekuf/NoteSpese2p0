select voce_menu,id_natura, trim(to_char(subtotale,'9999999.99')) subtotale from(
select
b.voce_menu
,b.id_natura
,(
select
    sum(importo_richiesto)
from
    psofa.pso_rs_dett a
where
    id_trasf=[id_trasf]
and 
    a.id_natura=b.id_natura
)as subtotale
from
psofa.pso_rs_id_natura b
)
where subtotale > 0