<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Observacions Controller
 *
 * @property \App\Model\Table\ObservacionsTable $Observacions
 */
class ObservacionsController extends AppController
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
        $this->loadModel('Students');
        $this->loadModel('Sections');
        $this->loadModel('Materias');
        $this->loadModel('Lapsos');
        $this->loadModel('ParametrosCargaCalificacions');

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idMateria      = $parametrosCargaCalificaciones->materia_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapso = $this->Lapsos->get($idLapso);
            $materia = $this->Materias->get($idMateria);
            $seccion = $this->Sections->get($materia->section_id);
            $estudiante = $this->Students->get($idEstudiante);

            $observacionesMateria = $this->Observacions->find('All')
            ->contain(['Lapsos', 'Materias', 'Students'])
            ->where(['Observacions.registro_eliminado' => false, 'Observacions.lapso_id' => $idLapso, 'Observacions.materia_id' => $idMateria, 'Observacions.student_id' => $idEstudiante])
            ->order(['Observacions.tipo_observacion' => 'ASC']);

            $this->set(compact('idLapso', 'idMateria', 'idEstudiante', 'lapso', 'materia', 'seccion', 'estudiante'));
            $this->set('observacionesMateria', $this->paginate($observacionesMateria, ['limit' => 50]));
        }
        else
        {
            return $this->redirect(['controller' => 'Users', 'action' => 'wait']);        
        }   
    }

    /**
     * View method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $observacion = $this->Observacions->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Students']
        ]);

        $this->set('observacion', $observacion);
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('ParametrosCargaCalificacions');

        $observacion = $this->Observacions->newEntity();
        if ($this->request->is('post')) {
            $observacion = $this->Observacions->patchEntity($observacion, $this->request->data);
            if ($this->Observacions->save($observacion)) {
                $this->Flash->success(__('La calificación ha sido registrada exitosamente'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo registrar la calificación'));
            }
        }

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idMateria      = $parametrosCargaCalificaciones->materia_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200])->where(['id' => $idLapso]);
            $materias = $this->Observacions->Materias->find('list', ['limit' => 200])->where(['id' => $idMateria]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200])->where(['id' => $idEstudiante]);
        }
        else
        {
            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
            $materias = $this->Observacions->Materias->find('list', ['limit' => 200]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200]);            
        }
        $this->set(compact('observacion', 'lapsos', 'materias', 'estudiantes', 'idLapso', 'idMateria', 'idEstudiante'));
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('ParametrosCargaCalificacions');

        $observacion = $this->Observacions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observacion = $this->Observacions->patchEntity($observacion, $this->request->data);
            if ($this->Observacions->save($observacion)) {
                $this->Flash->success(__('La calificación fue actualizada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo actualizar la calificación'));
            }
        }

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idMateria      = $parametrosCargaCalificaciones->materia_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200])->where(['id' => $idLapso]);
            $materias = $this->Observacions->Materias->find('list', ['limit' => 200])->where(['id' => $idMateria]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200])->where(['id' => $idEstudiante]);
        }
        else
        {
            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
            $materias = $this->Observacions->Materias->find('list', ['limit' => 200]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200]);            
        }
        $this->set(compact('observacion', 'lapsos', 'materias', 'estudiantes', 'idLapso', 'idMateria', 'idEstudiante'));
        $this->set('_serialize', ['observacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observacion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observacion = $this->Observacions->get($id);
        $observacion->registro_eliminado = 1;

        if ($this->Observacions->save($observacion)) 
        {
            $this->Flash->success(__('La calificación fue eliminada'));
        } 
        else 
        {
            $this->Flash->error(__('La calificación no pudo ser eliminada'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
