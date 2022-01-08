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
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'verificarRasgos', 'cargarRasgos']))
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
    public function verificarRasgos($idLapso = null, $idMateria = null, $idEstudiante = null, $tipoOpcion = null)
    {
        $this->autoRender = false;

        $opcionesUsuario = $this->RasgosPersonalidads->OpcionesUsuarios->find('All', ['limit' => 3])
        ->contain(['Users', 'Lapsos', 'Materias'])
        ->where(['OpcionesUsuarios.registro_eliminado' => false, 'OpcionesUsuarios.user_id' => $this->Auth->user('id'), 'OpcionesUsuarios.lapso_id' => $idLapso, 'OpcionesUsuarios.materia_id' => $idMateria, 'OpcionesUsuarios.tipo_opcion' => $tipoOpcion])
        ->order(['OpcionesUsuarios.descripcion_opcion' => 'ASC']);

        if ($opcionesUsuario->count() == 0):
            $this->Flash->success(__('Estimado profesor, primero debe establecer los tres rasgos de personalidad que evaluará en este lapso. Por favor agregue el primero y después los otros dos'));
            return $this->redirect(['controller' => 'OpcionesUsuarios', 'action' => 'add']);
        endif;

        $rasgosPersonalidad = $this->RasgosPersonalidads->find('All')
        ->contain(['Lapsos', 'Materias', 'Students', 'OpcionesUsuarios'])
        ->where(['RasgosPersonalidads.registro_eliminado' => false, 'RasgosPersonalidads.lapso_id' => $idLapso, 'RasgosPersonalidads.materia_id' => $idMateria, 'OpcionesUsuarios.tipo_opcion' => 'Rasgos de personalidad'])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC', 'OpcionesUsuarios.descripcion_opcion' => 'ASC']);

        if ($rasgosPersonalidad->count() == 0):
            foreach ($opcionesUsuario as $opcion):
                $rasgosPer = $this->RasgosPersonalidads->newEntity();
                $rasgosPer->lapso_id = $idLapso;
                $rasgosPer->materia_id = $idMateria;
                $rasgosPer->student_id = $idEstudiante;
                $rasgosPer->opciones_usuario_id = $opcion->id;
                $rasgosPer->calificacion = '*';
                if (!($this->RasgosPersonalidads->save($rasgosPer))): 
                    $this->Flash->error(__('El rasgo no pudo ser registrado'));
                endif;
            endforeach;
        endif;
        return $this->redirect(['action' => 'cargarRasgos', $idLapso, $idMateria, $idEstudiante, $tipoOpcion]);
    }
    public function cargarRasgos($idLapso = null, $idMateria = null, $idEstudiante = null, $tipoOpcion = null)
    {
        $rasgosPersonalidad = $this->RasgosPersonalidads->find('All')
        ->contain(['Lapsos', 'Materias', 'Students', 'OpcionesUsuarios'])
        ->where(['RasgosPersonalidads.registro_eliminado' => false, 'RasgosPersonalidads.lapso_id' => $idLapso, 'RasgosPersonalidads.materia_id' => $idMateria, 'OpcionesUsuarios.tipo_opcion' => 'Rasgos de personalidad'])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC', 'OpcionesUsuarios.id' => 'ASC']);

        if ($this->request->is('post')):
            foreach ($rasgosPersonalidad as $rasgo):
                $rasgoGet = $this->RasgosPersonalidads->get($rasgo->id);
                $rasgoGet->calificacion = $_POST['rasgo_' . $rasgo->id];
                if (!($this->RasgosPersonalidads->save($rasgoGet))): 
                    $this->Flash->error(__('La calificación no pudo ser actualizada'));
                endif;
            endforeach;
            return $this->redirect(['controller' => 'Calificacions', 'action' => 'index']);
        endif;

        $this->set(compact('idEstudiante', 'idMateria', 'idLapso', 'rasgosPersonalidad'));
    }
}