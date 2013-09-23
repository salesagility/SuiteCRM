To enable access to the ./examples/ directory, open .htaccess in the main Sugar directory and find the following line:

	RedirectMatch /dev/sugar/maint450/examples/(.*).php http://julian/dev/sugar/maint450/index.php

Change it to:

	# RedirectMatch /dev/sugar/maint450/examples/(.*).php http://julian/dev/sugar/maint450/index.php