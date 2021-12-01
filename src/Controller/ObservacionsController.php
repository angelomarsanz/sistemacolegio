<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Observacions Controller
 *
 * @property \App\Model\Table\ObservacionsTable $Observacions
 */
class ObservacionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lapsos', 'Students']
        ];
        $observacions = $this->paginate($this->Observacions);

        $this->set(compact('observacions'));
        $this->set('_serialize', ['observacions']);
    }

    /**
     * View method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $observacion = $this->Observacions->get($id, [
            'contain' => ['Lapsos', 'Students']
        ]);

        $this->set('observacion', $observacion);
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $observacion = $this->Observacions->newEntity();
        if ($this->request->is('post')) {
            $observacion = $this->Observacions->patchEntity($observacion, $this->request->data);
            if ($this->Observacions->save($observacion)) {
                $this->Flash->success(__('The observacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observacion could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
        $students = $this->Observacions->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacion', 'lapsos', 'students'));
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $observacion = $this->Observacions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observacion = $this->Observacions->patchEntity($observacion, $this->request->data);
            if ($this->Observacions->save($observacion)) {
                $this->Flash->success(__('The observacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observacion could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
        $students = $this->Observacions->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacion', 'lapsos', 'students'));
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observacion = $this->Observacions->get($id);
        if ($this->Observacions->delete($observacion)) {
            $this->Flash->success(__('The observacion has been deleted.'));
        } else {
            $this->Flash->error(__('The observacion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
