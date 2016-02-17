select * 
from
(select 
    1 as ord,soglia
from 
    psofa.pso_rs_soglie_personalizzate 
where 
    login_utente='[login_utente]'
and 
    id_natura='[id_natura]'
union
select 
    2,soglia
from 
    psofa.pso_rs_soglie_gruppi a
join
    psofa.pso_rs_trasf b
on
    a.id_gruppo=b.id_gruppo
where 
    b.id_trasf=[id_trasf]
and 
    a.id_natura='[id_natura]'
union
select 
    3,soglia
from 
    psofa.pso_rs_soglie_gruppi a
join
    psofa.pso_rs_utenti_gruppi b
on
    a.id_gruppo=b.id_gruppo
where 
    b.login_utente='[login_utente]'
and 
    a.id_natura='[id_natura]')
    order by ord