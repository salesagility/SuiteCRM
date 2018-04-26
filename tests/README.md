SuiteCRM Automated Testing Framework
====

Automated testing provides a means to ensure that the quality of the product is kept to a high standard. By working with a consistent testing framework, it helps to ensure that each contributor continues to work in harmony, The concept is that everyone shares tests with the changes being made in the product. Generally speaking, The more code is covered by high quality automated tests, the more likely the quality of the product is good.


## Introduction

### Test Scenario

A test scenario is a set of conditions or variables under which a tester will determine whether a system under the test conditions satisfies requirements of the software. The process of developing test scenarios can also help find problems in the requirements or design of an application.

**Characteristics of a good test scenario:**
- Accurate: Exactly test the purpose of a scenarios.
- Economical: No unnecessary steps used in the test.
- Traceable: Capable of being traced to requirements.
- Repeatable: Can be used to perform the test over and over under different operating environments.
- Reusable: Can be reused if necessary.

**Best Practices:**
- Write test scenarios in such a way that you test only one situation at a time. Do not overlap or complicate test scenarios.
 - You can use as many assertions as you need, provided that the assertions prove only the validity of the test scenario/case you are testing.
- Ensure that all positive scenarios and negative scenarios are covered.
- Language:
 - Write in the PHP Docs using the format:  "As a thing I (do not)want to do <scenario> so that I can/cannot <requirement> GIVEN that <some scenario is true> WHEN <condition is happening> EXPECT <some behavior will occur>"
 - Use easy to understand language. Use variable names to express intent like $expectedSomething, $doSomething and $actualSomething.
 - Use active voice: use present / current tense words like: has, is, call, do etc...
 - Use exact and consistent names (of forms, fields, actions etc).
 - Try to remove any ambiguity from your tests

**Characteristics of a bad test scenario:**
- Runs other tests scenarios (or does the job of the test framework)
- Do not assert the valid and invalid test conditions
- The name of the test scenario has nothing to do with what it is testing
- Adding assertions for a different test case
- Testing the scenario dependencies instead of the scenario itself
- Not testing the behaviour or data flow of the scenario
- Not expressing the intent of the test scenario (PHP Doc, method names, variables, failure messages)
- Using loops in your test scenario

### Acceptance Tests

Acceptance tests ensure that the software meets requirements of a user story. Since user stories are the examples given at the start of a development cycle, acceptance test tend to be the first set of tests to be written. Acceptances tests are also the easiest  tests to write, as they resemble a simple list of instructs like:
<pre>
$I->goto('/');
$I->click('button');
$I->see('dashboard');
</pre>

Automated user acceptance tests mock the behaviour of a user.  These tests tell the developer/engineer that the a part of the system is displaying the right elements after an action has been carried out.

### Functional Tests

The goal of a functional test is check how different parts of the code base interact including their dependencies, to ensure that the overall behaviour is correct. For example checking the output of a view when you use a controller action with some arguments against the expected output. These test are written instead of acceptance tests when it is not suitable to use a web browser to run the test. Functional tests can also be referred to as integration tests because they often inspect the interactions between sub systems. These tests tell the developer/engineer that the a part of the system is performing the right tasks.

These tests are often written after acceptance tests, however they may be omitted entirely. Functional tests are particularly useful when deciding on the structure of your code, such as classes and name spaces. They help you to think about the "bigger picture".

### Unit Tests

Unit tests reflect that a single unit of code (like a method / function) with all dependencies mocked up, has managed to assert that the unit of code has passed the minimum requirements. Since a pass doesn't guarantee absolute correctness of code but rather that the code meets the minimum requirements to pass a unit test. It is important to always be skeptical when a unit test pass. When a unit test fails, it is an indication that the code doesn't meet the minimum requirements. However a failure can also indicate that the code has changed and that the tests need to be updated to match the new requirements. Unit tests tell the developer/engineer that a unit is working correctly and is doing the right things.

These tests are often written before a developer writes/modifies a method or function. This helps the developer to defined how a client will use their code. So that they can better understand the requirements and hopefully produce code which is more maintainable.

### System Tests
Automated system testing are acceptance or functional tests which can used to test the performance of the software. System tests are written after developing code, as early optimisation can lead to badly written code.

### Regression Tests

Regression tests are typically functional or acceptance test which check that the software which was previously developed and tested still performs correctly after it was changed. Regression tests are also written when a user raises an issue with the software. If a tester can replicate an issue, then it is best practice to write an automated test that developers can also replicate and test the issue. This ensures that any future work doesn't contain the same issue.

