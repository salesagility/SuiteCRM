<?php

require_once __DIR__ . '/../TemplateSampleService.php';

class smpl_Contact_Sample
{
    public function getType()
    {
        return 'Contacts';
    }
        
    public function getBody()
    {
        global $locale;
        return '<table style="width: 100%;" border="0" cellspacing="2" cellpadding="2">
<tbody style="text-align: left;">
<tr>
<td valign="top">
<p><img src="'. TemplateSampleService::getAbsoluteLogoUrl() .'" style="float: left;"/>&nbsp;</p>
</td>
<td style="font-weight: bold; text-align: right;"><div>'.translate('LBL_BROWSER_TITLE').' Ltd<br />'.translate('LBL_ANY_STREET', 'AOS_PDF_Templates').'<br />'.translate('LBL_ANY_TOWN', 'AOS_PDF_Templates').'</span><br />'.translate('LBL_ANY_WHERE', 'AOS_PDF_Templates').'</div></td>
</tr>
</tbody>
</table>
<div><br /></div>
<div>$contacts_name<br /></div>
<div>$accounts_name<br /> $contacts_primary_address_street<br /> $contacts_primary_address_city<br /> $contacts_primary_address_state<br /> $contacts_primary_address_postalcode</div>
<div><br /></div>
<div>{DATE '.$locale->getPrecedentPreference('default_date_format').'}</div>
<div><br /></div>
<p>Dear $contacts_first_name</p>
<p>OpenSales was originally designed and conceived by Rustin Phares. In  2009, when Rustin could no longer devote time to the project, which is  an important one for the Community Edition of SugarCRM, SalesAgility approached him to seek permission to pick up where he had left off.</p>
<p>In early 2010 we released the first iteration of what was now to be  called "Advanced OpenSales". Since then there have been regular releases  to bring Advanced OpenSales into line with the latest releases of  SugarCRM and to advance the functionality.</p>
<p>2011 saw a complete rewrite of Advanced OpenSales to bring it into  line with the 5.x and 6.x architectures and the introduction of an  Invoice module. In March 2011, an Invoicing module for SugarCRM  Professional Edition was also released.</p>
<p>Advanced OpenSales is released under the Affero General Purpose  License meaning it&#39;s Open Source and freely available. That does not  mean that there is no cost involved in making it. Thousands of man hours  have gone in to developing and maintaining these modules. Any  contributions that assist us in keeping the project on an even keel are  gratefully received.</p>
<p>SalesAgility are SugarCRM experts. With offices in Manchester and Central Scotland,  we&#39;re ideally placed to serve your SugarCRM requirements. As  consultants, we design and implement tailored Sugar CRM instances. As  software developers, we design and deliver customised instances of Sugar  CRM that meet the more specialist needs of our clients. As a support  organisation we deliver training, hosting and help-desk services to  ensure that our clients continue to get best value from their Sugar  investment.</p>
<p>Yours sincerely</p>
<p> </p>
<p> </p>
<p>Someone</p>';
    }

    public function getHeader()
    {
        return '';
    }

    public function getFooter()
    {
        return '';
    }
}
