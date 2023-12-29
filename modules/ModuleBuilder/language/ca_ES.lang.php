<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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

$mod_strings = array(
    'LBL_LOADING' => 'Carregant' /*for 508 compliance fix*/,
    'LBL_HIDEOPTIONS' => 'Oculta les opcions' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Elimina' /*for 508 compliance fix*/,
    'help' => array(
        'package' => array(
            'author' => 'Aquest és l&#39; <b>Autor</b> mostrat durant la instal·lació com el nom de l&#39;entitat que ha creat el paquet.<br><br>L&#39;Autor podría ser un individu o una empresa.',
            'create' => 'Proporcioni un <b>Nom</b> par al paquet. El nom que introdueixi ha de ser alfanumèric i no pot contenir espais. (Exemple: HR_Management)<br/><br/> Pot proporcionar la informació del <b>Autor</b> i la <b>Descripció</b> del paquet. <br/><br/>Faci clic a <b>Desar</b> par a crear el paquet.',
            'deletebtn' => 'Faci clic a <b>Eliminar</b> per eliminar aquest paquet i tots els arxius relacionats amb aquest paquet.',
            'deploybtn' => 'Faci clic a <b>Desplegar</b> per a desar totes les dades introduïdes i instal·lar el paquet, incloent tots els mòduls, en la instància actual.',
            'description' => 'Aquesta és la <b>Descripció</b> del paquet que es mostra durant la instal·lació.',
            'duplicatebtn' => 'Faci clic a <b>Duplicar</b> per a copiar el contingut del paquet en un paquet nou i mostrar l&#39;acabat de creat paquet. <br/><br/>Es crearà de manera automàtica un nou nom per el nou paquet afegint un número al final del nom del paquet original. Pot renombrar el nou paquet introduint un nou <b>Nom</b> i fent clic a <b>Guardar</b>.',
            'existing_module' => 'Faci clic a l&#39;icona <b>Mòdul</b> per editar les propietats i personalitzar els camps, relacions i dissenys associats al mòdul.',
            'exportbtn' => 'Faci clic a <b>Exportar</b> per crear un arxiu .zip que contingui les personalitzacions fetes al paquet.<br><br> L&#39;arxiu generat no és una versió instal·lable del paquet.<br><br>Utilitzi el <b>Carregador de Mòduls</b> per importar l&#39;arxiu .zip i per a que el paquet, personalitzacions incloses, apareixi en el Constructor de Mòduls.',
            'key' => 'Aquesta <b>Clau</b> alfanumèrica de 5 lletres s&#39;utilitzarà per prefixar tots els directoris, noms de classes i taules de base de dades de tots els mòduls en el paquet actual.<br><br>La clau s&#39;utilitza per contribuir a la unicitat dels noms de taules.',
            'modify' => 'Les propietats i accions possibles del <b>Paquet</b> apareixen aquí.<br><br>Pot modificar el <b>Nom</b>, <b>Autor</b> i <b>Descripció</b> del paquet, així com veure i personalitzar qualsevol dels mòduls continguts en el paquet.<br><br>Faci clic a <b>Nou Mòdul</b> per crear un mòdul per el paquet.<br><br>Si el paquet conté al menys un mòdul, pot <b>Publicar</b> i <b>Desplegar</b> el paquet, així com <b>Exportar</b> les personaltizacions realitzades al paquet.',            
            'name' => 'Aquest és el <b>Nom</b> del paquet actual. <br/><br/>El nom que introdueixi ha de ser alfanumèric, començar per una lletra i no contenir espais. (Exemple: HR_Management)',
            'new_module' => 'Faci clic a <b>Nou Mòdul</b> per crear un nou mòdul per aquest paquet.',
            'publishbtn' => 'Faci clic a <b>Publicar</b> per a desar totes les dades introduides i crear un fitxer .zip que és una versió instal·lable del paquet.<br><br>Utilitzi el <b>Cargardor de Mòduls</b> per a pujar el fitxer .zip i instal·lar el paquet.',
            'readme' => 'Faci clic per agregar un text <b>Llegeix-me</b> per aquest paquet.<br><br>El Llegeix-me quedarà disponible en el moment de instal·lació.',
            'savebtn' => 'Faci clic a <b>Desar i Desplegar</b> per a desar tots els canvis que ha realitzat i per a que estiguin aplicats al mòdul.',
        ),
        'main' => array(),
        'module' => array(
            'acl' => 'Marcant aquesta opció habilitarà els Controls d&#39;Accés per aquest mòdul, incluent la Seguretat a Nivell de Camp.',
            'assignable' => 'Marcant aquesta opció permetrà que un registre d&#39;aquest mòdul sigui assignat a un usuari.',
            'audit' => 'Marcant aquesta opció habilitarà l&#39;Auditoria per  aquest mòdul. Els canvis a alguns dels camps seran registrats de manera que els administradors puguin revisar l&#39;historial de canvis.',
            'create' => 'Proporcioni un <b>Nom</b> per al mòdul. L&#39; <b>Etiqueta</b> que introdueixi apareixerà a la pestanya de navegació. <br/><br/>Trii mostrar una pestanya de navegació per al mòdul marcant el quadre <b>Pestanya de Navegació</b>.<br/><br/>Marqui el quadre <b>Seguritat d&#39;Equips</b> per a tenir un camp de selecció d&#39;Equips dins de los registres del mòdul. <br/><br/>Finalment, seleccioni el tipus de mòdul que desitja crear. <br/><br/>Seleccioni un tipus de plantilla. Cada plantilla conté un conjunt determinat de camps, així com dissenys predefinits, per a ser utilitzats com a base del seu mòdul. <br/><br/>Faci clic a <b>Guardar</b> per crear el mòdul.',            'deletebtn' => 'Cliqui <b>Eliminar</b> per eliminar aquest mòdul.',
            'duplicatebtn' => 'Feu clic a <b> Duplica </b> per copiar les propietats del mòdul en un mòdul nou i per mostrar el nou mòdul. <br/> Per al nou mòdul, un nou nom es generarà automàticament afegint un número al final del nom del mòdul utilitzat per crear la nova.',
            'has_tab' => 'Marcant <b>Pestanya de Navegació</b> proveïrà al mòdul d&#39;una pestanya de navegació.',
            'importable' => 'Marcant l&#39;opció <b>Importable</b> s&#39;habilitarà la importació per aquest mòdul.<br><br>Un enllaç a l&#39;Assistent d&#39;Importació apareixerà en el panell de Dreceres del mòdul.  L&#39;Assistent d&#39;Importació li facilitarà la importació de dades provinents de fonts externes en el mòdul personalitzat.',
            'label' => 'Aquesta és l&#39;<b>Etiqueta</b> que apareixerà a la pestanya de navegació del mòdul.',            'modify' => 'Vostè pot canviar les propietats del mòdul o personalitzar el <b> Camps </b>, <b> Relacions </b> i <b> Layouts </b> en relació amb el mòdul.',
            'name' => 'Aquest és el <b>Nom</b> del mòdul actual.<br/><br/>El nom ha de ser alfanumèric, ha de començar amb una lletra i no pot contenir espais. (Example: HR_Management)',
            'reportable' => 'Marcant aquesta opció permetrà que aquest mòdul tingui informes que corrin contra ell.',
            'savebtn' => 'Cliqui <b>Desar</b> per desar tota la informació relacionada amb el mòdul.',
            'studio' => 'Marcant aquesta opció permetrà que els administradors personalitzin aquest mòdul dins de l&#39;Estudi.',
            'team_security' => 'Marcant l&#39;opció <b>Seguretat d&#39;Equips</b> s&#39;habilitarà la seguretat d&#39;equips per aquest mòdul.  <br/><br/>Si la seguretat d&#39;equips està habilitada, el camp de selecció d&#39;Equip apareixerà en els registres del mòdul',
            'type_basic' => 'El tipus de plantilla <b>Bàsica</b> proporciona els camps bèsics, com Nom, Assignat a, Equip, Data de Creació i Descripció.',
            'type_company' => 'El tipus de plantilla <b>Empresa</b> proporciona camps particulars d&#39;una organizació, com Nom d&#39;Empresa, Indústria i Adreça de Facturació.<br/><br/>Utilitzi aquesta plantilla per crear mòduls que sigui similars al mòdul estàndar de Comptes.',
            'type_file' => 'La plantilla <b>Arxiu</b> proporciona camps específics d&#39;un Document, com Nom d&#39;Arxiu, tipus de Document, i Data de Publicació.<br><br>Utilitzi aquesta plantilla per crear mòduls que siguin similars al mòdul estàndar de Documents.',
            'type_issue' => 'El tipus de plantilla <b>Incidència</b> proporciona camps particulars de casos i incidèncis, com Número, Estat, Prioritat i Descripció.<br/><br/>Utilitzi aquesta plantilla pera crear mòduls que siguin similars als mòduls estàndar de Casos i Seguiment d&#39;Incidències.',
            'type_person' => 'El tipus de plantilla <b>Persona</b> disposa de camps específics, com per exemple, Salutació, Títol, Nom, Adreça, Número de Telèfon. <br /><br />Utilitzi aquesta plantilla per a crear mòduls que són similars als mòduls estàndards de Contactes i Clients Potencials.',
            'type_sale' => 'El tipus de plantilla <b>Ventes</b> proporciona camps específics d&#39;una oportunitat, com la Presa de Contacte, Etapa, Quantitat i Probabilitat.<br/><br/>Utilitzi aquesta plantilla per crear mòduls que siguin similars al mòdul estàndar d&#39;Oportunitats.',
            'viewfieldsbtn' => 'Faci clic a <b>Veure Camps</b> per veure els camps associats amb el mòdul i crear i editar camps personalitzats.',
            'viewlayoutsbtn' => 'Faci clic a <b>Veure Dissenys</b> per a veure els dissenys d&#39;aquest mòdul i personalitzar la disposició dels camps dins dels dissenys.',
            'viewrelsbtn' => 'Faci clic a <b>Veure Relacions</b> per a veure les relacions associades amb aquest mòdul i crear noves relacions.',
        ),
        'dropdowns' => array(
            'default' => 'Totes les <b>Llistes Desplegables</b> de l&#39;aplicació es llisten a aquí.<br><br>Les llistes desplegables poden ser utilitzades per camps de llista desplegable de qualsevol mòdul.<br><br>Per a realitzar canvis a una llista desplegable existent, faci clic al seu nom.<br><br>Faci clic a <b>Afegir Desplegable</b> per crear un nou desplegable.',
            'editdropdown' => 'Les llistes desplegables poden ser utilitzades per camps desplegables estàndar o personaltizats de qualsevol mòdul.<br><br>Proporcioni un <b>Nom</b> per a la llista desplegable.<br><br>Si té instalat altres paquets d&#39;idioma a l&#39;aplicació, podrà seleccionar l&#39; <b>Idioma</b> a utilitzar per als elements de la llista.<br><br>En el camp <b>Nom d&#39;Element</b>, proporcioni un nom per a l&#39;opció a la llista desplegable.  Aquest nom no apareixerà a la llista desplegable que és visible als usuaris.<br><br>En el camp <b>Etiqueta de Visualizació</b>, proporcioni una etiqueta que serà visible als usuaris.<br><br>Després de  proporcionar el nom d&#39;element i l&#39;etiqueta de visualització, faci clic a <b>Afegir</b> per afegir l&#39;element a la llista desplegable.<br><br>Per canviar l&#39;ordre dels elements a la llista, arrossegui i deixi anar elements en les posicions desitjades.<br><br>Per editar l&#39;etiqueta de visualizació d&#39;un element, faci clic a l&#39;icona <b>Editar</b>, y introdueixi una nueva etiqueta. Per eliminar un element de la llista desplegable, faci clic a l&#39;icona <b>Eliminar</b>.<br><br>Per a desfer un canvi realitzat a una etiqueta de visualizació, faci clic a <b>Desfer</b>.  Per a refer un canvi que ha estat previament desfet, faci clic a <b>Refer</b>.<br><br>Faci clic a <b>Guardar</b> per a guardar la llista desplegable.',
        ),
        'subPanelEditor' => array(
            'Default' => 'Els camps <b>Per Defecte</b> apareixen al subpanell.',
            'Hidden' => 'Els camps <b>Ocults</b> no apareixen al subpanell.',
            'historyBtn' => 'Faci clic a <b>Veure Historial</b> per a veure i restaurar de l&#39;historial un disseny previament guardat.',
            'historyDefault' => 'Feu clic a <b> Restaura valors per defecte </b> per restaurar la vista al format original.',
            'modify' => 'Tots els camps que es poden mostrar al <b> subpanel </b> apareixen aquí. A el <b> per defecte </b> la columna conté els camps que es mostren en el subpanel. <br /> <br/> La columna <b> Ocult </b> conté els camps que es poden afegir a la columna per defecte.',
            'savebtn' => 'Feu clic a <b> Desa i Desplegar </b> per desar els canvis realitzats i perquè siguin actius dins del mòdul.',
        ),
        'listViewEditor' => array(
            'Available' => 'Camps <b>disponibles</b> no es mostren per defecte, però es poden afegir a ListViews pels usuaris.',
            'Default' => 'Els camps <b>per defecte</b> apareixen a les vistes de llista que no han estat personalitzades pels usuaris.',
            'Hidden' => 'Els camps <b>Ocults</b> no estan disponibles per a ser vistos per els usuaris en les Vistes de Llista.',
            'historyBtn' => 'Feu clic a <b> Mostra l\'historial </b> per veure i restaurar un disseny prèviament guardat de la història. <br> <B> Restaura </b> a <b> Mostra l\'historial </b> restaura la col·locació de camp dins dels dissenys guardats anteriorment. Per canviar les etiquetes de camp, feu clic a la icona edita al costat de cada camp.',
            'historyDefault' => 'Feu clic a <b> Restaura valors per defecte </ b> per restaurar la vista en el seu format original. <br> <B> Restaura valors per defecte </ b> només es restaura la col·locació de camp dins el traçat original. Per canviar les etiquetes de camp, feu clic a la icona Edita al costat de cada camp.',
            'modify' => 'Tots els camps que poden ser mostrats a la <b>Vista de Llista</b> apareixen aquí.<br><br>La columna <b>Per Defecte</b> conté els camps que son mostrats a la Vista de Llista per defecte.<br/><br/>La columna <b>Displonibles</b> conté els camps que un usuari pot seleccionar a la Receerca per crear una Vista de Llista personalitzada. <br/><br/>La columna <b>Ocults</b> mostra els camps que poden ser agregats a les columnes Per Defecte o Disponibles.',
            'savebtn' => 'Feu clic a <b> Desa i Desplegar </b> per desar els canvis realitzats i perquè siguin actius dins del mòdul.',
        ),
        'popupListViewEditor' => array(
            'Default' => 'Els camps <b>per defecte</b> apareixen a les vistes de llista que no han estat personalitzades pels usuaris.',
            'Hidden' => 'Camps <b> Ocults </b>no disponibles actualment per a que els usuaris els vegin en Vistes de Llistes.',
            'historyBtn' => 'Feu clic a <b> Mostra l\'historial </b> per veure i restaurar un disseny prèviament guardat de la història. <br> <B> Restaura </b> a <b> Mostra l\'historial </b> restaura la col·locació de camp dins dels dissenys guardats anteriorment. Per canviar les etiquetes de camp, feu clic a la icona edita al costat de cada camp.',
            'historyDefault' => 'Feu clic a <b> Restaura valors per defecte </b> per restaurar la vista en el seu format original.<br><br><b>Restaura valors per defecte </b> només es restaura la col·locació de camp dins el vista original. Per canviar les etiquetes de camp, feu clic a la icona Edita al costat de cada camp.',
            'modify' => 'Tots els camps que es poden visualitzar en la <b>ListView</b> apareixen aquí. <br><br>La columna <b>per defecte</b> conté els camps que es mostren a la ListView predeterminada. <br/> <br/> La columna <b>ocults</b> conté camps que es poden afegir a l\'omissió o columna disponible.',
            'savebtn' => 'Feu clic a <b> Desa i Desplegar </ b> per desar els canvis realitzats i perquè siguin actius dins del mòdul.',
        ),
        'searchViewEditor' => array(
            'Default' => 'Les files per <b>Defecte</b> apareixen a la cerca.',
            'Hidden' => 'Els camps <b>Ocults</b> no apareixen a la cerca.',
            'historyBtn' => 'Feu clic a <b> Mostra l\'historial </b> per veure i restaurar un disseny prèviament guardat de la història. <br> <B> Restaura </b> a <b> Mostra l\'historial </b> restaura la col·locació de camp dins dels dissenys guardats anteriorment. Per canviar les etiquetes de camp, feu clic a la icona edita al costat de cada camp.',
            'historyDefault' => 'Feu clic a <b> Restaura valors per defecte </b> per restaurar la vista en el seu format original.<br><br><b>Restaura valors per defecte </b> només es restaura la col·locació de camp dins el vista original. Per canviar les etiquetes de camp, feu clic a la icona Edita al costat de cada camp.',
            'modify' => 'Tots els camps que es poden mostrar al formulari <b>Filtre</b> apareixen aquí.<br><br> La columna <b>Per defecte</b>conté els camps que es mostraran al formulari de cerca.<br/><br/>La columna<b> ocults</b>conté camps disponibles per a vostè com a administrador per afegir al formulari de cerca.',
            'savebtn' => 'Clicant <b>Desar i Aplicar</b> els canvis seran actius',
        ),
        'layoutEditor' => array(
            'default' => 'L\'àrea de <b>disseny</b> conté els camps que es mostren actualment dins de <b>EditView</b>. <br/> <br/> La <b>caixa d\'eines</b> conté la <b>Paperera de reciclatge</b> i els camps i elements de presentació que es poden afegir a la disposició. <br><br>Fes canvis a la disposició per arrossegar i deixar anar elements i camps entre la <b>caixa d\'eines</b> i la <b>disposició</b> i dins la mateixa disposició. <br> <br>Per a eliminar un camp de la disposició, arrossegueu el camp a la <b>Paperera de reciclatge</b>. El camp serà disponible en la caixa d\'eines per afegir a la disposició.',
            'defaultdetailview' => 'L&#39;àrea de <b>Disseny</b> conté els camps que actualment estan sent mostrats a la <b>Vista de Detall</b>.<br/><br/>La <b>Caixa d&#39;Eines</b> conté la <b>Paperera de Reciclatge</b> i els camps i elements del disseny que poden ser agregats al mateix.<br><br>Faci canvis al disseny arrossegant i deixant anar  elements i camps entre la <b>Caixa d&#39;Eines</b> i el <b>Disseny</b> així com dins del mateix disseny.<br><br>Per a treure un camp del disseny, arrossegui el camp a la <b>Paperera de Reciclatge</b>. El camp passarà a estar disponible a la Caixa d&#39;Eines per ser afegit al disseny.',
            'defaultquickcreate' => 'L&#39;àrea de <b>Disseny</b> conté els camps que actualment estan éssent mostrats en el formulari de <b>Creació Ràpida</b>.<br><br>El formulari de Creació Ràpida apareix als  subpanells d&#39;un mòdul quan el botó Crear és pulsat.<br/><br/>La <b>Caixa d&#39;Eines</b> conté la <b>Paperera de Reciclatge</b> i els camps i elements del disseny que poden ser afegits al mateix.<br><br>Faci canvis al disseny arrossegant i Deixant anar elements i camps entre la <b>Caixa d&#39;Eines</b> i el <b>Disseny</b> així com dins del mateix disseny.<br><br>Per treure un camp del disseny, arrossegui el camp a la <b>Paperera de Reciclatge</b>. El camp passarà a estar disponible a la Caixa d&#39;Eines per a ser afegit al disseny.',
            'delete' => 'Arrossegui i deixi anar qualsevol element aquí per a treure&#39;l  del disseny',
            'historyBtn' => 'Feu clic a <b> Mostra l\'historial </b> per veure i restaurar un disseny prèviament guardat de la història. <br> <B> Restaura </b> a <b> Mostra l\'historial </b> restaura la col·locació de camp dins dels dissenys guardats anteriorment. Per canviar les etiquetes de camp, feu clic a la icona edita al costat de cada camp.',
            'historyDefault' => 'Feu clic a <b> Restaura valors per defecte </ b> per restaurar la vista en el seu format original. <br> <B> Restaura valors per defecte </ b> només es restaura la col·locació de camp dins el traçat original. Per canviar les etiquetes de camp, feu clic a la icona Edita al costat de cada camp.',
            'panels' => 'L&#39;àrea de <b>Disseny</b> proporciona una vista sobre com el disseny apareixerà al mòdul quan els canvis realitzats al disseny siguin desplegats.<br/><br/>Pot reposicionar camps, files i panells arrossegant-los i deixant-los anar  a la ubicació desitjada.<br/><br/>Tregui elements arrossegant-los i deixant-los anar a la <b>Paperera de Reciclatge</b> de la Caixa d&#39;Eines, o afegeixi nous elements i camps arrossegant-los de la <b>Caixa d&#39;Eines</b> i deixant-los anar a la ubicació desitjada del disseny.',
            'property' => 'Editi l&#39;etiqueta mostrada per aquest camp. <br/>El <b>Ordre de Tabulació</b> controla en quuin ordre la tecla tabulador canviarà el focus entre els diferents camps.',
            'publishBtn' => 'Cliqui <b>Desar i aplicar</b> per a desar tots els canvis que ha realitzat al disseny des de l\'últim cop que els va desar, i per a deixar actius els canvis al mòdul.<br><br>El disseny serà mostrat immediatament al mòdul.',
            'saveBtn' => 'Faci clic a <b>Desar</b> per a preservar els canvis que ha realitzat al disseny des de l\'última vegada que el va desar.<br><br>Els canvis no es mostraran al mòdul fins que apliqui els canvis desats.',
            'toolbox' => 'La <b>Caixa d&#39;Eines</b> conté la <b>Paperera de Reciclatge</b>, elements de disseny adicionals i el conjunt de camps disponibles per a ser afegits al disseny.<br/><br/>Els elements de disseny i els camps de la Caixa d&#39;Eines poden ser arrossegats i deixats anar en el disseny, y els elements de disseny i els camps poden ser arrossegats i deixats anar del disseny a la Caixa d&#39;Eines.<br><br>Els elements de disseny son <b>Panells</b> i <b>Files</b>. Agregant una nova fila o un nou panell al disseny proporciona ubicacions adicionals al disseny per als camps.<br/><br/>Arrossegui i deixi qualsevol camp a la Caixa d&#39;Eines o en el disseny a una posició de camp ocupada per a intercanviar les ubicacions dels dos camps.<br/><br/>El camp de <b>Farcit</b> crea espai buit en el disseny allà  on és colocat.',
        ),
        'fieldsEditor' => array(
            'addField' => 'Seleccioni un <b>Tipus de Dades</b> per el nou camp. El tipus que seleccioni determinarà quin tipus de caràcters poden introduir-se per el camp. Per exemple, només es podran introduir números sencers en camps que son del tipus de dades Senceres.<br><br> Provi al camp d&#39;un <b>Nom</b>.  El nom he de ser alfanumèric i no contenir espais. El caràcter subratllat també és vàlid.<br><br> L&#39; <b>Etiqueta de Visualizació</b> és l&#39;etiqueta que apareixerà per als camps en els dissenys de mòduls.  L&#39; <b>Etiqueta del Sistema</b> s&#39;utiltza per a fer referència al camp al codi.<br><br> Segons el tipus de dades seleccionades per al camp, algunes o totes les següents propietats podran ser establertes en el mateix:<br><br> El <b>Text d&#39;Ajuda</b> apareix temporalment quan l&#39;usuari manté el cursor sobre el camp i pot ser utilitzat per indicar a l&#39;usuari el tipus d&#39;entrada desitjada.<br><br> El <b>Text de Comentari</b> només es veu a l&#39;Estudi i/o Constructor de Mòduls, i pot ser utilitzat per a descriure el camp als administradors.<br><br> El <b>Valor per Defecte</b> que apareixerà en el camp.  Els usuaris poden introduir un nou valor  al camp o deixar el valor predeterminat.<br><br> Seleccioni l&#39;opció d&#39;<b>Actualització Massiva</b> per poder utilitzar la característica d&#39;Actualizació Massiva al camp.<br><br>El valor del <b>Tamany Màxim</b> determina el màxim número de caràcters que poden ser introduits al camp.<br><br> Seleccioni l&#39;opció <b>Camp Requerit</b> per a fer el camp requerit. Ha de suministrar-se un valor per aquest camp per poder guardar un registre que el contingui.<br><br> Seleccioni l&#39;opció <b>Informable</b> per a permetre que el camp sigui utilitzat en filtres y per mostrar dades en Informes.<br><br> Seleccioni l&#39;opció <b>Auditar</b> per poder realitzar un seguiment dels canvis el camp en el Registre de Canvis.<br><br>Seleccioni una de les opcions en el camp <b>Importable</b> per a permetre, prohibir o requerir que el camp sigui importat mitjançant l&#39;Assistent d&#39;Importació.<br><br>Seleccioni una opció al camp <b>Combinar Duplicats</b> per habilitar o no les característiques de Combinar Duplicats i Recerca de Duplicatss.<br><br>Per certs tipus de dsdes es podran establir propietats adicionals.',
            'default' => 'Els <b>Camps</b> disponibles per a un mòdul es llisten aquí per Nom de Camp.<br><br>Els camps personalitzats creatss pel mòdul aparreixen sobre els camps disponibles pel mòdul per defecte.<br><br>Per editar un camp, faci clic al <b>Nom de Camp</b>.<br/><br/>Per a crear un noe camp, faci clic a <b>Afegir Camp</b>.',
            'editField' => 'Les propietats d&#39;aquest camp poden  ser personalitzades.<br><br>Faci clic a <b>Clonar</b> per crear un nou camp amb les mateixes propietats.',
            'mbDefault' => 'Els <b>Camps</b> disponibles per un mòdul es llisten aquí per Nom de Camp.<br><br>Per personalitzar l&#39;etiqueta del camp plantilla, faci clic al Nom de Camp.<br><br>Per a crear un nou camp, faci clic a <b>Afegir Camp</b>. L&#39;etiqueta i la resta de propietats del nou camp poden ser editades després de la seva creació fent clic al Nom de Camp.<br><br>Després del desplegament del mòdul, els nous camps creats amb el Constructor de Mòduls seran tractats com camps estandar del mòdul desplegat a l&#39;Estudi.',
            'mbeditField' => 'L&#39;<b>Etiqueta de Visualizació</b> d&#39;un camp de Sugar pot ser personalitzada. La resta de propietats del camp no poden ser personaltzades.<br><br>Faci clic a <b>Clonar</b> per crear un nou camp amb les mateixes propietats.<br><br>Per treure un camp plantilla de manera que no apareixi al mòdul, tregui el camp dels <b>Dissenys</b> corresponents.',
        ),
        'exportcustom' => array(
            'author' => 'Aquest és <b>l\'Autor</b> que és mostrat durant la instal·lació com el nom de la entitat que ha creat el paquet. L\'autor pot ser una companyia o una persona individual.',
            'description' => 'Aquesta és la <b>Descripció</b> del paquet mostrada durant la instal·lació.',
            'exportCustomBtn' => 'Faci clic a <b>Exportar</b> per crear un arxiu .zip per el paquet que contingui les personalitzacions que desitja exportar.',
            'exportHelp' => 'Exporta les personalitzacions fetes en estudi per construir alguns paquets que es poden carregar en una altra instància de SuiteCRM mitjançant el <b>Module Loader</b>. <br><br>Primer, proporcionar un <b>Nom del paquet</b>.  Vostè pot proporcionar informació <b>autor</b> i <b>Descripció</b> de paquet, així. <br><br>Selecciona els mòduls que contenen les personalitzacions que voleu exportar.Només apareixeran per ser  seleccionats els mòduls  que contenen les personalitzacions . <br><br>Llavors fes clic <b>d\'exportació</b> per crear un fitxer. zip paquet que contenen les personalitzacions.',
            'name' => 'Aquest és el <b>Nom</b> del paquet. Aquest nom serà mostrat durant la instal·lació.',
        ),
        'studioWizard' => array(
            'addDropDownBtn' => 'Afegir una nova Llista Desplegable global',
            'addLayoutHelp' => "Per crear un disseny personalitzat per a un grup de seguretat, seleccioneu el grup de seguretat adequat i el disseny del qual voleu partir.",
            'AdvancedSearchBtn' => 'Modifiqueu el formulari de <b>Filtre avançat</b> que apareix a la pestanya de Filtre avançat en l\'àrea per al Filtrat al mòdul.',
            'appBtn' => 'La manera  d&#39;aplicació li permet personalitzar vàries propietats del programa, com per exemple, quants informes es mostren a la pàgina d&#39;inici',
            'backBtn' => 'Tornar al pas previ.',
            'BasicSearchBtn' => 'Modifiqueu el formulari de <b>Filtre Ràpid</b> que apareix a la pestanya de Filtre Ràpid en l\'àrea per al Filtrat al mòdul.',
            'convertLeadHelp' => 'Aquí podeu afegir mòduls per a la disposició de convertir la pantalla i modificar els dissenys existents. <br/> Pot reordenar els mòduls arrossegant les seves files a la taula. <br/><br/><b> Mòdul: </b> El nom del mòdul. <br/> <br/><b> Requerit: </b> Els mòduls requerits han de ser creats o seleccionats abans que el plom es pot convertir. <br/><br/> <b> Copiar dades: </b> Si està activat, els camps de la iniciativa es copiaran a camps amb el mateix nom en els registres acabats de crear. <br/><br/> <b> Permetre la selecció: </b> Els Mòduls amb un camp de relació en els contactes poden ser seleccionats en lloc de creats durant el procés de convertir plom. <br/> <br/> <b> Edició: </b> Modificar el disseny de convertir per a aquest mòdul. <br/> <br/> <b> Esborrar: </b> Eliminar aquest mòdul de la disposició de convertir. <br/> <br/>',
            'dashletHelp' => 'Les disposicions <b>SuiteCRM Dashlet</b> que es poden personalitzar apareixen aquí. <br><br>El SuiteCRM Dashlet estarà disponible per afegir a les pàgines del mòdul de casa.',
            'DashletListViewBtn' => 'El <b>SuiteCRM Dashlet ListView</b> Mostra registres basats en els filtres de cerca de SuiteCRM Dashlet.',
            'DashletSearchViewBtn' => 'El <b>SuiteCRM Dashlet cerca</b> filtres registrats per la listview de SuiteCRM Dashlet.',
            'dropDownEditorBtn' => 'Utilitzi l&#39; <b>Editor de Llistes Desplegables</b> per agregar i editar llistes desplegables globals per a camps de llista desplegable.',
            'editDropDownBtn' => 'Editar una Llista Desplegable global',
            'exportBtn' => 'Faci clic a <b>Exportar Personalitzacions</b> per crear i descarregar un paquet que contingui les personalitzacions que ha realitzat en l&#39;Estudi a varis mòduls específics.',
            'fieldsBtn' => 'Crear i personalitzar els <b>Camps</b> que emmagatzemen la informació al mòdul.',
            'labelsBtn' => 'Editar les <b>Etiquetes</b> mostrades per els camps i altres títols del mòdul.',
            'Layouts' => 'Personalitzeu els <b> Dissenys </b> dels mòduls del Portal de SuiteCRM.',
            'layoutsBtn' => 'Personalitzar els <b>Dissenys</b> del mòdul.  Els dissenys son les diferents vistes del mòdul que contenen camps.<br><br>Pot establir quins camps apareixen i com son organitzats a cada disseny.',
            'layoutsHelp' => 'Els <b>Dissenys</b> d&#39;un mòdul que poden ser personalitzats apareixen aquí.<br><br>Els dissenys mostren els camps i les seve dades.<br><br>Faci clic a una icona per a seleccionar el disseny a editar.',
            'mainHelp' => 'Benvingut a l&#39;àrea d&#39;<b>Eines de Desenvolupament</b>. <br/><br/>Utilitzi les einess d&#39;aquesta àrea per crear i gestionar mòduls i camps tan estàndar com personalitzats.',
            'mbBtn' => 'Utilitzi el <b>Constructor de Mòduls</b> per crear nous mòduls.',
            'mbHelp' => 'Utilitzi el <b>Constructor de Mòduls</b> per crear paquets que continguin mòduls personalitzats basats en objectes estàndar o personalitzats.',
            'moduleBtn' => 'Faci clic per editar aquest modul.',
            'moduleHelp' => 'Els components del mòdul que pot personalitzar apareixen aquí.<br><br>Faci clic a una icona per seleccionar el component a editar.',
            'newPackage' => 'Faci clic a <b>Nou Paquet</b> per crear un nou paquet.',
            'popupHelp' => 'Els dissenys de <b>Finestres emergents</ b> que es poden personalitzar apareixen aquí.<br>',
            'PopupListViewBtn' => 'El <b>Desplegable ListView</b> Mostra registres basats en les vistes de recerca emergent.',
            'PopupSearchViewBtn' => 'La <b>Cerca emergent</b> mostra la visualització de les llistes emergents.',
            'portalBtn' => 'Personalitzar el mòdul <b>Dissenys</b> que apareix al <b>Portal de SuiteCRM</b>.',
            'portalHelp' => 'Gestionar i personalitzar el <b>Portal de SuiteCRM</b>.',
            'portalLayoutHelp' => 'Els mòduls dins del Portal SuiteCRM apareixen en aquesta àrea..<br><br> Seleccioneu un mòdul per editar els <b>Dissenys</ b>.',
            'relationshipHelp' => 'Les <b>Relacions</b> poden ser creades entre el mòdul i altre mòdul personalitzat o desplegat.<br><br> Les relacions s&#39;expressen visualment a través de subpanells i relacionen camps dels registres del mòdul.<br><br>Seleccioni un dels següents <b>Tipus</b> de relació per el mòdul:<br><br> <b>Un-a-Un</b> - Els registres d&#39;ambdós mòduls contindran camps relacionats.<br><br> <b>Un-a-Molts</b> - Els registrs del Mòdul Principal contindran un subpanell, i els registres del Mòdul Relacionat contindran un camp relacionat.<br><br> <b>Molts-a-Molts</b> - Els registrs d&#39;ambdós mòduls mostraran subpanells.<br><br> Seleccioni el <b>Mòdul Relacionat</b> per la relació. <br><br>Si el tipus de relació implica l&#39;ús de subpanells, seleccioni la vista de subpanell per als mòduls corresponents.<br><br> Faci clic a <b>Guardar</b> per crear la relació.',
            'relationshipsBtn' => 'Afegir noves <b>Relacions</b> del mòdul o veure les existents.',
            'relationshipsHelp' => 'Totes les <b>Relacions</b> que existeixen entre el mòdul i altres mòduls desplegats apareixen aquí.<br><br>El <b>Nom</b> de la relació és un nom generat per el sistema per la relació.<br><br>El <b>Mòdul Principal</b> és el mòdul que poseeix les relacions.  Per exemple, totes les propietats de les relacions per les que el mòdul de Comptes és el mòdul principal s&#39;emmagatzemen a les taules de base de dades de Comptes.<br><br>El <b>Tipus</b> és el tipus de relació existent entre el Mòdul Principal i el <b>Mòdul Relacionat</b>.<br><br>Faci clic al títol d&#39;una columna per ordenar per la columna.<br><br>Faci clic a una fila de la taula de la relació per veure i editar les propietats associades amb la relació.<br><br>Faci clic a <b>Agregar Relació</b> per crear una nova relació.<br><br>Es poden crear relacions entre dos mòduls desplegats qualssevol.',
            'searchBtn' => 'Personalitzar els dissenys de <b>Recerca</b> del mòdul.<br><br>Determina quins camps poden ser utilitzats per a filtrar els registres que apareixen a la Vista de Llista.',
            'searchHelp' => 'Els formularis de <b>Filtre</b> que poden ser personalitzats apareixen aquí. <br><br> Els formularis de Filtres contenen camps per filtrar registres. <br><br> Fes clic en un icona per seleccionar el disseny de filtre a editar.',
            'SPSync' => 'Personalitzacions de <b>sincronització</b> a la instància del SuiteCRM Portal.',
            'SPUploadCSS' => 'Puja a <b> Full d\'estil </b> per al Portal SuiteCRM.',
            'studioBtn' => 'Utilitzi l&#39; <b>Estudi</b> per personalitzar els mòduls desplegats.',
            'studioHelp' => 'Utilitzi l&#39;<b>Estudi</b> per establir quina informació del mòdul es mostra i com ho fa.',
            'subpanelBtn' => 'Determina quins camps apareixen als <b>Subpanells</b> del mòdul.',
            'subpanelHelp' => 'Els <b>Subpanells</b> d&#39;un mòdul que poden ser personalitzats apareixen aquí.<br><br>Faci clic a una icona per seleccionar el mòdul a editar.',
            'sugarPortalBtn' => 'Utilitzi <b>L\'editor del portal SuiteCRM</b> per a gestionar i personalitzar el portal de SuiteCRM.',
            'viewBtnDashlet' => 'Personalitzar <b>SuiteCRM Dashlet</b>, incloent-hi el SuiteCRM Dashlet ListView i cerca del mòdul. <br><br>El SuiteCRM Dashlet estarà disponible per afegir a les pàgines del mòdul de casa.',
            'viewBtnDetailView' => 'Personalitzar el disseny <b>Vista de Detall</b> del mòdul.<br><br>La Vista de Detall mostra dades de camps introduits per l&#39;usuari.',
            'viewBtnEditView' => 'Personalitzar el disseny de <b>Vista d&#39;Edició</b> del mòdul.<br><br>La Vista d&#39;Edició és el formulari que conté els camps d&#39;entrada per capturar les dades introduides per l&#39;usuari.',
            'viewBtnListView' => 'Personalitzar el disseny <b>Vista de Llista</b> del mòdul<br><br>Els resultats de la Recerca apareixen a la Vista de Llista.',
            'viewBtnQuickCreate' => 'Personalitzar el disseny <b>Creació ràpida</b> de mòdul.<br><br>El formulari de creació ràpida apareix als subpanells i en el mòdul de correu electrònic.',
        ),
        'fieldsHelp' => array(
            'default' => 'Els <b> Camps </b> del mòdul apareixen aquí llistats per Nom de Camp.<br><br>La plantilla del mòdul inclou un conjunt predeterminat de camps. <br><br> Per crear un nou camp, feu clic a <b> Afegeix camp </b>.<br><br> Per editar un camp, feu clic al <b> Nom de camp </b>.<br/><br/> Després de la implantació del mòdul, els nous camps creats en el Constructor de mòduls, així com els camps de la plantilla, es tractaran com a camps estàndard en l\'Estudi.',
        ),
        'relationshipsHelp' => array(
            'addRelationship' => 'Las <b>Relaciones</b> pueden ser creadas entre el módulo y otro módulo personalizado o desplegado.<br><br> Las relaciones se expresan visualmente a través de subpaneles y relacionan campos de los registros del módulo.<br><br>Seleccione uno de los siguientes <b>Tipos</b> de relación para el módulo:<br><br> <b>Uno-a-Uno</b> - Los registros de ambos módulos contendrán campos relacionados.<br><br> <b>Uno-a-Muchos</b> - Los registros del Módulo Principal contendrán un subpanel, y los registros del Módulo Relacionado contendrán un campo relacionado.<br><br> <b>Muchos-a-Muchos</b> - Los registros de ambos módulos mostrarán subpaneles.<br><br> Seleccione el <b>Módulo Relacionado</b> para la relación. <br><br>Si el tipo de relación implica el uso de subpaneles, seleccione la vista de subpanel para los módulos correspondientes.<br><br> Haga clic en <b>Guardar</b> para crear la relación.',
            'addrelbtn' => 'Moveu el ratolí fora de l\'ajuda per afegir relació...',
            'default' => 'Les <b>Relacions</b> que han estat creades entre el mòdul i altres mòduls apareixen aquí.<br><br>El <b>Nom</b> de la relació és un nom generat per el sistema per la relació.<br><br>El <b>Mòdul Principal</b> és el mòdul que poseeix les relacions. Les propietats de la relació son guardades en taules de la base de dades pertanyents al mòdul primari.<br><br>El <b>Tipus</b> és el tipus de relació existent entre el Mòdul Principal i el <b>Mòdul Relacionat</b>.<br><br>Faci clic al títol d&#39;una columna per ordenar per la columna.<br><br>Faci clic a una fila de la taula de la relació per veure i editar les propietats associades amb la relació.<br><br>Faci clic a <b>Afegir Relació</b> per crear una nova relació.',
        ),
        'labelsHelp' => array(
            'default' => 'Les <b>Etiquetes</b> per tots els camps i altres títols en el mòdul es poden canviar. <br><br>Pot editar l\'etiqueta fent clic en l\'àmbit, introduint un nou segell i fent clic a <b>salvar</b>. <br> <br>A qualsevol paquet d\'idioma instal·lat en l\'aplicació, podeu seleccionar l\' <b>idioma</b> a utilitzar per a les etiquetes.',
            'saveBtn' => 'Cliqui <b>Desar</b> per desar tots els canvis.',
            'publishBtn' => 'Feu clic a <b>Desa i Desplegar</b> per guardar tots els canvis i fer que s\'activin.',
        ),
        'portalSync' => array(
            'default' => 'Introduïu l\' <b>URL de Portal SuiteCRM</b> de la instància del portal a actualitzar, i cliqueu a <b>anar</b>. <br><br>A continuació, introduïu un nom d\'usuari SuiteCRM vàlid i contrasenya, i feu clic a <b>Començar sincronització</b>. <br> <br>Les personalitzacions fetes al SuiteCRM Portal <b>disposicions</b>, juntament amb el <b>Full d\'estil</b> si un va ser pujat, es transferiran a especificar la instància del portal.',
        ),
        'portalStyle' => array(
            'default' => 'Vostè pot personalitzar l\'aspecte del Portal SuiteCRM mitjançant l\'ús d\'un full d\'estil. <br><br> Seleccioneu una <b> Full d\'estil </b> per a carregar. <br> El full d\'estil es durà a terme al Portal SuiteCRM la propera alhora una sincronització es porta a terme.',
        ),
    ),

    'assistantHelp' => array(
        'package' => array(
            'afterSave' => 'El seu nou paquet ha de contenir com a mínim un mòdul. Vostè pot crear un o més mòduls personalitzats per al paquet. <br/><br/> Feu clic a <b> Nou Mòdul </b> per crear un mòdul personalitzat per a aquest paquet. <br/><br/> Després de crear com a mínim un mòdul, pot publicar o desplegar en el paquet per fer-ho disponible a la seva instància i / o d\'altres instàncies d\'usuaris. <br/><br/> Per desplegar el paquet en un pas dins del seu instància de SuiteCRM, feu clic a <b> Desplegar </ b>. qual Feu clic a <b> Publica </b> per guardar el paquet com un arxiu .zip. Després l\'arxiu .Zip es guarda en el sistema, utilitzeu el <b> Mòdul de Càrrega </b> per Puja i instal·lar el paquet en la instància de SuiteCRM. <br/><br/> Pot distribuir l\'arxiu a altres usuaris per carregar i instal·lar dins de les seves pròpies instàncies de SuiteCRM.',
            'create' => 'Un <b>paquet </b> actua com un contenidor de mòduls personalitzats, que són part d\'un projecte. El paquet pot contenir un o més <b> mòduls </b> personalitzats, que poden estar relacionats entre si o amb altres mòduls en l\'aplicació. <br/><br/> Després de crear un paquet per al seu projecte, vostè pot crear Mòduls dels paquets immediatament, o pot tornar a la Constructor de mòduls en un altre moment per completar el projecte.',
            'nopackages' => 'Per començar un projecte, faci clic a <b>Nou Paquet</b> i crearà un nou paquet en el que allotjar els seus mòduls personalitzats. <br/><br/>Cada paquet pot contenir un o més mòduls.<br/><br/>Per exemple, pot voler crear un paquet que contingui un mòdul personalitzat relacionat amb el mòdul estàndar de Comptes. O pot voler crear un paquet que contingui varis mòduls nous que treballen de manera conjunta com un projecte i que estan relacionats entre sí i amb altres mòduls ja existents a l&#39;aplicació.',
            'somepackages' => 'Un <b>paquet</b> actúa com contenidor de mòduls pesonalitzats, tots els quals son part d&#39;un projecte. El paquet pot contenir un o més <b>mòduls</b> personalitzats que poden estar relacionats entre ells o amb d&#39;atres mòduls de l&#39;aplicació.<br/><br/>Després de  la creació d&#39;un paquet per el seu projecte, pot crear mòduls per el paquet de manera inmediata, o tornar al Constructor de Mòduls més tard per completar el projecte.<br><br>Quan el projecte ha estat completat, pot <b>Desplegar</b> el paquet per instal·lar els mòduls personalitzats dind de l&#39;aplicació.',
        ),
        'main' => array(
            'studioWelcome' => 'Tots els mòduls actualment instal·lats, incloent els objectes estàndars així com els carregats per un mòdul, son personalitzables dins de l&#39;Estudi.',
            'welcome' => 'Utilitzi les <b>Eines de Desenvolupament</b> per crear i administrar mòduls i camps tant estàndar com personalitzats. <br/><br/>Per administrar els mòduls de l&#39;aplicació, faci clic a <b>Estudi</b>. <br/><br/>Per crear mòduls personalitzats, faci clic a <b>Constructor de Mòduls</b>.',
        ),
        'module' => array(
            'afterSave' => 'Personalitzeu el mòdul segons les vostres necessitats editant i creant camps, establint relacions amb altres mòduls i organitzant els camps dels dissenys. <br/> <br/> Per veure els camps de la plantilla i gestionar els camps personalitzats dins del mòdul, feu clic a <b > Veure camps </ b>. <br/> <br/> Per crear i gestionar les relacions entre el mòdul i altres mòduls, ja siguin mòduls ja a l\'aplicació o altres mòduls personalitzats del mateix paquet, feu clic a <b> Veure relacions < / b>. <br/> <br/> Per editar els dissenys del mòdul, feu clic a <b> Mostra dissenys </ b>. Podeu canviar la vista de detall, editar vista i visualitzar la llista de dissenys del mòdul tal com ho faria en els mòduls ja en l\'aplicació de Studio. <br/> <br/> Per crear un mòdul amb les mateixes propietats que el mòdul actual, feu clic a <b> Duplicar </ b>. Podeu personalitzar encara més el nou mòdul.',
            'create' => 'Hora d\'escollir el tipus de <b>tipus</b> de mòdul que voleu crear, tingueu en compte els tipus de camps que li agradaria tenir del mòdul. <br/> <br/> Cada mòdul plantilla conté un conjunt de camps a pertanyent al tipus de mòdul descrit pel títol. <br/> <br/> <b>Bàsic</b> - proporciona camps bàsics que apareixen en mòduls estàndards, com ara el nom, ASSIGN a, equip, data de creació i Descripció camps. <br/> <br/> <b>Empresa</b> - proporciona organització específica camps, com ara nom empresa, indústria i adreça de facturació. Utilitzeu aquesta plantilla per crear mòduls que són similars al mòdul estàndard comptes. <br/> <br/> <b>Persona</b> - proporciona camps individual específica, com la salutació, títol, nom, adreça i número de telèfon. Utilitzeu aquesta plantilla per crear mòduls que són similars als mòduls contactes i clients potencials estàndard. <br/> <br/> <b>Tema</b> - proporciona camps cas i error-específiques, com ara nombre, estatus, prioritat i descripció. Utilitzeu aquesta plantilla per crear mòduls que són similars als mòduls casos i errors estàndard. <br/> <br/> Nota: Després de crear el mòdul, vostè pot editar les etiquetes dels camps proporcionats per la plantilla, així com crear camps personalitzats per afegir a les disposicions de mòdul.',
            'editView' => 'Aquí pot editar els camps existents. Pot teure qualsevol dels camps existents o afegir els camps disponibles al panell situat a l&#39;esquerra.',
            'existingModule' => 'Després de crear i personalitzar aquest mòdul, pot crear mòduls adicionals o tornar al paquet per <b>Publicar</b> o <b>Desplegar</b> el mateix.<br><br>Si desitja crear mòduls addicionals, faci clic a <b>Duplicar</b> per crear un mòdul amb les mateixess propietats que el mòdul actual, o torni a navegar al paquet i faci clic a <b>Nou Mòdul</b>.<br><br> Si ja està llest per <b>Publicar</b> o <b>Desplegar</b> el paquet que conté aquest mòdul, torni a navegar al paquet per a realitzar aquestes funcions. Pot publicar i desplegar paquets que continguin almenys un mòdul.',
            'labels' => 'Les etiquetes dels camps estàndar així com les dels camps personalitzats poden ser canviades. Els canvis a les etiquetes dels camps no afecta a les dades emmagatzemades en els mateixos.',
            'somemodules' => "Atès que l'actual paquet conté almenys un mòdul, pot <b>Desplegar</b> els mòduls en el paquet dins de la instància de SuiteCRM o<b>Publicar</b> el paquet que s'instal·larà a l'actual instància de SuiteCRM o una altra Instància utilitzant el <b>Mòdul de Càrrega</b>.<br/><br/>Per instal·lar el paquet directament dins del seu instància de SuiteCRM, feu clic a <b>Desplegar</b>.<br><br>Per crear una arxiu. zip de el paquet que pot ser carregat i instal lat dins de la instància actual de SuiteCRM i altres casos utilitzant el <b>Mòdul de Càrrega</b>,feu clic a <b>Publicar</b>.<br/><br/>Vostè pot construir els mòduls d'aquest paquet en etapes, i publicar o desplegar quan estigui a punt per fer-ho.<br/><br/>Després de la publicació o el desplegament d'un paquet, pot fer canvis en el conjunt de propietats i personalitzar els mòduls més. Després tornarà a re-publicar o re-desplegar el paquet per aplicar els canvis.",
            'viewfields' => 'Els camps del mòdul poden ser personalitzats per ajustar-se a les seves necessitats.<br/><br/>No pot eliminar camps estàndar, però pot treure&#39;ls dels dissenys corresponents dins de les pàgines de Dissenys. <br/><br/>Pot editar les etiquetes dels camps estàndar. La resta de propietats dels camps estàndar no son editables. No obstant, pot crear facilment nous camps que tinguin propietats similars fent clic al nom d&#39;un camp i després en <b>Clonar</b> dins del formulari de <b>Propietats</b>.  Introdueixi qualsevol propietat nova, i faci clic a <b>Guardar</b>.<br/><br/>Si està personalitzant un nou mòdul, una vegada aquest hagi estat instal·lat, no totes les propietats dels camps podran ser editades.  Estableixi totes les propietats per els camps estàndar i personalitzats abans que publiqui i instali el paquet que conté el mòdul personalitzat.',
            'viewlayouts' => 'Pot controlar quins mòduls estan disponibles per captura de dades des de la <b>Vista d&#39;Edició</b>.  També pot controlar quines dades son mostrades des de la <b>Vista de Detall</b>.  Les vistes no han de ser iguals. <br/><br/>El formulari de Creació Ràpida es mostra quan fa clic a <b>Crear</b> dins del subpanell d&#39;un mòdul. Per defecte, el disseny del formulari de <b>Creació Ràpida</b> és el mateix que el disseny per defecte de <b>Vista d&#39;Edició</b>. Pot personalitzar el formulari de Creació Ràpida de manera que contingui menys i/o diferents camps que el disseny de Vista d&#39;Edició. <br><br>Pot establir la seguretat del mòdul utilizant la personalització del Disseny conjuntament amb l&#39;<b>Administració de Rols</b>.<br><br>',
            'viewrelationships' => 'Pot crear relacions molts-a-molts entre el mòdul actual i qualsevol altre mòdul del paquet, i/o entre el mòdul actual i altres mòduls ja instalats a l&#39;aplicació.<br><br> Per crear relacions un-a-molts i un-a-un, creei camps <b>Relatiu a</b> y <b>Possiblement Relatiu a</b> per els mòduls.',
        ),
        'listViewEditor' => array(
            'modify' => 'A continuació es mostren tres columnes. La columna "Per defecte" conté els camps que es mostren en una llista per defecte, la columna "Addicional" conté camps que un usuari pot elegir a l\'hora de crear una vista personalitzada, i la columna "Disponible" mostra columnes disponibles per a vostè com a administrador per a, o bé afegir-les a les columnes per defecte, o a les addicionals perquè siguin usades per usuaris ja que actualment no estan sent utilitzades.',
            'savebtn' => 'Clicant <b>Desar</b> es desaran tots els canvis i es faran efectius.',
            'Hidden' => 'Camps ocults són camps que no estan disponibles actualment per als usuaris per al seu ús en les vistes de llista.',
            'Available' => 'Els camps disponibles són camps que no es mostren per defecte, però es poden activar pels usuaris.',
            'Default' => 'Camps per defecte apareixen als usuaris que no han creat configuració de la vista de llista personalitzat.'
        ),
        'searchViewEditor' => array(
            'modify' => 'Hi ha dues columnes que es mostren a l\'esquerra. La columna d "Omissió" conté els camps que es mostraran a la visualització de cerca, i la columna "Oculta" conté camps disponibles per a vostè com un administrador per afegir a la vista.',
            'savebtn' => 'En fer clic a <b> Desa i Desplegar </b> guardar tots els canvis i fer que s\'activa.',
            'Hidden' => 'Camps ocults són camps que no es mostren a la vista de cerca.',
            'Default' => 'Camps predeterminats es mostraran a la vista de cerca.'
        ),
        'layoutEditor' => array(
            'default' => 'Hi ha dues columnes que es mostren a l\'esquerra. La columna de la dreta, anomenada Disseny actual o Vista preliminar, és on canvia el disseny del mòdul. La columna de l\'esquerra, titulada Toolbox, conté elements i eines útils per a l\'ús al editar el disseny. <br/> <br/> Si l\'àrea de disseny es diu Presentació actual, esteu treballant en una còpia del disseny que utilitza actualment el mòdul per mostrar. <br/> <br/> Si es titula Vista prèvia de disseny, llavors estan treballant en una còpia creada anteriorment mitjançant un clic al botó Desa, que ja podria haver estat modificat a partir de la versió que veuen els usuaris d\'aquest mòdul.',
            'saveBtn' => 'Si feu clic a aquest botó guarda la disposició de manera que pot conservar els canvis. Quan torneu a aquest mòdul es començarà des d\'aquesta disposició canviada. El seu disseny, no pot ser vist pels usuaris del mòdul fins que faci clic a salvar i publicar botó.',
            'publishBtn' => 'Feu clic a aquest botó per desplegar la disposició. Això significa que aquesta disposició serà immediatament vista pels usuaris d\'aquest mòdul.',
            'toolbox' => 'La caixa d\'eines conté una varietat de característiques útils per als dissenys d\'edició, incloent una àrea d\'escombraries, un conjunt d\'elements addicionals i un conjunt de camps disponibles. Qualsevol d\'ells pot arrossegar i deixar anar en el disseny.',
            'panels' => 'Aquesta àrea mostra com es visualitzarà el vostre disseny als usuaris d\'aquest mòdul quan no estigui desplegat. <br/> <br/> Podeu reposicionar elements com ara camps, files i panells arrossegant-los i deixant-los anar; elimineu elements arrossegant-los i deixant-los caure a l\'àrea de la paperera a la caixa d\'eines o afegiu-ne de nous arrossegant-los des de la caixa d\'eines i deixant-los anar al disseny en la posició desitjada.'
        ),
        'dropdownEditor' => array(
            'default' => 'Hi ha dues columnes que es mostren a l\'esquerra. La columna de la dreta, anomenada Disseny actual o Vista preliminar, és on canvia el disseny del mòdul. La columna de l\'esquerra, titulada Toolbox, conté elements i eines útils per a l\'ús al editar el disseny. <br/> <br/> Si l\'àrea de disseny es diu Presentació actual, esteu treballant en una còpia del disseny que utilitza actualment el mòdul per mostrar. <br/> <br/> Si es titula Vista prèvia de disseny, llavors estan treballant en una còpia creada anteriorment mitjançant un clic al botó Desa, que ja podria haver estat modificat a partir de la versió que veuen els usuaris d\'aquest mòdul.',
            'dropdownaddbtn' => 'Fent clic a aquest botó s&#39;afegeix un nou element a la llista desplegable.',
        ),
        'exportcustom' => array(
            'author' => 'L\'<b>Autor</b> és el nom de l\'entitat que ha creat el paquet. Pot ser un individu o una empresa.<br>L\'Autor es mostrarà en el mòdul carregador després que el paquet es carrega per a la instal·lació en estudi.',
            'description' => 'La <b>Descripció</b> del paquet es mostrarà en el mòdul carregador després que el paquet es carrega per a la instal·lació en Estudi.',
            'exportCustomBtn' => 'Faci clic a <b>Exportar</b> per crear un arxiu .zip per el paquet que contingui les personalitzacions que desitja exportar.',
            'exportHelp' => 'Les personalitzacions fetes a l\'estudi en aquest cas pot ser envasats i desplegat en un altre cas. <br><br>Proporcionar un <b>Nom del paquet</b>. Vostè pot proporcionar informació <b>d\'autor</b> i <b>Descripció</b> per paquet. <br><br>Seleccioneu el module(s) que contenen les personalitzacions que voleu exportar. (Només mòduls que contenen les personalitzacions apareixerà per seleccionar). <br><br>Clic <b>exportar</b> per crear un fitxer. zip paquet que contenen les personalitzacions. El fitxer. zip es poden carregar en un altre cas mitjançant <b>Module Loader</b>.',
            'name' => 'El <b>Nom</b> del paquet es mostrarà en el mòdul carregador després que el paquet es carrega per a la instal·lació en estudi.',
        ),
        'studioWizard' => array(
            'appBtn' => 'Utilitzeu la manera d\'aplicació per personalitzar les diferents propietats del programa, com quants es mostren els informes de TPS a la pàgina principal.',
            'backBtn' => 'Tornar al pas previ.',
            'exportBtn' => 'Cliqui <b>Exportar personalitzacions</b> per a crear un paquet que contingui les personalitzacions realitzades a l\'estudi per mòduls específics.',
            'fieldsBtn' => 'Edita la informació que s\'emmagatzema en el mòdul mitjançant el control de la <b> Camps </b> en el mòdul. <br/> Vostè pot editar i crear camps personalitzats aquí.',
            'labelsBtn' => 'Feu clic a <b>Desa</b> per guardar les teves etiquetes personalitzades.',
            'layoutsBtn' => 'Personalitzeu els <b> Layouts </b> de l\'Edició, Detall, de llista i buscar punts de vista.',
            'layoutsHelp' => 'Seleccioneu un <b> Disseny per editar </b>.<br/><br/> Per canviar el disseny que conté camps de dades per a la introducció de dades, feu clic a <b> Mostra l\'</b>.<br/><br/> Per canviar la presentació que mostra les dades introduïdes en els camps de la vista d\'edició, feu clic a <b> Detallat </b>.<br/><br/> Per canviar les columnes que apareixen a la llista predeterminada, feu clic a <b> Vista de llista </b>.<br/><br/> per canviar la recerca de dissenys Bàsic i Avançat, feu clic a <b> Cercar </b>.',
            'mainHelp' => 'Benvingut a la <b> Eines de Desenvolupament </b> zona. <br/><br/> Utilitzeu les eines dins d\'aquesta àrea per crear i administrar mòduls i camps estàndard i personalitzats.',
            'mbBtn' => 'Utilitzi el <b>Constructor de Mòduls</b> per crear nous mòduls.',
            'mbHelp' => '<b> Benvinguts al Mòdul Constructor. </b> <br/> ús <b> Mòdul Constructor </b> per crear paquets que continguin mòduls personalitzats en base a objectes estàndard o personalitzats. <br/> Per començar, feu clic a <b> Nou paquet </b> per crear un nou paquet, o seleccionar un paquet per editar. <br/> A <b> Paquet </b > actua com un contenidor per mòduls personalitzats, tots els quals formen part d\'un projecte. El paquet pot contenir un o més mòduls personalitzats que poden estar relacionats entre si o amb els mòduls de l\'aplicació. <br/> Exemples: Vostè pot ser que desitgi per crear un paquet que conté un mòdul personalitzat que es relaciona amb el mòdul de comptes estàndard. O bé, és possible que vulgueu crear un paquet que conté diversos mòduls nous que funcionen junts com un projecte i que es relacionen entre si i amb els mòduls de l\'aplicació.',
            'moduleBtn' => 'Faci clic per editar aquest mòdul.',
            'moduleHelp' => 'Seleccioneu el component de mòdul que voleu editar',
            'newPackage' => 'Faci clic a <b>Nou Paquet</b> per crear un nou paquet.',
            'searchHelp' => 'Seleccioneu un disseny de <b>Cerca</b> a editar.',
            'studioBtn' => 'Utilitzeu <b> Studio </b> per personalitzar mòduls instal·lats canviant la disposició de camp, la selecció del que es disposa dels camps i la creació de camps de dades personalitzades.',
            'studioHelp' => 'Utilitzeu <b>Studio</b> per personalitzar els mòduls instal·lats.',
            'subpanelBtn' => 'Edita la informació que es mostra en els subpanells d\'aquest mòdul.',
            'subpanelHelp' => 'Seleccioneu el <b>Subpanell</b> a editar.',
        ),
    ),
//HOME
    'LBL_HOME_EDIT_DROPDOWNS' => 'Editor de Llistes Desplegables',

//STUDIO2
    'LBL_MODULEBUILDER' => 'Constructor de Mòduls',
    'LBL_STUDIO' => 'Estudi',
    'LBL_DROPDOWNEDITOR' => 'Editor de Llistes Desplegables',
    'LBL_DEVELOPER_TOOLS' => 'Eines de Desenvolupament',
    'LBL_SUITEPORTAL' => 'Editor del Portal de SuiteCRM',
    'LBL_PACKAGE_LIST' => 'Llista de paquets',
    'LBL_HOME' => 'Inici',
    'LBL_NONE' => '-Cap-',
    'LBL_DEPLOYE_COMPLETE' => 'Desplegament completat',
    'LBL_DEPLOY_FAILED' => 'Hi ha hagut un error durant el desplegament del procés. Es possible que el seu paquet no s\'hagi instal·lat correctament',
    'LBL_AVAILABLE_SUBPANELS' => 'Subpanells disponibles',
    'LBL_ADVANCED' => 'Avançat',
    'LBL_ADVANCED_SEARCH' => 'Filtre avançat',
    'LBL_BASIC' => 'Bàsic',
    'LBL_BASIC_SEARCH' => 'Filtre ràpid',
    'LBL_CURRENT_LAYOUT' => 'Disseny',
    'LBL_CURRENCY' => 'Moneda',
    'LBL_DASHLET' => 'Dashlet de SuiteCRM',
    'LBL_DASHLETLISTVIEW' => 'Veure llista de Dashlets de SuiteCRM',
    'LBL_POPUP' => 'Vista de finestra emergent',
    'LBL_POPUPLISTVIEW' => 'Llista de les vistes emergents',
    'LBL_POPUPSEARCH' => 'Cerca de finestra emergent',
    'LBL_DASHLETSEARCHVIEW' => 'Cercar Dashlet de SuiteCRM',
    'LBL_DETAILVIEW' => 'Vista detallada',
    'LBL_DROP_HERE' => '[Deixar Anar Aquí]',
    'LBL_EDIT' => 'Editar',
    'LBL_EDIT_LAYOUT' => 'Editar Diseny',
    'LBL_EDIT_FIELDS' => 'Editar camps',
    'LBL_EDITVIEW' => 'Vista d\'Edició',
    'LBL_FILLER' => '(farcit)',
    'LBL_FIELDS' => 'Camps',
    'LBL_FAILED_TO_SAVE' => 'Error al desar',
    'LBL_FAILED_PUBLISHED' => 'Error al Publicar',
    'LBL_HOMEPAGE_PREFIX' => 'El meu',
    'LBL_LAYOUT_PREVIEW' => 'Vista preliminar del disseny',
    'LBL_LAYOUTS' => 'Dissenys',
    'LBL_LISTVIEW' => 'Vista de llista',
    'LBL_MODULES' => 'Mòdul',
    'LBL_MODULE_TITLE' => 'Estudi',
    'LBL_NEW_PACKAGE' => 'Nou paquet',
    'LBL_NEW_PANEL' => 'Nou panell',
    'LBL_NEW_ROW' => 'Nova fila',
    'LBL_PACKAGE_DELETED' => 'Paquet eliminat',
    'LBL_PUBLISHING' => 'Publicant...',
    'LBL_PUBLISHED' => 'Publicat',
    'LBL_SELECT_FILE' => 'Seleccionar Arxiu',
    'LBL_SUBPANELS' => 'Subpanells',
    'LBL_SUBPANEL' => 'Subpanell',
    'LBL_SUBPANEL_TITLE' => 'Títol:',
    'LBL_SEARCH_FORMS' => 'Cerca',
    'LBL_SEARCH' => 'Cerca',
    'LBL_SEARCH_BUTTON' => 'Cerca',
    'LBL_FILTER' => 'Filtre',
    'LBL_TOOLBOX' => "Caixa d'eines",
    'LBL_QUICKCREATE' => 'Creació ràpida',
    'LBL_EDIT_DROPDOWNS' => 'Editar una llista desplegable global',
    'LBL_ADD_DROPDOWN' => 'afegir una nova llista desplegable global',
    'LBL_BLANK' => '-buit-',
    'LBL_TAB_ORDER' => 'ordre de tabulació',
    'LBL_TABDEF_TYPE' => 'Tipus de visualització',
    'LBL_TABDEF_TYPE_HELP' => "Seleccioneu la forma en què s'ha de mostrar aquesta secció. Aquesta opció només tindrà efecte si heu habilitat el mode Pestanyes a la vista.",
    'LBL_TABDEF_TYPE_OPTION_TAB' => 'Pestanya',
    'LBL_TABDEF_TYPE_OPTION_PANEL' => 'Panell',
    'LBL_TABDEF_TYPE_OPTION_HELP' => 'Seleccioneu Panell perquè el panell es mostri a la vista inicial o en la vista del panell anterior que s\'hagi seleccionat com Pestaña. <br/> Seleccioneu Pestanya per mostrar el panell en una pestanya independent. Quan s\'ha seleccionat un panell com Pestaña, els següents panells seleccionats com Panell es mostraran a la vista d\'aquesta pestanya. <br/> Sempre que seleccioni un panell com Pestaña serà el primer panell a mostrar en aquesta Pestaña. <br/> Si es selecciona com Pestaña el segon panell o posteriors, el primer panell s\'establirà automàticament com Pestanya si s\'hagués seleccionat anteriorment com Panell.',
    'LBL_TABDEF_COLLAPSE' => 'Redueix ',
    'LBL_TABDEF_COLLAPSE_HELP' => 'Marqueu la casella per tal que el panell aparegui plegat per defecte.',
    'LBL_DROPDOWN_TITLE_NAME' => 'Nom',
    'LBL_DROPDOWN_LANGUAGE' => 'Idioma',
    'LBL_DROPDOWN_ITEMS' => "Llista d'elements",
    'LBL_DROPDOWN_ITEM_NAME' => "Nom de l'element",
    'LBL_DROPDOWN_ITEM_LABEL' => "Etiqueta de visualització",
    'LBL_SYNC_TO_DETAILVIEW' => 'Sincronitza amb la vista de detall',
    'LBL_SYNC_TO_DETAILVIEW_HELP' => "Seleccioneu aquesta opció per sincronitzar el disseny de la vista d'edició amb el corresponent disseny de la vista de detall. Mentre la sincronització estigui activada no es podran fer canvis a la vista de detall, que sempre es mostrarà igual que la d'edició.",
    'LBL_SYNC_TO_DETAILVIEW_NOTICE' => "La vista de detall està sincronitzada amb la vista d'edició, de manera que la disposició dels camps que veieu aquí reflecteix el que hi ha a l'altra vista. Els canvis que feu aquí no es conservaran. Si voleu modificar només aquesta vista, desactiveu la sincronització amb la vista d'edició.",
    'LBL_COPY_FROM_EDITVIEW' => "Copia la vista d'edició",
    'LBL_DROPDOWN_BLANK_WARNING' => "Cal introduir un valor tant pel nom de l'element com per l'etiqueta de visualització. Per afegir un element en blanc, feu clic a Agrega, sense introduir cap valor pel nom de l'element ni per l'etiqueta de visualització.",
    'LBL_DROPDOWN_KEY_EXISTS' => 'La clau ja existeix a la llista',
    'LBL_NO_SAVE_ACTION' => "No s'ha trobat l'opció Desa per aquesta vista.",
    'LBL_BADLY_FORMED_DOCUMENT' => 'Studio2:establishLocation: document mal format.',


//RELATIONSHIPS
    'LBL_MODULE' => 'Mòdul',
    'LBL_LHS_MODULE' => 'Mòdul principal',
    'LBL_CUSTOM_RELATIONSHIPS' => "* relació creada a l'Estudi",
    'LBL_RELATIONSHIPS' => 'Relacions',
    'LBL_RELATIONSHIP_EDIT' => 'Edita la relació',
    'LBL_REL_NAME' => 'Nom',
    'LBL_REL_LABEL' => 'Etiqueta',
    'LBL_REL_TYPE' => 'Tipus',
    'LBL_RHS_MODULE' => 'Mòdul relacionat',
    'LBL_NO_RELS' => 'Sense relacions',
    'LBL_RELATIONSHIP_ROLE_ENTRIES' => 'Condició opcional',
    'LBL_RELATIONSHIP_ROLE_COLUMN' => 'Columna',
    'LBL_RELATIONSHIP_ROLE_VALUE' => 'Valor',
    'LBL_SUBPANEL_FROM' => 'Subpanell de',
    'LBL_RELATIONSHIP_ONLY' => 'No es crearà cap element visible per a la relació atès que ja existia anteriorment una relació entre els dos mòduls.',
    'LBL_ONETOONE' => 'Un a un',
    'LBL_ONETOMANY' => 'Un a molts',
    'LBL_MANYTOONE' => 'Molts a un',
    'LBL_MANYTOMANY' => 'Molts a molts',

//STUDIO QUESTIONS
    'LBL_QUESTION_EDIT' => 'Seleccioneu el mòdul a editar.',
    'LBL_QUESTION_LAYOUT' => 'Seleccioneu el disseny a editar.',
    'LBL_QUESTION_SUBPANEL' => 'Seleccioneu el subpanell a editar.',
    'LBL_QUESTION_SEARCH' => 'Seleccioneu el disseny de cerca a editar.',
    'LBL_QUESTION_MODULE' => 'Seleccioneu el component de mòdul a editar.',
    'LBL_QUESTION_PACKAGE' => 'Seleccioneu el paquet a editar o creeu un nou paquet.',
    'LBL_QUESTION_EDITOR' => 'Seleccioneu una eina.',
    'LBL_QUESTION_DASHLET' => 'Seleccioneu el disseny de Dashlet a editar.',
    'LBL_QUESTION_POPUP' => 'Seleccioneu el disseny de finestra emergent a editar.',

//CUSTOM FIELDS
    'LBL_NAME' => 'Nom',
    'LBL_LABELS' => 'Etiquetes',
    'LBL_MASS_UPDATE' => 'Actualització massiva',
    'LBL_DEFAULT_VALUE' => 'Valor per defecte',
    'LBL_REQUIRED' => 'Requerit',
    'LBL_DATA_TYPE' => 'Tipus',
    'LBL_HCUSTOM' => 'Personalitzat',
    'LBL_HDEFAULT' => 'Per defecte',
    'LBL_LANGUAGE' => 'Idioma:',
    'LBL_CUSTOM_FIELDS' => '* camp creat a l\'estudi',

//SECTION
    'LBL_SECTION_EDLABELS' => 'Editar Etiquetes',
    'LBL_SECTION_PACKAGES' => 'Paquets',
    'LBL_SECTION_PACKAGE' => 'Paquet',
    'LBL_SECTION_MODULES' => 'Mòdul',
    'LBL_SECTION_DROPDOWNS' => 'Menús desplegables',
    'LBL_SECTION_PROPERTIES' => 'Propietats',
    'LBL_SECTION_DROPDOWNED' => 'Editar la llista desplegable',
    'LBL_SECTION_HELP' => 'Ajuda',
    'LBL_SECTION_MAIN' => 'Principal',
    'LBL_SECTION_FIELDEDITOR' => 'Editar camp',
    'LBL_SECTION_DEPLOY' => 'Desplegar',
    'LBL_SECTION_MODULE' => 'Mòdul',

//WIZARDS

//LIST VIEW EDITOR
    'LBL_DEFAULT' => 'Per defecte',
    'LBL_HIDDEN' => 'Ocult',
    'LBL_AVAILABLE' => 'Disponible',
    'LBL_LISTVIEW_DESCRIPTION' => 'Hi ha tres columnes que es mostren a continuació. El <b> per defecte </b> la columna conté els camps que es mostren en una vista de llista per defecte. El <b> addicional </b> columna conté els camps que l\'usuari pot triar per crear una vista personalitzada. El <b> disponible </b> columna mostra els camps disponibles per a vostè com un administrador per afegir a l\'omissió o columnes addicionals per al seu ús pels usuaris.',
    'LBL_LISTVIEW_EDIT' => 'Editor de Llistes',

//Manager Backups History
    'LBL_MB_PREVIEW' => 'Vista Preliminar',
    'LBL_MB_RESTORE' => 'Restaurar',
    'LBL_MB_DELETE' => 'Eliminar',
    'LBL_MB_DEFAULT_LAYOUT' => 'Disseny per defecte',

//END WIZARDS

//BUTTONS
    'LBL_BTN_ADD' => 'Afegeix',
    'LBL_BTN_SAVE' => 'Desa',
    'LBL_BTN_SAVE_CHANGES' => 'Desa els canvis',
    'LBL_BTN_DONT_SAVE' => 'Descarta els canvis',
    'LBL_BTN_CANCEL' => 'Cancel·la',
    'LBL_BTN_CLOSE' => 'Tanca',
    'LBL_BTN_SAVEPUBLISH' => 'Desa i publica',
    'LBL_BTN_CLONE' => 'Clona',
    'LBL_BTN_ADDROWS' => 'Afegeix files',
    'LBL_BTN_ADDFIELD' => 'Afegeix un camp',
    'LBL_BTN_ADDDROPDOWN' => 'Afegeix un desplegable',
    'LBL_BTN_SORT_ASCENDING' => 'Ordena ascendentment',
    'LBL_BTN_SORT_DESCENDING' => 'Ordena descendentment',
    'LBL_BTN_EDLABELS' => 'Edita les etiquetes',
    'LBL_BTN_UNDO' => 'Desfés',
    'LBL_BTN_REDO' => 'Repeteix',
    'LBL_BTN_ADDCUSTOMFIELD' => 'Afegeix un camp personalitzat',
    'LBL_BTN_EXPORT' => 'Exporta les personalitzacions',
    'LBL_BTN_DUPLICATE' => 'Duplica',
    'LBL_BTN_PUBLISH' => 'Publica',
    'LBL_BTN_DEPLOY' => 'Desplega',
    'LBL_BTN_EXP' => 'Exporta',
    'LBL_BTN_DELETE' => 'Eliminar',
    'LBL_BTN_VIEW_LAYOUTS' => 'Dissenys',
    'LBL_BTN_VIEW_FIELDS' => 'Camps',
    'LBL_BTN_VIEW_RELATIONSHIPS' => 'Relacions',
    'LBL_BTN_ADD_RELATIONSHIP' => 'Afegeix una relació',
    'LBL_BTN_RENAME_MODULE' => 'Canvia el nom del mòdul',
//TABS


//ERRORS
    'ERROR_ALREADY_EXISTS' => 'Error: Camp existent',
    'ERROR_INVALID_KEY_VALUE' => "Error: Valor de clau no vàlid: [&#39;]",
    'ERROR_NO_HISTORY' => 'No s\'han trobat arxius de la història',
    'ERROR_MINIMUM_FIELDS' => 'El disseny ha de contenir almenys un camp',
    'ERROR_GENERIC_TITLE' => 'Ha ocorregut un error',
    'ERROR_REQUIRED_FIELDS' => 'Segur que voleu continuar? Els següents camps obligatoris no es troben al disseny:',


//PACKAGE AND MODULE BUILDER
    'LBL_PACKAGE_NAME' => 'Nom del paquet:',
    'LBL_MODULE_NAME' => 'Nom del mòdul:',
    'LBL_AUTHOR' => 'Autor:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_KEY' => 'Clau:',
    'LBL_ADD_README' => 'Llegeix-me',
    'LBL_LAST_MODIFIED' => 'Última modificació:',
    'LBL_NEW_MODULE' => 'Nou mòdul',
    'LBL_LABEL' => 'Etiqueta:',
    'LBL_LABEL_TITLE' => 'Etiqueta',
    'LBL_WIDTH' => 'Amplada',
    'LBL_PACKAGE' => 'Paquet:',
    'LBL_TYPE' => 'Tipus:',
    'LBL_NAV_TAB' => 'Pestanya de navegació',
    'LBL_CREATE' => 'Crea',
    'LBL_LIST' => 'Llista',
    'LBL_VIEW' => 'Mostra',
    'LBL_HISTORY' => 'Historial',
    'LBL_RESTORE_DEFAULT' => 'Restableix',
    'LBL_ACTIVITIES' => 'Activitats',
    'LBL_NEW' => 'Nou',
    'LBL_TYPE_BASIC' => 'Bàsica',
    'LBL_TYPE_COMPANY' => 'Empresa',
    'LBL_TYPE_PERSON' => 'Persona',
    'LBL_TYPE_ISSUE' => 'Incidència',
    'LBL_TYPE_SALE' => 'Venda',
    'LBL_TYPE_FILE' => 'Fitxer',
    'LBL_RSUB' => 'Aquest és el subpanell que es mostrarà al mòdul',
    'LBL_MSUB' => 'Aquest és el subpanell que el mòdul proporciona per tal que sigui mostrat pels mòduls relacionats',
    'LBL_MB_IMPORTABLE' => 'Importable', 

// VISIBILITY EDITOR
    'LBL_PACKAGE_WAS_DELETED' => '[[package]] ha estat eliminat',

//EXPORT CUSTOMS
    'LBL_EC_TITLE' => 'Exporta les personalitzacions',
    'LBL_EC_NAME' => 'Nom del paquet:',
    'LBL_EC_AUTHOR' => 'Autor:',
    'LBL_EC_DESCRIPTION' => 'Descripció:',
    'LBL_EC_CHECKERROR' => 'Seleccioneu un mòdul',
    'LBL_EC_CUSTOMFIELD' => 'camps personalitzats',
    'LBL_EC_CUSTOMLAYOUT' => 'dissenys personalitzats',
    'LBL_EC_NOCUSTOM' => "No s'ha personalitzat cap mòdul.",
    'LBL_EC_EMPTYCUSTOM' => 'té personalitzacions buides.',
    'LBL_EC_EXPORTBTN' => 'Exporta',
    'LBL_MODULE_DEPLOYED' => "El mòdul s'ha desplegat.",
    'LBL_UNDEFINED' => 'no definit',
    'LBL_EC_VIEWS' => 'vistes personalitzades',
    'LBL_EC_SUITEFEEDS' => 'feeds personalitzats',
    'LBL_EC_DASHLETS' => 'dashlets personalitzats',
    'LBL_EC_CSS' => 'css personalitzat',
    'LBL_EC_TPLS' => 'tpls personalitzades',
    'LBL_EC_IMAGES' => 'imatges personalitzades',
    'LBL_EC_JS' => 'js personalitzats',
    'LBL_EC_QTIP' => 'qtip personalitzats',

//AJAX STATUS
    'LBL_AJAX_FAILED_DATA' => 'Error al recuperar les dades',
    'LBL_AJAX_LOADING' => 'Carregant...',
    'LBL_AJAX_DELETING' => 'Eliminant...',
    'LBL_AJAX_BUILDPROGRESS' => 'Construcció en progrés...',
    'LBL_AJAX_DEPLOYPROGRESS' => 'Desplegament en progres...',

    'LBL_AJAX_RESPONSE_TITLE' => 'Resultat',
    'LBL_AJAX_RESPONSE_MESSAGE' => 'Aquesta operació s\'ha realitzat correctament',
    'LBL_AJAX_LOADING_TITLE' => 'En curs...',
    'LBL_AJAX_LOADING_MESSAGE' => 'Espereu, carregant...',

//JS
    'LBL_JS_REMOVE_PACKAGE' => 'Segur que voleu eliminar aquest paquet? Això eliminarà permanentment tots els fitxers associats al paquet.',
    'LBL_JS_REMOVE_MODULE' => 'Segur que voleu eliminar aquest mòdul? Això eliminarà permanentment tots els fitxers associats al mòdul.',
    'LBL_JS_DEPLOY_PACKAGE' => "Qualsevol personalització que s'hagi fet a l'Estudi se sobreescriurà si es torna a desplegar aquest mòdul. Segur que voleu continuar?",

    'LBL_DEPLOY_IN_PROGRESS' => 'Desplegant el paquet',
    'LBL_JS_VALIDATE_NAME' => 'El nom del paquet ha de ser alfanumèric, començar amb una lletra i no contenir espais.',
    'LBL_JS_VALIDATE_PACKAGE_NAME' => 'El nom del paquet ja existeix.',
    'LBL_JS_VALIDATE_KEY' => 'La clau del paquet ha de ser alfanumèrica, començar amb una lletra i no contenir espais.',
    'LBL_JS_VALIDATE_LABEL' => "Introduïu l\'etiqueta que s\'utilitzarà com a nom visible d\'aquest mòdul.", // Excepció d'escapat 
    'LBL_JS_VALIDATE_TYPE' => 'Seleccioneu el tipus de mòdul que voleu crear.',
    'LBL_JS_VALIDATE_REL_LABEL' => "Afegiu l\'etiqueta que serà mostrada als subpanells.", // Excepció d'escapat 

//CONFIRM
    'LBL_CONFIRM_FIELD_DELETE' => 'Si elimineu el camp personalitzat esborrareu també la informació que el camp conté a la base de dades. El camp ja no apareixerà a les vistes del mòdul.\n\nVoleu continuar?',

    'LBL_CONFIRM_RELATIONSHIP_DELETE' => 'Segur que voleu eliminar aquesta relació?',
    'LBL_CONFIRM_DONT_SAVE' => 'Hi ha canvis pendents de ser desats, voleu desar-los ara?',
    'LBL_CONFIRM_DONT_SAVE_TITLE' => 'Voleu desar els canvis?',
    'LBL_CONFIRM_LOWER_LENGTH' => 'Les dades poden ser truncades i això no es podrà desfer. Segur que voleu continuar?',

//POPUP HELP
    'LBL_POPHELP_FIELD_DATA_TYPE' => 'Seleccioneu el tipus de dades apropiat segons el tipus de dades que seran introduïdes al camp.',
    'LBL_POPHELP_IMPORTABLE' => '<b>Sí</b>: El camp pot ser inclòs en una importació.<br><b>No</b>: El camp no pot ser inclòs en una importació.<br><b>Requerit</b>: El camp ha de ser inclòs en qualsevol importació.',
    'LBL_POPHELP_IMAGE_WIDTH' => 'Indiqueu l&#39;amplada en píxels. La imatge pujada s&#39;escalarà a aquesta amplada.',
    'LBL_POPHELP_IMAGE_HEIGHT' => 'Indiqueu l&#39;alçada en píxels. La imatge pujada s&#39;escalarà a aquesta alçada.',
    'LBL_POPHELP_DUPLICATE_MERGE' => '<b>Habilitat</b>: El camp apareixerà a la combinació de duplicats, però no als filtres de cerca de duplicats.<br><b>Deshabilitat</b>: El camp no apareixerà ni a la combinació ni a la cerca de duplicats.<br><b>Al filtre</b>: El camp apareixerà a la combinació de duplicats i estarà disponible a la cerca de duplicats.<br><b>Seleccionat per defecte al filtre</b>: El camp apareixerà com a condició de filtrat per defecte a la cerca de duplicats i també apareixerà a la combinació de duplicats.<br><b>Només al filtre</b>: El camp no apareixerá a la combinació de duplicats, però estarà disponible a la cerca de duplicats.',
    'LBL_POPHELP_FIELD_DATA_TYPE' => 'Seleccioneu el tipus de dades apropiat per al camp.',
    
//Revert Module labels
    'LBL_RESET' => 'Restableix',
    'LBL_RESET_MODULE' => 'Restableix el mòdul',
    'LBL_REMOVE_CUSTOM' => 'Elimina les personalitzacions',
    'LBL_CLEAR_RELATIONSHIPS' => 'Neteja les relacions',
    'LBL_RESET_LABELS' => 'Restableix les etiquetes',
    'LBL_RESET_LAYOUTS' => 'Restableix els dissenys',
    'LBL_REMOVE_FIELDS' => 'Elimina els camps personalitzats',
    'LBL_CLEAR_EXTENSIONS' => 'Neteja les extensions',
    'LBL_HISTORY_TIMESTAMP' => 'Registre de temps.',
    'LBL_HISTORY_TITLE' => 'historial',

    'fieldTypes' => array(
        'varchar' => 'Text',
        'int' => 'Enter',
        'float' => 'Flotant',
        'bool' => 'Casella de verificació',
        'enum' => 'Llista desplegable',
        'dynamicenum' => 'Llista desplegable dinàmica',
        'multienum' => 'Selecció múltiple',
        'date' => 'Data',
        'phone' => 'Telèfon',
        'currency' => 'Moneda',
        'html' => 'HTML',
        'radioenum' => 'Opció',
        'relate' => 'Relacionat',
        'address' => 'Adreça',
        'text' => 'Àrea de text',
        'url' => 'Enllaç',
        'iframe' => 'IFrame',
        'datetimecombo' => 'Data i Hora',
        'decimal' => 'Decimal',
        'image' => 'Imatge',
        'wysiwyg' => 'WYSIWYG',
    ),
    'labelTypes' => array(
        "frequently_used" => "Etiquetes d'ús freqüent",
        "all" => "Totes les etiquetes",
    ),

    'parent' => 'Possiblement relacionat amb ',

    'LBL_CONFIRM_SAVE_DROPDOWN' => "Esteu seleccionant aquest element per a la seva eliminació de la llista desplegable. Qualsevol camp desplegable que faci servir aquesta llista amb aquest element com a valor ja no mostrarà aquest valor, i el valor ja no podrà ser seleccionat en els camps desplegables. Segur que voleu continuar?",

    'LBL_ALL_MODULES' => 'Tots els mòduls',
    'LBL_RELATED_FIELD_ID_NAME_LABEL' => '{0} (relacionat {1} ID)',
);
