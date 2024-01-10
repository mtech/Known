<?php

    /**
     * Account management class
     *
     * @package    idno
     * @subpackage core
     */

namespace Idno\Core {

    class Account extends \Idno\Common\Component
    {

        function init()
        {

            // Account management
            Idno::site()->routes()->addRoute('/account/settings/?', '\Idno\Pages\Account\Settings');
            Idno::site()->routes()->addRoute('/account/settings/notifications/?', '\Idno\Pages\Account\Settings\Notifications');
            Idno::site()->routes()->addRoute('/account/settings/tools/?', '\Idno\Pages\Account\Settings\Tools');
            Idno::site()->routes()->addRoute('/account/settings/following/?', '\Idno\Pages\Account\Settings\Following');
            Idno::site()->routes()->addRoute('/account/settings/following/bookmarklet/?', '\Idno\Pages\Account\Settings\Following\Bookmarklet');

            Idno::site()->routes()->addRoute('/account/notifications/?', '\Idno\Pages\Account\Notifications');
            Idno::site()->routes()->addRoute('/service/notifications/new-notifications/?', '\Idno\Pages\Service\Notifications\NewNotifications');

            // Basic registration; this is now always present, but the page will reject the user if registration
            // is closed and a valid invitation code hasn't been provided
            Idno::site()->routes()->addRoute('/account/register/?', '\Idno\Pages\Account\Register', true);

            // Password requests
            Idno::site()->routes()->addRoute('/account/password/?', '\Idno\Pages\Account\Password', true);
            Idno::site()->routes()->addRoute('/account/password/reset/?', '\Idno\Pages\Account\Password\Reset', true);

            // Known feedback
            Idno::site()->routes()->addRoute('/account/settings/feedback/?', '\Idno\Pages\Account\Settings\Feedback');
            Idno::site()->routes()->addRoute('/account/settings/feedback/confirm/?', '\Idno\Pages\Account\Settings\FeedbackConfirm');

            // Per-user export
            Idno::site()->routes()->addRoute('/account/export/?', '\Idno\Pages\Account\Export');
            Idno::site()->routes()->addRoute('/account/export/rss/?', '\Idno\Pages\Account\Export\RSS');

            // Override the page shell
            Idno::site()->template()->addUrlShellOverride('account', 'settings-shell');

        }

    }

}
