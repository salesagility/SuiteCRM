<?php		
/**		
 *		
 * SugarCRM Community Edition is a customer relationship management program developed by		
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.		
 *		
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.		
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.		
 *		
 * This program is free software; you can redistribute it and/or modify it under		
 * the terms of the GNU Affero General Public License version 3 as published by the		
 * Free Software Foundation with the addition of the following permission added		
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK		
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY		
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.		
 *		
 * This program is distributed in the hope that it will be useful, but WITHOUT		
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS		
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more		
 * details.		
 *		
 * You should have received a copy of the GNU Affero General Public License along with		
 * this program; if not, see http://www.gnu.org/licenses or write to the Free		
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA		
 * 02110-1301 USA.		
 *		
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,		
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.		
 *		
 * The interactive user interfaces in modified source and object code versions		
 * of this program must display Appropriate Legal Notices, as required under		
 * Section 5 of the GNU Affero General Public License version 3.		
 *		
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,		
 * these Appropriate Legal Notices must retain the display of the "Powered by		
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not		
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must		
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".		
 */		
		
if (!defined('sugarEntry') || !sugarEntry) {		
    die('Not A Valid Entry Point');		
}		
		
//the left value is the key stored in the db and the right value is ie display value		
//to translate, only modify the right value in each key/value pair		
$app_list_strings 		 array(
//e.g. auf Deutsch 'Contacts'	=>'Contakten',
    'language_pack_name' 	=> 'US English',
    'moduleList' 	=> array(
        'Home' 	=> 'Ana Sayfa',
        'ResourceCalendar' 	=> 'Kaynak Takvimi',
        'Contacts' 	=> 'Kişiler'
        'Accounts' 	=> 'Hesaplar',
        'Alerts' 	=> 'Uyarılar',
        'Opportunities' 	=> 'Fırsatlar',
        'Cases' 	=> 'Durumlar',
        'Notes' 	=> 'Notlar',
        'Calls' 	=> 'Çağrılar',
        'TemplateSectionLine' 	=> 'Şablon Kesit Hattı',
        'Calls_Reschedule' 	=> 'Çağrıları Yeniden Planla',
        'Emails' 	=> 'E-postalar'
        'EAPM' 	=> 'EAPM',
        'Meetings' 	=> 'Toplantılar',
        'Tasks' 	=> 'Görevler',
        'Calendar' 	=> 'Takvim',
        'Leads' 	=> 'Kurşun',
        'Currencies' 	=> 'Para Birimleri',
        'Activities' 	=> 'Etkinlikler',
        'Bugs' 	=> 'Bugs',
        'Feeds' 	=> 'Beslemeler',
        'iFrames' 	=> 'Sitelerim'
        'TimePeriods' 	=> 'Zaman Periyotları',
        'ContractTypes' 	=> 'Sözleşme Türleri',
        'Schedulers' 	=> 'Zamanlayıcılar',
        'Project' 	=> 'Projeler',
        'ProjectTask' 	=> 'Proje Görevleri',
        'Campaigns' 	=> 'Kampanyalar',
        'CampaignLog' 	=> 'Kampanya Günlüğü'
        'Documents' 	=> 'Belgeler',
        'DocumentRevisions' 	=> 'Belge Değişiklikleri',
        'Connectors' 	=> 'Konnektörler',
        'Roles' 	=> 'Roller',
        'Notifications' 	=> 'Bildirimler',
        'Sync' 	=> 'Senkronize et',
        'Users' 	=> 'Kullanıcılar',
        'Employees' 	=> 'Çalışanlar',
        'Administration' 	=> 'İdare',
        'ACLRoles' 	=> 'Roller',
        'InboundEmail' 	=> 'Gelen E-posta',
        'Releases' 	=> 'Bültenler',
        'Prospects' 	=> 'Hedefler',
        'Queues' 	=> 'Kuyruklar',
        'EmailMarketing' 	=> 'E-posta Pazarlaması'
        'EmailTemplates' 	=> 'E-posta Şablonları',
        'ProspectLists' 	=> 'Hedef Listeler',
        'SavedSearch' 	=> 'Kayıtlı Aramalar'
        'UpgradeWizard' 	=> 'Yükseltme Sihirbazı',
        'Trackers' 	=> 'İzleyiciler',
        'TrackerSessions' 	=> 'İzleyici Oturumu',
        'TrackerQueries' 	=> 'İzleyici Sorguları',
        'FAQ' 	=> 'SSS',
        'Newsletters' 	=> 'Haber bültenleri',
        'SugarFeed' 	=> 'SuiteCRM Yayını',
        'SugarFavorites' 	=> 'SuiteCRM Sık Kullanılanları',
		
        'OAuthKeys' 	=> 'OAuth Tüketici Anahtarı',
        'OAuthTokens' 	=> 'OAuth Simgeleri',
    ),		
		
    'moduleListSingular' 	=> array(
        'Home' 	=> 'Ana Sayfa',
        'Dashboard' 	=> 'Gösterge tablosu',
        'Contacts' 	=> 'İletişim',
        'Accounts' 	=> 'Hesap',
        'Opportunities' 	=> 'Fırsat',
        'Cases' 	=> 'Durum',
        'Notes' 	=> 'Not',
        'Calls' 	=> 'Ara',
        'Emails' 	=> 'E-posta',
        'EmailTemplates' 	=> 'E-posta Şablonu'
        'Meetings' 	=> 'Toplantı',
        'Tasks' 	=> 'Görev',
        'Calendar' 	=> 'Takvim',
        'Leads' 	=> 'Kurşun',
        'Activities' 	=> 'Etkinlik',
        'Bugs' 	=> 'Hata',
        'KBDocuments' 	=> 'KBDocument',
        'Feeds' 	=> 'RSS',
        'iFrames' 	=> 'Sitelerim'
        'TimePeriods' 	=> 'Zaman aralığı',
        'Project' 	=> 'Proje',
        'ProjectTask' 	=> 'Proje Görevi',
        'Prospects' 	=> 'Hedef',
        'Campaigns' 	=> 'Kampanya',
        'Documents' 	=> 'Belge',
        'Sync' 	=> 'Senkronize et',
        'Users' 	=> 'Kullanıcı',
        'SugarFavorites' 	=> 'SuiteCRM Sık Kullanılanları',
		
    ),		
		
    'checkbox_dom' 	=> array(
        '' 	=> '',
        '1' 	=> 'Evet',
        '2' 	=> 'Hayır',
    ),		
		
    //e.g. en franï¿½ais 'Analyst'		>'Analyste',
    'account_type_dom' 	=> array(
        '' 	=> '',
        'Analyst' 	=> 'Analist',
        'Competitor' 	=> 'Rakip',
        'Customer' 	=> 'Müşteri',
        'Integrator' 	=> 'Integrator',
        'Investor' 	=> 'Yatırımcı',
        'Partner' 	=> 'Ortak',
        'Press' 	=> 'Basın',
        'Prospect' 	=> 'Prospect',
        'Reseller' 	=> 'Bayi',
        'Other' 	=> 'Diğer'
    ),		
    //e.g. en espaï¿½ol 'Apparel'	=>'Ropa',
    'industry_dom' 	=> array(
        '' 	=> '',
        'Apparel' 	=> 'Kıyafet',
        'Banking' 	=> 'Bankacılık',
        'Biotechnology' 	=> 'Biyoteknoloji',
        'Chemicals' 	=> 'Kimyasallar',
        'Communications' 	=> 'İletişim',
        'Construction' 	=> 'İnşaat',
        'Consulting' 	=> 'Danışmanlık',
        'Education' 	=> 'Eğitim',
        'Electronics' 	=> 'Elektronik',
        'Energy' 	=> 'Enerji',
        'Engineering' 	=> 'Mühendislik',
        'Entertainment' 	=> 'Eğlence',
        'Environmental' 	=> 'Çevre',
        'Finance' 	=> 'Maliye',
        'Government' 	=> 'Hükümet'
        'Healthcare' 	=> 'Sağlık hizmetleri'
        'Hospitality' 	=> 'Misafirperverlik',
        'Insurance' 	=> 'Sigorta',
        'Machinery' 	=> 'Makine',
        'Manufacturing' 	=> 'İmalat',
        'Media' 	=> 'Medya',
        'Not For Profit' 	=> 'Kâr için değil'
        'Recreation' 	=> 'Rekreasyon',
        'Retail' 	=> 'Perakende',
        'Shipping' 	=> 'Nakliye',
        'Technology' 	=> 'Teknoloji',
        'Telecommunications' 	=> 'Telekomünikasyon',
        'Transportation' 	=> 'Ulaşım',
        'Utilities' 	=> 'Kamu hizmetleri'
        'Other' 	=> 'Diğer'
    ),		
    'lead_source_default_key' 	=> 'Kendinden Üretilmiş'
    'lead_source_dom' 	=> array(
        '' 	=> '',
        'Cold Call' 	=> 'Soğuk Çağrı',
        'Existing Customer' 	=> 'Mevcut Müşteri',
        'Self Generated' 	=> 'Kendinden Üretilmiş'
        'Employee' 	=> 'Çalışan',
        'Partner' 	=> 'Ortak',
        'Public Relations' 	=> 'Halkla İlişkiler',
        'Direct Mail' 	=> 'Doğrudan Posta',
        'Conference' 	=> 'Konferans',
        'Trade Show' 	=> 'Ticaret fuarı'
        'Web Site' 	=> 'Web Sitesi',
        'Word of mouth' 	=> 'Ağız Sandığı'
        'Email' 	=> 'E-posta',
        'Campaign' 	=> 'Kampanya',
        'Other' 	=> 'Diğer'
    ),		
    'opportunity_type_dom' 	=> array(
        '' 	=> '',
        'Existing Business' 	=> 'Mevcut İşler'
        'New Business' 	=> 'Yeni İşler'
    ),		
    'roi_type_dom' 	=> array(
        'Revenue' 	=> 'Gelir',
        'Investment' 	=> 'Yatırım',
        'Expected_Revenue' 	=> 'Beklenen Gelir'
        'Budget' 	=> 'Bütçe',
		
    ),		
    //Note:  do not translate opportunity_relationship_type_default_key
//       it is the key for the default opportunity_relationship_type_dom value
    'opportunity_relationship_type_default_key' 	=> 'Primary Decision Maker',
    'opportunity_relationship_type_dom' 	=> array(
        '' 	=> '',
        'Primary Decision Maker' 	=> 'Birincil Karar Üreticisi',
        'Business Decision Maker' 	=> 'İş Karar Verme Makinesi',
        'Business Evaluator' 	=> 'İş Değerlendiricisi',
        'Technical Decision Maker' 	=> 'Teknik Karar Üreticisi',
        'Technical Evaluator' 	=> 'Teknik Değerlendirici',
        'Executive Sponsor' 	=> 'Yürütme Sponsoru',
        'Influencer' 	=> 'Influencer',
        'Other' 	=> 'Diğer'
    ),		
    //Note:  do not translate case_relationship_type_default_key
//       it is the key for the default case_relationship_type_dom value
    'case_relationship_type_default_key' 	=> 'Primary Contact',
    'case_relationship_type_dom' 	=> array(
        '' 	=> '',
        'Primary Contact' 	=> 'Birincil Temas',
        'Alternate Contact' 	=> 'Alternatif Kişi',
    ),		
    'payment_terms' 	=> array(
        '' 	=> '',
        'Net 15' 	=> 'Net 15',
        'Net 30' 	=> 'Net 30',
    ),		
    'sales_stage_default_key' 	=> 'Prospecting',
    'sales_stage_dom' 	=> array(
        'Prospecting' 	=> 'Prospeksiyon',
        'Qualification' 	=> 'Yeterlilik',
        'Needs Analysis' 	=> 'İhtiyaç Analizi',
        'Value Proposition' 	=> 'Değer Önerisi',
        'Id. Decision Makers' 	=> 'Karar Verenlerin Belirlenmesi',
        'Perception Analysis' 	=> 'Algı Analizi',
        'Proposal/Price Quote' 	=> 'Teklif / Fiyat Teklifi',
        'Negotiation/Review' 	=> 'Müzakere / İnceleme',
        'Closed Won' 	=> 'Kazanılmış Kazanılan'
        'Closed Lost' 	=> 'Kayıp Kapandı'
    ),		
    'sales_probability_dom' 	=> // keys must be the same as sales_stage_dom
        array(
            'Prospecting' 	=> '10',
            'Qualification' 	=> '20',
            'Needs Analysis' 	=> '25',
            'Value Proposition' 	=> '30',
            'Id. Decision Makers' 	=> '40',
            'Perception Analysis' 	=> '50',
            'Proposal/Price Quote' 	=> '65',
            'Negotiation/Review' 	=> '80',
            'Closed Won' 	=> '100',
            'Closed Lost' 	=> '0',
        ),		
    'activity_dom' 	=> array(
        'Call' 	=> 'Ara',
        'Meeting' 	=> 'Toplantı',
        'Task' 	=> 'Görev',
        'Email' 	=> 'E-posta',
        'Note' 	=> 'Not',
    ),		
    'salutation_dom' 	=> array(
        '' 	=> '',
        'Mr.' 	=> 'Bay',
        'Ms.' 	=> 'Bayan',
        'Mrs.' 	=> 'Bayan',
        'Dr.' 	=> 'Dr.'
        'Prof.' 	=> 'Prof.',
    ),		
    //time is in seconds; the greater the time the longer it takes;
    'reminder_max_time' 	=> 90000,
    'reminder_time_options' 	=> array(
60	=> '1 dakika önce',
300	=> '5 dakika önce',
600	=> '10 dakika önce ',
900	=> '15 dakika önce ',
1800	=> '30 dakika önce ',
3600	=> '1 saat önce',
7200	=> '2 saat önce',
10800	=> '3 saat önce',
18000	=> '5 saat önce',
86400	=> '1 gün önce',
    ),		
		
    'task_priority_default' 	=> 'Orta',
    'task_priority_dom' 	=> array(
        'High' 	=> 'Yüksek',
        'Medium' 	=> 'Orta',
        'Low' 	=> 'Düşük',
    ),		
    'task_status_default' 	=> 'Başlamadı',
    'task_status_dom' 	=> array(
        'Not Started' 	=> 'Başlamadı',
        'In Progress' 	=> 'İlerlemiyor',
        'Completed' 	=> 'Tamamlandı',
        'Pending Input' 	=> 'Beklemede Girdi',
        'Deferred' 	=> 'Ertelendi'
    ),		
    'meeting_status_default' 	=> 'Planlı',
    'meeting_status_dom' 	=> array(
        'Planned' 	=> 'Planlı',
        'Held' 	=> 'Bekletildi'
        'Not Held' 	=> 'Yapılmadı',
    ),		
    'extapi_meeting_password' 	=> array(
        'WebEx' 	=> 'WebEx',
    ),		
    'meeting_type_dom' 	=> array(
        'Other' 	=> 'Diğer',
        'Sugar' 	=> 'SuiteCRM',
    ),		
    'call_status_default' 	=> 'Planlı',
    'call_status_dom' 	=> array(
        'Planned' 	=> 'Planlı',
        'Held' 	=> 'Bekletildi'
        'Not Held' 	=> 'Yapılmadı',
    ),		
    'call_direction_default' 	=> 'Giden',
    'call_direction_dom' 	=> array(
        'Inbound' 	=> 'Gelen',
        'Outbound' 	=> 'Giden',
    ),		
    'lead_status_dom' 	=> array(
        '' 	=> '',
        'New' 	=> 'Yeni',
        'Assigned' 	=> 'Atandı',
        'In Process' 	=> 'İşlemde',
        'Converted' 	=> 'Dönüştürülmüş'
        'Recycled' 	=> 'Geri Dönüşümlü'
        'Dead' 	=> 'Ölü',
    ),		
    'case_priority_default_key' 	=> 'P2',
    'case_priority_dom' 	=> array(
        'P1' 	=> 'Yüksek',
        'P2' 	=> 'Orta',
        'P3' 	=> 'Düşük',
    ),		
    'user_type_dom' 	=> array(
        'RegularUser' 	=> 'Düzenli Kullanıcı',
        'Administrator' 	=> 'Yönetici',
    ),		
    'user_status_dom' 	=> array(
        'Active' 	=> 'Aktif',
        'Inactive' 	=> 'Etkin değil',
    ),		
    'employee_status_dom' 	=> array(
        'Active' 	=> 'Aktif',
        'Terminated' 	=> 'Sona Erdi',
        'Leave of Absence' 	=> 'İzin Yok',
    ),		
    'messenger_type_dom' 	=> array(
        '' 	=> '',
        'MSN' 	=> 'MSN',
        'Yahoo!' 	=> 'Yahoo!',
        'AOL' 	=> 'AOL',
    ),		
    'project_task_priority_options' 	=> array(
        'High' 	=> 'Yüksek',
        'Medium' 	=> 'Orta',
        'Low' 	=> 'Düşük',
    ),		
    'project_task_priority_default' 	=> 'Orta',
		
    'project_task_status_options' 	=> array(
        'Not Started' 	=> 'Başlamadı',
        'In Progress' 	=> 'İlerlemiyor',
        'Completed' 	=> 'Tamamlandı',
        'Pending Input' 	=> 'Beklemede Girdi',
        'Deferred' 	=> 'Ertelendi'
    ),		
    'project_task_utilization_options' 	=> array(
        '0' 	=> 'yok',
        '25' 	=> '25',
        '50' 	=> '50',
        '75' 	=> '75',
        '100' 	=> '100',
    ),		
	'project_status_dom' 	=> array(
        'Draft' 	=> 'Taslak',
        'In Review' 	=> 'İnceleme',
        'Underway' 	=> 'Yürütülüyor',
        'On_Hold' 	=> 'Beklemede',
        'Completed' 	=> 'Tamamlandı',
    ),		
    'project_status_default' 	=> 'Taslak',
		
    'project_duration_units_dom' 	=> array (
        'Days' 	=> 'Günler',
        'Hours' 	=> 'Saatler',
    ),		
	
    'activity_status_type_dom' 	=> array (
        '' 	=> "Hiçkimse--"
        'active' 	=> 'Aktif',
        'inactive' 	=> 'Etkin değil',
    ),		
	
    // Note:  do not translate record_type_default_key
    //        it is the key for the default record_type_module value
    'record_type_default_key' 	=> 'Hesaplar',
    'record_type_display' 	=> array (
        '' 	=> '',
        'Accounts' 	=> 'Hesap',
        'Opportunities' 	=> 'Fırsat',
        'Cases' 	=> 'Durum',
        'Leads' 	=> 'Kurşun',
        'Contacts' 	=> 'İletişim', // cn (11/22/2005) e-postaları desteklemek için eklendi
		
        'Bugs' 	=> 'Hata',
        'Project' 	=> 'Proje',
	
        'Prospects' 	=> 'Hedef',
        'ProjectTask' 	=> 'Proje Görevi',
		
        'Tasks' 	=> 'Görev',
		
    ),		
	
    'record_type_display_notes' 	=> array (
        'Accounts' 	=> 'Hesap',
        'Contacts' 	=> 'İletişim',
        'Opportunities' 	=> 'Fırsat',
        'Tasks' 	=> 'Görev',
        'Emails' 	=> 'E-posta',
		
        'Bugs' 	=> 'Hata',
        'Project' 	=> 'Proje',
        'ProjectTask' 	=> 'Proje Görevi',
        'Prospects' 	=> 'Hedef',
        'Cases' 	=> 'Durum',
        'Leads' 	=> 'Kurşun',
		
        'Meetings' 	=> 'Toplantı',
        'Calls' 	=> 'Ara',
    ),		
		
    'parent_type_display' 	=> array (
        'Accounts' 	=> 'Hesap',
        'Contacts' 	=> 'İletişim',
        'Tasks' 	=> 'Görev',
        'Opportunities' 	=> 'Fırsat',
		
        'Bugs' 	=> 'Hata',
        'Cases' 	=> 'Durum',
        'Leads' 	=> 'Kurşun',
		
        'Project' 	=> 'Proje',
        'ProjectTask' 	=> 'Proje Görevi',
		
        'Prospects' 	=> 'Hedef',
		
        ),		
    'parent_line_items' 	=> array (
        'AOS_Quotes' 	=> 'Tırnaklar',
        'AOS_Invoices' 	=> 'Faturalar',
        'AOS_Contracts' 	=> 'Sözleşmeler',
    ),		
    'issue_priority_default_key' 	=> 'Orta',
    'issue_priority_dom' 	=> array (
        'Urgent' 	=> 'Acil',
        'High' 	=> 'Yüksek',
        'Medium' 	=> 'Orta',
        'Low' 	=> 'Düşük',
    ),		
    'issue_resolution_default_key' 	=> '',
    'issue_resolution_dom' 	=> array (
        '' 	=> '',
        'Accepted' 	=> 'Kabul Edildi'
        'Duplicate' 	=> 'Çoğalt'
        'Closed' 	=> 'Kapalı',
        'Out of Date' 	=> 'Güncel Değil'
        'Invalid' 	=> 'Geçersiz'
    ),		
		
    'issue_status_default_key' 	=> 'Yeni',
    'issue_status_dom' 	=> array (
        'New' 	=> 'Yeni',
        'Assigned' 	=> 'Atandı',
        'Closed' 	=> 'Kapalı',
        'Pending' 	=> 'Beklemede',
        'Rejected' 	=> 'Reddedildi'
    ),		
		
    'bug_priority_default_key' 	=> 'Orta',
    'bug_priority_dom' 	=> array (
        'Urgent' 	=> 'Acil',
        'High' 	=> 'Yüksek',
        'Medium' 	=> 'Orta',
        'Low' 	=> 'Düşük',
    ),		
    'bug_resolution_default_key' 	=> '',
    'bug_resolution_dom' 	=> array (
        '' 	=> '',
        'Accepted' 	=> 'Kabul Edildi'
        'Duplicate' 	=> 'Çoğalt'
        'Fixed' 	=> 'Sabit',
        'Out of Date' 	=> 'Güncel Değil'
        'Invalid' 	=> 'Geçersiz'
        'Later' 	=> 'Daha Sonra',
    ),		
    'bug_status_default_key' 	=> 'Yeni',
    'bug_status_dom' 	=> array (
        'New' 	=> 'Yeni',
        'Assigned' 	=> 'Atandı',
        'Closed' 	=> 'Kapalı',
        'Pending' 	=> 'Beklemede',
        'Rejected' 	=> 'Reddedildi'
    ),		
    'bug_type_default_key' 	=> 'Hata',
    'bug_type_dom' 	=> array (
        'Defect' 	=> 'Kusur',
        'Feature' 	=> 'Özellik',
    ),		
    'case_type_dom' 	=> array (
        'Administration' 	=> 'İdare',
        'Product' 	=> 'Ürün',
        'User' 	=> 'Kullanıcı',
    ),		
		
    'source_default_key' 	=> '',
    'source_dom' 	=> array (
        '' 	=> '',
        'Internal' 	=> 'Dahili',
        'Forum' 	=> 'Forum',
        'Web' 	=> 'Web',
        'InboundEmail' 	=> 'E-posta',
    ),		

    'product_category_default_key' 	=> '',
    'product_category_dom' 	=> array (
        '' 	=> '',
        'Accounts' 	=> 'Hesaplar',
        'Activities' 	=> 'Etkinlikler',
        'Bugs' 	=> 'Bugs',
        'Calendar' 	=> 'Takvim',
        'Calls' 	=> 'Çağrılar',
        'Campaigns' 	=> 'Kampanyalar',
        'Cases' 	=> 'Durumlar',
        'Contacts' 	=> 'Kişiler'
        'Currencies' 	=> 'Para Birimleri',
        'Dashboard' 	=> 'Gösterge tablosu',
        'Documents' 	=> 'Belgeler',
        'Emails' 	=> 'E-postalar'
        'Feeds' 	=> 'Beslemeler',
        'Forecasts' 	=> 'Tahminler',
        'Help' 	=> 'Yardım',
        'Home' 	=> 'Ev',
        'Leads' 	=> 'Kurşun',
        'Meetings' 	=> 'Toplantılar',
        'Notes' 	=> 'Notlar',
        'Opportunities' 	=> 'Fırsatlar',
        'Outlook Plugin' 	=> 'Outlook Eklentisi',
        'Projects' 	=> 'Projeler',
        'Quotes' 	=> 'Tırnaklar',
        'Releases' 	=> 'Bültenler',
        'RSS' 	=> 'RSS',
        'Studio' 	=> 'Stüdyo',
        'Upgrade' 	=> 'Yükseltme',
        'Users' 	=> 'Kullanıcılar',
    ),		
    /*Added entries 'Queued' and 'Sending' for 4.0 release..*/
    'campaign_status_dom' 	=> array (
        '' 	=> '',
        'Planning' 	=> 'Planlama',
        'Active' 	=> 'Aktif',
        'Inactive' 	=> 'Etkin değil',
        'Complete' 	=> 'Tamamlandı',
        //'In Queue' 	=> 'Kuyrukta',
        //'Sending' 	=> 'Gönderme',
    ),		
    'campaign_type_dom' 	=> array (
        '' 	=> '',
        'Telesales' 	=> 'Telesayetler'
        'Mail' 	=> 'Posta',
        'Email' 	=> 'E-posta',
        'Print' 	=> 'Baskı',
        'Web' 	=> 'Web',
        'Radio' 	=> 'Radyo',
        'Television' 	=> 'Televizyon',
        'NewsLetter' 	=> 'Haber bülteni'
    ),		

    'newsletter_frequency_dom' 	=> array (
        '' 	=> '',
        'Weekly' 	=> 'Haftalık',
        'Monthly' 	=> 'Aylık',
        'Quarterly' 	=> 'Üç Aylık',
        'Annually' 	=> 'Yıllık',
    ),		

    'notifymail_sendtype' 	=> array (
        'SMTP' 	=> 'SMTP',
    ),		
    'dom_cal_month_long' 	=> array (
        '0' 	=> '',
        '1' 	=> 'Ocak',
        '2' 	=> 'Şubat',
        '3' 	=> 'Mart',
        '4' 	=> 'Nisan'
        '5' 	=> 'Mayıs',
        '6' 	=> 'Haziran',
        '7' 	=> 'Temmuz',
        '8' 	=> 'Ağustos',
        '9' 	=> 'Eylül',
        '10' 	=> 'Ekim',
        '11' 	=> 'Kasım',
        '12' 	=> 'Aralık',
    ),		
    'dom_cal_month_short' 	=> array (
        '0' 	=> '',
        '1' 	=> 'Jan',
        '2' 	=> 'Şubat',
        '3' 	=> 'Mar',
        '4' 	=> 'Nis',
        '5' 	=> 'Mayıs',
        '6' 	=> 'Haz',
        '7' 	=> 'Temmuz',
        '8' 	=> 'Ağustos',
        '9' 	=> 'Eylül',
        '10' 	=> 'Ekim',
        '11' 	=> 'Kasım',
        '12' 	=> 'Ara',
    ),		
    'dom_cal_day_long' 	=> array (
        '0' 	=> '',
        '1' 	=> 'Pazar',
        '2' 	=> 'Pazartesi',
        '3' 	=> 'Salı',
        '4' 	=> 'Çarşamba',
        '5' 	=> 'Perşembe',
        '6' 	=> 'Cuma',
        '7' 	=> 'Cumartesi',
    ),		
    'dom_cal_day_short' 	=> array (
        '0' 	=> '',
        '1' 	=> 'Güneş',
        '2' 	=> 'Pzt',
        '3' 	=> 'Salı',
        '4' 	=> 'Çarşamba',
        '5' 	=> 'Per',
        '6' 	=> 'Cum',
        '7' 	=> 'Sat',
    ),		
    'dom_meridiem_lowercase' 	=> array (
        'am' 	=> 'ben',
        'pm' 	=> 'pm',
    ),		
    'dom_meridiem_uppercase' 	=> array (
        'AM' 	=> 'AM',
        'PM' 	=> 'PM',
    ),		

    'dom_email_types' 	=> array (
        'out' 	=> 'Gönderildi'
        'archived' 	=> 'Arşivlenmiş'
        'draft' 	=> 'Taslak',
        'inbound' 	=> 'Gelen',
        'campaign' 	=> 'Kampanya',
    ),		
    'dom_email_status' 	=> array (
        'archived' 	=> 'Arşivlenmiş'
        'closed' 	=> 'Kapalı',
        'draft' 	=> 'Taslakta',
        'read' 	=> 'Oku',
        'replied' 	=> 'Yanıtlandı',
        'sent' 	=> 'Gönderildi'
        'send_error' 	=> 'Hata Gönder',
        'unread' 	=> 'Okunmamış'
    ),		
    'dom_email_archived_status' 	=> array (
        'archived' 	=> 'Arşivlenmiş'
    ),		

    'dom_email_server_type' 	=> array (
        '' 	=> "Hiçkimse--"
        'imap' 	=> 'IMAP',
    ),		
    'dom_mailbox_type' 	=> array (/ * ''
        'pick' 	=> "Hiçkimse--"
        'createcase' 	=> 'Vaka Oluşturma',
        'bounce' 	=> 'Bounce Handling',
    ),		
    'dom_email_distribution' 	=> array (
        '' 	=> "Hiçkimse--"
        'direct' 	=> 'Doğrudan Atama',
        'roundRobin' 	=> 'Yuvarlak Robin',
        'leastBusy' 	=> 'En Az Yoğun'
    ),		
    'dom_email_bool' 	=> array (
        'bool_true' 	=> 'Evet',
        'bool_false' 	=> 'Hayır',
    ),		
    'dom_int_bool' 	=> array (
1	=> 'Evet',
0	=> 'Hayır',
    ),		
    'dom_switch_bool' 	=> array (
        'on' 	=> 'Evet',
        'off' 	=> 'Hayır',
        '' 	=> 'Hayır',
    ),		

    'dom_email_link_type' 	=> array (
        'sugar' 	=> 'SuiteCRM E-posta İstemcisi',
        'mailto' 	=> 'Harici E-posta İstemcisi',
    ),		

    'dom_editor_type' 	=> array (
        'none' 	=> 'Doğrudan HTML',
        'tinymce' 	=> 'TinyMCE',
        'mozaik' 	=> 'Mozaik',
    ),		

    'dom_email_editor_option' 	=> array (
        '' 	=> 'Varsayılan E-posta Formatı',
        'html' 	=> 'HTML E-postası',
        'plain' 	=> 'Düz Metin E-posta',
    ),		

    'schedulers_times_dom' 	=> array (
        'not run' 	=> 'Geçmiş Çalışma Zamanı, Çalıştırılmadı',
        'ready' 	=> 'Hazır',
        'in progress' 	=> 'İlerlemiyor',
        'failed' 	=> 'Başarısız',
        'completed' 	=> 'Tamamlandı',
        'no curl' 	=> 'Çalışmıyor: Mevcut cURL yok',
    ),		

    'scheduler_status_dom' 	=> array (
        'Active' 	=> 'Aktif',
        'Inactive' 	=> 'Etkin değil',
    ),		

    'scheduler_period_dom' 	=> array (
        'min' 	=> 'Dakika',
        'hour' 	=> 'Saatler',
    ),		
    'document_category_dom' 	=> array (
        '' 	=> '',
        'Marketing' 	=> 'Pazarlama'
        'Knowledege Base' 	=> 'Bilgi Bankası',
        'Sales' 	=> 'Satış',
    ),		

    'email_category_dom' 	=> array (
        '' 	=> '',
        'Archived' 	=> 'Arşivlenmiş'
        // TODO: add more categories here...
    ),		

    'document_subcategory_dom' 	=> array (
        '' 	=> '',
        'Marketing Collateral' 	=> 'Pazarlama Teminatı',
        'Product Brochures' 	=> 'Ürün Broşürleri',
        'FAQ' 	=> 'SSS',
    ),		

    'document_status_dom' 	=> array (
        'Active' 	=> 'Aktif',
        'Draft' 	=> 'Taslak',
        'FAQ' 	=> 'SSS',
        'Expired' 	=> 'Süresi Doldu',
        'Under Review' 	=> 'İnceleniyor',
        'Pending' 	=> 'Beklemede',
    ),		
    'document_template_type_dom' 	=> array (
        '' 	=> '',
        'mailmerge' 	=> 'Mektup Birleştirme',
        'eula' 	=> 'EULA',
        'nda' 	=> 'NDA',
        'license' 	=> 'Lisans Sözleşmesi'
    ),		
    'dom_meeting_accept_options' 	=> array (
        'accept' 	=> 'Kabul Et',
        'decline' 	=> 'Reddet'
        'tentative' 	=> 'Geçici',
    ),		
    'dom_meeting_accept_status' 	=> array (
        'accept' 	=> 'Kabul Edildi'
        'decline' 	=> 'Reddedildi'
        'tentative' 	=> 'Geçici',
        'none' 	=> 'Hiçbiri',
    ),		
    'duration_intervals' 	=> array (
        '0' 	=> '00',
        '15' 	=> '15',
        '30' 	=> '30',
        '45' 	=> '45',
    ),		
    'repeat_type_dom' 	=> array (
        '' 	=> 'Hiçbiri',
        'Daily' 	=> 'Günlük',
        'Weekly' 	=> 'Haftalık',
        'Monthly' 	=> 'Aylık',
        'Yearly' 	=> 'Yıllık',
    ),		

    'repeat_intervals' 	=> array (
        '' 	=> '',
        'Daily' 	=> 'gün (ler)',
        'Weekly' 	=> 'hafta (lar)',
        'Monthly' 	=> 'ay (lar)',
        'Yearly' 	=> 'yıl (lar)',
    ),		

    'duration_dom' 	=> array (
        '' 	=> 'Hiçbiri',
        '900' 	=> '15 dakika ',
        '1800' 	=> '30 dakika ',
        '2700' 	=> '45 dakika ',
        '3600' 	=> '1 saat',
        '5400' 	=> '1.5 saat',
        '7200' 	=> '2 saat',
        '10800' 	=> '3 saat',
        '21600' 	=> '6 saat',
        '86400' 	=> '1 gün',
        '172800' 	=> '2 gün',
        '259200' 	=> '3 gün',
        '604800' 	=> '1 hafta',
    ),		


//prospect list type dom
    'prospect_list_type_dom' 	=> array (
        'default' 	=> 'Varsayılan',
        'seed' 	=> 'Tohum',
        'exempt_domain' 	=> 'Bastırma Listesi - Alan Tarafından',
        'exempt_address' 	=> 'Bastırma Listesi - E-posta Adresi'
        'exempt' 	=> 'Bastırma Listesi - Kimlik İle'
        'test' 	=> 'Test',
    ),		

    'email_settings_num_dom' 	=> array (
        '10' 	=> '10',
        '20' 	=> '20',
        '50' 	=> '50',
    ),		
    'email_marketing_status_dom' 	=> array (
        '' 	=> '',
        'active' 	=> 'Aktif',
        'inactive' 	=> 'Etkin değil',
    ),		

    'campainglog_activity_type_dom' 	=> array (
        '' 	=> '',
        'targeted' 	=> 'Mesaj gönderildi / denendi'
        'send error' 	=> 'Bounced Messages, Other',
        'invalid email' 	=> 'Bounced Messages, Geçersiz E-posta',
        'link' 	=> 'Tıklama Bağlantısı',
        'viewed' 	=> 'Görüntülenen Mesaj',
        'removed' 	=> 'Devre dışı bırakıldı',
        'lead' 	=> 'Kurşun Yarattı',
        'contact' 	=> 'Oluşturulan Kişiler',
        'blocked' 	=> 'Adres veya alana göre bastırılmış',
    ),		

    'campainglog_target_type_dom' 	=> array (
        'Contacts' 	=> 'Kişiler'
        'Users' 	=> 'Kullanıcılar',
        'Prospects' 	=> 'Hedefler',
        'Leads' 	=> 'Kurşun',
        'Accounts' 	=> 'Hesaplar',
    ),		
    'merge_operators_dom' 	=> array (
        'like' 	=> 'İçeriyor',
        'exact' 	=> 'Kesinlikle',
        'start' 	=> 'Ile Başlar'
    ),		

    'custom_fields_importable_dom' 	=> array (
        'true' 	=> 'Evet',
        'false' 	=> 'Hayır',
        'required' 	=> 'Gerekli',
    ),		

    'custom_fields_merge_dup_dom' 	=> array (
0	=> 'Devre Dışı',
1	=> 'Etkin',
    ),		

    'projects_priority_options' 	=> array (
        'high' 	=> 'Yüksek',
        'medium' 	=> 'Orta',
        'low' 	=> 'Düşük',
    ),		

    'projects_status_options' 	=> array (
        'notstarted' 	=> 'Başlamadı',
        'inprogress' 	=> 'İlerlemiyor',
        'completed' 	=> 'Tamamlandı',
    ),		
    // strings to pass to Flash charts
    'chart_strings' 	=> array (
        'expandlegend' 	=> 'Efsane Genişlet',
        'collapselegend' 	=> 'Efsane Daralt',
        'clickfordrilldown' 	=> 'Drilldown için Tıklayın',
        'detailview' 	=> 'Daha Fazla Bilgi ...',
        'piechart' 	=> 'Pasta Grafiği',
        'groupchart' 	=> 'Grup Şeması',
        'stackedchart' 	=> 'Yığılmış Grafik',
        'barchart' 	=> 'Çubuk Grafik',
        'horizontalbarchart' 	=> 'Yatay Çubuk Grafik',
        'linechart' 	=> 'Çizgi Grafik',
        'noData' 	=> 'Veri yok',
        'print' 	=> 'Baskı',
        'pieWedgeName' 	=> 'bölümler'
    ),		
    'release_status_dom' 	=> array (
        'Active' 	=> 'Aktif',
        'Inactive' 	=> 'Etkin değil',
    ),		
    'email_settings_for_ssl' 	=> array (
        '0' 	=> '',
        '1' 	=> 'SSL',
        '2' 	=> 'TLS',
    ),		
    'import_enclosure_options' 	=> array (
        '\'' 	=> 'Tekli Alıntı (\') ',
        '"' 	=> 'Çift Teklif ("),
        '' 	=> 'Hiçbiri',
        'other' 	=> 'Diğer:',
    ),		
    'import_delimeter_options' 	=> array (
        ',' 	=> ',',
        ';' 	=> ';',
        '\t' 	=> '\ t',
        '.' 	=> '.'
        ':' 	=> ':'
        '|' 	=> '|',
        'other' 	=> 'Diğer:',
    ),		
    'link_target_dom' 	=> array (
        '_blank' 	=> 'Yeni Pencere',
        '_self' 	=> 'Aynı Pencere',
    ),		
    'dashlet_auto_refresh_options' 	=> array (
        '-1' 	=> 'Otomatik yenileme',
        '30' 	=> 'Her 30 saniyede',
        '60' 	=> 'Her 1 dakikada bir'
        '180' 	=> 'Her 3 dakikada bir'
        '300' 	=> 'Her 5 dakikada bir'
        '600' 	=> 'Her 10 dakikada bir'
    ),		
    'dashlet_auto_refresh_options_admin' 	=> array (
        '-1' 	=> 'Asla',
        '30' 	=> 'Her 30 saniyede',
        '60' 	=> 'Her 1 dakikada bir'
        '180' 	=> 'Her 3 dakikada bir'
        '300' 	=> 'Her 5 dakikada bir'
        '600' 	=> 'Her 10 dakikada bir'
    ),		
    'date_range_search_dom' 	=> array (
        ''
        'not_equal' 	=> 'Açık değil'
        'greater_than' 	=> 'Sonra'
        'less_than' 	=> 'Önce',
        'last_7_days' 	=> 'Son 7 Gün',
        'next_7_days' 	=> 'Sonraki 7 Gün',
        'last_30_days' 	=> 'Son 30 Gün',
        'next_30_days' 	=> 'Sonraki 30 Gün',
        'last_month' 	=> 'Geçen Ay'
        'this_month' 	=> 'Bu Ay'
        'next_month' 	=> 'Sonraki Ay'
        'last_year' 	=> 'Geçen Yıl'
        'this_year' 	=> 'Bu yıl'
        'next_year' 	=> 'Gelecek Yıl'
        'between' 	=> 'Arasında',
    ),		
    'numeric_range_search_dom' 	=> array (
        ''
        'not_equal' 	=> Eşit Olmaz
        'greater_than' 	=> 'Daha Büyük'
        'greater_than_equals' 	=> 'Büyük veya Eşittir',
        'less_than' 	=> 'Daha Az'
        'less_than_equals' 	=> 'Daha Az veya Eşittir',
        'between' 	=> 'Arasında',
    ),		
    'lead_conv_activity_opt' 	=> array (
        'copy' 	=> 'Kopyala',
        'move' 	=> 'Taşı',
        'donothing' 	=> 'Hiçbir şey Yapma'
    ),		
);	

