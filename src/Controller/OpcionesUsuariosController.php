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
    public function isAuthorized($user)
    {
		if(isset($user['role']))
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
        $opcionesUsuario = $this->OpcionesUsuarios->find('All')
            ->contain(['Users', 'Lapsos', 'Materias'])
            ->where(['OpcionesUsuarios.registro_eliminado' => false, 'OpcionesUsuarios.user_id' => $this->Auth->user('id')])
            ->order(['Lapsos.numero_lapso' => 'ASC', 'Materias.nombre_materia' => 'ASC', 'Materias.grado_materia' => 'ASC', 'OpcionesUsuarios.tipo_opcion' => 'ASC', 'OpcionesUsuarios.descripcion_opcion' => 'ASC']);

            $this->set('opcionesUsuarios', $this->paginate($opcionesUsuario, ['limit' => 50]));  
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
                $this->Flash->success(__('La opción fue creada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo crear la opción'));
            }
        }

        $this->loadModel('Profesors');
        $this->loadModel('MateriasProfesors');

        if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
        {
            $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);

            if ($materiasProfesor->count() > 0):
                foreach ($materiasProfesor as $materias):
                    $vectorMaterias[] = $materias->materia_id;
                endforeach;
            endif;

            $materias = $this->OpcionesUsuarios->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias]);
        }
        else
        {
            $materias = $this->Materias->find('list', ['limit' => 200]);
        }

        $lapsos = $this->OpcionesUsuarios->Lapsos->find('list', ['limit' => 200]);
        $this->set(compact('opcionesUsuario', 'lapsos', 'materias'));
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
                $this->Flash->success(__('La opción fue actualizada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo actualizar la opción'));
            }
        }

        $this->loadModel('Profesors');
        $this->loadModel('MateriasProfesors');

        if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
        {
            $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);

            if ($materiasProfesor->count() > 0):
                foreach ($materiasProfesor as $materias):
                    $vectorMaterias[] = $materias->materia_id;
                endforeach;
            endif;

            $materias = $this->OpcionesUsuarios->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias]);
        }
        else
        {
            $materias = $this->Materias->find('list', ['limit' => 200]);
        }

        $lapsos = $this->OpcionesUsuarios->Lapsos->find('list', ['limit' => 200]);
        $this->set(compact('opcionesUsuario', 'lapsos', 'materias'));
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
        $opcionesUsuario->registro_eliminado = 1;
        if ($this->OpcionesUsuarios->save($opcionesUsuario)) {
            $this->Flash->success(__('The opciones usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The opciones usuario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
