<?php

    /**
     * Defines built-in log in functionality
     */

namespace Idno\Pages\Session {

    /**
     * Default class to serve the homepage
     */
    class Login extends \Idno\Common\Page
    {

        function getContent()
        {

            // If we're somehow here but logged in, move to the front page if we're viewing with the regular template
            if (\Idno\Core\Idno::site()->session()->isLoggedOn() && \Idno\Core\Idno::site()->template()->getTemplateType() == 'default') {

                $fwd = $this->getInput('fwd'); // Forward to a new page?
                if (empty($fwd)) {
                    $fwd = \Idno\Core\Idno::site()->config()->getDisplayURL();
                } else {
                    $fwd = \Idno\Core\Webservice::base64UrlDecode($this->getInput('fwd'));
                }
                $this->forward($fwd);
            }

            $fwd = \Idno\Core\Webservice::base64UrlDecode($this->getInput('fwd')); // Forward to a new page?
            if ($fwd == \Idno\Core\Idno::site()->config()->getDisplayURL() . 'session/login') {
                $fwd = \Idno\Core\Idno::site()->config()->getDisplayURL();
            }
            if (empty($fwd)) {
                $fwd = \Idno\Core\Idno::site()->config()->getDisplayURL();
            }
            $t        = \Idno\Core\Idno::site()->template();
            $vars = [
                'fwd' => $fwd
            ];

            // If user is logged in and we got this far, this is an api login so lets return a user api token (#2240)
            if (\Idno\Core\Idno::site()->session()->isLoggedOn() && \Idno\Core\Idno::site()->template()->getTemplateType() != 'default' && $this->isSSL()) {
                $user = \Idno\Core\Idno::site()->session()->currentUser();
                $vars['api-token'] = $user->getAPIkey();
            }

            $t->body  = $t->__($vars)->draw('account/login');
            $t->title = \Idno\Core\Idno::site()->language()->_('Sign in');
            $t->drawPage();
        }

        function postContent()
        {

            $fwd = $this->getInput('fwd'); // Forward to a new page?
            if (empty($fwd)) {
                $fwd = \Idno\Core\Idno::site()->config()->getDisplayURL();
            }

            if ($user = \Idno\Entities\User::getByHandle($this->getInput('email'))) {
            } else if ($user = \Idno\Entities\User::getByEmail($this->getInput('email'))) {
            } else {
                \Idno\Core\Idno::site()->events()->triggerEvent('login/failure/nouser', array('method' => 'password', 'credentials' => array('email' => $this->getInput('email'))));
                $this->setResponse(401);
            }

            if ($user instanceof \Idno\Entities\User) {
                if ($user->checkPassword(trim($this->getInput('password')))) {
                    \Idno\Core\Idno::site()->events()->triggerEvent('login/success', array('user' => $user)); // Trigger an event for auditing
                    \Idno\Core\Idno::site()->session()->logUserOn($user);
                    $this->forwardToLogin($fwd);
                } else {
                    \Idno\Core\Idno::site()->session()->addErrorMessage(\Idno\Core\Idno::site()->language()->_("Oops! It looks like your password isn't correct. Please try again."));
                    \Idno\Core\Idno::site()->events()->triggerEvent('login/failure', array('user' => $user));
                    $this->forwardToLogin($fwd);
                }
            } else {
                \Idno\Core\Idno::site()->session()->addErrorMessage(\Idno\Core\Idno::site()->language()->_("Oops! We couldn't find your username or email address. Please check you typed it correctly and try again."));
                $this->forwardToLogin($fwd);
            }
        }

    }

}

