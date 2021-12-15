<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OpcionesUsuarios Controller
 *
 * @property \App\Model\Table\OpcionesUsuariosTable $OpcionesUsuarios
 */
class OpcionesUsuariosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Lapsos', 'Materias']
        ];
        $opcionesUsuarios = $this->paginate($this->OpcionesUsuarios);

        $this->set(compact('opcionesUsuarios'));
        $this->set('_serialize', ['opcionesUsuarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Opciones Usuario id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $opcionesUsuario = $this->OpcionesUsuarios->get($id, [
            'contain' => ['Users', 'Lapsos', 'Materias', 'RasgosPersonalidads']
        ]);

        $this->set('opcionesUsuario', $opcionesUsuario);
        $this->set('_serialize', ['opcionesUsuario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $opcionesUsuario = $this->OpcionesUsuarios->newEntity();
        if ($this->request->is('post')) {
            $opcionesUsuario = $this->OpcionesUsuarios->patchEntity($opcionesUsuario, $this->request->data);
            if ($this->OpcionesUsuarios->save($opcionesUsuario)) {
                $this->Flash->success(__('The opciones usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The opciones usuario could not be saved. Please, try again.'));
            }
        }
        $users = $this->OpcionesUsuarios->Users->find('list', ['limit' => 200]);
        $lapsos = $this->OpcionesUsuarios->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->OpcionesUsuarios->Materias->find('list', ['limit' => 200]);
        $this->set(compact('opcionesUsuario', 'users', 'lapsos', 'materias'));
        $this->set('_serialize', ['opcionesUsuario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Opciones Usuario id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $opcionesUsuario = $this->OpcionesUsuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $opcionesUsuario = $this->OpcionesUsuarios->patchEntity($opcionesUsuario, $this->request->data);
            if ($this->OpcionesUsuarios->save($opcionesUsuario)) {
                $this->Flash->success(__('The opciones usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The opciones usuario could not be saved. Please, try again.'));
            }
        }
        $users = $this->OpcionesUsuarios->Users->find('list', ['limit' => 200]);
        $lapsos = $this->OpcionesUsuarios->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->OpcionesUsuarios->Materias->find('list', ['limit' => 200]);
        $this->set(compact('opcionesUsuario', 'users', 'lapsos', 'materias'));
        $this->set('_serialize', ['opcionesUsuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Opciones Usuario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $opcionesUsuario = $this->OpcionesUsuarios->get($id);
        if ($this->OpcionesUsuarios->delete($opcionesUsuario)) {
            $this->Flash->success(__('The opciones usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The opciones usuario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
