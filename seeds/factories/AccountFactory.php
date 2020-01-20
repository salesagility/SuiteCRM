<?php

namespace SuiteCRM\Factories;

use \SuiteCRM\BaseFactory;

class AccountFactory extends BaseFactory {
    public function __construct() {
        parent::__construct();

        $this->defaultProps = [
            'name' => $this->faker->company(),
            'account_type' => 'Customer'
        ];
    }

    /**
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @return Account
     */
    public function define($propertiesArray = []) {
        $account = parent::createSeedBean('Accounts', $propertiesArray);
        $account->save();

        return $account;
    }
}