## Installing the testing framework
The automated test framework is built on top of [codeception](http://codeception.com) and [mocha](https://mochajs.org/) (in the browser). It uses composer and bower to manage the dependencies.

Run the following in your terminal
<pre>
cd /path/to/suitecrm/instance
composer install
</pre>

## Running Codeception for the first time

Codeception and the other commands live inside the vendor/bin/ directory of your SuiteCRM instance

<pre>
cd /path/to/suitecrm/instance/
./vendor/bin/codecept run demo
</pre>

To make it easier to run codeception and the other commands which live in vendor/bin/ directory. You can add the
vendor/bin location to your PATH environment variable.

Adding vendor/bin to PATH (Bash):
<pre>
export PATH=$PATH:/path/to/instance/vendor/bin
</pre>

Adding vendor/bin to PATH (Command Prompt):
<pre>
set PATH=%PATH%;C:\path\to\instance\vendor\bin
</pre>

This allows you to call the codecept command without having to prefix the command with its location. When running codecept you should ensure that your current working directory is the same as your suitecrm instance.

<pre>
cd /path/to/suitecrm/instance/
codecept run demo
</pre>

## Configuring the automated tests

SuiteCRM requires you to configure the automated test with your development environment. There are a number of ways to configure your environment. 

- You can configure the automated test by adding an yml file to the tests/_envs folder
- You can edit the yml files for each test suite
- You can set up environment variables in the terminal or command prompt

### Add a file to tests/_envs

Adding a file to tests/_envs enables to create different configurations.

Example: tests/_envs/mysql.yml
<pre>
modules:
  config:
    \SuiteCRM\Test\Driver\WebDriver:
      url: "http://path/to/instance"
      database_driver: "MYSQL"
      # Also can be set to database_driver: "MSSQL"
      database_name: "automated_tests"
      database_host: "localhost"
      database_user: "automated_tester"
      database_password: "automated_password"
      instance_admin_user: "admin"
      instance_admin_password: "secret"
</pre>

Then you need to add this configuration into your command argument(s):

<pre>
codecept run install --env chrome,mysql
</pre>

For more details please refer to tests/_support/Helper/WebDriverHelper.php. For security reasons make sure you add the yml file to the gitignore file. DO NOT COMMIT SECURITY INFORMATION IN GIT.

### Editing test suite files
Using the same technique, described in  "Add a file to tests/_envs", You can also choose to edit the suite.yml files which live in the tests folder. This method is discoraged as you should not commit security information to the git repository.

Example: acceptance.suite.yml
<pre>
# Codeception Test Suite Configuration
#
# Suite for acceptance tests.
# Perform tests in browser using the SuiteCRM WebDriver
#
# Use the enviornmental config files to configure the driver

class_name: AcceptanceTester
modules:
    enabled:
        - \Helper\Acceptance
        - \Helper\WebDriverHelper
        - \SuiteCRM\Test\Driver\WebDriver
    config:
        \SuiteCRM\Test\Driver\WebDriver:
            url: "https://demo.suiteondemand.com"
            browser: chrome
            restart: true
            wait: 1
            # iPad 2
            # See _env
            width: 768
            height: 1024
            database_driver: "MYSQL"
            # Also can be set to database_driver: "MSSQL"
            database_name: "automated_tests"
            database_host: "localhost"
            database_user: "automated_tester"
            database_password: "automated_password"
            instance_admin_user: "admin"
            instance_admin_password: "secret"
</pre>

### Environment Variables
Environment variables allows more advanced users to script or automate their development environment. Also you can add these values to Docker Compose. This is the prefered method to store sensative information, as it cannot be commited to the git repository.

Setup environment variables (bash):
<pre>
export DATABASE_DRIVER=MYSQL
export DATABASE_NAME=automated_tests
export DATABASE_HOST=localhost
export DATABASE_USER=automated_tests
export DATABASE_PASSWORD=automated_tests
export INSTANCE_URL=http://path/to/instance
export INSTANCE_ADMIN_USER=admin
export INSTANCE_ADMIN_PASSWORD=admin
export INSTANCE_CLIENT_ID=suitecrm_client
export INSTANCE_CLIENT_SECRET=client_secret
</pre>

Setup environment variables  (Command Prompt):
<pre>
set DATABASE_DRIVER=MYSQL
set DATABASE_NAME=automated_tests
set DATABASE_HOST=localhost
set DATABASE_USER=automated_tests
set DATABASE_PASSWORD=automated_tests
set INSTANCE_URL=http://path/to/instance
set INSTANCE_ADMIN_USER=admin
set INSTANCE_ADMIN_PASSWORD=admin
set INSTANCE_CLIENT_ID: suitecrm_client
set INSTANCE_CLIENT_SECRET: client_secret
</pre>

#### For Docker Compose
You can add a .env file into your docker compose setup:
<pre>
DATABASE_DRIVER=MYSQL
DATABASE_NAME=automated_tests
DATABASE_HOST=localhost
DATABASE_USER=automated_tests
DATABASE_PASSWORD=automated_tests
INSTANCE_URL=http://path/to/instance
INSTANCE_ADMIN_USER=admin
INSTANCE_ADMIN_PASSWORD=admin
INSTANCE_CLIENT_ID: suitecrm_client
INSTANCE_CLIENT_SECRET: client_secret
</pre>

and then reference it in your php container (docker-compose.yml):
<pre>
version: '3'
services:
  php:
      image: php:7.0-apache
      restart: always
      ports:
        - 9001:80
      environment:
       - DATABASE_DRIVER: $DATABASE_DRIVER
       - DATABASE_NAME: $DATABASE_NAME
       - DATABASE_HOST: $DATABASE_HOST
       - DATABASE_USER: $DATABASE_USER
       - DATABASE_PASSWORD: $DATABASE_PASSWORD
       - INSTANCE_URL: $INSTANCE_URL
       - INSTANCE_ADMIN_USER: $INSTANCE_ADMIN_USER
       - INSTANCE_ADMIN_PASSWORD: $INSTANCE_ADMIN_PASSWORD
       - INSTANCE_CLIENT_ID: suitecrm_client
       - INSTANCE_CLIENT_SECRET: client_secret
</pre>

## Test Environments

The SuiteCRM automated testing framework can support different environments. You can see the different configurations for test environments in tests/_env folder. There are different prefixes fore each testing environment you choose to deploy.
 
- selenium- Configures the features for selenium web driver environment
- browser-stack- Configures features for browser stack environment
- travis-ci- Configures features for travis-ci environment

To run the tests in a single environment, add a --env flag to the codecept command; seperating each configuration by a comma: 

<pre>
codecept run acceptance --env selenium-hub,selenium-iphone-6
</pre>

It is also possible to run multi environments at the same time by adding multiple --env flags

<pre>
codecept run acceptance --env selenium-hub,selenium-iphone-6  --env selenium-hub,selenium-hd --env browser-stack,browser-stack-ipad-2 
</pre>
The tests will be executed 3 times. One for each environment

### Selenium Environment
In your selenium developement environment, It is recommended that you employ docker compose to set up a selenium hub with a selenium node. As this will ensure your version of chrome and firefox are kept up-to-date with the latest version. Plus you can then run multiple version of PHP on the same host machine.

#### Using Docker Compose with the Selenium Hub

You can configure selenium using docker compose. Please ensure you have the following in your docker-compose.yml file.

<pre>
 selenium-hub:
      image: selenium/hub
      restart: always
      ports:
        - 4444:4444
  selenium-node-chrome:
      image: selenium/node-chrome-debug
      restart: always
      ports: 
        - 5900:5900
      links:
        - selenium-hub:hub
      environment:
              - "HUB_PORT_4444_TCP_ADDR=selenium-hub"
              - "HUB_PORT_4444_TCP_PORT=4444"
  selenium-node-firefox:
      image: selenium/node-firefox-debug
      restart: always
      ports: 
        - 5901:5900
      links:
        - selenium-hub:hub
      environment:
              - "HUB_PORT_4444_TCP_ADDR=selenium-hub"
              - "HUB_PORT_4444_TCP_PORT=4444"
</pre>
**Note: you can also choose different images for the nodes, for example the nodes without vnc support**

You can select the browser you wish to test by adding it to the --env.

<pre>
codecept run demo --env selenium-hub,selenium-chrome --env selenium-hub,selenium-firefox
</pre>

#### Using Selenium with a local PHP environment
You may prefer to run in a local PHP environment instead of using docker compose. This requires that you need to have selenium running locally on your computer. When running in a local environment, you do not need to include the selenium-hub environment variable. Instead, you must choose which browser you have set up locally:

<pre>
codecept run demo --env selenium-chrome
</pre>

#### Screen Resolutions / Fake Devices
There are also different configurations for each target device we test for:

- selenium-iphone-6 (375x667)
- selenium-ipad-2 (768x1024)
- selenium-xga (1024x768)
- selenium-hd (1280x720)
- selenium-fhd (1920x1080)

Example:
<pre>
codecept run acceptance --env selenium-hub,selenium-xga
</pre>

**Please note:** that the SuiteCRM automated test framework uses **height** and **width** values to define the window size instead of the window_size. window_size is ignored by the automated test framework.


### Browser Stack Environment

The SuiteCRM Automated Test Framework can run on browser stack. It requires that you have an account with browser stack that enables automated testing. You also need to configure the testing framework with your username and access key. You can get your details from [automate](https://www.browserstack.com/automate) menu item.


To configure using environment variables (bash):
<pre>
export BROWSERSTACK_USERNAME=<Username>
export BROWSERSTACK_ACCESS_KEY=<Key>
</pre>


To configure using environment variables (Command Prompt):
<pre>
set BROWSERSTACK_USERNAME=<Username>
set BROWSERSTACK_ACCESS_KEY=<Key>
</pre>


To run the test framework with browser stack. You need to use the --env browser-stack-hub: 

<pre>
codecept run demo  --env browser-stack-hub
</pre>


#### Browser stack local

When you need to test a application that resides on a private server, You will need to run the browser-stack-local env option:

<pre>
codecept run demo  --env browser-stack-hub,browser-stack-local
</pre>


#### Screen Resolutions / Devices

There are also different configurations for each target device we test for:

- browser-stack-chrome-fhd (1920x1080)
- browser-stack-edge-fhd (1920x1080)
- browser-stack-firefox-fhd (1920x1080)
- browser-stack-ie-fhd (1920x1080)
- browser-stack-safari-fhd (1920x1080)
- browser-stack-iphone-6 (375x667)
- browser-stack-ipad-2 (768x1024)


<pre>
codecept run demo --env browser-stack-hub,browser-stack-local,browser-stack-chrome-fhd
</pre>
