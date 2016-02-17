delete from
    psofa.pso_rs_utenti_gruppi
where
    lower(trim(login_utente)) ='[usr_to_remove]'