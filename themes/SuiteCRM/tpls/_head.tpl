<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=9">
<link rel="SHORTCUT ICON" href="{$FAVICON_URL}">
<meta http-equiv="Content-Type" content="text/html; charset={$APP.LBL_CHARSET}">
<title>{$SYSTEM_NAME}</title>
{$SUGAR_CSS}
{$SUGAR_JS}
{literal}
<script type="text/javascript">
<!--
SUGAR.themes.theme_name      = '{/literal}{$THEME}{literal}';
SUGAR.themes.hide_image      = '{/literal}{sugar_getimagepath file="hide.gif"}{literal}';
SUGAR.themes.show_image      = '{/literal}{sugar_getimagepath file="show.gif"}{literal}';
SUGAR.themes.loading_image      = '{/literal}{sugar_getimagepath file="img_loading.gif"}{literal}';
if ( YAHOO.env.ua )
    UA = YAHOO.env.ua;
-->


</script>
{/literal}
</head>