$app_strings array(
    'LBL_TOUR_NEXT' 	=> 'Sonraki',
    'LBL_TOUR_SKIP' 	=> 'Skip',
    'LBL_TOUR_BACK' 	=> 'Geri',
    'LBL_TOUR_TAKE_TOUR' 	=> 'Tura katılın',
    'LBL_MOREDETAIL' 	=> 'Daha Fazla Ayrıntı' / * 508 uygunluk düzeltmesi için * /,
    'LBL_EDIT_INLINE' 	=> 'Inline düzenle' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_VIEW_INLINE' 	=> 'Görünüm' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_BASIC_SEARCH' 	=> 'Filtre' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_Blank' 	=> '' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_ID_FF_ADD' 	=> '508 uygunluk düzeltmesi için' / * ekleyin / *,
    'LBL_ID_FF_ADD_EMAIL' 	=> 'E-posta Adresi Ekle' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_HIDE_SHOW' 	=> 'Gizle / Göster' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_DELETE_INLINE' 	=> '508 uygunluk düzeltmesi için / *' silin / *,
    'LBL_ID_FF_CLEAR' 	=> 'Temizle' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_ID_FF_VCARD' 	=> 'vCard' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_ID_FF_REMOVE' 	=> 'Kaldır' / * 508 uygunluk düzeltmesi için * /,
    'LBL_ID_FF_REMOVE_EMAIL' 	=> 'E-posta Adresini Kaldır' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_ID_FF_OPT_OUT' 	=> 'Devre dışı bırak',
    'LBL_ID_FF_INVALID' 	=> 'Geçersiz kıl'
    'LBL_ADD' 	=> '508 uygunluk düzeltmesi için' / * ekleyin / *,
    'LBL_COMPANY_LOGO' 	=> 'Şirket logosu' / * 508 uyumluluk düzeltmesi için * /,
    'LBL_CONNECTORS_POPUPS' 	=> 'Konektörler Açılır Pencereleri'
    'LBL_CLOSEINLINE' 	=> 'Kapat',
    'LBL_VIEWINLINE' 	=> 'Görünüm'
    'LBL_INFOINLINE' 	=> 'Bilgi',
    'LBL_PRINT' 	=> 'Baskı',
    'LBL_HELP' 	=> 'Yardım',
    'LBL_ID_FF_SELECT' 	=> 'Seç',
    'DEFAULT' 	=> 'TEMEL',
    'LBL_SORT' 	=> 'Sırala',
    'LBL_EMAIL_SMTP_SSL_OR_TLS' 	=> 'SMTPyi SSL veya TLS üzerinden etkinleştirilsin mi?',
    'LBL_NO_ACTION' 	=> 'Bu adla hiçbir işlem yapılmadı:% s',
    'LBL_NO_SHORTCUT_MENU' 	=> 'Kullanılabilecek bir eylem yok.',
    'LBL_NO_DATA' 	=> 'Veri yok',

    'LBL_ROUTING_FLAGGED' 	=> 'bayrak takımı',
    'LBL_ROUTING_TO' 	=> 'to',
    'LBL_ROUTING_TO_ADDRESS' 	=> 'adres ver'
    'LBL_ROUTING_WITH_TEMPLATE' 	=> 'Şablonlu'

    'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM' 	=> 'Bu kayıt şu anda Office Telefon ve Adres alanlarındaki değerleri içeriyor. Bu değerleri, seçtiğiniz Hesabın Aşağıdaki Ofis Telefonu ve Adresiyle üzerine yazmak için "Tamam" ı tıklayın. Geçerli değerleri saklamak için "İptal" düğmesine tıklayın. ',
    'LBL_DROP_HERE' 	=> '[Bırak burada]',
    'LBL_EMAIL_ACCOUNTS_GMAIL_DEFAULTS' 	=> 'Gmail® Varsayılanlarını Önceden Doldur',
    'LBL_EMAIL_ACCOUNTS_NAME' 	=> 'İsim',
    'LBL_EMAIL_ACCOUNTS_OUTBOUND' 	=> 'Giden Posta Sunucusu Özellikleri',
    'LBL_EMAIL_ACCOUNTS_SMTPPASS' 	=> 'SMTP Parolası',
    'LBL_EMAIL_ACCOUNTS_SMTPPORT' 	=> 'SMTP Port'u
    'LBL_EMAIL_ACCOUNTS_SMTPSERVER' 	=> 'SMTP Sunucusu',
    'LBL_EMAIL_ACCOUNTS_SMTPUSER' 	=> 'SMTP Kullanıcı Adı',
    'LBL_EMAIL_ACCOUNTS_SMTPDEFAULT' 	=> 'Varsayılan',
    'LBL_EMAIL_WARNING_MISSING_USER_CREDS' 	=> 'Uyarı: Giden posta hesabı için kullanıcı adı ve şifre eksik.',
    'LBL_EMAIL_ACCOUNTS_SUBTITLE' 	=> 'E-posta hesaplarınızdan gelen e-postaları görüntülemek için Posta Hesapları oluşturun.',
    'LBL_EMAIL_ACCOUNTS_OUTBOUND_SUBTITLE' 	=> 'Posta Hesaplarında giden e-postalar için kullanılacak SMTP posta sunucusu bilgilerini sağlayın.',

    'LBL_EMAIL_ADDRESS_BOOK_ADD' 	=> "Bitti",
    'LBL_EMAIL_ADDRESS_BOOK_CLEAR' 	=> 'Temizle',
    'LBL_EMAIL_ADDRESS_BOOK_ADD_TO' 	=> 'To:',
    'LBL_EMAIL_ADDRESS_BOOK_ADD_CC' 	=> 'CC:',
    'LBL_EMAIL_ADDRESS_BOOK_ADD_BCC' 	=> 'Bcc:',
    'LBL_EMAIL_ADDRESS_BOOK_ADRRESS_TYPE' 	=> 'To/Cc/Bcc'
    'LBL_EMAIL_ADDRESS_BOOK_EMAIL_ADDR' 	=> 'E-posta Adresi',
    'LBL_EMAIL_ADDRESS_BOOK_FILTER' 	=> 'Filtre',
    'LBL_EMAIL_ADDRESS_BOOK_NAME' 	=> 'İsim',
    'LBL_EMAIL_ADDRESS_BOOK_NOT_FOUND' 	=> 'Bulunan Adres Yok',
    'LBL_EMAIL_ADDRESS_BOOK_SAVE_AND_ADD' 	=> 'Kaydet ve Adres Defterine Ekle',
    'LBL_EMAIL_ADDRESS_BOOK_SELECT_TITLE' 	=> 'E-posta Alıcılarını Seç',
    'LBL_EMAIL_ADDRESS_BOOK_TITLE' 	=> 'Adres Defteri',
    'LBL_EMAIL_REMOVE_SMTP_WARNING' 	=> 'Uyarı! Silmek istediğiniz giden hesap, mevcut bir gelen hesapla ilişkilendirilir. Devam etmek istediğine emin misin?',
    'LBL_EMAIL_ADDRESSES' 	=> 'E-posta',
    'LBL_EMAIL_ADDRESS_PRIMARY' 	=> 'E-posta Adresi',
    'LBL_EMAIL_ARCHIVE_TO_SUGAR' 	=> 'SuiteCRMye aktar',
    'LBL_EMAIL_ASSIGNMENT' 	=> 'Atama',
    'LBL_EMAIL_ATTACH_FILE_TO_EMAIL' 	=> 'Ekle',
    'LBL_EMAIL_ATTACHMENT' 	=> 'Ekle',
    'LBL_EMAIL_ATTACHMENTS' 	=> 'Yerel Sistemden',
    'LBL_EMAIL_ATTACHMENTS2' 	=> 'SuiteCRM Belgelerinden',
    'LBL_EMAIL_ATTACHMENTS3' 	=> 'Şablon Ekleri',
    'LBL_EMAIL_ATTACHMENTS_FILE' 	=> 'Dosya',
    'LBL_EMAIL_ATTACHMENTS_DOCUMENT' 	=> 'Belge',
    'LBL_EMAIL_BCC' 	=> 'BCC',
    'LBL_EMAIL_CANCEL' 	=> 'İptal et',
    'LBL_EMAIL_CC' 	=> 'CC',
    'LBL_EMAIL_CHARSET' 	=> 'Karakter Kümesi',
    'LBL_EMAIL_CHECK' 	=> 'Posta Kontrol Et',
    'LBL_EMAIL_CHECKING_NEW' 	=> 'Yeni E-postayı Kontrol Etmek',
    'LBL_EMAIL_CHECKING_DESC' 	=> 'Bir dakika lütfen ... <br> <br> Bu posta hesabının ilk onayıysa, biraz zaman alabilir.',
    'LBL_EMAIL_CLOSE' 	=> 'Kapat',
    'LBL_EMAIL_COFFEE_BREAK' 	=> 'Yeni E-postayı Kontrol Etmek. <br> <br> Büyük posta hesapları zaman alabilir. ',

    'LBL_EMAIL_COMPOSE' 	=> 'E-posta',
    'LBL_EMAIL_COMPOSE_ERR_NO_RECIPIENTS' 	=> 'Lütfen bu e-postanın alıcılarını girin.',
    'LBL_EMAIL_COMPOSE_NO_BODY' 	=> 'Bu e-postanın gövdesi boş. Ne olursa olsun gönder?',
    'LBL_EMAIL_COMPOSE_NO_SUBJECT' 	=> 'Bu e-postanın hiçbir konusu yok. Ne olursa olsun gönder?',
    'LBL_EMAIL_COMPOSE_NO_SUBJECT_LITERAL' 	=> '(konu yok)',
    'LBL_EMAIL_COMPOSE_INVALID_ADDRESS' 	=> 'Kime, Bilgi ve Gizli alanların geçerli e-posta adresini girin',

    'LBL_EMAIL_CONFIRM_CLOSE' 	=> 'Bu e-postayı silinsin mi?',
    'LBL_EMAIL_CONFIRM_DELETE_SIGNATURE' 	=> 'Bu imzayı silmek istediğinizden emin misiniz?',

    'LBL_EMAIL_SENT_SUCCESS' 	=> 'E-posta gönderildi'

    'LBL_EMAIL_CREATE_NEW' 	=> 'Kaydede Oluştur--',
    'LBL_EMAIL_MULT_GROUP_FOLDER_ACCOUNTS' 	=> 'Çoklu',
    'LBL_EMAIL_MULT_GROUP_FOLDER_ACCOUNTS_EMPTY' 	=> 'Boş',
    'LBL_EMAIL_DATE_SENT_BY_SENDER' 	=> 'Gönderen Gönderen Tarih',
    'LBL_EMAIL_DATE_TODAY' 	=> 'Bugün',
    'LBL_EMAIL_DELETE' 	=> 'Sil',
    'LBL_EMAIL_DELETE_CONFIRM' 	=> 'Seçili mesajları sil mi?',
    'LBL_EMAIL_DELETE_SUCCESS' 	=> 'E-posta başarıyla silindi.',
    'LBL_EMAIL_DELETING_MESSAGE' 	=> 'Mesaj Silme',
    'LBL_EMAIL_DETAILS' 	=> 'Ayrıntılar',

    'LBL_EMAIL_EDIT_CONTACT_WARN' 	=> 'O + B1124: B1171nly Birincil adres, Kişilerle çalışırken kullanılacaktır.',

    'LBL_EMAIL_EMPTYING_TRASH' 	=> 'Çöp Kutusunu Boşaltın',
    'LBL_EMAIL_DELETING_OUTBOUND' 	=> 'Giden sunucuyu silme',
    'LBL_EMAIL_CLEARING_CACHE_FILES' 	=> 'Önbellek dosyalarını temizleme',

    'LBL_EMAIL_ERROR_ADD_GROUP_FOLDER' 	=> 'Klasör adı benzersiz olmalı ve boş olmamalıdır. Lütfen tekrar deneyin.',
    'LBL_EMAIL_ERROR_DELETE_GROUP_FOLDER' 	=> 'Bir klasörü silemiyor. Klasör ya da çocuklarının e-postaları ya da ona bir posta kutusu var. ',
    'LBL_EMAIL_ERROR_CANNOT_FIND_NODE' 	=> 'Bağlamdan istenilen klasörü belirleyemiyorum. Tekrar deneyin.',
    'LBL_EMAIL_ERROR_CHECK_IE_SETTINGS' 	=> 'Lütfen ayarlarınızı kontrol edin.',
    'LBL_EMAIL_ERROR_DESC' 	=> 'Hatalar tespit edildi:',
    'LBL_EMAIL_DELETE_ERROR_DESC' 	=> 'Bu alana erişiminiz yok. Erişim almak için site yöneticinize başvurun. ',
    'LBL_EMAIL_ERROR_DUPE_FOLDER_NAME' 	=> 'SuiteCRM Klasör adları benzersiz olmalıdır.',
    'LBL_EMAIL_ERROR_EMPTY' 	=> 'Lütfen bazı arama ölçütleri girin.',
    'LBL_EMAIL_ERROR_GENERAL_TITLE' 	=> 'Bir hata oluştu',
    'LBL_EMAIL_ERROR_MESSAGE_DELETED' 	=> 'Sunucudan Kaldırılan Mesaj',
    'LBL_EMAIL_ERROR_IMAP_MESSAGE_DELETED' 	=> 'İleti Sunucu kaldırıldı veya farklı bir klasöre taşındı',
    'LBL_EMAIL_ERROR_MAILSERVERCONNECTION' 	=> 'Posta sunucusuna bağlantı başarısız oldu. Lütfen yöneticinize başvurun ',
    'LBL_EMAIL_ERROR_MOVE' 	=> 'E-postaları sunucular ve / veya posta hesapları arasında taşıma şu anda desteklenmiyor.',
    'LBL_EMAIL_ERROR_MOVE_TITLE' 	=> 'Hata Taşı',
    'LBL_EMAIL_ERROR_NAME' 	=> 'Bir ad gereklidir.',
    'LBL_EMAIL_ERROR_FROM_ADDRESS' 	=> 'Kimden Adres gerekli. Geçerli bir e.',
    'LBL_EMAIL_ERROR_NO_FILE' 	=> 'Lütfen bir dosya sağlayın.',
    'LBL_EMAIL_ERROR_SERVER' 	=> 'Bir posta sunucusu adresi gereklidir.',
    'LBL_EMAIL_ERROR_SAVE_ACCOUNT' 	=> 'Posta hesabı kaydedilmemiş olabilir.',
    'LBL_EMAIL_ERROR_TIMEOUT' 	=> 'Posta sunucusu ile iletişim kurarken bir hata oluştu.',
    'LBL_EMAIL_ERROR_USER' 	=> 'Bir oturum açma adı gereklidir.',
    'LBL_EMAIL_ERROR_PORT' 	=> 'Posta sunucusu bağlantı noktası gereklidir.',
    'LBL_EMAIL_ERROR_PROTOCOL' 	=> 'Bir sunucu protokolü gereklidir.',
    'LBL_EMAIL_ERROR_MONITORED_FOLDER' 	=> 'İzlenen Klasör gereklidir.',
    'LBL_EMAIL_ERROR_TRASH_FOLDER' 	=> 'Çöp Kutusu gereklidir.',
    'LBL_EMAIL_ERROR_VIEW_RAW_SOURCE' 	=> 'Bu bilgi mevcut değil',
    'LBL_EMAIL_ERROR_NO_OUTBOUND' 	=> 'Giden posta sunucusu belirtilmedi.',
    'LBL_EMAIL_ERROR_SENDING' 	=> 'E-posta Gönderme Hatası. Yardım için lütfen yöneticinize başvurun. ',
     'LBL_EMAIL_FOLDERS' => SugarThemeRegistry::current()->getImage('icon_email_folder', 'align=absmiddle border=0',
            null, null, '.gif', ''
        ) . 'Folders',
    'LBL_EMAIL_FOLDERS_SHORT' => SugarThemeRegistry::current()->getImage('icon_email_folder',
        'align=absmiddle border=0', null, null, '.gif', ''
    ),	
    'LBL_EMAIL_FOLDERS_ADD' 	=> 'Ekle',
    'LBL_EMAIL_FOLDERS_ADD_DIALOG_TITLE' 	=> 'Yeni Klasör Ekle'
    'LBL_EMAIL_FOLDERS_RENAME_DIALOG_TITLE' 	=> 'Klasörü Yeniden Adlandır',
    'LBL_EMAIL_FOLDERS_ADD_NEW_FOLDER' 	=> 'Kaydet',
    'LBL_EMAIL_FOLDERS_ADD_THIS_TO' 	=> 'Bu klasörü ekle',
    'LBL_EMAIL_FOLDERS_CHANGE_HOME' 	=> 'Bu klasör değiştirilemiyor',
    'LBL_EMAIL_FOLDERS_DELETE_CONFIRM' 	=> 'Bu klasörü silmek istediğinizden emin misiniz? \ NBu işlemi geri alamazsınız. \ NSizlenen silme, içerilen tüm klasöre basar.',
    'LBL_EMAIL_FOLDERS_NEW_FOLDER' 	=> 'Yeni Klasör Adı',
    'LBL_EMAIL_FOLDERS_NO_VALID_NODE' 	=> 'Lütfen bu işlemi yapmadan önce bir klasör seçin.',
    'LBL_EMAIL_FOLDERS_TITLE' 	=> 'Klasör Yönetimi',

    'LBL_EMAIL_FORWARD' 	=> 'İleri',
    'LBL_EMAIL_DELIMITER' 	=> '::; ::',
    'LBL_EMAIL_DOWNLOAD_STATUS' 	=> '[[Toplam]] e-postanın [[count]] indirildi',
    'LBL_EMAIL_FROM' 	=> 'Kimden',
    'LBL_EMAIL_GROUP' 	=> 'grup',
    'LBL_EMAIL_UPPER_CASE_GROUP' 	=> 'Grup',
    'LBL_EMAIL_HOME_FOLDER' 	=> 'Ev',
    'LBL_EMAIL_IE_DELETE' 	=> 'Posta Hesabı Silme',
    'LBL_EMAIL_IE_DELETE_SIGNATURE' 	=> 'İmza silme',
    'LBL_EMAIL_IE_DELETE_CONFIRM' 	=> 'Bu posta hesabını silmek istiyor musun?',
    'LBL_EMAIL_IE_DELETE_SUCCESSFUL' 	=> 'Silme başarılı.',
    'LBL_EMAIL_IE_SAVE' 	=> 'Posta Hesabı Bilgilerinin Kaydedilmesi',
    'LBL_EMAIL_IMPORTING_EMAIL' 	=> 'E-posta İçe Aktarma'
    'LBL_EMAIL_IMPORT_EMAIL' 	=> 'SuiteCRMye aktar',
    'LBL_EMAIL_IMPORT_SETTINGS' 	=> 'Alma Ayarları',
    'LBL_EMAIL_INVALID' 	=> 'Geçersiz'
    'LBL_EMAIL_LOADING' 	=> 'Yükleniyor ...',
    'LBL_EMAIL_MARK' 	=> 'İşaretle',
    'LBL_EMAIL_MARK_FLAGGED' 	=> 'Işaretlendiği gibi',
    'LBL_EMAIL_MARK_READ' 	=> 'Okundu Olarak'
    'LBL_EMAIL_MARK_UNFLAGGED' 	=> 'Unflagged olarak'
    'LBL_EMAIL_MARK_UNREAD' 	=> 'Okunmamış Olarak'
    'LBL_EMAIL_ASSIGN_TO' 	=> 'Ata Yap'

    'LBL_EMAIL_MENU_ADD_FOLDER' 	=> 'Klasör Oluştur',
    'LBL_EMAIL_MENU_COMPOSE' 	=> 'Oluştur',
    'LBL_EMAIL_MENU_DELETE_FOLDER' 	=> 'Klasörü Sil',
    'LBL_EMAIL_MENU_EMPTY_TRASH' 	=> 'Çöp Kutusunu Boşalt',
    'LBL_EMAIL_MENU_SYNCHRONIZE' 	=> 'Senkronize et',
    'LBL_EMAIL_MENU_CLEAR_CACHE' 	=> 'Önbellek dosyalarını temizle',
    'LBL_EMAIL_MENU_REMOVE' 	=> 'Kaldır',
    'LBL_EMAIL_MENU_RENAME_FOLDER' 	=> 'Klasörü Yeniden Adlandır',
    'LBL_EMAIL_MENU_RENAMING_FOLDER' 	=> 'Klasörü Yeniden Adlandırma',
    'LBL_EMAIL_MENU_MAKE_SELECTION' 	=> 'Bu işlemi denemeden önce lütfen bir seçim yapın.',

    'LBL_EMAIL_MENU_HELP_ADD_FOLDER' 	=> 'Bir Klasör Oluşturun (uzaktan veya SuiteCRMde)',
    'LBL_EMAIL_MENU_HELP_DELETE_FOLDER' 	=> 'Bir Klasörü Sil (uzaktan veya SuiteCRMde)',
    'LBL_EMAIL_MENU_HELP_EMPTY_TRASH' 	=> 'Posta hesaplarınızın tüm Çöp Kutusu klasörlerini boşaltır',
    'LBL_EMAIL_MENU_HELP_MARK_READ' 	=> 'Bu e-postaları işaretle',
    'LBL_EMAIL_MENU_HELP_MARK_UNFLAGGED' 	=> 'Bu e-postaları işaretlenmemiş olarak işaretle',
    'LBL_EMAIL_MENU_HELP_RENAME_FOLDER' 	=> 'Bir Klasörü Yeniden adlandır (uzaktan veya SuiteCRMde)',

    'LBL_EMAIL_MESSAGES' 	=> 'mesajlar'

    'LBL_EMAIL_ML_NAME' 	=> 'Liste Adı',
    'LBL_EMAIL_ML_ADDRESSES_1' 	=> 'Seçili Liste Adresleri',
    'LBL_EMAIL_ML_ADDRESSES_2' 	=> 'Mevcut Liste Adresleri',

    'LBL_EMAIL_MULTISELECT' => '<b>Ctrl-Click</b> to Birden fazla seçmek için<br />(Mac Kullanıcıları : <b>CMD-Click</b>)',

    'LBL_EMAIL_NO' 	=> 'Hayır',
    'LBL_EMAIL_NOT_SENT' 	=> 'Sistem, isteğinizi işleyemiyor. Lütfen sistem yöneticisine başvurun. ',

    'LBL_EMAIL_OK' 	=> 'Tamam',
    'LBL_EMAIL_ONE_MOMENT' 	=> 'Bir dakika lütfen ...',
    'LBL_EMAIL_OPEN_ALL' 	=> 'Birden Fazla Mesaj Aç',
    'LBL_EMAIL_OPTIONS' 	=> 'Seçenekler',
    'LBL_EMAIL_QUICK_COMPOSE' 	=> 'Hızlı Oluştur',
    'LBL_EMAIL_OPT_OUT' 	=> 'Devre dışı bırakıldı',
    'LBL_EMAIL_OPT_OUT_AND_INVALID' 	=> 'Devre dışı bırakıldı ve Geçersiz'
    'LBL_EMAIL_PERFORMING_TASK' 	=> 'Görev Gösterme',
    'LBL_EMAIL_PRIMARY' 	=> 'İlköğretim'
    'LBL_EMAIL_PRINT' 	=> 'Baskı',

    'LBL_EMAIL_QC_BUGS' 	=> 'Hata',
    'LBL_EMAIL_QC_CASES' 	=> 'Durum',
    'LBL_EMAIL_QC_LEADS' 	=> 'Kurşun',
    'LBL_EMAIL_QC_CONTACTS' 	=> 'İletişim',
    'LBL_EMAIL_QC_TASKS' 	=> 'Görev',
    'LBL_EMAIL_QC_OPPORTUNITIES' 	=> 'Fırsat',
    'LBL_EMAIL_QUICK_CREATE' 	=> 'Hızlı Oluştur',

    'LBL_EMAIL_REBUILDING_FOLDERS' 	=> 'Klasörleri Yeniden Oluşturma',
    'LBL_EMAIL_RELATE_TO' 	=> 'Ilişki',
    'LBL_EMAIL_VIEW_RELATIONSHIPS' 	=> 'İlişkileri Görüntüle',
    'LBL_EMAIL_RECORD' 	=> 'E-posta Kaydı',
    'LBL_EMAIL_REMOVE' 	=> 'Kaldır',
    'LBL_EMAIL_REPLY' 	=> 'Yanıtla',
    'LBL_EMAIL_REPLY_ALL' 	=> 'Tümünü Yanıtla',
    'LBL_EMAIL_REPLY_TO' 	=> 'Yanıtla',
    'LBL_EMAIL_RETRIEVING_MESSAGE' 	=> 'Mesajı Geri Alma',
    'LBL_EMAIL_RETRIEVING_RECORD' 	=> 'E-posta Kaydını Alma',
    'LBL_EMAIL_SELECT_ONE_RECORD' 	=> 'Lütfen sadece bir e-posta kaydı seçin',
    'LBL_EMAIL_RETURN_TO_VIEW' 	=> 'Önceki Modüle Dönsün mi?',
    'LBL_EMAIL_REVERT' 	=> 'Geri al',
    'LBL_EMAIL_RELATE_EMAIL' 	=> 'E-postayı İlişkilendirin',

    'LBL_EMAIL_RULES_TITLE' 	=> 'Kural Yönetimi',

    'LBL_EMAIL_SAVE' 	=> 'Kaydet',
    'LBL_EMAIL_SAVE_AND_REPLY' 	=> 'Kaydet ve Yanıtla',
    'LBL_EMAIL_SAVE_DRAFT' 	=> 'Taslak Kaydet',
    'LBL_EMAIL_DRAFT_SAVED' 	=> 'Taslak kaydedildi',
    
    'LBL_EMAIL_SEARCH' => SugarThemeRegistry::current()->getImage('Search', 'align=absmiddle border=0', null, null,
        '.gif', ''
    ),
    'LBL_EMAIL_SEARCH_SHORT' => SugarThemeRegistry::current()->getImage('Search', 'align=absmiddle border=0', null,
        null, '.gif', ''
    ),	
    'LBL_EMAIL_SEARCH_DATE_FROM' 	=> 'Tarih Başlangıcı'
    'LBL_EMAIL_SEARCH_DATE_UNTIL' 	=> 'Tarih Until'
    'LBL_EMAIL_SEARCH_NO_RESULTS' 	=> 'Arama kriterlerinize uyan sonuç yok.',
    'LBL_EMAIL_SEARCH_RESULTS_TITLE' 	=> 'Arama Sonuçları',

    'LBL_EMAIL_SELECT' 	=> 'Seç',

    'LBL_EMAIL_SEND' 	=> 'Gönder',
    'LBL_EMAIL_SENDING_EMAIL' 	=> 'E-posta Gönderme',

    'LBL_EMAIL_SETTINGS' 	=> 'Ayarlar',
    'LBL_EMAIL_SETTINGS_ACCOUNTS' 	=> 'Posta Hesapları',
    'LBL_EMAIL_SETTINGS_ADD_ACCOUNT' 	=> 'Formu Temizle',
    'LBL_EMAIL_SETTINGS_CHECK_INTERVAL' 	=> 'Yeni Posta Kontrolü',
    'LBL_EMAIL_SETTINGS_FROM_ADDR' 	=> 'Adresinden',
    'LBL_EMAIL_SETTINGS_FROM_TO_EMAIL_ADDR' 	=> 'Test Bildirim İçin E-posta Adresi:',
    'LBL_EMAIL_SETTINGS_FROM_NAME' 	=> 'İsimden',
    'LBL_EMAIL_SETTINGS_REPLY_TO_ADDR' 	=> 'Adrese Yanıtla',
    'LBL_EMAIL_SETTINGS_FULL_SYNC' 	=> 'Tüm Posta Hesaplarını Senkronize Et',
    'LBL_EMAIL_TEST_NOTIFICATION_SENT' 	=> 'Verilen giden posta ayarlarını kullanarak belirtilen e-posta adresine bir e-posta gönderildi. Lütfen ayarların doğru olduğunu doğrulamak için e-postanın alındığını kontrol edin. ',
    'LBL_EMAIL_SETTINGS_FULL_SYNC_WARN' 	=> 'Tam bir senkronizasyon gerçekleştirilsin mi? \' Büyük e-posta hesapları alması birkaç dakika sürebilir. ',
    'LBL_EMAIL_SUBSCRIPTION_FOLDER_HELP' 	=> 'Shift tuşunu veya birden fazla klasörü seçmek için Ctrl tuşunu tıklayın.',
    'LBL_EMAIL_SETTINGS_GENERAL' 	=> 'Genel',
    'LBL_EMAIL_SETTINGS_GROUP_FOLDERS_CREATE' 	=> 'Grup Klasörleri Oluştur',

    'LBL_EMAIL_SETTINGS_GROUP_FOLDERS_EDIT' 	=> 'Grup Klasörünü Düzenle',

    'LBL_EMAIL_SETTINGS_NAME' 	=> 'Posta Hesabı Adı',
    'LBL_EMAIL_SETTINGS_REQUIRE_REFRESH' 	=> 'Gelen Kutusunda sayfa başına e-posta sayısını seçin. Bu ayar, etkili olması için sayfanın yenilenmesini gerektirebilir. ',
    'LBL_EMAIL_SETTINGS_RETRIEVING_ACCOUNT' 	=> 'Posta Hesabı Alma',
    'LBL_EMAIL_SETTINGS_SAVED' 	=> 'Ayarlar kaydedildi.',
    'LBL_EMAIL_SETTINGS_SEND_EMAIL_AS' 	=> 'Sadece Düz Metin E-postalar Gönder',
    'LBL_EMAIL_SETTINGS_SHOW_NUM_IN_LIST' 	=> 'Sayfalardaki E-postalar',
    'LBL_EMAIL_SETTINGS_TITLE_LAYOUT' 	=> 'Görsel Ayarlar',
    'LBL_EMAIL_SETTINGS_TITLE_PREFERENCES' 	=> 'Tercihler',
    'LBL_EMAIL_SETTINGS_USER_FOLDERS' 	=> 'Kullanılabilir Kullanıcı Klasörleri',
    'LBL_EMAIL_ERROR_PREPEND' 	=> 'Hata:',
    'LBL_EMAIL_INVALID_PERSONAL_OUTBOUND' 	=> 'Kullandığınız posta hesabı için seçilen giden posta sunucusu geçersiz. Ayarları kontrol edin veya posta hesabı için farklı bir posta sunucusu seçin. ',
    'LBL_EMAIL_INVALID_SYSTEM_OUTBOUND' 	=> 'Giden bir posta sunucusu e-posta göndermek için yapılandırılmadı. Lütfen bir giden posta sunucusu yapılandırın veya kullandığınız posta hesabı için bir giden posta sunucusu seçin Ayarlar >> Posta Hesabı. ',
    'LBL_DEFAULT_EMAIL_SIGNATURES' 	=> 'Varsayılan İmza',
    'LBL_EMAIL_SIGNATURES' 	=> 'İmzalar',
    'LBL_SMTPTYPE_GMAIL' 	=> 'Gmail'
    'LBL_SMTPTYPE_YAHOO' 	=> 'Yahoo! Posta',
    'LBL_SMTPTYPE_EXCHANGE' 	=> 'Microsoft Exchange',
    'LBL_SMTPTYPE_OTHER' 	=> 'Diğer'
    'LBL_EMAIL_SPACER_MAIL_SERVER' 	=> '[Uzak Klasörler]',
    'LBL_EMAIL_SPACER_LOCAL_FOLDER' 	=> '[SuiteCRM Klasörleri]',
    'LBL_EMAIL_SUBJECT' 	=> 'Konu',
    'LBL_EMAIL_SUCCESS' 	=> 'Başarı',
    'LBL_EMAIL_SUGAR_FOLDER' 	=> 'SuiteCRM Klasörü',
    'LBL_EMAIL_TEMPLATE_EDIT_PLAIN_TEXT' 	=> 'E-posta şablonu gövdesi boş',
    'LBL_EMAIL_TEMPLATES' 	=> 'Şablonlar',
    'LBL_EMAIL_TO' 	=> 'To',
    'LBL_EMAIL_VIEW' 	=> 'Görünüm'
    'LBL_EMAIL_VIEW_HEADERS' 	=> 'Başlıkları Göster',
    'LBL_EMAIL_VIEW_RAW' 	=> 'Ham E-postayı Göster',
    'LBL_EMAIL_VIEW_UNSUPPORTED' 	=> 'Bu özellik, POP3 ile kullanıldığında desteklenmiyor.',
    'LBL_DEFAULT_LINK_TEXT' 	=> 'Varsayılan bağlantı metni.',
    'LBL_EMAIL_YES' 	=> 'Evet',
    'LBL_EMAIL_TEST_OUTBOUND_SETTINGS' 	=> 'Test E-postası gönder',
    'LBL_EMAIL_TEST_OUTBOUND_SETTINGS_SENT' 	=> 'Test E-postası Gönderildi',
    'LBL_EMAIL_MESSAGE_NO' 	=> 'Mesaj Hayır',
    'LBL_EMAIL_IMPORT_SUCCESS' 	=> 'İthalat Geçti',
    'LBL_EMAIL_IMPORT_FAIL' 	=> 'İçe Aktarma Başarısız çünkü mesaj zaten içe aktarıldı veya sunucudan silindi',

    'LBL_LINK_NONE' 	=> 'Hiçbiri',
    'LBL_LINK_ALL' 	=> 'Hepimiz',
    'LBL_LINK_RECORDS' 	=> 'Kayıtlar',
    'LBL_LINK_SELECT' 	=> 'Seç',
    'LBL_LINK_ACTIONS' 	=> 'EYLEM',
    'LBL_CLOSE_ACTIVITY_HEADER' 	=> 'Onayla',
    'LBL_CLOSE_ACTIVITY_CONFIRM' 	=> 'Bu # modül #? ü kapatmak istiyor musunuz?'
    'LBL_INVALID_FILE_EXTENSION' 	=> 'Geçersiz Dosya Uzantısı',

    'ERR_AJAX_LOAD' 	=> 'Bir hata oluştu:',
    'ERR_AJAX_LOAD_FAILURE' 	=> 'İsteğiniz işlenirken bir hata oluştu, lütfen daha sonra tekrar deneyin.',
    'ERR_AJAX_LOAD_FOOTER' 	=> 'Eğer bu hata devam ederse, lütfen yöneticiniz bu modül için Ajaxı devre dışı bırakmasını sağlayın',
    'ERR_DECIMAL_SEP_EQ_THOUSANDS_SEP' 	=> 'Ondalık ayırıcı, binlerce ayırıcıyla aynı karakteri kullanamaz. \\ n \\ n Lütfen değerleri değiştirin.',
    'ERR_DELETE_RECORD' 	=> 'Kartviziti silmek için bir kayıt numarası belirtilmelidir.',
    'ERR_EXPORT_DISABLED' 	=> 'İhracat Engelli.',
    'ERR_EXPORT_TYPE' 	=> 'Hata verme hatası',
    'ERR_INVALID_EMAIL_ADDRESS' 	=> 'geçerli bir e-posta adresi değil.',
    'ERR_INVALID_FILE_REFERENCE' 	=> 'Geçersiz Dosya Başvurusu',
    'ERR_NO_HEADER_ID' 	=> 'Bu özellik bu temada kullanılamıyor.',
    'ERR_NOT_ADMIN' 	=> 'Yetkisiz yönetim erişimi'.
    'ERR_MISSING_REQUIRED_FIELDS' 	=> 'Gerekli eksik alan:',
    'ERR_INVALID_REQUIRED_FIELDS' 	=> 'Geçersiz zorunlu alan:',
    'ERR_INVALID_VALUE' 	=> 'Geçersiz Değer:',
    'ERR_NO_SUCH_FILE' 	=> 'Dosya sistemde mevcut değil',
    'ERR_NO_SINGLE_QUOTE' 	=> 'İçin tek tırnak işareti kullanılamıyor',
    'ERR_NOTHING_SELECTED' 	=> 'Devam etmeden önce lütfen bir seçim yapın.',
    'ERR_SELF_REPORTING' 	=> 'Kullanıcı kendisine ya da kendisine rapor veremez.',
    'ERR_SQS_NO_MATCH_FIELD' 	=> 'Alan için eşleşme yok:',
    'ERR_SQS_NO_MATCH' 	=> 'Maç Yok',
    'ERR_ADDRESS_KEY_NOT_SPECIFIED' 	=> 'Meta-Veri tanımlaması için displayParams özniteliğinde \' anahtar \ arraynini belirtin',
    'ERR_EXISTING_PORTAL_USERNAME' 	=> 'Hata: Portal Adı zaten başka bir kişiye atandı.',
    'ERR_COMPATIBLE_PRECISION_VALUE' 	=> 'Alan değeri hassasiyet değeri ile uyumlu değil',
    'ERR_EXTERNAL_API_SAVE_FAIL' 	=> 'Harici hesaba kaydetmeye çalışılırken bir hata oluştu.',
    'ERR_NO_DB' 	=> 'Veritabanına bağlanılamadı. Ayrıntılar için lütfen suitecrm.loga bakın. ',
    'ERR_DB_FAIL' 	=> 'Veritabanı hatası. Ayrıntılar için lütfen suitecrm.loga bakın. ',
    'ERR_DB_VERSION' 	=> 'SuiteCRM {0} Dosyaları yalnızca bir SuiteCRM {1} Veritabanı ile Kullanılabilir.',

    'LBL_ACCOUNT' 	=> 'Hesap',
    'LBL_ACCOUNTS' 	=> 'Hesaplar',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' 	=> 'Etkinlikler',
    'LBL_ACCUMULATED_HISTORY_BUTTON_KEY' 	=> 'H',
    'LBL_ACCUMULATED_HISTORY_BUTTON_LABEL' 	=> 'Özeti Görüntüle',
    'LBL_ACCUMULATED_HISTORY_BUTTON_TITLE' 	=> 'Özeti Görüntüle',
    'LBL_ADD_BUTTON' 	=> 'Ekle',
    'LBL_ADD_DOCUMENT' 	=> 'Belge Ekle',
    'LBL_ADD_TO_PROSPECT_LIST_BUTTON_KEY' 	=> 'L',
    'LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL' 	=> 'Hedef Listeye Ekle',
    'LBL_ADD_TO_PROSPECT_LIST_BUTTON_LABEL_ACCOUNTS_CONTACTS' 	=> 'Hedefi Listeye Kişiler Ekle',
    'LBL_ADDITIONAL_DETAILS_CLOSE_TITLE' 	=> 'Kapatmak İçin Tıklayın',
    'LBL_ADDITIONAL_DETAILS' 	=> 'Ek Bilgiler',
    'LBL_ADMIN' 	=> 'Yönetici',
    'LBL_ALT_HOT_KEY' 	=> '',
    'LBL_ARCHIVE' 	=> 'Arşivle',
    'LBL_ASSIGNED_TO_USER' 	=> 'Kullanıcıya Atanmış',
    'LBL_ASSIGNED_TO' 	=> 'Atandı:',
    'LBL_BACK' 	=> 'Geri',
    'LBL_BILLING_ADDRESS' 	=> 'Fatura adresi',
    'LBL_BROWSER_TITLE' 	=> 'SuiteCRM - Açık Kaynaklı CRM',
    'LBL_BUGS' 	=> 'Bugs',
    'LBL_BY' 	=> 'by',
    'LBL_CALLS' 	=> 'Çağrılar',
    'LBL_CAMPAIGNS_SEND_QUEUED' 	=> 'Sıradaki Kampanya E-postalarını Gönder',
    'LBL_SUBMIT_BUTTON_LABEL' 	=> 'Gönderi',
    'LBL_CASE' 	=> 'Durum',
    'LBL_CASES' 	=> 'Durumlar',
    'LBL_CHANGE_PASSWORD' 	=> 'Parolayı değiştir',
    'LBL_CHARSET' 	=> 'UTF-8',
    'LBL_CHECKALL' 	=> 'Tümünü Kontrol Et',
    'LBL_CITY' 	=> 'Şehir',
    'LBL_CLEAR_BUTTON_LABEL' 	=> 'Temizle',
    'LBL_CLEAR_BUTTON_TITLE' 	=> 'Temizle',
    'LBL_CLEARALL' 	=> 'Tümünü Temizle',
    'LBL_CLOSE_BUTTON_TITLE' 	=> 'Kapat',
    'LBL_CLOSE_AND_CREATE_BUTTON_LABEL' 	=> 'Kapat ve Yeni Oluştur',
    'LBL_CLOSE_AND_CREATE_BUTTON_TITLE' 	=> 'Kapat ve Yeni Oluştur',
    'LBL_CLOSE_AND_CREATE_BUTTON_KEY' 	=> 'C',
    'LBL_OPEN_ITEMS' 	=> 'Açık Öğeler:',
    'LBL_COMPOSE_EMAIL_BUTTON_KEY' 	=> 'L',
    'LBL_COMPOSE_EMAIL_BUTTON_LABEL' 	=> 'E-posta Oluştur',
    'LBL_COMPOSE_EMAIL_BUTTON_TITLE' 	=> 'E-posta Oluştur',
    'LBL_SEARCH_DROPDOWN_YES' 	=> 'Evet',
    'LBL_SEARCH_DROPDOWN_NO' 	=> 'Hayır',
    'LBL_CONTACT_LIST' 	=> 'İletişim Listesi',
    'LBL_CONTACT' 	=> 'İletişim',
    'LBL_CONTACTS' 	=> 'Kişiler'
    'LBL_CONTRACT' 	=> 'Sözleşme',
    'LBL_CONTRACTS' 	=> 'Sözleşmeler',
    'LBL_COUNTRY' 	=> 'Ülke:',
    'LBL_CREATE_BUTTON_LABEL' 	=> 'CREATE',
    'LBL_CREATED_BY_USER' 	=> 'Kullanıcı Tarafından Oluşturuldu',
    'LBL_CREATED_USER' 	=> 'Kullanıcı Tarafından Oluşturuldu',
    'LBL_CREATED' 	=> "Oluşturan",
    'LBL_CURRENT_USER_FILTER' 	=> 'Öğelerim:',
    'LBL_CURRENCY' 	=> 'Para Birimi:',
    'LBL_DOCUMENTS' 	=> 'Belgeler',
    'LBL_DATE_ENTERED' 	=> 'Oluşturulan Tarih:',
    'LBL_DATE_MODIFIED' 	=> 'Değiştirilen Tarih:',
    'LBL_EDIT_BUTTON' 	=> 'Düzenle',
    'LBL_DUPLICATE_BUTTON' 	=> 'Çoğalt'
    'LBL_DELETE_BUTTON' 	=> 'Sil',
    'LBL_DELETE' 	=> 'Sil',
    'LBL_DELETED' 	=> 'Silindi'
    'LBL_DIRECT_REPORTS' 	=> 'Doğrudan Raporlar',
    'LBL_DONE_BUTTON_LABEL' 	=> "Bitti",
    'LBL_DONE_BUTTON_TITLE' 	=> "Bitti",
    'LBL_FAVORITES' 	=> 'Favoriler'
    'LBL_VCARD' 	=> 'vCard',
    'LBL_EMPTY_VCARD' 	=> 'Lütfen bir vCard dosyası seçin',
    'LBL_EMPTY_REQUIRED_VCARD' 	=> 'vCard, bu modül için gerekli tüm alanlara sahip değil. Ayrıntılar için lütfen suitecrm.loga bakın. ',
    'LBL_VCARD_ERROR_FILESIZE' 	=> 'Yüklenen dosya, HTML formunda belirtilen 30000 bayt boyutu sınırını aşıyor.',
    'LBL_VCARD_ERROR_DEFAULT' 	=> 'VCard dosyasını yüklerken hata oluştu. Ayrıntılar için lütfen suitecrm.loga bakın. ',
    'LBL_IMPORT_VCARD' 	=> 'VCardı içe aktarma:',
    'LBL_IMPORT_VCARD_BUTTON_LABEL' 	=> 'VCardı içe aktar',
    'LBL_IMPORT_VCARD_BUTTON_TITLE' 	=> 'VCardı içe aktar',
    'LBL_VIEW_BUTTON' 	=> 'Görünüm'
    'LBL_EMAIL_PDF_BUTTON_LABEL' 	=> 'PDF olarak e-postala',
    'LBL_EMAIL_PDF_BUTTON_TITLE' 	=> 'PDF olarak e-postala',
    'LBL_EMAILS' 	=> 'E-postalar'
    'LBL_EMPLOYEES' 	=> 'Çalışanlar',
    'LBL_ENTER_DATE' 	=> 'Tarih Girin',
    'LBL_EXPORT' 	=> 'İhracat',
    'LBL_FAVORITES_FILTER' 	=> 'Favorilerim:',
    'LBL_GO_BUTTON_LABEL' 	=> 'Git',
    'LBL_HIDE' 	=> 'Gizle'
    'LBL_ID' 	=> 'Kimlik',
    'LBL_IMPORT' 	=> 'İçe Aktar',
    'LBL_IMPORT_STARTED' 	=> 'İçe Aktar:',
    'LBL_LAST_VIEWED' 	=> 'Son Görüntülenenler',
    'LBL_LEADS' 	=> 'Kurşun',
    'LBL_LESS' 	=> 'daha az',
    'LBL_CAMPAIGN' 	=> 'Kampanya:',
    'LBL_CAMPAIGNS' 	=> 'Kampanyalar',
    'LBL_CAMPAIGNLOG' 	=> 'Kampanya Günlüğü'
    'LBL_CAMPAIGN_CONTACT' 	=> 'Kampanyalar',
    'LBL_CAMPAIGN_ID' 	=> 'campaign_id',
    'LBL_CAMPAIGN_NONE' 	=> 'Hiçbiri',
    'LBL_THEME' 	=> 'Tema:',
    'LBL_FOUND_IN_RELEASE' 	=> 'Yayınlandığında Bulundu',
    'LBL_FIXED_IN_RELEASE' 	=> 'Sabit Sürümde',
    'LBL_LIST_ACCOUNT_NAME' 	=> 'Hesap Adı',
    'LBL_LIST_ASSIGNED_USER' 	=> 'Kullanıcı',
    'LBL_LIST_CONTACT_NAME' 	=> 'Kişi Adı',
    'LBL_LIST_CONTACT_ROLE' 	=> 'Rolle İletişim',
    'LBL_LIST_DATE_ENTERED' 	=> 'Oluşturulan Tarih',
    'LBL_LIST_EMAIL' 	=> 'E-posta',
    'LBL_LIST_NAME' 	=> 'İsim',
    'LBL_LIST_OF' 	=> 'of',
    'LBL_LIST_PHONE' 	=> 'Telefon',
    'LBL_LIST_RELATED_TO' 	=> 'İlişkili',
    'LBL_LIST_USER_NAME' 	=> 'Kullanıcı Adı',
    'LBL_LISTVIEW_NO_SELECTED' 	=> 'Devam etmek için lütfen en az 1 kayıt seçin.',
    'LBL_LISTVIEW_TWO_REQUIRED' 	=> 'Devam etmek için lütfen en az 2 kayıt seçin.',
    'LBL_LISTVIEW_OPTION_SELECTED' 	=> 'Seçilmiş Kayıtlar',
    'LBL_LISTVIEW_SELECTED_OBJECTS' 	=> 'Seçilenler:',

    'LBL_LOCALE_NAME_EXAMPLE_FIRST' 	=> 'David',
    'LBL_LOCALE_NAME_EXAMPLE_LAST' 	=> 'Livingstone',
    'LBL_LOCALE_NAME_EXAMPLE_SALUTATION' 	=> 'Dr.',
    'LBL_LOCALE_NAME_EXAMPLE_TITLE' 	=> 'Code Monkey Extraordinaire',
    'LBL_LOGOUT' 	=> 'Oturumu Kapat',
    'LBL_PROFILE' 	=> 'Profil',
    'LBL_MAILMERGE' 	=> 'Mektup Birleştirme',
    'LBL_MASS_UPDATE' 	=> 'Toplu Güncelleştirme',
    'LBL_NO_MASS_UPDATE_FIELDS_AVAILABLE' 	=> 'Toplu Güncelleştirme işlemi için kullanılabilecek alan yok',
    'LBL_OPT_OUT_FLAG_PRIMARY' 	=> 'Birincil E-postayı İptal Et',
    'LBL_MEETINGS' 	=> 'Toplantılar',
    'LBL_MEETING_GO_BACK' 	=> 'Toplantıya geri dön',
    'LBL_MEMBERS' 	=> 'Üyeler',
    'LBL_MEMBER_OF' 	=> 'Üye'
    'LBL_MODIFIED_BY_USER' 	=> 'Kullanıcı Tarafından Değiştirildi',
    'LBL_MODIFIED_USER' 	=> 'Kullanıcı Tarafından Değiştirildi',
    'LBL_MODIFIED' 	=> 'Değiştirildi',
    'LBL_MODIFIED_NAME' 	=> 'Adıyla Değiştirilmiş',
    'LBL_MORE' 	=> 'Daha Fazla',
    'LBL_MY_ACCOUNT' 	=> 'Ayarlarım',
    'LBL_NAME' 	=> 'İsim',
    'LBL_NEW_BUTTON_KEY' 	=> 'N',
    'LBL_NEW_BUTTON_LABEL' 	=> 'Oluştur',
    'LBL_NEW_BUTTON_TITLE' 	=> 'Oluştur',
    'LBL_NEXT_BUTTON_LABEL' 	=> 'Sonraki',
    'LBL_NONE' 	=> "Hiçkimse--"
    'LBL_NOTES' 	=> 'Notlar',
    'LBL_OPPORTUNITIES' 	=> 'Fırsatlar',
    'LBL_OPPORTUNITY_NAME' 	=> 'Fırsat İsim'
    'LBL_OPPORTUNITY' 	=> 'Fırsat',
    'LBL_OR' 	=> 'VEYA',
    'LBL_PANEL_OVERVIEW' 	=> 'GENEL BAKIŞ',
    'LBL_PANEL_ASSIGNMENT' 	=> 'DİĞER'
    'LBL_PANEL_ADVANCED' 	=> 'DAHA FAZLA BİLGİ',
    'LBL_PARENT_TYPE' 	=> 'Ebeveyn Türü',
    'LBL_PERCENTAGE_SYMBOL' 	=> '%',
    'LBL_POSTAL_CODE' 	=> 'Posta Kodu:',
    'LBL_PRIMARY_ADDRESS_CITY' 	=> 'Birincil Adres Şehir:',
    'LBL_PRIMARY_ADDRESS_COUNTRY' 	=> 'Birincil Adres Ülke:',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' 	=> 'Birincil Posta Kodu:',
    'LBL_PRIMARY_ADDRESS_STATE' 	=> 'Birincil Adres Durumu:',
    'LBL_PRIMARY_ADDRESS_STREET_2' 	=> 'Birincil Adres Caddesi 2:',
    'LBL_PRIMARY_ADDRESS_STREET_3' 	=> 'Birincil Adres Sokak 3':
    'LBL_PRIMARY_ADDRESS_STREET' 	=> 'Birincil Adres Caddesi:',
    'LBL_PRIMARY_ADDRESS' 	=> 'Birincil Adres:',

    'LBL_PROSPECTS' 	=> 'Beklentiler',
    'LBL_PRODUCTS' 	=> 'Ürünler',
    'LBL_PROJECT_TASKS' 	=> 'Proje Görevleri',
    'LBL_PROJECTS' 	=> 'Projeler',
    'LBL_QUOTES' 	=> 'Tırnaklar',

    'LBL_RELATED' 	=> 'İlgili',
    'LBL_RELATED_RECORDS' 	=> 'İlgili Kayıtlar',
    'LBL_REMOVE' 	=> 'Kaldır',
    'LBL_REPORTS_TO' 	=> 'Raporlar Var',
    'LBL_REQUIRED_SYMBOL' 	=> '*',
    'LBL_REQUIRED_TITLE' 	=> 'Zorunlu alanı belirtir',
    'LBL_EMAIL_DONE_BUTTON_LABEL' 	=> "Bitti",
    'LBL_FULL_FORM_BUTTON_KEY' 	=> 'L',
    'LBL_FULL_FORM_BUTTON_LABEL' 	=> 'Tam Form',
    'LBL_FULL_FORM_BUTTON_TITLE' 	=> 'Tam Form',
    'LBL_SAVE_NEW_BUTTON_LABEL' 	=> 'Kaydet ve Yeni Oluştur',
    'LBL_SAVE_NEW_BUTTON_TITLE' 	=> 'Kaydet ve Yeni Oluştur',
    'LBL_SAVE_OBJECT' 	=> 'Kaydet {0}',
    'LBL_SEARCH_BUTTON_KEY' 	=> 'Q',
    'LBL_SEARCH_BUTTON_LABEL' 	=> 'Ara',
    'LBL_SEARCH_BUTTON_TITLE' 	=> 'Ara',
    'LBL_FILTER' 	=> 'Filtre',
    'LBL_SEARCH' 	=> 'Ara',
    'LBL_SEARCH_ALT' 	=> '',
    'LBL_SEARCH_MORE' 	=> 'daha',
    'LBL_UPLOAD_IMAGE_FILE_INVALID' 	=> 'Geçersiz dosya biçimi, sadece resim dosyası yüklenebilir.',
    'LBL_SELECT_BUTTON_KEY' 	=> 'T',
    'LBL_SELECT_BUTTON_LABEL' 	=> 'Seç',
    'LBL_SELECT_BUTTON_TITLE' 	=> 'Seç',
    'LBL_BROWSE_DOCUMENTS_BUTTON_LABEL' 	=> 'Belgelere Gözat',
    'LBL_BROWSE_DOCUMENTS_BUTTON_TITLE' 	=> 'Belgelere Gözat',
    'LBL_SELECT_CONTACT_BUTTON_KEY' 	=> 'T',
    'LBL_SELECT_CONTACT_BUTTON_LABEL' 	=> 'Kişi Seç',
    'LBL_SELECT_CONTACT_BUTTON_TITLE' 	=> 'Kişi Seç',
    'LBL_SELECT_REPORTS_BUTTON_LABEL' 	=> 'SELECT FROM Reports' (Raporlardan Seç),
    'LBL_SELECT_REPORTS_BUTTON_TITLE' 	=> 'Raporları Seç',
    'LBL_SELECT_USER_BUTTON_KEY' 	=> 'U',
    'LBL_SELECT_USER_BUTTON_LABEL' 	=> 'Kullanıcı Seç',
    'LBL_SELECT_USER_BUTTON_TITLE' 	=> 'Kullanıcı Seç',
    // Clear buttons take up too many keys, lets default the relate and collection ones to be empty
    'LBL_ACCESSKEY_CLEAR_RELATE_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_RELATE_TITLE' 	=> 'Seçimi Temizle',
    'LBL_ACCESSKEY_CLEAR_RELATE_LABEL' 	=> 'Seçimi Temizle',
    'LBL_ACCESSKEY_CLEAR_COLLECTION_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_COLLECTION_TITLE' 	=> 'Seçimi Temizle',
    'LBL_ACCESSKEY_CLEAR_COLLECTION_LABEL' 	=> 'Seçimi Temizle',
    'LBL_ACCESSKEY_SELECT_FILE_KEY' 	=> 'F',
    'LBL_ACCESSKEY_SELECT_FILE_TITLE' 	=> 'Dosya Seç',
    'LBL_ACCESSKEY_SELECT_FILE_LABEL' 	=> 'Dosya Seç',
    'LBL_ACCESSKEY_CLEAR_FILE_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_FILE_TITLE' 	=> 'Dosyayı Temizle',
    'LBL_ACCESSKEY_CLEAR_FILE_LABEL' 	=> 'Dosyayı Temizle',

    'LBL_ACCESSKEY_SELECT_USERS_KEY' 	=> 'U',
    'LBL_ACCESSKEY_SELECT_USERS_TITLE' 	=> 'Kullanıcı Seç',
    'LBL_ACCESSKEY_SELECT_USERS_LABEL' 	=> 'Kullanıcı Seç',
    'LBL_ACCESSKEY_CLEAR_USERS_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_USERS_TITLE' 	=> 'Kullanıcıyı Temizle',
    'LBL_ACCESSKEY_CLEAR_USERS_LABEL' 	=> 'Kullanıcıyı Temizle',
    'LBL_ACCESSKEY_SELECT_ACCOUNTS_KEY' 	=> 'A',
    'LBL_ACCESSKEY_SELECT_ACCOUNTS_TITLE' 	=> 'Hesap Seç',
    'LBL_ACCESSKEY_SELECT_ACCOUNTS_LABEL' 	=> 'Hesap Seç',
    'LBL_ACCESSKEY_CLEAR_ACCOUNTS_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_ACCOUNTS_TITLE' 	=> 'Hesabı Temizle',
    'LBL_ACCESSKEY_CLEAR_ACCOUNTS_LABEL' 	=> 'Hesabı Temizle',
    'LBL_ACCESSKEY_SELECT_CAMPAIGNS_KEY' 	=> 'M',
    'LBL_ACCESSKEY_SELECT_CAMPAIGNS_TITLE' 	=> 'Kampanyayı Seç',
    'LBL_ACCESSKEY_SELECT_CAMPAIGNS_LABEL' 	=> 'Kampanyayı Seç',
    'LBL_ACCESSKEY_CLEAR_CAMPAIGNS_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_CAMPAIGNS_TITLE' 	=> 'Kampanyayı Temizle',
    'LBL_ACCESSKEY_CLEAR_CAMPAIGNS_LABEL' 	=> 'Kampanyayı Temizle',
    'LBL_ACCESSKEY_SELECT_CONTACTS_KEY' 	=> 'C',
    'LBL_ACCESSKEY_SELECT_CONTACTS_TITLE' 	=> 'Kişi Seç',
    'LBL_ACCESSKEY_SELECT_CONTACTS_LABEL' 	=> 'Kişi Seç',
    'LBL_ACCESSKEY_CLEAR_CONTACTS_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_CONTACTS_TITLE' 	=> 'İletişim Kes',
    'LBL_ACCESSKEY_CLEAR_CONTACTS_LABEL' 	=> 'İletişim Kes',
    'LBL_ACCESSKEY_SELECT_TEAMSET_KEY' 	=> 'Z',
    'LBL_ACCESSKEY_SELECT_TEAMSET_TITLE' 	=> 'Takım Seç',
    'LBL_ACCESSKEY_SELECT_TEAMSET_LABEL' 	=> 'Takım Seç',
    'LBL_ACCESSKEY_CLEAR_TEAMS_KEY' 	=> '',
    'LBL_ACCESSKEY_CLEAR_TEAMS_TITLE' 	=> 'Takım Temizle',
    'LBL_ACCESSKEY_CLEAR_TEAMS_LABEL' 	=> 'Takım Temizle',
    'LBL_SERVER_RESPONSE_RESOURCES' 	=> 'Bu sayfayı oluşturmak için kullanılan kaynaklar (sorgular, dosyalar)',
    'LBL_SERVER_RESPONSE_TIME_SECONDS' 	=> 'saniye'
    'LBL_SERVER_RESPONSE_TIME' 	=> 'Sunucu yanıt süresi:',
    'LBL_SERVER_MEMORY_BYTES' 	=> 'bayt',
    'LBL_SERVER_MEMORY_USAGE' 	=> 'Sunucu Bellek Kullanımı: {0} ({1})',
    'LBL_SERVER_MEMORY_LOG_MESSAGE' 	=> 'Kullanım: - modül: {0} - eylem: {1}',
    'LBL_SERVER_PEAK_MEMORY_USAGE' 	=> 'Sunucu Zirve Bellek Kullanımı: {0} ({1})',
    'LBL_SHIPPING_ADDRESS' 	=> 'Nakliye Adresi',
    'LBL_SHOW' 	=> 'Göster'
    'LBL_STATE' 	=> 'Devlet:',
    'LBL_STATUS_UPDATED' 	=> 'Bu etkinliğin durumunuz güncellendi!',
    'LBL_STATUS' 	=> 'Durum:',
    'LBL_STREET' 	=> 'Cadde',
    'LBL_SUBJECT' 	=> 'Konu',

    'LBL_INBOUNDEMAIL_ID' 	=> 'Gelen E-posta Kimliği',

    'LBL_SCENARIO_SALES' 	=> 'Satış',
    'LBL_SCENARIO_MARKETING' 	=> 'Pazarlama'
    'LBL_SCENARIO_FINANCE' 	=> 'Maliye',
    'LBL_SCENARIO_SERVICE' 	=> 'Hizmet'
    'LBL_SCENARIO_PROJECT' 	=> 'Proje Yönetimi',

    'LBL_SCENARIO_SALES_DESCRIPTION' 	=> 'Bu senaryo satış ürünlerinin yönetimini kolaylaştırır',
    'LBL_SCENARIO_MAKETING_DESCRIPTION' 	=> 'Bu senaryo pazarlama ürünlerinin yönetimini kolaylaştırır',
    'LBL_SCENARIO_FINANCE_DESCRIPTION' 	=> 'Bu senaryo, finansmanla ilgili kalemlerin yönetimini kolaylaştırır'
    'LBL_SCENARIO_SERVICE_DESCRIPTION' 	=> 'Bu senaryo, hizmetle alakalı öğelerin yönetimini kolaylaştırır'
    'LBL_SCENARIO_PROJECT_DESCRIPTION' 	=> 'Bu senaryo proje ile ilgili öğelerin yönetimini kolaylaştırır'

    'LBL_SYNC' 	=> 'Senkronize et',
    'LBL_TABGROUP_ALL' 	=> 'Hepimiz',
    'LBL_TABGROUP_ACTIVITIES' 	=> 'Etkinlikler',
    'LBL_TABGROUP_COLLABORATION' 	=> 'İşbirliği',
    'LBL_TABGROUP_MARKETING' 	=> 'Pazarlama'
    'LBL_TABGROUP_OTHER' 	=> 'Diğer'
    'LBL_TABGROUP_SALES' 	=> 'Satış',
    'LBL_TABGROUP_SUPPORT' 	=> 'Destek',
    'LBL_TASKS' 	=> 'Görevler',
    'LBL_THOUSANDS_SYMBOL' 	=> 'K',
    'LBL_TRACK_EMAIL_BUTTON_LABEL' 	=> 'Arşiv E-postası',
    'LBL_TRACK_EMAIL_BUTTON_TITLE' 	=> 'Arşiv E-postası',
    'LBL_UNDELETE_BUTTON_LABEL' 	=> 'Geri alı sil'
    'LBL_UNDELETE_BUTTON_TITLE' 	=> 'Geri alı sil'
    'LBL_UNDELETE_BUTTON' 	=> 'Geri alı sil'
    'LBL_UNDELETE' 	=> 'Geri alı sil'
    'LBL_UNSYNC' 	=> 'Eşitsizlik',
    'LBL_UPDATE' 	=> 'Güncelle',
    'LBL_USER_LIST' 	=> 'Kullanıcı Listesi',
    'LBL_USERS' 	=> 'Kullanıcılar',
    'LBL_VERIFY_EMAIL_ADDRESS' 	=> 'Mevcut e-posta girişini kontrol et ...',
    'LBL_VERIFY_PORTAL_NAME' 	=> 'Varolan portal adını kontrol et ...',
    'LBL_VIEW_IMAGE' 	=> 'görüş',

    'LNK_ABOUT' 	=> 'Hakkında',
    'LNK_ADVANCED_FILTER' 	=> 'Gelişmiş Filtre',
    'LNK_BASIC_FILTER' 	=> 'Hızlı Filtre',
    'LBL_ADVANCED_SEARCH' 	=> 'Gelişmiş Filtre',
    'LBL_QUICK_FILTER' 	=> 'Hızlı Filtre',
    'LNK_SEARCH_NONFTS_VIEW_ALL' 	=> 'Tümünü Göster'
    'LNK_CLOSE' 	=> 'Kapat',
    'LBL_MODIFY_CURRENT_FILTER' 	=> 'Geçerli filtreyi değiştir',
    'LNK_SAVED_VIEWS' 	=> 'Düzen Seçenekleri',
    'LNK_DELETE' 	=> 'Sil',
    'LNK_EDIT' 	=> 'Düzenle',
    'LNK_GET_LATEST' 	=> 'Son gelişme',
    'LNK_GET_LATEST_TOOLTIP' 	=> 'Son sürümü ile değiştir',
    'LNK_HELP' 	=> 'Yardım',
    'LNK_CREATE' 	=> 'Oluştur',
    'LNK_LIST_END' 	=> 'Bitir',
    'LNK_LIST_NEXT' 	=> 'Sonraki',
    'LNK_LIST_PREVIOUS' 	=> 'Önceki',
    'LNK_LIST_RETURN' 	=> 'Listeye Dön',
    'LNK_LIST_START' 	=> 'Başla',
    'LNK_LOAD_SIGNED' 	=> 'İşaretle',
    'LNK_LOAD_SIGNED_TOOLTIP' 	=> 'İmzalı belgeyi değiştir',
    'LNK_PRINT' 	=> 'Baskı',
    'LNK_BACKTOTOP' 	=> 'Başa dön',
    'LNK_REMOVE' 	=> 'Kaldır',
    'LNK_RESUME' 	=> 'Özgeçmiş',
    'LNK_VIEW_CHANGE_LOG' 	=> 'Değişiklik Günlüğünü Görüntüle',

    'NTC_CLICK_BACK' 	=> 'Lütfen tarayıcı geri düğmesini tıklayın ve hatayı düzeltin.',
    'NTC_DATE_FORMAT' 	=> '(yyyy-aa-dd)',
    'NTC_DELETE_CONFIRMATION_MULTIPLE' 	=> 'Seçilen kayıtları silmek istediğinizden emin misiniz?',
    'NTC_TEMPLATE_IS_USED' 	=> 'Şablon en az bir e-posta pazarlama kaydında kullanılır. Silmek istediğinizden emin misiniz? ',
    'NTC_TEMPLATES_IS_USED' 	=> 'Aşağıdaki şablonlar e-posta pazarlama kayıtlarında kullanılır. Onları silmek istediğinizden emin misiniz? ' . PHP_EOL,
    'NTC_DELETE_CONFIRMATION' 	=> 'Bu kaydı silmek istediğinizden emin misiniz?',
    'NTC_DELETE_CONFIRMATION_NUM' 	=> 'Silmek istediğinizden emin misiniz',
    'NTC_UPDATE_CONFIRMATION_NUM' 	=> 'Güncellemek istediğinizden emin misiniz',
    'NTC_DELETE_SELECTED_RECORDS' 	=> 'seçilen kayıtlar?',
    'NTC_LOGIN_MESSAGE' 	=> 'Lütfen kullanıcı adınızı ve şifrenizi giriniz.',
    'NTC_NO_ITEMS_DISPLAY' 	=> 'yok',
    'NTC_REMOVE_CONFIRMATION' 	=> 'Bu ilişkiyi kaldırmak istediğinize emin misiniz? Yalnızca ilişki kaldırılacaktır. Kayıt silinmeyecek. ',
    'NTC_REQUIRED' 	=> 'Zorunlu alanı belirtir',
    'NTC_TIME_FORMAT' 	=> '(24: 00)',
    'NTC_WELCOME' 	=> 'Hoş geldiniz'
    'NTC_YEAR_FORMAT' 	=> '(yyyy)',
    'WARN_UNSAVED_CHANGES' 	=> 'Kayıt için yapmış olabileceğiniz değişiklikleri kaydetmeden bu kaydı terk etmek üzeresiniz. Bu rekorun dışına çıkmak istediğinden emin misin? ',
    'ERROR_NO_RECORD' 	=> 'Kayıt alınırken hata oluştu. Bu kayıt silinmiş olabilir veya görüntüleme yetkiniz bulunmayabilir. ',
    'WARN_BROWSER_VERSION_WARNING' 	=> '<b> Uyarı: </ b> Tarayıcınızın sürümü artık desteklenmiyor veya desteklenmeyen bir tarayıcı kullanıyorsunuz. <p> </ p> Aşağıdaki tarayıcı sürümleri önerilir: <p> </ p> <ul> <li> Internet Explorer 10 (uyumluluk görünümü desteklenmiyor) <li> Firefox 32.0 <li> Safari 5.1 <li> Chrome 37 </ ul> ',
    'WARN_BROWSER_IE_COMPATIBILITY_MODE_WARNING' 	=> '<b> Uyarı: </ b> Tarayıcınız desteklenmeyen IE uyumluluk görünümündedir.',
    'ERROR_TYPE_NOT_VALID' 	=> 'Hata. Bu tür bir geçerli değil. ',
    'ERROR_NO_BEAN' 	=> 'Fasulye alınamadı'.
    'LBL_DUP_MERGE' 	=> 'Yinelenenleri Bul',
    'LBL_MANAGE_SUBSCRIPTIONS' 	=> 'Abonelikleri Yönet',
    'LBL_MANAGE_SUBSCRIPTIONS_FOR' 	=> 'Abonelikleri Yönet'
    // Ajax status strings
    'LBL_LOADING' 	=> 'Yükleniyor ...',
    'LBL_SAVING_LAYOUT' 	=> 'Tasarruf Düzeni ...',
    'LBL_SAVED_LAYOUT' 	=> 'Yerleşim kaydedildi.',
    'LBL_SAVED' 	=> 'Kaydedildi'
    'LBL_SAVING' 	=> 'Tasarruf',
    'LBL_DISPLAY_COLUMNS' 	=> 'Sütunları Göster',
    'LBL_HIDE_COLUMNS' 	=> 'Sütunları Gizle',
    'LBL_PROCESSING_REQUEST' 	=> 'İşleniyor ...',
    'LBL_REQUEST_PROCESSED' 	=> "Bitti",
    'LBL_AJAX_FAILURE' 	=> 'Ajax hatası'
    'LBL_MERGE_DUPLICATES' 	=> 'Birleştir',
    'LBL_SAVED_FILTER_SHORTCUT' 	=> 'Filtrelerim'
    'LBL_SEARCH_POPULATE_ONLY' 	=> 'Yukarıdaki arama formunu kullanarak arama yapın',
    'LBL_DETAILVIEW' 	=> 'Ayrıntılı Görünüm',
    'LBL_LISTVIEW' 	=> 'Liste Görünümü',
    'LBL_EDITVIEW' 	=> 'Görünümü Düzenle',
    'LBL_BILLING_STREET' 	=> 'Sokak:',
    'LBL_SHIPPING_STREET' 	=> 'Sokak:',
    'LBL_SEARCHFORM' 	=> 'Arama Formu',
    'LBL_SAVED_SEARCH_ERROR' 	=> 'Lütfen bu görünüm için bir ad sağlayın.',
    'LBL_DISPLAY_LOG' 	=> 'Ekran Günlüğü',
    'ERROR_JS_ALERT_SYSTEM_CLASS' 	=> 'Sistem',
    'ERROR_JS_ALERT_TIMEOUT_TITLE' 	=> 'Oturum Zaman Aşımı',
    'ERROR_JS_ALERT_TIMEOUT_MSG_1' 	=> 'Oturumunuz 2 dakika içinde zaman aşımına uğrayacak. Lütfen işinizi kaydedin. ',
    'ERROR_JS_ALERT_TIMEOUT_MSG_2' 	=> 'Oturumunuz zaman aşımına uğradı.',
    'MSG_JS_ALERT_MTG_REMINDER_AGENDA' 	=> "\ nHediye:",
    'MSG_JS_ALERT_MTG_REMINDER_MEETING' 	=> 'Toplantı',
    'MSG_JS_ALERT_MTG_REMINDER_CALL' 	=> 'Ara',
    'MSG_JS_ALERT_MTG_REMINDER_TIME' 	=> 'Zaman':
    'MSG_JS_ALERT_MTG_REMINDER_LOC' 	=> 'Yer:',
    'MSG_JS_ALERT_MTG_REMINDER_DESC' 	=> 'Tanım:',
    'MSG_JS_ALERT_MTG_REMINDER_STATUS' 	=> 'Durum:',
    'MSG_JS_ALERT_MTG_REMINDER_RELATED_TO' 	=> 'İlişkili:',
    'MSG_JS_ALERT_MTG_REMINDER_CALL_MSG' 	=> "\ nBu aramayı görmek için Tamam'a tıklayın veya bu mesajı atlamak için İptal'e tıklayın.",
    'MSG_JS_ALERT_MTG_REMINDER_MEETING_MSG' 	=> "\ nBu toplantıyı görüntülemek için Tamam'ı tıklatın veya bu iletiyi kapatmak için İptal'i tıklayın.",
    'MSG_JS_ALERT_MTG_REMINDER_NO_EVENT_NAME' 	=> 'Etkinlik',
    'MSG_JS_ALERT_MTG_REMINDER_NO_DESCRIPTION' 	=> 'Etkinlik ayarlanmadı.',
    'MSG_JS_ALERT_MTG_REMINDER_NO_LOCATION' 	=> 'Konum ayarlanmadı.',
    'MSG_JS_ALERT_MTG_REMINDER_NO_START_DATE' 	=> 'Başlangıç ​​tarihi tanımlanmadı \.',
    'MSG_LIST_VIEW_NO_RESULTS_BASIC' 	=> 'Sonuç bulunamadı.',
    'MSG_LIST_VIEW_NO_RESULTS_CHANGE_CRITERIA' 	=> 'Sonuç bulunamadı ... Belki de arama ölçütlerinizi değiştirip tekrar deneyin?',
    'MSG_LIST_VIEW_NO_RESULTS' 	=> '<Item1>için sonuç bulunamadı. ',
    'MSG_LIST_VIEW_NO_RESULTS_SUBMSG' 	=> '<Item1> ı yeni bir <item2> olarak oluştur',
    'MSG_LIST_VIEW_CHANGE_SEARCH' 	=> 'veya arama kriterlerinizi değiştirin',
    'MSG_EMPTY_LIST_VIEW_NO_RESULTS' 	=> 'Kayıtlı kayıtlarınız yok. <item2> veya <item3> şimdi. ',

    'LBL_CLICK_HERE' 	=> 'Buraya tıklayın',
    // contextMenu strings
    'LBL_ADD_TO_FAVORITES' 	=> 'Favorilerime Ekle',
    'LBL_CREATE_CONTACT' 	=> 'Kişi Oluştur',
    'LBL_CREATE_CASE' 	=> 'Vaka Oluşturma',
    'LBL_CREATE_NOTE' 	=> 'Not oluştur',
    'LBL_CREATE_OPPORTUNITY' 	=> 'Fırsat Yarat',
    'LBL_SCHEDULE_CALL' 	=> 'Çağrı Günlüğü',
    'LBL_SCHEDULE_MEETING' 	=> 'Toplantıyı Zamanlama',
    'LBL_CREATE_TASK' 	=> 'Görev Oluştur',
    //web to lead
    'LBL_GENERATE_WEB_TO_LEAD_FORM' 	=> 'Form Yarat',
    'LBL_SAVE_WEB_TO_LEAD_FORM' 	=> 'Web Formunu Kaydet',
    'LBL_AVAILABLE_FIELDS' 	=> 'Kullanılabilir Alanlar',
    'LBL_FIRST_FORM_COLUMN' 	=> 'İlk Form Sütunu',
    'LBL_SECOND_FORM_COLUMN' 	=> 'İkinci Form Sütunu',
    'LBL_ASSIGNED_TO_REQUIRED' 	=> 'Gerekli eksik alan: Atanmış',
    'LBL_RELATED_CAMPAIGN_REQUIRED' 	=> 'Gerekli alan eksik: İlgili kampanya',
    'LBL_TYPE_OF_PERSON_FOR_FORM' 	=> 'Web formu oluşturmak',
    'LBL_TYPE_OF_PERSON_FOR_FORM_DESC' 	=> 'Bu formu göndermek üretecektir',

    'LBL_ADD_ALL_LEAD_FIELDS' 	=> 'Tüm Alanları Ekle',
    'LBL_RESET_ALL_LEAD_FIELDS' 	=> 'Tüm Alanları Sıfırla',
    'LBL_REMOVE_ALL_LEAD_FIELDS' 	=> 'Tüm Alanları Kaldır',
    'LBL_NEXT_BTN' 	=> 'Sonraki',
    'LBL_ONLY_IMAGE_ATTACHMENT' 	=> 'Yalnızca aşağıdaki desteklenen resim türü ekleri yerleştirilebilir: JPG, PNG.',
    'LBL_TRAINING' 	=> 'Destek Forumu',
    'ERR_MSSQL_DB_CONTEXT' 	=> 'Değişen veritabanı bağlamı',
    'ERR_MSSQL_WARNING' 	=> 'Uyarı:',

    //Meta-Data framework
    'ERR_CANNOT_CREATE_METADATA_FILE' 	=> 'Hata: Dosya [[dosya]] eksik. İlgili HTML dosyası bulunamadığından oluşturulamadı. ',
    'ERR_CANNOT_FIND_MODULE' 	=> 'Hata: Modül [modül] mevcut değil.',
    'LBL_ALT_ADDRESS' 	=> 'Diğer Adres:',
    'ERR_SMARTY_UNEQUAL_RELATED_FIELD_PARAMETERS' 	=> 'Hata: displayParams arraysindeki \' anahtar \'ve \' kopyalama \'öğeleri için eşit olmayan sayıda bağımsız değişken var.',

    /* MySugar Framework (for Home and Dashboard) */
    'LBL_DASHLET_CONFIGURE_GENERAL' 	=> 'Genel',
    'LBL_DASHLET_CONFIGURE_FILTERS' 	=> 'Filtreler',
    'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY' 	=> 'Sadece Öğelerim'
    'LBL_DASHLET_CONFIGURE_TITLE' 	=> 'Başlık',
    'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS' 	=> 'Satırları Göster',

    // MySugar status strings
    'LBL_MAX_DASHLETS_REACHED' 	=> 'Yönetici tarafından belirlenen azami SuiteCRM Dashlet sayısına ulaştınız. Lütfen daha fazla eklemek için bir SuiteCRM Dashleti kaldırın. ',
    'LBL_ADDING_DASHLET' 	=> 'SuiteCRM Dashlet Ekleniyor ...',
    'LBL_ADDED_DASHLET' 	=> 'SuiteCRM Dashlet Eklendi',
    'LBL_REMOVE_DASHLET_CONFIRM' 	=> 'SuiteCRM Dashleti silmek istediğinizden emin misiniz?',
    'LBL_REMOVING_DASHLET' 	=> 'SuiteCRM Dashleti Kaldırmak ...',
    'LBL_REMOVED_DASHLET' 	=> 'SuiteCRM Dashlet Çıkartıldı',

    // MySugar Menu Options

    'LBL_LOADING_PAGE' 	=> 'Sayfa yükleniyor, lütfen bekleyin ...',

    'LBL_RELOAD_PAGE' 	=> 'SuiteCRM de Lütfen <a href="javascript: window.location.reload()">yeniden yüklemek için </a> bunu kullan.'
    'LBL_ADD_DASHLETS' 	=> 'Add Dashlets',
    'LBL_CLOSE_DASHLETS' 	=> 'Kapat',
    'LBL_OPTIONS' 	=> 'Seçenekler',
    'LBL_1_COLUMN' 	=> '1 Sütun',
    'LBL_2_COLUMN' 	=> '2 Sütun',
    'LBL_3_COLUMN' 	=> '3 Sütun',
    'LBL_PAGE_NAME' 	=> 'Sayfa Adı',

    'LBL_SEARCH_RESULTS' 	=> 'Arama Sonuçları',
    'LBL_SEARCH_MODULES' 	=> 'Modüller',
    'LBL_SEARCH_TOOLS' 	=> 'Araçlar',
    'LBL_SEARCH_HELP_TITLE' 	=> 'Arama İpuçları',
    /* End MySugar Framework strings */

    'LBL_NO_IMAGE' 	=> 'Resim Yok',

    'LBL_MODULE' 	=> 'Modül',

    //adding a label for address copy from left
    'LBL_COPY_ADDRESS_FROM_LEFT' 	=> 'Sol taraftan adres kopyala:',
    'LBL_SAVE_AND_CONTINUE' 	=> 'Kaydet ve Devam et',

    'LBL_SEARCH_HELP_TEXT' 	=> '<p> <br /> <strong> Çoklu seçim denetimleri </ strong> </ p> <ul> <li> Bir özellik seçmek için değerleri tıklayın. </ li> <li> & nbsp; birden çok seç. Mac kullanıcıları CMD tıklama özelliğini kullanır. </ Li> <li> İki özellik arasındaki tüm değerleri seçmek için & nbsp; </ li> </ ul> <p> <strong> Gelişmiş Arama ve Düzen Seçenekleri </ strong> <br> <br> <b> Kayıtlı Arama ve Yerleşimi'ni kullanarak <b> İlk değerini & nbsp; </ b> seçeneğini kullanırsanız, istediğiniz arama sonuçlarını hızlı bir şekilde elde etmek için bir array arama parametresi ve / veya özel Liste Görünümü düzenini kaydedebilirsiniz. Sınırsız sayıda özel arama ve düzen kaydedebilirsiniz. Kaydedilen tüm aramalar Kayıtlı Aramalar listesinde ismiyle görünür ve son yüklenen kayıtlı arama listenin en üstünde görünür. <br> <br> Liste Görünümü düzenini özelleştirmek için, Sütunları Gizle ve Sütunları Görüntüle kutularını kullanarak alanlarını arama sonuçlarında görüntülemek için kullanın. Örneğin, kayıt adı, atanmış kullanıcı ve atanan ekip gibi ayrıntıları arama sonuçlarında görüntüleyebilir veya gizleyebilirsiniz. Liste Görünümü'ne bir sütun eklemek için, Sütunları Gizle listesinden alanı seçin ve Sütunları Görüntüle listesine taşımak için sol oku kullanın. Bir Sütunu Liste Görünümünden kaldırmak için Sütunları Görüntüle listesinden seçin ve Sütunları Gizle listesine taşımak için sağ oku kullanın. Sayfa düzen ayarlarını kaydedin, bunları herhangi bir yere yükleyebilirsiniz. Arama sonuçlarını özel düzeninde görüntülemek için zaman. <ol> <li> Arama sonuçlarına bir ad girin; <b> Bu Aramayı Farklı Kaydet </ b> alanına gidin ve <b> Kaydet </ b> 'i tıklayın. Adı artık <b> Temizle </ b> düğmesinin yanında bulunan Kayıtlı Aramalar listesinde görüntülenir. </ li> <li> Kaydedilmiş bir aramayı görüntülemek için , Kaydedilen Aramalar listesinden seçin. Arama sonuçları Liste Görünümünde görüntülenir. </ Li> <li> Kaydedilen bir aramanın özelliklerini güncellemek için listedeki kayıtlı aramayı seçin, Gelişmiş Arama alanında yeni arama ölçütlerini ve / veya düzen seçeneklerini girin, <b> Geçerli Aramayı Değiştir </ b> 'in yanındaki <b> Güncelle </ b>' yi tıklayın. </ li> <li> Kaydedilen bir aramayı silmek için Kayıtlı Aramalar listesinden seçin ve <b> Sil < / b> Geçerli Aramayı Değiştir </ b> 'in yanında ve ardından silme işlemini onaylamak için <b> Tamam </ b>' ı tıklayın. </ li> </ ol> <p> <strong> İpuçları </ strong > <br> <br>% 'i joker karakterli bir operatör olarak kullanarak aramanızı daha geniş hale getirebilirsiniz. Örneğin, sadece "Elmalar" ile eşit sonuçların aranması yerine, aramanızı "Elmalar%" olarak değiştirebilir; Elma kelimesiyle başlayan ancak diğer karakterleri de içerebilen tüm sonuçları eşleştirebilir. </ P> ',

    //resource management
    'ERR_QUERY_LIMIT' 	=> 'Hata: $ modül modülü için $ limit sorgusu sınırına ulaşıldı.',
    'ERROR_NOTIFY_OVERRIDE' 	=> 'Hata: ResourceObserver-> notify () öğesinin geçersiz kılınması gerekir.',

    //tracker labels
    'ERR_MONITOR_FILE_MISSING' 	=> 'Hata: metadata dosyası boş olduğundan veya dosya yok olduğundan monitör oluşturulamadı.',
    'ERR_MONITOR_NOT_CONFIGURED' 	=> 'Hata: istenen ad için yapılandırılmış bir monitör yok',
    'ERR_UNDEFINED_METRIC' 	=> 'Hata: Tanımsız metrik için değer ayarlanamadı',
    'ERR_STORE_FILE_MISSING' 	=> 'Hata: Mağaza uygulama dosyası bulunamadı',

    'LBL_MONITOR_ID' 	=> 'Monitör Kimliği'
    'LBL_USER_ID' 	=> 'Kullanıcı Kimliği',
    'LBL_MODULE_NAME' 	=> 'Modül Adı',
    'LBL_ITEM_ID' 	=> 'Öğe Kimliği',
    'LBL_ITEM_SUMMARY' 	=> 'Öğe Özeti',
    'LBL_ACTION' 	=> 'Eylem',
    'LBL_SESSION_ID' 	=> 'Oturum Kimliği'
    'LBL_BREADCRUMBSTACK_CREATED' 	=> 'Kullanıcı kimliği {0} için oluşturulmuş BreadCrumbStack',
    'LBL_VISIBLE' 	=> 'Kayıt Görünürlüğü'
    'LBL_DATE_LAST_ACTION' 	=> 'Son İşlem Tarihi',

    //jc:#12287 - For javascript validation messages
    'MSG_IS_NOT_BEFORE' 	=> 'daha önce değil'
    'MSG_IS_MORE_THAN' 	=> 'fazla',
    'MSG_SHOULD_BE' 	=> 'olması gerekir',
    'MSG_OR_GREATER' 	=> 'veya daha büyük'

    'LBL_LIST' 	=> 'Liste',
    'LBL_CREATE_BUG' 	=> 'Hata Oluştur',

    'LBL_OBJECT_IMAGE' 	=> 'nesne resmi',
    //jchi #12300
    'LBL_MASSUPDATE_DATE' 	=> 'Tarih Seç',

    'LBL_VALIDATE_RANGE' 	=> 'geçerli aralıkta değil',
    'LBL_CHOOSE_START_AND_END_DATES' 	=> 'Lütfen bir başlangıç ​​ve bitiş tarih aralığını seçin',
    'LBL_CHOOSE_START_AND_END_ENTRIES' 	=> 'Lütfen hem başlangıç ​​hem de bitiş aralığı girdilerini seçin',

    //jchi #  20776
    'LBL_DROPDOWN_LIST_ALL' 	=> 'Hepimiz',

    //Connector
    'ERR_CONNECTOR_FILL_BEANS_SIZE_MISMATCH' 	=> 'Hata: fasulye parametresinin Array sayısı, sonuçların Array sayısıyla eşleşmiyor.',
    'ERR_MISSING_MAPPING_ENTRY_FORM_MODULE' 	=> 'Hata: Modül için haritalama girişi eksik.',
    'ERROR_UNABLE_TO_RETRIEVE_DATA' 	=> 'Hata: {0} Bağlayıcı için veri alınamadı. Hizmet şu anda erişilemiyor olabilir veya yapılandırma ayarları geçersiz olabilir. Bağlayıcı hata iletisi: ({1}). ',

    // fastcgi checks
    'LBL_FASTCGI_LOGGING' 	=> 'IIS / FastCGI sapi kullanarak optimum deneyim için, fastcgi.logging dosyasını php.ini dosyanızda 0 olarak ayarlayın.',

    //Collection Field
    'LBL_COLLECTION_NAME' 	=> 'İsim',
    'LBL_COLLECTION_PRIMARY' 	=> 'İlköğretim'
    'ERROR_MISSING_COLLECTION_SELECTION' 	=> 'Gerekli alanları boşalt',

    //MB -Fixed Bug #32812 -Max
    'LBL_ASSIGNED_TO_NAME' 	=> 'Atandı',
    'LBL_DESCRIPTION' 	=> 'Açıklama',

    'LBL_YESTERDAY' 	=> 'dün',
    'LBL_TODAY' 	=> 'bugün'
    'LBL_TOMORROW' 	=> 'yarın',
    'LBL_NEXT_WEEK' 	=> 'önümüzdeki hafta'
    'LBL_NEXT_MONDAY' 	=> 'gelecek pazartesi günü'
    'LBL_NEXT_FRIDAY' 	=> 'önümüzdeki cuma',
    'LBL_TWO_WEEKS' 	=> 'iki hafta',
    'LBL_NEXT_MONTH' 	=> 'önümüzdeki ay'
    'LBL_FIRST_DAY_OF_NEXT_MONTH' 	=> 'önümüzdeki ayın ilk günü'
    'LBL_THREE_MONTHS' 	=> 'üç ay'
    'LBL_SIXMONTHS' 	=> 'altı ay',
    'LBL_NEXT_YEAR' 	=> 'gelecek yıl'

    //Datetimecombo fields
    'LBL_HOURS' 	=> 'Saatler',
    'LBL_MINUTES' 	=> 'Dakika',
    'LBL_MERIDIEM' 	=> 'Meridiem',
    'LBL_DATE' 	=> 'Tarih',
    'LBL_DASHLET_CONFIGURE_AUTOREFRESH' 	=> 'Otomatik Yenile',

    'LBL_DURATION_DAY' 	=> 'gün',
    'LBL_DURATION_HOUR' 	=> 'saat',
    'LBL_DURATION_MINUTE' 	=> 'dakika',
    'LBL_DURATION_DAYS' 	=> 'günler'
    'LBL_DURATION_HOURS' 	=> 'Süre Saatleri',
    'LBL_DURATION_MINUTES' 	=> 'Süre Dakika',

    //Calendar widget labels
    'LBL_CHOOSE_MONTH' 	=> 'Ay Seç',
    'LBL_ENTER_YEAR' 	=> 'Yıl girin',
    'LBL_ENTER_VALID_YEAR' 	=> 'Lütfen geçerli bir yıl giriniz',

    //File write error label
    'ERR_FILE_WRITE' 	=> 'Hata: {0} dosyası yazamadı. Lütfen sistem ve web sunucusu izinlerini kontrol edin. ',
    'ERR_FILE_NOT_FOUND' 	=> 'Hata: {0} dosyası yüklenemedi. Lütfen sistem ve web sunucusu izinlerini kontrol edin. ',

    'LBL_AND' 	=> 'Ve',

    // File fields
    'LBL_SEARCH_EXTERNAL_API' 	=> 'Dış Kaynak Dosyası',
    'LBL_EXTERNAL_SECURITY_LEVEL' 	=> 'Güvenlik',

    //IMPORT SAMPLE TEXT
    'LBL_IMPORT_SAMPLE_FILE_TEXT' 	=> '
This is a sample import file which provides an example of the expected contents of a file that is ready for import.
The file is a comma-delimited .csv file, using double-quotes as the field qualifier.

The header row is the top-most row in the file and contains the field labels as you would see them in the application.
These labels are used for mapping the data in the file to the fields in the application.

Notes: The database names could also be used in the header row. This is useful when you are using phpMyAdmin or another database tool to provide an exported list of data to import.
The column order is not critical as the import process matches the data to the appropriate fields based on the header row.


To use this file as a template, do the following:
1. Remove the sample rows of data
2. Remove the help text that you are reading right now
3. Input your own data into the appropriate rows and columns
4. Save the file to a known location on your system
5. Click on the Import option from the Actions menu in the application and choose the file to upload
   ',
    //define labels to be used for overriding local values during import/export

    'LBL_NOTIFICATIONS_NONE' 	=> 'Geçerli Bildirim Yok',
    'LBL_ALT_SORT_DESC' 	=> 'Sıralı azalan',
    'LBL_ALT_SORT_ASC' 	=> 'Artan Sırala',
    'LBL_ALT_SORT' 	=> 'Sırala',
    'LBL_ALT_SHOW_OPTIONS' 	=> 'Seçenekleri Göster',
    'LBL_ALT_HIDE_OPTIONS' 	=> 'Seçenekleri Gizle',
    'LBL_ALT_MOVE_COLUMN_LEFT' 	=> 'Seçili girdiyi sol taraftaki listeye taşı',
    'LBL_ALT_MOVE_COLUMN_RIGHT' 	=> 'Seçilen girdiyi sağdaki listeye taşı',
    'LBL_ALT_MOVE_COLUMN_UP' 	=> 'Seçilen girdiyi gösterilen liste sırasına taşı',
    'LBL_ALT_MOVE_COLUMN_DOWN' 	=> 'Seçilen girişi gösterilen liste sırasına taşı',
    'LBL_ALT_INFO' 	=> 'Bilgi',
    'MSG_DUPLICATE' 	=> 'Oluşturmak istediğiniz {0} kaydı mevcut bir {0} kaydından bir kopya olabilir. Benzer adları içeren {1} kayıtlar aşağıda listelenmiştir. <br> Bu yeni {0} 'yi oluşturmaya devam etmek için Oluştur {1}' i tıklayın veya aşağıda listelenen mevcut bir {0} seçin. ',
    'MSG_SHOW_DUPLICATES' 	=> 'Oluşturmak istediğiniz {0} kaydı mevcut bir {0} kaydından bir kopya olabilir. Benzer isimleri içeren {1} kayıtlar aşağıda listelenmiştir. Bu yeni {0} 'yi oluşturmaya devam etmek için Kaydet'i tıklayın veya {0} oluşturmadan modüle dönmek için İptal'i tıklayın.
    'LBL_EMAIL_TITLE' 	=> 'e-posta adresi',
    'LBL_EMAIL_OPT_TITLE' 	=> 'e-posta adresini iptal et',
    'LBL_EMAIL_INV_TITLE' 	=> 'geçersiz e-posta adresi',
    'LBL_EMAIL_PRIM_TITLE' 	=> 'Birincil E-posta Adresi Yap',
    'LBL_SELECT_ALL_TITLE' 	=> 'Tümünü seç',
    'LBL_SELECT_THIS_ROW_TITLE' 	=> 'Bu satırı seçin'

    //for upload errors
    'UPLOAD_ERROR_TEXT' 	=> 'HATA: Yükleme sırasında bir hata oluştu. Hata kodu: {0} - {1} ',
    'UPLOAD_ERROR_TEXT_SIZEINFO' 	=> 'HATA: Yükleme sırasında bir hata oluştu. Hata kodu: {0} - {1}. Upload_maxsize {2} ',
    'UPLOAD_ERROR_HOME_TEXT' 	=> 'HATA: Yükleme sırasında bir hata oluştu, lütfen yardım için bir yöneticiyle iletişime geçin.',
    'UPLOAD_MAXIMUM_EXCEEDED' 	=> 'Yükleme Boyutu ({0} bayt) Aştı Maksimum: {1} bayt',
    'UPLOAD_REQUEST_ERROR' 	=> 'Bir hata oluştu. Lütfen sayfanızı yenileyin ve tekrar deneyin. ',

    //508 used Access Keys
    'LBL_EDIT_BUTTON_KEY' 	=> 'i',
    'LBL_EDIT_BUTTON_LABEL' 	=> 'Düzenle',
    'LBL_EDIT_BUTTON_TITLE' 	=> 'Düzenle',
    'LBL_DUPLICATE_BUTTON_KEY' 	=> "u",
    'LBL_DUPLICATE_BUTTON_LABEL' 	=> 'Çoğalt'
    'LBL_DUPLICATE_BUTTON_TITLE' 	=> 'Çoğalt'
    'LBL_DELETE_BUTTON_KEY' 	=> 'd',
    'LBL_DELETE_BUTTON_LABEL' 	=> 'Sil',
    'LBL_DELETE_BUTTON_TITLE' 	=> 'Sil',
    'LBL_BULK_ACTION_BUTTON_LABEL' 	=> 'BÜYÜK EYLEM',
    'LBL_BULK_ACTION_BUTTON_LABEL_MOBILE' 	=> 'EYLEM',
    'LBL_SAVE_BUTTON_KEY' 	=> 'a',
    'LBL_SAVE_BUTTON_LABEL' 	=> 'Kaydet',
    'LBL_SAVE_BUTTON_TITLE' 	=> 'Kaydet',
    'LBL_CANCEL_BUTTON_KEY' 	=> 'l',
    'LBL_CANCEL_BUTTON_LABEL' 	=> 'İptal et',
    'LBL_CANCEL_BUTTON_TITLE' 	=> 'İptal et',
    'LBL_FIRST_INPUT_EDIT_VIEW_KEY' 	=> '7',
    'LBL_ADV_SEARCH_LNK_KEY' 	=> '8',
    'LBL_FIRST_INPUT_SEARCH_KEY' 	=> '9',

    'ERR_CONNECTOR_NOT_ARRAY' 	=> '{0} daki konektör arraysi yanlış tanımlanmış veya boş ve kullanılamıyor. ',
    'ERR_SUHOSIN' 	=> 'Karşıya yükleme akışı Suhosin tarafından engellendi, lütfen & quot; upload & quot; suhosin.executor.include.whitelist (Daha fazla bilgi için suitecrm.loga bakın) ',
    'ERR_BAD_RESPONSE_FROM_SERVER' 	=> 'Sunucudan yanlış yanıt',
    'LBL_ACCOUNT_PRODUCT_QUOTE_LINK' 	=> 'Alıntı',
    'LBL_ACCOUNT_PRODUCT_SALE_PRICE' 	=> 'Satış Fiyatı',
    'LBL_EMAIL_CHECK_INTERVAL_DOM' 	=> array (
        '-1' 	=> 'Elle',
        '5' 	=> 'Her 5 dakikada bir'
        '15' 	=> 'Her 15 dakikada bir'
        '30' 	=> 'Her 30 dakikada bir'
        '60' 	=> 'Her saat',
    ),		

    'ERR_A_REMINDER_IS_EMPTY_OR_INCORRECT' 	=> 'Bir hatırlatıcı boş veya yanlış.',
    'ERR_REMINDER_IS_NOT_SET_POPUP_OR_EMAIL' 	=> 'Anımsatıcı popup veya e-posta için ayarlanmamış.',
    'ERR_NO_INVITEES_FOR_REMINDER' 	=> 'Hatırlatma için davetliler yok'.
    'LBL_DELETE_REMINDER_CONFIRM' 	=> 'Hatırlatıcı davetlileri içermiyor, hatırlatıcıyı kaldırmak istiyor musunuz?',
    'LBL_DELETE_REMINDER' 	=> 'Hatırlatıcıyı Sil',
    'LBL_OK' 	=> 'Tamam',

    'LBL_COLUMNS_FILTER_HEADER_TITLE' 	=> 'Sütunları seç',
    'LBL_COLUMN_CHOOSER' 	=> 'Sütun Seçici',
    'LBL_SAVE_CHANGES_BUTTON_TITLE' 	=> 'Değişiklikleri kaydet',
    'LBL_DISPLAYED' 	=> 'Görüntülenen',
    'LBL_HIDDEN' 	=> 'Gizli'
    'ERR_EMPTY_COLUMNS_LIST' 	=> 'En azından bir unsur gerekli',

    'LBL_FILTER_HEADER_TITLE' 	=> 'Filtre',

    'LBL_CATEGORY' 	=> 'Kategori',
    'LBL_LIST_CATEGORY' 	=> 'Kategori',

    'LBL_SECURITYGROUP_NONINHERITABLE' 	=> 'Devralınamaz Grup',
    'LBL_PRIMARY_GROUP' 	=> "Birincil Grup",

    'LBL_CONFIRM_DISREGARD_DRAFT_TITLE' 	=> 'Taslakları dikkate almayın',
    'LBL_CONFIRM_DISREGARD_DRAFT_BODY' 	=> 'Bu işlem bu e-postayı silecektir, devam etmek istiyor musunuz?',
    'LBL_CONFIRM_APPLY_EMAIL_TEMPLATE_TITLE' 	=> 'E-posta Şablonu Uygula',
    'LBL_CONFIRM_APPLY_EMAIL_TEMPLATE_BODY' 	=> 'Bu işlem e-postanın Gövde ve Konu alanlarını geçersiz kılacak, devam etmek istiyor musunuz?',
);	

