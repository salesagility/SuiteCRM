<?php

namespace SuiteCRM;

use Faker;
use \BeanFactory;

abstract class BaseFactory {
    /** @var Faker\Generator */
    public $faker;

    /** @var array */
    public $defaultProps;

    /**
     * Create a new factory instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    abstract function define();

    /**
     * @param string $beanName The name of the bean to pass to `BeanFactory::newBean()`.
     * @param integer $numberOfInstances The number of instances of this bean to create.
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @return SugarBean[]
     */
    public function createSeedBeans($beanName, $numberOfInstances, $propertiesArray) {
        $beans = [];

        for ($i = 0; $i < $numberOfInstances; $i++) {
            $bean = BeanFactory::newBean($beanName);
            // Merge the default properties and the properties passed when defining
            // the user. Properties passed into the function should always override
            // the defaults.
            $properties = array_merge($propertiesArray, $this->defaultProps);
            // Assign each property in the array to the user bean.
            foreach ($properties as $name => $value) {
                $bean->$name = $value;
            }

            $bean->save();

            array_push($beans, $bean);
        }

        return $beans;
    }
}
