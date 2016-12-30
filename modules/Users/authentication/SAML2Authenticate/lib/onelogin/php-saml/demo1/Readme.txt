The example requires that SP and IdP are well configured before test it.

SP setup
--------

The Onelogin's PHP Toolkit allows you to provide the settings info in 2 ways:
 * Use a settings.php file that we should locate at the base folder of the
   toolkit.
 * Use an array with the setting data.

In this demo we provide the data in the second way, using a setting array named

Uses the settings_example.php included as a template to create the settings.php
settings and store it in the demo1 folder. Configure the SP part and later
review the metadata of the IdP and complete the IdP info.

If you check the code of the index.php file you will see that the settings.php
file is loaded in order to get the $settingsInfo var to be used to initialize
the Setting class.

Notice that in this demo, the setting.php file that could be defined at the base
folder of the toolkit is ignored and the libs are loaded using the 
_toolkit_loader.php located at the base folder of the toolkit.


IdP setup
---------

Once the SP is configured, the metadata of the SP is published at the
metadata.php file. Based on that info, configure the IdP.


How it works
------------

 1. First time you access to index.php view, you can select to login and return
    to the same view or login and be redirected to the attrs.php view.

 2. When you click:
 
    2.1 in the first link, we access to (index.php?sso) an AuthNRequest
    is sent to the IdP, we authenticate at the IdP and then a Response is sent
    to the SP, specifically the Assertion Consumer Service view: index.php?acs,
    notice that a RelayState parameter is set to the url that initiated the
    process, the index.php view.

    2.2 in the second link we access to (attrs.php) have the same process 
    described at 2.1 with the diference that as RelayState is set the attrs.php

3. The SAML Response is processed in the ACS (index.php?acs), if the Response
   is not valid, the process stop here and a message is showed. Otherwise we
   are redirected to the RelayState view. a) index.php or b) attrs.php

4. We are logged in the app and the user attributes are showed. 
   At this point, we can test the single log out functionality.

5. The single log out funcionality could be tested by 2 ways.

    5.1 SLO Initiated by SP. Click on the "logout" link at the SP, after that a
    Logout Request is sent to the IdP, the session at the IdP is closed and 
    replies to the SP a Logout Response (sent to the Single Logout Service
    endpoint). The SLS endpoint (index.php?sls)of the SP process the Logout
    Response and if is valid, close the user session of the local app. Notice
    that the SLO Workflow starts and ends at the SP.
   
    5.2 SLO Initiated by IdP. In this case, the action takes place on the IdP
    side, the logout process is initiated at the idP, sends a Logout 
    Request to the SP (SLS endpoint, index.php?sls). The SLS endpoint of the SP
    process the Logout Request and if is valid, close the session of the user
    at the local app and send a Logout Response to the IdP (to the SLS endpoint
    of the IdP). The IdP recieve the Logout Response, process it and close the
    session at of the IdP. Notice that the SLO Workflow starts and ends at the IdP.
    
Notice that all the SAML Requests and Responses are handler at a unique file,
the index.php file and how GET paramters are used to know the action that
must be done.
