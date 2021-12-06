<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MateriasProfesors Controller
 *
 * @property \App\Model\Table\MateriasProfesorsTable $MateriasProfesors
 */
class MateriasProfesorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Materias', 'Profesors']
        ];
        $materiasProfesors = $this->paginate($this->MateriasProfesors);

        $this->set(compact('materiasProfesors'));
        $this->set('_serialize', ['materiasProfesors']);
    }

    /**
     * View method
     *
     * @param string|null $id Materias Profesor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materiasProfesor = $this->MateriasProfesors->get($id, [
            'contain' => ['Materias', 'Profesors']
        ]);

        $this->set('materiasProfesor', $materiasProfesor);
        $this->set('_serialize', ['materiasProfesor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materiasProfesor = $this->MateriasProfesors->newEntity();
        if ($this->request->is('post')) {
            $materiasProfesor = $this->MateriasProfesors->patchEntity($materiasProfesor, $this->request->data);
            if ($this->MateriasProfesors->save($materiasProfesor)) {
                $this->Flash->success(__('The materias profesor has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materias profesor could not be saved. Please, try again.'));
            }
        }
        $materias = $this->MateriasProfesors->Materias->find('list', ['limit' => 200]);
        $profesors = $this->MateriasProfesors->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('materiasProfesor', 'materias', 'profesors'));
        $this->set('_serialize', ['materiasProfesor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Materias Profesor id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materiasProfesor = $this->MateriasProfesors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materiasProfesor = $this->MateriasProfesors->patchEntity($materiasProfesor, $this->request->data);
            if ($this->MateriasProfesors->save($materiasProfesor)) {
                $this->Flash->success(__('The materias profesor has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materias profesor could not be saved. Please, try again.'));
            }
        }
        $materias = $this->MateriasProfesors->Materias->find('list', ['limit' => 200]);
        $profesors = $this->MateriasProfesors->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('materiasProfesor', 'materias', 'profesors'));
        $this->set('_serialize', ['materiasProfesor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materias Profesor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materiasProfesor = $this->MateriasProfesors->get($id);
        if ($this->MateriasProfesors->delete($materiasProfesor)) {
            $this->Flash->success(__('The materias profesor has been deleted.'));
        } else {
            $this->Flash->error(__('The materias profesor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
