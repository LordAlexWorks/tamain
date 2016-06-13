<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Dashboards Controller
 *
 */
class DashboardsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null|void
     */
    public function index()
    {
        $this->loadModel('Members');

        // Lists
        $allMembers = $this->Members->find('all');
        $activeMembers = $this->Members->find('activeMembers');
        $newMembers = $this->Members->find('newMembers');

        $statsParams = [
            'stats' => [
                'field' => 'created',
                'referenceDate' => 'today',
                'dates' => ['-1 month', '-1 year']
            ]
        ];

        $allMembersGrowth = $this->Members->find('countGrowth', $statsParams);

        // Need to fix new members query
        $newMembersGrowth = $this->Members->find('newMembers')->find('countGrowth', $statsParams);

        // $soonToExpireMembers = $this->Members->find('soonToExpireMembers');
        $recentlyDeactivatedMembers = $this->Members
            ->find('limboMembers')
            ->contain(['Memberships' => [
                'sort' => ['expires_on' => 'DESC']
            ]]);

        // Numeric metrics
        $metrics['numRegisteredMembers'] = $allMembers->count();
        $metrics['numActiveMembers'] = $activeMembers->count();
        $metrics['numNewMembers'] = $newMembers->count();
        $metrics['numRecentlyDeactivatedMembers'] = $recentlyDeactivatedMembers->count();

        // $metrics['averageAge'] = $this->Members->find('averageAge')->count();
        // $metrics['mostCommonJob'] = $this->Members->find('mostCommonJob')->count();

        $this->set(compact('allMembersGrowth', 'newMembersGrowth', 'metrics', 'allMembers', 'activeMembers', 'newMembers', 'recentlyDeactivatedMembers'));
    }
}
