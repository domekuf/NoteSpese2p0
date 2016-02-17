select table_name, column_name, data_type, data_length
from sys.dba_tab_columns
where table_name = 'PSO_RS_TRASF'
union
select
'','totale_importo_approvato','',0
from dual