<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Objetivos Controller
 *
 * @property \App\Model\Table\ObjetivosTable $Objetivos
 */
class ObjetivosController extends AppController
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
        $this->loadModel('Profesors');
        $this->crearObjetivos();

        $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        $objetivos = $this->Objetivos->find('All')
            ->contain(['Lapsos', 'Materias', 'Profesors'])
            ->where(['Objetivos.profesor_id' => $profesor->id, 'Lapsos.periodo_escolar' => '2021-2022', 'Objetivos.registro_eliminado' => false])
            ->order(['Materias.nombre_materia' => 'ASC', 'Materias.grado_materia' => 'ASC', 'Profesors.primer_apellido' => 'ASC', 'Profesors.primer_nombre' => 'ASC', 'Lapsos.numero_lapso' => 'ASC', 'Objetivos.objetivo' => 'ASC']);

        $this->set('objetivos', $this->paginate($objetivos));
    }

    /**
     * View method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $objetivo = $this->Objetivos->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Profesors', 'Calificacions' => ['Students']]
        ]);

        $this->set('objetivo', $objetivo);
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $objetivo = $this->Objetivos->newEntity();
        if ($this->request->is('post')) 
        {
            $objetivo = $this->Objetivos->patchEntity($objetivo, $this->request->data);

            $materia = $this->Objetivos->Materias->get($objetivo->materia_id, [
                'contain' => []
            ]);

            $objetivo->section_id = $materia->section_id;

            $objetivos = $this->Objetivos->find('All')
            ->where(['Objetivos.registro_eliminado' => false, 'Objetivos.lapso_id' => $objetivo->lapso_id, 'Objetivos.materia_id' => $objetivo->materia_id, 'Objetivos.section_id' => $objetivo->section_id, 'Objetivos.profesor_id' => $objetivo->profesor_id, 'Objetivos.objetivo' => $objetivo->objetivo])->first();

            if ($objetivos)
            {
                $this->Flash->error(__('Objetivo duplicado'));
            }
            else
            {
                if ($this->Objetivos->save($objetivo)) 
                {
                    $this->Flash->success(__('El objetivo fue registrado'));
    
                    return $this->redirect(['action' => 'index']);
                } 
                else 
                {
                    $this->Flash->error(__('No se pudo registrar el objetivo'));
                }
    
            }
        }

        $this->loadModel('MateriasProfesors');

        $idProfesor = 0;

        if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
        {
            $profesor = $this->Objetivos->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $idProfesor = $profesor->id;
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);
            $vectorMaterias = [];
            
            if ($materiasProfesor)
            {
                foreach ($materiasProfesor as $materias)
                {
                    $vectorMaterias[] = $materias->materia_id;
                }
            }

            $materias = $this->Objetivos->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias])->order(['Materias.nombre_materia' => 'asc', 'Materias.grado_materia' => 'asc']);
        }
        else
        {
            $materias = $this->Objetivos->Materias->find('list', ['limit' => 200])->order(['Materias.nombre_materia' => 'asc', 'Materias.grado_materia' => 'asc']);
        }

        $lapsos = $this->Objetivos->Lapsos->find('list', ['limit' => 200]);
        $secciones = $this->Objetivos->Sections->find('list', ['limit' => 200])->where(['level !=' => 'Pre-escolar', 'section' => 'A']);
        $profesors = $this->Objetivos->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('objetivo', 'lapsos', 'materias', 'secciones', 'profesors', 'idProfesor'));
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $objetivo = $this->Objetivos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $objetivo = $this->Objetivos->patchEntity($objetivo, $this->request->data);

            $materia = $this->Objetivos->Materias->get($objetivo->materia_id, [
                'contain' => []
            ]);

            $objetivo->section_id = $materia->section_id;

            $objetivos = $this->Objetivos->find('All')
            ->where(['Objetivos.registro_eliminado' => false, 'Objetivos.id !=' => $id, 'Objetivos.lapso_id' => $objetivo->lapso_id, 'Objetivos.materia_id' => $objetivo->materia_id, 'Objetivos.section_id' => $objetivo->section_id, 'Objetivos.profesor_id' => $objetivo->profesor_id, 'Objetivos.objetivo' => $objetivo->objetivo])->first();

            if ($objetivos)
            {
                $this->Flash->error(__('Objetivo duplicado'));
            }
            else
            {
                if ($this->Objetivos->save($objetivo)) 
                {
                    $this->Flash->success(__('El objetivo fue actualizado'));

                    return $this->redirect(['action' => 'index']);
                }
                else 
                {
                    $this->Flash->error(__('No se pudo actualizar el objetivo'));
                }
            }
        }

        $this->loadModel('MateriasProfesors');
        $idProfesor = 0;

        if (substr($this->Auth->user('role'), 0, 8) == 'Profesor')
        {
            $profesor = $this->Objetivos->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $idProfesor = $profesor->id;
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);
            $vectorMaterias = [];
            
            if ($materiasProfesor)
            {
                foreach ($materiasProfesor as $materias)
                {
                    $vectorMaterias[] = $materias->materia_id;
                }
            }

            $materias = $this->Objetivos->Materias->find('list', ['limit' => 200])->where(['id IN' => $vectorMaterias])->order(['Materias.nombre_materia' => 'asc', 'Materias.grado_materia' => 'asc']);
        }
        else
        {
            $materias = $this->Objetivos->Materias->find('list', ['limit' => 200])->order(['Materias.nombre_materia' => 'asc', 'Materias.grado_materia' => 'asc']);
        }

        $lapsos = $this->Objetivos->Lapsos->find('list', ['limit' => 200]);
        $secciones = $this->Objetivos->Sections->find('list', ['limit' => 200])->where(['level !=' => 'Pre-escolar', 'section' => 'A']);
        $profesors = $this->Objetivos->Profesors->find('list', ['limit' => 200]);
        $this->set(compact('objetivo', 'lapsos', 'materias', 'secciones', 'profesors', 'idProfesor'));
        $this->set('_serialize', ['objetivo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Objetivo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $objetivo = $this->Objetivos->get($id);
        $objetivo->registro_eliminado = 1;
        if ($this->Objetivos->save($objetivo)) {
            $this->Flash->success(__('El objetivo fue eliminado'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el objetivo'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function crearObjetivos()
    {
        $this->loadModel('Lapsos');
        $this->loadModel('Materias');
        $this->loadModel('Profesors');
        $this->loadModel('MateriasProfesors');

        $tieneObjetivos = 0;
        $objetivosBachillerato =
            [
                '1',
                '2',
                '3',
                '4',
                '5',
                'Prueba de lapso'
            ];

        $lapsosAnoActual = $this->Lapsos->find('all')->where(['periodo_escolar' => '2021-2022']);

        if ($this->Auth->user('role') == 'Profesor' || $this->Auth->user('role') == 'Profesor guía'):
            $profesor = $this->Profesors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $materiasProfesor = $this->MateriasProfesors->find('all')->where(['profesor_id' => $profesor->id]);
            $objetivosProfesor = $this->Objetivos->find('all')->where(['profesor_id' => $profesor->id]);

            if ($objetivosProfesor->count() > 0):
                $tieneObjetivos = 1;
            endif;

            if ($materiasProfesor->count() > 0):
                foreach ($materiasProfesor as $materias):
                    $materiaActual = $this->Materias->get($materias->materia_id);
                    if ($tieneObjetivos == 0):
                        foreach ($lapsosAnoActual as $lapsoActual):
                            foreach ($objetivosBachillerato as $bachillerato):
                                $nuevoObjetivo = $this->Objetivos->newEntity();
                                $nuevoObjetivo->lapso_id = $lapsoActual->id; 
                                $nuevoObjetivo->materia_id = $materiaActual->id;
                                $nuevoObjetivo->section_id = $materiaActual->section_id;
                                $nuevoObjetivo->profesor_id = $profesor->id;
                                $nuevoObjetivo->objetivo = $bachillerato;           
                                if (!($this->Objetivos->save($nuevoObjetivo))): 
                                    $this->Flash->error(__('No se pudo crear el objetivo'));
                                endif;
                            endforeach;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endif;
    }
}