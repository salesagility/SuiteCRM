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
    'LBL_LOADING' => 'Cargando ...' /*for 508 compliance fix*/,
    'LBL_HIDEOPTIONS' => 'Ocultar Opcións' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Eliminar' /*for 508 compliance fix*/,
    'help' => array(
        'package' => array(
            'create' => 'Proporcionar un <b>Nome</b> para o paquete. O nome que introduza debe ser alfanumérico e sen espazos. (Exemplo: HR_Management)<br/><br/>Pode proporcionar <b>Autor</b> e <b>Descrición</b> como información para o paquete.<br/><br/> Faga clic en <b>Gardar</b> para crear o paquete.',
            'modify' => 'As propiedades e posibles accións para o <b>paquete</b> aparecerán aquí. <br/><br/> Pode modificar o <b>nome</b>, <b>Autor</b> e <b>Descrición</b> do paquete, así como ver e personalizar todos os módulos contidos no paquete. <br/><br/> Faga clic en  <b>novo módulo</b> para crear un módulo para o paquete.<br/><br/> Se o paquete contén polo menos un módulo, vostede pode <b>publicar</b> e <b>despregar</b> o paquete, así como <b>exportar</b> as personalizacións realizadas no paquete.',
            'name' => 'Este é o <b>nome</b> do paquete actual. <br/><br/> o nome que introduza debe ser alfanuméricos, comezar cunha letra e sen espazos. (Exemplo: HR_Management)',
            'author' => 'Este é o <b> Autor </b> que se mostra durante a instalación como o nome da entidade que creou o paquete. <br/><br/> o autor podería ser un individuo ou unha empresa.',
            'description' => 'Esta é a <b>Descrición</b> do paquete que é mostrada durante a instalación.',
            'publishbtn' => 'Faga clic en <b>Publicar</b> para gardar todos os datos introducidos e crear un arquivo .zip que é unha versión instalable do paquete.<br/><br/> Use o <b>Cargador de Módulos</b> para cargar o arquivo .zip e instalar o paquete.',
            'deploybtn' => 'Faga clic en <b> despregar </b> para gardar todos os datos introducidos e para instalar o paquete, incluíndo todos os módulos, na instancia actual.',
            'duplicatebtn' => 'Faga clic en <b> duplicar </b> para copiar o contido do paquete nun paquete novo e para mostrar o novo paquete. <br/> <br/> Para o novo paquete, un novo nome é xerado automaticamente engadindo un número ao final do nome do paquete utilizado para duplicarlo. Pode cambiar o nome do novo paquete mediante a introducción dun <b>nome</b> novo e despois facendo clic en <b>Gardar</b>.',
            'exportbtn' => 'Faga clic en <b>Exportar</b> para crear un arquivo .zip que contén as personalizacións realizadas no paquete. <br/><br/> o arquivo xerado non é unha versión instalable do paquete. <br/><br/> Use o <b >Cargador de módulos</b> para importar o arquivo .zip e ter o paquete, incluidas as personalizacións, aparecen no Xerador de módulos.',
            'deletebtn' => 'Faga Click en <b>Borrar</b> para suprimir este paquete e todos os arquivos relacionados co mesmo.',
            'savebtn' => 'Faga clic en <b>Gardar</b> para gardar todos os datos relacionados co paquete.',
            'existing_module' => 'Faga clic no icono do <b>módulo</b> para editar as propiedades e personalizar os campos, as relacións e deseño asociados co módulo.',
            'new_module' => 'Faga clic en <b> novo módulo </b> para crear un novo módulo para este paquete.',
            'key' => 'Estas 5 letras, <b> clave </b> alfanuméricas úsanse como prefixo para todos os directorios, os nomes de clases e as táboas de base de datos para todos os módulos no paquete actual. <br><br> a clave utilízase nun esforzo para lograr a singularidade dos nomes das táboas.',
            'readme' => 'Faga clic para engadir <b> Léame </b> de texto para este paquete. <br><br> o léame estará dispoñible no momento da instalación.',

        ),
        'main' => array(),
        'module' => array(
            'create' => 'Proporcionar un <b>nome</b> para o módulo. A <b>etiqueta</b> que lle proporcione aparecerá na pestana de navegación. <br/><br/> Escolla se desexa ver unha pestana de navegación para o módulo para iso seleccione a casilla de <b> Pestana de navegación </b>. <br/><br/> Revise a casilla de <b>equipo de seguridade</b> para ter un campo de selección do equipo dentro dos rexistros do módulo. <br/><br/> A continuación, seleccione o tipo de módulo que desexa crear. <br/><br/> Seleccione un tipo de plantilla. Cada plantilla contén un conxunto específico dos campos, así como os deseño pre-definidos, para usar como base do seu módulo. <br/><br/> Faga clic en <b>Gardar </b> para crear o módulo.',
            'modify' => 'Podes modificar as propiedades do módulo e adaptar os <b>Campos</b>, <b>Relacións</b> e <b>Vistas</b> relacionadas co módulo.',
            'importable' => 'Comprobe a casilla de <b> Importables </b> a cal permitirá a importación de datos sobre este módulo. <br><br> Un enlace de Asistente de importación aparecerá no panel de accesos directos no módulo. O Asistente de importación facilita a importación de datos de fontes externas no módulo personalizado.',
            'team_security' => 'Comprobe a casilla de <b> equipo de seguridade </b> que permitirá a seguridade por equipo para este módulo. <br/><br/> Se o equipo de seguridade está activado, o campo de selección do equipo aparecerá dentro dos rexistros no módulo',
            'reportable' => 'Ao marcar esta casilla permitirá que a este módulo se lle poidan realizar reportes.',
            'assignable' => 'Ao marcar esta casilla permitirá asignar a un usuario seleccionado un rexistro do módulo.',
            'has_tab' => 'Comprobación de <b> Pestana de Navegación </b> proporcionará unha pestana de navegación para o módulo.',
            'acl' => 'Ao marcar esta casilla permitirá aos controis de acceso neste módulo, incluíndo a seguridade sobre o terreo.',
            'studio' => 'Ao marcar esta casilla permitirá aos administradores personalizar este módulo dentro de Studio.',
            'audit' => 'Marcando esta casilla Habilitar a auditoría deste módulo. Os cambios en certos campos rexistraranse de modo que os administradores poden revisar o historial de cambios.',
            'viewfieldsbtn' => 'Faga clic en <b> Ver Campos </b> para ver os campos asociados co módulo e para crear e editar os campos personalizados.',
            'viewrelsbtn' => 'Faga clic en <b> Ver Relacións </b> para ver as relacións asociadas con este módulo e crear novas relacións.',
            'viewlayoutsbtn' => 'Faga clic en <b> Ver Deseño </b> para ver os deseño para o módulo e para personalizar a organización de campo dentro do deseño.',
            'duplicatebtn' => 'Faga clic en <b> duplicados </b> para copiar as propiedades do módulo nun novo módulo e para mostrar o novo módulo. <br/><br/> Para o novo módulo, un novo nome xérase automaticamente engadindo un número ao final do nome do módulo utilizado para crealo.',
            'deletebtn' => 'Faga Click en <b>Eliminar</b> para eliminar este módulo.',
            'name' => 'Este é o <b>Nome</b> do módulo actual.<br/><br/> o nome debe ser alfanumérico e debe comezar cunha letra e non conter espazos. (Exemplo: HR_Management)',
            'label' => 'Esta é a <b>Etiqueta</b> que aparecerá na pestana de navegación para o módulo. ',
            'savebtn' => 'Faga Click en <b>Gardar</b> para gardar toda a información relacionada co modulo.',
            'type_basic' => 'A plantilla <b> básica </b> conta con campos básicos, como o nome, Asignado a, Equipo, Data de creación e os campos de Descrición.',
            'type_company' => 'O tipo de plantilla da <b>Empresa</b> dispón de campos específicos á organización, como por exemplo Nome da Empresa, Sector, Enderezo Fiscal. <br /><br />Utilice esta plantilla para crear módulos que son similares aos módulos estándares de Contas.',
            'type_issue' => 'O tipo de plantilla de <b>Problemas</b> dispón de campos específicos a incidencias e casos internos, como por exemplo, Número, Estado, Prioridade, Descrición. <br /><br />Utilice esta plantilla para crear módulos que son similares aos módulos estándares de Incidencias e Seguimento de Casos Internos.',
            'type_person' => 'O tipo de plantilla de <b>Persoa</b> dispón de campos específicos ao contacto, como por exemplo, Greeting, Título, Nome, Enderezo, Número de Teléfono.  <br /><br />Utilice esta plantilla para crear módulos que son similares aos módulos estándares de Contactos e Potenciais.',
            'type_sale' => 'O tipo de plantilla de <b>Venda</b> dispón de campos específicos ás oportunidades, como por exemplo, Orixe do Potencial, Fase, Cantidade, e Probabilidade.<br /><br />Utilice esta plantilla para crear módulos que son similares aos módulos estándares das Oportunidades.',
            'type_file' => 'O tipo de plantilla de <b>Arquivo<b> dispón de campos específicos de Documentos, como por exemplo, Nome do Arquivo, tipo de Documento, e Data de Publicación. <br /><br />Utilice esta plantilla para crear módulos que son similares aos módules estándares de Documentos.',

        ),
        'dropdowns' => array(
            'default' => 'Todos os Menus despregables da aplicación, lístanse aquí. <br> <br> Para realizar cambios para un menú despregable, faga clic no nome do menú despregable. <br><br> Realice os cambios no <b>Editor de menus despregables</b> no formulario da parte dereita do panel, e faga clic en <b>Gardar</b>. Realice os cambios que sexan necesarios, e logo faga clic en "Gardar </b>. <br><br> Para crear un novo menú despregable, faga clic en <b>Engadir menu despregable </b>. Introduza as propiedades da lista despregable situada formulario no <b>Editor de menus despregables</b> e faga clic en <b>Gardar</b>.',
            'editdropdown' => 'As listas despregables poden ser utilizadas para campos despregables estándar ou personalizados de calquera módulo.<br><br>Proporcione un <b>Nome</b> para a lista despregable.<br><br>Se instalaou outros paquetes de idioma na aplicación, poderá seleccionar o <b>Idioma</b> a utilizar para os elementos da lista.<br><br>No campo <b>Nome do Elemento</b>, proporcione un nome para a opción na lista despregable.  Este nome non aparecerá na lista visible polos usuarios.<br><br>No campo <b>Etiqueta de Visualización</b>, proporcione unha etiqueta que será visible polos usuarios.<br><br>Tras proporcionar o nome do elemento e a etiqueta de visualización, faga click en <b>Agregar</b> para engadir o elemento á lista despregable.<br><br>Para cambiar a orde dos elementos na lista, arrastre elementos e sólteos nas posicións desexadas.<br><br>Para editar a etiqueta de visualización dun elemento, faga click no icono <b>Editar</b> e introduza unha nova etiqueta. Para eliminar un elemento da lista despregable, faga click no icono <b>Eliminar</b>.<br><br>Para desfacer un cambio realizado a unha etiqueta de visualización, faga click en <b>Desfacer</b>.  Para refacer un cambio que foi previamente desfeito, faga click en <b>Refacer</b>.<br><br>Faga click en <b>gardar</b> para gardar a lista despregable.',

        ),
        'subPanelEditor' => array(
            'modify' => 'Todos os campos que poden ser mostrados no <b>Subpanel</b> aparecen aquí.<br><br>A columna <b>Por omisión</b> contén os campos que son mostrados no Subpanel.<br/><br/>A columna <b>Dispoñibles</b> contén os campos que un usuario pode seleccionar na Busca para crear unha vista de Lista personalizada. <br/><br/>A columna <b>Ocultos</b> contén os campos que poden ser agregados ás columnas Por omisión ou Dispoñibles.'
        ,
            'savebtn' => 'Faga clic en <b>Gardar e Despregar</b> para gardar os cambios que realizou e para que estean aplicados no módulo.',
            'historyBtn' => 'Faga click en <b>Ver historial</b> para ver e restaurar do historial, un deseño previamente gardado.',
            'historyDefault' => 'Faga click en <b>Restaurar vista por omisión</b> para restaurar o deseño orixinal dunha vista.',
            'Hidden' => '<b>Oculto</b> os campos non aparecerán no subpanel.',
            'Default' => '<b>Por defecto</b> os campos aparecen no subpanel.',

        ),
        'listViewEditor' => array(
            'modify' => 'a columna <b>por defecto</b> contén os campos que se mostran nunha vista de lista por defecto. <br/><br/> a columna <b> Dispoñible</b> contén os campos que o usuario pode escoller para crear unha lista personalizada. <br/><br/> a columna <b>Ocultos</b>contén os campos que vostede como administrador pode agregar por defecto ou columnas dispoñibles para que os usuarios as vexan.'
        ,
            'savebtn' => 'Faga clic en <b>Gardar e Despregar</b> para gardar os cambios que realizou e para que estean aplicados no módulo.',
            'historyBtn' => 'Dá clic en <b>Ver historial</b> para ver e restaurar plantillas previamente gardadas.<br><br><b>Restaurar</b> dentro de <b>Historial</b> restaura o primeiro campo creado dentro de plantillas previamente gardadas. Para cambiar etiquetas de campos, dá clic en Editar enseguida de cada campo.',
            'historyDefault' => 'Faga clic en <b>Restaurar por defecto</b> para restablecer unha vista ao seu trazado orixinal. <br><br><b>Restaurar por defecto</b> só restaura a ubicación do campo no deseño orixinal. Para cambiar as etiquetas de campo, faga clic no icono de edición xunto a cada campo.',
            'Hidden' => 'Oculta campos que actualmente non estan dispoñibles para velos polos usuarios na lista de vistas.',
            'Available' => 'Activa campos que non se mostran por defecto, pero se poden agregar á lista de vistas para os usuarios.',
            'Default' => 'Por defecto móstranse os campos aos usuarios que non crearon lista personalizada.'
        ),
        'popupListViewEditor' => array(
            'modify' => 'Aquí aparecen todos os campos que se poden mostrar no <b>ListView</b>. <br><br>A columna <b>por defecto</b> contén os campos que se mostran no ListView por defecto. <br/> <br/> a columna <b>oculta</b> contén campos que poden agregarse por defecto ou á columna dispoñible.'
        ,
            'savebtn' => 'Faga clic en <b>Gardar e Despregar</b> para gardar os cambios que realizou e para que estean aplicados no módulo.',
            'historyBtn' => 'Dá clic en <b>Ver historial</b> para ver e restaurar plantillas previamente gardadas.<br><br><b>Restaurar</b> dentro de <b>Historial</b> restaura o primeiro campo creado dentro de plantillas previamente gardadas. Para cambiar etiquetas de campos, dá clic en Editar enseguida de cada campo.',
            'historyDefault' => 'Faga clic en <b>Restaurar por defecto</b> para restablecer unha vista ao seu trazado orixinal. <br><br><b>Restaurar por defecto</b> só restaura a ubicación do campo no deseño orixinal. Para cambiar as etiquetas de campo, faga clic no icono de edición xunto a cada campo.',
            'Hidden' => 'Oculta campos que actualmente non estan dispoñibles para velos polos usuarios na lista de vistas.',
            'Default' => 'Por defecto móstranse os campos aos usuarios que non crearon lista personalizada.'
        ),
        'searchViewEditor' => array(
            'modify' => 'Todos os campos que poden ser mostrados no formulario de <b>Filtro</b> aparecen aquí.<br><br>A columna <b>por defecto</b> contén os campos que serán mostrados no formulario de Busca. <br/><br/>A columna <b>Ocultos</b> contén os campos dispoñibles para ti para que sexan agregados ao Formulario de Busca.'
        ,
            'savebtn' => 'Ao facer clic en <b>Gardar e Utilizar</b> para gardar todos os cambios e facelos activos',
            'Hidden' => 'Os campos oculto son campos que non se mostra na vista de busca.',
            'historyBtn' => 'Dá clic en <b>Ver historial</b> para ver e restaurar plantillas previamente gardadas.<br><br><b>Restaurar</b> dentro de <b>Historial</b> restaura o primeiro campo creado dentro de plantillas previamente gardadas. Para cambiar etiquetas de campos, dá clic en Editar enseguida de cada campo.',
            'historyDefault' => 'Clic en <b>Restablecer</b>para reestablecer unha vista ao seu layout orixinal.<br><br><b>Restablecer</b> só restaura o campo dentro do seu lugar orixinal no layout. Para editar campos, dá clic en "Editar" enseguida do icono "Seguinte" en cada campo.',
            'Default' => 'Os campos por defecto mostraranse na vista de busca.'
        ),
        'layoutEditor' => array(
            'defaultdetailview' => 'O área de <b>Deseño</b> contén os campos que actualmente están sendo mostrados na <b>vista de detalle</b>.<br/><br/>A <b>Caixa de Ferramentas</b> contén a <b>Papeleira de Reciclaxe</b> e os campos e elementos do deseño que poden ser agregados ao mesmo.<br><br>Cambie o deseño arrastrando e soltando elementos e campos entre a <b>Caixa de Ferramentas</b> e o <b>Deseño</b> así como dentro do mesmo deseño.<br><br>Para quitar un campo do deseño, arrastre o campo á <b>Papeleira de Reciclaxe</b>. O campo pasará a estar dispoñible na Caixa de Ferramentas para ser agregado novamente.',
            'defaultquickcreate' => 'O área de <b>Deseño</b> contén os campos que actualmente están sendo mostrados no formulario de <b>Creación Rápida</b>.<br><br>O formulario de Creación Rápida aparece nos subpaneis dun módulo cando o botón Crear é pulsado.<br/><br/>A <b>Caixa de Ferramentas</b> contén a <b>Papeleira de Reciclaxe</b> e os campos e elementos do deseño que poden ser agregados ao mesmo.<br><br>Cambie o deseño arrastrando e soltando elementos e campos entre a <b>Caixa de Ferramentas</b> e o <b>Deseño</b> así como dentro do mesmo deseño.<br><br>Para quitar un campo do deseño, arrastre o campo á <b>Papeleira de Reciclaxe</b>. O campo pasará a estar dispoñible na Caixa de Ferramentas para ser agregado novamente.',
            //this default will be used for edit view
            'default' => 'Realice os cambios na capa mostrada pode arrastrar e soltar elementos  e campos entre as dúas areas nesta páxina. <br/><br/> a columna da esquerda, chamada <b>caixa de Ferramentas</b>, contén ferramentas útiles, elementos e campos para modificar o deseño. <br/><br/> o área a man dereita, chamada <b>Deseño Actual</b> ou <b>Vista previa do deseño</b>, contén o modulo de deseño <br/><br/>Se a área de deseño é chamada <b>Deseño Actual</b> Entón vostede esta traballando nunha copia do deseño que é actualmente mostrado no modulo. <br/><br/>Se a área de deseño é chamada <b>Vista previa do deseño</b> Entón vostede esta traballando nunha copia creada anteriormente Faga click en <b>Gardar</b> Nota: Se outro usuario utiliza unha copia diferente do deseño, a que pode ver nesta área tal vez non coincida coa versión actual.',
            'saveBtn' => 'Faga Click en <b>Gardar</b> para preservar os cambios que faga no deseño. Se non desprega os cambios antes de saír de estudio, os cambios non se mostrarán no módulo. Cando volva a estudio para modificar o deseño, móstrase o deseño cos cambios preservados. O deseño non se mostrara no modulo ata que faga click en <b>Gardar e Utilizar</b>.',
            'historyBtn' => 'Dá clic en <b>Ver historial</b> para ver e restaurar plantillas previamente gardadas.<br><br><b>Restaurar</b> dentro de <b>Historial</b> restaura o primeiro campo creado dentro de plantillas previamente gardadas. Para cambiar etiquetas de campos, dá clic en Editar enseguida de cada campo.',
            'historyDefault' => 'Faga clic en <b>Restaurar por defecto</b> para restablecer unha vista ao seu trazado orixinal. <br><br><b>Restaurar por defecto</b> só restaura a ubicación do campo no deseño orixinal. Para cambiar as etiquetas de campo, faga clic no icono de edición xunto a cada campo.',
            'publishBtn' => 'Faga clic en <b>Gardar e Utilizar</b> para implementar o deseño. <br><br>despois de implementar, o deseño sera inmediatamente mostrado no módulo.',
            'toolbox' => 'A <b>Caixa de Ferramentas</b> contén unha variedade de ferramentas útiles para a edición de deseño, incluíndo a Papeleira, deseño adicional de elementos e o conxunto de campos dispoñibles. <br/><br/>Calquera dos elementos e dos campos se poden arrastrar e soltar no deseño, e calquera deseño dos elementos e campos se poden arrastrar e soltar na papeleira. <br/><br/>Arrastrando unha nova fila ou un novo panel de elementos a o deseño sera  agregado no deseño onde este é quitado. <br/><br/>Un campo de recheo crea espazo en branco no deseño no que se colocara. <br/><br/> Arrastre e solte calquera dos campos dispoñibles a un campo nun panel de intercambio dos dous.',
            'panels' => 'Esta área mostra como o seu deseño publicarase dentro do modulo cando esta se use.<br/><br/>Pode posicionar campos, columnas e paneis arrastrando e soltándolos na posición desexada. <br/><br/>Quite elementos arrastrando e soltándoos na papeleira da caixa de ferramentas, ou agregar novos elementos e campos arrastrando e soltando da caixa de ferramentas na posición desexada no deseño.',
            'delete' => 'Arrastre e solte calquera elemento aqui para remover do deseño',
            'property' => 'Edite a etiqueta mostrada para este campo. <br/>O <b>Orde de Tabulación</b> controla en que orde a tecla tabulador cambiará o foco entre os distintos campos.',
        ),
        'fieldsEditor' => array(
            'default' => 'Todos os campos que estan dispoñibles para o modulo actual estan listados aqui. <br><br> os campos estandar que inclúe o modulo por defecto aparecen na area <b>Por defecto</b>. <br><br> os campos personalizados que foron creados para o modulo aparecen na area <b>Personalizados</b>.<br><br>Para Editar os campos, faga click no <b>Nome do Campo</b>.  Realize os cambios co formulario de <b>Propiedades</b> do panel da dereita, e faga click en <b>Gardar</b>. <br><br>Mentres visualiza as propiedades dos campos, pode crear rapidamente un novo campo con propiedades similares faga click en <b>Clone</b>.Realice os campos que sexan necesarios, e logo faga click en <b>Gardar</b> <br><br>Para crear un campo novo, faga click en <b>Agregar Campo</b>. Intrusca as propiedades para o campo no formulario de <b>Propiedades</b>, e faga click en <b>Gardar</b>. O Campo novo aparecerá  na area <b>Personalizado</b>.<br><br> Para Cambiar as etiquetas de calquera dos campos, faga click en <b>Editar Etiqutas</b>.',
            'mbDefault' => 'Os <b>Campos</b> dispoñibles para un módulo lístanse aquí por Nome de Campo.<br><br>Para personalizar a etiqueta do campo, faga click no nome do campo.<br><br>Para crear un novo campo, faga click en <b>Agregar Campo</b>. A etiqueta e o resto de propiedades do novo campo poden ser editadas trala súa creación facendo click no Nome de Campo.<br><br>Trala implantación do módulo, os novos campos creados co Construtor de módulos serán tratados no Estudio como campos estándar do módulo.',
            'addField' => 'Seleccione un <b>Tipo de Dato</b> para o novo campo. O tipo que seleccione determinará que valores poden introducirse no campo. Por exemplo, só se poderán introducir números enteiros en campos que son do tipo Enteiro.<br><br> Asigne ao campo un <b>Nome</b>.  O nome debe ser alfanumérico e non conter espazos. O carácter guión_baixo tamén é válido.<br><br> a <b>Etiqueta de Visualización</b> é a etiqueta que aparecerá para os campos nos deseño de módulos.  a <b>Etiqueta do Sistema</b> sutilízase para facer referencia ao campo no código.<br><br> Segundo o tipo de datos seleccionado para o campo, algunhas ou todas as seguintes propiedades poderán ser establecidas no mesmo:<br><br> o <b>Texto de Axuda</b> aparece temporalmente cando o usuario mantén o cursor sobre o campo e pode ser utilizado para indicar ao usuario o tipo de entrada desexada.<br><br> o <b>Texto de Comentario</b> só se ve no Estudio e/ou Construtor de módulos, e pode ser utilizado para describir o campo aos administradores.<br><br> o <b>Valor por omisión</b> que aparecerá no campo. Os usuarios poderán introducir un novo valor no campo ou deixar o predeterminado.<br><br> Seleccione a opción de <b>Actualización Masiva</b> para poder utilizar a característica de Actualización Masiva no campo.<br><br>O valor do <b>Tamaño Máximo</b> determina o máximo número de caracteres que poden ser introducidos no campo.<br><br> Seleccione a opción <b>Campo Requirido</b> para que o campo sexa obrigatorio, é decir, debe  suministrarse un valor para este campo para poder gardar un rexistro que o conteña.<br><br> Seleccione a opción <b>Informable</b> para permitir que o campo sexa utilizado en filtros e para mostrar datos en Informes.<br><br> Seleccione a opción <b>Auditar</b> para posibilitar o seguimento dos cambios dos valores do campo no Rexistro de Cambios.<br><br>Seleccione unha das opcións no campo <b>Importable</b> para permitir, prohibir ou requirir que o campo sexa importado mediante o Asistente de Importación.<br><br>Seleccione unha opción no campo <b>Combinar Duplicados</b> para habilitar ou non as características de Combinar Duplicados e Busca de Duplicados.<br><br>Para certos tipos de datos poderanse establecer propiedades adicionais.',
            'editField' => 'As propiedades do campo poden ser personalizadas.<br><br>Faga click en <b>Clonar</b> para crear un novo campo coas mesmas propiedades.',
            'mbeditField' => 'A <b>Etiqueta de Visualización</b> dun campo de Sugar pode ser personalizada. O resto de propiedades do campo non poden ser personalizadas.<br><br>Faga click en <b>Clonar</b> para crear un novo campo coas mesmas propiedades.<br><br>Para quitar un campo de modo que non aparezca no módulo, quite o campo dos <b>Deseño</b> correspondentes.'

        ),
        'exportcustom' => array(
            'exportHelp' => 'Exporte as personalizacións feitas con estudio mediante a creancion de paquetes que pode cargar noutra instancia de SuiteCRM a través do <b>Modulo de Carga</b>.<br><br>Primeiro, provea un <b>Nome do paquete</b>. Pode Proveer información do <b>Autor</b> e <b>Descrición</b> tamén para o paquete.<br><br>Seleccione o modulo(s) que contén as personalizacións  que vostede desexa exportar. Só os módulos que conteñen personalizacións aparecerán para a súa selección. <br><br>a Continuación, faga click en <b>Exportar</b> para crear un arquivo .zip para o paquete que contén as personalizacións.',
            'exportCustomBtn' => 'Faga click en <b>Exportar</b> para crear un arquivo .zip contenedor das personaliacións do paquete que pode exportar.',
            'name' => 'Este é o <b>Nome</b> do paquete. Este nome mostrarase durante a instalacion.',
            'author' => 'Este é o <b>Autor</b>Que se mostra durante a instalación como o nome da entidade que creou o paquete. O autor pode ser tanto unha persoa ou unha empresa.',
            'description' => 'Esta é a  <b>Descrición</b> que se mostra durante a instalación.',
        ),
        'studioWizard' => array(
            'mainHelp' => 'Benvido á area de <b>Ferramentas para desarrolladores</b>. <br/><br/>Utilice as ferramentas dentro desta area de creación e xestión estándar e personalizacion de módulos e campos.',
            'studioBtn' => 'Utilice <b>Estudio</b> para personalizar os módulos instalados.',
            'mbBtn' => 'Use o <b>Contructor de módulos</b> para crear novos módulos.',
            'sugarPortalBtn' => 'Utilice <b>Editor do portal SuiteCRM</b> para administrar e personalizar o portal de SuiteCRM.',
            'dropDownEditorBtn' => 'Utilice o <b>Editor despregable </b> para engadir e editar despregables globais para a aplicación .',
            'appBtn' => 'Utilice o modo de aplicación para personalizar as propiedades incluidas no programa, por exemplo, como moitos dos informes TPS que se mostran na páxina de inicio',
            'backBtn' => 'Volver á etapa anterior.',
            'studioHelp' => 'Use o <b>Studio</b> para personalizar os módulos instalados.',
            'moduleBtn' => 'Faga clic para editar este módulo.',
            'moduleHelp' => 'Os compoñentes do módulo que pode personalizar aparecen aquí.<br><br>Faga click nun icono para seleccionar o compoñente a editar.',
            'fieldsBtn' => 'Crear e personalizar os <b>Campos</b> que almacenan a información no módulo.',
            'labelsBtn' => 'Editar as <b> etiquetas </ b> para mostrar os valores deste módulo.',
            'relationshipsBtn' => 'Agregar novas <b>Relacións</b> do módulo ou ver as existentes.',
            'layoutsBtn' => 'Personalizar os <b>Deseño</b> do módulo.  Os deseño son as diferentes vistas do módulo que conteñen campos.<br><br>Pode establecer que campos aparecen e como son organizados en cada deseño.',
            'subpanelBtn' => 'Determinar que información é mostrada nos <b>Subpanels</b> para este módulo.',
            'portalBtn' => 'Personalizar os <b>Deseño</b> do módulo que aparecen no <b>portal SuiteCRM</b>.',
            'layoutsHelp' => 'Os <b>Deseño</b> dun módulo que poden ser personalizados aparecen aquí.<br><br>Os deseño mostran os campos e os seus datos.<br><br>Faga click nun icono para seleccionar o deseño a editar.',
            'subpanelHelp' => 'Os <b>Subpaneis</b> dun módulo que poden ser personalizados aparecen aquí.<br><br>Faga click nun icono para seleccionar o módulo a editar.',
            'newPackage' => 'Faga Click en <b>Novo Paquete</b> para crear un novo paquete.',
            'exportBtn' => 'Faga clic en <b> Exportar personalizacións </b> para crear un paquete que contén as personalizacións realizadas no Estudio dos módulos específicos.',
            'mbHelp' => 'Use <b>Módulo Builder</b> para crear paquetes que conteñen módulos personalizados baseado en Estandares u obxectos personalizados.',
            'viewBtnEditView' => 'Modifica o deseño do modulo <b>Editar Vista</b>.',
            'viewBtnDetailView' => 'Modifica o deseño do modulo <b>Detalles Vista</b>.',
            'viewBtnDashlet' => 'Personalizar o <b>SuiteCRM Dashlet</b> do módulo, incluíndo a vista de Lista e a Busca do SuiteCRM Dashlet.<br><br>O SuiteCRM Dashlet estará dispoñible para ser engadido ás páxinas do módulo Inicio.',
            'viewBtnListView' => 'Modifica o deseño do modulo <b>Listar Vista</b>.',
            'searchBtn' => 'Modifica o deseño do modulo <b>Busca</b>.',
            'viewBtnQuickCreate' => 'Modifica o deseño do modulo <b>Creación Rápida</b>.',
            'addLayoutHelp' => "Para crear un deseño personalizado para un grupo de seguridade, seleccione o grupo de seguridade apropiado e a disposición a copiar desde un punto de partida.",
            'searchHelp' => 'Os formularios de <b>Busca</b> que poden ser personalizados aparecen aquí. <br><br>Os formularios de Busca conteñen campos para filtrar rexistros.<br><br>Faga click nun icono para seleccionar o deseño de busca a editar.',
            'dashletHelp' => 'Os deseño de <b>SuiteCRM Dashlet</b> que poden ser personalizados aparecen aquí.<br><br>O SuiteCRM Dashlet estará dispoñible para ser engadido ás páxinas do módulo Inicio.',
            'DashletListViewBtn' => 'A <b>vista de Lista de SuiteCRM Dashlet</b> mostra os rexistros baseándose nos fíltros de busca do SuiteCRM Dashlet.',
            'DashletSearchViewBtn' => 'A <b>Busca de SuiteCRM Dashlet</b> filtra os rexistros da vista de lista de SuiteCRM Dashlet.',
            'popupHelp' => 'Os deseño de <b>Ventás Emerxentes</b> que poden ser personalizados aparecen aqui.<br>',
            'PopupListViewBtn' => 'As <b>Listas Emerxentes</b> mostran rexistros basados nas Buscas emerxentes.',
            'PopupSearchViewBtn' => 'A <b>Busca Emerxente</b> mostra rexistros das Listas Emerxentes.',
            'BasicSearchBtn' => 'Modifique o formulario de <b>Filtro Rápido</b> que aparece na pestana de Filtro Rápido na área para o Filtrado no modulo.',
            'AdvancedSearchBtn' => 'Modifique o formulario de <b>Filtro Avanzado</b> que aparece na pestana de Busca Avanzada na área de Busca no modulo.',
            'portalHelp' => 'Administre e personalice o <b>Portal SuiteCRM</b>.',
            'SPUploadCSS' => 'Suba unha <b>Folla de estilos</b> para o Portal SuiteCRM.',
            'SPSync' => '<b>Sync</b> Personalizacións para un instancia do Portal SuiteCRM.',
            'Layouts' => 'Modifique os <b>Deseño</b> dos módulos para o Portal SuiteCRM.',
            'portalLayoutHelp' => 'Os módulos dentro do Portal SuiteCRM aparecen nesta área.<br><br>Seleccione un módulo para editar o <b>Deseño</b>.',
            'relationshipsHelp' => 'Se pode relacionar este módulo a outros módulos no mesmo paquete ou dos módulos xa instalados na Aplicación.<br/><br/> Para crear unha nova relación, faga clic en <b>Engadir Relación</ b>. As propiedades da relación móstranse no formulario na parte dereita do panel. Utilice a lista despregable <b>Relacionado a</b>  para seleccionar o módulo aos que se refieren o módulo actual. <br><br>Provea unha <b>Etiqueta</ b> que aparecerá como título do sub-panel para o correspondente módulo. <br><br>As relacións entre os módulos  xestionaranse a través de sub-paneis que aparecen debaixo da Vistas de detalle nos módulos.<br> <br> Para o sub-panel do modulo relacionado, que podería estar en condicións de seleccionar diferentes sub-panel de deseño, dependendo de en que módulo é seleccionado para a relación. <br/><br/>Faga clic en <b>Gardar </b> para crear unha relación. Faga clic en <b>Eliminar</b> para borrar a relación de seleccionada. <br/><br/> Para editar unha relación existente, faga clic en <b>Nome de Relación</b>, e edite as propiedades dentro do panel a man dereita.',
            'relationshipHelp' => 'As <b>Relacións</b> poden ser creadas entre este módulo e outro módulo personalizado ou implantado.<br><br> as relacións exprésanse visualmente a través de subpaneis e relacionan campos dos rexistros do módulo.<br><br>Seleccione un dos seguintes <b>Tipos</b> de relación para o módulo:<br><br> <b>Un-a-Un</b> - os rexistros de ambos módulos conterán campos relacionados.<br><br> <b>Un-a-Moitos</b> - os rexistros do Módulo Principal conterán un subpanel, e os rexistros do Módulo Relacionado conterán un campo relacionado.<br><br> <b>Moitos-a-Moitos</b> - os rexistros de ambos módulos mostrarán subpaneis.<br><br> Seleccione o <b>Módulo Relacionado</b> para a relación. <br><br>Se o tipo de relación implica o uso de subpaneis, seleccione a vista de subpanel para os módulos correspondentes.<br><br> Faga click en <b>gardar</b> para crear a relación.',
            'convertLeadHelp' => 'Aquí pode engadir módulos para a disposición de convertir a pantalla e modificar os deseño existentes. <br/> Pode reordenar os módulos arrastrando as súas filas na táboa. <br/> <br/> <b>Módulo:</b> o nome do módulo. <br/> <br/> <b>Requirido:</b> os módulos requiridos deben ser creados ou seleccionados antes de que o plomo se pode convertir. <br/> <br/> <b>Copiar datos:</b> Se está activado, os campos da iniciativa copiaranse a campos co mesmo nome nos rexistros recién creados. <br/> <br/> <b>Permitir a selección:</b> os Módulos cun campo de relación nos contactos poden ser seleccionados en lugar de creados durante o proceso de convertir plomo. <br/> <br/> <b>Edición:</b> Modificar o deseño de convertir para este módulo. <br/> <br/> <b>Borrar:</b> Eliminar este módulo da disposición de convertir. <br/> <br/>',


            'editDropDownBtn' => 'Edita un Dropdown xeral',
            'addDropDownBtn' => 'Agrega un novo Dropdown xeral',
        ),
        'fieldsHelp' => array(
            'default' => 'Os <b>Campos</b> do módulo aparecen aquí listados por Nome de Campo.<br><br>A plantilla do módulo inclúe un conxunto predeterminado de campos.<br><br>Para crear un novo campo, faga click en <b>Agregar Campo</b>.<br><br>Para editar un campo, faga click no <b>Nome de Campo</b>.<br/><br/>Trala implantación do módulo, os novos campos creados no Construtor de módulos, así como os campos da plantilla, trataranse como campos estándar no Estudio.',
        ),
        'relationshipsHelp' => array(
            'default' => 'As <b>Relacións</b> que foron creadas entre o módulo e outros módulos aparecen aquí.<br><br>O <b>Nome</b> da relación é un nome xerado polo sistema para a relación.<br><br>O <b>Módulo Principal</b> é o módulo que posúe as relacións. As propiedades da relación son gardadas en táboas da base de datos pertenecentes ao módulo primario.<br><br>O <b>Tipo</b> é o tipo de relación existente entre o Módulo Principal e o <b>Módulo Relacionado</b>.<br><br>Faga clic no título dunha columna para ordear pola columna.<br><br>Faga clic nunha fila da táboa da relación para ver e editar as propiedades asociadas coa relación.<br><br>Faga clic en <b>Agregar Relación</b> para crear unha nova relación.',
            'addrelbtn' => 'axuda emerxente para agregar relación...',
            'addRelationship' => 'As <b>Relacións</b> poden ser creadas entre este módulo e outro módulo personalizado ou implantado.<br><br> as relacións exprésanse visualmente a través de subpaneis e relacionan campos dos rexistros do módulo.<br><br>Seleccione un dos seguintes <b>Tipos</b> de relación para o módulo:<br><br> <b>Un-a-Un</b> - os rexistros de ambos módulos conterán campos relacionados.<br><br> <b>Un-a-Moitos</b> - os rexistros do Módulo Principal conterán un subpanel, e os rexistros do Módulo Relacionado conterán un campo relacionado.<br><br> <b>Moitos-a-Moitos</b> - os rexistros de ambos módulos mostrarán subpaneis.<br><br> Seleccione o <b>Módulo Relacionado</b> para a relación. <br><br>Se o tipo de relación implica o uso de subpaneis, seleccione a vista de subpanel para os módulos correspondentes.<br><br> Faga click en <b>gardar</b> para crear a relación.',
        ),
        'labelsHelp' => array(
            'default' => 'As <b>Etiquetas</b> dos campos, así como outros títulos no módulo, poden ser cambiadas.<br><br>Edite a etiqueta facendo click dentro do campo, introducindo unha nova etiqueta e facendo click en <b>gardar</b>.<br><br>Se hai algún paquete de idioma instalado na aplicación, pode seleccionar o <b>Idioma</b> a utilizar para as etiquetas.',
            'saveBtn' => 'Faga click en <b>gardar</b> para gardar todos os cambios.',
            'publishBtn' => 'Faga click en <b>gardar e implantar</b> para gardar todos os cambios e activalos.',
        ),
        'portalSync' => array(
            'default' => 'Introduza a <b>URL do Portal SuiteCRM</b> da instancia do portal para actualizar, e faga click en <b>Ir</b>.<br><br>Introduza un nome de usuario válido en SuiteCRM e o contrasinal, e logo faga click en <b>Empezar sincronización</b>. <br><br>As Personalizacións realizadas aos <b>deseño</b>do Portal SuiteCRM, xunto coas <b>follas de estilos</b> se un se subiu, transferiranse a un instancia especificada do portal.',
        ),
        'portalStyle' => array(
            'default' => 'Pode personalizar a apariencia do portal de Sugar mediante unha folla de estilos.<br><br>Seleccione a <b>Folla de Estilos</b> a subir.<br><br>A folla de estilos será utilizada no portal Sugar a próxima vez que realice unha sincronización.',
        ),
    ),

    'assistantHelp' => array(
        'package' => array(
            //custom begin
            'nopackages' => 'Para empezar un proxecto, faga clic en <b>Novo Paquete</b> para crear un novo paquete do seu módulo(s) personalizado. <br/><br/> Cada paquete pode conter un ou máis módulos. <br/> <br/> Por exemplo, pode ser que desexa crear un paquete que contén un módulo personalizado que se relaciona co módulo de Contas. Ou ben, vostede pode ser que desexe crear un paquete que contén varios dos novos módulos que traballar xuntos como un proxecto e que están relacionadas entre si e con outros módulos existentes na aplicación.',
            'somepackages' => 'Un <b>paquete</b> actúa como un contenedor de módulos personalizados, que son parte dun proxecto. O paquete pode conter un ou máis <b>módulos personalizados</b>, que poden estar relacionados entre si ou con outros módulos na aplicación. <br/> <br/> Despois de crear un paquete para o seu proxecto, vostede pode crear Módulos dos paquetes de inmediato, ou pode volver ao Construtor de Módulos noutro momento para completar o proxecto. <br><br>Cando o proxecto se completa, pode <b>Despregar</b> para instalar o paquete de módulos personalizados dentro  da aplicación.',
            'afterSave' => 'O Seu novo paquete debe conter polo menos un módulo. Vostede pode crear un ou máis módulos personalizados para o paquete.<br/><br/>Faga clic en <b>Novo Módulo</b> para crear un módulo personalizado para este paquete.<br/><br/>Despois de crear polo menos un módulo, pode publicar ou despregar no paquete para facelo dispoñible na súa instancia e / ou doutras instancias de usuarios. <br/><br/>Para despregar o paquete nun paso dentro da súa instancia de SuiteCRM, faga click en <b>Despregar</b>.<br><br>Faga click en <b>Publicar</b> para gardar o paquete como un arquivo .zip. Despois o arquivo .Zip se garda no seu sistema, utilice o <b>Módulo de Carga</b> para Subir e instalar o paquete na súa instancia de SuiteCRM.<br/><br/> Pode distribuir o arquivo a outros usuarios para cargar e instalar dentro das súas propias instancias de SuiteCRM.',
            'create' => 'Un <b>paquete</b> actúa como un contenedor de módulos personalizados, que son parte dun proxecto. O paquete pode conter un ou máis <b>módulos</b> personalizados, que poden estar relacionados entre si ou con outros módulos na aplicación. <br/><br/>Despois de crear un paquete para o seu proxecto, vostede pode crear Módulos dos paquetes de inmediato, ou pode volver á Construtor de modulos noutro momento para completar o proxecto.',
        ),
        'main' => array(
            'welcome' => 'Utilize  as <b>Ferramentas de Desenvolvemento</b> para crear e manexar estándares e módulos personalizados e campos.<br/><br/>Para administrar os módulos da aplicación, faga click en <b>Estudio</b>.<br/><br/>Para crear módulos personalizados, faga click en <b> Construtor de Modulos</b>.',
            'studioWelcome' => 'Todos os módulos instalados actualmente, incluíndo estándar e os obxectos do módulo de carga, son personalizables dentro Estudio.'
        ),
        'module' => array(
            'somemodules' => "Dado que o actual paquete contén polo menos un módulo, pode <b>Despregar</b> os módulos no paquete dentro da súa instancia de SuiteCRM ou <b>Publicar</b> o paquete que se instalará na actual instancia de SuiteCRM ou outra Instancia utilizando o <b>Módulo de Carga</b>.<br/><br/>Para instalar o paquete directamente dentro da súa instancia de SuiteCRM, faga clic en <b>Despregar</b>.<br><br>Para crear unha arquivo . zip do paquete que pode ser cargado e instalado dentro da instancia actual de SuiteCRM e outros casos utilizando o <b>Módulo  de Carga</b>, faga clic en <b>Publicar</b>. <br/> <br/> Vostede pode construir os módulos deste paquete en etapas, e publicar ou despregar cando estea listo para facelo. <br/><br/>Despois da publicación ou o despregue dun paquete, pode facer cambios no conxunto de propiedades e personalizar os módulos máis. Logo volverá a re-publicar ou re-despregar o paquete para aplicar os cambios.",
            'editView' => 'Aquí pódense editar os campos xa existentes. Vostede pode eliminar calquera dos campos xa existentes ou engadir campos dispoñibles no panel da esquerda.',
            'create' => 'Cando escolla o tipo de <b>Tipo</b> do módulo que desexa crear, teña en conta os tipos de campos que queira que no módulo. <br/><br/>Cada plantilla do módulo contén unha serie de campos relacionados co tipo de módulo descrito polo título.<br/><br/> <b>Básicos</b> -Proporciona campos básicos que aparecen en Módulos estándar, tales como o Nome, Asignado a, o Equipo, Data de creación e o campo Descrición. <br/><br/><b>Empresa</b> - Proporciona campos dunha organización específica, tales como Nome da empresa, a Industria e Enderezo. Utilice esta plantilla para crear módulos que son similares a módulos estandar de contabilidade.<br/><br/><b>Persoa</b> - Proporciona campos específicos dun individuo, como o Saúdo, Título, Nome, Enderezo e Teléfono . Utilice esta plantilla para crear módulos que son similares a módulos estandar de contactos e clientes.<br/><br/><b>Número</b> - Proporciona caso de erro-y campos específicos, tales como Número, estado, prioridade e descrición. Utilice esta plantilla para crear modulos similares aos estandares de Casos e Bug Tracker. <br/><br/> Nota: Despois de crear o módulo, pode editar as etiquetas dos campos proporcionado pola plantilla, así como Crear campos personalizados para agregar ao deseño do módulo.',
            'afterSave' => 'Personalice o módulo para que se adapte a as súas necesidades de edición e creación de campos, estableza  relacións con outros módulos e a organización dos campos dentro do deseño.<br/><br/>Para ver os campos da plantilla e xestionar os campos personalizados no módulo, faga clic en <b>Ver Campos</b>.<br/><br/>Para crear e manexar as relacións entre o módulo e outros módulos, xa sexan módulos existentes u outros módulos personalizados no mesmo paquete, faga clic en <b>Ver Relacións</b>.<br/><br/>Para editar os deseño módulo, faga clic en <b>Ver Deseño</b>. Pode cambiar a Vista Detallada, Editar Vista e Listar Vista de deseño para o modulo só poderá para os módulos existentes na aplicación dentro de estudio.<br/><br/>Para crear un módulo coas mesmas propiedades do módulo actual, Faga clic en <b>Duplicar</b>. Pode personalizar aínda máis o módulo novo.',
            'viewfields' => 'Os campos no módulo pode ser personalizado para satisfacer as súas necesidades.<br/><br/>Non pode eliminar campos estándar, pero pode quitalos dos deseño apropiados dentro dos deseño de páxinas.<br/><br/>Pode editar as etiquetas dos campos estándar. As outras propiedades dos campos estándar non son editables. Porén, vostede pode crear rápidamente novos campos que teñen propiedades similares, faga clic no nome dun campo y, a continuación, faga clic en <b>Clone</b> no formulario de <b>Propiedades</ b>. Introduza as novas propiedades e, a continuación, faga clic en <b>Gardar</b>.<br/> <br/> Se vostede personaliza un novo módulo, unha vez que o módulo se instale, non todas as propiedades dos campos poden ser editadas. Configure de todas as propiedades dos campos estándar e campos personalizados antes de publicar e instalar o paquete que contén o módulo personalizado.',
            'viewrelationships' => 'Pode crear relacións varios-a-varios entre o actual módulo e outros módulos no paquete, e / ou entre o actual módulo e os módulos xa instalados na aplicación.<br><br>Para crear relacións un-a-varios e un-a-un, cree <b>Relacionar</b> e <b>Relacionar Flex</b>campos dos módulos.',
            'viewlayouts' => 'Pode controlar que campos están dispoñibles para a captura de datos dentro de <b>Editar Vista</b>. Tamén se pode controlar os datos  que se mostra dentro de <b>Ver Detalles</b>. As vistas non teñen que coincidir.<br/><br/> a creación rápida dun formulario é mostrada cando se fai clic en <b>Crear</ b>nun módulo subpanel. Por defecto, <b>Crear Rápido</ b> o formulario do deseño é o mesmo por defecto que o deseño de <b>Editar Vista</b>. Pode personalizar de forma rápida Crear de maneira que conteña menos e / ou diferentes campos da Vista de Deseño.<br><br> Pode determinar o módulo de seguridade o usando a personalizacion do deseño xunto con <b>Xestión de Roles</b>.<br><br>',
            'existingModule' => 'Despois da creación e personalización deste módulo, pode crear módulos adicionais ou regresar ao paquete a <b>Publicar</b> ou <b>Despregar</b> o paquete.<br><br>Para crear módulos adicionais, faga clic en <b>Duplicar</b> para crear un módulo coas mesmas propiedades que o actual módulo, ou navegar de volta ao paquete, e faga clic en <b>Novo Módulo</b>.<br><br>Se está listo a <b>Publicar</b> ou <b>Despregar</ b>, o paquete que contén este módulo, navegar de volta ao paquete para realizar estas funcións. Pode publicar e despregar paquetes que conteñan polo menos un módulo.',
            'labels' => 'As etiquetas dos campos estandar así como os campos personalizados pódense cambiar. Cambiar etiquetas dun campo non afectará aos datos almacenados nos campos.',
        ),
        'listViewEditor' => array(
            'modify' => 'Hai tres columnas que aparecen á esquerda. A Columna "por defecto" contén os campos que se mostran nunha vista de lista por defecto, a columna "Dispoñible" contén os campos que o usuario pode escoller para crear unha vista dunha lista personalizada, e a columna "Oculto" contén os campos dispoñibles para o seu uso Como administrador para engadir ás xa sexa por defecto ou columnas dispoñibles para o seu uso polos usuarios, pero se encontra inhabilitado.',
            'savebtn' => 'Ao facer clic en <b>Gardar</b> gardar todos os cambios e fai que este activo',
            'Hidden' => 'Campos ocultos son campos que non están dispoñibles actualmente para os usuarios para o uso en vista de lista.',
            'Available' => 'Campos dispoñibles son os campos que non se mostran por defecto, pero pode ser activado polos usuarios.',
            'Default' => 'Por defecto móstranse os campos aos usuarios que non crearon unha lista personalizada na vista de axustes.'
        ),

        'searchViewEditor' => array(
            'modify' => 'Hai dúas columnas mostradas á esquerda. A columna "por defecto" contén os campos que se mostrarán na vista de busca, e a columna "Oculto" contén os campos dispoñibles para vostede como un administrador para engadir á vista.',
            'savebtn' => 'Ao facer clic en <b>Gardar e Despregar</b> garda todos os cambios e os fai activos',
            'Hidden' => 'Campos oculto son campos que non se mostra na vista de busca.',
            'Default' => 'Campos por defecto que se mostrarán na vista de busca.'
        ),
        'layoutEditor' => array(
            'default' => 'Hai dúas columnas mostradas á esquerda. A columna da dereita, o actual deseño da etiqueta ou de deseño da vista previa, é onde se cambia o deseño do módulo. A columna da esquerda, titulado Caixa de ferramentas, contén elementos útiles e ferramentas para o seu uso cando a edición do deseño. <br/><br/> Se a area de deseño,  que levará por título Deseño Actual entón está traballando nunha copia do deseño actualmente utilizado o módulo de visualización.<br/><br/>Se é chamado Vista previa de deseño de entón Están traballando nunha copia creada anteriormente por un clic no botón Gardar, xa que podería ter sido cambiado a partir da versión vista polos usuarios deste módulo.',
            'saveBtn' => 'Ao facer clic neste botón garda o deseño de modo que vostede poida conservar os seus cambios. Ao volver a este módulo empezará a partir deste deseño modificado. O seu deseño porén non será visto polos usuarios do módulo ata que faga clic no botón Gardar e Publicar.',
            'publishBtn' => 'Faga clic neste botón para despregar o deseño. Isto significa que este deseño será inmediatamente visto polos usuarios deste módulo.',
            'toolbox' => 'A caixa de ferramentas contén unha variedade de funcións útiles para a edición de deseño, incluíndo unha área da lixo, un conxunto de elementos adicionais e un conxunto de campos dispoñibles. Calquera destes pode ser arrastrado e colocado no deseño.',
            'panels' => 'Esta zona mostra a forma en que o seu deseño se verá aos usuarios deste módulo cando este sexa mostrado.<br/><br/>Pode reposicionar elementos tales como campos, filas e paneis arrastrándoos e soltándoos; eliminar elementos arrastrándoos e soltándoos na zona da lixo na caixa de ferramentas, ou engadir novos elementos arrastrándoos da caixa de ferramentas e soltándoos sobre eles no deseño na posición desexada.'
        ),
        'dropdownEditor' => array(
            'default' => 'Hai dúas columnas mostradas á esquerda. A columna da dereita, o actual deseño da etiqueta ou de deseño da vista previa, é onde se cambia o deseño do módulo. A columna da esquerda, titulado Caixa de ferramentas, contén elementos útiles e ferramentas para o seu uso cando a edición do deseño. <br/><br/> Se a area de deseño,  que levará por título Deseño Actual entón está traballando nunha copia do deseño actualmente utilizado o módulo de visualización.<br/><br/>Se é chamado Vista previa de deseño de entón Están traballando nunha copia creada anteriormente por un clic no botón Gardar, xa que podería ter sido cambiado a partir da versión vista polos usuarios deste módulo.',
            'dropdownaddbtn' => 'Ao facer clic neste botón engade un novo elemento á lista despregable.',

        ),
        'exportcustom' => array(
            'exportHelp' => 'Exporte personalizacións realizadas en Estudio mediante a creación de paquetes que se poden cargar noutra instancia de SuiteCRM a través do <b>Módulo de Carga</b>.<br><br>En primeiro lugar, proporcione un <b>Nome do paquete</b>. Pode proporcionar <b>Autor</b> e <b>Descrición</b> para a información do paquete tamén.<br><br>Seleccione o módulo(s) que conteñen a personalizacións que desexa exportar. Só os módulos que contén personalizacións aparecerá para seleccionar.<br><br> A continuación, faga clic en <b>Exportar</b> para crear un Arquivo .zip para o paquete que contén os cambios.',
            'exportCustomBtn' => 'Click <b>Export</b> to create a .zip file for the package containing the customizations that you wish to export.',
            'name' => 'Este é o <b>Nome</b> do paquete. Este nome sera mostrado durante a instalación.',
            'author' => 'O <b>Autor</b> é o nome da entidade que creou o paquete. O autor pode ser un individuo ou unha empresa.<br><br>O autor mostrarase no Cargador de Modulo despois de que o paquete se teña subido para instalalo con Studio.',
            'description' => 'Este é a <b>Descrición</b> do paquete que se mostra durante a instalación.',
        ),
        'studioWizard' => array(
            'mainHelp' => 'Benvido á area <b>Ferramentas de Desenvolvemento</b>.<br/><br/> Utilize as ferramentas dentro desta area para crear e manexar estandares e personalizar modulos e campos.',
            'studioBtn' => 'Utilice <b>Estudio</b> para personalizar os módulos instalados pora cambiar a organización dos campos, seleccionando que campos estan dispoñibles e creando campos de datos personalizados.',
            'mbBtn' => 'Use o <b> Contructor de módulos </b> para crear novos módulos',
            'appBtn' => 'Utilice o modo de aplicación para personalizar as propiedades incluidas no programa, por exemplo, como moitos dos informes TPS que se mostran na páxina de inicio',
            'backBtn' => 'Volver á etapa anterior.',
            'studioHelp' => 'Use o <b>Studio</b> para personalizar os módulos instalados.',
            'moduleBtn' => 'Faga clic para editar este módulo.',
            'moduleHelp' => 'Seleccione o compoñente do módulo que desexa editar',
            'fieldsBtn' => 'Modificar o tipo de información que se almacena no módulo de control da <b> Campos</b> no módulo.<br/><br/>Pode editar e crear campos personalizados aquí.',
            'labelsBtn' => 'Editar as <b> etiquetas </b> para mostrar os valores deste módulo.',
            'layoutsBtn' => 'Personalizar as <b> vistas </b> do deseño da edición, o detalle, o listado e a busca.',
            'subpanelBtn' => 'Editar a información que se mostra nos subpaneis dos módulos.',
            'layoutsHelp' => 'Seleccione un <b>Deseño para editar</b>.<br/><br/>Para cambiar o formato que contén os campos de datos para a entrada de datos, fai clic en <b>Editar Vista</b>.<br/><br/>Para cambiar o deseño que mostra os datos introducidos no campo no editor de Vista, fai clic en <b>Ver Detalles</b>. <br/><br/> Para cambiar as columnas que aparecen na lista por defecto, fai click en <b>Vista de lista</b>.<br/><br/>Para cambiar a busca Básica e Avanzada, fai clic en <b>Buscar</b>.',
            'subpanelHelp' => 'Seleccione un <b>Subpanel</b> para editar.',
            'searchHelp' => 'Seleccione un deseño de <b>Busca</b> para editar.',
            'newPackage' => 'Faga clic en <b>Novo Paquete</b> para crear un novo paquete.',
            'mbHelp' => '<b>Benvido ao Construtor de Módulos</ b>. <br/><br/>Use o <b>Construtor de Módulos</ b> para crear paquetes que conteñen módulos personalizados baseados en estandares obxectos personalizados. <br/><br/>Para empezar, faga clic en <b>Novo Paquete</ b> para crear un novo paquete, ou seleccione un paquete para editar. <br/> <br/> Un<b>Paquete</b> Actúa como un contedor de módulos personalizados, que son parte dun proxecto. O paquete pode conter un ou máis módulos personalizados que poden ser relacionados uns con outros ou cos módulos na aplicación. <br/> <br/> Exemplos: é posible que desexe crear un paquete que contén un módulo personalizado que se relaciona co módulo estándar de Contas. Ou ben, vostede pode ser que desexe crear un paquete que contén varios dos novos módulos que traballan xuntos como un proxecto e que están relacionadas entre si e cos módulos na aplicación.',
            'exportBtn' => 'Faga clic en <b> Exportar personalizacións </b> para crear un paquete que contén as personalizacións realizadas no Estudio dos módulos específicos.',
        ),


    ),
