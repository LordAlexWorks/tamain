<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // Authorization
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Members',
                'action' => 'index',
                'prefix' => 'admin'
            ],
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth'
                ]
            ],
        ]);
    }

    /**
     * Before every action in the controller.
     *
     * @param \Cake\Event\Event $event The beforeFilter event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        // Allow public function without prefix ones
        if (empty($this->request->params['prefix'])) {
            $this->Auth->allow();
            return;
        }

        // Functions with prefix will need an organization
        if (!$this->Auth->user()) {
            $this->Auth->deny();
            return;
        }

        $this->loggedInUser = $this->Auth->user();

        $this->loadModel('Organizations');
        $this->loggedInUser['organizations'] = $this->Organizations->find('all')
            ->matching('Users', function ($q) {
                return $q->where(['Users.id' => $this->loggedInUser['id']]);
            })
            ->select(['id', 'name']);

        // Current organization
        $currentOrganizationId = $this->request->session()->read('CurrentOrganizationId');
        $this->currentOrganization = null;
        
        if ($currentOrganizationId) {
            $this->currentOrganization = $this->Organizations->findById($currentOrganizationId)->first();
        }

        if (!$this->currentOrganization) {
            if (($this->request->params['controller'] == 'Organizations') 
                && ($this->request->params['action'] == 'choose')) {
                return;
            }
            else {
                $this->redirect(['controller' => 'Organizations', 'action' => 'choose']);
            }
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (isset($this->loggedInUser)) {
            $this->set('loggedInUser', $this->loggedInUser);
        }
        if (isset($this->currentOrganization)) {
            $this->set('currentOrganization', $this->currentOrganization);
        }

        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
