<?php

namespace Step\Acceptance;

class Reports extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoReports()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Reports');
    }

    /**
     * Go to user profile
     */
    public function gotoProfile()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('Profile');
    }

    /**
     * Create a report
     *
     * @param $name
     * @param $module
     */
    public function createReport($name, $module)
    {
        $I = new EditView($this->getScenario());
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->selectOption('#report_module', $module);
    }

    /**
     * Create an account
     *
     * @param $name
     */
    public function createAccount($name)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());

        $I->see('Create Account', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->fillField('#phone_office', '(810) 267-0146');
        $I->fillField('#website', 'www.afakeurl.com');
        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }

    /**
     * Add a field to a report
     *
     * @param $name
     * @param $module
     */
    public function addField($name, $module)
    {
        $I = new EditView($this->getScenario());
        $I->executeJS('var node = $(\'span.jqtree_common.jqtree-title.jqtree-title-folder\').closest(\'li.jqtree_common\').data(\'node\');

var module = "Accounts";
var module_name = "Accounts";
var module_path_display = "Accounts";

        $.getJSON(\'index.php\',
          {
            \'module\': \'AOR_Reports\',
            \'action\': \'getModuleFields\',
            \'aor_module\': node.module,
            \'view\': \'JSON\'
          },
          function (fieldData) {
            var treeData = [];

            for (var field in fieldData) {
              if (field) {
                treeData.push(
                  {
                    id: field,
                    label: fieldData[field],
                    \'load_on_demand\': false,
                    type: \'field\',
                    module: node.module,
                    module_path: node.module_path,
                    module_path_display: node.module_path_display
                  });
              }
            }
            var treeDataLeafs = [];
            treeDataLeafs[module] = treeData;

                var showTreeDataLeafs = function(treeDataLeafs, module, module_name, module_path_display) {
      if (typeof module_name == \'undefined\' || !module_name) {
        module_name = module;
      }
      if (typeof module_path_display == \'undefined\' || !module_path_display) {
        module_path_display = module_name;
      }
      $(\'#module-name\').html(\'(<span title="\' + module_path_display + \'">\' + module_name + \'</span>)\');
      $(\'#fieldTreeLeafs\').remove();
      $(\'#detailpanel_fields_select\').append(
        \'<div id="fieldTreeLeafs" class="dragbox aor_dragbox" title="\'
        + SUGAR.language.translate(\'AOR_Reports\', \'LBL_TOOLTIP_DRAG_DROP_ELEMS\')
        + \'"></div>\'
      );
      $(\'#fieldTreeLeafs\').tree({
        data: treeDataLeafs,
        dragAndDrop: true,
        selectable: true,
        onCanSelectNode: function(node) {
          if($(\'#report-editview-footer .toggle-detailpanel_fields\').hasClass(\'active\')) {
            dropFieldLine(node);
          }
          else if($(\'#report-editview-footer .toggle-detailpanel_conditions\').hasClass(\'active\')) {
            dropConditionLine(node);
          }
        },
        onDragMove: function() {
          $(\'.drop-area\').addClass(\'highlighted\');
        },
        onDragStop: function(node, e,thing){
          $(\'.drop-area\').removeClass(\'highlighted\');
          var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
          if(node.type != \'field\'){
            return;
          }
          if(target.closest(\'#fieldLines\').length > 0){
            dropFieldLine(node);
          }else if(target.closest(\'#aor_conditionLines\').length > 0){
            var conditionLineTarget = ConditionOrderHandler.getConditionLineByPageEvent(e);
            var conditionLineNew = dropConditionLine(node);
            if(conditionLineTarget) {
              ConditionOrderHandler.putPositionedConditionLines(conditionLineTarget, conditionLineNew);
              ConditionOrderHandler.setConditionOrders();
            }
            ParenthesisHandler.addParenthesisLineIdent();
          }
          else if(target.closest(\'.tab-toggler\').length > 0) {
            target.closest(\'.tab-toggler\').click();
            if(target.closest(\'.tab-toggler\').hasClass(\'toggle-detailpanel_fields\')) {
              dropFieldLine(node);
            }
            else if (target.closest(\'.tab-toggler\').hasClass(\'toggle-detailpanel_conditions\')) {
              dropConditionLine(node);
            }
          }

        },
        onCanMoveTo: function(){
          return false;
        }
      });
    };
    
            showTreeDataLeafs(treeDataLeafs[module], module, module_name, module_path_display);
          }
        );

$(\'.jqtree-selected\').removeClass(\'jqtree-selected\');
$(\'#fieldTree\').tree(\'addToSelection\', node);
');
        $I->click($module, '.jqtree_common jqtree-title jqtree-title-folder');
        $I->click($name, '.jqtree-title jqtree_common');
    }

    /**
     * Adds condition to report
     * @param $condition
     * @param $module
     */
    public function addCondition($condition, $module)
    {
        $I = new EditView($this->getScenario());

        $I->click('Conditions', 'tab-toggler');
        $I->click($module, 'jqtree_common jqtree-title jqtree-title-folder');
        $I->click($condition, 'jqtree-title jqtree_common');
    }
}