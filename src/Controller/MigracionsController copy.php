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
    public function migracionActualizacionRepresentantes()
    {
        $contadorMigracion = 0;
        $representantesActualizados = [];
        $representantesNoActualizados = [];

        $this->loadModel('Parentsandguardians');

        $migraciones = $this->Migracions->find('all')->where(['id >' => 1])->order(['campo_2' => 'ASC', 'campo_1' => 'ASC']);

        $representantes = $this->Parentsandguardians->find('all')->where(['id >' => 1]);

        $representanteAnterior = '';
        $representanteActual = '';
        $contadorRegistros = 0;

        foreach ($migraciones as $migracion):
            if ($contadorRegistros == 0):
                $representanteActual = $migracion->campo_2.$migracion->campo_1;
            else:
                $representanteAnterior = $representanteActual;
                $representanteActual = $migracion->campo_2.$migracion->campo_1;
            endif;
            $contadorRegistros++;
            if ($representanteAnterior != $representanteActual): 
                $nacionalidad = $migracion->campo_2;
                $numeroIdentificacion = $migracion->campo_1;
                foreach ($representantes as $representante):
                    if ($representante->type_of_identification == $nacionalidad && $representante->identidy_card == $numeroIdentificacion):
                        $representanteGet = $this->Parentsandguardians->get($representante->id);
                        $representanteGet->second_name = $migracion->campo_4 ? $migracion->campo_4 : '';
                        $representanteGet->second_surname = $migracion->campo_6 ? $migracion->campo_6: '';
                        $representanteGet->workplace = $migracion->campo_7 ? $migracion->campo_7 : '';
                        $representanteGet->address = $migracion->campo_8 ? $migracion->campo_8 : '';
                        $representanteGet->work_phone = $migracion->campo_9 ? $migracion->campo_9 : '';
                        $representanteGet->workplace = $migracion->campo_10 ? $migracion->campo_10 : '';
                        $representanteGet->landline = $migracion->campo_11 ? $migracion->campo_11 : '';
                        $representanteGet->identidy_card_father = $migracion->campo_12 ? $migracion->campo_12 : '';
                        $representanteGet->type_of_identification_father = $migracion->campo_13 ? $migracion->campo_13 : '';
                        if ($migracion->campo_14 != null):
                            $nombrePadre = explode(" ", $migracion->campo_14);

                            $cantidadElementosPadre = count($nombrePadre);

                            switch ($cantidadElementosPadre) 
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
                        else:
                            $representanteGet->first_name_father = '';
                            $representanteGet->second_name_father = '';
                            $representanteGet->surname_father = '';
                            $representanteGet->second_surname_father = '';
                        endif;
                        $representanteGet->address_father = $migracion->campo_15 ? $migracion->campo_15 : '';
                        $representanteGet->landline_father = $migracion->campo_16 ? $migracion->campo_16 : '';
                        $representanteGet->lugar_trabajo_padre = $migracion->campo_17 ? $migracion->campo_17 : '';
                        $representanteGet->direccion_trabajo_padre = $migracion->campo_18 ? $migracion->campo_18 : '';
                        $representanteGet->profession_father = $migracion->campo_19 ? $migracion->campo_19 : '';
                        $representanteGet->work_phone_father = $migracion->campo_20 ? $migracion->campo_20 : '';
                        $representanteGet->identidy_card_mother = $migracion->campo_21 ? $migracion->campo_21 : '';
                        $representanteGet->type_of_identification_mother = $migracion->campo_22 ? $migracion->campo_22 : '';

                        if ($migracion->campo_23 != null):
                            $nombreMadre = explode(" ", $migracion->campo_23);

                            $cantidadElementosMadre = count($nombreMadre);

                            switch ($cantidadElementosMadre) 
                            {
                                case 1:
                                    $representanteGet->first_name_mother = $nombreMadre[0];
                                    break;
                                case 2:
                                    $representanteGet->first_name_mother = $nombreMadre[0];
                                    $representanteGet->surname_mother = $nombreMadre[1];
                                    break;
                                case 3:
                                    $representanteGet->first_name_mother = $nombreMadre[0];
                                    $representanteGet->second_name_mother = $nombreMadre[1];
                                    $representanteGet->surname_mother = $nombreMadre[2];
                                    break;
                                case 4:
                                    $representanteGet->first_name_mother = $nombreMadre[0];
                                    $representanteGet->second_name_mother = $nombreMadre[1];
                                    $representanteGet->surname_mother = $nombreMadre[2];
                                    $representanteGet->second_surname_mother = $nombreMadre[3];
                                    break;
                            }
                        else:
                            $representanteGet->first_name_mother = '';
                            $representanteGet->second_name_mother = '';
                            $representanteGet->surname_mother = '';
                            $representanteGet->second_surname_mother = '';                            
                        endif;

                        $representanteGet->profession_mother = $migracion->campo_24 ? $migracion->campo_24 : '';
                        $representanteGet->address_mother = $migracion->campo_25 ? $migracion->campo_25 : '';
                        $representanteGet->landline_mother = $migracion->campo_26 ? $migracion->campo_26 : '';
                        $representanteGet->lugar_trabajo_madre = $migracion->campo_27 ? $migracion->campo_27 : '';
                        $representanteGet->direccion_trabajo_madre = $migracion->campo_28 ? $migracion->campo_28 : '';
                        $representanteGet->work_phone_mother = $migracion->campo_29 ? $migracion->campo_29 : '';
                        $representanteGet->family_tie = $migracion->campo_30 ? $migracion->campo_30 : '';
                        $representanteGet->llamada_emergencia = $migracion->campo_31 ? $migracion->campo_31 : '';
                        $representanteGet->cell_phone = $migracion->campo_32 ? $migracion->campo_32 : '';
                        $representanteGet->cell_phone_father = $migracion->campo_33 ? $migracion->campo_33 : '';
                        $representanteGet->cell_phone_mother = $migracion->campo_34 ? $migracion->campo_34 : '';
                        $representanteGet->profession = $migracion->campo_35 ? $migracion->campo_35 : '';
                        if ($migracion->campo_36 != null):
                            $representanteGet->email = $migracion->campo_36;
                        endif;
                        $representanteGet->email_father = $migracion->campo_37 ? $migracion->campo_37 : '';
                        $representanteGet->email_mother = $migracion->campo_38 ? $migracion->campo_38 : '';
                        if ($this->Parentsandguardians->save($representanteGet)):
                            $contadorMigracion++;
                            $representantesActualizados[] = 
                                [
                                    'cedula'    => $representanteGet->type_of_identification.'-'.$representanteGet->identidy_card,
                                    'nombre'    => $representanteGet->surname.' '.$representanteGet->first_name,
                                    'id'        => $representanteGet->id,
                                ];
                        else:
                            $representantesNoActualizados[] = 
                                [
                                    'cedula'    => $representanteGet->type_of_identification.'-'.$representanteGet->identidy_card,
                                    'nombre'    => $representanteGet->surname.' '.$representanteGet->first_name,
                                    'id'        => $representanteGet->id,
                                ];
                        endif; 
                        break;  
                    endif;
                endforeach;
            else:
                $representantesDuplicados[] = 
                                [
                                    'cedula'    => $representanteGet->type_of_identification.'-'.$representanteGet->identidy_card,
                                    'nombre'    => $representanteGet->surname.' '.$representanteGet->first_name,
                                    'id'        => $representanteGet->id,
                                ];
            endif;
            /*
            if ($contadorMigracion == 1):
                break;
            endif;
            */
        endforeach;
        $this->set(compact('representantesActualizados', 'representantesNoActualizados'));
    }
}