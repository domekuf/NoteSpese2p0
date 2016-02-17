select
id_dett       
,n_notti       
,n_colazioni   
,n_pranzi      
,n_cene        
,case when tot_notti     	is null or tot_notti     	=0 then '0.00' else trim(to_char(tot_notti     	,'9999999.99')) end tot_notti     	
,case when tot_colazioni 	is null or tot_colazioni 	=0 then '0.00' else trim(to_char(tot_colazioni 	,'9999999.99')) end tot_colazioni 	
,case when tot_pranzi    	is null or tot_pranzi    	=0 then '0.00' else trim(to_char(tot_pranzi    	,'9999999.99')) end tot_pranzi    	
,case when altro         	is null or altro         	=0 then '0.00' else trim(to_char(altro         	,'9999999.99')) end altro         	
,case when totale_fattura	is null or totale_fattura	=0 then '0.00' else trim(to_char(totale_fattura	,'9999999.99')) end totale_fattura	
,case when totale 			is null or totale 			=0 then '0.00' else trim(to_char(totale 		,'9999999.99')) end totale 		
,case when tot_cene     	is null or tot_cene     	=0 then '0.00' else trim(to_char(tot_cene     	,'9999999.99')) end tot_cene     			      
,id_trasf
,id_hotel      
from
	psofa.pso_rs_dett_hotel
where
	id_dett=[id_dett]