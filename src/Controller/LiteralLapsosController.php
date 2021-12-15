<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LiteralLapsos Controller
 *
 * @property \App\Model\Table\LiteralLapsosTable $LiteralLapsos
 */
class LiteralLapsosController extends AppController
{
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if (substr($user['role'], 0, 8) === 'Profesor')
			{
				if(in_array($this->request->action, ['index', 'view', 'add', 'edit', 'delete', 'apreciacionLiteralLapso']))
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
            'contain' => ['Lapsos', 'Students']
        ];
        $literalLapsos = $this->paginate($this->LiteralLapsos);

        $this->set(compact('literalLapsos'));
        $this->set('_serialize', ['literalLapsos']);
    }

    /**
     * View method
     *
     * @param string|null $id Literal Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $literalLapso = $this->LiteralLapsos->get($id, [
            'contain' => ['Lapsos', 'Students']
        ]);

        $this->set('literalLapso', $literalLapso);
        $this->set('_serialize', ['literalLapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $literalLapso = $this->LiteralLapsos->newEntity();
        if ($this->request->is('post')) {
            $literalLapso = $this->LiteralLapsos->patchEntity($literalLapso, $this->request->data);
            if ($this->LiteralLapsos->save($literalLapso)) {
                $this->Flash->success(__('La calificación fue agregada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo agregar la calificación'));
            }
        }
        $lapsos = $this->LiteralLapsos->Lapsos->find('list', ['limit' => 200]);
        $students = $this->LiteralLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalLapso', 'lapsos', 'students'));
        $this->set('_serialize', ['literalLapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Literal Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $controlador = null, $accion = null)
    {
        $literalLapso = $this->LiteralLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $literalLapso = $this->LiteralLapsos->patchEntity($literalLapso, $this->request->data);
            if ($this->LiteralLapsos->save($literalLapso)) {
                $this->Flash->success(__('La calificación fue actualizada'));

                return $this->redirect(['controller' => $controlador, 'action' => $accion]);
            } else {
                $this->Flash->error(__('La calificación no pudo ser actualizada'));
            }
        }
        $lapsos = $this->LiteralLapsos->Lapsos->find('list', ['limit' => 200]);
        $students = $this->LiteralLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalLapso', 'lapsos', 'students'));
        $this->set('_serialize', ['literalLapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Literal Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $literalLapso = $this->LiteralLapsos->get($id);
        $literalLapso->registro_eliminado = 1;
        if ($this->LiteralLapsos->save($literalLapso)) {
            $this->Flash->success(__('La calificación fue eliminada'));
        } else {
            $this->Flash->error(__('No se pudo eliminar la calificación'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function apreciacionLiteralLapso($tipo = null, $idLapso = null, $idMateria = null, $idEstudiante = null)
    {
        $literalLapso = $this->LiteralLapsos->find('All')
        ->where(['LiteralLapsos.registro_eliminado' => false, 'LiteralLapsos.lapso_id' => $idLapso, 'LiteralLapsos.student_id' => $idEstudiante])->first();

        if (!($literalLapso)):
            if (substr($this->Auth->user('role'), 0, 8) == 'Profesor'):
                $literalLapso = $this->LiteralLapsos->newEntity();
                $literalLapso->lapso_id = $idLapso;
                $literalLapso->student_id = $idEstudiante;
                $literalLapso->calificacion_descriptiva = '***';
                $literalLapso->literal = '***';
                if ($this->LiteralLapsos->save($literalLapso)):
                    $literalLapso = $this->LiteralLapsos->find('All')
                    ->where(['LiteralLapsos.registro_eliminado' => false, 'LiteralLapsos.lapso_id' => $idLapso, 'LiteralLapsos.student_id' => $idEstudiante])->first();
                else:
                    $this->Flash->error(__('No se pudo agregar el literal'));
                endif;
            endif;
        endif;
        return $this->redirect(['controller' => 'LiteralLapsos', 'action' => 'edit', $literalLapso->id, 'Calificacions', 'index']);
    }
}