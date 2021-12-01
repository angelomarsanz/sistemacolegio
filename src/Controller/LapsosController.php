<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Lapsos Controller
 *
 * @property \App\Model\Table\LapsosTable $Lapsos
 */
class LapsosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $lapsos = $this->paginate($this->Lapsos);

        $this->set(compact('lapsos'));
        $this->set('_serialize', ['lapsos']);
    }

    /**
     * View method
     *
     * @param string|null $id Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lapso = $this->Lapsos->get($id, [
            'contain' => ['EstudianteLapsos', 'LiteralLapsos', 'LiteralMaterias', 'Objetivos', 'Observacions', 'ParametrosCargaCalificacions', 'PruebaLapsos']
        ]);

        $this->set('lapso', $lapso);
        $this->set('_serialize', ['lapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lapso = $this->Lapsos->newEntity();
        if ($this->request->is('post')) {
            $lapso = $this->Lapsos->patchEntity($lapso, $this->request->data);
            if ($this->Lapsos->save($lapso)) {
                $this->Flash->success(__('The lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lapso could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('lapso'));
        $this->set('_serialize', ['lapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lapso = $this->Lapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lapso = $this->Lapsos->patchEntity($lapso, $this->request->data);
            if ($this->Lapsos->save($lapso)) {
                $this->Flash->success(__('The lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lapso could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('lapso'));
        $this->set('_serialize', ['lapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lapso = $this->Lapsos->get($id);
        if ($this->Lapsos->delete($lapso)) {
            $this->Flash->success(__('The lapso has been deleted.'));
        } else {
            $this->Flash->error(__('The lapso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
