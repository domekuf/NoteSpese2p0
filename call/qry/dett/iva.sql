select regexp_substr(PSO_PKG_UTILITY.sf_read_par_vari_TXT('RS_CODICI_IVA'),'[^,]+', 1, level) cod_iva 
from dual 
connect by 
regexp_substr(PSO_PKG_UTILITY.sf_read_par_vari_TXT('RS_CODICI_IVA'), '[^,]+', 1, level) is not null