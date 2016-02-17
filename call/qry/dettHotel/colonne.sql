select table_name, column_name, data_type, data_length
from sys.dba_tab_columns
where table_name = 'PSO_RS_DETT_HOTEL'