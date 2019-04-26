if (!checkValidate('EditCredentials', 'name')) {
  addToValidate('EditCredentials', 'name', 'varchar', true);
}

if (!checkValidate('EditCredentials', 'assigned_user_name')) {
  addToValidate('EditCredentials', 'assigned_user_name', 'varchar', true);
}
