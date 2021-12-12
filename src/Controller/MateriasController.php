<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Materias Controller
 *
 * @property \App\Model\Table\MateriasTable $Materias
 */
class MateriasController extends AppController
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
        $materias = $this->paginate($this->Materias);

        $this->set(compact('materias'));
        $this->set('_serialize', ['materias']);
    }

    /**
     * View method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materia = $this->Materias->get($id, [
            'contain' => []
        ]);

        $this->loadModel('MateriasProfesors');
        $profesoresMateria = $this->MateriasProfesors->find('all')->contain(['Profesors'])->where(['MateriasProfesors.materia_id' => $id]);

        $this->set(compact('materia', 'profesoresMateria'));
        $this->set('_serialize', ['materia']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materia = $this->Materias->newEntity();
        if ($this->request->is('post')) {
            $materia = $this->Materias->patchEntity($materia, $this->request->data);

            $seccion = $this->Materias->Sections->get($materia->section_id);

            $materia->grado_materia = $seccion->sublevel;

            if ($this->Materias->save($materia)) {
                $this->Flash->success(__('La materia fue exitosamente registrada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La materia no pudo ser registrada, por favor intente nuevamente'));
            }
        }

        $secciones = $this->Materias->Sections->find('list', ['limit' => 200])->where(['level !=' => 'Pre-escolar', 'section' => 'A']);
        $profesors = $this->Materias->Profesors->find('list', ['limit' => 200]);

        $this->set(compact('materia', 'secciones', 'profesors'));
        $this->set('_serialize', ['materia', 'secciones', 'profesors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materia = $this->Materias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materia = $this->Materias->patchEntity($materia, $this->request->data);
            if ($this->Materias->save($materia)) {
                $this->Flash->success(__('La materia fue actualizada exitosamente'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La materia no pudo ser actualizada. Por favor intente nuevamente'));
            }
        }

        $secciones = $this->Materias->Sections->find('list', ['limit' => 200])->where(['level !=' => 'Pre-escolar']);
        $profesors = $this->Materias->Profesors->find('list', ['limit' => 200]);

        $this->set(compact('materia', 'secciones', 'profesors'));
        $this->set('_serialize', ['materia', 'secciones', 'profesors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $Materia = $this->Materias->get($id);
        if ($this->Materias->delete($Materia)) {
            $this->Flash->success(__('La materia fue eliminada exitosamente'));
        } else {
            $this->Flash->error(__('La materia no pudo ser eliminada por favor intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}