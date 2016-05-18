<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class ReminderEmailsShell extends Shell
{
    /**
     * Unsubscribe member in mailchimp's list
     *
     * @param int $memberId ID of the member that will be unsubscribed
     * @return void
     */
    public function deleteMemberInMailchimp(int $memberId)
    {
        $this->loadModel('Memberships');
    }
}
