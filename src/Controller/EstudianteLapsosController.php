<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EstudianteLapsos Controller
 *
 * @property \App\Model\Table\EstudianteLapsosTable $EstudianteLapsos
 */
class EstudianteLapsosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students', 'Lapsos', 'Materias']
        ];
        $estudianteLapsos = $this->paginate($this->EstudianteLapsos);

        $this->set(compact('estudianteLapsos'));
        $this->set('_serialize', ['estudianteLapsos']);
    }

    /**
     * View method
     *
     * @param string|null $id Estudiante Lapso id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estudianteLapso = $this->EstudianteLapsos->get($id, [
            'contain' => ['Students', 'Lapsos', 'Materias']
        ]);

        $this->set('estudianteLapso', $estudianteLapso);
        $this->set('_serialize', ['estudianteLapso']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estudianteLapso = $this->EstudianteLapsos->newEntity();
        if ($this->request->is('post')) {
            $estudianteLapso = $this->EstudianteLapsos->patchEntity($estudianteLapso, $this->request->data);
            if ($this->EstudianteLapsos->save($estudianteLapso)) {
                $this->Flash->success(__('The estudiante lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The estudiante lapso could not be saved. Please, try again.'));
            }
        }
        $students = $this->EstudianteLapsos->Students->find('list', ['limit' => 200]);
        $lapsos = $this->EstudianteLapsos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->EstudianteLapsos->Materias->find('list', ['limit' => 200]);
        $this->set(compact('estudianteLapso', 'students', 'lapsos', 'materias'));
        $this->set('_serialize', ['estudianteLapso']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estudiante Lapso id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estudianteLapso = $this->EstudianteLapsos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estudianteLapso = $this->EstudianteLapsos->patchEntity($estudianteLapso, $this->request->data);
            if ($this->EstudianteLapsos->save($estudianteLapso)) {
                $this->Flash->success(__('The estudiante lapso has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The estudiante lapso could not be saved. Please, try again.'));
            }
        }
        $students = $this->EstudianteLapsos->Students->find('list', ['limit' => 200]);
        $lapsos = $this->EstudianteLapsos->Lapsos->find('list', ['limit' => 200]);
        $materias = $this->EstudianteLapsos->Materias->find('list', ['limit' => 200]);
        $this->set(compact('estudianteLapso', 'students', 'lapsos', 'materias'));
        $this->set('_serialize', ['estudianteLapso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Estudiante Lapso id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estudianteLapso = $this->EstudianteLapsos->get($id);
        if ($this->EstudianteLapsos->delete($estudianteLapso)) {
            $this->Flash->success(__('The estudiante lapso has been deleted.'));
        } else {
            $this->Flash->error(__('The estudiante lapso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
