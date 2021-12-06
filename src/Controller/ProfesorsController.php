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

        $this->loadModel('MateriasProfesors');

        $materiasProfesor = $this->MateriasProfesors->find('all')->contain(['Materias'])->where(['MateriasProfesors.profesor_id' => $id]);

        $this->set(compact('profesor', 'materiasProfesor'));
        $this->set('_serialize', ['profesor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Users');

        $profesor = $this->Profesors->newEntity();
        if ($this->request->is('post')) {
            $profesor = $this->Profesors->patchEntity($profesor, $this->request->data);
            $usuario = $this->Users->newEntity();

            $usuario->username = $profesor->tipo_documento_identificacion . 'P' . $profesor->numero_documento_identificacion;  
            $usuario->password = substr($profesor->primer_apellido, 1, 2) . (string)$profesor->numero_horas . substr($profesor->sexo, 2, 3) . '$';
            $usuario->role = "Profesor";
            $usuario->first_name = $profesor->primer_nombre;
            $usuario->second_name = $profesor->segundo_nombre;
            $usuario->surname = $profesor->primer_apellido;              
            $usuario->second_surname = $profesor->segundo_nombre;
            $usuario->sex = $profesor->sexo;                
            $usuario->email = $profesor->correo_electronico;
            $usuario->cell_phone = $profesor->celular;
            $usuario->profile_photo = substr($profesor->primer_apellido, 1, 2) . (string)$profesor->numero_horas . substr($profesor->sexo, 2, 3) . '$';
            $usuario->profile_photo_dir = "";

            if (!($this->Users->save($usuario))) 
            {
                $this->Flash->error(__('El usuario no fue guardado ' . $usuario->username));
                return $this->redirect(['action' => 'Users', 'action' => 'index']);
            }
            else
            {
                $usuarios = $this->Users->find('all', ['conditions' => ['username' => $usuario->username], 'order' => ['Users.created' => 'DESC'] ]);
                    
                $primerUsuario = $usuarios->first();
                $profesor->user_id = $primerUsuario->id;
                
                if ($this->Profesors->save($profesor)) {
                    $this->Flash->success(__('El profesor fue exitosamente registrado'));
    
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('El profesor no pudo ser registrado, por favor intente nuevamente'));
                }   
            }
        }

        $materias = $this->Profesors->Materias->find('list', ['limit' => 200])->order(['nombre_materia' => 'ASC', 'grado_materia' => 'ASC']);

        $this->set(compact('profesor', 'materias'));
        $this->set('_serialize', ['profesor', 'materias']);
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

        $materias = $this->Profesors->Materias->find('list', ['limit' => 200])->order(['nombre_materia' => 'ASC', 'grado_materia' => 'ASC']);

        $this->set(compact('profesor', 'materias'));
        $this->set('_serialize', ['profesor', 'materias']);
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