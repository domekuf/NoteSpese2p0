select
    trim(psofa.anagrafico_conti_v.mastro)||'-'||trim(psofa.anagrafico_conti_v.partitario) codice,
    descrizione_1||' ('||partita_iva||')' descrizione
from
    psofa.anagrafico_conti_v,
    psofa.conti_fornitori,
    psofa.cow_clifor_altri_campi
where
        psofa.anagrafico_conti_v.mastro = psofa.cow_clifor_altri_campi.mastro
    and psofa.anagrafico_conti_v.partitario = psofa.cow_clifor_altri_campi.partitario
    and psofa.anagrafico_conti_v.mastro = psofa.conti_fornitori.mastro
    and psofa.anagrafico_conti_v.partitario = psofa.conti_fornitori.partitario
    and cod_campo = 'C_AR'
    and valore in ('Y')
order by 2
