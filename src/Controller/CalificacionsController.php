<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Calificacions Controller
 *
 * @property \App\Model\Table\CalificacionsTable $Calificacions
 */
class CalificacionsController extends AppController
{

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'actualizarParametros', 'registrarCalificaciones']))
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
        $this->loadModel('Lapsos');
        $this->loadModel('Materias');
        $this->loadModel('Profesors');
        $this->loadModel('Objetivos');
        $this->loadModel('MateriasProfesors');
        $this->loadModel('ParametrosCargaCalificacions');
        $this->loadModel('LiteralMaterias');
        $this->loadModel('LiteralLapsos');
        $this->loadModel('RasgosPersonalidads');
        $this->loadModel('OpcionesUsuarios');
        $objetivos = new ObjetivosController();

        $vectorMaterias = [];

        $lapsos = $this->Lapsos->find('list', ['limit' => 200]);

        if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
        {
            $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);
            $objetivosProfesor = $this->Objetivos->find('all')->where(['profesor_id' => $profesor->id]);

            if ($materiasProfesor->count() > 0):
                foreach ($materiasProfesor as $materias):
                    $vectorMaterias[] = $materias->materia_id;
                endforeach;
            endif;

            $materias = $this->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias]);
        }
        else
        {
            $materias = $this->Materias->find('list', ['limit' => 200]);
        }

        $objetivos->crearObjetivos();

        $lapsoBuscar = 0;
        $materiaBuscar = 0;

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $lapsoBuscar = $parametrosCargaCalificaciones->lapso_id;
            $materiaBuscar = $parametrosCargaCalificaciones->materia_id;
        }
        else
        {
            if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
            {
                $objetivoProfesor = $this->Objetivos->find('all')->where(['profesor_id' => $profesor->id])->first();
                if ($objetivoProfesor)
                {
                    $lapsoBuscar = $objetivoProfesor->lapso_id;
                    $materiaBuscar = $objetivoProfesor->materia_id;
                }
            }
            else
            {
                $lapsoBuscar = 1;
                $materiaBuscar = 1;
            }
        }

        $materia = $this->Materias->get($materiaBuscar);

        $estudiantes = $this->Calificacions->Students->find('All')
        ->where(['section_id' => $materia->section_id, 'student_condition' => 'Regular', 'balance' => '2021'])
        ->order(['surname' => 'ASC', 'first_name' => 'ASC', 'type_of_identification' => 'ASC', 'identity_card' => 'ASC']);
       
        $calificaciones = $this->Calificacions->find('All')
        ->contain(['Objetivos', 'Students'])
        ->where(['Calificacions.registro_eliminado' => false, 'Objetivos.lapso_id' => $lapsoBuscar, 'Objetivos.materia_id' => $materiaBuscar])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC', 'Objetivos.objetivo' => 'ASC']);

        $literalesMateria = $this->LiteralMaterias->find('All')
        ->contain(['Students'])
        ->where(['LiteralMaterias.registro_eliminado' => false, 'LiteralMaterias.lapso_id' => $lapsoBuscar, 'LiteralMaterias.materia_id' => $materiaBuscar])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC']);

        $literalesLapso = $this->LiteralLapsos->find('All')
        ->contain(['Students'])
        ->where(['LiteralLapsos.registro_eliminado' => false, 'LiteralLapsos.lapso_id' => $lapsoBuscar])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC']);

        $opcionesUsuario = $this->OpcionesUsuarios->find('All', ['limit' => 3])
        ->contain(['Users', 'Lapsos', 'Materias'])
        ->where(['OpcionesUsuarios.registro_eliminado' => false, 'OpcionesUsuarios.user_id' => $this->Auth->user('id'), 'OpcionesUsuarios.lapso_id' => $lapsoBuscar, 'OpcionesUsuarios.materia_id' => $materiaBuscar, 'OpcionesUsuarios.tipo_opcion' => "Rasgos de personalidad"])
        ->order(['OpcionesUsuarios.id' => 'ASC']);

        $rasgosPersonalidad = $this->RasgosPersonalidads->find('All')
        ->contain(['Lapsos', 'Materias', 'Students', 'OpcionesUsuarios'])
        ->where(['RasgosPersonalidads.registro_eliminado' => false, 'RasgosPersonalidads.lapso_id' => $lapsoBuscar, 'RasgosPersonalidads.materia_id' => $materiaBuscar, 'OpcionesUsuarios.tipo_opcion' => 'Rasgos de personalidad'])
        ->order(['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.type_of_identification' => 'ASC', 'Students.identity_card' => 'ASC', 'OpcionesUsuarios.id' => 'ASC']);

        $this->set(compact('calificaciones', 'materias', 'lapsos', 'lapsoBuscar', 'materiaBuscar', 'literalesMateria', 'literalesLapso', 'opcionesUsuario', 'rasgosPersonalidad'));
        $this->set('estudiantes', $this->paginate($estudiantes, ['limit' => 50]));    
    }

    /**
     * View method
     *
     * @param string|null $id Calificacion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $calificacion = $this->Calificacions->get($id, [
            'contain' => ['Objetivos', 'Students']
        ]);

        $this->set('calificacion', $calificacion);
        $this->set('_serialize', ['calificacion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $calificacion = $this->Calificacions->newEntity();
        if ($this->request->is('post')) {
            $calificacion = $this->Calificacions->patchEntity($calificacion, $this->request->data);
            if ($this->Calificacions->save($calificacion)) {
                $this->Flash->success(__('The calificacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The calificacion could not be saved. Please, try again.'));
            }
        }
        $objetivos = $this->Calificacions->Objetivos->find('list', ['limit' => 200]);
        $students = $this->Calificacions->Students->find('list', ['limit' => 200])->where(['id >' => 1, 'student_condition' => 'Regular', 'balance' => 2021])->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);
        $this->set(compact('calificacion', 'objetivos', 'students'));
        $this->set('_serialize', ['calificacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Calificacion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $calificacion = $this->Calificacions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $calificacion = $this->Calificacions->patchEntity($calificacion, $this->request->data);
            if ($this->Calificacions->save($calificacion)) {
                $this->Flash->success(__('The calificacion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The calificacion could not be saved. Please, try again.'));
            }
        }
        $objetivos = $this->Calificacions->Objetivos->find('list', ['limit' => 200]);
        $students = $this->Calificacions->Students->find('list', ['limit' => 200])->where(['id >' => 1, 'student_condition' => 'Regular', 'balance' => 2021])->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);
        $this->set(compact('calificacion', 'objetivos', 'students'));
        $this->set('_serialize', ['calificacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Calificacion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calificacion = $this->Calificacions->get($id);
        $calificacion->registro_eliminado = 1;
        if ($this->Calificacions->save($calificacion)) {
            $this->Flash->success(__('La calificación fue eliminada'));
        } else {
            $this->Flash->error(__('La calificación no pudo ser eliminada'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function registrarCalificaciones($idEstudiante = null, $idMateria = null, $idLapso = null)
    {  
        $this->loadModel('Profesors');
        $this->loadModel('Students');
        $this->loadModel('Sections');
        $this->loadModel('Materias');
        $this->loadModel('Lapsos');
        $this->loadModel('Objetivos');

        $parametrosCargaCalificaciones = new ParametrosCargaCalificacionsController();

        $parametrosCargaCalificaciones->actualizarParametrosCargaCalificaciones($idLapso, $idMateria, $idEstudiante);

        $estudiante = $this->Students->get($idEstudiante);
        $materia = $this->Materias->get($idMateria);
        $seccion = $this->Sections->get($materia->section_id);
        $lapso = $this->Lapsos->get($idLapso);

        if ($this->request->is('post')) 
        {
            $idEstudiante = $_POST['id_estudiante'];
            $idMateria = $_POST['id_materia'];
            $idLapso = $_POST['id_lapso'];

            $calificaciones = $this->Calificacions->find('All')
            ->contain(['Objetivos', 'Students'])
            ->where(['Calificacions.registro_eliminado' => false, 'Calificacions.student_id' => $idEstudiante, 'Objetivos.lapso_id' => $idLapso, 'Objetivos.materia_id' => $idMateria])
            ->order(['Objetivos.objetivo' => 'ASC']);

            foreach ($calificaciones as $calificacion):
                $nota = $this->Calificacions->get($calificacion->id);
                $nota->puntaje = $_POST['nota_' . $calificacion->id];
                $nota->puntaje_112 = $_POST['nota112_' . $calificacion->id];
                if (!($this->Calificacions->save($nota))): 
                    $this->Flash->error(__('La calificación no pudo ser actualizada'));
                endif;
            endforeach;
            return $this->redirect(['action' => 'index']);
        }

        $calificaciones = $this->Calificacions->find('All')
        ->contain(['Objetivos', 'Students'])
        ->where(['Calificacions.registro_eliminado' => false, 'Calificacions.student_id' => $idEstudiante, 'Objetivos.lapso_id' => $idLapso, 'Objetivos.materia_id' => $idMateria])
        ->order(['Objetivos.objetivo' => 'ASC']);

        if ($calificaciones->count() == 0):
            if ($this->Auth->user('role') == 'Profesor' || $this->Auth->user('role') == 'Profesor guía'):
                $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
                $objetivosProfesor = $this->Objetivos->find('all')
                    ->where(['profesor_id' => $profesor->id, 'materia_id' => $idMateria, 'lapso_id' => $idLapso]);
                if ($objetivosProfesor->count() > 0):
                    foreach ($objetivosProfesor as $objetivo):
                        $calificacion = $this->Calificacions->newEntity();
                        $calificacion->objetivo_id = $objetivo->id;
                        $calificacion->student_id = $idEstudiante;
                        $calificacion->puntaje = 0;
                        $calificacion->puntaje_112 = 0;
                        $calificacion->observacion = '';
                        if (!($this->Calificacions->save($calificacion))): 
                            $this->Flash->error(__('La calificación no pudo ser creada'));
                        endif;
                    endforeach;
                endif;

                $calificaciones = $this->Calificacions->find('All')
                ->contain(['Objetivos', 'Students'])
                ->where(['Calificacions.registro_eliminado' => false, 'Calificacions.student_id' => $idEstudiante, 'Objetivos.lapso_id' => $idLapso, 'Objetivos.materia_id' => $idMateria])
                ->order(['Objetivos.objetivo' => 'ASC']);
            endif;
        endif;
      
        $this->set(compact('idEstudiante', 'idMateria', 'idLapso', 'calificaciones', 'estudiante', 'materia', 'seccion', 'lapso'));
    }
}