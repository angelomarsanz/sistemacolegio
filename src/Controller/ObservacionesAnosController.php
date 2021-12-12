<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ObservacionesAnos Controller
 *
 * @property \App\Model\Table\ObservacionesAnosTable $ObservacionesAnos
 */
class ObservacionesAnosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students']
        ];
        $observacionesAnos = $this->paginate($this->ObservacionesAnos);

        $this->set(compact('observacionesAnos'));
        $this->set('_serialize', ['observacionesAnos']);
    }

    /**
     * View method
     *
     * @param string|null $id Observaciones Ano id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $observacionesAno = $this->ObservacionesAnos->get($id, [
            'contain' => ['Students']
        ]);

        $this->set('observacionesAno', $observacionesAno);
        $this->set('_serialize', ['observacionesAno']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $observacionesAno = $this->ObservacionesAnos->newEntity();
        if ($this->request->is('post')) {
            $observacionesAno = $this->ObservacionesAnos->patchEntity($observacionesAno, $this->request->data);
            if ($this->ObservacionesAnos->save($observacionesAno)) {
                $this->Flash->success(__('The observaciones ano has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observaciones ano could not be saved. Please, try again.'));
            }
        }
        $students = $this->ObservacionesAnos->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacionesAno', 'students'));
        $this->set('_serialize', ['observacionesAno']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observaciones Ano id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $observacionesAno = $this->ObservacionesAnos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observacionesAno = $this->ObservacionesAnos->patchEntity($observacionesAno, $this->request->data);
            if ($this->ObservacionesAnos->save($observacionesAno)) {
                $this->Flash->success(__('The observaciones ano has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The observaciones ano could not be saved. Please, try again.'));
            }
        }
        $students = $this->ObservacionesAnos->Students->find('list', ['limit' => 200]);
        $this->set(compact('observacionesAno', 'students'));
        $this->set('_serialize', ['observacionesAno']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observaciones Ano id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observacionesAno = $this->ObservacionesAnos->get($id);
        if ($this->ObservacionesAnos->delete($observacionesAno)) {
            $this->Flash->success(__('The observaciones ano has been deleted.'));
        } else {
            $this->Flash->error(__('The observaciones ano could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
