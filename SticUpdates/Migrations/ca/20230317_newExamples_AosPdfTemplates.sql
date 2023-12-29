-- SinergiaCRM: Exemples de Plantilles PDF
REPLACE INTO `aos_pdf_templates` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `assigned_user_id`, `active`, `type`, `pdfheader`, `pdffooter`, `margin_left`, `margin_right`, `margin_top`, `margin_bottom`, `margin_header`, `margin_footer`, `page_size`, `orientation`) VALUES
('49e6e278-9584-b17c-6e41-6414358fafde', 'Exemple - Persones - 01 - Cessió de Dades (RGPD)', NOW(), NOW(), '1', '1', '<h1 align=\"center\"><span style=\"font-size:2em;\"> </span><img style=\"font-size:2em;\" src=\"https://sinergiacrm.org/wp-content/uploads/2019/04/cropped-Logo_SinergiaTIC-5.png\" alt=\"\" width=\"375\" height=\"113\" /></h1><h1 align=\"center\"><strong>DOCUMENT DE CESSIÓ DE DADES PERSONALS</strong></h1><p align=\"center\">  </p><p style=\"text-align:justify;\"><span style=\"color:#b4bc32;\"><strong>$contacts_name</strong></span>, amb domicili a <span style=\"color:#b4bc32;\"><strong>$contacts_primary_address_street</strong></span> de <strong><span style=\"color:#b4bc32;\">$contacts_primary_address_city</span></strong> i amb  <span style=\"color:#b4bc32;\"><strong>$contacts_stic_identification_type_c</strong></span> n.º <span style=\"color:#b4bc32;\"><strong>$contacts_stic_identification_number_c</strong><span style=\"color:#333300;\">:</span></span></p><p style=\"text-align:justify;\">Autoritza que les seves dades personals siguin tractades per <span style=\"color:#333300;\"><strong>Nom Organització </strong></span>amb domicili a <strong>Adreça Organització</strong> i NIF <strong>NIF Organització</strong> amb la finalitat de gestionar la seva donació i informar-li de les activitats de l\'organització.</p><p style=\"text-align:justify;\">Així mateix, les seves dades personals podran ser cedides a les Administracions Públiques en compliment de la normativa legal en vigor. </p><p style=\"text-align:justify;\">Addicionalment, <strong>Nom Organització</strong> podrà cedir les seves dades a aquelles empreses o organitzacions que presten serveis a <strong>Nom Organització </strong>i que requereixin dels mateixos per realitzar la seva tasca.</p><p style=\"text-align:justify;\">Pot exercir els seus drets d\'accés, rectificació, cancelació o oposició davant <strong>Nom Organització</strong> a l\'adreça anteriorment indicada mitjançant sol·licitud per escrit acompanyada de còpia del seu NIF.</p><p style=\"text-align:justify;\">Per consultar informació en detall entorn l\'ús, finalitats i drets que l\'emparen  consultar la pàgina <a title=\"http://laorganizacion.com/rgpd\" href=\"http://laorganizacion.com/rgpd\">http://laorganizacion.com/rgpd</a>.</p><p> </p><p>En <span style=\"color:#b4bc32;\"><strong>$contacts_primary_address_city</strong></span> a {DATE d/m/Y}, </p><p> </p><p>Signatura de l\'interessat/da,</p><p> </p><p> </p><p> </p>', 0, '1', 1, 'Contacts', '', '<p style=\"text-align:center;\" align=\"right\"><em><span style=\"font-size:x-small;\"><strong>p.{PAGENO}</strong></span></em></p>', 30, 30, 15, 15, 9, 9, 'A4', 'Portrait'),
('a35d5775-7805-0e10-e5c6-641435f2d02b', 'Exemple - Persones - 02 - Certificat de donacions anual', NOW(), NOW(), '1', '1', '<h1 align=\"center\"><span style=\"font-size:2em;\"> </span><img style=\"font-size:2em;\" src=\"https://sinergiacrm.org/wp-content/uploads/2019/04/cropped-Logo_SinergiaTIC-5.png\" alt=\"\" width=\"375\" height=\"113\" /></h1><h1 align=\"center\">CERTIFICAT DE DONACIONS</h1><p style=\"padding-left:30px;\" align=\"center\"><span style=\"text-align:justify;\"> </span></p><p> </p><p style=\"padding-left:30px;text-align:justify;\">En/Na.<strong> Nom de la persona que representa l\'organització</strong> , amb DNI <strong>DNI de la dita persona</strong>, en la seva condició de representant de <strong>Nom Organització</strong> amb domicili a <strong>Localitat</strong>, i amb NIF <strong>NIF <strong>Organització</strong></strong>.</p><p style=\"text-align:justify;padding-left:30px;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>CERTIFICA</strong></p><p style=\"text-align:justify;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>PRIMER</strong>.- Que aquesta entitat, constituïda amb data <strong>XX/XX/XXXX</strong>, es troba inclosa dins de les que estan regulades per l\'article 16 de la Llei 49/2002 (entitats beneficiaries de mecenatge).</p><p style=\"text-align:justify;padding-left:30px;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>SEGON</strong>.- Que per ajudar amb l\'acompliment de les finalitats estatutàries de l\'entitat <strong>Nom Organització</strong>, En/Na. <span style=\"color:#808000;\"><strong>$contacts_name</strong></span>, amb <strong><span style=\"color:#808000;\">$contacts_stic_identification_type_c  $contacts_stic_identification_number_c</span></strong>, i resident a provincia de <strong><span style=\"color:#808000;\">$contacts_primary_address_state</span></strong> ha abonat a aquesta organització amb caràcter irrevocable la quantitat de <strong><span style=\"color:#808000;\">$contacts_stic_total_annual_donations_c €</span></strong> al llarg de l\'any 2022<strong><em><a>.</a></em></strong></p><p> </p><p style=\"padding-left:30px;\">A <strong>Localitat</strong>, a {DATE d/m/Y} </p><p> </p><div id=\"sugar_text_gtx-trans\"> </div>', 0, '1', 1, 'Contacts', NULL, '<p style=\"text-align:center;\" align=\"right\"><em><span style=\"font-size:x-small;\"><strong>p.{PAGENO}</strong></span></em></p>', 30, 30, 15, 15, 9, 9, 'A4', 'Portrait'),
-- ('adf40f80-f8d7-4cff-0ed1-63b6ed256afd', 'Exemple - Factures - 01 - Factura a organització', NOW(), NOW(), '1', '1', '<table style=\"width:100%;font-family:Arial;text-align:center;\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tbody style=\"text-align:left;\"><tr style=\"text-align:left;\"><td style=\"text-align:left;\"><p><img style=\"float:left;\" src=\"https://sinergiacrm.org/wp-content/uploads/2019/04/cropped-Logo_SinergiaTIC-5.png\" alt=\"\" width=\"220\" /> </p></td></tr><tr style=\"text-align:left;\"><td style=\"font-weight:bold;text-align:left;\"><div dir=\"ltr\" align=\"left\"><table><colgroup><col width=\"800\" /><col width=\"329\" /></colgroup><tbody><tr><td><p dir=\"ltr\"><strong><span style=\"font-size:small;\">Nom de l\'Organització</span></strong></p></td></tr><tr><td><p dir=\"ltr\"><strong><span style=\"font-size:small;\">Adreça</span></strong></p></td></tr><tr><td><p dir=\"ltr\"><strong><span style=\"font-size:small;\">CP Municipi</span></strong></p></td></tr><tr><td><p dir=\"ltr\"><span style=\"font-size:small;\"><strong>NIF</strong></span></p></td></tr></tbody></table></div></td></tr></tbody></table><p> </p><table style=\"width:619px;border:0pt none;border-spacing:0pt;height:82px;\"><tbody style=\"text-align:left;\"><tr><td style=\"font-weight:bold;text-align:center;\">FACTURA</td></tr><tr style=\"text-align:left;\"><td style=\"font-weight:bold;padding:2px 6px;border-style:solid;border-width:0.5px;vertical-align:top;width:50%;text-align:center;\">Número factura</td><td style=\"font-weight:bold;padding:2px 6px;border-style:solid;border-width:0.5px;vertical-align:top;width:50%;text-align:center;\"> <span>Data factura</span></td></tr><tr style=\"text-align:left;\"><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:50%;vertical-align:top;text-align:center;\"><div>$aos_invoices_number</div></td><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:50%;vertical-align:top;text-align:center;\"> $aos_invoices_invoice_date</td></tr></tbody></table><p> </p><table><tbody><tr style=\"text-align:left;\"><td><strong>FACTURAR A:</strong></td></tr><tr style=\"text-align:left;\"><td style=\"padding:2px 6px;width:50%;vertical-align:top;text-align:left;\"><div><div><span>$aos_invoices_billing_contact$aos_invoices_billing_account</span></div><div><span>$billing_contact_stic_identification_number_c$billing_account_stic_identification_number_c</span></div><div><span>$billing_contact_primary_address_street $billing_account_billing_address_street</span></div><div><span>$billing_contact_primary_address_postalcode $billing_contact_primary_address_city $billing_account_billing_address_postalcode $billing_account_billing_address_city</span></div><div><span>$billing_contact_primary_address_state $billing_account_billing_address_state</span></div> </div></td></tr></tbody></table><table style=\"width:100%;border:0pt none;border-spacing:0pt;\"><tbody><tr><td><strong>DESCRIPCIÓ</strong></td></tr><tr><td>$aos_invoices_description</td></tr></tbody></table><p> </p><table style=\"width:566px;border:0pt none;border-spacing:0pt;height:132px;\"><tbody><tr><td><strong>IMPORTS</strong></td></tr><tr><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:75%;vertical-align:top;text-align:left;\"><div>Total abans d\'impostos</div></td><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:25%;vertical-align:top;text-align:right;\">$aos_invoices_subtotal_amount €</td></tr><tr><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:75%;vertical-align:top;text-align:left;\"><div>IVA</div></td><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:25%;vertical-align:top;text-align:right;\">$aos_invoices_tax_amount €</td></tr><tr><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:75%;vertical-align:top;text-align:left;\"><div><strong>TOTAL</strong></div></td><td style=\"padding:2px 6px;border-style:solid;border-width:0.5px;width:25%;vertical-align:top;text-align:right;\">$aos_invoices_total_amount €</td></tr></tbody></table><p> </p><table style=\"width:656px;border:0pt none;border-spacing:0pt;height:90px;\"><tbody><tr><td><strong>FORMA DE PAGAMENT</strong></td></tr><tr><td>Transferència bancària a BANC ESXX XXXX XXXX XXXX XXXX XXXX</td></tr><tr><td><p>Venciment: $aos_invoices_due_date</p></td></tr></tbody></table><p> </p><div id=\"sugar_text_gtx-trans\"> </div>', 0, '1', 1, 'AOS_Invoices', '', '<p style=\"text-align:right;\"><span style=\"font-size:x-small;\"><em><strong>p.{PAGENO}</strong></em></span></p>', 15, 15, 16, 16, 5, 9, 'A4', 'Portrait'),
('cc2864ec-85aa-6838-dcd2-63b6ac981294', 'Exemple - Organitzacions - 01 - Certificat de donacions anual', NOW(), NOW(), '1', '1', '<h1 align=\"center\"><span style=\"font-size:2em;\"> </span><img style=\"font-size:2em;\" src=\"https://sinergiacrm.org/wp-content/uploads/2019/04/cropped-Logo_SinergiaTIC-5.png\" alt=\"\" width=\"375\" height=\"113\" /></h1><h1 align=\"center\">CERTIFICAT DE DONACIONS</h1><p style=\"padding-left:30px;\" align=\"center\"><span style=\"text-align:justify;\"> </span></p><p style=\"padding-left:30px;text-align:justify;\">En/Na.<strong> Nom de la persona que representa l\'organització</strong> , amb DNI <strong>DNI de la dita persona</strong>, en la seva condició de representant de <strong>Nom Organització</strong> amb domicili a <strong>Localitat</strong>, i amb NIF <strong>NIF <strong>Organització</strong></strong>.</p><p style=\"text-align:justify;padding-left:30px;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>CERTIFICA</strong></p><p style=\"text-align:justify;padding-left:30px;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>PRIMER</strong>.- Que aquesta entitat, constituïda amb data <strong>XX/XX/XXXX</strong>, es troba inclosa dins de les que estan regulades per l\'article 16 de la Llei 49/2002 (entitats beneficiaries de mecenatge).</p><p style=\"padding-left:30px;\"> </p><p style=\"text-align:justify;padding-left:30px;\"><strong>SEGON</strong>.- Que per ajudar amb l\'acompliment de les finalitats estatutàries de l\'entitat <strong>Associació SinergiaTIC</strong>, <span style=\"color:#808000;\"><strong>$accounts_name</strong></span>, amb número d\'identificació fiscal <span style=\"color:#808000;\"><strong>$accounts_stic_identification_number_c</strong></span>, i amb domicili a la provincia de <strong><span style=\"color:#808000;\">$accounts_billing_address_state</span></strong> ha abonat a aquesta organització amb caràcter irrevocable la quantitat de <strong><span style=\"color:#808000;\">$accounts_stic_total_annual_donations_c</span><span style=\"color:#808000;\"> €</span></strong> al llarg de l\'any 2022<strong><em><a>.</a></em></strong></p><p style=\"padding-left:30px;\">  </p><p style=\"padding-left:30px;\">A <strong>Localitat</strong>, a {DATE d/m/Y} </p><p> </p>', 0, '1', 1, 'Accounts', NULL, '<p style=\"text-align:center;\" align=\"right\"><em><span style=\"font-size:x-small;\"><strong>p.{PAGENO}</strong></span></em></p>', 30, 30, 15, 15, 9, 9, 'A4', 'Portrait');
