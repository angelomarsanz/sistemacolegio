<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PruebaLapsos Controller
 *
 * @property \App\Model\Table\PruebaLapsosTable $PruebaLapsos
 */
class PruebaLapsosController extends AppController
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
        $pruebaLapsos = $this->paginate($this->PruebaLapsos);

        $this->set(compact('pruebaLapsos'));
        $this->set('_serialize', ['pruebaLapsos']);
    }

    /**
     * View method
     *
     * @param string|null $id Prueba Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pruebaLapso = $this->PruebaLapsos->get($id, [
            'contain' => ['Lapsos', 'Materias', 'Students']
        ]);

        $this->set('pruebaLapso', $pruebaLapso);
        $this->set('_serialize', ['pruebaLapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pruebaLapso = $this->PruebaLapsos->newEntity();
        if ($this->request->is('post')) {
            $pruebaLapso = $this->PruebaLapsos->patchEntity($pruebaLapso, $this->request->data);
            if ($this->PruebaLapsos->save($pruebaLapso)) {
                $this->Flash->success(__('The prueba lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The prueba lapso could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->PruebaLapsos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->PruebaLapsos->Materias->find('list', ['limit' => 200]);
        $students = $this->PruebaLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('pruebaLapso', 'lapsos', 'materias', 'students'));
        $this->set('_serialize', ['pruebaLapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Prueba Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pruebaLapso = $this->PruebaLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pruebaLapso = $this->PruebaLapsos->patchEntity($pruebaLapso, $this->request->data);
            if ($this->PruebaLapsos->save($pruebaLapso)) {
                $this->Flash->success(__('The prueba lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The prueba lapso could not be saved. Please, try again.'));
            }
        }
        $lapsos = $this->PruebaLapsos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->PruebaLapsos->Materias->find('list', ['limit' => 200]);
        $students = $this->PruebaLapsos->Students->find('list', ['limit' => 200]);
        $this->set(compact('pruebaLapso', 'lapsos', 'materias', 'students'));
        $this->set('_serialize', ['pruebaLapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prueba Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pruebaLapso = $this->PruebaLapsos->get($id);
        if ($this->PruebaLapsos->delete($pruebaLapso)) {
            $this->Flash->success(__('The prueba lapso has been deleted.'));
        } else {
            $this->Flash->error(__('The prueba lapso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