$app_list_strings['moduleList']['Library'] ='Kütüphane';
$app_list_strings['moduleList']['EmailAddresses'] = 'E';
$app_list_strings['project_priority_default'] = 'Orta';
$app_list_strings['project_priority_options'] = array(
    'High' 	=> 'Yüksek',
    'Medium' 	=> 'Orta',
    'Low' 	=> 'Düşük',
);	

$app_list_strings['moduleList']['KBDocuments'] ='Bilgi tabanı';

$app_list_strings['countries_dom']  array(
    '' 	=> '',
    'ABU DHABI' 	=> 'ABU DHABI',
    'ADEN' 	=> 'ADEN',
    'AFGHANISTAN' 	=> 'AFGHANISTAN',
    'ALBANIA' 	=> 'ALBANIA',
    'ALGERIA' 	=> 'ALGERIA',
    'AMERICAN SAMOA' 	=> 'AMERICAN SAMOA',
    'ANDORRA' 	=> 'ANDORRA',
    'ANGOLA' 	=> 'ANGOLA',
    'ANTARCTICA' 	=> 'ANTARCTICA',
    'ANTIGUA' 	=> 'ANTIGUA',
    'ARGENTINA' 	=> 'ARGENTINA',
    'ARMENIA' 	=> 'ARMENIA',
    'ARUBA' 	=> 'ARUBA',
    'AUSTRALIA' 	=> 'AUSTRALIA',
    'AUSTRIA' 	=> 'AUSTRIA',
    'AZERBAIJAN' 	=> 'AZERBAIJAN',
    'BAHAMAS' 	=> 'BAHAMAS',
    'BAHRAIN' 	=> 'BAHRAIN',
    'BANGLADESH' 	=> 'BANGLADESH',
    'BARBADOS' 	=> 'BARBADOS',
    'BELARUS' 	=> 'BELARUS',
    'BELGIUM' 	=> 'BELGIUM',
    'BELIZE' 	=> 'BELIZE',
    'BENIN' 	=> 'BENIN',
    'BERMUDA' 	=> 'BERMUDA',
    'BHUTAN' 	=> 'BHUTAN',
    'BOLIVIA' 	=> 'BOLIVIA',
    'BOSNIA' 	=> 'BOSNIA',
    'BOTSWANA' 	=> 'BOTSWANA',
    'BOUVET ISLAND' 	=> 'BOUVET ISLAND',
    'BRAZIL' 	=> 'BRAZIL',
    'BRITISH ANTARCTICA TERRITORY' 	=> 'BRITISH ANTARCTICA TERRITORY',
    'BRITISH INDIAN OCEAN TERRITORY' 	=> 'BRITISH INDIAN OCEAN TERRITORY',
    'BRITISH VIRGIN ISLANDS' 	=> 'BRITISH VIRGIN ISLANDS',
    'BRITISH WEST INDIES' 	=> 'BRITISH WEST INDIES',
    'BRUNEI' 	=> 'BRUNEI',
    'BULGARIA' 	=> 'BULGARIA',
    'BURKINA FASO' 	=> 'BURKINA FASO',
    'BURUNDI' 	=> 'BURUNDI',
    'CAMBODIA' 	=> 'CAMBODIA',
    'CAMEROON' 	=> 'CAMEROON',
    'CANADA' 	=> 'CANADA',
    'CANAL ZONE' 	=> 'CANAL ZONE',
    'CANARY ISLAND' 	=> 'CANARY ISLAND',
    'CAPE VERDI ISLANDS' 	=> 'CAPE VERDI ISLANDS',
    'CAYMAN ISLANDS' 	=> 'CAYMAN ISLANDS',
    'CHAD' 	=> 'CHAD',
    'CHANNEL ISLAND UK' 	=> 'CHANNEL ISLAND UK',
    'CHILE' 	=> 'CHILE',
    'CHINA' 	=> 'CHINA',
    'CHRISTMAS ISLAND' 	=> 'CHRISTMAS ISLAND',
    'COCOS (KEELING) ISLAND' 	=> 'COCOS (KEELING) ISLAND',
    'COLOMBIA' 	=> 'COLOMBIA',
    'COMORO ISLANDS' 	=> 'COMORO ISLANDS',
    'CONGO' 	=> 'CONGO',
    'CONGO KINSHASA' 	=> 'CONGO KINSHASA',
    'COOK ISLANDS' 	=> 'COOK ISLANDS',
    'COSTA RICA' 	=> 'COSTA RICA',
    'CROATIA' 	=> 'CROATIA',
    'CUBA' 	=> 'CUBA',
    'CURACAO' 	=> 'CURACAO',
    'CYPRUS' 	=> 'CYPRUS',
    'CZECH REPUBLIC' 	=> 'CZECH REPUBLIC',
    'DAHOMEY' 	=> 'DAHOMEY',
    'DENMARK' 	=> 'DENMARK',
    'DJIBOUTI' 	=> 'DJIBOUTI',
    'DOMINICA' 	=> 'DOMINICA',
    'DOMINICAN REPUBLIC' 	=> 'DOMINICAN REPUBLIC',
    'DUBAI' 	=> 'DUBAI',
    'ECUADOR' 	=> 'ECUADOR',
    'EGYPT' 	=> 'EGYPT',
    'EL SALVADOR' 	=> 'EL SALVADOR',
    'EQUATORIAL GUINEA' 	=> 'EQUATORIAL GUINEA',
    'ESTONIA' 	=> 'ESTONIA',
    'ETHIOPIA' 	=> 'ETHIOPIA',
    'FAEROE ISLANDS' 	=> 'FAEROE ISLANDS',
    'FALKLAND ISLANDS' 	=> 'FALKLAND ISLANDS',
    'FIJI' 	=> 'FIJI',
    'FINLAND' 	=> 'FINLAND',
    'FRANCE' 	=> 'FRANCE',
    'FRENCH GUIANA' 	=> 'FRENCH GUIANA',
    'FRENCH POLYNESIA' 	=> 'FRENCH POLYNESIA',
    'GABON' 	=> 'GABON',
    'GAMBIA' 	=> 'GAMBIA',
    'GEORGIA' 	=> 'GEORGIA',
    'GERMANY' 	=> 'GERMANY',
    'GHANA' 	=> 'GHANA',
    'GIBRALTAR' 	=> 'GIBRALTAR',
    'GREECE' 	=> 'GREECE',
    'GREENLAND' 	=> 'GREENLAND',
    'GUADELOUPE' 	=> 'GUADELOUPE',
    'GUAM' 	=> 'GUAM',
    'GUATEMALA' 	=> 'GUATEMALA',
    'GUINEA' 	=> 'GUINEA',
    'GUYANA' 	=> 'GUYANA',
    'HAITI' 	=> 'HAITI',
    'HONDURAS' 	=> 'HONDURAS',
    'HONG KONG' 	=> 'HONG KONG',
    'HUNGARY' 	=> 'HUNGARY',
    'ICELAND' 	=> 'ICELAND',
    'IFNI' 	=> 'IFNI',
    'INDIA' 	=> 'INDIA',
    'INDONESIA' 	=> 'INDONESIA',
    'IRAN' 	=> 'IRAN',
    'IRAQ' 	=> 'IRAQ',
    'IRELAND' 	=> 'IRELAND',
    'ISRAEL' 	=> 'ISRAEL',
    'ITALY' 	=> 'ITALY',
    'IVORY COAST' 	=> 'IVORY COAST',
    'JAMAICA' 	=> 'JAMAICA',
    'JAPAN' 	=> 'JAPAN',
    'JORDAN' 	=> 'JORDAN',
    'KAZAKHSTAN' 	=> 'KAZAKHSTAN',
    'KENYA' 	=> 'KENYA',
    'KOREA' 	=> 'KOREA',
    'KOREA, SOUTH' 	=> 'KOREA, SOUTH',
    'KUWAIT' 	=> 'KUWAIT',
    'KYRGYZSTAN' 	=> 'KYRGYZSTAN',
    'LAOS' 	=> 'LAOS',
    'LATVIA' 	=> 'LATVIA',
    'LEBANON' 	=> 'LEBANON',
    'LEEWARD ISLANDS' 	=> 'LEEWARD ISLANDS',
    'LESOTHO' 	=> 'LESOTHO',
    'LIBYA' 	=> 'LIBYA',
    'LIECHTENSTEIN' 	=> 'LIECHTENSTEIN',
    'LITHUANIA' 	=> 'LITHUANIA',
    'LUXEMBOURG' 	=> 'LUXEMBOURG',
    'MACAO' 	=> 'MACAO',
    'MACEDONIA' 	=> 'MACEDONIA',
    'MADAGASCAR' 	=> 'MADAGASCAR',
    'MALAWI' 	=> 'MALAWI',
    'MALAYSIA' 	=> 'MALAYSIA',
    'MALDIVES' 	=> 'MALDIVES',
    'MALI' 	=> 'MALI',
    'MALTA' 	=> 'MALTA',
    'MARTINIQUE' 	=> 'MARTINIQUE',
    'MAURITANIA' 	=> 'MAURITANIA',
    'MAURITIUS' 	=> 'MAURITIUS',
    'MELANESIA' 	=> 'MELANESIA',
    'MEXICO' 	=> 'MEXICO',
    'MOLDOVIA' 	=> 'MOLDOVIA',
    'MONACO' 	=> 'MONACO',
    'MONGOLIA' 	=> 'MONGOLIA',
    'MOROCCO' 	=> 'MOROCCO',
    'MOZAMBIQUE' 	=> 'MOZAMBIQUE',
    'MYANAMAR' 	=> 'MYANAMAR',
    'NAMIBIA' 	=> 'NAMIBIA',
    'NEPAL' 	=> 'NEPAL',
    'NETHERLANDS' 	=> 'NETHERLANDS',
    'NETHERLANDS ANTILLES' 	=> 'NETHERLANDS ANTILLES',
    'NETHERLANDS ANTILLES NEUTRAL ZONE' 	=> 'NETHERLANDS ANTILLES NEUTRAL ZONE',
    'NEW CALADONIA' 	=> 'NEW CALADONIA',
    'NEW HEBRIDES' 	=> 'NEW HEBRIDES',
    'NEW ZEALAND' 	=> 'NEW ZEALAND',
    'NICARAGUA' 	=> 'NICARAGUA',
    'NIGER' 	=> 'NIGER',
    'NIGERIA' 	=> 'NIGERIA',
    'NORFOLK ISLAND' 	=> 'NORFOLK ISLAND',
    'NORWAY' 	=> 'NORWAY',
    'OMAN' 	=> 'OMAN',
    'OTHER' 	=> 'OTHER',
    'PACIFIC ISLAND' 	=> 'PACIFIC ISLAND',
    'PAKISTAN' 	=> 'PAKISTAN',
    'PANAMA' 	=> 'PANAMA',
    'PAPUA NEW GUINEA' 	=> 'PAPUA NEW GUINEA',
    'PARAGUAY' 	=> 'PARAGUAY',
    'PERU' 	=> 'PERU',
    'PHILIPPINES' 	=> 'PHILIPPINES',
    'POLAND' 	=> 'POLAND',
    'PORTUGAL' 	=> 'PORTUGAL',
    'PORTUGUESE TIMOR' 	=> 'EAST TIMOR',
    'PUERTO RICO' 	=> 'PUERTO RICO',
    'QATAR' 	=> 'QATAR',
    'REPUBLIC OF BELARUS' 	=> 'REPUBLIC OF BELARUS',
    'REPUBLIC OF SOUTH AFRICA' 	=> 'REPUBLIC OF SOUTH AFRICA',
    'REUNION' 	=> 'REUNION',
    'ROMANIA' 	=> 'ROMANIA',
    'RUSSIA' 	=> 'RUSSIA',
    'RWANDA' 	=> 'RWANDA',
    'RYUKYU ISLANDS' 	=> 'RYUKYU ISLANDS',
    'SABAH' 	=> 'SABAH',
    'SAN MARINO' 	=> 'SAN MARINO',
    'SAUDI ARABIA' 	=> 'SAUDI ARABIA',
    'SENEGAL' 	=> 'SENEGAL',
    'SERBIA' 	=> 'SERBIA',
    'SEYCHELLES' 	=> 'SEYCHELLES',
    'SIERRA LEONE' 	=> 'SIERRA LEONE',
    'SINGAPORE' 	=> 'SINGAPORE',
    'SLOVAKIA' 	=> 'SLOVAKIA',
    'SLOVENIA' 	=> 'SLOVENIA',
    'SOMALILIAND' 	=> 'SOMALILIAND',
    'SOUTH AFRICA' 	=> 'SOUTH AFRICA',
    'SOUTH YEMEN' 	=> 'SOUTH YEMEN',
    'SPAIN' 	=> 'SPAIN',
    'SPANISH SAHARA' 	=> 'SPANISH SAHARA',
    'SRI LANKA' 	=> 'SRI LANKA',
    'ST. KITTS AND NEVIS' 	=> 'ST. KITTS AND NEVIS',
    'ST. LUCIA' 	=> 'ST. LUCIA',
    'SUDAN' 	=> 'SUDAN',
    'SURINAM' 	=> 'SURINAM',
    'SW AFRICA' 	=> 'SW AFRICA',
    'SWAZILAND' 	=> 'SWAZILAND',
    'SWEDEN' 	=> 'SWEDEN',
    'SWITZERLAND' 	=> 'SWITZERLAND',
    'SYRIA' 	=> 'SYRIA',
    'TAIWAN' 	=> 'TAIWAN',
    'TAJIKISTAN' 	=> 'TAJIKISTAN',
    'TANZANIA' 	=> 'TANZANIA',
    'THAILAND' 	=> 'THAILAND',
    'TONGA' 	=> 'TONGA',
    'TRINIDAD' 	=> 'TRINIDAD',
    'TUNISIA' 	=> 'TUNISIA',
    'TURKEY' 	=> 'TURKEY',
    'UGANDA' 	=> 'UGANDA',
    'UKRAINE' 	=> 'UKRAINE',
    'UNITED ARAB EMIRATES' 	=> 'UNITED ARAB EMIRATES',
    'UNITED KINGDOM' 	=> 'UNITED KINGDOM',
    'URUGUAY' 	=> 'URUGUAY',
    'US PACIFIC ISLAND' 	=> 'US PACIFIC ISLAND',
    'US VIRGIN ISLANDS' 	=> 'US VIRGIN ISLANDS',
    'USA' 	=> 'USA',
    'UZBEKISTAN' 	=> 'UZBEKISTAN',
    'VANUATU' 	=> 'VANUATU',
    'VATICAN CITY' 	=> 'VATICAN CITY',
    'VENEZUELA' 	=> 'VENEZUELA',
    'VIETNAM' 	=> 'VIETNAM',
    'WAKE ISLAND' 	=> 'WAKE ISLAND',
    'WEST INDIES' 	=> 'WEST INDIES',
    'WESTERN SAHARA' 	=> 'WESTERN SAHARA',
    'YEMEN' 	=> 'YEMEN',
    'ZAIRE' 	=> 'ZAIRE',
    'ZAMBIA' 	=> 'ZAMBIA',
    'ZIMBABWE' 	=> 'ZIMBABWE',
);	

