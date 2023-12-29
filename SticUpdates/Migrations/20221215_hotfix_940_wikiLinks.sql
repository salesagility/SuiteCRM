UPDATE
    stic_settings
SET
    description = REPLACE(
        description,
        'https://wiki.sinergiacrm.org/index.php?title=Formas_de_pago,_Pagos_y_Remesas#Notas_adicionales_sobre_las_constantes_del_Modelo_182',
        'https://wikisuite.sinergiacrm.org/index.php?title=Modelo_182#Porcentaje_de_deducci.C3.B3n_auton.C3.B3mica'
    )
WHERE
    id = '846d3469-acef-db6c-41bc-518cccb58b4a';

UPDATE
    stic_settings
SET
    description = REPLACE(
        description,
        'https://wiki.sinergiacrm.org/index.php?title=Formas_de_pago,_Pagos_y_Remesas#Constantes_SEPA_para_remesas_de_recibos_domiciliados',
        'https://wikisuite.sinergiacrm.org/index.php?title=Compromisos_de_pago,_Pagos_y_Remesas#Par.C3.A1metros_SEPA_para_remesas_de_recibos_domiciliados'
    )
WHERE
    id = 'eacb2339-7741-96d7-3fd6-531f07485832';


