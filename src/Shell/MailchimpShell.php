<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Mailchimp\Mailchimp;

class MailchimpShell extends Shell
{
    /**
     * Unsubscribe members in mailchimp's list,
     * whose last membership expired 30 days ago
     *
     * @return void
     */
    public function unsubscribeDeactivatedMembers()
    {
        $this->loadModel('Members');
        $numDaysExpiration = 30;

        // Because we only care about the date, not the time,
        // and the database fields compare with the time
        $today = date_format(new \DateTime(), 'Y-m-d');
        $expirationDate = date_format(new \DateTime("- $numDaysExpiration days"), 'Y-m-d');

        // Memberships expired in that date
        $membersExpiring = $this->Members->find('all')
            ->matching('Memberships', function ($q) use ($expirationDate) {
                return $q->where([
                    'Memberships.expires_on >=' => $expirationDate . ":00:00:00",
                    'Memberships.expires_on <=' => $expirationDate . ":23:59:59"
                ]);
            });

        $mailchimpKey = Configure::read('App.mailchimpKey');
        $listId = "eaad0ec6e1";
        $unsubscribeOperations = [];

        foreach ($membersExpiring as $member) {
            // Member does not have an active membership now
            if ($member->has_active_membership == false) {
                $subscriberHash = md5(strtolower($member->email));

                // Add operation to batch request
                array_push($unsubscribeOperations, [
                    "method" => "PATCH",
                    "path" => "lists/$listId/members/$subscriberHash",
                    "body" => json_encode([
                        "status" => "unsubscribed",
                        "merge_fields" => [
                            "EXP_ON" => $expirationDate
                        ]
                    ])
                ]);
            }
        }

        // Send batch request
        $mc = new Mailchimp($mailchimpKey);

        try {
            $mc->post("batches", [
                "operations" => $unsubscribeOperations
            ]);
        } catch (Exception $e) {
            if ($e->getMessage()) {
                $this->error = $e->getMessage();
            } else {
                $this->error = 'An unknown error occurred when unsubscribing members in Mailchimp.';
            }
        }
    }
}
