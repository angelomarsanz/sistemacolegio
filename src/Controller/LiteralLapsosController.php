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
                $this->Flash->success(__('The literal lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal lapso could not be saved. Please, try again.'));
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
    public function edit($id = null)
    {
        $literalLapso = $this->LiteralLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $literalLapso = $this->LiteralLapsos->patchEntity($literalLapso, $this->request->data);
            if ($this->LiteralLapsos->save($literalLapso)) {
                $this->Flash->success(__('The literal lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal lapso could not be saved. Please, try again.'));
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
        if ($this->LiteralLapsos->delete($literalLapso)) {
            $this->Flash->success(__('The literal lapso has been deleted.'));
        } else {
            $this->Flash->error(__('The literal lapso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