$app_list_strings['charset_dom']  array(
    'BIG-5' 	=> 'BIG-5 (Taiwan and Hong Kong)',
    /*'CP866'     	=> 'CP866', // ms-dos Cyrillic */
    /*'CP949'     	=> 'CP949 (Microsoft Korean)', */
    'CP1251' 	=> 'CP1251 (MS Cyrillic)',
    'CP1252' 	=> 'CP1252 (MS Western European & US)',
    'EUC-CN' 	=> 'EUC-CN (Simplified Chinese GB2312)',
    'EUC-JP' 	=> 'EUC-JP (Unix Japanese)',
    'EUC-KR' 	=> 'EUC-KR (Korean)',
    'EUC-TW' 	=> 'EUC-TW (Taiwanese)',
    'ISO-2022-JP' 	=> 'ISO-2022-JP (Japanese)',
    'ISO-2022-KR' 	=> 'ISO-2022-KR (Korean)',
    'ISO-8859-1' 	=> 'ISO-8859-1 (Western European and US)',
    'ISO-8859-2' 	=> 'ISO-8859-2 (Central and Eastern European)',
    'ISO-8859-3' 	=> 'ISO-8859-3 (Latin 3)',
    'ISO-8859-4' 	=> 'ISO-8859-4 (Latin 4)',
    'ISO-8859-5' 	=> 'ISO-8859-5 (Cyrillic)',
    'ISO-8859-6' 	=> 'ISO-8859-6 (Arabic)',
    'ISO-8859-7' 	=> 'ISO-8859-7 (Greek)',
    'ISO-8859-8' 	=> 'ISO-8859-8 (Hebrew)',
    'ISO-8859-9' 	=> 'ISO-8859-9 (Latin 5)',
    'ISO-8859-10' 	=> 'ISO-8859-10 (Latin 6)',
    'ISO-8859-13' 	=> 'ISO-8859-13 (Latin 7)',
    'ISO-8859-14' 	=> 'ISO-8859-14 (Latin 8)',
    'ISO-8859-15' 	=> 'ISO-8859-15 (Latin 9)',
    'KOI8-R' 	=> 'KOI8-R (Cyrillic Russian)',
    'KOI8-U' 	=> 'KOI8-U (Cyrillic Ukranian)',
    'SJIS' 	=> 'SJIS (MS Japanese)',
    'UTF-8' 	=> 'UTF-8',
);	

