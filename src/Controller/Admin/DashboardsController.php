<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Dashboards Controller
 *
 */
class DashboardsController extends AppController
{
    public $helpers = ['Statistics'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null|void
     */
    public function index()
    {
        $this->loadModel('Members');

        $statsParams = [
            'stats' => [
                'field' => 'created',
                'dates' => ['-1 month', '-1 year']
            ]
        ];

        $allMembersGrowth = $this->Members->find('countGrowth', $statsParams);

        // Members that renewed membership
        $reregistratedParams = [ 'stats' => [ 'customFinder' => 'reregistratedMembers' ] ];
        $reregistratedGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $reregistratedParams)
        );

        $reregistrationRate = 0;
        if ($allMembersGrowth['reference']['count']) {
            $reregistrationRate = ($reregistratedGrowth['reference']['count'] / $allMembersGrowth['reference']['count']) * 100;
        }

        // New members
        $newMembersParams = [ 'stats' => [ 'customFinder' => 'newMembers' ] ];
        $newMembersGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $newMembersParams)
        );

        $newMembers = $newMembersGrowth['reference']['query']->order(['Members.created' => 'DESC']);

        // Soon to deactivate
        $soonToDeactivateParams = [ 'stats' => [ 'customFinder' => 'soonToDeactivateMembers' ] ];
        $soonToDeactivateGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $soonToDeactivateParams)
        );

        $soonToDeactivateMembers = $soonToDeactivateGrowth['reference']['query'];

        // Recently deactivated
        $recentlyDeactivatedParams = [ 'stats' => [ 'customFinder' => 'recentlyDeactivatedMembers' ] ];
        $recentlyDeactivatedGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $recentlyDeactivatedParams)
        );

        $recentlyDeactivatedMembers = $recentlyDeactivatedGrowth['reference']['query']
            ->contain('Memberships')
            ->order(['Memberships.expires_on' => 'DESC']);

        // $metrics['averageAge'] = $this->Members->find('averageAge')->count();
        // $metrics['mostCommonJob'] = $this->Members->find('mostCommonJob')->count();

        $this->set(compact(
            'allMembersGrowth',
            'reregistratedGrowth',
            'reregistrationRate',
            'newMembers',
            'newMembersGrowth',
            'soonToDeactivateMembers',
            'soonToDeactivateGrowth',
            'recentlyDeactivatedMembers',
            'recentlyDeactivatedGrowth'
        ));
    }
}