//HOME
    'LBL_HOME_EDIT_DROPDOWNS' => 'Editor de Listas Despregables',

//STUDIO2
    'LBL_MODULEBUILDER' => 'Construtor de Módulos',
    'LBL_STUDIO' => 'Estudio',
    'LBL_DROPDOWNEDITOR' => 'Editor de Listas Despregables',
    'LBL_DEVELOPER_TOOLS' => 'Ferramentas de Desenvolvemento',
    'LBL_SUITEPORTAL' => 'Editor do Portal SuiteCRM',
    'LBL_PACKAGE_LIST' => 'Lista de paquetes',
    'LBL_HOME' => 'Inicio',
    'LBL_NONE' => '-Ningún-',
    'LBL_DEPLOYE_COMPLETE' => 'Despregue completado',
    'LBL_DEPLOY_FAILED' => 'Ocurreu un erro durante o proceso de despregue. É posible que o seu paquete non fora instalado correctamente',
    'LBL_AVAILABLE_SUBPANELS' => 'Subpaneis Dispoñibles',
    'LBL_ADVANCED' => 'Avanzada',
    'LBL_ADVANCED_SEARCH' => 'Filtro avanzado',
    'LBL_BASIC' => 'Básica',
    'LBL_BASIC_SEARCH' => 'Filtro rápido',
    'LBL_CURRENT_LAYOUT' => 'Deseño',
    'LBL_CURRENCY' => 'Moeda',
    'LBL_DASHLET' => 'SuiteCRM Dashlet',
    'LBL_DASHLETLISTVIEW' => 'Vista de Lista de SuiteCRM Dashlet',
    'LBL_POPUP' => 'Vista Emerxente',
    'LBL_POPUPLISTVIEW' => 'Vista de Lista Emerxente',
    'LBL_POPUPSEARCH' => 'Busca Emerxente',
    'LBL_DASHLETSEARCHVIEW' => 'Busca de SuiteCRM Dashlet',
    'LBL_DETAILVIEW' => 'Vista Detallada',
    'LBL_DROP_HERE' => '[Soltar Aquí]',
    'LBL_EDIT' => 'Editar',
    'LBL_EDIT_LAYOUT' => 'Editar Deseño',
    'LBL_EDIT_FIELDS' => 'Editar Campos',
    'LBL_EDITVIEW' => 'Vista de Edición',
    'LBL_FILLER' => '(recheo)',
    'LBL_FIELDS' => 'Campos',
    'LBL_FAILED_TO_SAVE' => 'Fallo ao Gardar',
    'LBL_FAILED_PUBLISHED' => 'Fallo Ao Publicar',
    'LBL_HOMEPAGE_PREFIX' => 'Mi',
    'LBL_LAYOUT_PREVIEW' => 'Vista Preliminar do Deseño',
    'LBL_LAYOUTS' => 'Deseño',
    'LBL_LISTVIEW' => 'Vista de Lista',
    'LBL_MODULES' => 'Módulos:',
    'LBL_MODULE_TITLE' => 'Estudio',
    'LBL_NEW_PACKAGE' => 'Novo Paquete',
    'LBL_NEW_PANEL' => 'Novo Panel',
    'LBL_NEW_ROW' => 'Nova Fila',
    'LBL_PACKAGE_DELETED' => 'Paquete Eliminado',
    'LBL_PUBLISHING' => 'Publicando ...',
    'LBL_PUBLISHED' => 'Publicado',
    'LBL_SELECT_FILE' => 'Seleccionar Arquivo',
    'LBL_SUBPANELS' => 'Subpaneis',
    'LBL_SUBPANEL' => 'Subpanel',
    'LBL_SUBPANEL_TITLE' => 'Título:',
    'LBL_SEARCH_FORMS' => 'Busca',
    'LBL_SEARCH' => 'Busca',
    'LBL_SEARCH_BUTTON' => 'Busca',
    'LBL_FILTER' => 'Filtro',
    'LBL_TOOLBOX' => 'Caixa de Ferramentas',
    'LBL_QUICKCREATE' => 'Creación Rápida',
    'LBL_EDIT_DROPDOWNS' => 'Editar un menu despregable Global',
    'LBL_ADD_DROPDOWN' => 'Agregar un menu despregable Global',
    'LBL_BLANK' => '-baleiro-',
    'LBL_TAB_ORDER' => 'Órden de Tabulación',
    'LBL_TABDEF_TYPE' => 'Tipo de Visualización:',
    'LBL_TABDEF_TYPE_HELP' => 'Seleccione a forma na que se debe mostra esta sección. Esta opción unicamente terá efecto se habilitaou o modo pestanas para esta vista.',
    'LBL_TABDEF_TYPE_OPTION_TAB' => 'Pestana',
    'LBL_TABDEF_TYPE_OPTION_PANEL' => 'Panel',
    'LBL_TABDEF_TYPE_OPTION_HELP' => 'Seleccione Panel para que o panel se mostre na vista inicial ou na vista do panel anterior que fora seleccionado como Pestana.  <br/>Seleccione Pestana para mostrar o panel nunha pestana independiente. Cando se seleccionou un panel como Pestana, os seguintes paneis seleccionados como Panel mostraranse na vista de dita pestana.  <br/>Sempre que seleccione un panel como Pestana será o primeiro panel a mostrar en dita Pestana.  <br/>Se se selecciona como Pestana o segundo panel ou posteriores, o primeiro panel establecerase automaticamente como Pestana se se tivera seleccionado anteriormente como Panel.',
    'LBL_TABDEF_COLLAPSE' => 'Contraído',
    'LBL_TABDEF_COLLAPSE_HELP' => 'Seleccione para que por defecto o estado do panel sexa contraído.',
    'LBL_DROPDOWN_TITLE_NAME' => 'Nome',
    'LBL_DROPDOWN_LANGUAGE' => 'Idioma',
    'LBL_DROPDOWN_ITEMS' => 'Elementos de Lista',
    'LBL_DROPDOWN_ITEM_NAME' => 'Nome do Elemento',
    'LBL_DROPDOWN_ITEM_LABEL' => 'Mostrar Etiqueta',
    'LBL_SYNC_TO_DETAILVIEW' => 'Sincroniza con Vista de Detalle',
    'LBL_SYNC_TO_DETAILVIEW_HELP' => 'Seleccione esta opción para sincronizar o deseño da Vista de Edición co correspondente deseño da Vista de Detalle. Os campos e a súa colocación na Vista de Detalle serán sincronizados e gardados automaticamente na Vista de Detalle ao pulsar en Gardar or Gardar e Despregar na Vista de Edición. Non se poderán realizar cambios no deseño da Vista de Detalle.',
    'LBL_SYNC_TO_DETAILVIEW_NOTICE' => 'Este DetailView é sincronizado co EditView correspondente. <br> Campos e colocación sobre o terreo neste DetailView reflicten os campos e colocación sobre o terreo non EditView. <br> Cambios en DetailView non pode ser salvado ou despregados desde esta páxina. Realizar os cambios ou quitar sincronización na vista de EditView.',
    'LBL_COPY_FROM_EDITVIEW' => 'Copiar da Vista de Edición',
    'LBL_DROPDOWN_BLANK_WARNING' => 'Os valores son necesarios tanto para o nome do elemento e a etiqueta de visualización. Para agregar un elemento en branco, faga clic en Agregar, sen entrar en ningún valor para o nome do elemento e a etiqueta de visualización.',
    'LBL_DROPDOWN_KEY_EXISTS' => 'Clave xa existe na lista',
    'LBL_NO_SAVE_ACTION' => 'Non se puido encontrar a opción de gardar para esta vista.',
    'LBL_BADLY_FORMED_DOCUMENT' => 'Studio2:establishLocation: documento mal constituido',