$app_list_strings['timezone_dom']  array(

    'Africa/Algiers' 	=> 'Africa/Algiers',
    'Africa/Luanda' 	=> 'Africa/Luanda',
    'Africa/Porto-Novo' 	=> 'Africa/Porto-Novo',
    'Africa/Gaborone' 	=> 'Africa/Gaborone',
    'Africa/Ouagadougou' 	=> 'Africa/Ouagadougou',
    'Africa/Bujumbura' 	=> 'Africa/Bujumbura',
    'Africa/Douala' 	=> 'Africa/Douala',
    'Atlantic/Cape_Verde' 	=> 'Atlantic/Cape Verde',
    'Africa/Bangui' 	=> 'Africa/Bangui',
    'Africa/Ndjamena' 	=> 'Africa/Ndjamena',
    'Indian/Comoro' 	=> 'Indian/Comoro',
    'Africa/Kinshasa' 	=> 'Africa/Kinshasa',
    'Africa/Lubumbashi' 	=> 'Africa/Lubumbashi',
    'Africa/Brazzaville' 	=> 'Africa/Brazzaville',
    'Africa/Abidjan' 	=> 'Africa/Abidjan',
    'Africa/Djibouti' 	=> 'Africa/Djibouti',
    'Africa/Cairo' 	=> 'Africa/Cairo',
    'Africa/Malabo' 	=> 'Africa/Malabo',
    'Africa/Asmera' 	=> 'Africa/Asmera',
    'Africa/Addis_Ababa' 	=> 'Africa/Addis Ababa',
    'Africa/Libreville' 	=> 'Africa/Libreville',
    'Africa/Banjul' 	=> 'Africa/Banjul',
    'Africa/Accra' 	=> 'Africa/Accra',
    'Africa/Conakry' 	=> 'Africa/Conakry',
    'Africa/Bissau' 	=> 'Africa/Bissau',
    'Africa/Nairobi' 	=> 'Africa/Nairobi',
    'Africa/Maseru' 	=> 'Africa/Maseru',
    'Africa/Monrovia' 	=> 'Africa/Monrovia',
    'Africa/Tripoli' 	=> 'Africa/Tripoli',
    'Indian/Antananarivo' 	=> 'Indian/Antananarivo',
    'Africa/Blantyre' 	=> 'Africa/Blantyre',
    'Africa/Bamako' 	=> 'Africa/Bamako',
    'Africa/Nouakchott' 	=> 'Africa/Nouakchott',
    'Indian/Mauritius' 	=> 'Indian/Mauritius',
    'Indian/Mayotte' 	=> 'Indian/Mayotte',
    'Africa/Casablanca' 	=> 'Africa/Casablanca',
    'Africa/El_Aaiun' 	=> 'Africa/El Aaiun',
    'Africa/Maputo' 	=> 'Africa/Maputo',
    'Africa/Windhoek' 	=> 'Africa/Windhoek',
    'Africa/Niamey' 	=> 'Africa/Niamey',
    'Africa/Lagos' 	=> 'Africa/Lagos',
    'Indian/Reunion' 	=> 'Indian/Reunion',
    'Africa/Kigali' 	=> 'Africa/Kigali',
    'Atlantic/St_Helena' 	=> 'Atlantic/St. Helena',
    'Africa/Sao_Tome' 	=> 'Africa/Sao Tome',
    'Africa/Dakar' 	=> 'Africa/Dakar',
    'Indian/Mahe' 	=> 'Indian/Mahe',
    'Africa/Freetown' 	=> 'Africa/Freetown',
    'Africa/Mogadishu' 	=> 'Africa/Mogadishu',
    'Africa/Johannesburg' 	=> 'Africa/Johannesburg',
    'Africa/Khartoum' 	=> 'Africa/Khartoum',
    'Africa/Mbabane' 	=> 'Africa/Mbabane',
    'Africa/Dar_es_Salaam' 	=> 'Africa/Dar es Salaam',
    'Africa/Lome' 	=> 'Africa/Lome',
    'Africa/Tunis' 	=> 'Africa/Tunis',
    'Africa/Kampala' 	=> 'Africa/Kampala',
    'Africa/Lusaka' 	=> 'Africa/Lusaka',
    'Africa/Harare' 	=> 'Africa/Harare',
    'Antarctica/Casey' 	=> 'Antarctica/Casey',
    'Antarctica/Davis' 	=> 'Antarctica/Davis',
    'Antarctica/Mawson' 	=> 'Antarctica/Mawson',
    'Indian/Kerguelen' 	=> 'Indian/Kerguelen',
    'Antarctica/DumontDUrville' 	=> 'Antarctica/DumontDUrville',
    'Antarctica/Syowa' 	=> 'Antarctica/Syowa',
    'Antarctica/Vostok' 	=> 'Antarctica/Vostok',
    'Antarctica/Rothera' 	=> 'Antarctica/Rothera',
    'Antarctica/Palmer' 	=> 'Antarctica/Palmer',
    'Antarctica/McMurdo' 	=> 'Antarctica/McMurdo',
    'Asia/Kabul' 	=> 'Asia/Kabul',
    'Asia/Yerevan' 	=> 'Asia/Yerevan',
    'Asia/Baku' 	=> 'Asia/Baku',
    'Asia/Bahrain' 	=> 'Asia/Bahrain',
    'Asia/Dhaka' 	=> 'Asia/Dhaka',
    'Asia/Thimphu' 	=> 'Asia/Thimphu',
    'Indian/Chagos' 	=> 'Indian/Chagos',
    'Asia/Brunei' 	=> 'Asia/Brunei',
    'Asia/Rangoon' 	=> 'Asia/Rangoon',
    'Asia/Phnom_Penh' 	=> 'Asia/Phnom Penh',
    'Asia/Beijing' 	=> 'Asia/Beijing',
    'Asia/Harbin' 	=> 'Asia/Harbin',
    'Asia/Shanghai' 	=> 'Asia/Shanghai',
    'Asia/Chongqing' 	=> 'Asia/Chongqing',
    'Asia/Urumqi' 	=> 'Asia/Urumqi',
    'Asia/Kashgar' 	=> 'Asia/Kashgar',
    'Asia/Hong_Kong' 	=> 'Asia/Hong Kong',
    'Asia/Taipei' 	=> 'Asia/Taipei',
    'Asia/Macau' 	=> 'Asia/Macau',
    'Asia/Nicosia' 	=> 'Asia/Nicosia',
    'Asia/Tbilisi' 	=> 'Asia/Tbilisi',
    'Asia/Dili' 	=> 'Asia/Dili',
    'Asia/Calcutta' 	=> 'Asia/Calcutta',
    'Asia/Jakarta' 	=> 'Asia/Jakarta',
    'Asia/Pontianak' 	=> 'Asia/Pontianak',
    'Asia/Makassar' 	=> 'Asia/Makassar',
    'Asia/Jayapura' 	=> 'Asia/Jayapura',
    'Asia/Tehran' 	=> 'Asia/Tehran',
    'Asia/Baghdad' 	=> 'Asia/Baghdad',
    'Asia/Jerusalem' 	=> 'Asia/Jerusalem',
    'Asia/Tokyo' 	=> 'Asia/Tokyo',
    'Asia/Amman' 	=> 'Asia/Amman',
    'Asia/Almaty' 	=> 'Asia/Almaty',
    'Asia/Qyzylorda' 	=> 'Asia/Qyzylorda',
    'Asia/Aqtobe' 	=> 'Asia/Aqtobe',
    'Asia/Aqtau' 	=> 'Asia/Aqtau',
    'Asia/Oral' 	=> 'Asia/Oral',
    'Asia/Bishkek' 	=> 'Asia/Bishkek',
    'Asia/Seoul' 	=> 'Asia/Seoul',
    'Asia/Pyongyang' 	=> 'Asia/Pyongyang',
    'Asia/Kuwait' 	=> 'Asia/Kuwait',
    'Asia/Vientiane' 	=> 'Asia/Vientiane',
    'Asia/Beirut' 	=> 'Asia/Beirut',
    'Asia/Kuala_Lumpur' 	=> 'Asia/Kuala Lumpur',
    'Asia/Kuching' 	=> 'Asia/Kuching',
    'Indian/Maldives' 	=> 'Indian/Maldives',
    'Asia/Hovd' 	=> 'Asia/Hovd',
    'Asia/Ulaanbaatar' 	=> 'Asia/Ulaanbaatar',
    'Asia/Choibalsan' 	=> 'Asia/Choibalsan',
    'Asia/Katmandu' 	=> 'Asia/Katmandu',
    'Asia/Muscat' 	=> 'Asia/Muscat',
    'Asia/Karachi' 	=> 'Asia/Karachi',
    'Asia/Gaza' 	=> 'Asia/Gaza',
    'Asia/Manila' 	=> 'Asia/Manila',
    'Asia/Qatar' 	=> 'Asia/Qatar',
    'Asia/Riyadh' 	=> 'Asia/Riyadh',
    'Asia/Singapore' 	=> 'Asia/Singapore',
    'Asia/Colombo' 	=> 'Asia/Colombo',
    'Asia/Damascus' 	=> 'Asia/Damascus',
    'Asia/Dushanbe' 	=> 'Asia/Dushanbe',
    'Asia/Bangkok' 	=> 'Asia/Bangkok',
    'Asia/Ashgabat' 	=> 'Asia/Ashgabat',
    'Asia/Dubai' 	=> 'Asia/Dubai',
    'Asia/Samarkand' 	=> 'Asia/Samarkand',
    'Asia/Tashkent' 	=> 'Asia/Tashkent',
    'Asia/Saigon' 	=> 'Asia/Saigon',
    'Asia/Aden' 	=> 'Asia/Aden',
    'Australia/Darwin' 	=> 'Australia/Darwin',
    'Australia/Perth' 	=> 'Australia/Perth',
    'Australia/Brisbane' 	=> 'Australia/Brisbane',
    'Australia/Lindeman' 	=> 'Australia/Lindeman',
    'Australia/Adelaide' 	=> 'Australia/Adelaide',
    'Australia/Hobart' 	=> 'Australia/Hobart',
    'Australia/Currie' 	=> 'Australia/Currie',
    'Australia/Melbourne' 	=> 'Australia/Melbourne',
    'Australia/Sydney' 	=> 'Australia/Sydney',
    'Australia/Broken_Hill' 	=> 'Australia/Broken Hill',
    'Indian/Christmas' 	=> 'Indian/Christmas',
    'Pacific/Rarotonga' 	=> 'Pacific/Rarotonga',
    'Indian/Cocos' 	=> 'Indian/Cocos',
    'Pacific/Fiji' 	=> 'Pacific/Fiji',
    'Pacific/Gambier' 	=> 'Pacific/Gambier',
    'Pacific/Marquesas' 	=> 'Pacific/Marquesas',
    'Pacific/Tahiti' 	=> 'Pacific/Tahiti',
    'Pacific/Guam' 	=> 'Pacific/Guam',
    'Pacific/Tarawa' 	=> 'Pacific/Tarawa',
    'Pacific/Enderbury' 	=> 'Pacific/Enderbury',
    'Pacific/Kiritimati' 	=> 'Pacific/Kiritimati',
    'Pacific/Saipan' 	=> 'Pacific/Saipan',
    'Pacific/Majuro' 	=> 'Pacific/Majuro',
    'Pacific/Kwajalein' 	=> 'Pacific/Kwajalein',
    'Pacific/Truk' 	=> 'Pacific/Truk',
    'Pacific/Pohnpei' 	=> 'Pacific/Pohnpei',
    'Pacific/Kosrae' 	=> 'Pacific/Kosrae',
    'Pacific/Nauru' 	=> 'Pacific/Nauru',
    'Pacific/Noumea' 	=> 'Pacific/Noumea',
    'Pacific/Auckland' 	=> 'Pacific/Auckland',
    'Pacific/Chatham' 	=> 'Pacific/Chatham',
    'Pacific/Niue' 	=> 'Pacific/Niue',
    'Pacific/Norfolk' 	=> 'Pacific/Norfolk',
    'Pacific/Palau' 	=> 'Pacific/Palau',
    'Pacific/Port_Moresby' 	=> 'Pacific/Port Moresby',
    'Pacific/Pitcairn' 	=> 'Pacific/Pitcairn',
    'Pacific/Pago_Pago' 	=> 'Pacific/Pago Pago',
    'Pacific/Apia' 	=> 'Pacific/Apia',
    'Pacific/Guadalcanal' 	=> 'Pacific/Guadalcanal',
    'Pacific/Fakaofo' 	=> 'Pacific/Fakaofo',
    'Pacific/Tongatapu' 	=> 'Pacific/Tongatapu',
    'Pacific/Funafuti' 	=> 'Pacific/Funafuti',
    'Pacific/Johnston' 	=> 'Pacific/Johnston',
    'Pacific/Midway' 	=> 'Pacific/Midway',
    'Pacific/Wake' 	=> 'Pacific/Wake',
    'Pacific/Efate' 	=> 'Pacific/Efate',
    'Pacific/Wallis' 	=> 'Pacific/Wallis',
    'Europe/London' 	=> 'Europe/London',
    'Europe/Dublin' 	=> 'Europe/Dublin',
    'WET' 	=> 'WET',
    'CET' 	=> 'CET',
    'MET' 	=> 'MET',
    'EET' 	=> 'EET',
    'Europe/Tirane' 	=> 'Europe/Tirane',
    'Europe/Andorra' 	=> 'Europe/Andorra',
    'Europe/Vienna' 	=> 'Europe/Vienna',
    'Europe/Minsk' 	=> 'Europe/Minsk',
    'Europe/Brussels' 	=> 'Europe/Brussels',
    'Europe/Sofia' 	=> 'Europe/Sofia',
    'Europe/Prague' 	=> 'Europe/Prague',
    'Europe/Copenhagen' 	=> 'Europe/Copenhagen',
    'Atlantic/Faeroe' 	=> 'Atlantic/Faeroe',
    'America/Danmarkshavn' 	=> 'America/Danmarkshavn',
    'America/Scoresbysund' 	=> 'America/Scoresbysund',
    'America/Godthab' 	=> 'America/Godthab',
    'America/Thule' 	=> 'America/Thule',
    'Europe/Tallinn' 	=> 'Europe/Tallinn',
    'Europe/Helsinki' 	=> 'Europe/Helsinki',
    'Europe/Paris' 	=> 'Europe/Paris',
    'Europe/Berlin' 	=> 'Europe/Berlin',
    'Europe/Gibraltar' 	=> 'Europe/Gibraltar',
    'Europe/Athens' 	=> 'Europe/Athens',
    'Europe/Budapest' 	=> 'Europe/Budapest',
    'Atlantic/Reykjavik' 	=> 'Atlantic/Reykjavik',
    'Europe/Rome' 	=> 'Europe/Rome',
    'Europe/Riga' 	=> 'Europe/Riga',
    'Europe/Vaduz' 	=> 'Europe/Vaduz',
    'Europe/Vilnius' 	=> 'Europe/Vilnius',
    'Europe/Luxembourg' 	=> 'Europe/Luxembourg',
    'Europe/Malta' 	=> 'Europe/Malta',
    'Europe/Chisinau' 	=> 'Europe/Chisinau',
    'Europe/Monaco' 	=> 'Europe/Monaco',
    'Europe/Amsterdam' 	=> 'Europe/Amsterdam',
    'Europe/Oslo' 	=> 'Europe/Oslo',
    'Europe/Warsaw' 	=> 'Europe/Warsaw',
    'Europe/Lisbon' 	=> 'Europe/Lisbon',
    'Atlantic/Azores' 	=> 'Atlantic/Azores',
    'Atlantic/Madeira' 	=> 'Atlantic/Madeira',
    'Europe/Bucharest' 	=> 'Europe/Bucharest',
    'Europe/Kaliningrad' 	=> 'Europe/Kaliningrad',
    'Europe/Moscow' 	=> 'Europe/Moscow',
    'Europe/Samara' 	=> 'Europe/Samara',
    'Asia/Yekaterinburg' 	=> 'Asia/Yekaterinburg',
    'Asia/Omsk' 	=> 'Asia/Omsk',
    'Asia/Novosibirsk' 	=> 'Asia/Novosibirsk',
    'Asia/Krasnoyarsk' 	=> 'Asia/Krasnoyarsk',
    'Asia/Irkutsk' 	=> 'Asia/Irkutsk',
    'Asia/Yakutsk' 	=> 'Asia/Yakutsk',
    'Asia/Vladivostok' 	=> 'Asia/Vladivostok',
    'Asia/Sakhalin' 	=> 'Asia/Sakhalin',
    'Asia/Magadan' 	=> 'Asia/Magadan',
    'Asia/Kamchatka' 	=> 'Asia/Kamchatka',
    'Asia/Anadyr' 	=> 'Asia/Anadyr',
    'Europe/Belgrade' 	=> 'Europe/Belgrade',
    'Europe/Madrid' 	=> 'Europe/Madrid',
    'Africa/Ceuta' 	=> 'Africa/Ceuta',
    'Atlantic/Canary' 	=> 'Atlantic/Canary',
    'Europe/Stockholm' 	=> 'Europe/Stockholm',
    'Europe/Zurich' 	=> 'Europe/Zurich',
    'Europe/Istanbul' 	=> 'Europe/Istanbul',
    'Europe/Kiev' 	=> 'Europe/Kiev',
    'Europe/Uzhgorod' 	=> 'Europe/Uzhgorod',
    'Europe/Zaporozhye' 	=> 'Europe/Zaporozhye',
    'Europe/Simferopol' 	=> 'Europe/Simferopol',
    'America/New_York' 	=> 'America/New York',
    'America/Chicago' 	=> 'America/Chicago',
    'America/North_Dakota/Center' 	=> 'America/North Dakota/Center',
    'America/Denver' 	=> 'America/Denver',
    'America/Los_Angeles' 	=> 'America/Los Angeles',
    'America/Juneau' 	=> 'America/Juneau',
    'America/Yakutat' 	=> 'America/Yakutat',
    'America/Anchorage' 	=> 'America/Anchorage',
    'America/Nome' 	=> 'America/Nome',
    'America/Adak' 	=> 'America/Adak',
    'Pacific/Honolulu' 	=> 'Pacific/Honolulu',
    'America/Phoenix' 	=> 'America/Phoenix',
    'America/Boise' 	=> 'America/Boise',
    'America/Indiana/Indianapolis' 	=> 'America/Indiana/Indianapolis',
    'America/Indiana/Marengo' 	=> 'America/Indiana/Marengo',
    'America/Indiana/Knox' 	=> 'America/Indiana/Knox',
    'America/Indiana/Vevay' 	=> 'America/Indiana/Vevay',
    'America/Kentucky/Louisville' 	=> 'America/Kentucky/Louisville',
    'America/Kentucky/Monticello' 	=> 'America/Kentucky/Monticello',
    'America/Detroit' 	=> 'America/Detroit',
    'America/Menominee' 	=> 'America/Menominee',
    'America/St_Johns' 	=> 'America/St. Johns',
    'America/Goose_Bay' 	=> 'America/Goose_Bay',
    'America/Halifax' 	=> 'America/Halifax',
    'America/Glace_Bay' 	=> 'America/Glace Bay',
    'America/Montreal' 	=> 'America/Montreal',
    'America/Toronto' 	=> 'America/Toronto',
    'America/Thunder_Bay' 	=> 'America/Thunder Bay',
    'America/Nipigon' 	=> 'America/Nipigon',
    'America/Rainy_River' 	=> 'America/Rainy River',
    'America/Winnipeg' 	=> 'America/Winnipeg',
    'America/Regina' 	=> 'America/Regina',
    'America/Swift_Current' 	=> 'America/Swift Current',
    'America/Edmonton' 	=> 'America/Edmonton',
    'America/Vancouver' 	=> 'America/Vancouver',
    'America/Dawson_Creek' 	=> 'America/Dawson Creek',
    'America/Pangnirtung' 	=> 'America/Pangnirtung',
    'America/Iqaluit' 	=> 'America/Iqaluit',
    'America/Coral_Harbour' 	=> 'America/Coral Harbour',
    'America/Rankin_Inlet' 	=> 'America/Rankin Inlet',
    'America/Cambridge_Bay' 	=> 'America/Cambridge Bay',
    'America/Yellowknife' 	=> 'America/Yellowknife',
    'America/Inuvik' 	=> 'America/Inuvik',
    'America/Whitehorse' 	=> 'America/Whitehorse',
    'America/Dawson' 	=> 'America/Dawson',
    'America/Cancun' 	=> 'America/Cancun',
    'America/Merida' 	=> 'America/Merida',
    'America/Monterrey' 	=> 'America/Monterrey',
    'America/Mexico_City' 	=> 'America/Mexico City',
    'America/Chihuahua' 	=> 'America/Chihuahua',
    'America/Hermosillo' 	=> 'America/Hermosillo',
    'America/Mazatlan' 	=> 'America/Mazatlan',
    'America/Tijuana' 	=> 'America/Tijuana',
    'America/Anguilla' 	=> 'America/Anguilla',
    'America/Antigua' 	=> 'America/Antigua',
    'America/Nassau' 	=> 'America/Nassau',
    'America/Barbados' 	=> 'America/Barbados',
    'America/Belize' 	=> 'America/Belize',
    'Atlantic/Bermuda' 	=> 'Atlantic/Bermuda',
    'America/Cayman' 	=> 'America/Cayman',
    'America/Costa_Rica' 	=> 'America/Costa Rica',
    'America/Havana' 	=> 'America/Havana',
    'America/Dominica' 	=> 'America/Dominica',
    'America/Santo_Domingo' 	=> 'America/Santo Domingo',
    'America/El_Salvador' 	=> 'America/El Salvador',
    'America/Grenada' 	=> 'America/Grenada',
    'America/Guadeloupe' 	=> 'America/Guadeloupe',
    'America/Guatemala' 	=> 'America/Guatemala',
    'America/Port-au-Prince' 	=> 'America/Port-au-Prince',
    'America/Tegucigalpa' 	=> 'America/Tegucigalpa',
    'America/Jamaica' 	=> 'America/Jamaica',
    'America/Martinique' 	=> 'America/Martinique',
    'America/Montserrat' 	=> 'America/Montserrat',
    'America/Managua' 	=> 'America/Managua',
    'America/Panama' 	=> 'America/Panama',
    'America/Puerto_Rico' 	=> 'America/Puerto_Rico',
    'America/St_Kitts' 	=> 'America/St_Kitts',
    'America/St_Lucia' 	=> 'America/St_Lucia',
    'America/Miquelon' 	=> 'America/Miquelon',
    'America/St_Vincent' 	=> 'America/St. Vincent',
    'America/Grand_Turk' 	=> 'America/Grand Turk',
    'America/Tortola' 	=> 'America/Tortola',
    'America/St_Thomas' 	=> 'America/St. Thomas',
    'America/Argentina/Buenos_Aires' 	=> 'America/Argentina/Buenos Aires',
    'America/Argentina/Cordoba' 	=> 'America/Argentina/Cordoba',
    'America/Argentina/Tucuman' 	=> 'America/Argentina/Tucuman',
    'America/Argentina/La_Rioja' 	=> 'America/Argentina/La_Rioja',
    'America/Argentina/San_Juan' 	=> 'America/Argentina/San_Juan',
    'America/Argentina/Jujuy' 	=> 'America/Argentina/Jujuy',
    'America/Argentina/Catamarca' 	=> 'America/Argentina/Catamarca',
    'America/Argentina/Mendoza' 	=> 'America/Argentina/Mendoza',
    'America/Argentina/Rio_Gallegos' 	=> 'America/Argentina/Rio Gallegos',
    'America/Argentina/Ushuaia' 	=> 'America/Argentina/Ushuaia',
    'America/Aruba' 	=> 'America/Aruba',
    'America/La_Paz' 	=> 'America/La Paz',
    'America/Noronha' 	=> 'America/Noronha',
    'America/Belem' 	=> 'America/Belem',
    'America/Fortaleza' 	=> 'America/Fortaleza',
    'America/Recife' 	=> 'America/Recife',
    'America/Araguaina' 	=> 'America/Araguaina',
    'America/Maceio' 	=> 'America/Maceio',
    'America/Bahia' 	=> 'America/Bahia',
    'America/Sao_Paulo' 	=> 'America/Sao Paulo',
    'America/Campo_Grande' 	=> 'America/Campo Grande',
    'America/Cuiaba' 	=> 'America/Cuiaba',
    'America/Porto_Velho' 	=> 'America/Porto_Velho',
    'America/Boa_Vista' 	=> 'America/Boa Vista',
    'America/Manaus' 	=> 'America/Manaus',
    'America/Eirunepe' 	=> 'America/Eirunepe',
    'America/Rio_Branco' 	=> 'America/Rio Branco',
    'America/Santiago' 	=> 'America/Santiago',
    'Pacific/Easter' 	=> 'Pacific/Easter',
    'America/Bogota' 	=> 'America/Bogota',
    'America/Curacao' 	=> 'America/Curacao',
    'America/Guayaquil' 	=> 'America/Guayaquil',
    'Pacific/Galapagos' 	=> 'Pacific/Galapagos',
    'Atlantic/Stanley' 	=> 'Atlantic/Stanley',
    'America/Cayenne' 	=> 'America/Cayenne',
    'America/Guyana' 	=> 'America/Guyana',
    'America/Asuncion' 	=> 'America/Asuncion',
    'America/Lima' 	=> 'America/Lima',
    'Atlantic/South_Georgia' 	=> 'Atlantic/South Georgia',
    'America/Paramaribo' 	=> 'America/Paramaribo',
    'America/Port_of_Spain' 	=> 'America/Port-of-Spain',
    'America/Montevideo' 	=> 'America/Montevideo',
    'America/Caracas' 	=> 'America/Caracas',
);	

