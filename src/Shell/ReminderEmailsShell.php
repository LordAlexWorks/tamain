<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class ReminderEmailsShell extends Shell
{
    /**
     * Add parameters to email and send it
     *
     * @param \Cake\Mailer\Email $email Email to be sent
     * @param string $recipientEmail Email address of recipient
     * @param string $recipientName Name of recipient
     * @return int|null|void
     */
    public function sendReminderEmail(\Cake\Mailer\Email $email, $recipientEmail, $recipientName)
    {
        $email
            ->addTo($recipientEmail, $recipientName)
            ->from(env('ADMIN_EMAIL', 'gabrielascardine@gmail.com'), 'Tamarin')
            ->emailFormat('html')
            ->helpers('Html');
        $email->send();
    }

    /**
     * Find memberships within 15 days (before or after) expiration,
     * and send reminders with membership to be renewed
     *
     * @return int|null|void
     */
    public function sendMembershipExpirationReminders()
    {
        $this->loadModel('Memberships');

        $numDaysBeforeExpiration = 15;
        $numDaysAfterExpiration = 15;

        // Because we only care about the date, not the time,
        // and the database fields compare with the time
        $today = date_format(new \DateTime(), 'Y-m-d');
        $dayOfNoticeBeforeExpiration = date_format(new \DateTime("- $numDaysBeforeExpiration days"), 'Y-m-d');
        $dayOfNoticeAfterExpiration = date_format(new \DateTime("+ $numDaysAfterExpiration days"), 'Y-m-d');
        $dayNoNotices = date_format(new \DateTime("+ " . ($numDaysAfterExpiration + 1) . " days"), 'Y-m-d');

        // Memberships expiring within interval
        $membershipsExpiring = $this->Memberships
            ->find('withinDates', [
                    'min_date' => $dayOfNoticeBeforeExpiration,
                    'max_date' => $dayNoNotices
                ]);

        foreach ($membershipsExpiring as $membership) {
            $expiresOnDay = date_format($membership->expires_on, 'Y-m-d');

            // Member, if s/he didn't get another membership already
            $member = $this->Memberships->Members
                ->findById($membership->member_id)
                ->notMatching('Memberships', function ($q) use ($dayNoNotices) {
                    return $q
                        ->where(['Memberships.expires_on >=' => $dayNoNotices]);
                })
                ->first();

            if ($member) {
                if ($expiresOnDay == $today) {
                    // Send reminder for memberships that expires today
                    $email = new Email();
                    $email->subject(__("Tamarin membership expires today"))
                        ->template('membership_expires_today', 'action')
                        ->viewVars([
                            'recipientName' => $member->full_name,
                            'renew_membership_url' => Configure::read('App.fullBaseUrl'),
                            'fullBaseUrl' => Configure::read('App.fullBaseUrl')
                        ]);
                    $this->sendReminderEmail($email, $member->email, $member->full_name);
                } elseif ($expiresOnDay == $dayOfNoticeAfterExpiration) {
                    // Send reminder for memberships expiring in 15 days from now
                    $email = new Email();
                    $email->subject(__("Tamarin membership expiring soon"))
                        ->template('membership_before_expires', 'action')
                        ->viewVars([
                            'recipientName' => $member->full_name,
                            'numDaysBeforeExpiration' => $numDaysBeforeExpiration,
                            'renew_membership_url' => Configure::read('App.fullBaseUrl'),
                            'fullBaseUrl' => Configure::read('App.fullBaseUrl')
                        ]);
                    $this->sendReminderEmail($email, $member->email, $member->full_name);
                } elseif ($expiresOnDay == $dayOfNoticeBeforeExpiration) {
                    // Send reminder for memberships that expired 15 days ago
                    $email = new Email();
                    $email->subject(__("Tamarin membership expired recently"))
                        ->template('membership_after_expires', 'action')
                        ->viewVars([
                            'recipientName' => $member->full_name,
                            'numDaysAfterExpiration' => $numDaysAfterExpiration,
                            'renew_membership_url' => Configure::read('App.fullBaseUrl'),
                            'fullBaseUrl' => Configure::read('App.fullBaseUrl')
                        ]);
                    $this->sendReminderEmail($email, $member->email, $member->full_name);
                }
            }
        }
    }
}
