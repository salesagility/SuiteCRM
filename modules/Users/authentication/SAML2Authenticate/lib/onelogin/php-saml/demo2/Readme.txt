The example requires that SP and IdP are well configured before test it.

SP setup
--------

The Onelogin's PHP Toolkit allows you to provide the settings info in 2 ways:
 * Use a settings.php file that we should locate at the base folder of the
   toolkit.
 * Use an array with the setting data.

The first is the case of the demo2 app. The setting.php file and the 
setting_extended.php file should be defined at the base folder of the toolkit.
Review the setting_example.php and the advanced_settings_example.php to
learn how to build them.

In this case as Attribute Consume Service and Single Logout Service we gonna
use the files located in the endpoint folder (acs.php and sls.php).

IdP setup
---------

Once the SP is configured, the metadata of the SP is published at the
metadata.php file. Based on that info, configure the IdP.


How it works
------------

At demo1, we saw how all the SAML Request and Responses were handler at an
unique file, the index.php file. This demo1 uses hight-level programming.

At demo2, we have several views: index.php, sso.php, slo.php, consume.php
and metadata.php. As we said, we gonna use the endpoints that are defined
in the toolkit (acs.php, sls.php of the endpoints folder). This demo2 uses
low-level programming.

Notice that the SSO action can be initiated at index.php or sso.php.

The SAML workflow that take place is similar that the workflow defined in the
demo1, only changes the targets.


 1. When you first time access to index.php or sso.php, an AuthNRequest is
    sent to the IdP automatically, (as RelayState is sent the origin url).
    We authenticate at the IdP and then a Response is sent to the SP, to the
    ACS endpoint, in this case acs.php of the endpoints folder.
 
 2. The SAML Response is processed in the ACS, if the Response is not valid,
    the process stop here and a message is showed. Otherwise we are redirected
    to the RelayState view (sso.php or index.php). The sso.php detect if the
    user is logged and do a redirect to index.php, so we will be in the
    index.php at the end.

 3. We are logged in the app and the user attributes are showed. 
    At this point, we can test the single log out functionality.

 4. The single log out funcionality could be tested by 2 ways.

    4.1 SLO Initiated by SP. Click on the "logout" link at the SP, after that
    we are redirected to the slo.php view and there a Logout Request is sent
    to the IdP, the session at the IdP is closed and replies to the SP a
    Logout Response (sent to the Single Logout Service endpoint). In this case
    The SLS endpoint of the SP process the Logout Response and if is
    valid, close the user session of the local app. Notice that the SLO
    Workflow starts and ends at the SP.
   
    5.2 SLO Initiated by IdP. In this case, the action takes place on the IdP
    side, the logout process is initiated at the idP, sends a Logout 
    Request to the SP (SLS endpoint sls.php of the endpoint folder).
    The SLS endpoint of the SP process the Logout Request and if is valid,
    close the session of the user at the local app and sends a Logout Response
    to the IdP (to the SLS endpoint of the IdP).The IdP recieves the Logout
    Response, process it and close the session at of the IdP. Notice that the
    SLO Workflow starts and ends at the IdP.


