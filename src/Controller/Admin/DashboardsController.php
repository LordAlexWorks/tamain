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

        // New members
        $newMembersParams = [ 'stats' => [ 'customFinder' => 'newMembers' ] ];
        $newMembersGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $newMembersParams)
        );

        $newMembers = $this->Members->find('newMembers')
            ->order(['Members.created' => 'DESC']);

        // Soon to deactivate
        $soonToDeactivateParams = [ 'stats' => [ 'customFinder' => 'soonToDeactivateMembers' ] ];
        $soonToDeactivateGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $soonToDeactivateParams)
        );

        $soonToDeactivateMembers = $this->Members
            ->find('soonToDeactivateMembers');
        
        // Recently deactivated
        $recentlyDeactivatedParams = [ 'stats' => [ 'customFinder' => 'recentlyDeactivatedMembers' ] ];
        $recentlyDeactivatedGrowth = $this->Members->find(
            'countGrowth',
            array_merge_recursive($statsParams, $recentlyDeactivatedParams)
        );

        $recentlyDeactivatedMembers = $this->Members
            ->find('recentlyDeactivatedMembers')
            ->contain(['Memberships'])
            ->order(['Memberships.expires_on' => 'DESC']);

        // $metrics['averageAge'] = $this->Members->find('averageAge')->count();
        // $metrics['mostCommonJob'] = $this->Members->find('mostCommonJob')->count();

        $this->set(compact(
            'allMembersGrowth',
            'newMembers',
            'newMembersGrowth',
            'soonToDeactivateMembers',
            'soonToDeactivateGrowth',
            'recentlyDeactivatedMembers',
            'recentlyDeactivatedGrowth'
        ));
    }
}
