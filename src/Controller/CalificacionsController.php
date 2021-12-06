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
			if ($user['role'] === 'Profesor')
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
        $this->loadModel('ParametrosCargaCalificacions');

        if ($this->Auth->user('role') == 'Profesor')
        {
            $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);
            $vectorMaterias = [];
            
            if ($materiasProfesor)
            {
                foreach ($materiasProfesor as $materias)
                {
                    $vectorMaterias[] = $materias->materia_id;
                }
            }

            $materias = $this->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias]);
        }
        else
        {
            $materias = $this->Materias->find('list', ['limit' => 200]);
        }

        $materiaBuscar = 0;

        $parametrosCargaCalificaciones = $this->ParametrosCargaCalificacions->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if ($parametrosCargaCalificaciones)
        {
            $materiaBuscar = $parametrosCargaCalificaciones->materia_id;
        }
        else
        {
            if ($this->Auth->user('role') == 'Profesor')
            {
                if ($materiasProfesor)
                {
                    $primeraMateria = $materiasProfesor->first();
                    $materiaBuscar = $primeraMateria->materia_id;        
                }
                else
                {
                    $materiaBuscar = 1;
                }
        }

        $this->paginate = [
            'order' => ['Students.surname' => 'ASC', 'Students.first_name' => 'ASC', 'Objetivos.objetivo' => 'ASC'],
            'contain' => ['Objetivos' => 'Materias', 'Students'],
            'where' => ['Objetivos.materia_id' => $materiaBuscar]
        ];
    
        $calificacions = $this->paginate($this->Calificacions);
     
        $this->set(compact('calificacions', 'materias'));
        $this->set('_serialize', ['calificacions']);
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
        $students = $this->Calificacions->Students->find('list', ['limit' => 200])->where(['id >' => 1, 'student_condition' => 'Regular'])->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);
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
        $students = $this->Calificacions->Students->find('list', ['limit' => 200]);
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
        if ($this->Calificacions->delete($calificacion)) {
            $this->Flash->success(__('The calificacion has been deleted.'));
        } else {
            $this->Flash->error(__('The calificacion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
