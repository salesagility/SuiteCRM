<?php

/**
 * Unit tests for Error class
 */
class OneLogin_Saml2_ErrorTest extends PHPUnit_Framework_TestCase
{
    /**
    * Tests the OneLogin_Saml2_Error Constructor. 
    * The creation of a deflated SAML Request
    *
    * @covers OneLogin_Saml2_Error
    */
    public function testError()
    {
        $samlException = new OneLogin_Saml2_Error('test');
        $this->assertEquals('test', $samlException->getMessage());
    }
}
