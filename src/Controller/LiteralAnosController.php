<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LiteralAnos Controller
 *
 * @property \App\Model\Table\LiteralAnosTable $LiteralAnos
 */
class LiteralAnosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students']
        ];
        $literalAnos = $this->paginate($this->LiteralAnos);

        $this->set(compact('literalAnos'));
        $this->set('_serialize', ['literalAnos']);
    }

    /**
     * View method
     *
     * @param string|null $id Literal Ano id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $literalAno = $this->LiteralAnos->get($id, [
            'contain' => ['Students']
        ]);

        $this->set('literalAno', $literalAno);
        $this->set('_serialize', ['literalAno']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $literalAno = $this->LiteralAnos->newEntity();
        if ($this->request->is('post')) {
            $literalAno = $this->LiteralAnos->patchEntity($literalAno, $this->request->data);
            if ($this->LiteralAnos->save($literalAno)) {
                $this->Flash->success(__('The literal ano has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal ano could not be saved. Please, try again.'));
            }
        }
        $students = $this->LiteralAnos->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalAno', 'students'));
        $this->set('_serialize', ['literalAno']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Literal Ano id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $literalAno = $this->LiteralAnos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $literalAno = $this->LiteralAnos->patchEntity($literalAno, $this->request->data);
            if ($this->LiteralAnos->save($literalAno)) {
                $this->Flash->success(__('The literal ano has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The literal ano could not be saved. Please, try again.'));
            }
        }
        $students = $this->LiteralAnos->Students->find('list', ['limit' => 200]);
        $this->set(compact('literalAno', 'students'));
        $this->set('_serialize', ['literalAno']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Literal Ano id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $literalAno = $this->LiteralAnos->get($id);
        if ($this->LiteralAnos->delete($literalAno)) {
            $this->Flash->success(__('The literal ano has been deleted.'));
        } else {
            $this->Flash->error(__('The literal ano could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
