{*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*}

{* Smarty *}

{* debug.tpl, last updated version 2.0.1 *}

{assign_debug_info}

{if isset($_smarty_debug_output) and $_smarty_debug_output eq "html"}
	<table border=0 width=100%>
	<tr bgcolor=#cccccc><th colspan=2>Smarty Debug Console</th></tr>
	<tr bgcolor=#cccccc><td colspan=2><b>included templates & config files (load time in seconds):</b></td></tr>
	{section name=templates loop=$_debug_tpls}
		<tr bgcolor={if %templates.index% is even}#eeeeee{else}#fafafa{/if}><td colspan=2><tt>{section name=indent loop=$_debug_tpls[templates].depth}&nbsp;&nbsp;&nbsp;{/section}<font color={if $_debug_tpls[templates].type eq "template"}brown{elseif $_debug_tpls[templates].type eq "insert"}black{else}green{/if}>{$_debug_tpls[templates].filename|escape:html}</font>{if isset($_debug_tpls[templates].exec_time)} <font size=-1><i>({$_debug_tpls[templates].exec_time|string_format:"%.5f"}){if %templates.index% eq 0} (total){/if}</i></font>{/if}</tt></td></tr>
	{sectionelse}
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>no templates included</i></tt></td></tr>	
	{/section}
	<tr bgcolor=#cccccc><td colspan=2><b>assigned template variables:</b></td></tr>
	{section name=vars loop=$_debug_keys}
		<tr bgcolor={if %vars.index% is even}#eeeeee{else}#fafafa{/if}><td valign=top><tt><font color=blue>{ldelim}${$_debug_keys[vars]}{rdelim}</font></tt></td><td nowrap><tt><font color=green>{$_debug_vals[vars]|@debug_print_var}</font></tt></td></tr>
	{sectionelse}
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>no template variables assigned</i></tt></td></tr>	
	{/section}
	<tr bgcolor=#cccccc><td colspan=2><b>assigned config file variables (outer template scope):</b></td></tr>
	{section name=config_vars loop=$_debug_config_keys}
		<tr bgcolor={if %config_vars.index% is even}#eeeeee{else}#fafafa{/if}><td valign=top><tt><font color=maroon>{ldelim}#{$_debug_config_keys[config_vars]}#{rdelim}</font></tt></td><td><tt><font color=green>{$_debug_config_vals[config_vars]|@debug_print_var}</font></tt></td></tr>
	{sectionelse}
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>no config vars assigned</i></tt></td></tr>	
	{/section}
	</table>
</BODY></HTML>
{else}
<SCRIPT language=javascript>
	if( self.name == '' ) {ldelim}
	   var title = 'Console';
	{rdelim}
	else {ldelim}
	   var title = 'Console_' + self.name;
	{rdelim}
	_smarty_console = window.open("",title.value,"width=680,height=600,resizable,scrollbars=yes");
	_smarty_console.document.write("<HTML><HEAD><TITLE>Smarty Debug Console_"+self.name+"</TITLE></HEAD><BODY bgcolor=#ffffff>");
	_smarty_console.document.write("<table border=0 width=100%>");
	_smarty_console.document.write("<tr bgcolor=#cccccc><th colspan=2>Smarty Debug Console</th></tr>");
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>included templates & config files (load time in seconds):</b></td></tr>");
	{section name=templates loop=$_debug_tpls}
		_smarty_console.document.write("<tr bgcolor={if %templates.index% is even}#eeeeee{else}#fafafa{/if}><td colspan=2><tt>{section name=indent loop=$_debug_tpls[templates].depth}&nbsp;&nbsp;&nbsp;{/section}<font color={if $_debug_tpls[templates].type eq "template"}brown{elseif $_debug_tpls[templates].type eq "insert"}black{else}green{/if}>{$_debug_tpls[templates].filename|escape:html|escape:javascript}</font>{if isset($_debug_tpls[templates].exec_time)} <font size=-1><i>({$_debug_tpls[templates].exec_time|string_format:"%.5f"}){if %templates.index% eq 0} (total){/if}</i></font>{/if}</tt></td></tr>");
	{sectionelse}
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>no templates included</i></tt></td></tr>");	
	{/section}
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>assigned template variables:</b></td></tr>");
	{section name=vars loop=$_debug_keys}
		_smarty_console.document.write("<tr bgcolor={if %vars.index% is even}#eeeeee{else}#fafafa{/if}><td valign=top><tt><font color=blue>{ldelim}${$_debug_keys[vars]}{rdelim}</font></tt></td><td nowrap><tt><font color=green>{$_debug_vals[vars]|@debug_print_var|escape:javascript}</font></tt></td></tr>");
	{sectionelse}
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>no template variables assigned</i></tt></td></tr>");	
	{/section}
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>assigned config file variables (outer template scope):</b></td></tr>");
	{section name=config_vars loop=$_debug_config_keys}
		_smarty_console.document.write("<tr bgcolor={if %config_vars.index% is even}#eeeeee{else}#fafafa{/if}><td valign=top><tt><font color=maroon>{ldelim}#{$_debug_config_keys[config_vars]}#{rdelim}</font></tt></td><td><tt><font color=green>{$_debug_config_vals[config_vars]|@debug_print_var|escape:javascript}</font></tt></td></tr>");
	{sectionelse}
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>no config vars assigned</i></tt></td></tr>");	
	{/section}
	_smarty_console.document.write("</table>");
	_smarty_console.document.write("</BODY></HTML>");
	_smarty_console.document.close();
</SCRIPT>
{/if}
