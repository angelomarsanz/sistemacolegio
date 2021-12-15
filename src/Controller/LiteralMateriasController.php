<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LiteralMaterias Controller
 *
 * @property \App\Model\Table\LiteralMateriasTable $LiteralMaterias
 */
class LiteralMateriasController extends AppController
{
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'apreciacionLiteralMateria']))
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
            'contain' => ['Lapsos', 'Materias', 'Students']
        ];
        $literalMaterias = $this->paginate($this->LiteralMaterias);

        $this->set(compact('literalMaterias'));
        $this->set('_serialize', ['literalMaterias']);
    }

    /**
     * View method
     *
     * @param string|null $id Literal Materia id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $literalMateria = $this->LiteralMaterias->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Students']
        ]);

        $this->set('literalMateria', $literalMateria);
        $this->set('_serialize', ['literalMateria']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $literalMateria = $this->LiteralMaterias->newEntity();
        if ($this->request->is('post')) {
            $literalMateria = $this->LiteralMaterias->patchEntity($literalMateria, $this->request->data);
            if ($this->LiteralMaterias->save($literalMateria)) {
                $this->Flash->success(__('La calificación fue agregada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo agregar la calificación'));
            }
        }
        $lapsos = $this->LiteralMaterias->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->LiteralMaterias->Materias->find('list', ['limit' => 200]);
        $students = $this->LiteralMaterias->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalMateria', 'lapsos', 'materias', 'students'));
        $this->set('_serialize', ['literalMateria']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Literal Materia id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $tipo = null, $controlador = null, $accion = null)
    {
        $literalMateria = $this->LiteralMaterias->get($id, [
            'contain' => []
        ]);
      
        if ($this->request->is(['patch', 'post', 'put'])) {
            $literalMateria = $this->LiteralMaterias->patchEntity($literalMateria, $this->request->data);
            if ($this->LiteralMaterias->save($literalMateria)) {
                $this->Flash->success(__('La calificación fue actualizada'));

                return $this->redirect(['controller' => $controlador, 'action' => $accion]);
            } else {
                $this->Flash->error(__('No se pudo actualizar la calificación'));
            }
        }
        $lapsos = $this->LiteralMaterias->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->LiteralMaterias->Materias->find('list', ['limit' => 200]);
        $students = $this->LiteralMaterias->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalMateria', 'tipo', 'lapsos', 'materias', 'students'));
        $this->set('_serialize', ['literalMateria']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Literal Materia id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $literalMateria = $this->LiteralMaterias->get($id);
        $literalMateria->registro_eliminado = 1;
        if ($this->LiteralMaterias->save($literalMateria)) {
            $this->Flash->success(__('La calificación fue eliminada'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la calificación'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function apreciacionLiteralMateria($tipo = null, $idLapso = null, $idMateria = null, $idEstudiante = null)
    {
        $literalMateria = $this->LiteralMaterias->find('All')
        ->where(['LiteralMaterias.registro_eliminado' => false, 'LiteralMaterias.lapso_id' => $idLapso, 'LiteralMaterias.materia_id' => $idMateria, 'LiteralMaterias.student_id' => $idEstudiante])->first();

        if (!($literalMateria)):
            if (substr($this->Auth->user('role'), 0, 8) == 'Profesor'):
                $literalMateria = $this->LiteralMaterias->newEntity();
                $literalMateria->lapso_id = $idLapso;
                $literalMateria->materia_id = $idMateria;
                $literalMateria->student_id = $idEstudiante;
                $literalMateria->calificacion_descriptiva = '***';
                $literalMateria->literal = '***';
                $literalMateria->numero = 0;
                if ($this->LiteralMaterias->save($literalMateria)):
                    $literalMateria = $this->LiteralMaterias->find('All')
                    ->where(['LiteralMaterias.registro_eliminado' => false, 'LiteralMaterias.lapso_id' => $idLapso, 'LiteralMaterias.materia_id' => $idMateria, 'LiteralMaterias.student_id' => $idEstudiante])->first();
                else:
                    $this->Flash->error(__('No se pudo agregar la calificación'));
                endif;
            endif;
        endif;

        return $this->redirect(['controller' => 'LiteralMaterias', 'action' => 'edit', $literalMateria->id, $tipo, 'Calificacions', 'index']);
    }
}
