$(document).ready(function() {
  $('.btn-edit-drafts').click(function() {
    $(document).find('#formDetailView').find('[name=action]').val('ComposeView');
    $(document).find('#formDetailView').find('[name=return_module]').val('Emails');
    $(document).find('#formDetailView').submit();
  });
});