<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RasgosPersonalidads Controller
 *
 * @property \App\Model\Table\RasgosPersonalidadsTable $RasgosPersonalidads
 */
class RasgosPersonalidadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lapsos', 'Materias', 'Students', 'OpcionesUsuarios']
        ];
        $rasgosPersonalidads = $this->paginate($this->RasgosPersonalidads);

        $this->set(compact('rasgosPersonalidads'));
        $this->set('_serialize', ['rasgosPersonalidads']);
    }

    /**
     * View method
     *
     * @param string|null $id Rasgos Personalidad id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rasgosPersonalidad = $this->RasgosPersonalidads->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Students', 'OpcionesUsuarios']
        ]);

        $this->set('rasgosPersonalidad', $rasgosPersonalidad);
        $this->set('_serialize', ['rasgosPersonalidad']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rasgosPersonalidad = $this->RasgosPersonalidads->newEntity();
        if ($this->request->is('post')) {
            $rasgosPersonalidad = $this->RasgosPersonalidads->patchEntity($rasgosPersonalidad, $this->request->data);
            if ($this->RasgosPersonalidads->save($rasgosPersonalidad)) {
                $this->Flash->success(__('The rasgos personalidad has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rasgos personalidad could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->RasgosPersonalidads->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->RasgosPersonalidads->Materias->find('list', ['limit' => 200]);
        $students = $this->RasgosPersonalidads->Students->find('list', ['limit' => 200]);
        $opcionesUsuarios = $this->RasgosPersonalidads->OpcionesUsuarios->find('list', ['limit' => 200]);
        $this->set(compact('rasgosPersonalidad', 'lapsos', 'materias', 'students', 'opcionesUsuarios'));
        $this->set('_serialize', ['rasgosPersonalidad']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rasgos Personalidad id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rasgosPersonalidad = $this->RasgosPersonalidads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rasgosPersonalidad = $this->RasgosPersonalidads->patchEntity($rasgosPersonalidad, $this->request->data);
            if ($this->RasgosPersonalidads->save($rasgosPersonalidad)) {
                $this->Flash->success(__('The rasgos personalidad has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rasgos personalidad could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->RasgosPersonalidads->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->RasgosPersonalidads->Materias->find('list', ['limit' => 200]);
        $students = $this->RasgosPersonalidads->Students->find('list', ['limit' => 200]);
        $opcionesUsuarios = $this->RasgosPersonalidads->OpcionesUsuarios->find('list', ['limit' => 200]);
        $this->set(compact('rasgosPersonalidad', 'lapsos', 'materias', 'students', 'opcionesUsuarios'));
        $this->set('_serialize', ['rasgosPersonalidad']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rasgos Personalidad id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rasgosPersonalidad = $this->RasgosPersonalidads->get($id);
        if ($this->RasgosPersonalidads->delete($rasgosPersonalidad)) {
            $this->Flash->success(__('The rasgos personalidad has been deleted.'));
        } else {
            $this->Flash->error(__('The rasgos personalidad could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