//RELATIONSHIPS
    'LBL_MODULE' => 'Módulo',
    'LBL_LHS_MODULE' => 'Módulo Principal',
    'LBL_CUSTOM_RELATIONSHIPS' => '* relación creada no Estudio',
    'LBL_RELATIONSHIPS' => 'Relacións',
    'LBL_RELATIONSHIP_EDIT' => 'Editar Relación',
    'LBL_REL_NAME' => 'Nome',
    'LBL_REL_LABEL' => 'Etiqueta',
    'LBL_REL_TYPE' => 'Tipo',
    'LBL_RHS_MODULE' => 'Módulo Relacionado',
    'LBL_NO_RELS' => 'Sen Relacións',
    'LBL_RELATIONSHIP_ROLE_ENTRIES' => 'Condición Opcional',
    'LBL_RELATIONSHIP_ROLE_COLUMN' => 'Columna',
    'LBL_RELATIONSHIP_ROLE_VALUE' => 'Valor',
    'LBL_SUBPANEL_FROM' => 'Subpanel de',
    'LBL_RELATIONSHIP_ONLY' => 'Non se creará ningún elemento visible para esta relación xa que existía anteriormente unha relación visible entre estos dous módulos.',
    'LBL_ONETOONE' => 'Un a Un',
    'LBL_ONETOMANY' => 'Un a Moitos',
    'LBL_MANYTOONE' => 'Moitos a Un',
    'LBL_MANYTOMANY' => 'Moitos a Moitos',


