<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Profesors Controller
 *
 * @property \App\Model\Table\ProfesorsTable $Profesors
 */
class ProfesorsController extends AppController
{
    public function isAuthorized($user)
    {
		if(in_array($this->request->action, ['add']))
		{
			return true;
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
        $profesors = $this->paginate($this->Profesors);

        $this->set(compact('profesors'));
        $this->set('_serialize', ['profesors']);
    }

    /**
     * View method
     *
     * @param string|null $id Profesor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $profesor = $this->Profesors->get($id, [
            'contain' => []
        ]);

        $this->set('profesor', $profesor);
        $this->set('_serialize', ['profesor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $profesor = $this->Profesors->newEntity();
        if ($this->request->is('post')) {
            $profesor = $this->Profesors->patchEntity($profesor, $this->request->data);
            $profesor->user_id = 2;
            if ($this->Profesors->save($profesor)) {
                $this->Flash->success(__('El profesor fue exitosamente registrado'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El profesor no pudo ser registrado, por favor intente nuevamente'));
            }
        }

        $materias = $this->Profesors->Materias->find('list', ['limit' => 200]);

        $this->set(compact('profesor', 'materias'));
        $this->set('_serialize', ['profesor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Profesor id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $profesor = $this->Profesors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $profesor = $this->Profesors->patchEntity($profesor, $this->request->data);
            if ($this->Profesors->save($profesor)) {
                $this->Flash->success(__('El profesor fue actualizado exitosamente'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('El profesor no pudo ser actualizado. Por favor intente nuevamente'));
            }
        }

        $secciones = $this->Profesors->Sections->find('list', ['limit' => 200]);

        $this->set(compact('profesor', 'secciones'));
        $this->set('_serialize', ['profesor', 'secciones']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Profesor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $Profesor = $this->Profesors->get($id);
        if ($this->Profesors->delete($Profesor)) {
            $this->Flash->success(__('El profesor fue eliminado exitosamente'));
        } else {
            $this->Flash->error(__('El profesor no pudo ser eliminado por favor intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}