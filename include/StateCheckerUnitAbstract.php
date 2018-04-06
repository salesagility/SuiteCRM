<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

use Codeception\Test\Unit;

/**
 * Description of StateCheckerUnit
 *
 * @author SalesAgility
 */
abstract class StateCheckerUnitAbstract extends Unit
{
    use StateCheckerTrait;
    use StateCheckerCodeceptionTrait;
}
