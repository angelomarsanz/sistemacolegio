<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Objetivos Controller
 *
 * @property \App\Model\Table\ObjetivosTable $Objetivos
 */
class ObjetivosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lapsos', 'Materias', 'Profesors']
        ];
        $objetivos = $this->paginate($this->Objetivos);

        $this->set(compact('objetivos'));
        $this->set('_serialize', ['objetivos']);
    }

    /**
     * View method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $objetivo = $this->Objetivos->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Profesors', 'Calificacions']
        ]);

        $this->set('objetivo', $objetivo);
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $objetivo = $this->Objetivos->newEntity();
        if ($this->request->is('post')) {
            $objetivo = $this->Objetivos->patchEntity($objetivo, $this->request->data);
            if ($this->Objetivos->save($objetivo)) {
                $this->Flash->success(__('The objetivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The objetivo could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->Objetivos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->Objetivos->Materias->find('list', ['limit' => 200]);
        $profesors = $this->Objetivos->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('objetivo', 'lapsos', 'materias', 'profesors'));
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $objetivo = $this->Objetivos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $objetivo = $this->Objetivos->patchEntity($objetivo, $this->request->data);
            if ($this->Objetivos->save($objetivo)) {
                $this->Flash->success(__('The objetivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The objetivo could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->Objetivos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->Objetivos->Materias->find('list', ['limit' => 200]);
        $profesors = $this->Objetivos->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('objetivo', 'lapsos', 'materias', 'profesors'));
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $objetivo = $this->Objetivos->get($id);
        if ($this->Objetivos->delete($objetivo)) {
            $this->Flash->success(__('The objetivo has been deleted.'));
        } else {
            $this->Flash->error(__('The objetivo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
