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
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'postParametrosCargaCalificaciones', 'calificacionesDescriptivas', 'apreciacionLiteral']))
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

    public function actualizarParametrosCargaCalificaciones($idLapso = null, $idMateria = null, $idEstudiante = null)
    {
        $this->autoRender = false;

        $parametro = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametro)
        {
            $parametro->lapso_id    = $idLapso;
            $parametro->materia_id  = $idMateria;
            $parametro->student_id  = $idEstudiante;

            if (!($this->ParametrosCargaCalificacions->save($parametro))) 
            {
                $this->Flash->error(__('El parámetro no fue actualizado'));
            } 
        }
        else
        {
            $parametro = $this->ParametrosCargaCalificacions->newEntity();
            $parametro->user_id     = $this->Auth->user('id');
            $parametro->lapso_id    = $idLapso;
            $parametro->materia_id  = $idMateria;  
            $parametro->student_id  = $idEstudiante;

            if (!($this->ParametrosCargaCalificacions->save($parametro))) 
            {
                $this->Flash->error(__('El parámetro no fue creado'));
            }
        }
        return;
    }
    public function postParametrosCargaCalificaciones()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $idLapso        = $_POST['id_lapso'];
            $idMateria      = $_POST['id_materia'];
            $idEstudiante   = $_POST['id_estudiante'];
 
            $parametro = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

            if ($parametro)
            {
                $parametro->lapso_id    = $idLapso;
                $parametro->materia_id  = $idMateria;
                $parametro->student_id  = $idEstudiante;

                if (!($this->ParametrosCargaCalificacions->save($parametro))) 
                {
                    $this->Flash->error(__('El parámetro no fue actualizado'));
                } 
            }
            else
            {
                $parametro = $this->ParametrosCargaCalificacions->newEntity();
                $parametro->user_id     = $this->Auth->user('id');
                $parametro->lapso_id    = $idLapso;
                $parametro->materia_id  = $idMateria;  
                $parametro->student_id  = $idEstudiante;

                if (!($this->ParametrosCargaCalificacions->save($parametro))) 
                {
                    $this->Flash->error(__('El parámetro no fue creado'));
                }
            }
            return $this->redirect(['controller' => 'Calificacions', 'action' => 'index']);
        }
    }
    public function calificacionesDescriptivas($idLapso = null, $idMateria = null, $idEstudiante = null, $controlador = null, $accion = null)
    {
        $this->autoRender = false;

        $this->actualizarParametrosCargaCalificaciones($idLapso, $idMateria, $idEstudiante);
        
        return $this->redirect(['controller' => $controlador, 'action' => $accion]);
    }
    public function apreciacionLiteral($idLapso = null, $idMateria = null, $idEstudiante = null, $tipo = null, $controlador = null, $accion = null)
    {
        $this->autoRender = false;

        $this->actualizarParametrosCargaCalificaciones($idLapso, $idMateria, $idEstudiante);
        
        return $this->redirect(['controller' => $controlador, 'action' => $accion, $tipo, $idLapso, $idMateria, $idEstudiante]);
    }
}