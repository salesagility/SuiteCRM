<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.detail.php');

class FP_eventsViewDetail extends ViewDetail
{
    public $currSymbol;
    public function __construct()
    {
        parent::__construct();
    }




    public function display()
    {
        $this->bean->email_templates();
        parent::display();
    }
}
