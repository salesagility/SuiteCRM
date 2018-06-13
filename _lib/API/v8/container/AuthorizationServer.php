<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$container['AuthorizationServer'] = function () {
    $keys = new \SuiteCRM\API\OAuth2\Keys();
    // Setup the authorization server
    $server = new \SuiteCRM\API\OAuth2\Middleware\AuthorizationServer(
        new SuiteCRM\API\OAuth2\Repositories\ClientRepository(),
        new SuiteCRM\API\OAuth2\Repositories\AccessTokenRepository(),
        new SuiteCRM\API\OAuth2\Repositories\ScopeRepository(),
        $keys->getPrivateKey(),
        $keys->getPublicKey()
    );

    $server->setEncryptionKey(base64_encode(random_bytes(32)));

    $passwordGrant = new League\OAuth2\Server\Grant\PasswordGrant(
        new SuiteCRM\API\OAuth2\Repositories\UserRepository(),
        new  SuiteCRM\API\OAuth2\Repositories\RefreshTokenRepository()
    );

    // refresh tokens will expire after 1 month
    $passwordGrant->setRefreshTokenTTL(new \DateInterval('P1M'));

    // Enable the password grant on the server with a token TTL of 1 hour
    // access tokens will expire after 1 hour
    $server->enableGrantType(
        $passwordGrant,
        new \DateInterval('PT1H')
    );


    $clientCredentialsGrant = new League\OAuth2\Server\Grant\ClientCredentialsGrant();

    // refresh tokens will expire after 1 month
    $clientCredentialsGrant->setRefreshTokenTTL(new \DateInterval('P1M'));

    // Enable the client credentials grant on the server with a token TTL of 1 hour
    // access tokens will expire after 1 hour
    $server->enableGrantType(
        $clientCredentialsGrant,
        new \DateInterval('PT1H')
    );

    return $server;
};