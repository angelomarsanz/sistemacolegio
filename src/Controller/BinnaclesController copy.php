<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\StudenttransactionsController;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;

/**
 * Binnacles Controller
 *
 * @property \App\Model\Table\BinnaclesTable $Binnacles
 */
class BinnaclesController extends AppController
{
    public function isAuthorized($user)
    {
		if(in_array($this->request->action, ['add']))
		{
			return true;
		}
        return parent::isAuthorized($user);
    }
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */

    public function testFunction()
    {
    }

    public function index()
    {
        $binnacles = $this->paginate($this->Binnacles);

        $this->set(compact('binnacles'));
        $this->set('_serialize', ['binnacles']);
    }

    /**
     * View method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $binnacle = $this->Binnacles->get($id, [
            'contain' => []
        ]);

        $this->set('binnacle', $binnacle);
        $this->set('_serialize', ['binnacle']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($typeClass = null, $className = null, $methodName = null, $novelty = null, $arrayExtra = null)
    {
		$this->autoRender = false;
		
		$arrayResult = [];
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = "Registro grabado exitosamente";
		$arrayResult['id'] = 0;
		
        $binnacle = $this->Binnacles->newEntity();
		
		$binnacle->type_class = $typeClass;
		
		$binnacle->class_name = $className;
		
		$binnacle->method_name = $methodName;
		
		$binnacle->novelty = $novelty;
		
		if (isset($arrayExtra))
		{
			$accountArray = 1;
			
			foreach ($arrayExtra as $arrayExtras)
			{
				if ($accountArray == 1)
				{
					$binnacle->extra_column1 = $arrayExtras;
				}
				
				if ($accountArray == 2)
				{
					$binnacle->extra_column2 = $arrayExtras;
				}

				if ($accountArray == 3)
				{
					$binnacle->extra_column3 = $arrayExtras;
				}
				
				if ($accountArray == 4)
				{
					$binnacle->extra_column4 = $arrayExtras;
				}
				
				if ($accountArray == 5)
				{
					$binnacle->extra_column5 = $arrayExtras;
				}
				
				if ($accountArray == 6)
				{
					$binnacle->extra_column6 = $arrayExtras;
				}
				
				if ($accountArray == 7)
				{
					$binnacle->extra_column7 = $arrayExtras;
				}
				
				if ($accountArray == 8)
				{
					$binnacle->extra_column8 = $arrayExtras;
				}
				
				if ($accountArray == 9)
				{
					$binnacle->extra_column9 = $arrayExtras;
				}
				
				if ($accountArray == 10)
				{
					$binnacle->extra_column10 = $arrayExtras;
				}
				
				$accountArray++;
			}
		}
				
		$binnacle->responsible_user = $this->Auth->user('username');
				
        if ($this->Binnacles->save($binnacle))
		{
			$lastRecord = $this->Binnacles->find('all')
				->where(['responsible_user' => $this->Auth->user('username')])
				->order(['created' => 'DESC']);
				
			$row = $lastRecord->first();
			
			if ($row)
			{
				$arrayResult['id'] = $row->id;
			}
		}
		else
		{
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = "No se pudo grabar el registro";
		}
	
		return $arrayResult;
    }

    /**
     * Edit method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $binnacle = $this->Binnacles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $binnacle = $this->Binnacles->patchEntity($binnacle, $this->request->data);
            if ($this->Binnacles->save($binnacle)) {
                $this->Flash->success(__('The binnacle has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The binnacle could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('binnacle'));
        $this->set('_serialize', ['binnacle']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Binnacle id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $binnacle = $this->Binnacles->get($id);
        if ($this->Binnacles->delete($binnacle)) {
            $this->Flash->success(__('The binnacle has been deleted.'));
        } else {
            $this->Flash->error(__('The binnacle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function cargarRepresentantes()
    {
        
        $representantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column1' => 'ASC', 'Binnacles.extra_column2' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorUsuarios = 0;
        $contadorRepresentantes = 0;
        $contadorRepresentantesCedulaDuplicada = 0;
        $contadorRepresentanteVariosHijos = 0;
        $representantesConCedulaDuplicada = [];
        $representantesConVariosHijos = [];
        $this->loadModel('Users');
        $this->loadModel('Parentsandguardians');

        foreach ($representantes as $representante)
        {
            $tipoIdentificacion = trim($representante->extra_column1);
            $numeroIdentificacion = trim($representante->extra_column2);
            $usuario = $tipoIdentificacion . $numeroIdentificacion;
            $nombre = trim($representante->extra_column3);
            $apellido = trim($representante->extra_column4);
 
            $usuarios = $this->Users->find('all', ['conditions' => ['username' => $usuario], 'order' => ['Users.created' => 'DESC'] ]);
                    
            $ultimaFila = $usuarios->first();

            if ($ultimaFila)
            {
                if ($ultimaFila->first_name != $nombre || $ultimaFila->surname != $apellido)
                {
                    $contadorRepresentantesCedulaDuplicada++;
                    $representantesConCedulaDuplicada[] =   
                    [
                        'cedula'    => $usuario,
                        'nombre'    => $nombre . ' ' . $apellido        
                    ];
                }
                else
                {
                    $contadorRepresentanteVariosHijos++;
                    $representantesConVariosHijos[] =   
                        [
                            'cedula'    => $usuario,
                            'nombre'    => $nombre . ' ' . $apellido        
                        ];
                }
            }
            else
            {
                $nuevoUsuario = $this->Users->newEntity();
                
                $nuevoUsuario->username = $usuario;
                    
                $nuevoUsuario->password = "verdad";
    
                $nuevoUsuario->role = "Representante";
    
                $nuevoUsuario->first_name = $nombre;
    
                $nuevoUsuario->second_name = "";
                    
                $nuevoUsuario->surname = $apellido;
                    
                $nuevoUsuario->second_surname = "";
                    
                $nuevoUsuario->sex = "";
                    
                $nuevoUsuario->email = $usuario . "@correo.com";
                    
                $nuevoUsuario->cell_phone = "";
                
                $nuevoUsuario->profile_photo = "";
                    
                $nuevoUsuario->profile_photo_dir = "";
                /*
                if (!($this->Users->save($nuevoUsuario))) 
                {
                    $this->Flash->error(__('El usuario no fue guardado ' . $user->username));
                }
                else
                {
                    $contadorUsuarios++;
                    $usuarios = $this->Users->find('all', ['conditions' => ['username' => $usuario], 'order' => ['Users.created' => 'DESC'] ]);
                    
                    $ultimaFila = $usuarios->first();
        
                    if ($ultimaFila)
                    {
                        $nuevoRepresentante = $this->Users->newEntity();
                        $nuevoRepresentante->user_id = $ultimaFila->id;
                        $nuevoRepresentante->first_name = $nombre;
                        $nuevoRepresentante->second_name = "";
                        $nuevoRepresentante->surname = $apellido;
                        $nuevoRepresentante->second_surname = "";
                        $nuevoRepresentante->sex = "";
                        $nuevoRepresentante->type_of_identification = $tipoIdentificacion;
                        $nuevoRepresentante->identidy_card = $numeroIdentificacion; 
                        $nuevoRepresentante->email = $usuario . "@correo.com"; 
                        $nuevoRepresentante->cell_phone = "";
                        $nuevoRepresentante->landline = "";
                        $nuevoRepresentante->address = "";
                        $nuevoRepresentante->profession = "";
                        $nuevoRepresentante->item = "";
                        $nuevoRepresentante->item_not_specified = "";
                        $nuevoRepresentante->workplace = "";
                        $nuevoRepresentante->professional_position = "";
                        $nuevoRepresentante->work_phone = "";
                        $nuevoRepresentante->work_address = "";
                        $nuevoRepresentante->family = "";
                        $nuevoRepresentante->surname_father = "";
                        $nuevoRepresentante->second_surname_father = "";
                        $nuevoRepresentante->first_name_father = "";
                        $nuevoRepresentante->second_name_father = "";
                        $nuevoRepresentante->type_of_identification_father = "";
                        $nuevoRepresentante->identidy_card_father = "";
                        $nuevoRepresentante->email_father = "";
                        $nuevoRepresentante->cell_phone_father = "";
                        $nuevoRepresentante->landline_father = "";
                        $nuevoRepresentante->work_phone_father = "";
                        $nuevoRepresentante->profession_father = "";
                        $nuevoRepresentante->address_father = "";
                        $nuevoRepresentante->surname_mother = "";
                        $nuevoRepresentante->second_surname_mother = "";
                        $nuevoRepresentante->first_name_mother = "";
                        $nuevoRepresentante->second_name_mother = "";
                        $nuevoRepresentante->type_of_identification_mother = ""; 
                        $nuevoRepresentante->identidy_card_mother = "";
                        $nuevoRepresentante->email_mother = "";
                        $nuevoRepresentante->cell_phone_mother = "";
                        $nuevoRepresentante->landline_mother = "";
                        $nuevoRepresentante->work_phone_mother = "";
                        $nuevoRepresentante->profession_mother = "";
                        $nuevoRepresentante->address_mother = "";
                        $nuevoRepresentante->client = "";
                        $nuevoRepresentante->type_of_identification_client = "";
                        $nuevoRepresentante->identification_number_client = "";
                        $nuevoRepresentante->fiscal_address = "";
                        $nuevoRepresentante->tax_phone = "";
                        $nuevoRepresentante->code_for_user = "";
                        $nuevoRepresentante->guardian = 0;
                        $nuevoRepresentante->family_tie = "";
                        $nuevoRepresentante->balance = 0;
                        $nuevoRepresentante->guardian_migration = 0;
                        $nuevoRepresentante->mi_id = 0;
                        $nuevoRepresentante->mi_children = 0;
                        $nuevoRepresentante->new_guardian = true;
                        $nuevoRepresentante->creative_user = $this->Auth->user('username');
                        $nuevoRepresentante->profile_photo = "";
                        $nuevoRepresentante->profile_photo_dir = "";
                        
                        if ($this->Parentsandguardians->save($nuevoRepresentante))
                        {
                            $contadorRepresentantes++;
                        } 
                        else
                        {
                            $this->Flash->error(__('El representante no pudo ser registrado ' . $usuario));
                        }
                        
                    }
                    else
                    {
                        $this->Flash->error(__('Nuevo usuario no encontrado ' . $usuario));
                    }
                }
                */
            }
            $contadorRegistros++;
            // if ($contadorRegistros == 10)
            // {
            //    break;
            // }
        }
        $this->Flash->success(__('Total registros leídos: ' . $contadorRegistros));
        $this->Flash->success(__('Total usuarios creados: ' . $contadorUsuarios));
        $this->Flash->success(__('Total representantes creados: ' . $contadorRepresentantes));
        $this->Flash->success(__('Total representantes con cédula duplicada: ' . $contadorRepresentantesCedulaDuplicada));
        $this->Flash->success(__('Total representantes con varios hijos: ' . $contadorRepresentanteVariosHijos));
        $this->set(compact('contadorRepresentantesCedulaDuplicada', 'contadorRepresentanteVariosHijos',  'representantesConCedulaDuplicada','representantesConVariosHijos'));
		$this->set('_serialize', ['contadorRepresentantesCedulaDuplicada', 'contadorRepresentanteVariosHijos', 'representantesConCedulaDuplicada', 'representantesConVariosHijos']);	
        
    }

    public function cargarEstudiantes()
    {
        
        $grados = 
        [
            'Pre-escolar, pre-kinder' => 'Pre-kinder',                                
            'Pre-escolar, kinder' => 'Kinder',
            'Pre-escolar, preparatorio' => 'Preparatorio',
            'Primaria, 1' => '1er. Grado',
            'Primaria, 2' => '2do. Grado',
            'Primaria, 3' => '3er. Grado',
            'Primaria, 4' => '4to. Grado',
            'Primaria, 5' => '5to. Grado',
            'Primaria, 6' => '6to. Grado',
            'Secundaria, 1' => '1er. Año',
            'Secundaria, 2' => '2do. Año',
            'Secundaria, 3' => '3er. Año',
            'Secundaria, 4' => '4to. Año',
            'Secundaria, 5' => '5to. Año'
        ];

        $nivelesGrados = 
        [
            'Pre-escolar, pre-kinder' => 'Pre-escolar, kinder',                                 
            'Pre-escolar, kinder' => 'Pre-escolar, preparatorio',
            'Pre-escolar, preparatorio' => 'Primaria, 1er. grado',
            'Primaria, 1' => 'Primaria, 2do. grado',
            'Primaria, 2' => 'Primaria, 3er. grado',
            'Primaria, 3' => 'Primaria, 4to. grado',
            'Primaria, 4' => 'Primaria, 5to. grado',
            'Primaria, 5' => 'Primaria, 6to. grado',
            'Primaria, 6' => 'Secundaria, 1er. año',
            'Secundaria, 1' => 'Secundaria, 2do. año',
            'Secundaria, 2' => 'Secundaria, 3er. año',
            'Secundaria, 3' => 'Secundaria, 4to. año',
            'Secundaria, 4' => 'Secundaria, 5to. año',
            'Secundaria, 5' => ''
        ];

        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorEstudiantes = 0;
        $contadorEstudiantesCedulaDuplicada = 0;
        $contadorEstudiantesRepetidos = 0;
        $contadorEstudiantesSinRepresentantes = 0;
        $contadorEstudiantesNoRegistrados = 0;
        $estudiantesConCedulaDuplicada = [];
        $estudiantesRepetidos = [];
        $estudiantesSinRepresentantes = [];
        $estudiantesNoRegistrados = [];
        $this->loadModel('Parentsandguardians');
        $this->loadModel('Students');
        $this->loadModel('Sections');

        foreach ($estudiantes as $estudiante)
        {
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionRepresentante = trim($estudiante->extra_column2);
            $numeroIdentificacionRepresentante = trim($estudiante->extra_column3);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column4);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column5);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;
            $nombre = trim($estudiante->extra_column6);
            $apellido = trim($estudiante->extra_column7);
            $nivelEstudianteMigracion = trim($estudiante->extra_column9);
            $gradoEstudianteMigracion = trim($estudiante->extra_column10);
            $nivelGradoEstudianteMigracion = $nivelEstudianteMigracion . ', ' . $gradoEstudianteMigracion;
            
            if ($estudiante->extra_column8 == null)
            {
                $descuentoEstudiante = 0;
            }
            else
            {
                $descuentoEstudiante = trim($estudiante->extra_column8);
            }

            if ($descuentoEstudiante == 0)
            {
                $tipoDescuentoEstudiante = '';
            }
            elseif ($descuentoEstudiante == 60)
            {
                $tipoDescuentoEstudiante = 'Empleado';
            }
            else
            {
                $tipoDescuentoEstudiante = 'Hijos';
            }
 
            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();

            if ($ultimaFila)
            {
                if ($ultimaFila->first_name != $nombre || $ultimaFila->surname != $apellido)
                {
                    $contadorEstudiantesCedulaDuplicada++;
                    $estudiantesConCedulaDuplicada[] =   
                    [
                        'cedula'    => $cedula,
                        'nombre'    => $nombre . ' ' . $apellido        
                    ];
                }
                else
                {
                    $contadorEstudiantesRepetidos++;
                    $estudiantesRepetidos[] =   
                        [
                            'cedula'    => $cedula,
                            'nombre'    => $nombre . ' ' . $apellido        
                        ];
                }
            }
            else
            {
                $representantes = $this->Parentsandguardians->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionRepresentante, 'identidy_card' => $numeroIdentificacionRepresentante], 'order' => ['Parentsandguardians.created' => 'DESC']]);

                $ultimaFila = $representantes->first();

                if ($ultimaFila)
                {
                    $idRepresentante = $ultimaFila->id;

                    $secciones = $this->Sections->find('all', ['conditions' => ['section' => 'A',]]);

                    $gradoEstudiante = $grados[$nivelGradoEstudianteMigracion];
                    $nivelGradoEstudiante = $nivelesGrados[$nivelGradoEstudianteMigracion];

                    foreach ($secciones as $seccion)
                    {
                        if ($seccion->sublevel == $gradoEstudiante)
                        {
                            $idSeccionActual = $seccion->id;        
                        }
                    }
                    
                    // $this->Flash->success(__('Estudiante: ' . $nombre . ' ' . $apellido));
                    // $this->Flash->success(__('nivelGradoEstudianteMigracion: ' . $nivelGradoEstudianteMigracion));
                    // $this->Flash->success(__('gradoEstudiante: ' . $gradoEstudiante));
                    // $this->Flash->success(__('nivelGradoEstudiante: ' . $nivelGradoEstudiante));
                    
                    $nuevoEstudiante = $this->Students->newEntity();      
                    $nuevoEstudiante->user_id = 3;
                    $nuevoEstudiante->parentsandguardian_id = $idRepresentante;
                    $nuevoEstudiante->first_name = $nombre;                    
                    $nuevoEstudiante->second_name = "";
                    $nuevoEstudiante->surname = $apellido;
                    $nuevoEstudiante->second_surname = "";
                    $nuevoEstudiante->sex = "";
                    $nuevoEstudiante->nationality = "";
                    $nuevoEstudiante->type_of_identification = $tipoIdentificacionEstudiante; 
                    $nuevoEstudiante->identity_card = $numeroIdentificacionEstudiante;
                    $nuevoEstudiante->place_of_birth = "";
                    $nuevoEstudiante->country_of_birth = "";
                    $nuevoEstudiante->birthdate = Time::now();
                    $nuevoEstudiante->cell_phone = "";
                    $nuevoEstudiante->email = "";
                    $nuevoEstudiante->address = "";
                    $nuevoEstudiante->level_of_study = $nivelGradoEstudiante;
                    $nuevoEstudiante->family_bond_guardian_student = "";
                    $nuevoEstudiante->first_name_father = "";
                    $nuevoEstudiante->second_name_father = "";
                    $nuevoEstudiante->surname_father = "";
                    $nuevoEstudiante->second_surname_father = "";
                    $nuevoEstudiante->first_name_mother = "";
                    $nuevoEstudiante->second_name_mother = "";
                    $nuevoEstudiante->surname_mother = "";
                    $nuevoEstudiante->second_surname_mother = "";
                    $nuevoEstudiante->brothers_in_school = false;
                    $nuevoEstudiante->previous_school = "";
                    $nuevoEstudiante->student_illnesses = "";
                    $nuevoEstudiante->observations = "";
                    $nuevoEstudiante->code_for_user = "";
                    $nuevoEstudiante->school_card = "";
                    $nuevoEstudiante->profile_photo = "";
                    $nuevoEstudiante->profile_photo_dir = "";
                    $nuevoEstudiante->section_id = $idSeccionActual;
                    $nuevoEstudiante->student_condition = "Regular";
                    $nuevoEstudiante->new_student = 0;
                    $nuevoEstudiante->scholarship = 0;
                    $nuevoEstudiante->creative_user = $this->Auth->user('username');
                    $nuevoEstudiante->student_migration = 0;
                    $nuevoEstudiante->mi_id = $idMigracion;
                    $nuevoEstudiante->number_of_brothers = 0;
                    $nuevoEstudiante->balance = 0;
                    $nuevoEstudiante->tipo_descuento = $tipoDescuentoEstudiante;
                    $nuevoEstudiante->discount = $descuentoEstudiante;
                    /*
                    if ($this->Students->save($nuevoEstudiante)) 
                    {
                        $contadorEstudiantes++;                
                    }
                    else
                    {
                        $contadorEstudiantesNoRegistrados++;
                        $estudiantesNoRegistrados[] =   
                        [
                            'cedula'    => $cedula,
                            'nombre'    => $nombre . ' ' . $apellido        
                        ];
                    }
                    */
                }
                else
                {
                    $contadorEstudiantesSinRepresentantes++;
                    $estudiantesSinRepresentantes[] =   
                    [
                        'cedula'    => $cedula,
                        'nombre'    => $nombre . ' ' . $apellido        
                    ];
                }
            }
            $contadorRegistros++;
            
            // if ($contadorRegistros == 5)
            // {
            //    break;
            // }
            //
        }
        $this->Flash->success(__('Total registros leídos: ' . $contadorRegistros));
        $this->Flash->success(__('Total estudiantes creados: ' . $contadorEstudiantes));
        $this->Flash->success(__('Total estudiantes no registrados: ' . $contadorEstudiantesNoRegistrados));
        $this->Flash->success(__('Total estudiantes con cédula duplicada: ' . $contadorEstudiantesCedulaDuplicada));
        $this->Flash->success(__('Total estudiantes repetidos: ' . $contadorEstudiantesRepetidos));

        $this->set(compact('contadorEstudiantesNoRegistrados', 'contadorEstudiantesCedulaDuplicada', 'contadorEstudiantesRepetidos', 'estudiantesNoRegistrados', 'estudiantesConCedulaDuplicada', 'estudiantesRepetidos'));
		$this->set('_serialize', ['contadorEstudiantesNoRegistrados', 'contadorEstudiantesCedulaDuplicada', 'contadorEstudiantesRepetidos', 'estudiantesNoRegistrados', 'estudiantesConCedulaDuplicada', 'estudiantesRepetidos']);	
    
    }
    public function cargarMensualidadesAnterior()
    {
        $nivelAnterior = 
        [
            'Pre-escolar, kinder' => 'Pre-escolar',
            'Pre-escolar, preparatorio' => 'Pre-escolar',
            'Primaria, 1' => 'Pre-escolar',
            'Primaria, 2' => 'Primaria',
            'Primaria, 3' => 'Primaria',
            'Primaria, 4' => 'Primaria',
            'Primaria, 5' => 'Primaria',
            'Primaria, 6' => 'Primaria',
            'Secundaria, 1' => 'Primaria',
            'Secundaria, 2' => 'Secundaria',
            'Secundaria, 3' => 'Secundaria',
            'Secundaria, 4' => 'Secundaria',
            'Secundaria, 5' => 'Secundaria'
        ];

        $columnasMensualidades =
        [
            'columna_extra27' => '2019-09-01Septiembre',
            'columna_extra26' => '2019-10-01Octubre',
            'columna_extra25' => '2019-11-01Noviembre',
            'columna_extra24' => '2019-12-01Diciembre',
            'columna_extra23' => '2020-01-01Enero',
            'columna_extra22' => '2020-02-01Febrero',
            'columna_extra21' => '2020-03-01Marzo',
            'columna_extra20' => '2020-04-01Abril',
            'columna_extra19' => '2020-05-01Mayo',
            'columna_extra18' => '2020-06-01Junio',
            'columna_extra17' => '2020-07-01Julio',
            'columna_extra16' => '2020-08-01Agosto'
        ];

        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorEstudiantes = 0;
        $contadorTransaccionesMayorCero = 0;
        $contadorEstudiantesNoEncontrados = 0;
        $estudiantesNoEncontrados = [];
        $contadorMensualidadesMayorTarifa = 0;
        $mensualidadesMayorTarifa = [];
        $contadorTransaccionesNoGuardadas = 0;
        $transaccionesNoGuardadas = []; 

        $this->loadModel('Students');

        foreach ($estudiantes as $estudiante)
        {     
            $estudianteEncontrado = 0;   
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column2);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column3);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;
            $nivelGradoEstudianteActual = trim($estudiante->extra_column4) . ', ' . trim($estudiante->extra_column5);
            $nivelEstudianteAnterior = $nivelAnterior[$nivelGradoEstudianteActual];
            $matriculaPrimaria = 0;
            $matriculaSecundaria = 0;
            $mensualidadPrimaria = 13.88;
            $mensualidadSecundaria = 13.88;
            $matriculaAplicar = 0;
            $mensualidadAplicar = 0;

            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante, 'mi_id' => $idMigracion], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();

            if ($ultimaFila)
            {
                $estudianteEncontrado = 1;
                $idEstudiante = $ultimaFila->id;
                if ($nivelEstudianteAnterior == 'Primaria')
                {
                    $matriculaAplicar = $matriculaPrimaria;
                    $mensualidadAplicar = $mensualidadPrimaria;
                }
                else
                {
                    $matriculaAplicar = $matriculaSecundaria;
                    $mensualidadAplicar = $mensualidadSecundaria;                    
                }
            }
            else
            {
                $contadorEstudiantesNoEncontrados++;
                $estudiantesNoEncontrados[] = ['cedula' => $cedula, 'idMigracion' => $idMigracion];
            }

            if ($estudianteEncontrado == 1)
            {
                if ($estudiante->columna_extra28 > 0)
                {
                    $contadorTransaccionesMayorCero++;
                    $this->Flash->success(__('Matrícula Cédula ' . $cedula . ' Nivel anterior' . $nivelEstudianteAnterior . ' Monto ' . number_format($estudiante->columna_extra28, 2, ",", "."))); 
                    // Crear transaccion de matrícula
                }

                foreach ($columnasMensualidades as $indice => $valor)
                {
                    if ($estudiante->$indice > 0)
                    {
                        $contadorTransaccionesMayorCero++;
                        if ($mensualidadAplicar == $estudiante->$indice)
                        {
                            $pagoParcial = 0;
                            $montoAbonado = 0;
                        }
                        elseif ($mensualidadAplicar > $estudiante->$indice)
                        {
                            $pagoParcial = 1;
                            $montoAbonado = $mensualidadAplicar - $estudiante->$indice;
                        }
                        else
                        {
                            $pagoParcial = 0;
                            $montoAbonado = 0;
                            $contadorMensualidadesMayorTarifa++;
                            $mensualidadesMayorTarifa[] = 
                            [
                                'cedula' => $cedula,
                                'mensualidad' => substr($valor, 0, 10),
                                'monto' => $estudiante->$indice
                            ];
                        }

                        $datosTransaccion =
                        [
                            'id_estudiante' => $idEstudiante,
                            'fecha_pago' => substr($valor, 0, 10),
                            'ano_escolar' => '2019',
                            'tipo_transaccion' => 'Mensualidad',
                            'descripcion_transaccion' => substr($valor, 10, 3) . ' ' . substr($valor, 0, 4),
                            'monto' => $mensualidadAplicar,
                            'monto_original' => $mensualidadAplicar,
                            'pago_total' => 0,                          
                            'pago_parcial' => $pagoParcial,
                            'monto_abonado' => $montoAbonado
                        ];

                        $this->Flash->success(__('Mensualidades Cédula: ' . $cedula . ', Nivel anterior: ' . $nivelEstudianteAnterior . ', Mensualidad a aplicar: ' . number_format($mensualidadAplicar, 2, ",", ".") . ', Monto adeudado: ' . number_format($estudiante->$indice, 2, ",", ".") . ', Monto abonado: ' . number_format($montoAbonado, 2, ",", "."))); 

                        /*
                        $codigoRetornoTransaccion = $this->agregarTransaccion($datosTransaccion);
                        if ($codigoRetornoTransaccion == 1)
                        {
                            $contadorTransaccionesNoGuardadas++;
                            $transaccionesNoGuardadas[] = 
                            [
                                'cedula' => $cedula,
                                'mensualidad' => substr($valor, 0, 10),
                                'monto' => $estudiante->$indice
                            ];
                        }
                        */
                    }
                }
            } 
        }
        $this->Flash->success(__('ContadorTransaccionesMayorCero ' . $contadorTransaccionesMayorCero)); 
        $this->set(compact('contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas', 'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas'));
        $this->set('_serialize', ['contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas',  'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas']);	
    }

    public function cargarMensualidadesActual()
    {
        $nivelActual = 
        [
            'Pre-escolar, pre-kinder' => 'Pre-escolar',                                
            'Pre-escolar, kinder' => 'Pre-escolar',
            'Pre-escolar, preparatorio' => 'Pre-escolar',
            'Primaria, 1' => 'Primaria',
            'Primaria, 2' => 'Primaria',
            'Primaria, 3' => 'Primaria',
            'Primaria, 4' => 'Primaria',
            'Primaria, 5' => 'Primaria',
            'Primaria, 6' => 'Primaria',
            'Secundaria, 1' => 'Secundaria',
            'Secundaria, 2' => 'Secundaria',
            'Secundaria, 3' => 'Secundaria',
            'Secundaria, 4' => 'Secundaria',
            'Secundaria, 5' => 'Secundaria'
        ];

        $columnasMensualidades =
        [
            'columna_extra27' => '2020-09-01Septiembre',
            'columna_extra26' => '2020-10-01Octubre',
            'columna_extra25' => '2020-11-01Noviembre',
            'columna_extra24' => '2020-12-01Diciembre',
            'columna_extra23' => '2021-01-01Enero',
            'columna_extra22' => '2021-02-01Febrero',
            'columna_extra21' => '2021-03-01Marzo',
            'columna_extra20' => '2021-04-01Abril',
            'columna_extra19' => '2021-05-01Mayo',
            'columna_extra18' => '2021-06-01Junio',
            'columna_extra17' => '2021-07-01Julio',
            'columna_extra16' => '2021-08-01Agosto'
        ];

        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorEstudiantes = 0;
        $contadorTransaccionesMayorCero = 0;
        $contadorEstudiantesNoEncontrados = 0;
        $estudiantesNoEncontrados = [];
        $contadorMensualidadesMayorTarifa = 0;
        $mensualidadesMayorTarifa = [];
        $contadorTransaccionesNoGuardadas = 0;
        $transaccionesNoGuardadas = []; 

        $this->loadModel('Students');

        foreach ($estudiantes as $estudiante)
        {     
            $contadorRegistros++;

            // if ($contadorRegistros > 10)
            // {
            //    break;
            // }

            $estudianteEncontrado = 0;   
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column2);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column3);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;
            $nivelGradoEstudianteActual = trim($estudiante->extra_column4) . ', ' . trim($estudiante->extra_column5);
            $nivelEstudianteActual = $nivelActual[$nivelGradoEstudianteActual];
            $matriculaPrimaria = 0;
            $matriculaSecundaria = 0;
            $mensualidadPrimaria = 16.50;
            $mensualidadSecundaria = 17.80;
            $matriculaAplicar = 0;
            $mensualidadAplicar = 0;

            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante, 'mi_id' => $idMigracion], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();

            if ($ultimaFila)
            {
                $estudianteEncontrado = 1;
                $idEstudiante = $ultimaFila->id;
                $nombreEstudiante = $ultimaFila->surname . ' ' . $ultimaFila->first_name; 
                if ($nivelEstudianteActual == 'Primaria')
                {
                    $matriculaAplicar = $matriculaPrimaria;
                    if ($ultimaFila->discount > 0)
                    {
                        $mensualidadAplicar = round($mensualidadPrimaria - (($mensualidadPrimaria * $ultimaFila->discount)/100), 2);
                    }
                    else
                    {                       
                        $mensualidadAplicar = $mensualidadPrimaria;
                    }
                }
                else
                {
                    $matriculaAplicar = $matriculaSecundaria;
                    if ($ultimaFila->discount > 0)
                    {
                        $mensualidadAplicar = round($mensualidadSecundaria - (($mensualidadSecundaria * $ultimaFila->discount)/100), 2);
                    }    
                    else
                    {                    
                        $mensualidadAplicar = $mensualidadSecundaria;   
                    }                 
                }
            }
            else
            {
                $this->Flash->error(__('Estudiante no encontrado: ' . $cedula . ' ' . $idMigracion));
                $contadorEstudiantesNoEncontrados++;
                $estudiantesNoEncontrados[] = ['cedula' => $cedula, 'idMigracion' => $idMigracion];
            }

            if ($estudianteEncontrado == 1)
            {
                if ($estudiante->columna_extra28 > 0)
                {
                    $contadorTransaccionesMayorCero++;
                    $this->Flash->success(__('Matrícula Cédula ' . $cedula . ' Nivel actual' . $nivelEstudianteActual . ' Monto ' . number_format($estudiante->columna_extra28, 2, ",", "."))); 
                    // Crear transaccion de matrícula
                }

                foreach ($columnasMensualidades as $indice => $valor)
                {
                    if ($estudiante->$indice > 0)
                    {
                        $contadorTransaccionesMayorCero++;
                        if ($mensualidadAplicar == $estudiante->$indice)
                        {
                            $pagoParcial = 0;
                            $montoAbonado = 0;
                        }
                        elseif ($mensualidadAplicar > $estudiante->$indice)
                        {
                            $pagoParcial = 1;
                            $montoAbonado = $mensualidadAplicar - $estudiante->$indice;
                        }
                        elseif ($mensualidadAplicar < $estudiante->$indice)
                        {
                            $pagoParcial = 0;
                            $montoAbonado = 0;
                            $contadorMensualidadesMayorTarifa++;
                            $mensualidadesMayorTarifa[] = 
                            [
                                'cedula' => $cedula,
                                'nombre' => $nombreEstudiante,
                                'nivel' => $nivelEstudianteActual,
                                'mensualidad' => substr($valor, 0, 7),
                                'monto' => $mensualidadAplicar, 
                                'deuda' => $estudiante->$indice
                            ];
                        }

                        $datosTransaccion =
                        [
                            'id_estudiante' => $idEstudiante,
                            'fecha_pago' => substr($valor, 0, 10),
                            'ano_escolar' => '2020',
                            'tipo_transaccion' => 'Mensualidad',
                            'descripcion_transaccion' => substr($valor, 10, 3) . ' ' . substr($valor, 0, 4),
                            'monto' => $mensualidadAplicar,
                            'monto_original' => $mensualidadAplicar,
                            'pago_total' => 0,                          
                            'pago_parcial' => $pagoParcial,
                            'monto_abonado' => $montoAbonado
                        ];

                        $this->Flash->success(__('Mensualidades Cédula: ' . $cedula . ', Nivel actual: ' . $nivelEstudianteActual . ', Mensualidad a aplicar: ' . number_format($mensualidadAplicar, 2, ",", ".") . ', mensualidad ' . substr($valor, 0, 7) . ', Monto adeudado: ' . number_format($estudiante->$indice, 2, ",", ".") . ', Monto abonado: ' . number_format($montoAbonado, 2, ",", "."))); 
                        /*
                        $codigoRetornoTransaccion = $this->agregarTransaccion($datosTransaccion);
                        if ($codigoRetornoTransaccion == 1)
                        {
                            $contadorTransaccionesNoGuardadas++;
                            $transaccionesNoGuardadas[] = 
                            [
                                'cedula' => $cedula,
                                'mensualidad' => substr($valor, 0, 10),
                                'monto' => $estudiante->$indice
                            ];
                        }
                        */
                    }
                }
            } 
        }
        $this->Flash->success(__('ContadorTransaccionesMayorCero ' . $contadorTransaccionesMayorCero)); 
        $this->set(compact('contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas', 'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas'));
        $this->set('_serialize', ['contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas',  'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas']);
    }

    public function cargarMensualidadesNuevo()
    {
        $nivelNuevo = 
        [
            'Pre-escolar, pre-kinder' => 'Pre-escolar',                                
            'Pre-escolar, kinder' => 'Pre-escolar',
            'Pre-escolar, preparatorio' => 'Primaria',
            'Primaria, 1' => 'Primaria',
            'Primaria, 2' => 'Primaria',
            'Primaria, 3' => 'Primaria',
            'Primaria, 4' => 'Primaria',
            'Primaria, 5' => 'Primaria',
            'Primaria, 6' => 'Secundaria',
            'Secundaria, 1' => 'Secundaria',
            'Secundaria, 2' => 'Secundaria',
            'Secundaria, 3' => 'Secundaria',
            'Secundaria, 4' => 'Secundaria',
            'Secundaria, 5' => ''
        ];

        $columnasMensualidades =
        [
            'columna_extra27' => '2021-09-01Septiembre',
        ];

        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorEstudiantes = 0;
        $contadorTransaccionesMayorCero = 0;
        $contadorEstudiantesNoEncontrados = 0;
        $estudiantesNoEncontrados = [];
        $contadorMatriculasMayorTarifa = 0;
        $matriculasMayorTarifa = [];
        $contadorMensualidadesMayorTarifa = 0;
        $mensualidadesMayorTarifa = [];
        $contadorTransaccionesNoGuardadas = 0;
        $transaccionesNoGuardadas = []; 
        $contadorEstudianteNoActualizado = 0;
        $estudiantesNoActualizados = [];
        $contadorRepresentantesNoActualizados = 0;
        $representantesNoActualizados = []; 

        $this->loadModel('Students');
        $this->loadModel('Parentsandguardians');

        foreach ($estudiantes as $estudiante)
        {
            $sobranteMatricula = 0;
            $sobranteMensualidad = 0; 
            $sobranteAcumulado = 0; 
            $pagoMatricula = 0;
            $motivoRepresentanteNoActualizado = ''; 
            $contadorRegistros++;

            // if ($contadorRegistros > 10)
            // {
            //    break;
            // }

            $estudianteEncontrado = 0;   
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column2);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column3);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;
            $nivelGradoEstudianteActual = trim($estudiante->extra_column4) . ', ' . trim($estudiante->extra_column5);
            $nivelEstudianteNuevo = $nivelNuevo[$nivelGradoEstudianteActual];
            $matriculaPrimaria = 23;
            $matriculaSecundaria = 23;
            $mensualidadPrimaria = 25;
            $mensualidadSecundaria = 25;
            $matriculaAplicar = 0;
            $mensualidadAplicar = 0;

            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante, 'mi_id' => $idMigracion], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();
            $registroEstudiante = $ultimaFila;

            if ($ultimaFila)
            {
                $estudianteEncontrado = 1;
                $idEstudiante = $ultimaFila->id;
                $idRepresentante = $ultimaFila->parentsandguardian_id;
                $nombreEstudiante = $ultimaFila->surname . ' ' . $ultimaFila->first_name; 
                if ($nivelEstudianteNuevo == 'Primaria')
                {
                    $matriculaAplicar = $matriculaPrimaria;
                    if ($ultimaFila->discount > 0)
                    {
                        $mensualidadAplicar = round($mensualidadPrimaria - (($mensualidadPrimaria * $ultimaFila->discount)/100), 2);
                    }
                    else
                    {
                        $mensualidadAplicar = $mensualidadPrimaria;
                    }
                }
                else
                {
                    $matriculaAplicar = $matriculaSecundaria;
                    if ($ultimaFila->discount > 0)
                    {
                        $mensualidadAplicar = round($mensualidadSecundaria - (($mensualidadSecundaria * $ultimaFila->discount)/100), 2);
                    }    
                    else
                    {                    
                        $mensualidadAplicar = $mensualidadSecundaria;   
                    }                 
                }
            }
            else
            {
                $this->Flash->error(__('Estudiante no encontrado: ' . $cedula . ' ' . $idMigracion));
                $contadorEstudiantesNoEncontrados++;
                $estudiantesNoEncontrados[] = ['cedula' => $cedula, 'idMigracion' => $idMigracion];
            }

            if ($estudianteEncontrado == 1)
            {
                if ($estudiante->columna_extra28 > 0)
                {
                    $pagoMatricula = 1;
                    $contadorTransaccionesMayorCero++;
                    $montoAbonado = $estudiante->columna_extra28;
                    if ($matriculaAplicar == $estudiante->columna_extra28)
                    {
                        $pagoTotal = 1;
                        $pagoParcial = 0;
                    }
                    elseif ($matriculaAplicar > $estudiante->columna_extra28)
                    {
                        $pagoTotal = 0;
                        $pagoParcial = 1;
                    }
                    elseif ($matriculaAplicar < $estudiante->columna_extra28)
                    {
                        $pagoTotal = 1;
                        $pagoParcial = 0;
                        $contadorMatriculasMayorTarifa++;
                        $matriculasMayorTarifa[] =
                        [
                            'cedula' => $cedula,
                            'nombre' => $nombreEstudiante,
                            'nivel' => $nivelEstudianteNuevo,
                            'matricula' => 'Matrícula 2021',
                            'monto' => $matriculaAplicar, 
                            'abono' => $estudiante->columna_extra28
                        ];

                        $sobranteMatricula = $estudiante->columna_extra28 - $matriculaAplicar;
                        $sobranteAcumulado = $sobranteAcumulado + $sobranteMatricula;
                    }

                    $datosTransaccion =
                    [
                        'id_estudiante' => $idEstudiante,
                        'fecha_pago' => '1970-01-01',
                        'ano_escolar' => '2021',
                        'tipo_transaccion' => 'Matrícula',
                        'descripcion_transaccion' => 'Matrícula 2021',
                        'monto' => $matriculaAplicar,
                        'monto_original' => $matriculaAplicar,
                        'pago_total' => $pagoTotal,                          
                        'pago_parcial' => $pagoParcial,
                        'monto_abonado' => $montoAbonado
                    ];

                    $this->Flash->success(__('Matrícula Cédula: ' . $cedula . ', Nivel nuevo: ' . $nivelEstudianteNuevo . ', Matrícula a aplicar: ' . number_format($matriculaAplicar, 2, ",", ".") . ', Monto abonado: ' . number_format($montoAbonado, 2, ",", "."))); 
                    
                    $codigoRetornoTransaccion = $this->agregarTransaccion($datosTransaccion);
                    if ($codigoRetornoTransaccion == 1)
                    {
                        $contadorTransaccionesNoGuardadas++;
                        $transaccionesNoGuardadas[] = 
                        [
                            'cedula' => $cedula,
                            'mensualidad' => 'Matrícula 2021',
                            'monto' => $estudiante->columna_extra28
                        ];
                    }
                    
                }

                foreach ($columnasMensualidades as $indice => $valor)
                {
                    if ($estudiante->$indice > 0)
                    {
                        $contadorTransaccionesMayorCero++;
                        $montoAbonado = $estudiante->$indice;
                        if ($mensualidadAplicar == $estudiante->$indice)
                        {
                            $pagoTotal = 1;
                            $pagoParcial = 0;
                        }
                        elseif ($mensualidadAplicar > $estudiante->$indice)
                        {
                            $pagoTotal = 0;
                            $pagoParcial = 1;
                        }
                        elseif ($mensualidadAplicar < $estudiante->$indice)
                        {
                            $pagoTotal = 1;
                            $pagoParcial = 0;
                            $contadorMensualidadesMayorTarifa++;
                            $mensualidadesMayorTarifa[] = 
                            [
                                'cedula' => $cedula,
                                'nombre' => $nombreEstudiante,
                                'nivel' => $nivelEstudianteNuevo,
                                'mensualidad' => substr($valor, 0, 7),
                                'monto' => $mensualidadAplicar, 
                                'abono' => $estudiante->$indice
                            ];

                            $sobranteMensualidad = $estudiante->$indice - $mensualidadAplicar;
                            $sobranteAcumulado = $sobranteAcumulado + $sobranteMensualidad;
                        }

                        $datosTransaccion =
                        [
                            'id_estudiante' => $idEstudiante,
                            'fecha_pago' => substr($valor, 0, 10),
                            'ano_escolar' => '2021',
                            'tipo_transaccion' => 'Mensualidad',
                            'descripcion_transaccion' => substr($valor, 10, 3) . ' ' . substr($valor, 0, 4),
                            'monto' => $mensualidadAplicar,
                            'monto_original' => $mensualidadAplicar,
                            'pago_total' => $pagoTotal,                          
                            'pago_parcial' => $pagoParcial,
                            'monto_abonado' => $montoAbonado
                        ];

                        $this->Flash->success(__('Mensualidades Cédula: ' . $cedula . ', Nivel nuevo: ' . $nivelEstudianteNuevo . ', Mensualidad a aplicar: ' . number_format($mensualidadAplicar, 2, ",", ".") . ', mensualidad ' . substr($valor, 0, 7) . ', Monto abonado: ' . number_format($montoAbonado, 2, ",", "."))); 

                        
                        $codigoRetornoTransaccion = $this->agregarTransaccion($datosTransaccion);
                        if ($codigoRetornoTransaccion == 1)
                        {
                            $contadorTransaccionesNoGuardadas++;
                            $transaccionesNoGuardadas[] = 
                            [
                                'cedula' => $cedula,
                                'mensualidad' => substr($valor, 0, 10),
                                'monto' => $estudiante->$indice
                            ];
                        }
                        
                    }
                }
                if ($pagoMatricula == 1)
                {
                    
                    $registroEstudiante->balance = 2021;
                    if (!($this->Students->save($registroEstudiante)))
                    {
                        $contadorEstudianteNoActualizado++;
                        $estudiantesNoActualizados[] =
                            [
                                'cedula' => $cedula,
                                'nombre' => $nombreEstudiante
                            ];
                    }                 
                }
                if ($sobranteAcumulado > 0)
                {
                    $representantes = $this->Parentsandguardians->find('all', ['conditions' => ['id' => $idRepresentante], 'order' => ['Parentsandguardians.created' => 'DESC']]);

                    $ultimaFila = $representantes->first();

                    if ($ultimaFila)
                    {
                        $ultimaFila->balance = round($ultimaFila->balance + $sobranteAcumulado, 2);
                        
                        if (!($this->Parentsandguardians->save($ultimaFila)))
                        {
                            $motivoRepresentanteNoActualizado = 'No guardado';
                        }
                        
                    }
                    else
                    {
                        $motivoRepresentanteNoActualizado = 'No encontrado';
                    }
                    if ($motivoRepresentanteNoActualizado != '')
                    {
                        $contadorRepresentantesNoActualizados++;
                        $representantesNoActualizados[] =
                            [
                                'cedula' => $cedula,
                                'nombre' => $nombreEstudiante,
                                'motivo' => $motivoRepresentanteNoActualizado
                            ];
                    }
                }
            }
        }
        $this->Flash->success(__('ContadorTransaccionesMayorCero ' . $contadorTransaccionesMayorCero)); 

        $this->set(compact('contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas', 'contadorRepresentantesNoActualizados', 'contadorMatriculasMayorTarifa', 'contadorEstudianteNoActualizado', 'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas', 'representantesNoActualizados', 'matriculasMayorTarifa', 'estudiantesNoActualizados'));

        $this->set('_serialize', ['contadorEstudiantesNoEncontrados', 'contadorMensualidadesMayorTarifa', 'contadorTransaccionesNoGuardadas', 'contadorRepresentantesNoActualizados', 'contadorMatriculasMayorTarifa', 'contadorEstudianteNoActualizado', 'estudiantesNoEncontrados', 'mensualidadesMayorTarifa', 'transaccionesNoGuardadas', 'representantesNoActualizados', 'matriculasMayorTarifa', 'estudiantesNoActualizados']);
    }

    public function agregarTransaccion($datosTransaccion = null)
    {
        $codigoRetorno = 0;

        $this->loadModel('Studenttransactions');

        $transaccionEstudiante = $this->Studenttransactions->newEntity();
        
        $transaccionEstudiante->student_id = $datosTransaccion['id_estudiante'];
        $transaccionEstudiante->payment_date = $datosTransaccion['fecha_pago'];
        $transaccionEstudiante->ano_escolar = $datosTransaccion['ano_escolar'];
        $transaccionEstudiante->transaction_type = $datosTransaccion['tipo_transaccion'];
        $transaccionEstudiante->transaction_description = $datosTransaccion['descripcion_transaccion'];
        $transaccionEstudiante->amount = $datosTransaccion['monto'];
        $transaccionEstudiante->original_amount = $datosTransaccion['monto_original'];
        $transaccionEstudiante->invoiced = 0;
        $transaccionEstudiante->paid_out = $datosTransaccion['pago_total'];
        $transaccionEstudiante->partial_payment = $datosTransaccion['pago_parcial'];
        $transaccionEstudiante->bill_number = 0;      
        $transaccionEstudiante->transaction_migration = 0;
        $transaccionEstudiante->amount_dollar = $datosTransaccion['monto_abonado'];
        $transaccionEstudiante->porcentaje_descuento = 0;
        
        if (!($this->Studenttransactions->save($transaccionEstudiante))) 
        {
           $codigoRetorno = 1;
        }
        return $codigoRetorno;
    }

    public function agregarTransaccionesInscritos()
    {
        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorTransacciones = 0;

        $this->loadModel('Students');

        foreach ($estudiantes as $estudiante)
        {
            $contadorRegistros++;
            // if ($contadorRegistros > 10)
            // {
            //    break;
            // }

            $estudianteEncontrado = 0;   
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column2);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column3);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;

            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante, 'mi_id' => $idMigracion], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();

            if ($ultimaFila)
            {
                $idEstudiante = $ultimaFila->id;

                $transaccionesCreadas = $this->crearCuotasInscritos($idEstudiante);

                $contadorTransacciones = $contadorTransacciones + $transaccionesCreadas;
            }
        }
        $this->Flash->success(__('Total transacciones agregadas ' . $contadorTransacciones));
    }

    public function agregarTransaccionesNoInscritos()
    {
        $estudiantes = $this->Binnacles->find()
        ->order(['Binnacles.extra_column2' => 'ASC', 'Binnacles.extra_column3' => 'ASC']);
 
        $contadorRegistros = 0;
        $contadorTransacciones = 0;

        $this->loadModel('Students');

        foreach ($estudiantes as $estudiante)
        {
            $contadorRegistros++;
            // if ($contadorRegistros > 10)
            // {
            //    break;
            // }

            $estudianteEncontrado = 0;   
            $idMigracion = trim($estudiante->extra_column1);
            $tipoIdentificacionEstudiante = trim($estudiante->extra_column2);
            $numeroIdentificacionEstudiante = trim($estudiante->extra_column3);
            $cedula = $tipoIdentificacionEstudiante . $numeroIdentificacionEstudiante;

            $estudiantesRegistrados = $this->Students->find('all', ['conditions' => ['type_of_identification' => $tipoIdentificacionEstudiante, 'identity_card' => $numeroIdentificacionEstudiante, 'mi_id' => $idMigracion], 'order' => ['Students.created' => 'DESC']]);
                    
            $ultimaFila = $estudiantesRegistrados->first();

            if ($ultimaFila)
            {
                $idEstudiante = $ultimaFila->id;

                $transaccionesCreadas = $this->crearCuotasNoInscritos($idEstudiante);

                $contadorTransacciones = $contadorTransacciones + $transaccionesCreadas;
            }
        }
        $this->Flash->success(__('Total registros leídos ' . $contadorRegistros));
        $this->Flash->success(__('Total transacciones agregadas ' . $contadorTransacciones));
    }

    public function crearCuotasInscritos($studentId = null)
    {
		$indicadorError = 0;
        $contadorTransacciones = 0;
		
		$this->loadModel('Schools');
        $this->loadModel('Studenttransactions');
		
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->current_year_registration;
		        
        $nextYear = $quotaYear + 1;
        
        for ($i = 1; $i <= 12; $i++) 
        {    
            $studenttransaction = $this->Studenttransactions->newEntity();
    
            $studenttransaction->student_id = $studentId;
            $studenttransaction->amount = 0;
            $studenttransaction->original_amount = 0;
            $studenttransaction->invoiced = 0;
            $studenttransaction->paid_out = 0;
            $studenttransaction->partial_payment = 0;
            $studenttransaction->bill_number = 0;
            $studenttransaction->transaction_migration = 0;
            $studenttransaction->amount_dollar = 0;
            $studenttransaction->ano_escolar = $quotaYear;
            $studenttransaction->porcentaje_descuento = 0;
        
            if ($i < 5)
            {
                $monthNumber = $i + 8;
            }
            else
            {
                $monthNumber = $i - 4;
            }
            
            $nameOfTheMonth = $this->nameMonth($monthNumber);

            $studenttransaction->transaction_type = 'Mensualidad';
                
            if ($monthNumber < 10)
            {
                $monthString = "0" . $monthNumber;
            }
            else
            {
                $monthString = (string) $monthNumber;
            }
                
            if ($monthNumber < 9)
            {
                $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;				
                $studenttransaction->payment_date = $nextYear . '-' . $monthString . '-01';						
            }
            else
            {		
                $studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;
                $studenttransaction->payment_date = $quotaYear . '-' . $monthString . '-01';
            }        

            if ($studenttransaction->payment_date != '2021-09-01')
            {
                
                if (!($this->Studenttransactions->save($studenttransaction))) 
                {
                    $indicadorError = 1;
                    $this->Flash->error(__('No se pudo agregar transaccion al estudiante con ID ' . $studentId));
                    break;
                }
                else
                {
                    $contadorTransacciones++;
                }
                
            }
        } 
        return $contadorTransacciones;   
    }

    public function crearCuotasNoInscritos($studentId = null)
    {
		$indicadorError = 0;
        $contadorTransacciones = 0;
		
		$this->loadModel('Schools');
        $this->loadModel('Studenttransactions');
				
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->current_year_registration;
		        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        $studenttransaction->transaction_type = 'Matrícula';
        $studenttransaction->transaction_description = 'Matrícula' . ' ' . $quotaYear;
        $studenttransaction->amount = 0;
        $studenttransaction->original_amount = 0;
        $studenttransaction->invoiced = 0;
        $studenttransaction->paid_out = 0;
        $studenttransaction->partial_payment = 0;
        $studenttransaction->bill_number = 0;
        $studenttransaction->payment_date = 0;
        $studenttransaction->transaction_migration = 0;
		$studenttransaction->amount_dollar = 0;
		$studenttransaction->ano_escolar = $quotaYear;
		$studenttransaction->porcentaje_descuento = 0;
		
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
            $indicadorError = 1;
            $this->Flash->error(__('No se pudo agregar matrícula al estudiante con ID ' . $studentId));
		}
        else
        {
            $contadorTransacciones++;
        }
		
		if ($indicadorError == 0)
		{				
			for ($i = 1; $i <= 12; $i++) 
			{    
				$studenttransaction = $this->Studenttransactions->newEntity();
		
				$studenttransaction->student_id = $studentId;
				$studenttransaction->amount = 0;
				$studenttransaction->original_amount = 0;
				$studenttransaction->invoiced = 0;
				$studenttransaction->paid_out = 0;
				$studenttransaction->partial_payment = 0;
				$studenttransaction->bill_number = 0;
				$studenttransaction->transaction_migration = 0;
				$studenttransaction->amount_dollar = 0;
				$studenttransaction->ano_escolar = $quotaYear;
				$studenttransaction->porcentaje_descuento = 0;
           
				if ($i < 5)
				{
					$monthNumber = $i + 8;
				}
				else
				{
					$monthNumber = $i - 4;
				}
				
				$nameOfTheMonth = $this->nameMonth($monthNumber);
	
				$studenttransaction->transaction_type = 'Mensualidad';
					
				if ($monthNumber < 10)
				{
					$monthString = "0" . $monthNumber;
				}
				else
				{
					$monthString = (string) $monthNumber;
				}
					
				if ($monthNumber < 9)
				{
					$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $nextYear;				
					$studenttransaction->payment_date = $nextYear . '-' . $monthString . '-01';						
				}
				else
				{		
					$studenttransaction->transaction_description = $nameOfTheMonth . ' ' . $quotaYear;
					$studenttransaction->payment_date = $quotaYear . '-' . $monthString . '-01';
				}        
				
                if (!($this->Studenttransactions->save($studenttransaction))) 
                {
                    $indicadorError = 1;
                    $this->Flash->error(__('No se pudo agregar transaccion al estudiante con ID ' . $studentId));
                    break;
                }
                else
                { 
                    $contadorTransacciones++;
                }
			}    
        }
        return $contadorTransacciones;
    }
    function nameMonth($monthNumber = null)
    {
        if ($monthNumber < 10)
        {
            $monthString = "0" . $monthNumber;
        }
        else
        {
        $monthString = (string) $monthNumber;
        }
        $monthsSpanish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $monthsEnglish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $monthString);
        return $spanishMonth;
    }
}