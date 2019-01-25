<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.edit.php');

class AOS_Product_CategoriesViewEdit extends ViewEdit
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function AOS_Product_CategoriesViewEdit()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    public function display()
    {
        parent::display(); ?>
        <script>
            function update_parent_display(){
                var name_elem = document.getElementById("parent_category_name");
                var id_elem = document.getElementById("parent_category_id");
                var btn_elem = document.getElementById("btn_parent_category_name");
                var disable = document.getElementById("is_parent") && document.getElementById("is_parent").checked;
                if(name_elem){
                    name_elem.disabled = disable;
                }
                if(id_elem){
                    id_elem.disabled = disable;
                }
                if(btn_elem){
                    btn_elem.disabled = disable;
                }
                if(disable){
                    SUGAR.clearRelateField(this.form, 'parent_category_name', 'parent_category_id');
                }
            }
            document.getElementById("is_parent").onchange = update_parent_display;
            document.getElementById("is_parent").onchange();
        </script>

        <?php
    }
}
?>
