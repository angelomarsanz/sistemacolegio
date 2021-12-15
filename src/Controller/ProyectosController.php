<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proyectos Controller
 *
 * @property \App\Model\Table\ProyectosTable $Proyectos
 */
class ProyectosController extends AppController
{
    public function isAuthorized($user)
    {
		if (isset($user['role']))
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
        $this->loadModel('Materias');
        $this->loadModel('Profesors');
        $this->loadModel('MateriasProfesors');

        $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        $materiaProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id])->first();
        $materia = $this->Materias->get($materiaProfesor->materia_id, [
            'contain' => ['Sections']
        ]);

        $proyectos = $this->Proyectos->find('All')
        ->contain(['Lapsos', 'Sections'])
        ->where(['Proyectos.registro_eliminado' => false, 'Proyectos.section_id' => $materia->section_id, 'Lapsos.periodo_escolar' => '2021-2022'])
        ->order(['Proyectos.identificador_proyecto' => 'ASC']);

        $this->set(compact('materia'));
        $this->set('proyectos', $this->paginate($proyectos, ['limit' => 50]));    
    }

    /**
     * View method
     *
     * @param string|null $id Proyecto id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $proyecto = $this->Proyectos->get($id, [
            'contain' => ['Lapsos']
        ]);

        $this->set('proyecto', $proyecto);
        $this->set('_serialize', ['proyecto']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Materias');
        $this->loadModel('Profesors');
        $this->loadModel('MateriasProfesors');

        $proyecto = $this->Proyectos->newEntity();
        if ($this->request->is('post')) {
            $proyecto = $this->Proyectos->patchEntity($proyecto, $this->request->data);
            if ($this->Proyectos->save($proyecto)) {
                $this->Flash->success(__('El proyecto fue creado'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo crear el proyecto'));
            }
        }

        $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        $materiaProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id])->first();
        $materia = $this->Materias->get($materiaProfesor->materia_id, [
            'contain' => ['Sections']
        ]);

        $lapsos = $this->Proyectos->Lapsos->find('list', ['limit' => 200]);
        $this->set(compact('proyecto', 'lapsos', 'materia'));
        $this->set('_serialize', ['proyecto']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Proyecto id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proyecto = $this->Proyectos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proyecto = $this->Proyectos->patchEntity($proyecto, $this->request->data);
            if ($this->Proyectos->save($proyecto)) {
                $this->Flash->success(__('El proyecto fue actualizado'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo actualizar el proyecto'));
            }
        }
        $lapsos = $this->Proyectos->Lapsos->find('list', ['limit' => 200]);
        $this->set(compact('proyecto', 'lapsos'));
        $this->set('_serialize', ['proyecto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Proyecto id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proyecto = $this->Proyectos->get($id);
        $proyecto->registro_eliminado = 1;
        if ($this->Proyectos->save($proyecto)) {
            $this->Flash->success(__('El proyecto fue eliminado'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el proyecto'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
