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

        $migraciones = $this->Migracions->find('all')->order(['campo_2' => 'ASC', 'campo_1' => 'ASC']);

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
                        $representanteGet->work_address = $migracion->campo_10 ? $migracion->campo_10 : '';
                        $representanteGet->landline = $migracion->campo_11 ? $migracion->campo_11 : '';
                        $representanteGet->family_tie = $migracion->campo_30 ? $migracion->campo_30 : '';
                        $representanteGet->cell_phone = $migracion->campo_32 ? $migracion->campo_32 : '';
                        $representanteGet->profession = $migracion->campo_35 ? $migracion->campo_35 : '';
                        if ($migracion->campo_36 != null):
                            $representanteGet->email = $migracion->campo_36;
                        endif;
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
                    'cedula'    => $representanteActual,
                    'nombre'    => $migracion->campo_3.' '.$migracion->campo_5,
                ];
            endif;
            /*
            if ($contadorMigracion == 1):
                break;
            endif;
            */
        endforeach;
        $this->set(compact('representantesActualizados', 'representantesNoActualizados', 'representantesDuplicados'));
    }
    public function migracionActualizacionEstudiante()
    {
        $contadorMigracion = 0;
        $contadorActualizados = 0;
        $estudiantesActualizados = [];
        $estudiantesNoActualizados = [];
        $estudiantesDuplicados = [];

        $this->loadModel('Students');

        $migraciones = $this->Migracions->find('all')->where(['id >' => 1])->order(['campo_39' => 'ASC']);

        $estudiantes = $this->Students->find('all')->where(['id >' => 1]);

        $identificacionEstudianteAnterior = '';
        $identificacionEstudianteActual = '';
        $contadorRegistros = 0;

        foreach ($migraciones as $migracion):
            $identificacionEstudianteActual = $migracion->campo_39;
            if ($identificacionEstudianteActual != $identificacionEstudianteAnterior): 
                foreach ($estudiantes as $estudiante):
                    if ($estudiante->identity_card == $identificacionEstudianteActual):
                        $estudianteActualizar = $this->Students->get($estudiante->id);
                        $estudianteActualizar->family_bond_guardian_student = $migracion->campo_30 ? $migracion->campo_30 : '';
                        if ($migracion->campo_14 != null):
                            $nombrePadre = explode(" ", $migracion->campo_14);

                            $cantidadElementosPadre = count($nombrePadre);

                            switch ($cantidadElementosPadre) 
                            {
                                case 1:
                                    $estudianteActualizar->first_name_father = $nombrePadre[0];
                                    break;
                                case 2:
                                    $estudianteActualizar->first_name_father = $nombrePadre[0];
                                    $estudianteActualizar->surname_father = $nombrePadre[1];
                                    break;
                                case 3:
                                    $estudianteActualizar->first_name_father = $nombrePadre[0];
                                    $estudianteActualizar->second_name_father = $nombrePadre[1];
                                    $estudianteActualizar->surname_father = $nombrePadre[2];
                                    break;
                                case 4:
                                    $estudianteActualizar->first_name_father = $nombrePadre[0];
                                    $estudianteActualizar->second_name_father = $nombrePadre[1];
                                    $estudianteActualizar->surname_father = $nombrePadre[2];
                                    $estudianteActualizar->second_surname_father = $nombrePadre[3];
                                    break;
                            }
                        else:
                            $estudianteActualizar->first_name_father = '';
                            $estudianteActualizar->second_name_father = '';
                            $estudianteActualizar->surname_father = '';
                            $estudianteActualizar->second_surname_father = '';
                        endif;

                        if ($migracion->campo_23 != null):
                            $nombreMadre = explode(" ", $migracion->campo_23);

                            $cantidadElementosMadre = count($nombreMadre);

                            switch ($cantidadElementosMadre) 
                            {
                                case 1:
                                    $estudianteActualizar->first_name_mother = $nombreMadre[0];
                                    break;
                                case 2:
                                    $estudianteActualizar->first_name_mother = $nombreMadre[0];
                                    $estudianteActualizar->surname_mother = $nombreMadre[1];
                                    break;
                                case 3:
                                    $estudianteActualizar->first_name_mother = $nombreMadre[0];
                                    $estudianteActualizar->second_name_mother = $nombreMadre[1];
                                    $estudianteActualizar->surname_mother = $nombreMadre[2];
                                    break;
                                case 4:
                                    $estudianteActualizar->first_name_mother = $nombreMadre[0];
                                    $estudianteActualizar->second_name_mother = $nombreMadre[1];
                                    $estudianteActualizar->surname_mother = $nombreMadre[2];
                                    $estudianteActualizar->second_surname_mother = $nombreMadre[3];
                                    break;
                            }
                        else:
                            $estudianteActualizar->first_name_mother = '';
                            $estudianteActualizar->second_name_mother = '';
                            $estudianteActualizar->surname_mother = '';
                            $estudianteActualizar->second_surname_mother = '';                            
                        endif;

                        $estudianteActualizar->tipo_identificacion_padre = $migracion->campo_13 ? $migracion->campo_13 : '';
                        $estudianteActualizar->numero_identificacion_padre = $migracion->campo_12 ? $migracion->campo_12 : '';
                        $estudianteActualizar->direccion_residencia_padre = $migracion->campo_15 ? $migracion->campo_15 : '';
                        $estudianteActualizar->email_padre = $migracion->campo_37 ? $migracion->campo_37 : '';
                        $estudianteActualizar->telefono_fijo_padre = $migracion->campo_16 ? $migracion->campo_16 : '';
                        $estudianteActualizar->celular_padre = $migracion->campo_33 ? $migracion->campo_33 : '';
                        $estudianteActualizar->telefono_trabajo_padre = $migracion->campo_20 ? $migracion->campo_20 : '';
                        $estudianteActualizar->profesion_padre = $migracion->campo_19 ? $migracion->campo_19 : '';
                        $estudianteActualizar->lugar_trabajo_padre = $migracion->campo_17 ? $migracion->campo_17 : '';
                        $estudianteActualizar->direccion_trabajo_padre = $migracion->campo_18 ? $migracion->campo_18 : '';
                        $estudianteActualizar->tipo_identificacion_madre = $migracion->campo_22 ? $migracion->campo_22 : '';
                        $estudianteActualizar->numero_identificacion_madre = $migracion->campo_21 ? $migracion->campo_21 : '';
                        $estudianteActualizar->direccion_residencia_madre = $migracion->campo_25 ? $migracion->campo_25 : '';
                        $estudianteActualizar->email_madre = $migracion->campo_38 ? $migracion->campo_38 : '';
                        $estudianteActualizar->telefono_fijo_madre = $migracion->campo_26 ? $migracion->campo_26 : '';
                        $estudianteActualizar->celular_madre = $migracion->campo_34 ? $migracion->campo_34 : '';
                        $estudianteActualizar->telefono_trabajo_madre = $migracion->campo_29 ? $migracion->campo_29 : '';
                        $estudianteActualizar->profesion_madre = $migracion->campo_24 ? $migracion->campo_24 : '';
                        $estudianteActualizar->lugar_trabajo_madre = $migracion->campo_27 ? $migracion->campo_27 : '';
                        $estudianteActualizar->direccion_trabajo_madre = $migracion->campo_28 ? $migracion->campo_28 : '';
                        $estudianteActualizar->llamada_emergencia = $migracion->campo_31 ? $migracion->campo_31 : '';

                        if ($this->Students->save($estudianteActualizar)):
                            $estudiantesActualizados[] = 
                                [
                                    'cedula'    => $estudianteActualizar->identity_card,
                                    'nombre'    => $estudianteActualizar->surname.' '.$estudianteActualizar->first_name,
                                    'id'        => $estudianteActualizar->id
                                ];
                            $contadorActualizados++;
                        else:
                            $estudiantesNoActualizados[] = 
                            [
                                'cedula'    => $estudianteActualizar->$estudiante->identity_card,
                                'nombre'    => $estudianteActualizar->surname.' '.$estudianteActualizar->first_name,
                                'id'        => $estudianteActualizar->id,
                            ];
                        endif; 
                        break;  
                    endif;
                endforeach;
            else:
                $estudiantesDuplicados[] = $identificacionEstudianteActual;
            endif;
            $identificacionEstudianteAnterior = $identificacionEstudianteActual;
            /*
            if ($contadorActualizados == 1):
                break;
            endif;
            */
            $contadorMigracion++;
        endforeach;
        $this->set(compact('estudiantesActualizados', 'estudiantesNoActualizados', 'estudiantesDuplicados', 'estudianteActualizar'));
    }
}