select 
	to_char(dt_fatt,'dd/mm/yyyy') dt_fatt
    ,trim(nro_fatt) nro_fatt
    ,trim(mastro_ft) mastro_ft
    ,trim(partit_ft) partit_ft	
    ,trim(cod_iva) cod_iva
from
	psofa.pso_rs_dett
where
	id_dett=[id_dett]