delete from 
    psofa.pso_rs_soglie_gruppi
where 
    trim(id_gruppo)=trim('[id_gruppo]')
and 
    id_natura=[id_natura]