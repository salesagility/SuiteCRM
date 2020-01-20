<?php

namespace SuiteCRM\Factories;

use \SuiteCRM\BaseFactory;

class AccountFactory extends BaseFactory {
    public function __construct() {
        parent::__construct();

        $this->defaultProps = function() {
            return [
                'name' => $this->faker->company(),
                'account_type' => 'Customer'
            ];
        };
    }

    /**
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @param integer $numberOfInstances The number of instances of this bean to create.
     * @return Account[] An array of Account beans.
     */
    public function create($propertiesArray = [], $numberOfInstances = 1) {
        return parent::createSeedBeans('Accounts', $propertiesArray, $numberOfInstances);
    }
}
