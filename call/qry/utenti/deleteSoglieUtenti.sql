delete from 
    psofa.pso_rs_soglie_personalizzate
where 
    trim(login_utente)=trim('[login_utente]')
and 
    id_natura=[id_natura]