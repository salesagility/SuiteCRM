<?php

require_once('include/ListView/ListViewSmarty.php');
require_once('AM_ProjectTemplatesListViewData.php');


class AM_ProjectTemplatesListViewSmarty extends ListViewSmarty {

    function AM_ProjectTemplatesListViewSmarty() {

        parent::ListViewSmarty();

		$this->lvd = new AM_ProjectTemplatesListViewData();

    }

}

?>