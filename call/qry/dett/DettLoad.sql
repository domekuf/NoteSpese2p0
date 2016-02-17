
select
trim(cod_iva) cod_iva
,pagamento_menu     
,giustificativo_menu
,voce_menu          
,partitario         
,mastro             
,descrizione        
,icon_menu          
,id_dett            
,id_trasf           
,data               
,id_natura          
,luogo              
,id_pagamento       
,tipo_giustificativo
,giustificativo     
,pre_approvazione   
,approvazione_sforo 
,note                
,qta_soglia         
,id_hotel           
,id_hotel_padre     
,no_giustificativo  
,case when importo is null or importo=0 then '0.00' else trim(to_char(importo,'999999.99')) end  importo
,case when importo_richiesto is null or importo_richiesto=0 then '0.00' else trim(to_char(importo_richiesto,'999999.99')) end  importo_richiesto
,case when limite_spesa is null or limite_spesa=0 then '0.00' else trim(to_char(limite_spesa,'999999.99')) end  limite_spesa
,case when importo_approvato is null or importo_approvato=0 then '0.00' else trim(to_char(importo_approvato,'999999.99')) end  importo_approvato
,case when soglia is null or soglia=0 then '0.00' else trim(to_char(soglia,'999999.99')) end  soglia
from
    psofa.pso_rs_dett_view_test
where
	id_trasf='[id_trasf]'
order by
	data
asc,
id_hotel,
id_hotel_padre