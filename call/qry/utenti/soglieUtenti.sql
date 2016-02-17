select 
    prsp.id_natura
    ,prid.voce_menu
    ,trim(to_char(prsp.soglia,'999999.99')) soglia
from
    psofa.pso_rs_soglie_personalizzate prsp
join
    psofa.pso_rs_id_natura prid
on
    prid.id_natura=prsp.id_natura
where
    lower(trim(login_utente))='[login_utente]'