//STUDIO QUESTIONS
    'LBL_QUESTION_EDIT' => 'Seleccione un módulo a editar.',
    'LBL_QUESTION_LAYOUT' => 'Seleccione un deseño a editar.',
    'LBL_QUESTION_SUBPANEL' => 'Seleccione un subpanel a editar.',
    'LBL_QUESTION_SEARCH' => 'Seleccione un deseño de busca a editar.',
    'LBL_QUESTION_MODULE' => 'Seleccione un compoñente de módulo a editar.',
    'LBL_QUESTION_PACKAGE' => 'Seleccione un paquete a editar, ou cree un novo paquete.',
    'LBL_QUESTION_EDITOR' => 'Seleccione unha ferramenta.',
    'LBL_QUESTION_DASHLET' => 'Seleccione un deseño de dashlet a editar.',
    'LBL_QUESTION_POPUP' => 'Seleccione un deseño emerxente a editar.',
//CUSTOM FIELDS
    'LBL_NAME' => 'Nome',
    'LBL_LABELS' => 'Etiquetas',
    'LBL_MASS_UPDATE' => 'Actualización Masiva',
    'LBL_DEFAULT_VALUE' => 'Valor por defecto',
    'LBL_REQUIRED' => 'Requirido',
    'LBL_DATA_TYPE' => 'Tipo',
    'LBL_HCUSTOM' => 'PERSONALIZADO',
    'LBL_HDEFAULT' => 'POR DEFECTO',
    'LBL_LANGUAGE' => 'Idioma:',
    'LBL_CUSTOM_FIELDS' => 'campo creado en Estudio',

