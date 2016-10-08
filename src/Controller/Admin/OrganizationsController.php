<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Organizations Controller
 *
 * @property \App\Model\Table\OrganizationsTable $Organizations
 */
class OrganizationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $organizations = $this->Organizations->find('all')
            ->matching('Users', function($q) {
                return $q->where(['Users.id' => $this->loggedInUser['id']]);
            });
        $organizations = $this->paginate($organizations);

        $this->set(compact('organizations'));
        $this->set('_serialize', ['organizations']);
    }

    /**
     * Choose current organization
     *
     * @param string|null $id Organization id
     * @return \Cake\Network\Response|null
     */
    public function choose($id = null) {
        if ($id != null) {
            $this->request->session()->write('CurrentOrganizationId', $id);
            $this->redirect('/');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $organization = $this->Organizations->newEntity();
        if ($this->request->is('post')) {
            $organization = $this->request->data;

            // Link new organization with user that is creating it
            $organization['users'] = [
                [ 'id' => $this->loggedInUser['id'] ]
            ];

            $organization = $this->Organizations->newEntity($organization, ['associated' => ['Users']]);

            if ($this->Organizations->save($organization)) {
                $this->Flash->success(__('The organization has been saved.'));
                return $this->redirect(['action' => 'choose']);
            } else {
                $this->Flash->error(__('The organization could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('organization'));
        $this->set('_serialize', ['organization']);
        $this->viewBuilder()->template('add_edit_common');
    }

    /**
     * Edit method
     *
     * @param string|null $id Organization id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $organization = $this->Organizations->findById($id)
            ->matching('Users', function($q) {
                return $q->where(['Users.id' => $this->loggedInUser['id']]);
            })
            ->first();

        if (!$organization) {
            $this->Flash->error(__('The organization could not be found. Please, select an existing organization or create a new one.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $organization = $this->Organizations->patchEntity($organization, $this->request->data);
            if ($this->Organizations->save($organization)) {
                $this->Flash->success(__('The organization has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The organization could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('organization'));
        $this->set('_serialize', ['organization']);
        $this->viewBuilder()->template('add_edit_common');
    }

    /**
     * Configure mailchimp method
     *
     * @param string|null $id Organization id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function configureMailchimp($id = null)
    {
        if (!$id) {
            $id = $this->currentOrganization['id'];
        }

        $organization = $this->Organizations->findById($id)
            ->matching('Users', function($q) {
                return $q->where(['Users.id' => $this->loggedInUser['id']]);
            })
            ->first();

        if (!$organization) {
            $this->Flash->error(__('The organization could not be found. Please, select an existing organization or create a new one.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $organization = $this->Organizations->patchEntity($organization, $this->request->data);
            if ($this->Organizations->save($organization)) {
                $this->Flash->success(__('The organization has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The organization could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('organization'));
        $this->set('_serialize', ['organization']);
        $this->viewBuilder()->template('configure_mailchimp');
    }

    /**
     * Delete method
     *
     * @param string|null $id Organization id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $organization = $this->Organizations->findById($id)
            ->matching('Users', function($q) {
                return $q->where(['Users.id' => $this->loggedInUser['id']]);
            })
            ->first();

        if (!$organization) {
            $this->Flash->error(__('The organization could not be found. Please, select an existing organization or create a new one.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Organizations->delete($organization)) {
            $this->Flash->success(__('The organization has been deleted.'));
        } else {
            $this->Flash->error(__('The organization could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
