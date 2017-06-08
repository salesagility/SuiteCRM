{* Fix for issue 1549: mass update the cases, and change the state value from open to close,
   Status value can still display New, Assigned, Pending Input (even though it should not) *}
{php}
    $parentFieldArray = $this->get_template_vars('parentFieldArray');
    if($GLOBALS['module'] == 'Cases') {
        if($parentFieldArray['STATE'] == 'Closed' && $parentFieldArray['STATUS'] == 'New') {
            echo 'Closed';
        } elseif($parentFieldArray['STATE'] == 'Closed' && $parentFieldArray['STATUS'] == 'Assigned') {
            echo 'Closed';
        } elseif($parentFieldArray['STATE'] == 'Closed' && $parentFieldArray['STATUS'] == 'Pending Input') {
            echo 'Closed';
        } else {
            echo $parentFieldArray['STATUS'];
        }
    }
{/php}