//SECTION
    'LBL_SECTION_EDLABELS' => 'Editar Etiquetas',
    'LBL_SECTION_PACKAGES' => 'Paquetes',
    'LBL_SECTION_PACKAGE' => 'Paquete',
    'LBL_SECTION_MODULES' => 'Módulos',
    'LBL_SECTION_DROPDOWNS' => 'Listas Despregables',
    'LBL_SECTION_PROPERTIES' => 'Propiedades',
    'LBL_SECTION_DROPDOWNED' => 'Editar Lista Despregable',
    'LBL_SECTION_HELP' => 'Axuda',
    'LBL_SECTION_MAIN' => 'Principal',
    'LBL_SECTION_FIELDEDITOR' => 'Editar Campo',
    'LBL_SECTION_DEPLOY' => 'Despregar',
    'LBL_SECTION_MODULE' => 'Módulo',
//WIZARDS

//LIST VIEW EDITOR
    'LBL_DEFAULT' => 'Por Defecto',
    'LBL_HIDDEN' => 'Oculto',
    'LBL_AVAILABLE' => 'Dispoñible',
    'LBL_LISTVIEW_DESCRIPTION' => 'A continuación móstranse tres columnas. A columna <b>Por Defecto</b> contén os campos que se mostran nunha lista por defecto. A columna <b>Adicional</b> contén campos que un usuario pode escoller á hora de crear unha vista personalizada. A columna <b>Dispoñible</b> mostra columnas dispoñibles para vostede como administrador para, ou ben engadilas ás columnas Por Defecto, ou ás Adicionais para que sexan usadas por usuarios.',
    'LBL_LISTVIEW_EDIT' => 'Editor de Listas',

