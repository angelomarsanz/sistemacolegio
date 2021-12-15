<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ObservacionesLapsos Controller
 *
 * @property \App\Model\Table\ObservacionesLapsosTable $ObservacionesLapsos
 */
class ObservacionesLapsosController extends AppController
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
        $this->loadModel('Lapsos');
        $this->loadModel('ParametrosCargaCalificacions');

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapso = $this->Lapsos->get($idLapso);
            $estudiante = $this->Students->get($idEstudiante);

            $observacionesLapso = $this->ObservacionesLapsos->find('All')
            ->contain(['Lapsos', 'Students'])
            ->where(['ObservacionesLapsos.registro_eliminado' => false, 'ObservacionesLapsos.student_id' => $idEstudiante, 'ObservacionesLapsos.lapso_id' => $idLapso])
            ->order(['ObservacionesLapsos.tipo_observacion' => 'ASC']);

            $this->set(compact('idLapso', 'idEstudiante', 'lapso', 'estudiante'));
            $this->set('observacionesLapso', $this->paginate($observacionesLapso, ['limit' => 50]));
        }
        else
        {
            return $this->redirect(['controller' => 'Users', 'action' => 'wait']);        
        }   

    }

    /**
     * View method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $observacionesLapso = $this->ObservacionesLapsos->get($id, [
            'contain' => ['Lapsos', 'Students']
        ]);

        $this->set('observacionesLapso', $observacionesLapso);
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('ParametrosCargaCalificacions');

        $observacionesLapso = $this->ObservacionesLapsos->newEntity();
        if ($this->request->is('post')) {
            $observacionesLapso = $this->ObservacionesLapsos->patchEntity($observacionesLapso, $this->request->data);
            if ($this->ObservacionesLapsos->save($observacionesLapso)) {
                $this->Flash->success(__('La calificación fue agregada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo agregar la calificación'));
            }
        }

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapsos = $this->ObservacionesLapsos->Lapsos->find('list', ['limit' => 200])->where(['id' => $idLapso]);
            $estudiantes = $this->ObservacionesLapsos->Students->find('list', ['limit' => 200])->where(['id' => $idEstudiante]);
        }
        else
        {
            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200]);            
        }
        $this->set(compact('observacionesLapso', 'lapsos', 'estudiantes', 'idLapso', 'idEstudiante'));
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('ParametrosCargaCalificacions');

        $observacionesLapso = $this->ObservacionesLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observacionesLapso = $this->ObservacionesLapsos->patchEntity($observacionesLapso, $this->request->data);
            if ($this->ObservacionesLapsos->save($observacionesLapso)) {
                $this->Flash->success(__('La calificación se actualizó'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo actualizar la calificación'));
            }
        }

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $idLapso        = $parametrosCargaCalificaciones->lapso_id;
            $idEstudiante   = $parametrosCargaCalificaciones->student_id;

            $lapsos = $this->ObservacionesLapsos->Lapsos->find('list', ['limit' => 200])->where(['id' => $idLapso]);
            $estudiantes = $this->ObservacionesLapsos->Students->find('list', ['limit' => 200])->where(['id' => $idEstudiante]);
        }
        else
        {
            $lapsos = $this->Observacions->Lapsos->find('list', ['limit' => 200]);
            $estudiantes = $this->Observacions->Students->find('list', ['limit' => 200]);            
        }
        $this->set(compact('observacionesLapso', 'lapsos', 'estudiantes', 'idLapso', 'idEstudiante'));
        $this->set('_serialize', ['observacionesLapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observaciones Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observacionesLapso = $this->ObservacionesLapsos->get($id);
        $observacionesLapso->registro_eliminado = 1;
        if ($this->ObservacionesLapsos->save($observacionesLapso)) {
            $this->Flash->success(__('La calificación fue eliminada'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la calificación'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
