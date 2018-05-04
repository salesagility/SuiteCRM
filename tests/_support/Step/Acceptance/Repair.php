<?php

namespace Step\Acceptance;

class Repair extends Administration
{
    public function clickQuickRepairAndRebuild ()
    {
        $I = $this;
        $I->gotoAdministration();
        $I->click('#repair');
        $I->waitForText('Repair');
        $I->click('Quick Repair and Rebuild');
        $I->waitForText('Return to Administration page');
    }

    public function clickExecuteSqlButton ()
    {
        $I = $this;
        $I->click('Execute');
        $I->waitForText('Database tables are synced with vardefs');
    }


}