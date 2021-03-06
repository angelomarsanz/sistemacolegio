<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\ParentsandguardiansController;

use App\Controller\StudenttransactionsController;

use App\Controller\BinnaclesController;

use Cake\I18n\Time;

use Cake\ORM\TableRegistry;

/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 */
class StudentsController extends AppController
{
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Representante')
			{
				if(in_array($this->request->action, ['index', 'view', 'edit', 'filepdf', 'profilePhoto', 'editPhoto']))
				{
					return true;
				}
			}
			if ($user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['familyStudents', 'reportFamilyStudents', 'familiasDescuento20', 'familiasDescuento50', 'consultStudent', 'viewStudent', 'edit', 'editStatus', 'reporteBecados', 'reportGraduateStudents', 'consultStudentDelete', 'indexConsult', 'viewConsult', 'filepdf', 'findStudent', 'findStudentDelete']))
				{
					return true;
				}				
			}
        }
				
        return parent::isAuthorized($user);
    }
    
    public function testFunction()
    {	
		/*
		$this->log("Something didn't work!"); 
		$mesesTarifas = $this->mesesTarifas(0);

		$otrasTarifas = $this->otrasTarifas(0);

		$this->set(compact('mesesTarifas', 'otrasTarifas'));
        $this->set('_serialize', ['mesesTarifas', 'otrasTarifas']);
		
		$this->loadModel('Studenttransactions');
		*/

		$this->loadModel('Studenttransactions');

		$estudiantes = $this->Students->find('all')->where(['Students.id >' => 1, 'Students.student_condition' => 'Regular', 'Students.balance <' => '2021', 'Students.discount >' => 0]);

		$contadorEstudiantes = $estudiantes->count();

		$this->Flash->success(__('Estudiantes no inscritos en el 2021 ' . $contadorEstudiantes));

		if ($contadorEstudiantes > 0)
		{
			foreach ($estudiantes as $estudiante)
			{
				$transaccionesEstudiante = $this->Studenttransactions->find('all')->where(['student_id' => $estudiante->id, 'transaction_description' => 'Sep 2021', 'amount_dollar >' => 0]);

				$contadorTransacciones = $transaccionesEstudiante->count();

				if ($contadorTransacciones > 0)
				{
					foreach ($transaccionesEstudiante as $transaccion)
					{
						$this->Flash->success(__('id Estudiante que pag?? matr??cula 2021 ' . $transaccion->student_id));
					}
				}
			}
		}
    }
	
    public function testFunction2()
    {
		$this->loadModel('Studenttransactions');

		$contadorEstudiantesSinSeptiembre = 0;
		$contadorEliminadas = 0;

		$estudiantes = $this->Students->find('all')->where(['Students.id >' => 1, 'Students.balance' => '2021']);

		$contadorEstudiantes = $estudiantes->count();

		$this->Flash->success(__('Estudiantes inscritos 2021 ' . $contadorEstudiantes));

		if ($contadorEstudiantes > 0)
		{
			foreach ($estudiantes as $estudiante)
			{
				$transaccionesEstudiante = $this->Studenttransactions->find('all')->where(['student_id' => $estudiante->id, 'transaction_type' => 'Mensualidad', 'ano_escolar' => '2021']);

				$contadorTransacciones = $transaccionesEstudiante->count();

				if ($contadorTransacciones > 0)
				{
					$septiembreEncontrado = 0;

					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->transaction_description == 'Sep 2021')
						{
							$septiembreEncontrado = 1;
							break;
						}
					}

					if ($septiembreEncontrado == 0)
					{
						foreach ($transaccionesEstudiante as $transaccion)
						{
							if (!($this->Studenttransactions->delete($transaccion)))
							{
								$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser eliminada'));
							}				
							else
							{ 
								$contadorEliminadas++;
							}
						}
						$this->Flash->success(__('Id del Estudiante al que se le eliminaron la transacciones  ' . $estudiante->id));
						$contadorEstudiantesSinSeptiembre++;
						// if ($contadorEstudiantesSinSeptiembre == 1)
						// {
						//  break;
						// }
					}
				}
			}
		}
		$this->Flash->success(__('Estudiantes sin septiembre ' . $contadorEstudiantesSinSeptiembre));
		$this->Flash->success(__('Total transacciones eliminadas ' . $contadorEliminadas));

		/*
		$this->loadModel('Studenttransactions');

		$contadorEstudiantes = 0;
		$contadorTransacciones = 0;
		$contadorActualizadas = 0;
		$contadorNoActualizadas = 0;
		$septiembreEncontrado = 0;
		$indicadorPrimeraTransaccion = 0;
		$contadorInsertadas = 0;
		$contadorNoInsertadas = 0;
		$contadorEstudiantesActualizado = 0;

		$estudiantes = $this->Students->find('all')->where(['Students.id >' => 1, 'Students.balance' => '2021']);

		$contadorEstudiantes = $estudiantes->count();

		$this->Flash->success(__('Estudiantes inscritos 2021 ' . $contadorEstudiantes));

		if ($contadorEstudiantes > 0)
		{
			foreach ($estudiantes as $estudiante)
			{
				if ($contadorEstudiantesActualizado == 4)
				{
					break;
				}

				$transaccionesEstudiante = $this->Studenttransactions->find('all')->where(['student_id' => $estudiante->id, 'transaction_type' => 'Mensualidad', 'ano_escolar' => '2021']);

				$contadorTransacciones = $estudiantes->count();

				if ($contadorTransacciones > 0)
				{
					$septiembreEncontrado = 0;

					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->transaction_description == 'Sep 2021')
						{
							$septiembreEncontrado = 1;
							break;
						}
					}

					if ($septiembreEncontrado == 0)
					{
						$indicadorPrimeraTransaccion = 0;
						foreach ($transaccionesEstudiante as $transaccion)
						{
							if ($indicadorPrimeraTransaccion == 0)
							{							
								$indicadorPrimeraTransaccion = 1;	
								$transaccionPendiente = $transaccion;

								$transaccion->student_id = $estudiante->id;
								$transaccion->payment_date = '2021-09-01';
								$transaccion->ano_escolar = '2021';
								$transaccion->transaction_type = 'Mensualidad';
								$transaccion->transaction_description = 'Sep 2021';
								$transaccion->amount = 0;
								$transaccion->original_amount = 0;
								$transaccion->invoiced = 0;
								$transaccion->partial_payment = 0;
								$transaccion->paid_out = 0;
								$transaccion->bill_number = 0;      
								$transaccion->transaction_migration = 0;
								$transaccion->amount_dollar = 0;
								$transaccion->porcentaje_descuento = 0;
							}								
							else
							{
								if (isset($transacctionActual))
								{
									unset($transaccionActual);
								}
								$transaccionActual = $transaccion;

								$transaccion->student_id = $transaccionPendiente->student_id;
								$transaccion->payment_date = $transaccionPendiente->payment_date;
								$transaccion->ano_escolar = $transaccionPendiente->ano_escolar;
								$transaccion->transaction_type = $transaccionPendiente->transaction_type;
								$transaccion->transaction_description = $transaccionPendiente->transaction_description;
								$transaccion->amount = $transaccionPendiente->amount;
								$transaccion->original_amount = $transaccionPendiente->original_amount;
								$transaccion->invoiced = $transaccionPendiente->invoiced;
								$transaccion->partial_payment = $transaccionPendiente->partial_payment;
								$transaccion->paid_out = $transaccionPendiente->paid_out;
								$transaccion->bill_number = $transaccionPendiente->bill_number;      
								$transaccion->transaction_migration = $transaccionPendiente->transaction_migration;
								$transaccion->amount_dollar = $transaccionPendiente->amount_dollar;
								$transaccion->porcentaje_descuento = $transaccionPendiente->porcentaje_descuento;

								unset($transaccionPendiente);
								$transaccionPendiente = $transaccionActual;
							}
							if (!($this->Studenttransactions->save($transaccion)))
							{
								$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
								$contadorNoActualizadas++;
							}				
							else
							{
								$contadorActualizadas++;
							}
						}
						$nuevaTransaccion = $this->Studenttransactions->newEntity();

						$nuevaTransaccion->student_id = $transaccionPendiente->student_id;
						$nuevaTransaccion->payment_date = $transaccionPendiente->payment_date;
						$nuevaTransaccion->ano_escolar = $transaccionPendiente->ano_escolar;
						$nuevaTransaccion->transaction_type = $transaccionPendiente->transaction_type;
						$nuevaTransaccion->transaction_description = $transaccionPendiente->transaction_description;
						$nuevaTransaccion->amount = $transaccionPendiente->amount;
						$nuevaTransaccion->original_amount = $transaccionPendiente->original_amount;
						$nuevaTransaccion->invoiced = $transaccionPendiente->invoiced;
						$nuevaTransaccion->partial_payment = $transaccionPendiente->partial_payment;
						$nuevaTransaccion->paid_out = $transaccionPendiente->paid_out;
						$nuevaTransaccion->bill_number = $transaccionPendiente->bill_number;      
						$nuevaTransaccion->transaction_migration = $transaccionPendiente->transaction_migration;
						$nuevaTransaccion->amount_dollar = $transaccionPendiente->amount_dollar;
						$nuevaTransaccion->porcentaje_descuento = $transaccionPendiente->porcentaje_descuento;

						if (!($this->Studenttransactions->save($nuevaTransaccion)))
						{
							$this->Flash->error(__('La transacci??n no pudo ser insertada'));
							$contadorNoInsertadas++;
						}				
						else
						{
							$contadorInsertadas++;
						}
						$this->Flash->success(__('Id estudiante actualizado ' . $estudiante->id));	
						$contadorEstudiantesActualizado++;	
					}
				}
			}
		}

		$this->Flash->success(__('Total transacciones actualizadas ' . $contadorActualizadas));
		$this->Flash->success(__('Total transacciones no actualizadas ' . $contadorNoActualizadas));
		$this->Flash->success(__('Total transacciones insertadas ' . $contadorInsertadas));
		$this->Flash->success(__('Total transacciones no insertadas ' . $contadorNoInsertadas));
 
		$this->loadModel('Studenttransactions');

		$contadorEliminadas = 0;

		$estudiantes5to = $this->Students->find('all')->where(['Students.id >' => 1, 'Students.level_of_study' => '', 'Students.section_id' => 41]);

		$contadorEstudiantes5to = $estudiantes5to->count();

		if ($contadorEstudiantes5to > 0)
		{
			foreach ($estudiantes5to as $estudiante)
			{
				$transaccionesEstudiante = $this->Studenttransactions->find('all')->where(['student_id' => $estudiante->id]);

				foreach ($transaccionesEstudiante as $transaccion)
				{
					if ($transaccion->ano_escolar == 2021)
					{
						if (!($this->Studenttransactions->delete($transaccion)))
						{
							$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser eliminada'));
						}				
						else
						{ 
							$contadorEliminadas++;
						}
					}
				}
			}
		}

		$this->Flash->success(__('Estudiantes de 5to. A??o egresados ' . $contadorEstudiantes5to));
		$this->Flash->success(__('Transacciones eliminadas ' . $contadorEliminadas));
		
		$nivelEstudio = 
			[
				'Pre-escolar, pre-kinder',                                
				'Pre-escolar, kinder',
				'Pre-escolar, preparatorio',
				'Primaria, 1er. grado',
				'Primaria, 2do. grado',
				'Primaria, 3er. grado',
				'Primaria, 4to. grado',
				'Primaria, 5to. grado',
				'Primaria, 6to. grado',
				'Secundaria, 1er. a??o',
				'Secundaria, 2do. a??o',
				'Secundaria, 3er. a??o',
				'Secundaria, 4to. a??o',
				'Secundaria, 5to. a??o'
			];

		$nivelBuscado = 'Secundaria, 1er. a??o';
		if (substr($nivelBuscado, 0, 8) == 'Primaria')
		{
			$nivelEstudioActual = 'primaria';
		}
		else
		{
			$nivelEstudioActual = 'secundaria';
		}
		$nivelEstudioPasado = '';
		$nivelEstudioAntepasado = '';

		foreach ($nivelEstudio as $indice => $valor)
		{
			if ($valor == $nivelBuscado)
			{
				if ($indice > 3)
				{
					if (substr($nivelEstudio[$indice - 1], 0, 8) == 'Primaria')
					{
						$nivelEstudioPasado = 'primaria';
					}
					else
					{
						$nivelEstudioPasado = 'secundaria';
					}
				}
				if ($indice > 4)
				{
					if (substr($nivelEstudio[$indice - 2], 0, 8) == 'Primaria')
					{
						$nivelEstudioAntepasado = 'primaria';
					}
					else
					{
						$nivelEstudioAntepasado = 'secundaria';
					}
				}
				break;
			}
		}
		$this->Flash->success(__('Nivel de estudio actual ' . $nivelEstudioActual));
		$this->Flash->success(__('Nivel de estudio pasado ' . $nivelEstudioPasado));
		$this->Flash->success(__('Nivel de estudio antepasado ' . $nivelEstudioAntepasado));
		
		$estudiantes = $this->Students->find('all')->where(['Students.id >' => 1]);

		$contadorEstudiantes = $estudiantes->count();

		$this->Flash->success(__('Total estudiantes encontrados ' . $contadorEstudiantes));

        foreach ($estudiantes as $estudiante) 
        {
			$estudiante->balance = 2020;
			$estudiante->number_of_brothers = 2019;
			if (!($this->Students->save($estudiante))) 
			{
				$this->Flash->error(__('Id Estudiante no guardado ' . $estudiante->id));
			}
		}

		$this->loadModel('Studenttransactions');

		$contadorActualizadas = 0;
		$contadorNoActualizadas = 0;

		$estudiantesBecados = $this->Students->find('all')->where(['Students.id >' => 1, 'Students.discount >' => 0]);

		$contadorEstudiantesBecados = $estudiantesBecados->count();

		$this->Flash->success(__('Total estudiantes becados ' . $contadorEstudiantesBecados));

		if ($contadorEstudiantesBecados > 0)
		{
			foreach ($estudiantesBecados as $becado)
			{
				$transaccionesBecado = $this->Studenttransactions->find('all')->where(['student_id' => $becado->id, 'transaction_description' => 'Sep 2021', 'paid_out' => 1]);

				$contadorTransaccionesBecado = $transaccionesBecado->count();

				if ($contadorTransaccionesBecado > 0)
				{
					foreach ($transaccionesBecado as $transaccion)
					{
						$transaccion->porcentaje_descuento = $becado->discount;
						if ($this->Studenttransactions->save($transaccion)) 
						{
							$contadorActualizadas++;
							$this->Flash->success(__('Transacci??n con ID ' . $transaccion->id . ' fue actualizada'));
						} 
						else 
						{
							$contadorNoActualizadas;
						}
					}
				}
			}
		}
		else
		{
			$this->Flash->error(__('No se consiguieron alumnos becados'));
		}
		$this->Flash->success(__('Total transacciones actualizadas ' . $contadorActualizadas));
		$this->Flash->success(__('Total transacciones no actualizadas ' . $contadorNoActualizadas));
		*/
    }
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    
	public function index()
    {
		$family = '';
        if($this->Auth->user('role') == 'Representante')
        {
            $parentsandguardians = $this->Students->Parentsandguardians->find('all')
                ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')]);

            $resultParentsandguardians = $parentsandguardians->toArray();
            
            $family = $resultParentsandguardians[0]['family'];

            if ($resultParentsandguardians) 
            {
                $query = $this->Students->find('all')->where([['parentsandguardian_id' => $resultParentsandguardians[0]['id']], ['Students.student_condition' => 'Regular'],
					['Students.section_id <' => 41]]);
                $this->set('students', $this->paginate($query));
            }           
        }
        else
        {
			$query = $this->Students->find('all')->where([['Students.student_condition' => 'Regular'],
			['Students.section_id <' => 41]])->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);;
			$this->set('students', $this->paginate($query));
        }

        $this->set(compact('family'));
        $this->set('_serialize', ['students', 'family']);
    }

    public function indexAdmin($idFamily = null)
    {
        if ($this->request->is('post'))
        {
            $query = $this->Students->find('all')->where(['parentsandguardian_id' => $_POST['idFamily']]);
            $idFamilyP = $_POST['idFamily'];
        }    
        else
        {
            $query = $this->Students->find('all')->where(['parentsandguardian_id' => $idFamily]);
            $idFamilyP = $idFamily;
        }
            
        $this->set('students', $this->paginate($query));

        $this->set(compact('students', 'idFamilyP'));
        $this->set('_serialize', ['students', 'idFamilyp']);
    }

    public function indexConsult($idFamily = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);

        $this->set('students', $this->paginate($query));

        $this->set(compact('idFamily', 'family'));
        $this->set('_serialize', ['students', 'idFamily', 'family']);
    }

    public function previousCardboard()
    {
        if ($this->request->is('post')) 
        {
            $idFamily = $_POST['idFamily'];
            $family = $_POST['family'];

            return $this->redirect(['action' => 'indexCardboard', $idFamily, $family]);
        }
    }

    public function indexCardboard($idFamily = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            
        $this->set('students', $this->paginate($query));
            
        $this->set(compact('students', 'idFamily', 'family'));
        $this->set('_serialize', ['students', 'idFamily', 'family']);
    }

    public function indexCardboardInscription($billNumber = null, $idParentsandguardian = null, $family = null)
    {
        $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idParentsandguardian], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
        
        $this->set('students', $this->paginate($query));
        
        $this->set(compact('students', 'billNumber', 'idParentsandguardian', 'family'));
        $this->set('_serialize', ['students', 'billNumber', 'idParentsandguardian', 'family']);
    }

    public function indexAdminb($idFamily = null)
    {
        if ($this->request->is('post'))
        {
            $query = $this->Students->find('all')->where([['parentsandguardian_id' => $_POST['idFamily']], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            $idFamilyP = $_POST['idFamily'];
        }    
        else
        {
            $query = $this->Students->find('all')->where([['parentsandguardian_id' => $idFamily], ['OR' => [['Students.student_condition' => 'Regular'], ['Students.student_condition like' => 'Alumno nuevo%']]]]);
            $idFamilyP = $idFamily;
        }
            
        $this->set('students', $this->paginate($query));

        $this->set(compact('idFamilyP'));
        $this->set('_serialize', ['students', 'idFamilyp']);
    }

    /**
     * View method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection'));
        $this->set('_serialize', ['student', 'assignedSection']);
    }
 
    public function viewAdminb($id = null, $idFamilyP = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection', 'idFamilyP'));
        $this->set('_serialize', ['student', 'assignedSection', 'idFamilyP']);
    }

    public function viewConsult($id = null, $idFamily = null, $family = null, $controller = null, $action = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Users', 'Parentsandguardians']
        ]);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'idFamily', 'family', 'assignedSection', 'controller', 'action'));
        $this->set('_serialize', ['student', 'idFamily', 'family', 'assignedSection', 'controller', 'action']);
    }

    public function viewStudent($id = null)
    {
        if ($this->request->is('post')) 
        {
            $id = $_POST['idStudent'];
        }
            
        $student = $this->Students->get($id);
        
        $section = $this->Students->Sections->get($student->section_id);
        
        $assignedSection = $section->sublevel . ' ' . $section->section;

        $this->set(compact('student', 'assignedSection'));
        $this->set('_serialize', ['student', 'assignedSection']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($userName = null)
    {
        $users = $this->Students->Users->find('all')
            ->where(['Users.username =' => $userName]);

        $resultUsers = $users->toArray();
        
        $parentsandguardians = $this->Students->Parentsandguardians->find('all')
            ->where(['Parentsandguardians.user_id =' => $this->Auth->user('id')]);

        $resultParentsandguardians = $parentsandguardians->toArray();

        if (!$resultParentsandguardians) 
        {
            $this->Flash->error(__('Por favor primero complete el perfil del representante y luego agregue el alumno'));
            return $this->redirect(['controller' => 'Parentsandguardians', 'action' => 'add']);
        }
        else  
        {
            $student = $this->Students->newEntity();
            if ($this->request->is('post')) 
            {
                $student = $this->Students->patchEntity($student, $this->request->data);
    
                $student->user_id = $resultUsers[0]['id'];
                $student->parentsandguardian_id = $resultParentsandguardians[0]['id'];
                $student->code_for_user = '';
                $student->first_name = $resultUsers[0]['first_name'];
                $student->second_name = $resultUsers[0]['second_name'];
                $student->surname = $resultUsers[0]['surname'];
                $student->second_surname = $resultUsers[0]['second_surname'];
                $student->sex = $resultUsers[0]['sex'];
                $student->school_card = '';
                $student->profile_photo = $resultUsers[0]['profile_photo'];
                $student->profile_photo_dir = $resultUsers[0]['profile_photo_dir'];
                $student->cell_phone = $resultUsers[0]['cell_phone'];
                $student->email = $resultUsers[0]['email'];
                $student->student_condition = "Regular";
                $student->section_id = 1;
                $student->scholarship = 0;
                $student->balance = 0;
                $student->creative_user = $this->Auth->user('username');
                $student->student_migration = false;
                $student->mi_id = 0;
                $student->new_student = true;

                if ($this->Students->save($student)) 
                {
                    $this->Flash->success(__('Los datos de su hijo o representado fueron guardados'));
    
                    return $this->redirect(['action' => 'index']);
                } 
                else 
                {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
                }
            }
        }
        $this->set(compact('student', 'users', 'resultParentsandguardians'));
        $this->set('_serialize', ['student']);
    }
    
    public function addAdminp()
    {
        $this->autoRender = false;
        
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'addAdmin', $_POST['idFamily']]);
        }
    }

    public function addAdminpb()
    {
        $this->autoRender = false;
        
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'addAdminb', $_POST['idFamily']]);
        }
    }

    public function addAdmin($idParentsandguardians = null)
    {
        $studentTransactions = new StudenttransactionsController();
		$indicadorError = 0;
        
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
    
            $student->user_id = 3;
            $student->parentsandguardian_id = $idParentsandguardians;
            $student->code_for_user = " ";
            $student->school_card = " ";
            $student->profile_photo = "";
            $student->profile_photo_dir = "";
            $student->section_id = 1;
            $student->student_condition = "Regular";
            $student->scholarship = 0;
            $student->balance = 0;
            $student->creative_user = $this->Auth->user('username');
            $student->student_migration = 0;
            $student->mi_id = 0;
            $student->new_student = 1;
            
            if ($this->Students->save($student)) 
            {
                $lastRecord = $this->Students->find('all', ['conditions' => ['creative_user' => $this->Auth->user('username')],
                'order' => ['Students.created' => 'DESC'] ]);

                $row = $lastRecord->first();
                
                $this->Flash->success(__('El alumno fue guardado exitosamente'));
                
                $indicadorError = $studentTransactions->createQuotasNew($row->id);
				
				if ($indicadorError == 0)
				{
					return $this->redirect(['action' => 'indexAdmin', $idParentsandguardians]);
				}
				else
				{
					$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
				}
            } 
            else 
            {
                $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($idParentsandguardians);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    public function addAdminb($idParentsandguardians = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
		$indicadorError = 0;
		
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$lastYear = $currentDate->year - 1;
		$nextYear = $currentDate->year + 1;
		
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $studentTransactions = new StudenttransactionsController();

            $student = $this->Students->patchEntity($student, $this->request->data);

			$lastRecord = $this->Students->find('all', ['conditions' => ['type_of_identification' => $student->type_of_identification, 'identity_card' => $student->identity_card],
			'order' => ['Students.created' => 'DESC'] ]);

			$row = $lastRecord->first();

			if ($row)
			{
				$this->Flash->error(__('Ya existe otro estudiante con el mismo n??mero de documento de identidad ' . $student->type_of_identification . $student->identity_card));
			}
			else
			{
				$student->user_id = 3;
				$student->parentsandguardian_id = $idParentsandguardians;
				$student->second_surname = "";
				$student->second_name = "";
				$student->sex = "";
				$student->nationality = "";
				$student->place_of_birth = "";
				$student->country_of_birth = "";
				$student->birthdate = Time::now();
				$student->cell_phone = "";
				$student->email = "";
				$student->address = "";
				$student->family_bond_guardian_student = "";
				$student->first_name_father = "";
				$student->second_name_father = "";
				$student->surname_father = "";
				$student->second_surname_father = "";
				$student->first_name_mother = "";
				$student->second_name_mother = "";
				$student->surname_mother = "";
				$student->second_surname_mother = "";
				$student->brothers_in_school = false;
				$student->previous_school = "";
				$student->student_illnesses = "";
				$student->observations = "";
				$student->code_for_user = "";
				$student->school_card = "";
				$student->profile_photo = "";
				$student->profile_photo_dir = "";

				$nivel = $student->level_of_study; 
                        
				$grado = $studentTransactions->levelSublevel($nivel); 
				
				$secciones = $this->Students->Sections->find('all')
					->where(['sublevel' => $grado, 'section' => 'A'])
					->order(['id' => 'DESC']);
		
				$seccion = $secciones->first();

				if ($seccion)
				{ 
					$student->section_id = $seccion->id;
				}
				else
				{
					$student->section_id = 1;
				}

				$student->student_condition = "Regular";
				$student->scholarship = 0;
				$student->creative_user = $this->Auth->user('username');
				$student->student_migration = 0;
				$student->mi_id = 0;

				$incomeType = $student->number_of_brothers;

				$student->number_of_brothers = 0;

				$student->balance = 0;			

				
				if ($incomeType < 2)
				{
					$student->new_student = 1;
				}
				else
				{
					$student->new_student = 0;		
				}

				if ($student->tipo_descuento == null)
				{
					$student->discount = 0; 
				}
					
				if ($this->Students->save($student)) 
				{
					$lastRecord = $this->Students->find('all', ['conditions' => ['creative_user' => $this->Auth->user('username')],
					'order' => ['Students.created' => 'DESC'] ]);

					$row = $lastRecord->first();

					if ($row)
					{
						$this->Flash->success(__('El alumno fue guardado exitosamente'));

						
						if ($incomeType == 0)
						{
							$indicadorError = $studentTransactions->createQuotasNew($row->id, $lastYear);
						}
						elseif ($incomeType == 1)
						{
							$indicadorError = $studentTransactions->createQuotasNew($row->id, $currentYear);
						}
						else
						{
							$indicadorError = $studentTransactions->createQuotasRegular($row->id);	
						}					
						
						if ($indicadorError == 0)
						{
							return $this->redirect(['action' => 'indexAdminb', $idParentsandguardians]);
						}
						else
						{
							$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
						}
					}
				} 
				$this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
			}
        }
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($idParentsandguardians);

        $this->set(compact('student', 'currentYear', 'nextYear', 'lastYear', 'idParentsandguardians'));
        $this->set('_serialize', ['student']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
 
    public function edit($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
		$indicadorError = 0;
		
		$indicadorJulioPendiente = 0;
		
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$lastYear = $currentDate->year - 1;
		$nextYear = $currentDate->year + 1;
		
		$this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
	    $families = $this->Students->Parentsandguardians->find('list', ['keyField' => 'id', 'valueField' => 'family'])
						->where(['id' > 1, 'family !=' => ''])
						->order(['family' => 'ASC']);
	
        $studentTransactions = new StudenttransactionsController();

        $student = $this->Students->get($id);
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);
		
        $sections = $this->Students->Sections->find('list', ['limit' => 200]);
				
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            
            $student->brothers_in_school = 0;
		            
            if ($this->Students->save($student)) 
            {
				if ($student->new_student == 0)
				{	
					$transactionDescription = 'Matr??cula ' . $school->current_year_registration;
			
					$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);

					$results = $studentTransaction->toArray();

					if (!($results))
					{
						$indicadorError = $studentTransactions->createQuotasRegular($student->id);
					}
				}
				else
				{
					$transactionDescription = 'Matr??cula ' . $school->current_year_registration;
			
					$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);

					$results = $studentTransaction->toArray();

					if (!($results))
					{
						$transactionDescription = 'Matr??cula ' . $school->next_year_registration;
			
						$studentTransaction = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription]);
	
						$results = $studentTransaction->toArray();
	
						if (!($results))
						{
							$indicadorError = $studentTransactions->createQuotasNew($student->id, $school->current_year_registration);
						}
					}					
				}
				
				if ($indicadorError == 0)
				{
					$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
					if (isset($controller))
					{
						return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
					}
					else
					{
						return $this->redirect(['action' => 'editPhoto', $id]);
					}
				}
				else
				{
					$this->Flash->error(__('No se pudieron generar las cuotas del estudiante'));
				}
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }
		else
		{
			if ($student->scholarship == false)
			{
				$transactionDescription = 'Jul ' . $school->current_year_registration;
					
				$busquedaJulioAnoAnterior = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'transaction_description' => $transactionDescription])->order(['id' => 'DESC']);

				$contadorRegistrosJulio = $busquedaJulioAnoAnterior->count();
				
				if ($contadorRegistrosJulio > 0)
				{				
					$registroJulio = $busquedaJulioAnoAnterior->first();
					
					$concept = 'Mensualidad';
					
					$this->loadModel('Rates');
			
					$busquedaMensualidad = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
					'order' => ['Rates.created' => 'DESC'] ]);

					$registroMensualidad = $busquedaMensualidad->first();

					if ($registroJulio->amount_dollar < $registroMensualidad->amount)
					{
						$indicadorJulioPendiente = 1;			
					}
				}
			}
		}

        $this->set(compact('student', 'parentsandguardian', 'currentYear', 'lastYear', 'nextYear', 'sections', 'families', 'indicadorJulioPendiente'));
        $this->set('_serialize', ['student', 'parentsandguardian', 'sections', 'families', 'indicadorJulioPendiente']);
    }
    
    public function reasignFamily($id = null, $controller = null, $action = null)
    {		
	    $families = $this->Students->Parentsandguardians->find('list', ['keyField' => 'id', 'valueField' => 'family'])
						->where(['id' > 1, 'family !=' => ''])
						->order(['family' => 'ASC']);
	
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            	            
            if ($this->Students->save($student)) 
            {		
				$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }    
        $this->set(compact('student', 'families'));
        $this->set('_serialize', ['student', 'families']);
    }
	
    public function reasignFamilyInt($id = null, $controller = null, $action = null)
    {				
		$student = $this->Students->get($id);
		
		$parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);
		
		if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            	            
            if ($this->Students->save($student)) 
            {		
				$this->Flash->success(__('Los datos se actualizaron exitosamente'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
            }
            else 
            {
                $this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
            }
        }    
        $this->set(compact('student', 'parentsandguardian'));
        $this->set('_serialize', ['student', 'parentsandguardian']);
    }
	
    public function editPhoto($id = null)
    {
        $student = $this->Students->get($id);
        
        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
			$student = $this->Students->patchEntity($student, $this->request->data);

			$archivoFoto = $student->profile_photo;
			
			if (isset($archivoFoto['name']))
			{
				$extensiones_permitidas = array('jpg', 'jpeg', 'gif', 'png');
				$extensionFoto = substr(strtolower(strrchr($archivoFoto['name'], '.')), 1);
				
				if ($extensionFoto != false)
				{						
					if (in_array($extensionFoto, $extensiones_permitidas))
					{
						if ($this->Students->save($student)) 
						{
							$this->Flash->success(__('La foto fue guardada exitosamente'));
							return $this->redirect(['action' => 'index']);
						}
						else 
						{
							$this->Flash->error(__('Los datos del alumno no se actualizaron, por favor verifique los datos e intente nuevamente'));
						}
					}
					else
					{
						$this->Flash->error(__('Estimado representante la foto debe tener alguna de estas extensiones: jpg, jpeg, gif o png'));
					}
				}
				else
				{
					$this->Flash->error(__('Estimado representante la foto debe tener alguna de estas extensiones: jpg, jpeg, gif o png'));
				}
			}
			else
			{
				$this->Flash->error(__('Estimado representante debe subir un archivo con alguna de estas extensiones: jpg, jpeg, gif o png'));
			}
        }    
        $this->set(compact('student', 'parentsandguardian'));
        $this->set('_serialize', ['student', 'parentsandguardian']);
    }

    
    public function editAdmin($idStudent = null, $idParentsandguardians = null)
    {
        $student = $this->Students->get($idStudent);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            $student->user_id = 3;
            $student->code_for_user = " ";
            $student->school_card = " ";
            $student->profile_photo = "";
            $student->profile_photo_dir = "";
            $student->section_id = 1;
            $student->student_condition = "Regular";
            $student->scholarship = 0;
            $student->balance = 0;
            $student->creative_user = $this->Auth->user('username');

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('El alumno fue guardado exitosamente'));

                return $this->redirect(['action' => 'indexAdmin', $idParentsandguardians]);
            } 
            else 
            {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }

        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    public function editAdminb($idStudent = null, $idParentsandguardians = null)
    {
        $student = $this->Students->get($idStudent);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('El alumno fue guardado exitosamente'));

                return $this->redirect(['action' => 'indexAdminb', $idParentsandguardians]);
            } 
            else 
            {
                    $this->Flash->error(__('El alumno no fue guardado, por favor verifique los datos e intente nuevamente'));
            }
        }

        $parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);

        $this->set(compact('student', 'users', 'parentsandguardian'));
        $this->set('_serialize', ['student']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Student id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Students->get($id);

        $id = $student->user_id;

        if ($this->Students->delete($student)) 
        {
            $this->Flash->success(__('El alumno ha sido borrado'));

            $user = $this->Students->Users->get($id);

            if ($this->Students->Users->delete($user)) 
            {
                $this->Flash->success(__('Los datos de usuario del alumno han sido borrados'));
            } 
            else 
            {
                $this->Flash->error(__('Los datos de usuario del alumno no pudieron ser borrados, por favor intente nuevamente '));
            }
        } 
        else 
        {
            $this->Flash->error(__('El alumno no pudo ser borrado, por favor intente nuevamente'));  
        }
        return $this->redirect(['action' => 'index']);
    }

    public function guardian()
    {
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);

            if ($student->parentsandguardian_id == null) 
                $this->Flash->error(__('No existe el representante'));
            else    
                return $this->redirect(['controller' => 'Students',   'action' => 'payments', $student->parentsandguardian_id, 'Inscripci??n']);
        }
        
        $this->set(compact('student'));

        $this->set('_serialize', ['student']);
    }

    public function monthlyPayment()
    {
    }

    public function payments($parentId = null, $description = null)
    {
        $parentsandguardian = $this->Students->Parentsandguardians->get($parentId);
        $balance = $parentsandguardian->balance;
        $query = $this->Students->find('all')->where(['parentsandguardian_id' => $parentId]);
        $this->set('students', $this->paginate($query));

        $this->set(compact('students', 'description', 'balance'));
        $this->set('_serialize', ['students']);
    }
    public function searchScholarship()
    {

    }
    public function enableScholarship($idParent = null)
    {
        if ($this->request->is('post'))
        {
            if (isset($_POST['idParent']))
            {
                $idParent = $_POST['idParent'];
            }
        }
        
        $query = $this->Students->find('all')
            ->where(['parentsandguardian_id' => $idParent])
            ->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

        $this->set('students', $this->paginate($query));

        $this->set(compact('students'));
        $this->set('_serialize', ['students']);
    }
    public function studentScholarship($studentId = null, $parentId = null)
    {
        $this->autoRender = false;

        $student = $this->Students->get($studentId, [
            'contain' => []
        ]);

        $student->scholarship = 1;
		$student->tipo_descuento = "Becado";
		$student->discount = 100;
        
        if ($this->Students->save($student)) 
        {
            $this->Flash->success(__('El alumno fue becado exitosamente'));

            return $this->redirect(['action' => 'enableScholarship', $parentId]);
        }
        else 
        {
            $this->Flash->error(__('El alumno no pudo ser becado, por favor intente nuevamente'));
        }
    }    

    public function deleteScholarship($studentId = null, $parentId = null)
    {
        $this->autoRender = false;

        $student = $this->Students->get($studentId, [
            'contain' => []
        ]);

        $student->scholarship = 0;
		$student->tipo_descuento = "";
		$student->discount = 0;
        
        if ($this->Students->save($student)) 
        {
            $this->Flash->success(__('La beca fue eliminada exitosamente'));
            
            if ($parentId == null)
                return $this->redirect(['controller' => 'Studenttransactions', 'action' => 'scholarshipIndex']);
            else    
                return $this->redirect(['controller' => 'Students', 'action' => 'enableScholarship', $parentId]);
        }
        else 
        {
            $this->Flash->error(__('La beca no pudo ser eliminada, por favor intente nuevamente'));
        }
    } 

    public function everyfamily()
    {
        $this->autoRender = false;

        if ($this->request->is('json')) 
        {
            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->find('all')->where([['Parentsandguardians.new_guardian' => $_POST['newFamily']], ['Parentsandguardians.guardian !=' => 1]])->order(['Parentsandguardians.family' => 'ASC']);

            $results = $parentsandguardians->toArray();

            if ($results) 
            {
                $jsondata["success"] = true;
                $jsondata["data"]["message"] = "Se encontraron familias";
                $jsondata["data"]["families"] = [];

                foreach ($results as $result)
                {
                    if ($result->id > 1)
                    {
                        $jsondata["data"]["families"][]['id'] = $result->id;
                        $jsondata["data"]["families"][]['family'] = $result->family;
                        $jsondata["data"]["families"][]['surname'] = $result->surname;
                        $jsondata["data"]["families"][]['first_name'] = $result->first_name;
                    }
                }
            }
            else
            { 
          
                $jsondata["success"] = false;
                $jsondata["data"]["message"] = "No se encontraron familias";
            }
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));

        }
    }
    
    public function relatedstudents()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $this->autoRender = false;

		$nivelEstudio = 
		[
			'Pre-escolar, pre-kinder',                                
			'Pre-escolar, kinder',
			'Pre-escolar, preparatorio',
			'Primaria, 1er. grado',
			'Primaria, 2do. grado',
			'Primaria, 3er. grado',
			'Primaria, 4to. grado',
			'Primaria, 5to. grado',
			'Primaria, 6to. grado',
			'Secundaria, 1er. a??o',
			'Secundaria, 2do. a??o',
			'Secundaria, 3er. a??o',
			'Secundaria, 4to. a??o',
			'Secundaria, 5to. a??o'
		];

		$gradoNivelEstudio = 
		[
			'Pre-kinder' => 'Pre-escolar, pre-kinder',                                
			'Kinder' => 'Pre-escolar, kinder',
			'Preparatorio' => 'Pre-escolar, preparatorio',
			'1er. Grado' => 'Primaria, 1er. grado',
			'2do. Grado' => 'Primaria, 2do. grado',
			'3er. Grado' => 'Primaria, 3er. grado',
			'4to. Grado' => 'Primaria, 4to. grado',
			'5to. Grado' => 'Primaria, 5to. grado',
			'6to. Grado' => 'Primaria, 6to. grado',
			'1er. A??o' => 'Secundaria, 1er. a??o',
			'2do. A??o' => 'Secundaria, 2do. a??o',
			'3er. A??o' => 'Secundaria, 3er. a??o',
			'4to. A??o' => 'Secundaria, 4to. a??o',
			'5to. A??o' => 'Secundaria, 5to. a??o'
		];
        
        $studenttransactions = new StudenttransactionsController();
		
		$tasaTemporalDolar = 0;
		$tasaTemporalEuro = 0;
				
        if ($this->request->is('json')) 
        {
            if(isset($_POST['id']))
            {
                $parentId = $_POST['id'];
                $new = $_POST['new'];
				
				if (isset($_POST['tasaTemporalDolar']))
				{
					if (substr($_POST['tasaTemporalDolar'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporalDolar']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporalDolar = $replace2;
					}
					else
					{
						$tasaTemporalDolar = $_POST['tasaTemporalDolar'];
					}
				}
				
				if (isset($_POST['tasaTemporalEuro']))
				{
					if (substr($_POST['tasaTemporalEuro'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporalEuro']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporalEuro = $replace2;
					}
					else
					{
						$tasaTemporalEuro = $_POST['tasaTemporalEuro'];
					}
				}
            }
            else 
            {
                die("Solicitud no v??lida.");
            }
		
			$this->loadModel('Monedas');
			
			if ($tasaTemporalDolar == 0)
			{	
				$moneda = $this->Monedas->get(2);
				$dollarExchangeRate = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$dollarExchangeRate = $tasaTemporalDolar;
			}
							
			if ($tasaTemporalEuro == 0)
			{
				$moneda = $this->Monedas->get(3);
				$euro = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$euro = $tasaTemporalEuro;
			}
			
			$mesesTarifas = $this->mesesTarifas($tasaTemporalDolar);	

			$otrasTarifas = $this->otrasTarifas($tasaTemporalDolar);
			    
            $currentDate = Time::now();
            
            if ($currentDate->day < 10)
            {
                $dd = "0" . $currentDate->day;
            }
            else
            {
                $dd = $currentDate->day;
            }

            if ($currentDate->month < 10)
            {
                $mm = "0" . $currentDate->month;
            }
            else
            {
                $mm = $currentDate->month;
            }
            
            $yyyy = $currentDate->year;
            
            $today = $dd . "/" . $mm . "/" . $yyyy;
            
            $reversedDate = $yyyy . "/" . $mm . "/" . $dd;

            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->get($parentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontraron familias";
            $jsondata["data"]['parentsandguardian_id'] = $parentsandguardians->id;
            $jsondata["data"]['family'] = $parentsandguardians->family;
            $jsondata["data"]['first_name'] = $parentsandguardians->first_name;
            $jsondata["data"]['surname'] = $parentsandguardians->surname;
            $jsondata["data"]['today'] = $today;
            $jsondata["data"]['reversedDate'] = $reversedDate;
            $jsondata["data"]['client'] = $parentsandguardians->client;
            $jsondata["data"]['type_of_identification_client'] = $parentsandguardians->type_of_identification_client;
            $jsondata["data"]['identification_number_client'] = $parentsandguardians->identification_number_client;
            $jsondata["data"]['fiscal_address'] = $parentsandguardians->fiscal_address;
            $jsondata["data"]['tax_phone'] = $parentsandguardians->tax_phone;
            $jsondata["data"]['email'] = $parentsandguardians->email;
			$jsondata["data"]['balance'] = $parentsandguardians->balance;
			$jsondata["data"]['dollar_exchange_rate'] = $dollarExchangeRate;
			$jsondata["data"]['euro'] = $euro;
			$jsondata["data"]['meses_tarifas'] = $mesesTarifas;
			$jsondata["data"]['otras_tarifas'] = $otrasTarifas;
			
            $jsondata["data"]["students"] = [];
            
            if ($new == 0)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 0], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            elseif ($new == 1)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 1], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            else
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }

            $results = $students->toArray();

            if ($results)
            {
                foreach ($results as $result)
                {
					$sections = $this->Students->Sections->get($result->section_id);
                    $transacciones = $studenttransactions->responsejson($result->id);

					if ($result->level_of_study == '')
					{
						$nivelBuscado = $gradoNivelEstudio[$sections->sublevel];
					}
					else
					{
						$nivelBuscado = $result->level_of_study;
					}

					if (substr($nivelBuscado, 0, 8) == 'Primaria')
					{
						$nivelEstudioActual = 'primaria';
					}
					else
					{
						$nivelEstudioActual = 'secundaria';
					}
					$nivelEstudioPasado = '';
					$nivelEstudioAntepasado = '';
					$indiceEncontrado = 0;
			
					foreach ($nivelEstudio as $indice => $valor)
					{
						if ($valor == $nivelBuscado)
						{
							$indiceEncontrado = $indice;
							if ($indice > 3)
							{
								if (substr($nivelEstudio[$indice - 1], 0, 8) == 'Primaria')
								{
									$nivelEstudioPasado = 'primaria';
								}
								else
								{
									$nivelEstudioPasado = 'secundaria';
								}
							}
							if ($indice > 4)
							{
								if (substr($nivelEstudio[$indice - 2], 0, 8) == 'Primaria')
								{
									$nivelEstudioAntepasado = 'primaria';
								}
								else
								{
									$nivelEstudioAntepasado = 'secundaria';
								}
							}
							break;
						}
					}	

                    $jsondata["data"]["students"][] = 
						[
							'id' => $result->id,
							'surname' => $result->surname,
							'second_surname' => $result->second_surname,
							'first_name' => $result->first_name,
							'second_name' => $result->second_name,
							'level_of_study' => $result->level_of_study,
							'becado_ano_anterior' => $result->becado_ano_anterior,
							'scholarship' => $result->scholarship,
							'schoolYearFrom' => $result->balance,
							'descuento_ano_anterior' => $result->descuento_ano_anterior,
							'tipo_descuento' => $result->tipo_descuento,
							'discount_family' => $result->discount,
							'sublevel' => $sections->sublevel,
							'section' => $sections->section,
							'indice_encontrado' => $indiceEncontrado,
							'nivel_buscado' => $nivelBuscado,
							'nivel_estudio_actual' => $nivelEstudioActual,
							'nivel_estudio_pasado' => $nivelEstudioPasado,
							'nivel_estudio_antepasado' => $nivelEstudioAntepasado,
							'studentTransactions' => json_decode($transacciones) 
						];
                }
            }
            
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function searchForStudent()
    {
        $this->autoRender = false;

        $studenttransactions = new StudenttransactionsController();

        if ($this->request->is('json')) 
        {

            if(isset($_POST['id'])) 
                $studentId = $_POST['id'];
            else 
                die("Solicitud no v??lida.");

            $jsondata = [];

            $students = $this->Students->get($studentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontr?? el alumno";
            $jsondata["data"]["first_name"] = $students->first_name;
            $jsondata["data"]["surname"] = $students->surname;
        
            $sections = $this->Students->Sections->get($students->section_id);
                    
            $jsondata["data"]["sublevel"] = $sections->sublevel;
            $jsondata["data"]["section"] = $sections->section;

            $jsondata["data"]["scholarship"] = $students->scholarship;

            $variable = $studenttransactions->responsejson($studentId);
            
            $jsondata["data"]["studenttransactions"] = []; 
            
            $jsondata["data"]["studenttransactions"] = json_decode($variable); 

            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function listStudentsSection()
    {
        $students = $this->paginate($this->Students);   

        $this->set(compact('students'));
        $this->set('_serialize', ['students']);
    }

    public function listMonthlyPayments()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'relationpdf', $_POST['section_id']]);
        }

        $sections = $this->Students->Sections->find('list', ['limit' => 200]);
        
        $this->set(compact('sections'));
    }

    public function relationpdf($section = null)
    {		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;
			
        $yearMonthFrom = $yearFrom . '08';
        
        $yearMonthUp = $yearUntil . '08';

        $nameSection = $this->Students->Sections->get($section);

		if ($nameSection->level == 'Primaria')
		{
			$nivelEstudio = 'primaria';
		}
		else
		{
			$nivelEstudio = 'secundaria';
		}
        
        $level = $this->sublevelLevel($nameSection->sublevel);

        $students = $this->Students->find('all')
            ->where([['id >' => 1], ['section_id' => $section], ['balance >=' => $yearFrom], ['Students.student_condition' => 'Regular']])
            ->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);

        $monthlyPayments = [];
        
        $accountantManager = 0;

		foreach ($students as $student) 
		{
			$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id]);

			$monthlyPayments[$accountantManager]['student'] = $student->full_name;
		
			$monthlyPayments[$accountantManager]['studentTransactions'] = [];
			
			if ($student->scholarship == true)
			{
				$monthlyPayments[$accountantManager]['tipoDescuento'] = "Completo";
				$monthlyPayments[$accountantManager]['descuento'] = 100;
			}
			elseif ($student->discount === null || $student->discount == 0)
			{
				$monthlyPayments[$accountantManager]['tipoDescuento'] = "";
				$monthlyPayments[$accountantManager]['descuento'] = 0;
			}
			else
			{
				$monthlyPayments[$accountantManager]['tipoDescuento'] = $student->tipo_descuento;
				$monthlyPayments[$accountantManager]['descuento'] = $student->discount;
			}

			foreach ($studentTransactions as $studentTransaction) 
			{
				if ($studentTransaction->transaction_type == "Mensualidad")
				{
					$month = substr($studentTransaction->transaction_description, 0, 3);
					
					$year = substr($studentTransaction->transaction_description, 4, 4);
					
					$numberOfTheMonth = $this->nameMonth($month);
					
					$yearMonth = $year . $numberOfTheMonth;
					
					if ($yearMonth > $yearMonthFrom && $yearMonth < $yearMonthUp)
					{
						if ($student->scholarship == 1)
						{
							$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'B';
						}
						else
						{
							if ($studentTransaction->paid_out == 1)
							{

								$indicadorPagado = $this->verificarDiferencia($studentTransaction, $nivelEstudio);

								$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = $indicadorPagado;    
							}
							else
							{
								$monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'P'; 
							}
						}
					}
				}
			}  
			$accountantManager++;
        }

        $this->set(compact('nameSection', 'monthlyPayments', 'yearFrom', 'yearMonthFrom', 'yearMonthUp'));
    }
    
    public function relationPayments($schoolperiod = null, $section = null)
    {
        $yearFrom = substr($schoolperiod, 0, 4);

        $yearMonthFrom = substr($schoolperiod, 0, 4) . '08';
        
        $yearMonthUp = substr($schoolperiod, 5, 4) . '08';

        $nameSection = $this->Students->Sections->get($section);
        
        $level = $this->sublevelLevel($nameSection->sublevel);

        $students = $this->Students->find('all')
            ->where([['id >' => 1], ['section_id' => $section], ['level_of_study' => $level], ['Students.student_condition' => 'Regular']])
            ->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);

        $monthlyPayments = [];
        
        $accountantManager = 0;

        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

        $this->loadModel('Rates');
        
        $concept = 'Matr??cula';
        
        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
           'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();

        if($row)
        {
            foreach ($students as $student) 
            {
                $studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id]);

                $swSignedUp = 0;

                foreach ($studentTransactions as $studentTransaction) 
                {
                    if ($studentTransaction->transaction_description == 'Matr??cula ' . $yearFrom)
                    {
                        if ($studentTransaction->amount < $row->amount)
                        {
                            $swSignedUp = 1;
                        }
                    }
                }                    

                if ($swSignedUp == 1)
                {
                    $monthlyPayments[$accountantManager]['student'] = $student->full_name;
                
                    $monthlyPayments[$accountantManager]['studentTransactions'] = [];

                    foreach ($studentTransactions as $studentTransaction) 
                    {
                        if ($studentTransaction->transaction_type == "Mensualidad")
                        {
                            $month = substr($studentTransaction->transaction_description, 0, 3);
                            
                            $year = substr($studentTransaction->transaction_description, 4, 4);
                            
                            $numberOfTheMonth = $this->nameMonth($month);
                            
                            $yearMonth = $year . $numberOfTheMonth;
                            
                            if ($yearMonth > $yearMonthFrom && $yearMonth < $yearMonthUp)
                            {
                                if ($student->scholarship == 1)
                                {
                                    $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'B';
                                }
                                else
                                {
                                    if ($studentTransaction->paid_out == 1)
                                    {
                                        $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = '*';    
                                    }
                                    else
                                    {
                                        $monthlyPayments[$accountantManager]['studentTransactions'][]['monthlyPayment'] = 'P'; 
                                    }
                                }
                            }
                        }
                    }  
                }
                $accountantManager++;
            }
        }

        $this->set(compact('nameSection', 'monthlyPayments', 'yearFrom', 'yearMonthFrom', 'yearMonthUp'));
    }
	
    function nameMonth($month = null)
    {
        $monthsSpanish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $monthsEnglish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $month);
        return $spanishMonth;
    }

    function nameMonth2($monthNumber = null)
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
    
    public function newRegistration()
    {
        
    }

    public function registerNewStudents()
    {
		
    }

    public function newstudentpdf()
    {
        $newStudents = [];
        $accountantManager = 0;
        $newLevel = " ";
        $newStudent = " ";
        $paidOut = 0;
        $totalPaid = 0;
        $totalPayable = 0;

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => "nuevos",
                'render' => 'browser',
            ]]);

        $students = $this->Students->find('all')->where(['Students.student_condition like' => 'Alumno nuevo%'])->order(['Students.level_of_study' => 'ASC', 
            'Students.surname' => 'ASC', 'Students.second_surname' => 'ASC',
            'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);;

        foreach ($students as $student) 
        {
            $studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $student->id, 'OR' => [['transaction_description' => 'Matr??cula 2017'], ['transaction_description' => 'Servicio educativo 2017'], ['transaction_description' => 'Ago 2018']]]);
                
            foreach ($studentTransactions as $studentTransaction) 
            {
                if ($newLevel != $student->level_of_study)
                {
                    $newStudents[$accountantManager]['levelOfStudy'] = $student->level_of_study;
                    $newLevel = $student->level_of_study;
                }
                else
                {
                    $newStudents[$accountantManager]['levelOfStudy'] = " ";
                }
                if ($newStudent != $student->full_name)
                {
                    $newStudents[$accountantManager]['nameStudent'] = $student->full_name;
                    $newStudents[$accountantManager]['id'] = $student->id;
                    $newStudent = $student->full_name;
                }
                else
                {
                    $newStudents[$accountantManager]['nameStudent'] = " ";
                }
                
                $newStudents[$accountantManager]['transactionDescription'] = $studentTransaction->transaction_description;
                
                $paidOut = $studentTransaction->original_amount - $studentTransaction->amount;
                
                $newStudents[$accountantManager]['paidOut'] = $paidOut;
                
                $newStudents[$accountantManager]['toPay'] = $studentTransaction->amount;
                
                $totalPaid = $totalPaid + $paidOut;
                
                $totalPayable = $totalPayable + $studentTransaction->amount;
                
                $accountantManager++;
            }
        }
        
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
        
        $currentDate = Time::now();

        $this->set(compact('newStudents', 'totalPaid', 'totalPayable', 'currentDate'));
    }
    
    public function indexStudents()
    {
        
    }
    
    public function filepdf($id = null, $controlador = null, $accion = null)
    {
		$ultimoAnoInscripcion = 0;

		$this->loadModel('Schools');

        $school = $this->Schools->get(2);
	
		$usuarioActual = $this->Auth->user('username');
	
		$currentDate = Time::now();
		
		$currentYearRegistration = $school->current_year_registration;
		
        $student = $this->Students->get($id);
		
		$indicadorDescarga = 0;
		
		if ($student->profile_photo != "" && $student->profile_photo != " " && $student->profile_photo != "Sin foto")
		{
			$extensiones_permitidas = array('jpg', 'jpeg', 'gif', 'png');
			$extensionFoto = substr(strtolower(strrchr($student->profile_photo, '.')), 1);
			if ($extensionFoto != false)
			{	
				if (in_array($extensionFoto, $extensiones_permitidas))
				{
					$indicadorDescarga = 1;
				}
			}
		}
	
		if ($usuarioActual == 'angel2703' || $usuarioActual == 'adminsg' || $usuarioActual == 'evelin')
		{
			$indicadorDescarga = 1;
		}
		
		if ($indicadorDescarga == 1)
		{
			$matriculasEstudiante = $this->Students->Studenttransactions->find('all')->where(['student_id' => $id, 'transaction_type' => 'Matr??cula'])->order(['id' => 'DESC']);

			$ultimaMatricula = $matriculasEstudiante->first();

			$ultimoAnoInscripcion =  substr($ultimaMatricula->transaction_description, 11, 4);

			$brothers = $this->Students->find('all')->where(['parentsandguardian_id' => $student->parentsandguardian_id, 'id !=' => $id]);

			$brothersArray = $brothers->toArray();
			
			$brothersPdf = [];
			$account = 0;
			
			if ($brothersArray):
				foreach ($brothersArray as $brothersArrays):
					$brothersPdf[$account]['nameStudent'] = $brothersArrays['surname'] . ' ' . $brothersArrays['first_name'];
					$brothersPdf[$account]['gradeStudent'] = $brothersArrays['level_of_study'];
					$account++;
				endforeach;
			endif;
			
			$parentsandguardian = $this->Students->Parentsandguardians->get($student->parentsandguardian_id);
		}
		else
		{
			$this->Flash->error(__('Estimado usuario, antes de imprimir la ficha de inscripci??n debe subir una foto de perfil del estudiante con alguna de estas extensiones: .gif, .jpeg, .jpg y .png'));
			
			if (isset($origen) && $origen == "viewStudent")
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'indexConsult']);	
			}
			else
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'index']);
			}
		}
		$this->set(compact('student', 'brothersPdf', 'parentsandguardian', 'currentYearRegistration', 'currentDate', 'ultimoAnoInscripcion', 'controlador', 'accion'));
		$this->set('_serialize', ['student', 'brothersPdf', 'parentsandguardian', 'currentYearRegistration', 'currentDate', 'ultimoAnoInscripcion', 'controlador', 'accion']);
    }
    
    public function cardboardpdf($id = null)
    {
        $student = $this->Students->get($id);
        
        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('default')
            ->options(['config' => [
                'filename' => $student->full_name,
                'render' => 'browser'
            ]]);

        $this->set(compact('student'));
        $this->set('_serialize', ['student']);
    }

    public function profilePhoto($id = null)
    {
        $this->set(compact('id'));
    }
    
    public function consultStudent()
    {
        
    }
	
    public function consultStudentDelete()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
	
		$this->set(compact('school'));
		$this->set('_serialize', ['school']);		
    }
    
    public function modifyTransactions()
    {
        
    }

    public function findStudent()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $name = trim($this->request->query['term']);
            $results = $this->Students->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['Students.student_condition' => 'Regular']],
				'order' => ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = ['label' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'value' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'id' => $result['id']];
            }
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }
    public function findStudentDelete()
    {
        $this->autoRender = false;
		if ($this->request->is('ajax')) {
            $name = trim($this->request->query['term']);
            $results = $this->Students->find('all', [
                'conditions' => [['surname LIKE' => $name . '%'], ['Students.student_condition !=' => 'Regular']],
				'order' => ['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]]);
            $resultsArr = [];
            foreach ($results as $result) {
                 $resultsArr[] = ['label' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'value' => $result['surname'] . ' ' . $result['second_surname'] . ' ' . $result['first_name'] . ' ' . $result['second_name'], 'id' => $result['id']];
            }
			exit(json_encode($resultsArr, JSON_FORCE_OBJECT));
        }
    }
    public function reportGraduateStudents()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
			
		$currentYearRegistration = $school->current_year_registration;
		
		$students = TableRegistry::get('Students');

		$studentsFor = $students->find()
			->select(
				['Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.type_of_identification',
				'Students.identity_card',
				'Students.section_id',
				'Students.sex',
				'Students.birthdate',
				'Students.student_condition',
				'Parentsandguardians.type_of_identification',
				'Parentsandguardians.identidy_card',
				'Parentsandguardians.surname',
				'Parentsandguardians.second_surname',
				'Parentsandguardians.first_name',
				'Parentsandguardians.second_name',
				'Sections.id',
				'Sections.sublevel'])
			->contain(['Parentsandguardians', 'Sections'])
			->where([['Students.id >' => 1],
				['Students.student_condition' => 'Regular'],
				['Students.balance !=' => $currentYearRegistration]])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
	  
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();
		
		$accountRecord = $studentsFor->count();

		$totalPages = ceil($accountRecord / 20);
		
		$this->set(compact('school', 'studentsFor', 'totalPages', 'currentDate', 'currentYearRegistration'));
		$this->set('_serialize', ['school', 'studentsFor', 'totalPages', 'currentDate', 'currentYearRegistration']);
    }
    public function SublevelLevel($sublevel = null)
    {
        $sub = ["Pre-kinder",
                    "Kinder",
                    "Preparatorio",
                    "1er. Grado",
                    "2do. Grado",
                    "3er. Grado",
                    "4to. Grado",
                    "5to. Grado",
                    "6to. Grado",
                    "1er. A??o",
                    "2do. A??o",
                    "3er. A??o",
                    "4to. A??o",
                    "5to. A??o"];
        $levelOfStudy = ['Pre-escolar, pre-kinder',                                
                        'Pre-escolar, kinder',
                        'Pre-escolar, preparatorio',
                        'Primaria, 1er. grado',
                        'Primaria, 2do. grado',
                        'Primaria, 3er. grado',
                        'Primaria, 4to. grado',
                        'Primaria, 5to. grado',
                        'Primaria, 6to. grado',
                        'Secundaria, 1er. a??o',
                        'Secundaria, 2do. a??o',
                        'Secundaria, 3er. a??o',
                        'Secundaria, 4to. a??o',
                        'Secundaria, 5to. a??o'];

        $level = str_replace($sub, $levelOfStudy, $sublevel);
        return $level;
    }
	public function defaulters()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
				
		$mesesTarifas = $this->mesesTarifas(0);
						
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;
				
		$yearMonthFrom = $yearFrom . '09';
		
        if ($currentDate->month < 10)
        {
            $monthUntil = "0" . $currentDate->month;
        }
        else
        {
            $monthUntil = $currentDate->month;
        }
		
		$yearMonthUntil = $currentYear . $monthUntil;
					
		$yearMonthEnd = $yearUntil . '07';
				
		$totalDebt = 0;
			
        $students = TableRegistry::get('Students');
        
        $arrayResult = $students->find('regular');
        
        if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos regulares'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		
		$studentsFor = $arrayResult['searchRequired'];

		$defaulters = [];
        
		$accountantManager = 0;	
		
		$defaulters[$accountantManager]['section'] = '';
		$defaulters[$accountantManager]['one'] = 0;
		$defaulters[$accountantManager]['two'] = 0;
		$defaulters[$accountantManager]['three'] = 0;
		$defaulters[$accountantManager]['four'] = 0;
		$defaulters[$accountantManager]['fiveMore'] = 0;
		$defaulters[$accountantManager]['solvents'] = 0;
		$defaulters[$accountantManager]['defaulters'] = 0;
		$defaulters[$accountantManager]['prepaid'] = 0;
		$defaulters[$accountantManager]['scholarship'] = 0;	

		$tDefaulters = [];
			
		$tDefaulters[0]['section'] = '';
		$tDefaulters[0]['one'] = 0;
		$tDefaulters[0]['two'] = 0;
		$tDefaulters[0]['three'] = 0;
		$tDefaulters[0]['four'] = 0;
		$tDefaulters[0]['fiveMore'] = 0;
		$tDefaulters[0]['solvents'] = 0;
		$tDefaulters[0]['defaulters'] = 0;
		$tDefaulters[0]['prepaid'] = 0;
		$tDefaulters[0]['scholarship'] = 0;
		$tDefaulters[0]['totalStudents'] = 0;
		
		$swSection = 0;
				
		foreach ($studentsFor as $studentsFors)
		{		
			$nameSection = $this->Students->Sections->get($studentsFors->section_id);
			
			if ($studentsFors->section_id > 1)
			{				
				$delinquentMonths = 0;
				
				$wholeYear = 0;
				
				$swSignedUp = 0;
				
				$scholarship = 0;
				
				if ($studentsFors->scholarship == 1)
				{
					$scholarship = 1;
				}
				else
				{				
					$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $studentsFors->id]);

					foreach ($studentTransactions as $studentTransaction) 
					{
						if ($studentTransaction->transaction_description == 'Matr??cula ' . $yearFrom)
						{
							if ($studentTransaction->amount_dollar > 0)
							{
								$swSignedUp = 1;
							}
							break;						
						}
					}
					if ($swSignedUp == 1)
					{
						foreach ($studentTransactions as $studentTransaction)
						{
							if ($studentTransaction->transaction_type == "Mensualidad")
							{
								$month = substr($studentTransaction->transaction_description, 0, 3);
									
								$year = substr($studentTransaction->transaction_description, 4, 4);
									
								$numberOfTheMonth = $this->nameMonth($month);
									
								$yearMonth = $year . $numberOfTheMonth;
									
								if ($yearMonth >= $yearMonthFrom && $yearMonth <= $yearMonthEnd)
								{
									if ($studentTransaction->paid_out == 0)
									{
										$wholeYear = 1;
										
										if ($yearMonth <= $yearMonthUntil)
										{
											foreach ($mesesTarifas as $mesesTarifa)
											{
												if ($mesesTarifa["anoMes"] == $yearMonth)
												{
													$amountMonthly = $mesesTarifa["tarifaBolivar"];
													break;
												}
											}
											$delinquentMonths++;
											$totalDebt = $totalDebt + $amountMonthly;
										}
									}
									else
									{
										foreach ($mesesTarifas as $mesesTarifa)
										{
											if ($mesesTarifa["anoMes"] == $yearMonth)
											{
												$tarifaDolarAnoMes = $mesesTarifa["tarifaDolar"];
												if ($studentTransaction->porcentaje_descuento > 0)
												{
													$tarifaDolarAnoMes = ($tarifaDolarAnoMes * $studentTransaction->porcentaje_descuento) / 100;
												}
												break;
											}
										}
										if ($studentTransaction->amount_dollar < $tarifaDolarAnoMes)
										{
											$wholeYear = 1;

											if ($yearMonth <= $yearMonthUntil)
											{											
												$diferenciaDolares = $tarifaDolarAnoMes - $studentTransaction->amount_dolar;
												$diferenciaBolivares = round($diferenciaDolares * $dollarExchangeRate);
											
												$delinquentMonths++;
												$totalDebt = $totalDebt + $diferenciaBolivares;
											}
										}
									}
								}	
							}
						}	
					}	
				}
				if ($scholarship == 1 || $swSignedUp == 1)
				{
					if ($swSection == 0)
					{
						$swSection = 1;
						
						$previousSection = $studentsFors->section_id;
						
						$defaulters[$accountantManager]['section'] = $nameSection->full_name;
						
						$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
						$defaulters = $arrayGeneral[0];
						
						$accountantManager = $arrayGeneral[1];

						$tDefaulters = $arrayGeneral[2];
					}
					else
					{
						if ($previousSection == $studentsFors->section_id)
						{				
							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 		

							$tDefaulters = $arrayGeneral[2];
						}
						else
						{
							$previousSection = $studentsFors->section_id;
						
							$accountantManager++;		
							
							$defaulters[$accountantManager]['section'] = $nameSection->full_name;	
							$defaulters[$accountantManager]['one'] = 0;
							$defaulters[$accountantManager]['two'] = 0;
							$defaulters[$accountantManager]['three'] = 0;
							$defaulters[$accountantManager]['four'] = 0;
							$defaulters[$accountantManager]['fiveMore'] = 0;
							$defaulters[$accountantManager]['solvents'] = 0;
							$defaulters[$accountantManager]['defaulters'] = 0;
							$defaulters[$accountantManager]['prepaid'] = 0;	
							$defaulters[$accountantManager]['scholarship'] = 0;

							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship, $studentsFors->full_name);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 

							$tDefaulters = $arrayGeneral[2];
						}
					}
				}
			}
		}
		$this->set(compact('school', 'defaulters', 'tDefaulters', 'totalDebt', 'currentDate'));
	}
	
	public function addCounter($defaulters = null, $accountantManager = null, $tDefaulters = null, $delinquentMonths = null, $wholeYear = null, $scholarship = null, $alumno = null)
	{
		if ($scholarship == 1)
		{
			$defaulters[$accountantManager]['scholarship']++;
			$tDefaulters[0]['scholarship']++;
			$tDefaulters[0]['totalStudents']++;
			
		}
		else
		{
			if ($delinquentMonths == 0) 
			{
				$defaulters[$accountantManager]['solvents']++;
				$tDefaulters[0]['solvents']++;
				$tDefaulters[0]['totalStudents']++;
			}
			else
			{
				$defaulters[$accountantManager]['defaulters']++;
				$tDefaulters[0]['defaulters']++;
				$tDefaulters[0]['totalStudents']++;
				
				switch ($delinquentMonths) 
				{	
					case 1:
						$defaulters[$accountantManager]['one']++;
						$tDefaulters[0]['one']++;
						break;
					case 2:
						$defaulters[$accountantManager]['two']++;
						$tDefaulters[0]['two']++;
						break;
					case 3:
						$defaulters[$accountantManager]['three']++;
						$tDefaulters[0]['three']++;
						break;
					case 4:
						$defaulters[$accountantManager]['four']++;
						$tDefaulters[0]['four']++;
						break;
					default:
						$defaulters[$accountantManager]['fiveMore']++;
						$tDefaulters[0]['fiveMore']++;
						break;
				}
			}
			
			if ($wholeYear == 0)
			{
				$defaulters[$accountantManager]['prepaid']++;
				$tDefaulters[0]['prepaid']++;
			}
		}
		return [$defaulters, $accountantManager, $tDefaulters];
	}
	public function reportStudentsGeneral()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
		
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
				
		if ($currentMonth < 9)
		{
			$yearFrom = $currentYear - 1;
			$yearUntil = $currentYear;
		}
		else
		{
			$yearFrom = $currentYear;
			$yearUntil = $currentYear + 1;
		}
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);

		$this->loadModel('Rates');
					
		$concept = 'Matr??cula';
					
		$lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
		   'order' => ['Rates.created' => 'DESC'] ]);

		$row = $lastRecord->first();
					
		if ($row)
		{
			$amountRegistration = $row->amount;
		}
		else
		{
			$this->Flash->error(__('No se encontr?? el monto de la matr??cula'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);		
		}
	
        $students = TableRegistry::get('Students');
        
		$studentsFor = $students->find('all')
			->select(
				['Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.type_of_identification',
				'Students.identity_card',
				'Students.section_id',
				'Students.sex',
				'Students.birthdate',
				'Students.student_condition',
				'Students.scholarship',
				'Parentsandguardians.type_of_identification',
				'Parentsandguardians.identidy_card',
				'Parentsandguardians.surname',
				'Parentsandguardians.second_surname',
				'Parentsandguardians.first_name',
				'Parentsandguardians.second_name',
				'Parentsandguardians.email',
				'Parentsandguardians.cell_phone',
				'Parentsandguardians.landline',
				'Parentsandguardians.work_phone',
				'Sections.id',
				'Sections.sublevel'])
			->contain(['Parentsandguardians', 'Sections'])
			->where([['Students.id >' => 1]])
			->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
				
		$studentObservations = [];
        
		foreach ($studentsFor as $studentsFors)
		{										
			$studentObservations[$studentsFors->id]['observation'] = '';
			
			if ($studentsFors->student_condition == 'Regular')
			{
				$level = $this->sublevelLevel($studentsFors->section->sublevel);
				
				if ($level == $studentsFors->level_of_study)
				{						
					if ($studentsFors->scholarship == 1)
					{
						$studentObservations[$studentsFors->id]['observation'] = 'Becado';
					}
					else
					{				
						$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' => $studentsFors->id]);

						foreach ($studentTransactions as $studentTransaction) 
						{
							if ($studentTransaction->transaction_description == 'Matr??cula ' . $yearFrom)
							{
								if ($studentTransaction->amount < $amountRegistration)
								{
									$studentObservations[$studentsFors->id]['observation'] = 'Regular';
								}
								else
								{
									$studentObservations[$studentsFors->id]['observation'] = 'No est?? inscrito';
								}
								break;						
							}
						}
					}
				}
				else
				{
					$studentObservations[$studentsFors->id]['observation'] = 'No est?? asignado a ninguna secci??n';
				}
			}
			else
			{
				$studentObservations[$studentsFors->id]['observation'] = $studentsFors->student_condition;
			}
		}
		$this->set(compact('school', 'studentsFor', 'studentObservations', 'currentDate'));
	}
	public function familyStudents()
	{	
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
		$binnacles = new BinnaclesController;

		$arrayExtra = [];
		
	    if ($this->request->is('post')) 
        {					
			if (isset($_POST['columnsReport']))
			{
				$columnsReport = $_POST['columnsReport'];
			}
			else
			{
				$columnsReport = [];
			}
			
			$arrayMark = $this->markColumns($columnsReport);
			
			$jsonArrayMark = json_encode($arrayMark, JSON_FORCE_OBJECT);	

			if (isset($_POST['filters_report']))
			{
				$arrayExtra[0] = $_POST['filters_report'];
				$arrayExtra[1] = $_POST['order_report'];
			}
		
			$arrayResult = $binnacles->add('controller', 'Students', 'familyStudents', $jsonArrayMark, $arrayExtra);
			
			if ($arrayResult['indicator'] == 0)
			{
				return $this->redirect(['controller' => 'Students', 'action' => 'reportFamilyStudents', $arrayResult['id']]);
			}
			else
			{
				$this->Flash->error(___('Error al guardar el registro Binnacles'));
			}
		}
	}
	
	public function reportFamilyStudents($id = null)
	{	
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
		$this->loadModel('Binnacles');
		
		$accountStudents = [];
		
		$accountStudents['Regular'] = 0; 
		$accountStudents['New'] = 0; 
		$accountStudents['Graduated'] = 0; 
		$accountStudents['Retired'] = 0; 
		$accountStudents['Expelled'] = 0;
		$accountStudents['Discontinued'] = 0;
		$accountNewRegistration = 0;
		$accountRegularRegistration = 0;
					
		$binnacle = $this->Binnacles->get($id);
		
		$objetColumnsReport = json_decode($binnacle->novelty);
						
		$arrayMark = (array) $objetColumnsReport;
				
		$filtersReport = $binnacle->extra_column1;
		
		$orderReport = $binnacle->extra_column2;
		
		$arraySignedUp = [];
					
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$anoEscolarActual = $school->current_school_year;
		$proximoAnoEscolar = $anoEscolarActual + 1;
		$anoBusqueda = 0;

		if ($filtersReport == "Nuevos")
		{		
			$concepto = 'Matr??cula ' . $anoEscolarActual;
			$anoBusqueda = $anoEscolarActual;
		}
		elseif ($filtersReport == "Nuevos pr??ximo a??o escolar")
		{
			$concepto = 'Matr??cula ' . $proximoAnoEscolar;
			$anoBusqueda = $proximoAnoEscolar;
		}
		elseif ($filtersReport == "Regulares")
		{
			$concepto = 'Matr??cula ' . $anoEscolarActual;
			$anoBusqueda = $anoEscolarActual;
		}
		elseif ($filtersReport == "Regulares pr??ximo a??o escolar")
		{
			$concepto = 'Matr??cula ' . $proximoAnoEscolar;
			$anoBusqueda = $proximoAnoEscolar;
		}		
		elseif ($filtersReport == "Nuevos y regulares")
		{		
			$concepto = 'Matr??cula ' . $anoEscolarActual; 
			$anoBusqueda = $anoEscolarActual;
		}
		elseif ($filtersReport == "Todos")
		{
			$concepto = 'Matr??cula ' . $anoEscolarActual;
			$anoBusqueda = $anoEscolarActual;
		}
			
		$students = TableRegistry::get('Students');

		$arrayResult = $students->find('family', ['filtersReport' => $filtersReport, 'orderReport' => $orderReport, 'anoEscolarActual' => $anoEscolarActual, 'proximoAnoEscolar' => $proximoAnoEscolar]);
		
		if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		else
		{
			$familyStudents = $arrayResult['searchRequired'];
		}
		
		$familiaAnterior = "";
		$contadorFamilias = 0;
		
		foreach ($familyStudents as $familyStudent)
		{
			if ($familyStudent->student_condition == "Regular")
			{
				if ($familyStudent->new_student == 0)
				{
					$accountStudents['Regular']++;
				}
				else
				{
					$accountStudents['New']++;
				}
				
				$signedUp = $this->Students->Studenttransactions->find('all')
					->select(['Studenttransactions.student_id', 
						'Studenttransactions.transaction_description', 
						'Studenttransactions.amount', 
						'Studenttransactions.original_amount',
						'Studenttransactions.amount_dollar'])
					->contain(['Students'])
					->where([['Studenttransactions.student_id' => $familyStudent->id],
						['Studenttransactions.transaction_description' => $concepto],
						['Students.balance' => $anoBusqueda]])
					->order(['Studenttransactions.created' => 'DESC']);

				$row = $signedUp->first();	

				if ($row)
				{
					$arraySignedUp[$familyStudent->id] = 'Pagado';
					if ($familyStudent->new_student == 1)
					{
						if ($orderReport == "Representante")
						{
							if ($accountNewRegistration == 0)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card;
								$contadorFamilias++;
							}
							if ($familiaAnterior != $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card;
								$contadorFamilias++;
							}
						}							
						$accountNewRegistration++;
					}
					else
					{
						if ($orderReport == "Representante")
						{
							if ($accountRegularRegistration == 0)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card;
								$contadorFamilias++;
							}
							if ($familiaAnterior != $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card)
							{
								$familiaAnterior = $familyStudent->parentsandguardian->type_of_identification . $familyStudent->parentsandguardian->identidy_card;
								$contadorFamilias++;
							}
						}												
						$accountRegularRegistration++;
					}							
				}
				else
				{
					$arraySignedUp[$familyStudent->id] = 'No pagado';
				}
			}
			elseif ($familyStudent->student_condition == "Egresado")
			{
				$accountStudents['Graduated']++;
			}
			elseif ($familyStudent->student_condition == "Retirado")
			{
				$accountStudents['Retired']++;
			}				
			elseif ($familyStudent->student_condition == "Expulsado")
			{
				$accountStudents['Expelled']++;
			}
			elseif ($familyStudent->student_condition == "Suspendido")
			{
				$accountStudents['Discontinued']++;
			}
		}	
				
		$this->set(compact('familyStudents', 'arrayMark', 'currentDate', 'accountStudents', 'arraySignedUp', 'anoEscolarActual', 'proximoAnoEscolar',  'filtersReport', 'accountNewRegistration', 'accountRegularRegistration', 'contadorFamilias', 'orderReport'));
		$this->set('_serialize', ['familyStudents', 'arrayMark', 'currenDate', 'accountStudents', 'arraySignedUp', 'anoEscolarActual', 'proximoAnoEscolar', 'filtersReport', 'accountNewRegistration', 'accountRegularRegistration', 'contadorFamilias', 'orderReport']); 		
	}
	
	public function markColumns($columnsReport = null)
	{
		$arrayMark = [];
		
		isset($columnsReport['Students.estatus']) ? $arrayMark['Students.estatus'] = 'siExl' : $arrayMark['Students.estatus'] = 'noExl';
				
		isset($columnsReport['Students.sex']) ? $arrayMark['Students.sex'] = 'siExl' : $arrayMark['Students.sex'] = 'noExl';
		
		isset($columnsReport['Students.nationality']) ? $arrayMark['Students.nationality'] = 'siExl' : $arrayMark['Students.nationality'] = 'noExl';
		
		isset($columnsReport['Students.identity_card']) ? $arrayMark['Students.identity_card'] = 'siExl' : $arrayMark['Students.identity_card'] = 'noExl';
				
		isset($columnsReport['Students.balance']) ? $arrayMark['Students.balance'] = 'siExl' : $arrayMark['Students.balance'] = 'noExl';
				
		isset($columnsReport['Students.section_id']) ? $arrayMark['Students.section_id'] = 'siExl' : $arrayMark['Students.section_id'] = 'noExl';
		
		isset($columnsReport['Students.grado_renovacion']) ? $arrayMark['Students.grado_renovacion'] = 'siExl' : $arrayMark['Students.grado_renovacion'] = 'noExl';
		
		isset($columnsReport['Parentsandguardians.full_name']) ? $arrayMark['Parentsandguardians.full_name'] = 'siExl' : $arrayMark['Parentsandguardians.full_name'] = 'noExl';
				
		isset($columnsReport['Parentsandguardians.sex']) ? $arrayMark['Parentsandguardians.sex'] = 'siExl' : $arrayMark['Parentsandguardians.sex'] = 'noExl';
		
		isset($columnsReport['Parentsandguardians.identidy_card']) ? $arrayMark['Parentsandguardians.identidy_card'] = 'siExl' : $arrayMark['Parentsandguardians.identidy_card'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone']) ? $arrayMark['Parentsandguardians.work_phone'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone']) ? $arrayMark['Parentsandguardians.cell_phone'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email']) ? $arrayMark['Parentsandguardians.email'] = 'siExl' : $arrayMark['Parentsandguardians.email'] = 'noExl';	
		
		isset($columnsReport['Parentsandguardians.nombre_completo_padre']) ? $arrayMark['Parentsandguardians.nombre_completo_padre'] = 'siExl' : $arrayMark['Parentsandguardians.nombre_completo_padre'] = 'noExl';
						
		isset($columnsReport['Parentsandguardians.documento_identidad_padre']) ? $arrayMark['Parentsandguardians.documento_identidad_padre'] = 'siExl' : $arrayMark['Parentsandguardians.documento_identidad_padre'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone_father']) ? $arrayMark['Parentsandguardians.work_phone_father'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone_father'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone_father']) ? $arrayMark['Parentsandguardians.cell_phone_father'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone_father'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email_father']) ? $arrayMark['Parentsandguardians.email_father'] = 'siExl' : $arrayMark['Parentsandguardians.email_father'] = 'noExl';	
		
		isset($columnsReport['Parentsandguardians.nombre_completo_madre']) ? $arrayMark['Parentsandguardians.nombre_completo_madre'] = 'siExl' : $arrayMark['Parentsandguardians.nombre_completo_madre'] = 'noExl';
						
		isset($columnsReport['Parentsandguardians.documento_identidad_madre']) ? $arrayMark['Parentsandguardians.documento_identidad_madre'] = 'siExl' : $arrayMark['Parentsandguardians.documento_identidad_madre'] = 'noExl';

		isset($columnsReport['Parentsandguardians.work_phone_mother']) ? $arrayMark['Parentsandguardians.work_phone_mother'] = 'siExl' : $arrayMark['Parentsandguardians.work_phone_mother'] = 'noExl';

		isset($columnsReport['Parentsandguardians.cell_phone_mother']) ? $arrayMark['Parentsandguardians.cell_phone_mother'] = 'siExl' : $arrayMark['Parentsandguardians.cell_phone_mother'] = 'noExl';

		isset($columnsReport['Parentsandguardians.email_mother']) ? $arrayMark['Parentsandguardians.email_mother'] = 'siExl' : $arrayMark['Parentsandguardians.email_mother'] = 'noExl';
		
		return $arrayMark;
	}
    public function editStatus($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();
		
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            
            $student->brothers_in_school = 0;

			if ($student->student_condition == "Nuevo")
			{
				$student->student_condition = "Regular";
				$student->new_student = true;
				$student->level_of_study = "";
				$student->section_id = 1;
				$student->number_of_brothers = 0;
				$student->balance = 0;	
				$student->tipo_descuento = "";
				$student->discount = 0;		
			}
		            
            if ($this->Students->save($student)) 
            {			
				$this->Flash->success(__('El estatus del alumno se actualiz?? correctamente'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
                else
                {
                    return $this->redirect(['controller' => 'users', 'action' => 'wait']);
                }
            }
            else 
            {
                $this->Flash->error(__('El estatus del alumno no se pudo actualizar'));
            }
        }    
        $this->set(compact('student'));
        $this->set('_serialize', ['student']);
    }
    public function editSection($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $currentDate = Time::now();

		$this->loadModel('Sections');

		$gradoNivelEstudio = 
		[
			'Pre-kinder' => 'Pre-escolar, pre-kinder',                                
			'Kinder' => 'Pre-escolar, kinder',
			'Preparatorio' => 'Pre-escolar, preparatorio',
			'1er. Grado' => 'Primaria, 1er. grado',
			'2do. Grado' => 'Primaria, 2do. grado',
			'3er. Grado' => 'Primaria, 3er. grado',
			'4to. Grado' => 'Primaria, 4to. grado',
			'5to. Grado' => 'Primaria, 5to. grado',
			'6to. Grado' => 'Primaria, 6to. grado',
			'1er. A??o' => 'Secundaria, 1er. a??o',
			'2do. A??o' => 'Secundaria, 2do. a??o',
			'3er. A??o' => 'Secundaria, 3er. a??o',
			'4to. A??o' => 'Secundaria, 4to. a??o',
			'5to. A??o' => 'Secundaria, 5to. a??o'
		];
		
		$sections = $this->Students->Sections->find('list', ['limit' => 200]);
		
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
            
            $student->brothers_in_school = 0;

			$seccion = $this->Sections->get($student->section_id);
			
			$student->level_of_study = $gradoNivelEstudio[$seccion->sublevel];
		            
            if ($this->Students->save($student)) 
            {			
				$this->Flash->success(__('El alumno fue asignado correctamente a la secci??n'));
				
                if (isset($controller))
                {
                    return $this->redirect(['controller' => $controller, 'action' => $action, $id]);
                }
                else
                {
                    return $this->redirect(['controller' => 'users', 'action' => 'wait']);
                }
            }
            else 
            {
                $this->Flash->error(__('No se pudo asignar el alumno a la secci??n'));
            }
        }    
        $this->set(compact('student', 'sections'));
        $this->set('_serialize', ['student', 'sections']);
    }
	public function repairColumn()
	{
		$accountRecords = 0;
		
		$query = $this->Students->find('all');
		
		foreach ($query as $querys)
		{
			$student = $this->Students->get($querys->id);
			
			$student->balance = 0;			

            if (!($this->Students->save($student))) 
            {
                $this->Flash->error(__('No pudo ser actualizado el registro Nro. ' . $student->id . ' Nombre: ' . $student->full_name));
			}
			else
			{
				$accountRecords++;
			}
		}
		$this->Flash->success(__('Total registros actualizados: ' . $accountRecords));
	}
    public function sameNames()
    {		
        $this->autoRender = false; 

		$binnacles = new BinnaclesController;
        
		$jsondata = [];

        if ($this->request->is('json')) 
        { 
            if (isset($_POST['surname']) && isset($_POST['firstName']))
            {
				$surname = $_POST['surname'];
				$firstName = $_POST['firstName']; 
								
				$sameStudents = $this->Students->find('all')->where([['Students.surname LIKE' => $surname . '%'], ['Students.first_name LIKE' => $firstName . '%']])
					->contain(['Parentsandguardians'])
					->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

				$count = $sameStudents->count();
				
				if ($count > 0)
				{
					$jsondata['success'] = true;
					$jsondata['data']['message'] = 'Se encontraron estudiantes con nombres similares';
					$jsondata['data']['students'] = [];
					
					foreach ($sameStudents as $sameStudent)
					{
						$jsondata['data']['students'][]['student'] = $sameStudent->full_name;
						$jsondata['data']['students'][]['family'] = $sameStudent->parentsandguardian->family;
						$jsondata['data']['students'][]['id'] = $sameStudent->id;
						$binnacles->add('controller', 'Students', 'sameNames', $sameStudent->full_name);
					}
				}
				else
				{
					$jsondata["success"] = false;
					$jsondata["data"]["message"] = 'No se encontraron estudiantes';
				}
				exit(json_encode($jsondata, JSON_FORCE_OBJECT));
            }
            else 
            {
                die("Solicitud no v??lida.");
            }           
        } 
    }
    public function searchFamily($id = null, $nameStudent = null, $controller = null, $action = null)
    {		
        $this->set(compact('id', 'nameStudent', 'controller', 'action'));
        $this->set('_serialize', ['id', 'nameStudent', 'controller', 'action']);
    }
	
    public function editFamily()
    {		
		$this->autoRender = false;
		
		if ($this->request->is('json')) 
        {
			$student = $this->Students->get($_POST['idStudent']);

			$student->parentsandguardian_id = $_POST['idFamily'];

            if ($this->Students->save($student)) 
            {
                $this->Flash->success(__('La familia fue reasignada exitosamente'));

                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
            else 
            {
                $this->Flash->error(__('La familia no pudo ser reasignada'));
            }
        }    
    }
	public function verifyColumn()
	{
		$accountRecords = 0;
		
		$students = $this->Students->find('all')->where(['id >' => 1]);
		
		foreach ($students as $student)
		{
			if ($student->balance > 0)
			{
				if ($student->number_of_brothers > $student->balance)
				{
					$this->Flash->error(__('En el estudiante: ' . $student->full_name . ' el campo number_of_brothers es mayor a balance'));
					$accountRecords++;
				}
			}
		}
		$this->Flash->success(__('Total registros con columna number_of_brothers mayor a balance: ' . $accountRecords));
	}
	public function verifyColumn2()
	{
		$account2016 = 0;
		$account2017 = 0;
		$account2018 = 0;
		
		$students = $this->Students->find('all')->where(['id >' => 1]);
		
		foreach ($students as $student)
		{
			if ($student->balance == 0)
			{
				if ($student->number_of_brothers == 2016)
				{
					$account2016++;
				}
				elseif ($student->number_of_brothers == 2017)
				{
					$account2017++;
				}
				else
				{
					$account2018++;
				}
			}
		}
		$this->Flash->success(__('Total registros a??o 2016: ' . $account2016));
		$this->Flash->success(__('Total registros a??o 2017: ' . $account2017));
		$this->Flash->success(__('Total registros a??o 2018: ' . $account2018));
	}

    public function uniqueMultidimArray($array, $key) 
    { 
        $temp_array = array(); 
        $key_array = array(); 
        
        foreach($array as $val) 
        { 
            if (!in_array($val[$key], $key_array)) 
            { 
                $key_array[] = $val[$key]; 
                $temp_array[] = $val; 
            } 
        } 
        return $temp_array; 
    } 
	
	public function mesesTarifas($tasaTemporal = null)
	{		
		$tablaMensualidades = 
			[
				'Mensualidadprimaria201909',
				'Mensualidadprimaria201910',
				'Mensualidadprimaria201911',
				'Mensualidadprimaria201912',
				'Mensualidadprimaria202001',
				'Mensualidadprimaria202002',
				'Mensualidadprimaria202003',
				'Mensualidadprimaria202004',
				'Mensualidadprimaria202005',
				'Mensualidadprimaria202006',
				'Mensualidadprimaria202007',
				'Mensualidadprimaria202008',
				'Mensualidadprimaria202009',
				'Mensualidadprimaria202010',
				'Mensualidadprimaria202011',
				'Mensualidadprimaria202012',
				'Mensualidadprimaria202101',
				'Mensualidadprimaria202102',
				'Mensualidadprimaria202103',
				'Mensualidadprimaria202104',
				'Mensualidadprimaria202105',
				'Mensualidadprimaria202106',
				'Mensualidadprimaria202107',
				'Mensualidadprimaria202108',
				'Mensualidadprimaria202109',
				'Mensualidadprimaria202110',
				'Mensualidadprimaria202111',
				'Mensualidadprimaria202112',
				'Mensualidadprimaria202201',
				'Mensualidadprimaria202202',
				'Mensualidadprimaria202203',
				'Mensualidadprimaria202204',
				'Mensualidadprimaria202205',
				'Mensualidadprimaria202206',
				'Mensualidadprimaria202207',
				'Mensualidadprimaria202208',
				'Mensualidadprimaria202209',
				'Mensualidadprimaria202210',
				'Mensualidadprimaria202211',
				'Mensualidadprimaria202212',
				'Mensualidadsecundaria201909',
				'Mensualidadsecundaria201910',
				'Mensualidadsecundaria201911',
				'Mensualidadsecundaria201912',
				'Mensualidadsecundaria202001',
				'Mensualidadsecundaria202002',
				'Mensualidadsecundaria202003',
				'Mensualidadsecundaria202004',
				'Mensualidadsecundaria202005',
				'Mensualidadsecundaria202006',
				'Mensualidadsecundaria202007',
				'Mensualidadsecundaria202008',
				'Mensualidadsecundaria202009',
				'Mensualidadsecundaria202010',
				'Mensualidadsecundaria202011',
				'Mensualidadsecundaria202012',
				'Mensualidadsecundaria202101',
				'Mensualidadsecundaria202102',
				'Mensualidadsecundaria202103',
				'Mensualidadsecundaria202104',
				'Mensualidadsecundaria202105',
				'Mensualidadsecundaria202106',
				'Mensualidadsecundaria202107',
				'Mensualidadsecundaria202108',
				'Mensualidadsecundaria202109',
				'Mensualidadsecundaria202110',
				'Mensualidadsecundaria202111',
				'Mensualidadsecundaria202112',
				'Mensualidadsecundaria202201',
				'Mensualidadsecundaria202202',
				'Mensualidadsecundaria202203',
				'Mensualidadsecundaria202204',
				'Mensualidadsecundaria202205',
				'Mensualidadsecundaria202206',
				'Mensualidadsecundaria202207',
				'Mensualidadsecundaria202208',
				'Mensualidadsecundaria202209',
				'Mensualidadsecundaria202210',
				'Mensualidadsecundaria202211',
				'Mensualidadsecundaria202212'
			];
				
		if ($tasaTemporal == 0)
		{
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$dollarExchangeRate = $moneda->tasa_cambio_dolar;
		}
		else
		{
			$dollarExchangeRate = $tasaTemporal;
		}
		
		$this->loadModel('Rates');
				
		$mensualidades = $this->Rates->find('all', ['conditions' => ['SUBSTRING(concept, 1, 11) =' => 'Mensualidad'], 
			'order' => ['Rates.concept' => 'ASC', 'Rates.rate_year' => 'ASC', 'Rates.rate_month' => 'ASC', 'Rates.created' => 'DESC']]);
		
		$contadorRegistros = $mensualidades->count();
		
		if ($contadorRegistros > 0)
		{
			$mesesTarifas = [];
			$tarifaDolarAnterior = 0;
			$tarifaBolivarAnterior = 0;
			$nivelAnoMesAnterior = "";
			
			$tarifaDolarActual = 0;
			$tarifaBolivarActual = 0;
			$nivelAnoMesActual = "";
			
			foreach ($tablaMensualidades as $tablaMensualidad)
			{
				$indicadorEncontrado = 0;
				
				foreach ($mensualidades as $mensualidad)
				{
					$nivelAnoMesAnterior = $nivelAnoMesActual;

					if ($mensualidad->concept == 'Mensualidad primaria')
					{
						$nivelAnoMesActual = 'Mensualidadprimaria' . $mensualidad->rate_year . $mensualidad->rate_month;
					}
					else
					{
						$nivelAnoMesActual = 'Mensualidadsecundaria' . $mensualidad->rate_year . $mensualidad->rate_month;
					}
					
					$tarifaDolarAnterior = $tarifaDolarActual;
					$tarifaBolivarAnterior = $tarifaBolivarActual;
					
					$tarifaDolarActual = $mensualidad->amount;
					$tarifaBolivarActual = round($tarifaDolarActual * $dollarExchangeRate);
					
					if ($nivelAnoMesActual == $tablaMensualidad)
					{							
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarActual, 'tarifaBolivar' => $tarifaBolivarActual];
						$indicadorEncontrado = 1;
						break;
					}
					elseif ($nivelAnoMesActual > $tablaMensualidad)
					{
						break;
					}
				}
				if ($indicadorEncontrado == 0)
				{
					if ($tablaMensualidad < $nivelAnoMesActual)
					{
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarAnterior, 'tarifaBolivar' => $tarifaBolivarAnterior];
					}
					else
					{
						$mesesTarifas[] = ['anoMes' => $tablaMensualidad, 'tarifaDolar' => $tarifaDolarActual, 'tarifaBolivar' => $tarifaBolivarActual];
					}
				}					
			}
		}	
		return $mesesTarifas;
	}
	
	public function otrasTarifas($tasaTemporal = null)
	{
		if ($tasaTemporal == 0)
		{
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$dollarExchangeRate = $moneda->tasa_cambio_dolar;
		}
		else
		{
			$dollarExchangeRate = $tasaTemporal;
		}
		
		$this->loadModel('Rates');
				
		$tarifas = $this->Rates->find('all', ['conditions' => ['SUBSTRING(concept, 1, 11) !=' => 'Mensualidad'], 
			'order' => ['Rates.concept' => 'ASC', 'Rates.rate_year' => 'ASC', 'Rates.created' => 'DESC']]);
		
		$contadorRegistros = $tarifas->count();
		
		if ($contadorRegistros > 0)
		{
			$otrasTarifas = [];
			$otrasConceptoAnoAnterior = "";		
			$otrasConceptoAnoActual = "";
			
			foreach ($tarifas as $tarifa)
			{
				$otrasConceptoAnoAnterior = $otrasConceptoAnoActual;
				
				$otrasConceptoAnoActual = $tarifa->concept . " " . $tarifa->rate_year;
									
				$otrasDolarActual = $tarifa->amount;				
				$otrasBolivarActual = round($otrasDolarActual * $dollarExchangeRate);
				
				if ($otrasConceptoAnoActual != $otrasConceptoAnoAnterior)
				{							
					$otrasTarifas[] = ['conceptoAno' => $otrasConceptoAnoActual, 'tarifaDolar' => $otrasDolarActual, 'tarifaBolivar' => $otrasBolivarActual];
				}
			}					
		}
		return $otrasTarifas;
	}
	
	public function familiasDescuento20()
	{
        $this->loadModel('Schools');
        $school = $this->Schools->get(2);
		
		$familiaAnterior = "";
		$contadorEstudiantes = 0;
		$vectorFamilias = [];
		
		$estudiantes20 = $this->Students->find('all')->where(['tipo_descuento' => 'Hijos', 'discount' => 20]);

		foreach ($estudiantes20 as $estudiante)
		{
			if ($contadorEstudiantes == 0)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			if ($familiaAnterior != $estudiante->parentsandguardian_id)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			$contadorEstudiantes++;
		}
		
		asort($vectorFamilias);
		
        $this->set(compact('vectorFamilias', 'school'));
        $this->set('_serialize', ['vectorFamilias', 'school']);
	}
	public function familiasDescuento50()
	{
        $this->loadModel('Schools');
        $school = $this->Schools->get(2);
		
		$familiaAnterior = "";
		$contadorEstudiantes = 0;
		$vectorFamilias = [];
		
		$estudiantes20 = $this->Students->find('all')->where(['tipo_descuento' => 'Hijos', 'discount' => 50]);

		foreach ($estudiantes20 as $estudiante)
		{
			if ($contadorEstudiantes == 0)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			if ($familiaAnterior != $estudiante->parentsandguardian_id)
			{
				$familiaAnterior = $estudiante->parentsandguardian_id;
				$familia = $this->Students->Parentsandguardians->get($estudiante->parentsandguardian_id);
				$vectorFamilias[] = $familia->family;
			}
			$contadorEstudiantes++;
		}
		
		asort($vectorFamilias);
        
		$this->set(compact('vectorFamilias', 'school'));
        $this->set('_serialize', ['vectorFamilias', 'school']);
	}
	
	public function morosidad()
    {
        if ($this->request->is('post')) 
        {
			return $this->redirect(['controller' => 'Students', 'action' => 'reporteMorosidad', $_POST["mes"], $_POST["ano"], $_POST["tipo_reporte"], $_POST["ano_escolar"]]);
        }
	}
	
	public function reporteMorosidad($mes = null, $ano = null, $tipoReporte = null, $anoEscolar = null)
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
               
        $currentDate = Time::now();
				
		$currentYear = $currentDate->year;
		$currentMonth = $currentDate->month;
		
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
		
		$this->loadModel('Rates');
		
		$this->loadModel('Monedas');	
		$moneda = $this->Monedas->get(2);
		$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
				
		$mesesTarifas = $this->mesesTarifas(0);

		$tarifaDolarAnoMes = 0;

		$amountMonthly = 0;
								
		if ($anoEscolar == "A??o escolar anterior")
		{
			$yearFrom = $school->current_school_year - 1;
			$yearUntil = $school->current_school_year;
		}	
		else
		{
			$yearFrom = $school->current_school_year;
			$yearUntil = $yearFrom + 1;
		}
				
		$yearMonthFrom = $yearFrom . '09';
			
		$yearMonthUntil = $ano . $mes;
					
		$yearMonthEnd = $yearUntil . '07';
				
		$totalDebt = 0;
			
        $students = TableRegistry::get('Students');
        
        $arrayResult = $students->find('regular');
        
        if ($arrayResult['indicator'] == 1)
		{
			$this->Flash->error(___('No se encontraron alumnos regulares'));
			
			return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
		}
		
		$studentsFor = $arrayResult['searchRequired'];

		$representantes = $this->Students->Parentsandguardians->find('all');

		$defaulters = [];
        
		$accountantManager = 0;	
		
		$defaulters[$accountantManager]['section'] = '';
		$defaulters[$accountantManager]['one'] = 0;
		$defaulters[$accountantManager]['two'] = 0;
		$defaulters[$accountantManager]['three'] = 0;
		$defaulters[$accountantManager]['four'] = 0;
		$defaulters[$accountantManager]['fiveMore'] = 0;
		$defaulters[$accountantManager]['solvents'] = 0;
		$defaulters[$accountantManager]['defaulters'] = 0;
		$defaulters[$accountantManager]['prepaid'] = 0;
		$defaulters[$accountantManager]['scholarship'] = 0;	

		$tDefaulters = [];
			
		$tDefaulters[0]['section'] = '';
		$tDefaulters[0]['one'] = 0;
		$tDefaulters[0]['two'] = 0;
		$tDefaulters[0]['three'] = 0;
		$tDefaulters[0]['four'] = 0;
		$tDefaulters[0]['fiveMore'] = 0;
		$tDefaulters[0]['solvents'] = 0;
		$tDefaulters[0]['defaulters'] = 0;
		$tDefaulters[0]['prepaid'] = 0;
		$tDefaulters[0]['scholarship'] = 0;
		$tDefaulters[0]['totalStudents'] = 0;
		
		$swSection = 0;
		
		$detalleMorosos = [];
		$totalMoroso = 0;
				
		foreach ($studentsFor as $studentsFors)
		{		
			$indiceEstudiante = $studentsFors->full_name . '- ' . $studentsFors->type_of_identification . $studentsFors->identity_card;

			$nameSection = $this->Students->Sections->get($studentsFors->section_id);

			if ($nameSection->level == 'Primaria')
			{
				$nivelEstudio = 'primaria';
			}
			else
			{
				$nivelEstudio = 'secundaria';
			}
			
			if ($studentsFors->section_id > 1)
			{				
				$delinquentMonths = 0;
				
				$wholeYear = 0;
				
				$swSignedUp = 0;
				
				$scholarship = 0;
				
				if ($studentsFors->scholarship == 1)
				{
					$scholarship = 1;
				}
				else
				{				
					$studentTransactions = $this->Students->Studenttransactions->find('all')->where(['student_id' =>$studentsFors->id, 'invoiced' => 0, 'ano_escolar' => $yearFrom, 'transaction_type' => 'Mensualidad']);

					if ($studentsFors->balance == $yearFrom)
					{
						foreach ($studentTransactions as $studentTransaction)
						{
							$month = substr($studentTransaction->transaction_description, 0, 3);
								
							$year = substr($studentTransaction->transaction_description, 4, 4);
								
							$numberOfTheMonth = $this->nameMonth($month);
								
							$yearMonth = 'Mensualidad' . $nivelEstudio. $year . $numberOfTheMonth;

							$soloAnoMes = $year . $numberOfTheMonth;
								
							if ($month != "Ago")
							{
								if ($studentTransaction->paid_out == 0)
								{
									$wholeYear = 1;
									
									if ($soloAnoMes <= $yearMonthUntil)
									{
										foreach ($mesesTarifas as $mesesTarifa)
										{
											if ($mesesTarifa["anoMes"] == $yearMonth)
											{
												if ($studentsFors->discount != null)
												{
													$amountMonthly = round(($mesesTarifa["tarifaDolar"] * (100 - $studentsFors->discount)) / 100, 2);
												}
												else
												{
													$amountMonthly = $mesesTarifa["tarifaDolar"];
												}
												break;
											}
										}
										$delinquentMonths++;
										$saldoCuota = $amountMonthly - $studentTransaction->amount_dolar;
										$totalDebt = $totalDebt + $saldoCuota;
										if (isset($detalleMorosos[$indiceEstudiante]))
										{
											$detalleMorosos[$indiceEstudiante]['cuotasPendientes']++;
											$detalleMorosos[$indiceEstudiante]['pendiente'] += $saldoCuota; 
											$totalMoroso += $saldoCuota;
										}
										else
										{
											$nombreRepresentante = '';
											$cedulaRepresentante = '';
											foreach ($representantes as $representante)
											{
												if ($representante->id == $studentsFors->parentsandguardian_id)
												{
													$nombreRepresentante = $representante->surname . ' ' . $representante->first_name;
													$cedulaRepresentante = $representante->type_of_identification . '-' . $representante->identidy_card;
													break;
												}
											}
											$detalleMorosos[$indiceEstudiante] = 
												['grado' => $nameSection->full_name,
												'descuento' => $studentsFors->discount,
												'cuotasPendientes' => 1,
												'pendiente' => $saldoCuota,
												'nombreRepresentante' => $nombreRepresentante,
												'cedulaRepresentante' => $cedulaRepresentante];
											$totalMoroso += $saldoCuota;
										}
									}
								}
								else
								{
									foreach ($mesesTarifas as $mesesTarifa)
									{
										if ($mesesTarifa["anoMes"] == $yearMonth)
										{
											if ($studentsFors->discount != null)
											{
												$tarifaDolarAnoMes = round(($mesesTarifa["tarifaDolar"] * (100 - $studentsFors->discount)) / 100, 2);
											}
											else
											{
												$tarifaDolarAnoMes = $mesesTarifa["tarifaDolar"];
											}
											break;
										}
									}
									$descuentoAplicado = $studentTransaction->original_amount - $studentTransaction->amount;
									$cuotaAplicadaAlumno = $tarifaDolarAnoMes - $descuentoAplicado; 
									if ($studentTransaction->amount_dollar < $cuotaAplicadaAlumno)
									{
										$wholeYear = 1;

										if ($soloAnoMes <= $yearMonthUntil)
										{											
											$diferenciaDolares = $tarifaDolarAnoMes - $studentTransaction->amount_dollar;
											$diferenciaBolivares = round($diferenciaDolares * $dollarExchangeRate);
										
											$delinquentMonths++;
											$totalDebt = $totalDebt + $diferenciaDolares;
												
											if (isset($detalleMorosos[$indiceEstudiante]))
											{
												$detalleMorosos[$indiceEstudiante]['cuotasPendientes']++;
												$detalleMorosos[$indiceEstudiante]['pendiente'] += $diferenciaDolares; 
												$totalMoroso += $diferenciaDolares;
											}
											else
											{
												$nombreRepresentante = '';
												$cedulaRepresentante = '';
												foreach ($representantes as $representante)
												{
													if ($representante->id == $studentFors->parentsandguardian_id)
													{
														$nombreRepresentante = $representante->surname . ' ' . $representante->first_name;
														$cedulaRepresentante = $representante->type_of_identification . '-' . $representante->identidy_card;
														break;
													}
												}
												$detalleMorosos[$indiceEstudiante] = 
													['grado' => $nameSection->full_name,
													'descuento' => $studentsFors->discount,
													'cuotasPendientes' => 1,
													'pendiente' => $diferenciaDolares,
													'nombreRepresentante' => $nombreRepresentante,
													'cedulaRepresentante' => $cedulaRepresentante];
												$totalMoroso += $diferenciaDolares;
											}
										}
									}
								}
							}	
						}	
					}	
				}
				if ($studentsFors->balance == $yearFrom)
				{
					if ($swSection == 0)
					{
						$swSection = 1;
						
						$previousSection = $studentsFors->section_id;
						
						$defaulters[$accountantManager]['section'] = $nameSection->full_name;
						
						$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
						
						$defaulters = $arrayGeneral[0];
						
						$accountantManager = $arrayGeneral[1];

						$tDefaulters = $arrayGeneral[2];
					}
					else
					{
						if ($previousSection == $studentsFors->section_id)
						{				
							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 		

							$tDefaulters = $arrayGeneral[2];
						}
						else
						{
							$previousSection = $studentsFors->section_id;
						
							$accountantManager++;		
							
							$defaulters[$accountantManager]['section'] = $nameSection->full_name;	
							$defaulters[$accountantManager]['one'] = 0;
							$defaulters[$accountantManager]['two'] = 0;
							$defaulters[$accountantManager]['three'] = 0;
							$defaulters[$accountantManager]['four'] = 0;
							$defaulters[$accountantManager]['fiveMore'] = 0;
							$defaulters[$accountantManager]['solvents'] = 0;
							$defaulters[$accountantManager]['defaulters'] = 0;
							$defaulters[$accountantManager]['prepaid'] = 0;	
							$defaulters[$accountantManager]['scholarship'] = 0;

							$arrayGeneral = $this->addCounter($defaulters, $accountantManager, $tDefaulters, $delinquentMonths, $wholeYear, $scholarship);
						
							$defaulters = $arrayGeneral[0];
						
							$accountantManager = $arrayGeneral[1]; 

							$tDefaulters = $arrayGeneral[2];
						}
					}
				}
			}
		}
			
		$this->set(compact('school', 'defaulters', 'tDefaulters', 'totalDebt', 'currentDate', 'ano', 'mes', 'tipoReporte', 'detalleMorosos', 'totalMoroso'));
	}

	public function relatedstudentsPrueba()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

		$nivelEstudio = 
			[
				'Pre-escolar, pre-kinder',                                
				'Pre-escolar, kinder',
				'Pre-escolar, preparatorio',
				'Primaria, 1er. grado',
				'Primaria, 2do. grado',
				'Primaria, 3er. grado',
				'Primaria, 4to. grado',
				'Primaria, 5to. grado',
				'Primaria, 6to. grado',
				'Secundaria, 1er. a??o',
				'Secundaria, 2do. a??o',
				'Secundaria, 3er. a??o',
				'Secundaria, 4to. a??o',
				'Secundaria, 5to. a??o'
			];
        
        $studenttransactions = new StudenttransactionsController();
				
        if ($this->request->is('post')) 
        {
            if(isset($_POST['id']))
            {
                $parentId = $_POST['id'];
                $new = $_POST['new'];
				
				if (isset($_POST['tasaTemporal']))
				{
					if (substr($_POST['tasaTemporal'], -3, 1) == ',')
					{
						$replace1= str_replace('.', '', $_POST['tasaTemporal']);
						$replace2 = str_replace(',', '.', $replace1);
						$tasaTemporal = $replace2;
					}
					else
					{
						$tasaTemporal = $_POST['tasaTemporal'];
					}
				}
				else
				{
					$tasaTemporal = 0;
				}
            }
            else 
            {
                die("Solicitud no v??lida.");
            }

			$this->loadModel('Schools');

			$school = $this->Schools->get(2);
					
			$anoEscolarActual = $school->current_school_year;
			
			if ($tasaTemporal == 0)
			{
				$this->loadModel('Monedas');	
				$moneda = $this->Monedas->get(2);
				$dollarExchangeRate = $moneda->tasa_cambio_dolar;
			}
			else
			{
				$dollarExchangeRate = $tasaTemporal;
			}

			$mesesTarifas = $this->mesesTarifas($tasaTemporal);	

			$otrasTarifas = $this->otrasTarifas($tasaTemporal);
			    
            $currentDate = Time::now();
            
            if ($currentDate->day < 10)
            {
                $dd = "0" . $currentDate->day;
            }
            else
            {
                $dd = $currentDate->day;
            }

            if ($currentDate->month < 10)
            {
                $mm = "0" . $currentDate->month;
            }
            else
            {
                $mm = $currentDate->month;
            }
            
            $yyyy = $currentDate->year;
            
            $today = $dd . "/" . $mm . "/" . $yyyy;
            
            $reversedDate = $yyyy . "/" . $mm . "/" . $dd;

            $jsondata = [];

            $parentsandguardians = $this->Students->Parentsandguardians->get($parentId);

            $jsondata["success"] = true;
            $jsondata["data"]["message"] = "Se encontraron familias";
            $jsondata["data"]['parentsandguardian_id'] = $parentsandguardians->id;
            $jsondata["data"]['family'] = $parentsandguardians->family;
            $jsondata["data"]['first_name'] = $parentsandguardians->first_name;
            $jsondata["data"]['surname'] = $parentsandguardians->surname;
            $jsondata["data"]['today'] = $today;
            $jsondata["data"]['reversedDate'] = $reversedDate;
            $jsondata["data"]['client'] = $parentsandguardians->client;
            $jsondata["data"]['type_of_identification_client'] = $parentsandguardians->type_of_identification_client;
            $jsondata["data"]['identification_number_client'] = $parentsandguardians->identification_number_client;
            $jsondata["data"]['fiscal_address'] = $parentsandguardians->fiscal_address;
            $jsondata["data"]['tax_phone'] = $parentsandguardians->tax_phone;
            $jsondata["data"]['email'] = $parentsandguardians->email;
			$jsondata["data"]['balance'] = $parentsandguardians->balance;
			$jsondata["data"]['dollar_exchange_rate'] = $dollarExchangeRate;
			$jsondata["data"]['meses_tarifas'] = $mesesTarifas;
			$jsondata["data"]['otras_tarifas'] = $otrasTarifas;
			$jsondata["data"]['ano_escolar_actual'] = $anoEscolarActual;
			
            $jsondata["data"]["students"] = [];
            
            if ($new == 0)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 0], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            elseif ($new == 1)
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['new_student' => 1], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }
            else
            {
                $students = $this->Students->find('all')->where([['parentsandguardian_id' => $parentId], ['Students.student_condition' => 'Regular']])
                ->order(['Students.first_name' => 'ASC', 'Students.surname' => 'ASC']);
            }

            $results = $students->toArray();

            if ($results)
            {
                foreach ($results as $result)
                {
					$sections = $this->Students->Sections->get($result->section_id);
                    $transacciones = $studenttransactions->responsejson($result->id);
					
                    $jsondata["data"]["students"][] = 
						[
							'id' => $result->id,
							'surname' => $result->surname,
							'second_surname' => $result->second_surname,
							'first_name' => $result->first_name,
							'second_name' => $result->second_name,
							'level_of_study' => $result->level_of_study,
							'scholarship' => $result->scholarship,
							'schoolYearFrom' => $result->balance,
							'discount_family' => $result->discount,
							'sublevel' => $sections->sublevel,
							'section' => $sections->section,
							'studentTransactions' => json_decode($transacciones) 
						];
                }
            }
            
            exit(json_encode($jsondata, JSON_FORCE_OBJECT));
        }
    }
    public function busquedaAlumno()
    {
        
    }
	public function becadosAnoAnterior()
	{
		$this->loadModel('Discounts');
		$contadorTotal = 0;
		$contadorBecados = 0;
		$contadorHijos20 = 0;
		$contadorHijos50 = 0;
		
		$becados = $this->Students->find('all')->where(['OR' => [['scholarship' => true], ['discount' => 20], ['discount' => 50]]]);
        
		foreach ($becados as $becado)
		{
			$descuento = $this->Discounts->newEntity();
			$contadorTotal++;
			if ($becado->scholarship == true)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Becado";
				$descuento->discount_amount = 100;
				$contadorBecados++;
			}
			elseif ($becado->discount == 20)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Hijos";
				$descuento->discount_amount = $becado->discount;	
				$contadorHijos20++;
			}
			elseif ($becado->discount == 50)
			{
				$descuento->description_discount = $becado->id;
				$descuento->discount_mode = "Hijos";
				$descuento->discount_amount = $becado->discount;	
				$contadorHijos50++;
			}
			
			if (!($this->Discounts->save($descuento))) 
			{
                $this->Flash->error(__('No se pudo grabar el alumno en la tabla'));
			}
		}
		$this->Flash->success(__('Total alumnos becados a??o anterior ' . $contadorBecados));
		$this->Flash->success(__('Total alumnos beca hijos 20% ' . $contadorHijos20));
		$this->Flash->success(__('Total alumnos beca hijos 50% ' . $contadorHijos50));
		$this->Flash->success(__('Total alumnos becados ' . $contadorTotal));
	}
	public function actualizarBecadosAnoAnterior()
	{
		$this->loadModel('Discounts');
		$contadorActualizados = 0;
		$contadorBecados = 0;
		$contadorHijos20 = 0;
		$contadorHijos50 = 0;
		
		$becados = $this->Discounts->find('all');
        
		foreach ($becados as $becado)
		{
			$estudiante = $this->Students->get($becado->description_discount);
						
			if ($becado->discount_mode == "Becado")
			{
				$estudiante->becado_ano_anterior = true;
				$estudiante->tipo_descuento_ano_anterior = "Becado";
				$estudiante->descuento_ano_anterior = 100;
				$contadorBecados++;
			}
			elseif ($becado->discount_mode == "Hijos" && $becado->discount_amount == 20)
			{
				$estudiante->tipo_descuento_ano_anterior = "Hijos";
				$estudiante->descuento_ano_anterior = $becado->discount_amount;
				$contadorHijos20++;
			}			
			elseif ($becado->discount_mode == "Hijos" && $becado->discount_amount == 50)
			{
				$estudiante->tipo_descuento_ano_anterior = "Hijos";
				$estudiante->descuento_ano_anterior = $becado->discount_amount;
				$contadorHijos50++;
			}

			$contadorActualizados++;
			
			if (!($this->Students->save($estudiante))) 
			{
                $this->Flash->error(__('No se pudo actualizar el alumno en la tabla'));
			}
		}
		$this->Flash->success(__('Total alumnos becados ' . $contadorBecados));
		$this->Flash->success(__('Total alumnos beca hijos 20% ' . $contadorHijos20));
		$this->Flash->success(__('Total alumnos beca hijos 50% ' . $contadorHijos50));
		$this->Flash->success(__('Total alumnos actualizados ' . $contadorActualizados));
	}
	public function becasEspeciales()
	{
		
	}
    public function aplicarBecaEspecial($id = null, $controller = null, $action = null)
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $student = $this->Students->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $student = $this->Students->patchEntity($student, $this->request->data);
			
			if ($student->tipo_descuento == null)
			{
				$student->discount = 0; 
			}

            if ($this->Students->save($student)) 
            {
				$this->Flash->success(__('La beca se aplic?? exitosamente'));
				return $this->redirect(['controller' => 'Users', 'action' => 'wait']);;
            }
            else 
            {
                $this->Flash->error(__('La beca no se pudo aplicar correctamente'));
            }
        }    
        $this->set(compact('student', 'controller', 'action'));
        $this->set('_serialize', ['student', 'controller', 'action']);
	}
	public function reporteBecados()
	{
		$becados = $this->Students->find('all')
			->where(['student_condition' => 'Regular', 'discount >' => 0])
			->order(['surname' => 'ASC', 'second_surname' => 'ASC', 'first_name' => 'ASC', 'second_name' => 'ASC']);
			
		$this->set(compact('becados'));
        $this->set('_serialize', ['becados']);
	}

	public function buscarBecadosAnoAnterior()
	{
		$codigoRetorno = 0;

		$transaccionesActualizadas = 0;

		$studentTransactions = new StudenttransactionsController();

		$becadosAnoAnterior = $this->Students->find('all')
			->where(['descuento_ano_anterior !=' => 0]);

		$contadorBusqueda = $becadosAnoAnterior->count();

		$this->Flash->success(__('Total becados a??o anterior: ' . $contadorBusqueda));	
		
		foreach ($becadosAnoAnterior as $becado)
		{
			$codigoRetorno = $studentTransactions->actualizarTransaccionBecado($becado->id, 2019);

			if ($codigoRetorno == 99)
			{
				break;
			}
			else
			{
				$transaccionesActualizadas += $codigoRetorno;
			} 
		}	
		
		$this->Flash->success(__('Total transacciones actualizadas ' . $transaccionesActualizadas));
	}

	public function buscarBecadosAnoActual()
	{
		$codigoRetorno = 0;

		$transaccionesActualizadas = 0;

		$studentTransactions = new StudenttransactionsController();

		$becadosAnoAnterior = $this->Students->find('all')
			->where(['discount !=' => 0]);

		$contadorBusqueda = $becadosAnoAnterior->count();

		$this->Flash->success(__('Total becados a??o anterior: ' . $contadorBusqueda));	
		
		foreach ($becadosAnoAnterior as $becado)
		{
			$codigoRetorno = $studentTransactions->actualizarTransaccionBecado($becado->id, 2020);

			if ($codigoRetorno == 99)
			{
				break;
			}
			else
			{
				$transaccionesActualizadas += $codigoRetorno;
			} 
		}	
		
		$this->Flash->success(__('Total transacciones actualizadas ' . $transaccionesActualizadas));
	}

	public function verificarDiferencia($studentTransaction = null, $nivelEstudio = null)
	{
		$indicadorPagado = '*';

		$mesesTarifas = $this->mesesTarifas(0);

		$ano = $studentTransaction->payment_date->year;
								
		$mes = $studentTransaction->payment_date->month;
																						
		if ($mes < 10)
		{
			$mesCadena = '0' . $mes;
		}
		else
		{
			$mesCadena = (string) $mes;
		}

		$anoMes = 'Mensualidad' . $nivelEstudio. $ano . $mesCadena;
						
		foreach ($mesesTarifas as $mesTarifa)
		{
			if ($mesTarifa['anoMes'] == $anoMes)
			{
				$tarifaDolar = $mesTarifa['tarifaDolar'];

				if ($studentTransaction->porcentaje_descuento == 0)
				{
					$tarifaDolarConDescuento = $tarifaDolar;					
				}
				else
				{
					$tarifaDolarConDescuento = round(($tarifaDolar * $studentTransaction->porcentaje_descuento) / 100, 2);	
				}

				if ($studentTransaction->amount_dollar < $tarifaDolarConDescuento)
				{
					$indicadorPagado = 'A';
				}
				break;
			}
		}

		return $indicadorPagado;
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
            
            $nameOfTheMonth = $this->nameMonth2($monthNumber);

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
        return $contadorTransacciones;   
    }
	public function ReporteInscritosConFactura()
	{
		$estudiantesInscritos = [];

		$this->loadModel('Schools');

        $school = $this->Schools->get(2);

		$anoEscolarActual = $school->current_year_registration;

		$estudiantes = $this->Students->find('all')->where(['Students.balance' => $anoEscolarActual])->order(['Students.type_of_identification' => 'DESC', 'Students.identity_card' => 'DESC']);

		$contadorEstudiantes = $estudiantes->count();

		// $this->Flash->success(__('Estudiantes inscritos ' . $contadorEstudiantes));

		if ($contadorEstudiantes > 0)
		{
			$transaccionesEstudiante = $this->Students->Studenttransactions->find('all')->where(['OR' => [['Studenttransactions.transaction_description' => 'Matr??cula ' . $anoEscolarActual], ['Studenttransactions.transaction_description' => 'Sep ' . $anoEscolarActual]]]);

			$contadorTransacciones = $transaccionesEstudiante->count();

			// $this->Flash->success(__('Transacciones encontradas ' . $contadorTransacciones));

			foreach ($estudiantes as $estudiante)
			{
				$estudianteImprimir = 0;
				$numeroFactura = 0;
				$descripcionTransaccion = '';
				$montoPagado = 0;

				if ($estudiante->tipo_descuento == '' || $estudiante->tipo_descuento == null)
				{
					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->student_id == $estudiante->id)
						{
							if ($transaccion->transaction_description == 'Matr??cula ' . $anoEscolarActual)
							{
								if ($transaccion->bill_number != 0 && $transaccion->bill_number != null && $transaccion->amount_dollar > 0)
								{
									$estudianteImprimir = 1;
									$numeroFactura = $transaccion->bill_number;
									$descripcionTransaccion = $transaccion->transaction_description;
									$montoPagado = $transaccion->amount_dollar;
									break;
								}
								else
								{
									break;
								}
							}
						}
					}
				}
				elseif ($estudiante->tipo_descuento == 'Hijos' && $estudiante->discount > 0)
				{
					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->student_id == $estudiante->id)
						{
							if ($transaccion->transaction_description == 'Sep ' . $anoEscolarActual)
							{
								if ($transaccion->bill_number != 0 && $transaccion->bill_number != null && $transaccion->amount_dollar > 0)
								{
									$estudianteImprimir = 1;
									$numeroFactura = $transaccion->bill_number;
									$descripcionTransaccion = $transaccion->transaction_description;
									$montoPagado = $transaccion->amount_dollar;
									break;
								}
								else
								{
									break;
								}
							}
						}
					}
				}
				elseif ($estudiante->tipo_descuento == 'Empleado' && $estudiante->discount > 0)
				{
					$indicadorMatr??cula = 0;

					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->student_id == $estudiante->id)
						{
							if ($transaccion->transaction_description == 'Matr??cula ' . $anoEscolarActual)
							{
								if ($transaccion->bill_number != 0 && $transaccion->bill_number != null && $transaccion->amount_dollar > 0)
								{
									$estudianteImprimir = 1;
									$numeroFactura = $transaccion->bill_number;
									$descripcionTransaccion = $transaccion->transaction_description;
									$montoPagado = $transaccion->amount_dollar;
									break;
								}
								elseif ($transaccion->bill_number == 0 || $transaccion->bill_number != null)
								{
									if ($transaccion->amount_dollar > 0)
									{
										break;
									}
								}
							}
							elseif ($transaccion->transaction_description == 'Sep ' . $anoEscolarActual)
							{
								if ($transaccion->bill_number != 0 && $transaccion->bill_number != null && $transaccion->amount_dollar > 0)
								{
									$estudianteImprimir = 1;
									$numeroFactura = $transaccion->bill_number;
									$descripcionTransaccion = $transaccion->transaction_description;
									$montoPagado = $transaccion->amount_dollar;
									break;
								}	
								elseif ($transaccion->bill_number == 0 || $transaccion->bill_number != null)
								{
									if ($transaccion->amount_dollar > 0)
									{
										break;
									}
								}							
							}
						}
					}
				}	
				else
				{
					foreach ($transaccionesEstudiante as $transaccion)
					{
						if ($transaccion->student_id == $estudiante->id)
						{
							if ($transaccion->transaction_description == 'Matr??cula ' . $anoEscolarActual)
							{
								if ($transaccion->bill_number != 0 && $transaccion->bill_number != null && $transaccion->amount_dollar > 0)
								{
									$estudianteImprimir = 1;
									$numeroFactura = $transaccion->bill_number;
									$descripcionTransaccion = $transaccion->transaction_description;
									$montoPagado = $transaccion->amount_dollar;
									break;
								}
							}
						}
					}
				}	
				if ($estudianteImprimir == 1)
				{
					$estudiantesInscritos[] =
						[
							'c??dula' => $estudiante->type_of_identification . '-' . $estudiante->identity_card,
							'nombre' => $estudiante->surname,
							'apellido' => $estudiante->first_name,
							'grado' => $estudiante->level_of_study, 
							'tipo_descuento' => $estudiante->tipo_descuento,
							'descuento' => $estudiante->discount,
							'factura' => $numeroFactura,
							'transaccion' => $descripcionTransaccion,
							'monto' => $montoPagado
						];		
				}
			}
		}
		$this->set(compact('estudiantesInscritos', 'contadorEstudiantes'));
        $this->set('_serialize', ['estudiantesInscritos', 'contadorEstudiantes']);
	}
}