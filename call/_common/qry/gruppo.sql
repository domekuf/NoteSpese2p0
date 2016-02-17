select descrizione
from
    psofa.pso_rs_soglie_gruppi_desc a 
join
    psofa.pso_rs_soglie_gruppi b
on
    a.id_gruppo=b.id_gruppo
join
    psofa.pso_rs_utenti_gruppi c
on
    b.id_gruppo=c.id_gruppo
    
where
    c.login_utente='[login_utente]'