//Manager Backups History
    'LBL_MB_PREVIEW' => 'Vista Preliminar',
    'LBL_MB_RESTORE' => 'Restaurar',
    'LBL_MB_DELETE' => 'Eliminar',
    'LBL_MB_DEFAULT_LAYOUT' => 'Deseño por Defecto',

//END WIZARDS

//BUTTONS
    'LBL_BTN_ADD' => 'Agregar',
    'LBL_BTN_SAVE' => 'Gardar',
    'LBL_BTN_SAVE_CHANGES' => 'Gardar Cambios',
    'LBL_BTN_DONT_SAVE' => 'Descartar Cambios',
    'LBL_BTN_CANCEL' => 'Cancelar',
    'LBL_BTN_CLOSE' => 'Cerrar',
    'LBL_BTN_SAVEPUBLISH' => 'Gardar e Despregar',
    'LBL_BTN_CLONE' => 'Clonar',
    'LBL_BTN_ADDROWS' => 'Agregar Filas',
    'LBL_BTN_ADDFIELD' => 'Agregar Campo',
    'LBL_BTN_ADDDROPDOWN' => 'Agregar Lista Despregable',
    'LBL_BTN_SORT_ASCENDING' => 'Ordear Ascendete',
    'LBL_BTN_SORT_DESCENDING' => 'Ordear Descendente',
    'LBL_BTN_EDLABELS' => 'Editar Etiquetas',
    'LBL_BTN_UNDO' => 'Desfacer',
    'LBL_BTN_REDO' => 'Refacer',
    'LBL_BTN_ADDCUSTOMFIELD' => 'Agregar Campo Personalizado',
    'LBL_BTN_EXPORT' => 'Exportar Personalizacións',
    'LBL_BTN_DUPLICATE' => 'Duplicar',
    'LBL_BTN_PUBLISH' => 'Publicar',
    'LBL_BTN_DEPLOY' => 'Despregar',
    'LBL_BTN_EXP' => 'Exportar',
    'LBL_BTN_DELETE' => 'Eliminar',
    'LBL_BTN_VIEW_LAYOUTS' => 'Ver Deseño',
    'LBL_BTN_VIEW_FIELDS' => 'Ver Campos',
    'LBL_BTN_VIEW_RELATIONSHIPS' => 'Ver Relacións',
    'LBL_BTN_ADD_RELATIONSHIP' => 'Agregar Relación',
    'LBL_BTN_RENAME_MODULE' => 'Cambiar o Nome do Módulo',
