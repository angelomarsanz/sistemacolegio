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
                $this->Flash->success(__('The literal materia has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal materia could not be saved. Please, try again.'));
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
    public function edit($id = null)
    {
        $literalMateria = $this->LiteralMaterias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $literalMateria = $this->LiteralMaterias->patchEntity($literalMateria, $this->request->data);
            if ($this->LiteralMaterias->save($literalMateria)) {
                $this->Flash->success(__('The literal materia has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal materia could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->LiteralMaterias->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->LiteralMaterias->Materias->find('list', ['limit' => 200]);
        $students = $this->LiteralMaterias->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalMateria', 'lapsos', 'materias', 'students'));
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
        if ($this->LiteralMaterias->delete($literalMateria)) {
            $this->Flash->success(__('The literal materia has been deleted.'));
        } else {
            $this->Flash->error(__('The literal materia could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
