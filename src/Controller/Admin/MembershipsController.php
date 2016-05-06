<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Memberships Controller
 *
 * @property \App\Model\Table\MembershipsTable $Memberships
 */
class MembershipsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Members']
        ];
        $memberships = $this->paginate($this->Memberships);

        $this->set(compact('memberships'));
        $this->set('_serialize', ['memberships']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership id.
     * @return \Cake\Network\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membership = $this->Memberships->get($id, [
            'contain' => ['Members']
        ]);

        $this->set('membership', $membership);
        $this->set('_serialize', ['membership']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membership = $this->Memberships->newEntity();
        if ($this->request->is('post')) {
            $membership = $this->Memberships->patchEntity($membership, $this->request->data);
            if ($this->Memberships->save($membership)) {
                $this->Flash->success(__('The membership has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The membership could not be saved. Please, try again.'));
            }
        }
        $members = $this->Memberships->Members->find('list', ['limit' => 200]);
        $this->set(compact('membership', 'members'));
        $this->set('_serialize', ['membership']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membership = $this->Memberships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membership = $this->Memberships->patchEntity($membership, $this->request->data);
            if ($this->Memberships->save($membership)) {
                $this->Flash->success(__('The membership has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The membership could not be saved. Please, try again.'));
            }
        }
        $members = $this->Memberships->Members->find('list', ['limit' => 200]);
        $this->set(compact('membership', 'members'));
        $this->set('_serialize', ['membership']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membership = $this->Memberships->get($id);
        if ($this->Memberships->delete($membership)) {
            $this->Flash->success(__('The membership has been deleted.'));
        } else {
            $this->Flash->error(__('The membership could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