//TABS


//ERRORS
    'ERROR_ALREADY_EXISTS' => 'Erro: o campo xa existe',
    'ERROR_INVALID_KEY_VALUE' => "Erro: Valor de Clave non Válido: [&#39;]",
    'ERROR_NO_HISTORY' => 'Non se encontraron arquivos no historial',
    'ERROR_MINIMUM_FIELDS' => 'O deseño debe conter polo menos un campo',
    'ERROR_GENERIC_TITLE' => 'Ocurreu un erro',
    'ERROR_REQUIRED_FIELDS' => '¿Está seguro de que desexa continuar? os seguintes campos requiridos non se encontran no deseño:',


//PACKAGE AND MODULE BUILDER
    'LBL_PACKAGE_NAME' => 'Nome do Paquete:',
    'LBL_MODULE_NAME' => 'Nome do Módulo:',
    'LBL_AUTHOR' => 'Autor:',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_KEY' => 'Clave:',
    'LBL_ADD_README' => 'Léame',
    'LBL_LAST_MODIFIED' => 'Última Modificación:',
    'LBL_NEW_MODULE' => 'Novo Módulo',
    'LBL_LABEL' => 'Etiqueta:',
    'LBL_LABEL_TITLE' => 'Etiqueta',
    'LBL_WIDTH' => 'Anchura',
    'LBL_PACKAGE' => 'Paquete:',
    'LBL_TYPE' => 'Tipo:',
    'LBL_NAV_TAB' => 'Pestana de Navegación',
    'LBL_CREATE' => 'Crear',
    'LBL_LIST' => 'Lista',
    'LBL_VIEW' => 'Vista',
    'LBL_HISTORY' => 'Ver Historial',
    'LBL_RESTORE_DEFAULT' => 'Restaurar Vista Por Defecto',
    'LBL_ACTIVITIES' => 'Actividades',
    'LBL_NEW' => 'Novo',
    'LBL_TYPE_BASIC' => 'básico',
    'LBL_TYPE_COMPANY' => 'empresa',
    'LBL_TYPE_PERSON' => 'persoa',
    'LBL_TYPE_ISSUE' => 'problema',
    'LBL_TYPE_SALE' => 'venda',
    'LBL_TYPE_FILE' => 'arquivo',
    'LBL_RSUB' => 'Este é o subpanel que se mostrará no seu módulo',
    'LBL_MSUB' => 'Este é o subpanel que o seu módulo proporciona para que sexa mostrado polo módulo relacionado',
    'LBL_MB_IMPORTABLE' => 'Importable',

