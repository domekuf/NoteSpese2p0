select
     prt.data_da        
    ,prt.data_a         
    ,prt.ok_x_cont      
    ,prt.rrbsp          
    ,prt.rrbsp_2
    ,case when prt.totale_carta is null or      prt.totale_carta=0 then '0.00' else     trim(to_char(prt.totale_carta,'999999.99') 		)end  totale_carta
    ,case when prt.totale_contanti is null or   prt.totale_contanti=0 then '0.00' else  trim(to_char(prt.totale_contanti,'999999.99') 	)end  totale_contanti
    ,case when prt.totale_ob is null or         prt.totale_ob=0 then '0.00' else        trim(to_char(prt.totale_ob,'999999.99') 		)end  totale_ob
    ,case when prt.totale is null or            prt.totale=0 then '0.00' else           trim(to_char(prt.totale,'999999.99')			)end  totale
    ,prt.status         
    ,prt.id_trasf       
    ,prt.login_utente   
    ,prt.desc_trasf
    ,case when
		(select
            sum(prd.importo_approvato) 
        from 
            psofa.pso_rs_dett prd
        where
            prd.id_trasf=prt.id_trasf
        ) is null or
		(select
            sum(prd.importo_approvato) 
        from 
            psofa.pso_rs_dett prd
        where
            prd.id_trasf=prt.id_trasf
        )=0
		
		
		then '0.00'
		else
		trim(to_char((select
            sum(prd.importo_approvato) 
        from 
            psofa.pso_rs_dett prd
        where
            prd.id_trasf=prt.id_trasf
        ),'999999.99'))end
		totale_importo_approvato
from
    psofa.pso_rs_trasf prt
where
    login_utente='[login_utente]'
and
    (rrbsp is null and rrbsp_2 is null)
order by
    prt.data_da