$app_list_strings['eapm_list']  array(
    'Sugar' 	=> 'SuiteCRM',
    'WebEx' 	=> 'WebEx',
    'GoToMeeting' 	=> 'GoToMeeting',
    'IBMSmartCloud' 	=> 'IBM SmartCloud',
    'Google' 	=> 'Google',
    'Box' 	=> 'Box.net',
    'Facebook' 	=> 'Facebook',
    'Twitter' 	=> 'Twitter',
);	
$app_list_strings['eapm_list_import'] array(
    'Google' 	=> 'Google Kişileri'
);	
$app_list_strings['eapm_list_documents'] =array(
    'Google' 	=> 'Google Drive',
);	
$app_list_strings['token_status'] =array(
1	=> 'İstek',
2	=> 'Erişim',
3	=> 'Geçersiz'
);	

$app_list_strings ['emailTemplates_type_list'] =array(
    '' 	=> '',
    'campaign' 	=> 'Kampanya',
    'email' 	=> 'E-posta',
);	

$app_list_strings ['emailTemplates_type_list_campaigns'] =array(
    '' 	=> '',
    'campaign' 	=> 'Kampanya',
);	

$app_list_strings ['emailTemplates_type_list_no_workflow'] =array(
    '' 	=> '',
    'campaign' 	=> 'Kampanya',
    'email' 	=> 'E-posta',
    'system' 	=> 'Sistem',
);	

