<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ObservacionesLapsos Controller
 *
 * @property \App\Model\Table\ObservacionesLapsosTable $ObservacionesLapsos
 */
class ObservacionesLapsosController extends AppController
{
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete']))
				{
					return true;
				}
			}
        }
        return parent::isAuthorized($user);
    }

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
        $observacionesLapsos = $this->paginate($this->ObservacionesLapsos);

        $this->set(compact('observacionesLapsos'));
        $this->set('_serialize', ['observacionesLapsos']);
    }

    /**
     * View method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $observacionesLapso = $this->ObservacionesLapsos->get($id, [
            'contain' => ['Lapsos', 'Students']
        ]);

        $this->set('observacionesLapso', $observacionesLapso);
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $observacionesLapso = $this->ObservacionesLapsos->newEntity();
        if ($this->request->is('post')) {
            $observacionesLapso = $this->ObservacionesLapsos->patchEntity($observacionesLapso, $this->request->data);
            if ($this->ObservacionesLapsos->save($observacionesLapso)) {
                $this->Flash->success(__('The observaciones lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observaciones lapso could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->ObservacionesLapsos->Lapsos->find('list', ['limit' => 200]);
        $students = $this->ObservacionesLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacionesLapso', 'lapsos', 'students'));
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $observacionesLapso = $this->ObservacionesLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observacionesLapso = $this->ObservacionesLapsos->patchEntity($observacionesLapso, $this->request->data);
            if ($this->ObservacionesLapsos->save($observacionesLapso)) {
                $this->Flash->success(__('The observaciones lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observaciones lapso could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->ObservacionesLapsos->Lapsos->find('list', ['limit' => 200]);
        $students = $this->ObservacionesLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacionesLapso', 'lapsos', 'students'));
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observacionesLapso = $this->ObservacionesLapsos->get($id);
        if ($this->ObservacionesLapsos->delete($observacionesLapso)) {
            $this->Flash->success(__('The observaciones lapso has been deleted.'));
        } else {
            $this->Flash->error(__('The observaciones lapso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
