select  
    wp.login_utente,wp.desc_login
from 
    psofaweb7.web_permessi wp
join 
     psofa.pso_tab_appl_utenti_funz ptau
on 
    trim(wp.login_utente)=trim(ptau.utente)
left join
    psofa.pso_rs_utenti_gruppi prug
on
    trim(prug.login_utente)=trim(ptau.utente)
where 
    trim(ptau.cod_appl)='PORTAL1'
and
    trim(ptau.cod_funz)='1'
and
    id_gruppo is null