// knowledge base
$app_list_strings['moduleList']['AOK_KnowledgeBase'] ='Bilgi tabanı';
$app_list_strings['moduleList']['AOK_Knowledge_Base_Categories'] ='KB Kategorileri';
$app_list_strings['aok_status_list']['Draft'] ='Taslak';
$app_list_strings['aok_status_list']['Expired'] ='Süresi doldu';
$app_list_strings['aok_status_list']['In_Review'] ='İncelemede';
//$app_list_strings['aok_status_list']['Published'] ='Yayınlanan';
$app_list_strings['aok_status_list']['published_private'] ='Özel';
$app_list_strings['aok_status_list']['published_public'] ='Halka açık';

$app_list_strings['moduleList']['FP_events'] ='Olaylar';
$app_list_strings['moduleList']['FP_Event_Locations'] ='Mekanlar';

//events
$app_list_strings['fp_event_invite_status_dom']['Invited'] ='Davet';
$app_list_strings['fp_event_invite_status_dom']['Not Invited'] ='Davet edilmemiş';
$app_list_strings['fp_event_invite_status_dom']['Attended'] ='Katıldı';
$app_list_strings['fp_event_invite_status_dom']['Not Attended'] ='Katılmadı';
$app_list_strings['fp_event_status_dom']['Accepted'] ='Kabul edilmiş';
$app_list_strings['fp_event_status_dom']['Declined'] ='Reddedildi';
$app_list_strings['fp_event_status_dom']['No Response'] ='Cevap yok';

$app_strings['LBL_STATUS_EVENT'] ='Davetiye Durumu';
$app_strings['LBL_ACCEPT_STATUS'] ='Durumu Kabul Et';
$app_strings['LBL_LISTVIEW_OPTION_CURRENT'] ='Bu Sayfayı Seç';
$app_strings['LBL_LISTVIEW_OPTION_ENTIRE'] ='Hepsini seç';
$app_strings['LBL_LISTVIEW_NONE'] ='Hiçbirini seçme';

//aod
$app_list_strings['moduleList']['AOD_IndexEvent'] ='arrayn Olayı';
$app_list_strings['moduleList']['AOD_Index'] ='Endeks';

$app_list_strings['moduleList']['AOP_Case_Events'] ='Vaka Olayları';
$app_list_strings['moduleList']['AOP_Case_Updates'] ='Vaka Güncellemeleri';
$app_strings['LBL_AOP_EMAIL_REPLY_DELIMITER'] = '========== Lütfen bu satırın üstünde yanıt ver ==========';


//aop
$app_list_strings['case_state_default_key'] ='Açık';
$app_list_strings['case_state_dom'] 
    array(
        'Open' 	=> 'Açık',
        'Closed' 	=> 'Kapalı',
    );	
$app_list_strings['case_status_default_key'] ='Open_New';
$app_list_strings['case_status_dom'] 
    array(
        'Open_New' 	=> 'Yeni',
        'Open_Assigned' 	=> 'Atandı',
        'Closed_Closed' 	=> 'Kapalı',
        'Open_Pending Input' 	=> 'Beklemede Girdi',
        'Closed_Rejected' 	=> 'Reddedildi'
        'Closed_Duplicate' 	=> 'Çoğalt'
    );	
$app_list_strings['contact_portal_user_type_dom'] 
    array(
        'Single' 	=> 'Tek kullanıcı',
        'Account' 	=> 'Hesap kullanıcısı',
    );	
$app_list_strings['dom_email_distribution_for_auto_create'] =array(
    'AOPDefault' 	=> 'AOP Varsayılan Kullan',
    'singleUser' 	=> 'Tek Kullanıcı',
    'roundRobin' 	=> 'Yuvarlak Robin',
    'leastBusy' 	=> 'En Az Yoğun'
    'random' 	=> 'Rastgele',
);	

//aor
$app_list_strings['moduleList']['AOR_Reports'] ='Raporlar';
$app_list_strings['moduleList']['AOR_Conditions'] ='Rapor Şartları';
$app_list_strings['moduleList']['AOR_Charts'] ='Grafikleri Raporla';
$app_list_strings['moduleList']['AOR_Fields'] ='Rapor Alanları';
$app_list_strings['moduleList']['AOR_Scheduled_Reports'] ='Zamanlanmış Raporlar';
$app_list_strings['aor_operator_list']['Equal_To'] ='Eşittir';
$app_list_strings['aor_operator_list']['Not_Equal_To'] ='Eşit değil';
$app_list_strings['aor_operator_list']['Greater_Than'] ='Daha Büyük';
$app_list_strings['aor_operator_list']['Less_Than'] ='Daha az';
$app_list_strings['aor_operator_list']['Greater_Than_or_Equal_To'] ='Büyük veya Eşittir';
$app_list_strings['aor_operator_list']['Less_Than_or_Equal_To'] ='Daha Az veya Eşittir';
$app_list_strings['aor_operator_list']['Contains'] ='İçeren';
$app_list_strings['aor_operator_list']['Starts_With'] ='İle başlar';
$app_list_strings['aor_operator_list']['Ends_With'] ='Bitir';
$app_list_strings['aor_format_options'][''] ='';
$app_list_strings['aor_format_options']['Y-m-d'] ='Y, m-d';
$app_list_strings['aor_format_options']['Ymd'] ='Ymd';
$app_list_strings['aor_format_options']['Y-m'] ='Y, m';
$app_list_strings['aor_format_options']['d/m/Y'] ='G / A / Y';
$app_list_strings['aor_format_options']['Y'] ='Y';
$app_list_strings['aor_condition_operator_list']['And'] ='Ve';
$app_list_strings['aor_condition_operator_list']['OR'] ='VEYA';
$app_list_strings['aor_condition_type_list']['Value'] ='Değer';
$app_list_strings['aor_condition_type_list']['Field'] ='Alan';
$app_list_strings['aor_condition_type_list']['Date'] ='Tarih';
$app_list_strings['aor_condition_type_list']['Multi'] ='Biri';
$app_list_strings['aor_condition_type_list']['Period'] ='Dönem';
$app_list_strings['aor_condition_type_list']['CurrentUserID'] ='Şu anki kullanıcı';
$app_list_strings['aor_date_type_list'][''] ='';
$app_list_strings['aor_date_type_list']['minute'] ='Dakika';
$app_list_strings['aor_date_type_list']['hour'] ='Saatler';
$app_list_strings['aor_date_type_list']['day'] ='Gün';
$app_list_strings['aor_date_type_list']['week'] ='Haftalar';
$app_list_strings['aor_date_type_list']['month'] ='Ay';
$app_list_strings['aor_date_type_list']['business_hours'] ='İş saatleri';
$app_list_strings['aor_date_options']['now'] ='Şimdi';
$app_list_strings['aor_date_options']['field'] ='Bu alan';
$app_list_strings['aor_date_operator']['now'] ='';
$app_list_strings['aor_date_operator']['plus'] ='+';
$app_list_strings['aor_date_operator']['minus'] ='-';
$app_list_strings['aor_sort_operator'][''] ='';
$app_list_strings['aor_sort_operator']['ASC'] ='Artan';
$app_list_strings['aor_sort_operator']['DESC'] ='Azalan';
$app_list_strings['aor_function_list'][''] ='';
$app_list_strings['aor_function_list']['COUNT'] ='Sayısı';
$app_list_strings['aor_function_list']['MIN'] ='En az';
$app_list_strings['aor_function_list']['MAX'] ='Maksimum';
$app_list_strings['aor_function_list']['SUM'] ='Toplam';
$app_list_strings['aor_function_list']['AVG'] = 'Ortalama';
$app_list_strings['aor_total_options'][''] = '';
$app_list_strings['aor_total_options']['COUNT'] = 'Sayısı';
$app_list_strings['aor_total_options']['SUM'] = 'Toplam';
$app_list_strings['aor_total_options']['AVG'] = 'Ortalama';
$app_list_strings['aor_chart_types']['bar'] = 'Grafik çubuğu';
$app_list_strings['aor_chart_types']['line'] = 'Çizgi grafik';
$app_list_strings['aor_chart_types']['pie'] = 'Yuvarlak diyagram';
$app_list_strings['aor_chart_types']['radar'] = 'Radar grafiği';
$app_list_strings['aor_chart_types']['polar'] = 'Kutup haritası';
$app_list_strings['aor_chart_types']['stacked_bar'] = 'İstiflenmiş çubuk';
$app_list_strings['aor_chart_types']['grouped_bar'] = 'Gruplanmış çubuk';
$app_list_strings['aor_scheduled_report_schedule_types']['monthly'] = 'Aylık';
$app_list_strings['aor_scheduled_report_schedule_types']['weekly'] = 'Haftalık';
$app_list_strings['aor_scheduled_report_schedule_types']['daily'] = 'Günlük';
$app_list_strings['aor_scheduled_reports_status_dom']['active'] = 'Aktif';
$app_list_strings['aor_scheduled_reports_status_dom']['inactive'] = 'Etkin';
$app_list_strings['aor_email_type_list']['Email Address'] = 'E-posta';
$app_list_strings['aor_email_type_list']['Specify User'] = 'Kullanıcı';
$app_list_strings['aor_email_type_list']['Users'] = 'Kullanıcılar';
$app_list_strings['aor_assign_options']['all'] = 'Tüm kullanıcılar';
$app_list_strings['aor_assign_options']['role'] = 'Roldeki TÜM Kullanıcılar';
$app_list_strings['aor_assign_options']['security_group'] = 'Güvenlik Grubundaki TÜM Kullanıcılar';
$app_list_strings['date_time_period_list']['today'] = 'Bugün';
$app_list_strings['date_time_period_list']['yesterday'] = 'Dün';
$app_list_strings['date_time_period_list']['this_week'] = 'Bu hafta';
$app_list_strings['date_time_period_list']['last_week'] = 'Geçen hafta';
$app_list_strings['date_time_period_list']['last_month'] = 'Geçen ay';
$app_list_strings['date_time_period_list']['this_month'] = 'Bu ay';
$app_list_strings['date_time_period_list']['this_quarter'] = 'Bu çeyrek';
$app_list_strings['date_time_period_list']['last_quarter'] = 'Son çeyrek';
$app_list_strings['date_time_period_list']['this_year'] = 'Bu yıl';
$app_list_strings['date_time_period_list']['last_year'] = 'Geçen yıl';
$app_strings['LBL_CRON_ON_THE_MONTHDAY'] = 'üzerinde';
$app_strings['LBL_CRON_ON_THE_WEEKDAY'] = 'Açık';
$app_strings['LBL_CRON_AT'] = 'De';
$app_strings['LBL_CRON_RAW'] = 'İleri';
$app_strings['LBL_CRON_MIN'] = 'Minimum';
$app_strings['LBL_CRON_HOUR'] = 'Saat';
$app_strings['LBL_CRON_DAY'] = 'Gün';
$app_strings['LBL_CRON_MONTH'] = 'Ay';
$app_strings['LBL_CRON_DOW'] = 'DOW';
$app_strings['LBL_CRON_DAILY'] = 'Günlük';
$app_strings['LBL_CRON_WEEKLY'] = 'Haftalık';
$app_strings['LBL_CRON_MONTHLY'] = 'Aylık';

//aos
$app_list_strings['moduleList']['AOS_Contracts'] ='Sözleşmeler';
$app_list_strings['moduleList']['AOS_Invoices'] ='Faturalar';
$app_list_strings['moduleList']['AOS_PDF_Templates'] ='PDF Şablonları';
$app_list_strings['moduleList']['AOS_Product_Categories'] ='Ürün kategorileri';
$app_list_strings['moduleList']['AOS_Products'] ='Ürünler';
$app_list_strings['moduleList']['AOS_Products_Quotes'] ='Satır Öğeleri';
$app_list_strings['moduleList']['AOS_Line_Item_Groups'] ='Satır Öğesi Grupları';
$app_list_strings['moduleList']['AOS_Quotes'] ='Parite';
$app_list_strings['aos_quotes_type_dom'][''] ='';
$app_list_strings['aos_quotes_type_dom']['Analyst'] ='Analist';
$app_list_strings['aos_quotes_type_dom']['Competitor'] ='Yarışmacı';
$app_list_strings['aos_quotes_type_dom']['Customer'] ='Müşteri';
$app_list_strings['aos_quotes_type_dom']['Integrator'] ='Entegratör';
$app_list_strings['aos_quotes_type_dom']['Investor'] ='Yatırımcı';
$app_list_strings['aos_quotes_type_dom']['Partner'] ='Ortak';
$app_list_strings['aos_quotes_type_dom']['Press'] ='Basın';
$app_list_strings['aos_quotes_type_dom']['Prospect'] ='Prospect';
$app_list_strings['aos_quotes_type_dom']['Reseller'] ='Bayi';
$app_list_strings['aos_quotes_type_dom']['Other'] ='Diğer';
$app_list_strings['template_ddown_c_list'][''] ='';
$app_list_strings['quote_stage_dom']['Draft'] ='Taslak';
$app_list_strings['quote_stage_dom']['Negotiation'] ='Müzakere';
$app_list_strings['quote_stage_dom']['Delivered'] ='Teslim';
$app_list_strings['quote_stage_dom']['On Hold'] ='Beklemede';
$app_list_strings['quote_stage_dom']['Confirmed'] ='Onaylı';
$app_list_strings['quote_stage_dom']['Closed Accepted'] ='Kabul Kabul Edildi';
$app_list_strings['quote_stage_dom']['Closed Lost'] ='Kapalı Kayıp';
$app_list_strings['quote_stage_dom']['Closed Dead'] ='Kapalı Ölü';
$app_list_strings['quote_term_dom']['Net 15'] ='Nett 15';
$app_list_strings['quote_term_dom']['Net 30'] ='Nett 30';
$app_list_strings['quote_term_dom'][''] ='';
$app_list_strings['approval_status_dom']['Approved'] ='Onaylı';
$app_list_strings['approval_status_dom']['Not Approved'] ='Onaylanmamış';
$app_list_strings['approval_status_dom'][''] ='';
$app_list_strings['vat_list']['0.0'] ='% 0';
$app_list_strings['vat_list']['5.0'] ='% 5';
$app_list_strings['vat_list']['7.5'] ='% 7.5';
$app_list_strings['vat_list']['17.5'] ='17 .5% ';
$app_list_strings['vat_list']['20.0'] ='20% ';
$app_list_strings['discount_list']['Percentage'] ='Pct';
$app_list_strings['discount_list']['Amount'] ='Amt';
$app_list_strings['aos_invoices_type_dom'][''] ='';
$app_list_strings['aos_invoices_type_dom']['Analyst'] ='Analist';
$app_list_strings['aos_invoices_type_dom']['Competitor'] ='Yarışmacı';
$app_list_strings['aos_invoices_type_dom']['Customer'] ='Müşteri';
$app_list_strings['aos_invoices_type_dom']['Integrator'] ='Entegratör';
$app_list_strings['aos_invoices_type_dom']['Investor'] ='Yatırımcı';
$app_list_strings['aos_invoices_type_dom']['Partner'] ='Ortak';
$app_list_strings['aos_invoices_type_dom']['Press'] ='Basın';
$app_list_strings['aos_invoices_type_dom']['Prospect'] ='Prospect';
$app_list_strings['aos_invoices_type_dom']['Reseller'] ='Bayi';
$app_list_strings['aos_invoices_type_dom']['Other'] ='Diğer';
$app_list_strings['invoice_status_dom']['Paid'] ='Ücretli';
$app_list_strings['invoice_status_dom']['Unpaid'] ='Ödenmemiş';
$app_list_strings['invoice_status_dom']['Cancelled'] ='İptal edildi';
$app_list_strings['invoice_status_dom'][''] ='';
$app_list_strings['quote_invoice_status_dom']['Not Invoiced'] ='Faturalandırılmamış';
$app_list_strings['quote_invoice_status_dom']['Invoiced'] ='Faturalanan';
$app_list_strings['product_code_dom']['XXXX'] ='XXXX';
$app_list_strings['product_code_dom']['YYYY'] ='YYYY';
$app_list_strings['product_category_dom']['Laptops'] ='Dizüstü';
$app_list_strings['product_category_dom']['Desktops'] ='Masaüstü';
$app_list_strings['product_category_dom'][''] ='';
$app_list_strings['product_type_dom']['Good'] ='İyi';
$app_list_strings['product_type_dom']['Service'] ='Hizmet';
$app_list_strings['product_quote_parent_type_dom']['AOS_Quotes'] ='Parite';
$app_list_strings['product_quote_parent_type_dom']['AOS_Invoices'] ='Faturalar';
$app_list_strings['product_quote_parent_type_dom']['AOS_Contracts'] ='Sözleşmeler';
$app_list_strings['pdf_template_type_dom']['AOS_Quotes'] ='Parite';
$app_list_strings['pdf_template_type_dom']['AOS_Invoices'] ='Faturalar';
$app_list_strings['pdf_template_type_dom']['AOS_Contracts'] ='Sözleşmeler';
$app_list_strings['pdf_template_type_dom']['Accounts'] ='Hesaplar';
$app_list_strings['pdf_template_type_dom']['Contacts'] ='Kişiler';
$app_list_strings['pdf_template_type_dom']['Leads'] ='İlanlar';
$app_list_strings['pdf_template_sample_dom'][''] ='';
$app_list_strings['contract_status_list']['Not Started'] ='Başlatılmadı';
$app_list_strings['contract_status_list']['In Progress'] ='Devam etmekte';
$app_list_strings['contract_status_list']['Signed'] ='İmzalı';
$app_list_strings['contract_type_list']['Type'] ='Tür';
$app_strings['LBL_PRINT_AS_PDF'] ='PDF olarak yazdır';
$app_strings['LBL_SELECT_TEMPLATE'] ='Lütfen bir şablon seçin';
$app_strings['LBL_NO_TEMPLATE'] ='HATA \ nHiçbir şablon bulunamadı. \ NLütfen PDF şablonları modülüne gidin ve bir tane oluşturun';

//aow
$app_list_strings['moduleList']['AOW_WorkFlow'] ='İş Akışı';
$app_list_strings['moduleList']['AOW_Conditions'] ='İş Akışı Koşulları';
$app_list_strings['moduleList']['AOW_Processed'] ='Süreç Denetimi';
$app_list_strings['moduleList']['AOW_Actions'] ='İş Akışı Eylemleri';
$app_list_strings['aow_status_list']['Active'] ='Aktif';
$app_list_strings['aow_status_list']['Inactive'] ='Etkin';
$app_list_strings['aow_operator_list']['Equal_To'] ='Eşittir';
$app_list_strings['aow_operator_list']['Not_Equal_To'] ='Eşit değil';
$app_list_strings['aow_operator_list']['Greater_Than'] ='Daha Büyük';
$app_list_strings['aow_operator_list']['Less_Than'] ='Daha az';
$app_list_strings['aow_operator_list']['Greater_Than_or_Equal_To'] ='Büyük veya Eşittir';
$app_list_strings['aow_operator_list']['Less_Than_or_Equal_To'] ='Daha Az veya Eşittir';
$app_list_strings['aow_operator_list']['Contains'] ='İçeren';
$app_list_strings['aow_operator_list']['Starts_With'] ='İle başlar';
$app_list_strings['aow_operator_list']['Ends_With'] ='Bitir';
$app_list_strings['aow_operator_list']['is_null'] ='Boş';
$app_list_strings['aow_process_status_list']['Complete'] ='Tamamlayınız';
$app_list_strings['aow_process_status_list']['Running'] ='Running';
$app_list_strings['aow_process_status_list']['Pending'] ='Beklemede';
$app_list_strings['aow_process_status_list']['Failed'] ='Başarısız oldu';
$app_list_strings['aow_condition_operator_list']['And'] ='Ve';
$app_list_strings['aow_condition_operator_list']['OR'] ='VEYA';
$app_list_strings['aow_condition_type_list']['Value'] ='Değer';
$app_list_strings['aow_condition_type_list']['Field'] ='Alan';
$app_list_strings['aow_condition_type_list']['Any_Change'] ='Herhangi bir değişiklik';
$app_list_strings['aow_condition_type_list']['SecurityGroup'] ='SecurityGroupta';
$app_list_strings['aow_condition_type_list']['Date'] ='Tarih';
$app_list_strings['aow_condition_type_list']['Multi'] ='Biri';
$app_list_strings['aow_action_type_list']['Value'] ='Değer';
$app_list_strings['aow_action_type_list']['Field'] ='Alan';
$app_list_strings['aow_action_type_list']['Date'] ='Tarih';
$app_list_strings['aow_action_type_list']['Round_Robin'] ='Round Robin';
$app_list_strings['aow_action_type_list']['Least_Busy'] ='En Az Meşgul';
$app_list_strings['aow_action_type_list']['Random'] ='Rastgele';
$app_list_strings['aow_rel_action_type_list']['Value'] ='Değer';
$app_list_strings['aow_rel_action_type_list']['Field'] ='Alan';
$app_list_strings['aow_date_type_list'][''] ='';
$app_list_strings['aow_date_type_list']['minute'] ='Dakika';
$app_list_strings['aow_date_type_list']['hour'] ='Saatler';
$app_list_strings['aow_date_type_list']['day'] ='Gün';
$app_list_strings['aow_date_type_list']['week'] ='Haftalar';
$app_list_strings['aow_date_type_list']['month'] ='Ay';
$app_list_strings['aow_date_type_list']['business_hours'] ='İş saatleri';
$app_list_strings['aow_date_options']['now'] ='Şimdi';
$app_list_strings['aow_date_options']['today'] ='Bugün';
$app_list_strings['aow_date_options']['field'] ='Bu alan';
$app_list_strings['aow_date_operator']['now'] ='';
$app_list_strings['aow_date_operator']['plus'] ='+';
$app_list_strings['aow_date_operator']['minus'] ='-';
$app_list_strings['aow_assign_options']['all'] ='Tüm kullanıcılar';
$app_list_strings['aow_assign_options']['role'] ='Roldeki TÜM Kullanıcılar';
$app_list_strings['aow_assign_options']['security_group'] ='Güvenlik Grubundaki TÜM Kullanıcılar';
$app_list_strings['aow_email_type_list']['Email Address'] ='E-posta';
$app_list_strings['aow_email_type_list']['Record Email'] ='Kayıt E-postası';
$app_list_strings['aow_email_type_list']['Related Field'] ='İlgili Alan';
$app_list_strings['aow_email_type_list']['Specify User'] ='Kullanıcı';
$app_list_strings['aow_email_type_list']['Users'] ='Kullanıcılar';
$app_list_strings['aow_email_to_list']['to'] ='Için';
$app_list_strings['aow_email_to_list']['cc'] ='Cc';
$app_list_strings['aow_email_to_list']['bcc'] ='Gizli';
$app_list_strings['aow_run_on_list']['All_Records'] ='Tüm Kayıtlar';
$app_list_strings['aow_run_on_list']['New_Records'] ='Yeni Kayıtlar';
$app_list_strings['aow_run_on_list']['Modified_Records'] ='Değiştirilmiş Kayıtlar';
$app_list_strings['aow_run_when_list']['Always'] ='Her zaman';
$app_list_strings['aow_run_when_list']['On_Save'] ='Sadece Kaydetme';
$app_list_strings['aow_run_when_list']['In_Scheduler'] ='Sadece Zamanlayıcıda';