// VISIBILITY EDITOR
    'LBL_PACKAGE_WAS_DELETED' => '[[package]] foi eliminado',

//EXPORT CUSTOMS
    'LBL_EC_TITLE' => 'Exportar personalizacións',
    'LBL_EC_NAME' => 'Nome do Paquete:',
    'LBL_EC_AUTHOR' => 'Autor:',
    'LBL_EC_DESCRIPTION' => 'Descrición:',
    'LBL_EC_CHECKERROR' => 'Por favor, seleccione un módulo.',
    'LBL_EC_CUSTOMFIELD' => 'campos personalizados',
    'LBL_EC_CUSTOMLAYOUT' => 'deseño personalizados',
    'LBL_EC_NOCUSTOM' => 'Non se personalizou ningún módulo.',
    'LBL_EC_EMPTYCUSTOM' => 'ten baleiras as personalizacións.',
    'LBL_EC_EXPORTBTN' => 'Exportar',
    'LBL_MODULE_DEPLOYED' => 'O módulo foi desplegado.',
    'LBL_UNDEFINED' => 'non definido',
    'LBL_EC_VIEWS' => 'vista(s) personalizada(s)',
    'LBL_EC_SUITEFEEDS' => 'feed(s) personalizados',
    'LBL_EC_DASHLETS' => 'Dashlet(s) personalizado(s)',
    'LBL_EC_CSS' => 'css personalizado',
    'LBL_EC_TPLS' => 'tpl(s) personalizado(s)',
    'LBL_EC_IMAGES' => 'imaxes personalizadas',
    'LBL_EC_JS' => 'js(s) personalizado(s)',
    'LBL_EC_QTIP' => 'qtip(s) personalizado(s)',

//AJAX STATUS
    'LBL_AJAX_FAILED_DATA' => 'Erro ao recuperar datos',
    'LBL_AJAX_LOADING' => 'Cargando...',
    'LBL_AJAX_DELETING' => 'Eliminando...',
    'LBL_AJAX_BUILDPROGRESS' => 'Construción en Progreso...',
    'LBL_AJAX_DEPLOYPROGRESS' => 'Desprege en Progreso...',

    'LBL_AJAX_RESPONSE_TITLE' => 'Resultado',
    'LBL_AJAX_RESPONSE_MESSAGE' => 'Esta operación realizouse correctamente',
    'LBL_AJAX_LOADING_TITLE' => 'En curso...',
    'LBL_AJAX_LOADING_MESSAGE' => 'Por favor espere, cargando...',

//JS
    'LBL_JS_REMOVE_PACKAGE' => '¿Está seguro de que desexa quitar este paquete? Isto eliminará permanentemente todos os arquivos asociados con este paquete.',
    'LBL_JS_REMOVE_MODULE' => '¿Está seguro de que desexa quitar este módulo? Isto eliminará permanentemente todos os arquivos asociados con este módulo.',
    'LBL_JS_DEPLOY_PACKAGE' => 'Calquera personalización que realizara no Estudio será sobrescrita cando este módulo sexa desplegado de novo. ¿Está seguro de que desexa proceder?',

    'LBL_DEPLOY_IN_PROGRESS' => 'Desplegando Paquete',
    'LBL_JS_VALIDATE_NAME' => 'Nome - Debe ser alfanumérico, sen espazos e comenzando por letra',
    'LBL_JS_VALIDATE_PACKAGE_NAME' => 'O Nome do Paquete xa existe',
    'LBL_JS_VALIDATE_KEY' => 'Clave - Debe ser alfanumérica',
    'LBL_JS_VALIDATE_LABEL' => 'Por favor, introduza a etiqueta que se utilizará como Nome Visible deste módulo',
    'LBL_JS_VALIDATE_TYPE' => 'Por favor, seleccione o tipo de módulo que quere construir da lista anterior',
    'LBL_JS_VALIDATE_REL_LABEL' => 'Etiqueta - por favor, agregue a etiqueta que será mostrada sobre o subpanel',

//CONFIRM
    'LBL_CONFIRM_FIELD_DELETE' => 'Ao eliminar este campo personalizado, eliminará tanto o campo como todos os seus datos da base de datos. O campo xa non aparecerá en ningún dos deseño de módulo.\n\n¿Desexa continuar?',

    'LBL_CONFIRM_RELATIONSHIP_DELETE' => '¿Está seguro de que desexa eliminar esta relación?',
    'LBL_CONFIRM_DONT_SAVE' => 'Hai cambios pendentes de ser gardados, ¿desexa gardalos agora?',
    'LBL_CONFIRM_DONT_SAVE_TITLE' => '¿Gardar Cambios?',
    'LBL_CONFIRM_LOWER_LENGTH' => 'Os datos poden ser truncados e isto non poderá desfacerse, ¿está seguro de que desexa continuar?',

//POPUP HELP
    'LBL_POPHELP_FIELD_DATA_TYPE' => 'Seleccione o tipo de datos apropiado acorde co tipo de datos que será introducido no campo.',
    'LBL_POPHELP_IMPORTABLE' => '<b>Sí</b>: O campo será incluido nunha operación de importación.<br><b>No</b>: O campo non será incluido nunha importación.<br><b>Requirido</b>: Debe de subministrarse un valor para o campo en toda importación.',
    'LBL_POPHELP_IMAGE_WIDTH' => 'Introduza un número para a Anchura, como medida en píxeles.<br> A imaxe subida será escalada a esta Anchura.',
    'LBL_POPHELP_IMAGE_HEIGHT' => 'Introduzca un número para la Altura, como medida en píxeles.<br> A imaxe subida será escalada a esta Altura.',
    'LBL_POPHELP_DUPLICATE_MERGE' => '<b>Habilitado</b>: O campo aparecerá na característica de Combinar Duplicados, pero non estará dispoñible para ser utilizado nas condicións de filtrado da característica Busca de Duplicados.<br><b>Deshabilitado</b>: O campo non aparecerá na característica Combinar Duplicados, e tampouco estará dispoñible para ser utilizado como condición de filtrado na característica de Busca de Duplicados.<br><b>En Filtro</b>: O campo aparecerá na característica de Combinar Duplicados, e tamén estará dispoñible na característica de Busca de Duplicados.<br><b>Filtro Seleccionado por Defecto</b>: O campo será utilizado na condición de filtrado por defecto da páxina de Busca de Duplicados, e tamén aparecerá na característica de Combinar Duplicados.<br><b>Só en Filtro</b>: O campo non aparecerá na característica Combinar Duplicados, pero estará dispoñible na característica de Busca de Duplicados.',
    'LBL_POPHELP_FIELD_DATA_TYPE' => 'Seleccione o tipo de datos apropiado acorde co tipo de datos que será introducido no campo.',

//Revert Module labels
    'LBL_RESET' => 'Restablecer',
    'LBL_RESET_MODULE' => 'Restablecer Módulo',
    'LBL_REMOVE_CUSTOM' => 'Quitar Personalizacións',
    'LBL_CLEAR_RELATIONSHIPS' => 'Limpar Relacións',
    'LBL_RESET_LABELS' => 'Restablecer Eqiquetas',
    'LBL_RESET_LAYOUTS' => 'Restablecer Deseño"',
    'LBL_REMOVE_FIELDS' => 'Quitar Campos Personalizados',
    'LBL_CLEAR_EXTENSIONS' => 'Limpar Extensións',
    'LBL_HISTORY_TIMESTAMP' => 'Rexistro de Tempo',
    'LBL_HISTORY_TITLE' => 'historial',

    'fieldTypes' => array(
        'varchar' => 'Campo de Texto',
        'int' => 'Enteiro',
        'float' => 'Coma flotante',
        'bool' => 'Casilla de Verificación',
        'enum' => 'Despregable',
        'dynamicenum' => 'Lista Despregable Dinámica',
        'multienum' => 'Selección Múltiple',
        'date' => 'Data',
        'phone' => 'Teléfono',
        'currency' => 'Moeda',
        'html' => 'HTML',
        'radioenum' => 'Opción',
        'relate' => 'Relacionado',
        'address' => 'Enderezo',
        'text' => 'Área de Texto',
        'url' => 'URL',
        'iframe' => 'IFrame',
        'datetimecombo' => 'Data e hora',
        'decimal' => 'Decimal',
        'image' => 'Imaxe',
        'wysiwyg' => 'WYSIWYG',
    ),
    'labelTypes' => array(
        "frequently_used" => "Etiquetas de uso frecuente",
        "all" => "Todas as etiquetas",
    ),

    'parent' => 'Posiblemente Relacionado con',

    'LBL_CONFIRM_SAVE_DROPDOWN' => "Está seleccionando este elemento para a súa eliminación da lista despregable. Calquera campo despregable que use esta lista con este elemento como valor xa non mostrará dito valor, e o valor xa non poderá ser seleccionado nos campos despregables. ¿Está seguro de que desexa continuar?",

    'LBL_ALL_MODULES' => 'Todos os Módulos',
    'LBL_RELATED_FIELD_ID_NAME_LABEL' => '{0} (relacionado {1} ID)',
);
