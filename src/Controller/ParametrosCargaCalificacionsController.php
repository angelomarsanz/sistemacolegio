<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ParametrosCargaCalificacions Controller
 *
 * @property \App\Model\Table\ParametrosCargaCalificacionsTable $ParametrosCargaCalificacions
 */
class ParametrosCargaCalificacionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Profesors', 'Lapsos', 'Materias', 'Sections']
        ];
        $parametrosCargaCalificacions = $this->paginate($this->ParametrosCargaCalificacions);

        $this->set(compact('parametrosCargaCalificacions'));
        $this->set('_serialize', ['parametrosCargaCalificacions']);
    }

    /**
     * View method
     *
     * @param string|null $id Parametros Carga Calificacion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->get($id, [
            'contain' => ['Profesors', 'Lapsos', 'Materias', 'Sections']
        ]);

        $this->set('parametrosCargaCalificacion', $parametrosCargaCalificacion);
        $this->set('_serialize', ['parametrosCargaCalificacion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->newEntity();
        if ($this->request->is('post')) {
            $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->patchEntity($parametrosCargaCalificacion, $this->request->data);
            if ($this->ParametrosCargaCalificacions->save($parametrosCargaCalificacion)) {
                $this->Flash->success(__('The parametros carga calificacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The parametros carga calificacion could not be saved. Please, try again.'));
            }
        }
        $profesors = $this->ParametrosCargaCalificacions->Profesors->find('list', ['limit' => 200]);
        $lapsos = $this->ParametrosCargaCalificacions->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->ParametrosCargaCalificacions->Materias->find('list', ['limit' => 200]);
        $sections = $this->ParametrosCargaCalificacions->Sections->find('list', ['limit' => 200]);
        $this->set(compact('parametrosCargaCalificacion', 'profesors', 'lapsos', 'materias', 'sections'));
        $this->set('_serialize', ['parametrosCargaCalificacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Parametros Carga Calificacion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->patchEntity($parametrosCargaCalificacion, $this->request->data);
            if ($this->ParametrosCargaCalificacions->save($parametrosCargaCalificacion)) {
                $this->Flash->success(__('The parametros carga calificacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The parametros carga calificacion could not be saved. Please, try again.'));
            }
        }
        $profesors = $this->ParametrosCargaCalificacions->Profesors->find('list', ['limit' => 200]);
        $lapsos = $this->ParametrosCargaCalificacions->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->ParametrosCargaCalificacions->Materias->find('list', ['limit' => 200]);
        $sections = $this->ParametrosCargaCalificacions->Sections->find('list', ['limit' => 200]);
        $this->set(compact('parametrosCargaCalificacion', 'profesors', 'lapsos', 'materias', 'sections'));
        $this->set('_serialize', ['parametrosCargaCalificacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Parametros Carga Calificacion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parametrosCargaCalificacion = $this->ParametrosCargaCalificacions->get($id);
        if ($this->ParametrosCargaCalificacions->delete($parametrosCargaCalificacion)) {
            $this->Flash->success(__('The parametros carga calificacion has been deleted.'));
        } else {
            $this->Flash->error(__('The parametros carga calificacion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
