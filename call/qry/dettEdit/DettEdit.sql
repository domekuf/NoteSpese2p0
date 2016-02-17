
select
case when id_dett            is null then 0 else id_dett    end id_dett          	--number  	22  
,case when id_trasf           is null then 0 else id_trasf   end id_trasf         	--number  	22  
,case when id_natura          is null then -1 else id_natura  end id_natura    		--number  	22  
,case when importo            is null or importo           =0 then '0.00' else trim(to_char(importo          ,'999999.99')) end importo          	--number  	22  
,case when importo_richiesto  is null or importo_richiesto =0 then '0.00' else trim(to_char(importo_richiesto,'999999.99')) end importo_richiesto	--number  	22  
,case when limite_spesa       is null or limite_spesa      =0 then '-1.00' else trim(to_char(limite_spesa     ,'999999.99')) end limite_spesa     	--number  	22  
,case when id_pagamento       is null then -1 else id_pagamento end id_pagamento    --number  	22  
,case when importo_approvato  is null or importo_approvato =0 then '0.00' else trim(to_char(importo_approvato,'999999.99')) end importo_approvato	--number  	22  
,case when soglia             is null or soglia            =0 then '-1.00' else trim(to_char(soglia           ,'999999.99')) end soglia           	--number  	22  
,case when qta_soglia         is null then 1 else qta_soglia end qta_soglia       	--number  	22  
,case when id_hotel           is null then -1 else id_hotel end id_hotel         	--number  	22  
,case when id_hotel_padre     is null then -1 else id_hotel_padre end id_hotel_padre   	--number  	22  
,case when no_giustificativo 	is null then 	'N'	else 	no_giustificativo 	    end	no_giustificativo
,case when partitario         	is null then '' else	partitario         		end partitario         					--char    	6   
,case when mastro             	is null then '' else	mastro             		end mastro             				--char    	6   
,case when data               	is null then to_char(trunc(sysdate),'dd/mm/yyyy') else	to_char(data,'dd/mm/yyyy')        end data               				--date    	7   
,case when pagamento_menu     	is null then '' else	pagamento_menu     		end pagamento_menu     				--varchar2	512 
,case when giustificativo_menu	is null then '' else	giustificativo_menu		end giustificativo_menu				--varchar2	512 
,case when voce_menu          	is null then '' else	voce_menu          		end voce_menu          				--varchar2	32  
,case when descrizione        	is null then '' else	descrizione        		end descrizione        				--varchar2	32  
,case when icon_menu          	is null then '' else	icon_menu          		end icon_menu          				--varchar2	32  
,case when luogo              	is null then '' else	luogo              		end luogo              				--varchar2	512 
,case when tipo_giustificativo	is null then '' else	tipo_giustificativo		end tipo_giustificativo				--varchar2	512 
,case when giustificativo     	is null then '' else	giustificativo     		end giustificativo     				--varchar2	512 
,case when pre_approvazione   	is null then '' else	pre_approvazione   		end pre_approvazione   				--varchar2	512 
,case when approvazione_sforo 	is null then '' else	approvazione_sforo 		end approvazione_sforo 				--varchar2	512 
,case when note               	is null then '' else	note               		end note               				--varchar2	2000
from
    psofa.pso_rs_dett_view_test
where
	id_dett='[id_dett]'
order by
	data
asc
