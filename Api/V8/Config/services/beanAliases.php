<?php

return [
    'beanAliases' => function () {
        return [
            'Account' => 'Accounts',
            'account' => 'Accounts',
            'accounts' => 'Accounts',
            'case' => 'Cases',
            'cases' => 'Cases',
            'aCase' => 'Cases',
            'Contact' => 'Contacts',
            'contact' => 'Contacts',
            'contacts' => 'Contacts',
            'Contracts' => AOS_Contracts::class,
            'contracts' => AOS_Contracts::class,
            'quote' => AOS_Quotes::class,
            'quotes' => AOS_Quotes::class,
            'Quotes' => AOS_Quotes::class,
            'User' => 'Users',
            'users' => 'Users',
        ];
    }
];