//gant
$app_list_strings['moduleList']['AM_ProjectTemplates'] ='Proje Şablonları';
$app_list_strings['moduleList']['AM_TaskTemplates'] ='Proje Görev Şablonları';
$app_list_strings['relationship_type_list']['FS'] ='Bitirmeye Başlayın';
$app_list_strings['relationship_type_list']['SS'] ='Başlamaya Başlayın';
$app_list_strings['duration_unit_dom']['Days'] ='Gün';
$app_list_strings['duration_unit_dom']['Hours'] ='Saatler';
$app_strings['LBL_GANTT_BUTTON_LABEL'] ='View Gantt';
$app_strings['LBL_DETAIL_BUTTON_LABEL'] ='Ayrıntılara bakın';
$app_strings['LBL_CREATE_PROJECT'] ='Proje Oluşturun';

//gmaps
$app_strings['LBL_MAP'] ='Harita';

$app_strings['LBL_JJWG_MAPS_LNG'] ='Boylam';
$app_strings['LBL_JJWG_MAPS_LAT'] ='Enlem';
$app_strings['LBL_JJWG_MAPS_GEOCODE_STATUS'] ='Coğrafi Kod Durumu';
$app_strings['LBL_JJWG_MAPS_ADDRESS'] ='Adres';

$app_list_strings['moduleList']['jjwg_Maps'] ='Haritalar';
$app_list_strings['moduleList']['jjwg_Markers'] ='Harita İşaretleyicileri';
$app_list_strings['moduleList']['jjwg_Areas'] ='Harita Alanları';
$app_list_strings['moduleList']['jjwg_Address_Cache'] ='Harita Adresi Önbellek';

$app_list_strings['moduleList']['jjwp_Partners'] ='JJWP Ortakları';

$app_list_strings['map_unit_type_list']['mi'] = 'Miles';
$app_list_strings['map_unit_type_list']['km'] = 'Kilometre';

$app_list_strings['map_module_type_list']['Accounts'] ='Hesaplar';
$app_list_strings['map_module_type_list']['Contacts'] ='Kişiler';
$app_list_strings['map_module_type_list']['Cases'] ='Kılıflar';
$app_list_strings['map_module_type_list']['Leads'] ='İlanlar';
$app_list_strings['map_module_type_list']['Meetings'] ='Toplantılar';
$app_list_strings['map_module_type_list']['Opportunities'] ='Olanakları';
$app_list_strings['map_module_type_list']['Project'] ='Projeler';
$app_list_strings['map_module_type_list']['Prospects'] ='Hedefler';

$app_list_strings['map_relate_type_list']['Accounts'] ='Hesap';
$app_list_strings['map_relate_type_list']['Contacts'] ='Temas';
$app_list_strings['map_relate_type_list']['Cases'] ='Case';
$app_list_strings['map_relate_type_list']['Leads'] ='Öncülük etmek';
$app_list_strings['map_relate_type_list']['Meetings'] ='Toplantı';
$app_list_strings['map_relate_type_list']['Opportunities'] ='Fırsat';
$app_list_strings['map_relate_type_list']['Project'] ='Proje';
$app_list_strings['map_relate_type_list']['Prospects'] ='Hedef';

$app_list_strings['marker_image_list']['accident'] ='Kaza';
$app_list_strings['marker_image_list']['administration'] ='İdare';
$app_list_strings['marker_image_list']['agriculture'] ='Tarım';
$app_list_strings['marker_image_list']['aircraft_small'] ='Uçak küçük';
$app_list_strings['marker_image_list']['airplane_tourism'] ='Uçak Turizmi';
$app_list_strings['marker_image_list']['airport'] ='Havalimanı';
$app_list_strings['marker_image_list']['amphitheater'] ='Amfitiyatro';
$app_list_strings['marker_image_list']['apartment'] ='Apartman';
$app_list_strings['marker_image_list']['aquarium'] ='Akvaryum';
$app_list_strings['marker_image_list']['arch'] ='Arch';
$app_list_strings['marker_image_list']['atm'] ='ATM';
$app_list_strings['marker_image_list']['audio'] ='Ses';
$app_list_strings['marker_image_list']['bank'] ='Banka';
$app_list_strings['marker_image_list']['bank_euro'] ='Banka Euro';
$app_list_strings['marker_image_list']['bank_pound'] ='Banka Poundu';
$app_list_strings['marker_image_list']['bar'] ='Bar';
$app_list_strings['marker_image_list']['beach'] ='Plaj';
$app_list_strings['marker_image_list']['beautiful'] ='Güzel';
$app_list_strings['marker_image_list']['bicycle_parking'] ='Bisiklet park yeri';
$app_list_strings['marker_image_list']['big_city'] ='Büyük şehir';
$app_list_strings['marker_image_list']['bridge'] ='Köprü';
$app_list_strings['marker_image_list']['bridge_modern'] ='Köprü Modern';
$app_list_strings['marker_image_list']['bus'] ='Otobüs';
$app_list_strings['marker_image_list']['cable_car'] ='Teleferik';
$app_list_strings['marker_image_list']['car'] ='Araba';
$app_list_strings['marker_image_list']['car_rental'] ='Araba kiralama';
$app_list_strings['marker_image_list']['carrepair'] ='Araba tamiri';
$app_list_strings['marker_image_list']['castle'] ='Kale';
$app_list_strings['marker_image_list']['cathedral'] ='Katedral';
$app_list_strings['marker_image_list']['chapel'] ='Chapel';
$app_list_strings['marker_image_list']['church'] ='Kilise';
$app_list_strings['marker_image_list']['city_square'] ='Şehir Meydanı';
$app_list_strings['marker_image_list']['cluster'] ='Küme';
$app_list_strings['marker_image_list']['cluster_2'] ='Küme 2';
$app_list_strings['marker_image_list']['cluster_3'] ='Küme 3';
$app_list_strings['marker_image_list']['cluster_4'] ='Küme 4';
$app_list_strings['marker_image_list']['cluster_5'] ='Küme 5';
$app_list_strings['marker_image_list']['coffee'] ='Kahve';
$app_list_strings['marker_image_list']['community_centre'] ='Toplum Merkezi';
$app_list_strings['marker_image_list']['company'] ='Şirket';
$app_list_strings['marker_image_list']['conference'] ='Konferans';
$app_list_strings['marker_image_list']['construction'] ='İnşaat';
$app_list_strings['marker_image_list']['convenience'] ='Kolaylık';
$app_list_strings['marker_image_list']['court'] ='Mahkeme';
$app_list_strings['marker_image_list']['cruise'] ='Seyir';
$app_list_strings['marker_image_list']['currency_exchange'] ='Döviz değişimi';
$app_list_strings['marker_image_list']['customs'] ='Gümrük';
$app_list_strings['marker_image_list']['cycling'] ='Bisiklet sürmek';
$app_list_strings['marker_image_list']['dam'] = 'Dam';
$app_list_strings['marker_image_list']['days_dim'] = 'Days Dim';
$app_list_strings['marker_image_list']['days_dom'] = 'Days Dom';
$app_list_strings['marker_image_list']['days_jeu'] = 'Days Jeu';
$app_list_strings['marker_image_list']['days_jue'] = 'Days Jue';
$app_list_strings['marker_image_list']['days_lun'] = 'Days Lun';
$app_list_strings['marker_image_list']['days_mar'] = 'Days Mar';
$app_list_strings['marker_image_list']['days_mer'] = 'Days Mer';
$app_list_strings['marker_image_list']['days_mie'] = 'Days Mie';
$app_list_strings['marker_image_list']['days_qua'] = 'Days Qua';
$app_list_strings['marker_image_list']['days_qui'] = 'Days Qui';
$app_list_strings['marker_image_list']['days_sab'] = 'Days Sab';
$app_list_strings['marker_image_list']['days_sam'] = 'Days Sam';
$app_list_strings['marker_image_list']['days_seg'] = 'Days Seg';
$app_list_strings['marker_image_list']['days_sex'] = 'Days Sex';
$app_list_strings['marker_image_list']['days_ter'] = 'Days Ter';
$app_list_strings['marker_image_list']['days_ven'] = 'Days Ven';
$app_list_strings['marker_image_list']['days_vie'] = 'Days Vie';
$app_list_strings['marker_image_list']['dentist'] ='Diş doktoru';
$app_list_strings['marker_image_list']['deptartment_store'] ='Deptartment Mağazası';
$app_list_strings['marker_image_list']['disability'] ='Engellilik';
$app_list_strings['marker_image_list']['disabled_parking'] ='Engelli otopark';
$app_list_strings['marker_image_list']['doctor'] ='Doktor';
$app_list_strings['marker_image_list']['dog_leash'] ='Köpek tasması';
$app_list_strings['marker_image_list']['down'] ='Aşağı';
$app_list_strings['marker_image_list']['down_left'] ='Aşağı Sol';
$app_list_strings['marker_image_list']['down_right'] ='Sağ Aşağı';
$app_list_strings['marker_image_list']['down_then_left'] ='Aşağıdan Sonra Sola';
$app_list_strings['marker_image_list']['down_then_right'] ='Aşağı doğru doğru';
$app_list_strings['marker_image_list']['drugs'] ='İlaçlar';
$app_list_strings['marker_image_list']['elevator'] ='Asansör';
$app_list_strings['marker_image_list']['embassy'] ='Elçilik';
$app_list_strings['marker_image_list']['expert'] ='Uzman';
$app_list_strings['marker_image_list']['factory'] ='Fabrika';
$app_list_strings['marker_image_list']['falling_rocks'] ='Düşen kayalar';
$app_list_strings['marker_image_list']['fast_food'] ='Fast food';
$app_list_strings['marker_image_list']['festival'] ='Festival';
$app_list_strings['marker_image_list']['fjord'] ='Fiyort';
$app_list_strings['marker_image_list']['forest'] ='Orman';
$app_list_strings['marker_image_list']['fountain'] ='Çeşme';
$app_list_strings['marker_image_list']['friday'] ='Cuma';
$app_list_strings['marker_image_list']['garden'] ='Bahçe';
$app_list_strings['marker_image_list']['gas_station'] ='Gaz istasyonu';
$app_list_strings['marker_image_list']['geyser'] ='Termosifon';
$app_list_strings['marker_image_list']['gifts'] ='Hediyeler';
$app_list_strings['marker_image_list']['gourmet'] ='Gurme';
$app_list_strings['marker_image_list']['grocery'] ='Bakkal';
$app_list_strings['marker_image_list']['hairsalon'] ='Kuaför';
$app_list_strings['marker_image_list']['helicopter'] ='Helikopter';
$app_list_strings['marker_image_list']['highway'] ='Otoyol';
$app_list_strings['marker_image_list']['historical_quarter'] ='Tarihsel Çeyrek';
$app_list_strings['marker_image_list']['home'] ='Ev';
$app_list_strings['marker_image_list']['hospital'] ='Hastane';
$app_list_strings['marker_image_list']['hostel'] ='Pansiyon';
$app_list_strings['marker_image_list']['hotel'] ='Otel';
$app_list_strings['marker_image_list']['hotel_1_star'] ='Otel 1 Yıldız';
$app_list_strings['marker_image_list']['hotel_2_stars'] ='Otel 2 Yıldız';
$app_list_strings['marker_image_list']['hotel_3_stars'] ='Otel 3 Yıldız';
$app_list_strings['marker_image_list']['hotel_4_stars'] ='Otel 4 Yıldız';
$app_list_strings['marker_image_list']['hotel_5_stars'] ='Otel 5 Yıldız';
$app_list_strings['marker_image_list']['info'] ='Bilgi';
$app_list_strings['marker_image_list']['justice'] ='Adalet';
$app_list_strings['marker_image_list']['lake'] ='Göl';
$app_list_strings['marker_image_list']['laundromat'] ='Launderette';
$app_list_strings['marker_image_list']['left'] ='Ayrıldı';
$app_list_strings['marker_image_list']['left_then_down'] ='Aşağıdan Aşağıya';
$app_list_strings['marker_image_list']['left_then_up'] ='Soldan Sonra Sonra';
$app_list_strings['marker_image_list']['library'] ='Kütüphane';
$app_list_strings['marker_image_list']['lighthouse'] ='Deniz feneri';
$app_list_strings['marker_image_list']['liquor'] ='Likör';
$app_list_strings['marker_image_list']['lock'] ='Kilit';
$app_list_strings['marker_image_list']['main_road'] ='Ana yol';
$app_list_strings['marker_image_list']['massage'] ='Masaj';
$app_list_strings['marker_image_list']['mobile_phone_tower'] ='Cep Telefonu Kulesi';
$app_list_strings['marker_image_list']['modern_tower'] ='Modern Tower';
$app_list_strings['marker_image_list']['monastery'] ='Sinagog';
$app_list_strings['marker_image_list']['monday'] ='Pazartesi';
$app_list_strings['marker_image_list']['monument'] ='Anıt';
$app_list_strings['marker_image_list']['mosque'] ='Cami';
$app_list_strings['marker_image_list']['motorcycle'] ='Motosiklet';
$app_list_strings['marker_image_list']['museum'] ='Müze';
$app_list_strings['marker_image_list']['music_live'] ='Müzik Canlı';
$app_list_strings['marker_image_list']['oil_pump_jack'] ='Yağ Pompası Krikosu';
$app_list_strings['marker_image_list']['pagoda'] ='Pagoda';
$app_list_strings['marker_image_list']['palace'] ='Saray';
$app_list_strings['marker_image_list']['panoramic'] ='Panoramik';
$app_list_strings['marker_image_list']['park'] ='Park';
$app_list_strings['marker_image_list']['park_and_ride'] ='Dur ve sür';
$app_list_strings['marker_image_list']['parking'] ='Otopark';
$app_list_strings['marker_image_list']['photo'] ='Fotoğraf';
$app_list_strings['marker_image_list']['picnic'] ='Piknik';
$app_list_strings['marker_image_list']['places_unvisited'] ='Yerler Unvisited';
$app_list_strings['marker_image_list']['places_visited'] ='Ziyaret edilen yerler';
$app_list_strings['marker_image_list']['playground'] ='Oyun alanı';
$app_list_strings['marker_image_list']['police'] ='Polis';
$app_list_strings['marker_image_list']['port'] ='Liman';
$app_list_strings['marker_image_list']['postal'] ='Posta';
$app_list_strings['marker_image_list']['power_line_pole'] ='Güç Hattı Kutbu';
$app_list_strings['marker_image_list']['power_plant'] ='Enerji santrali';
$app_list_strings['marker_image_list']['power_substation'] ='Güç Santrali';
$app_list_strings['marker_image_list']['public_art'] ='Halk sanatı';
$app_list_strings['marker_image_list']['rain'] ='Yağmur';
$app_list_strings['marker_image_list']['real_estate'] ='Emlak';
$app_list_strings['marker_image_list']['regroup'] ='Yeniden grupla';
$app_list_strings['marker_image_list']['resort'] ='Resort';
$app_list_strings['marker_image_list']['restaurant'] ='Restoran';
$app_list_strings['marker_image_list']['restaurant_african'] ='Restoran Afrika';
$app_list_strings['marker_image_list']['restaurant_barbecue'] ='Restaurant Barbekü';
$app_list_strings['marker_image_list']['restaurant_buffet'] ='Restoran Büfesi';
$app_list_strings['marker_image_list']['restaurant_chinese'] ='Restoran Çinlisi';
$app_list_strings['marker_image_list']['restaurant_fish'] ='Restoran Balıkları';
$app_list_strings['marker_image_list']['restaurant_fish_chips'] ='Restaurant Fish Chips';
$app_list_strings['marker_image_list']['restaurant_gourmet'] ='Restoran Gurme';
$app_list_strings['marker_image_list']['restaurant_greek'] ='Restaurant Greek';
$app_list_strings['marker_image_list']['restaurant_indian'] ='Restoran Hint';
$app_list_strings['marker_image_list']['restaurant_italian'] ='Restoran İtalyan';
$app_list_strings['marker_image_list']['restaurant_japanese'] ='Restoran Japonca';
$app_list_strings['marker_image_list']['restaurant_kebab'] ='Restaurant Kebap';
$app_list_strings['marker_image_list']['restaurant_korean'] ='Restoran Korece';
$app_list_strings['marker_image_list']['restaurant_mediterranean'] ='Restoran Akdeniz';
$app_list_strings['marker_image_list']['restaurant_mexican'] ='Restoran Meksika';
$app_list_strings['marker_image_list']['restaurant_romantic'] ='Restoran Romantik';
$app_list_strings['marker_image_list']['restaurant_thai'] ='Restaurant Thai';
$app_list_strings['marker_image_list']['restaurant_turkish'] ='Restaurant Türkçesi';
$app_list_strings['marker_image_list']['right'] ='Sağ';
$app_list_strings['marker_image_list']['right_then_down'] ='Hemen Sonra Aşağı';
$app_list_strings['marker_image_list']['right_then_up'] ='Hemen Sonra';
$app_list_strings['marker_image_list']['saturday'] ='Cumartesi';
$app_list_strings['marker_image_list']['school'] ='Okul';
$app_list_strings['marker_image_list']['shopping_mall'] ='Alışveriş Merkezi';
$app_list_strings['marker_image_list']['shore'] ='Shore';
$app_list_strings['marker_image_list']['sight'] ='Görme';
$app_list_strings['marker_image_list']['small_city'] ='Küçük şehir';
$app_list_strings['marker_image_list']['snow'] ='Kar';
$app_list_strings['marker_image_list']['spaceport'] ='Uzaylimanı';
$app_list_strings['marker_image_list']['speed_100'] ='Hız 100';
$app_list_strings['marker_image_list']['speed_110'] ='Hız 110';
$app_list_strings['marker_image_list']['speed_120'] ='Hız 120';
$app_list_strings['marker_image_list']['speed_130'] ='Hız 130';
$app_list_strings['marker_image_list']['speed_20'] ='Hız 20';
$app_list_strings['marker_image_list']['speed_30'] ='Hız 30';
$app_list_strings['marker_image_list']['speed_40'] ='Hız 40';
$app_list_strings['marker_image_list']['speed_50'] ='Hız 50';
$app_list_strings['marker_image_list']['speed_60'] ='Hız 60';
$app_list_strings['marker_image_list']['speed_70'] ='Hız 70';
$app_list_strings['marker_image_list']['speed_80'] ='Hız 80';
$app_list_strings['marker_image_list']['speed_90'] ='Hız 90';
$app_list_strings['marker_image_list']['speed_hump'] ='Hızlı Hump';
$app_list_strings['marker_image_list']['stadium'] ='Stadyum';
$app_list_strings['marker_image_list']['statue'] ='Heykel';
$app_list_strings['marker_image_list']['steam_train'] ='Buharlı tren';
$app_list_strings['marker_image_list']['stop'] ='Durdurmak';
$app_list_strings['marker_image_list']['stoplight'] ='Dur ışığı';
$app_list_strings['marker_image_list']['subway'] ='Metro';
$app_list_strings['marker_image_list']['sun'] ='Güneş';
$app_list_strings['marker_image_list']['sunday'] ='Pazar';
$app_list_strings['marker_image_list']['supermarket'] ='Süpermarket';
$app_list_strings['marker_image_list']['synagogue'] ='Sinagogu ';
$app_list_strings['marker_image_list']['tapas'] ='Tapas';
$app_list_strings['marker_image_list']['taxi'] ='Taksi';
$app_list_strings['marker_image_list']['taxiway'] ='Taxiway';
$app_list_strings['marker_image_list']['teahouse'] ='Çayevi';
$app_list_strings['marker_image_list']['telephone'] ='Telefon';
$app_list_strings['marker_image_list']['temple_hindu'] ='Tapınak Hindu';
$app_list_strings['marker_image_list']['terrace'] ='Teras';
$app_list_strings['marker_image_list']['text'] ='Metin';
$app_list_strings['marker_image_list']['theater'] ='Tiyatro';
$app_list_strings['marker_image_list']['theme_park'] ='Tema Parkı';
$app_list_strings['marker_image_list']['thursday'] ='Perşembe';
$app_list_strings['marker_image_list']['toilets'] ='Tuvalet';
$app_list_strings['marker_image_list']['toll_station'] ='Ücretli İstasyon';
$app_list_strings['marker_image_list']['tower'] ='Kule';
$app_list_strings['marker_image_list']['traffic_enforcement_camera'] ='Trafik İcra Kamerası';
$app_list_strings['marker_image_list']['train'] ='Tren';
$app_list_strings['marker_image_list']['tram'] ='Tramvay';
$app_list_strings['marker_image_list']['truck'] ='Kamyon';
$app_list_strings['marker_image_list']['tuesday'] ='Salı';
$app_list_strings['marker_image_list']['tunnel'] ='Tünel';
$app_list_strings['marker_image_list']['turn_left'] ='Sola çevirin';
$app_list_strings['marker_image_list']['turn_right'] ='Sağa dönün';
$app_list_strings['marker_image_list']['university'] ='Üniversite';
$app_list_strings['marker_image_list']['up'] ='Yukarı';
$app_list_strings['marker_image_list']['up_left'] ='Yukarı sol';
$app_list_strings['marker_image_list']['up_right'] ='Sağ Yukarı';
$app_list_strings['marker_image_list']['up_then_left'] ='Yukarıdan Sonra Soldan';
$app_list_strings['marker_image_list']['up_then_right'] ='O zaman doğru';
$app_list_strings['marker_image_list']['vespa'] ='Vespa';
$app_list_strings['marker_image_list']['video'] ='Video';
$app_list_strings['marker_image_list']['villa'] ='Villa';
$app_list_strings['marker_image_list']['water'] ='Su';
$app_list_strings['marker_image_list']['waterfall'] ='Şelale';
$app_list_strings['marker_image_list']['watermill'] ='Watermill';
$app_list_strings['marker_image_list']['waterpark'] ='Su parkı';
$app_list_strings['marker_image_list']['watertower'] ='Su kulesi';
$app_list_strings['marker_image_list']['wednesday'] ='Çarşamba';
$app_list_strings['marker_image_list']['wifi'] ='Kablosuz internet';
$app_list_strings['marker_image_list']['wind_turbine'] ='Rüzgar türbini';
$app_list_strings['marker_image_list']['windmill'] ='Yeldeğirmeni';
$app_list_strings['marker_image_list']['winery'] ='Şaraphane';
$app_list_strings['marker_image_list']['work_office'] ='Çalışma ofisi';
$app_list_strings['marker_image_list']['world_heritage_site'] ='Dünya Mirası sitesi';
$app_list_strings['marker_image_list']['zoo'] ='Zoo';

//Reschedule
$app_list_strings['call_reschedule_dom']['']  ='';
$app_list_strings['call_reschedule_dom']['Out of Office'] ='Ofis dışında';
$app_list_strings['call_reschedule_dom']['In a Meeting'] ='Bir toplantıda';

$app_strings['LBL_RESCHEDULE_LABEL'] ='Yeniden zamanlama';
$app_strings['LBL_RESCHEDULE_TITLE'] ='Lütfen yeniden zamanlama bilgilerini giriniz';
$app_strings['LBL_RESCHEDULE_DATE'] ='Tarih:';
$app_strings['LBL_RESCHEDULE_REASON'] ='Sebep:';
$app_strings['LBL_RESCHEDULE_ERROR1'] ='Lütfen geçerli bir tarih seçiniz';
$app_strings['LBL_RESCHEDULE_ERROR2'] ='Lütfen bir sebep seçin';

$app_strings['LBL_RESCHEDULE_PANEL'] ='Yeniden zamanlama';
$app_strings['LBL_RESCHEDULE_HISTORY'] ='Çağrı deneme geçmişi';
$app_strings['LBL_RESCHEDULE_COUNT'] ='Çağrı Denemeleri';

//SecurityGroups
$app_list_strings['moduleList']['SecurityGroups'] ='Güvenlik Grupları Yönetimi';
$app_strings['LBL_SECURITYGROUP'] ='Güvenlik Grubu';

$app_list_strings['moduleList']['OutboundEmailAccounts'] ='Giden E-posta Hesapları';

//social
$app_strings['FACEBOOK_USER_C'] ='Facebook';
$app_strings['TWITTER_USER_C'] ='Heyecan';
$app_strings['LBL_PANEL_SOCIAL_FEED'] ='Sosyal Besleme Ayrıntıları';

$app_strings['LBL_SUBPANEL_FILTER_LABEL'] ='Filtre';

$app_strings['LBL_QUICK_ACCOUNT'] ='Hesap açmak';
$app_strings['LBL_QUICK_CONTACT'] ='Temas kurmak';
$app_strings['LBL_QUICK_OPPORTUNITY'] ='Fırsat Yaratın';
$app_strings['LBL_QUICK_LEAD'] ='Kurşun Yarat';
$app_strings['LBL_QUICK_DOCUMENT'] ='Belge Oluştur';
$app_strings['LBL_QUICK_CALL'] ='Log Call';
$app_strings['LBL_QUICK_TASK'] ='Görev Oluştur';
$app_strings['LBL_COLLECTION_TYPE'] ='Tür';

$app_strings['LBL_ADD_TAB'] ='Sekme Ekle';
$app_strings['LBL_EDIT_TAB'] ='Sekmeleri Düzenle';
$app_strings['LBL_SUITE_DASHBOARD'] ='SUITECRM DASHBOARD';
$app_strings['LBL_ENTER_DASHBOARD_NAME'] ='Gösterge Tablosu Adını Girin:';
$app_strings['LBL_NUMBER_OF_COLUMNS'] ='Sütun sayısı:';
$app_strings['LBL_DELETE_DASHBOARD1'] ='Silmek istediğinizden emin misiniz';
$app_strings['LBL_DELETE_DASHBOARD2'] ='Pano?';
$app_strings['LBL_ADD_DASHBOARD_PAGE'] ='Bir Gösterge Tablosu Sayfası Ekle';
$app_strings['LBL_DELETE_DASHBOARD_PAGE'] ='Geçerli Gösterge Tablosu Sayfasını Kaldır';
$app_strings['LBL_RENAME_DASHBOARD_PAGE'] ='Gösterge Panosu Sayfasını Yeniden Adlandır';
$app_strings['LBL_SUITE_DASHBOARD_ACTIONS'] ='İŞLEMLER';

$app_list_strings['collection_temp_list'] =array(
    'Tasks' 	=> 'Görevler',
    'Meetings' 	=> 'Toplantılar',
    'Calls' 	=> 'Çağrılar',
    'Notes' 	=> 'Notlar',
    'Emails' 	=> 'E-postalar'
);	

$app_list_strings['moduleList']['TemplateEditor'] ='Şablon Parça Editörü';
$app_strings['LBL_CONFIRM_CANCEL_INLINE_EDITING'] ="Kaydetmeden kaydettiğiniz alana tıklayıp uzaklaştınız mı? Değişikliğinizi kaybetmekten memnuniyet duyarsanız Tamam'ı tıklayın veya düzenleme işlemine devam etmek isterseniz iptal et ";
$app_strings['LBL_LOADING_ERROR_INLINE_EDITING'] ="Alan yüklenirken bir hata oluştu. Oturumunuz zaman aşımına uğramış olabilir Lütfen bunu düzeltmek için tekrar oturum açın";

//SuiteSpots
$app_list_strings['spots_areas'] =array(
    'getSalesSpotsData' 	=> 'Satış',
    'getAccountsSpotsData' 	=> 'Hesaplar',
    'getLeadsSpotsData' 	=> 'Kurşun',
    'getServiceSpotsData' 	=> 'Hizmet'
    'getMarketingSpotsData' 	=> 'Pazarlama'
    'getMarketingActivitySpotsData' 	=> 'Pazarlama Etkinliği',
    'getActivitiesSpotsData' 	=> 'Etkinlikler',
    'getQuotesSpotsData' 	=> 'Tırnaklar'
);	

$app_list_strings['moduleList']['Spots'] ='Noktalar';

$app_list_strings['moduleList']['AOBH_BusinessHours'] ='İş saatleri';
$app_list_strings['business_hours_list']['0']  ='12am';
$app_list_strings['business_hours_list']['1']  ='1am';
$app_list_strings['business_hours_list']['2']  ='2am';
$app_list_strings['business_hours_list']['3']  ='3am';
$app_list_strings['business_hours_list']['4']  ='4am';
$app_list_strings['business_hours_list']['5']  ='5am';
$app_list_strings['business_hours_list']['6']  ='6am';
$app_list_strings['business_hours_list']['7']  ='7am';
$app_list_strings['business_hours_list']['8']  ='8am';
$app_list_strings['business_hours_list']['9']  ='9am';
$app_list_strings['business_hours_list']['10']  ='10am';
$app_list_strings['business_hours_list']['11']  ='11am';
$app_list_strings['business_hours_list']['12']  ='12pm';
$app_list_strings['business_hours_list']['13']  ='1pm';
$app_list_strings['business_hours_list']['14']  ='2pm';
$app_list_strings['business_hours_list']['15']  ='3pm';
$app_list_strings['business_hours_list']['16']  ='4pm';
$app_list_strings['business_hours_list']['17']  ='5pm';
$app_list_strings['business_hours_list']['18']  ='6pm';
$app_list_strings['business_hours_list']['19']  ='7pm';
$app_list_strings['business_hours_list']['20']  ='8pm';
$app_list_strings['business_hours_list']['21']  ='9pm';
$app_list_strings['business_hours_list']['22']  ='10pm';
$app_list_strings['business_hours_list']['23']  ='11pm';
$app_list_strings['day_list']['Monday'] ='Pazartesi';
$app_list_strings['day_list']['Tuesday'] = 'Salı';
$app_list_strings['day_list']['Wednesday'] = 'Çarşamba';
$app_list_strings['day_list']['Thursday'] = 'Perşembe';
$app_list_strings['day_list']['Friday'] = 'Cuma';
$app_list_strings['day_list']['Saturday'] = 'Cumartesi';
$app_list_strings['day_list']['Sunday'] = 'Pazar';
$app_list_strings['pdf_page_size_dom']['A4'] = 'A4';
$app_list_strings['pdf_page_size_dom']['Letter'] = 'Mektup';
$app_list_strings['pdf_page_size_dom']['Legal'] = 'Yasal';
$app_list_strings['pdf_orientation_dom']['Portrait'] = 'Portre';
$app_list_strings['pdf_orientation_dom']['Landscape'] = 'Yatay';
