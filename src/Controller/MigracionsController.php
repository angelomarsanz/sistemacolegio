<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Migracions Controller
 *
 * @property \App\Model\Table\MigracionsTable $Migracions
 */
class MigracionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $migracions = $this->paginate($this->Migracions);

        $this->set(compact('migracions'));
        $this->set('_serialize', ['migracions']);
    }

    /**
     * View method
     *
     * @param string|null $id Migracion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $migracion = $this->Migracions->get($id, [
            'contain' => []
        ]);

        $this->set('migracion', $migracion);
        $this->set('_serialize', ['migracion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $migracion = $this->Migracions->newEntity();
        if ($this->request->is('post')) {
            $migracion = $this->Migracions->patchEntity($migracion, $this->request->data);
            if ($this->Migracions->save($migracion)) {
                $this->Flash->success(__('The migracion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The migracion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('migracion'));
        $this->set('_serialize', ['migracion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Migracion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $migracion = $this->Migracions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $migracion = $this->Migracions->patchEntity($migracion, $this->request->data);
            if ($this->Migracions->save($migracion)) {
                $this->Flash->success(__('The migracion has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The migracion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('migracion'));
        $this->set('_serialize', ['migracion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Migracion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $migracion = $this->Migracions->get($id);
        if ($this->Migracions->delete($migracion)) {
            $this->Flash->success(__('The migracion has been deleted.'));
        } else {
            $this->Flash->error(__('The migracion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function migracionActualizarRepresentantes()
    {
        $this->loadModel('Parentsandguardians');

        $migraciones = $this->Migracions->find('all')->where(['id >' => 1]);

        $representantes = $this->Parentsandguardians->find('all')->where(['id >' => 1]);

        foreach ($migraciones as $migracion):
            $nacionalidad = $migracion->campo_2;
            $numeroIdentificacion = $migracion->campo_1;
            foreach ($representantes as $representante):
                if ($representante->type_of_identification == $nacionalidad && $representante->identidy_card):
                    $representanteGet = $this->Parentsandguardians->get($representante->id);
                    $representanteGet->second_name = $migracion->campo_4;
                    $representanteGet->second_surname = $migracion->campo_6;
                    $representanteGet->wworkplace = $migracion->campo_7;
                    $representanteGet->address = $migracion->campo_8;
                    $representanteGet->work_phone = $migracion->campo_9;
                    $representanteGet->workplace = $migracion->campo_10;
                    $representanteGet->landline = $migracion->campo_11;
                    $representanteGet->identidy_card_father = $migracion->campo_12;
                    $representanteGet->type_of_identification_father = $migracion->campo_13;
                    $nombrePadre = explode(" ", $migracion->campo_14);

                    $cantidadElementos = count($nombrePadre);

                    switch ($cantidadElementos) 
                    {
                        case 1:
                            $representanteGet->first_name_father = $nombrePadre[0];
                            break;
                        case 2:
                            $representanteGet->first_name_father = $nombrePadre[0];
                            $representanteGet->surname_father = $nombrePadre[1];
                            break;
                        case 3:
                            $representanteGet->first_name_father = $nombrePadre[0];
                            $representanteGet->second_name_father = $nombrePadre[1];
                            $representanteGet->surname_father = $nombrePadre[2];
                            break;
                        case 4:
                            $representanteGet->first_name_father = $nombrePadre[0];
                            $representanteGet->second_name_father = $nombrePadre[1];
                            $representanteGet->surname_father = $nombrePadre[2];
                            $representanteGet->second_surname_father = $nombrePadre[3];
                            break;
                    }

                    $representanteGet-> = $migracion->campo_15;
                    $representanteGet-> = $migracion->campo_16;
                    $representanteGet-> = $migracion->campo_17;
                    $representanteGet-> = $migracion->campo_18;
                    $representanteGet-> = $migracion->campo_19;
                    $representanteGet-> = $migracion->campo_20;
                    $representanteGet-> = $migracion->campo_21;
                    $representanteGet-> = $migracion->campo_22;
                    $representanteGet-> = $migracion->campo_23;
                    $representanteGet-> = $migracion->campo_24;
                    $representanteGet-> = $migracion->campo_25;
                    $representanteGet-> = $migracion->campo_26;
                    $representanteGet-> = $migracion->campo_27;
                    $representanteGet-> = $migracion->campo_28;
                    $representanteGet-> = $migracion->campo_29;
                    $representanteGet-> = $migracion->campo_30;
                    $representanteGet-> = $migracion->campo_31;
                    $representanteGet-> = $migracion->campo_32;
                    $representanteGet-> = $migracion->campo_33;
                    $representanteGet-> = $migracion->campo_34;
                    $representanteGet-> = $migracion->campo_35;
                    $representanteGet-> = $migracion->campo_36;
                    if (!($this->Parentsandguardians->save($representanteGet))): 
                        $this->Flash->error(__('El representante con el id ' . $representante->id . ' no pudo ser actualizado'));
                    endif;    
                endif;
            endforeach;
        endforeach;
    }
}
