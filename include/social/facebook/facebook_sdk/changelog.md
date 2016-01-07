Facebook PHP SDK (v.3.0.0)
==========================

The new PHP SDK (v3.0.0) is a major upgrade to the older one (v2.2.x):

- Uses OAuth authentication flows instead of our legacy authentication flow
- Consists of two classes. The first (class BaseFacebook) maintains the core of the upgrade, and the second one (class Facebook) is a small subclass that uses PHP sessions to store the user id and access token.

If you’re currently using the PHP SDK (v2.2.x) for authentication, you will recall that the login code looked like this:

     $facebook = new Facebook(…);
     $session = $facebook->getSession();
     if ($session) {
       // proceed knowing you have a valid user session
     } else {
       // proceed knowing you require user login and/or authentication
     }

The login code is now:

     $facebook = new Facebook(…);
     $user = $facebook->getUser();
     if ($user) {
       // proceed knowing you have a logged in user who's authenticated
     } else {
       // proceed knowing you require user login and/or authentication
     }

