

function bulkRevokeTokens() {

  document.MassUpdate.action = 'index.php?module=OAuth2Tokens&action=RevokeTokens';
  document.MassUpdate.submit();
}
