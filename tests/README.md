SuiteCRM Automated Test Suite
====

Automated tested provides a means to ensure that the quality of the product is kept to a high standard. Tests help to ensure that each team member continues to work in harmony, by providing a consistent testing framework, in which every one contributes tests with the changes being made in the product. Generally speaking, The more code is covered by high quality automated tests, the more likely the quality of the product is good.


##Introduction Automated testing

###Test Scenario

A test scenario is a set of conditions or variables under which a tester will determine whether a system under the test conditions satisfies requirements of the software. The process of developing test scenarios can also help find problems in the requirements or design of an application.

'''Characteristics of a good test scenario:'''
* Accurate: Exactly test the purpose of a scenarios.
* Economical: No unnecessary steps used in the test.
* Traceable: Capable of being traced to requirements.
* Repeatable: Can be used to perform the test over and over under different operating environments.
* Reusable: Can be reused if necessary.

'''Best Practices:'''
* Write test scenarios in such a way that you test only one situation at a time. Do not overlap or complicate test scenarios.
** You can use as many assertions as you need, provided that the assertions prove only the validity of the test scenario/case you are testing.
* Ensure that all positive scenarios and negative scenarios are covered.
* Language:
** Write in the PHP Docs using the format:  "As a thing I (do not)want to do <scenario> so that I can/cannot <requirement> GIVEN that <some scenario is true> WHEN <condition is happening> EXPECT <some behavior will occur>"
** Use easy to understand language. Use variable names to express intent like $expectedSomething, $doSomething and $actualSomething.
** Use active voice: use present / current tense words like: has, is, call, do etc...
** Use exact and consistent names (of forms, fields, actions etc).
** Try to remove any ambiguity from your tests

'''Characteristics of a bad test scenario:'''
* Runs other tests scenarios (or does the job of the test framework)
* Do not assert the valid and invalid test conditions
* The name of the test scenario has nothing to do with what it is testing
* Adding assertions for a different test case
* Testing the scenario dependencies instead of the scenario itself
* Not testing the behaviour or data flow of the scenario
* Not expressing the intent of the test scenario (PHP Doc, method names, variables, failure messages)
* Using loops in your test scenario

###Acceptance Tests

Acceptance tests ensure that the software meets requirements of a user story. Since user stories are the examples given at the start of a development cycle, acceptance test tend to be the first set of tests to be written. Acceptances tests are also the easiest  tests to write, as they resemble a simple list of instructs like $I->goto('/home'); $I->click('button'); $I->see('dashboard'). Automated user acceptance tests mock the behaviour of a user.  These tests tell the developer/engineer that the a part of the system is displaying the right elements after an action has been carried out.

###Functional Tests

The goal of a functional test is check how different parts of the code base interact including their dependencies, to ensure that the overall behaviour is correct. For example checking the output of a view when you use a controller action with some arguments against the expected output. These test are written instead of acceptance tests when it is not suitable to use a web browser to run the test. Functional tests can also be referred to as integration tests because they often inspect the interactions between sub systems. These tests tell the developer/engineer that the a part of the system is performing the right tasks.

These tests are often written after acceptance tests, however they may be omitted entirely. Functional tests are particularly useful when deciding on the structure of your code, such as classes and name spaces. They help you to think about the "bigger picture".

###Unit Tests

Unit tests reflect that a single unit of code (like a method / function) with all dependencies mocked up, has managed to assert that the unit of code has passed the minimum requirements. Since a pass doesn't guarantee absolute correctness of code but rather that the code meets the minimum requirements to pass a unit test. It is important to always be skeptical when a unit test pass. When a unit test fails, it is an indication that the code doesn't meet the minimum requirements. However a failure can also indicate that the code has changed and that the tests need to be updated to match the new requirements. Unit tests tell the developer/engineer that a unit is working correctly and is doing the right things.

These tests are often written before a developer writes/modifies a method or function. This helps the developer to defined how a client will use their code. So that they can better understand the requirements and hopefully produce code which is more maintainable.

###System Tests
Automated system testing are acceptance or functional tests which can used to test the performance of the software. System tests are written after developing code, as early optimisation can lead to badly written code.

###Regression Tests

Regression tests are typically functional or acceptance test which check that the software which was previously developed and tested still performs correctly after it was changed. Regression tests are also written when a user raises an issue with the software. If a tester can replicate an issue, then it is best practice to write an automated test that developers can also replicate and test the issue. This ensures that any future work doesn't contain the same issue.

## Set up locally

Set up the environment variables
<pre>
export DATABASE_DRIVER=MYSQL
export DATABASE_NAME=automated_tests
export DATABASE_HOST=localhost
export DATABASE_USER=automated_tests
export DATABASE_PASSWORD=automated_tests
export INSTANCE_URL=http://path/to/instance
export INSTANCE_ADMIN_USER=admin
export INSTANCE_ADMIN_PASSWORD=admin
</pre>

to make it easier to run the commands

<pre>
export PATH=$PATH:/path/to/instance/vendor/bin
</pre>


Test your configuration
<pre>
codecept run demo --env selenium-hub --env chrome
</pre>

## Set up with travis
## Set up with browser stack

