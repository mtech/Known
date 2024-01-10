<?php

namespace Tests\Core {

    /**
     * Test gatekeepers
     */
    class GatekeeperTest extends \Tests\KnownTestCase
    {

        public function testGatekeeper()
        {
            $result = \Idno\Core\Webservice::get(\Idno\Core\Idno::site()->config()->url . 'account/settings/', [], []);

            $response = $result['response'];
            $this->assertEmpty($result['error'], 'The result\'s error property should be empty.');
            $this->assertEquals($response, 403, 'The response should have returned a 403 HTTP response.');

            $user = \Tests\KnownTestCase::user();
            $this->assertIsObject(\Idno\Core\Idno::site()->session()->logUserOn($user));

            $result = \Idno\Core\Webservice::get(
                \Idno\Core\Idno::site()->config()->url . 'account/settings/', [], [
                'X-KNOWN-USERNAME: ' . $user->handle,
                'X-KNOWN-SIGNATURE: ' . base64_encode(hash_hmac('sha256', '/account/settings/', $user->getAPIkey(), true)),

                ]
            );

            $response = $result['response'];
            $this->assertEmpty($result['error'], 'The result\'s error property should be empty.');
            $this->assertEquals($response, 200, 'The response should have returned a 200 HTTP response.');

            \Idno\Core\Idno::site()->session()->logUserOff();
        }

        public function testAdminGatekeeper()
        {
            $result = \Idno\Core\Webservice::get(\Idno\Core\Idno::site()->config()->url . 'admin/', [], []);

            $response = $result['response'];
            $this->assertEmpty($result['error'], 'The result\'s error property should be empty.');
            $this->assertEquals($response, 403, 'The response should have returned a 403 HTTP response.');

            $user = \Tests\KnownTestCase::user();
            $this->assertIsObject(\Idno\Core\Idno::site()->session()->logUserOn($user));

            // Try normal user
            \Idno\Core\Idno::site()->session()->logUserOff();
            $result = \Idno\Core\Webservice::get(
                \Idno\Core\Idno::site()->config()->url . 'admin/', [], [
                'X-KNOWN-USERNAME: ' . $user->handle,
                'X-KNOWN-SIGNATURE: ' . base64_encode(hash_hmac('sha256', '/admin/', $user->getAPIkey(), true)),

                ]
            );

            $response = $result['response'];
            $this->assertEmpty($result['error'], 'The result\'s error property should be empty.');
            $this->assertEquals($response, 403, 'The response should have returned a 403 HTTP response.');

            // Try admin
            $user = \Tests\KnownTestCase::admin();
            $this->assertIsObject(\Idno\Core\Idno::site()->session()->logUserOn($user));

            $result = \Idno\Core\Webservice::get(
                \Idno\Core\Idno::site()->config()->url . 'admin/', [], [
                'X-KNOWN-USERNAME: ' . $user->handle,
                'X-KNOWN-SIGNATURE: ' . base64_encode(hash_hmac('sha256', '/admin/', $user->getAPIkey(), true)),

                ]
            );

            $response = $result['response'];
            $this->assertEmpty($result['error'], 'The result\'s error property should be empty.');
            $this->assertEquals($response, 403, 'The response should have returned a 403 HTTP response.');

            \Idno\Core\Idno::site()->session()->logUserOff();
        }


    }

}
