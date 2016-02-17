select
    data_da        
    ,data_a         
    ,ok_x_cont      
    ,rrbsp          
    ,rrbsp_2
	,rrbsp_ft
	,rrbsp_2_ft
    ,case when totale_carta is null or totale_carta=0 then '0.00' else to_char(totale_carta,'999999.99') end  totale_carta
    ,case when totale_contanti is null or totale_contanti=0 then '0.00' else to_char(totale_contanti,'999999.99') end  totale_contanti
    ,case when totale_ob is null or totale_ob=0 then '0.00' else to_char(totale_ob,'999999.99') end  totale_ob
    ,case when totale is null or totale=0 then '0.00' else to_char(totale,'999999.99') end  totale
	,status         
    ,id_trasf       
    ,login_utente   
    ,desc_trasf
from
    psofa.pso_rs_trasf
where
    login_utente='[login_utente]'
and
	(rrbsp is not null or rrbsp_2 is not null)
order by
	data_da