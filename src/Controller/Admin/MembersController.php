<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 */
class MembersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null|void
     */
    public function index()
    {
        $members = $this->paginate($this->Members);

        $this->set(compact('members'));
        $this->set('_serialize', ['members']);
    }

    /**
     * View method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Memberships']
        ]);

        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $member = $this->Members->newEntity();
        if ($this->request->is('post')) {
            $member = $this->Members->patchEntity($member, $this->request->data);
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }

        $membershipDefaultExpiration = $this->Members->Memberships->getMembershipDefaultExpiration();
        $this->set(compact('member', 'membershipDefaultExpiration'));
        $this->set('_serialize', ['member', 'membershipDefaultExpiration']);
        $this->viewBuilder()->template('add_edit_common');
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Memberships']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Members->patchEntity(
                $member,
                $this->request->data,
                ['associated' => ['Memberships']]
            );
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        
        $membershipDefaultExpiration = $this->Members->Memberships->getMembershipDefaultExpiration();
        $this->set(compact('member', 'membershipDefaultExpiration'));
        $this->set('_serialize', ['member', 'membershipDefaultExpiration']);
        $this->viewBuilder()->template('add_edit_common');
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Import from CSV
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function import()
    {
        $this->loadModel('FileUploads');
        $fileUpload = $this->FileUploads->newEntity();
        if ($this->request->is('post')) {
            $fileUploadData = $this->request->data;
            $fileUploadData['type'] = $this->request->data["file_name"]["type"];
            $fileUploadData['user_id'] = $this->Auth->user('id');
            $fileUploadData['file_dir'] = $this->Members->getMemberImportUploadDir();

            // File upload
            $fileUpload = $this->FileUploads->patchEntity($fileUpload, $fileUploadData);

            if ($this->FileUploads->save($fileUpload)) {
                // Import members
                $importMessages = $this->Members->import($fileUpload->id);
                debug($importMessages);

                if (empty($importMessages['errors'])) {
                    $this->Flash->success(__('All members have been imported!'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Not all members were imported. Please, check your spreadsheet and try again.'));
                    $this->set(compact('importMessages'));
                }
            } else {
                $this->Flash->error(__('The file upload was not successful. Please, try again.'));
            }
        }
        $this->set(compact('fileUpload'));
        $this->set('_serialize', ['fileUpload']);
    }

    /**
     * Filter members
     *
     * @return \Cake\Network\Response|void
     */
    public function filter()
    {
        if ($this->request->is('post')) {
            $standardFilter = $this->request->data('standardFilter');
            if ($standardFilter && !empty($standardFilter)) {
                // Existing filters: new members and expired members
                $members = $this->Members->find($standardFilter);
            } else {
                // Custom filters
                $minDate = $this->request->data('min_date');
                
                $members = $this->Members->find()
                    ->matching('Memberships', function ($q) use ($minDate) {
                        return $q->where([
                            'Memberships.expires_on >=' => $minDate['year'] . "/" . $minDate['month'] . "/" . $minDate['day']
                        ]);
                    });
            }

            $members = $members
                ->contain(['Memberships' => [
                    'sort' => ['Memberships.expires_on' => 'DESC']
                ]])
                ->autoFields(true)
                ->distinct(['Members.id'])
                ->toArray();

            $_serialize = 'members';
            $_header = [__('Email'), __('First name'), __('Last name'),
                __('Job title'), __('Company'), __('Twitter'),
                __('Active'), __('Last membership expires on') ];
            $_extract = [
                'email',
                'firstname',
                'lastname',
                'job',
                'company',
                'twitter',
                'has_active_membership_text',
                'memberships.0.expires_on'
            ];
            $_delimiter = ";";

            $this->response->download('Tamarin_Members_' . date('Y-m-d_h-s') . '.csv');

            $this->viewBuilder()->className('CsvView.Csv');
            $this->set(compact('members', '_serialize', '_header', '_extract', '_delimiter'));
            return;
        }

        $dateModifier = $this->Members->settingsFilters['newMembers']['dateModifier'];
        $newMembersDate = date_format(new \DateTime($dateModifier), 'd/m/Y');

        $dateModifier = $this->Members->settingsFilters['deactivatedMembers']['dateModifier'];
        $deactivatedMembersDate = date_format(new \DateTime($dateModifier), 'd/m/Y');

        $this->set(compact('members', 'newMembersDate', 'deactivatedMembersDate'));
        $this->set('_serialize', ['members']);
    }
}
