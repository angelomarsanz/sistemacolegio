<?php
namespace App\Controller;

use App\Controller\AppController;

use App\Controller\ExcelsController;

use App\Controller\BinnaclesController;

use Cake\ORM\TableRegistry;

use App\Controller\EventosController;

use Cake\I18n\Time;

class StudenttransactionsController extends AppController
{
    public function isAuthorized($user)
    {
		if(isset($user['role']))
		{
			if ($user['role'] === 'Control de estudios')
			{
				if(in_array($this->request->action, ['reportStudentGeneral', 'scholarshipIndex']))
				{
					return true;
				}				
			}
			if ($user['role'] === 'Representante')
			{
				if(in_array($this->request->action, ['cuotasPendientes']))
				{
					return true;
				}				
			}
		}

        return parent::isAuthorized($user);
    }        
	
    public function testFunction()
    {
		/* $transaccionesEncontradas = 0;
		$transaccionesActualizadas = 0;

		$binnacles = new BinnaclesController;

		$transacciones = $this->Studenttransactions->find('all');
			
		$transaccionesEncontradas = $transacciones->count();

		$this->Flash->success(__('Total transaccciones encontradas: ' . $transaccionesEncontradas));
				
		foreach ($transacciones as $transaccion)
		{
			$indicadorDecimal = 0;
			$decimalAmount = 0;
			$decimalOriginalAmount = 0;
			$decimalAmountDollar = 0;
			$arrayExtra = ['', '', '', '', '', 0, 0, 0, 0, 0];

			$decimalAmount = $transaccion->amount - (int) $transaccion->amount;
			
			if ($decimalAmount > 0)
			{
				$indicadorDecimal = 1;
				$arrayExtra[6] = $transaccion->amount;
			}

			$decimalOriginalAmount = $transaccion->original_amount - (int) $transaccion->original_amount;
			
			if ($decimalOriginalAmount > 0)
			{
				$indicadorDecimal = 1;
				$arrayExtra[7] = $transaccion->original_amount;
			}

			$decimalAmountDollar = $transaccion->amount_dollar - (int) $transaccion->amount_dollar;

			if ($decimalAmountDollar > 0)
			{
				$indicadorDecimal = 1;
				$arrayExtra[8] = $transaccion->amount_dollar;
			}

			if ($indicadorDecimal == 1)
			{
				$arrayExtra[5] = $transaccion->id; 
				$binnacles->add('controller', 'Studenttransactions', 'testFunction', 'Monto decimal', $arrayExtra );
				$transaccionesActualizadas++;
			}
		}
		$this->Flash->success(__('Total transaccciones actualizadas: ' . $transaccionesActualizadas)); */
    }

    public function testFunction2()
    {
		$contadorTransaccionesActualizadas = 0;

		$transacciones = $this->Studenttransactions->find('all');

		foreach ($transacciones as $transaccion)
		{
			if ($transaccion->amount_dollar > $transaccion->amount)
			{
				$transaccion->amount_dollar = $transaccion->amount;
				
				if ($this->Studenttransactions->save($transaccion)) 
				{ 
					$contadorTransaccionesActualizadas++;
				}
				else 
				{ 
					$this->Flash->error(__('La transaccion no fue actualizada. ID ' . $transacccion->id));
				} 
			}
		}
		$this->Flash->success(__('Total transaccciones actualizadas: ' . $contadorTransaccionesActualizadas));
	}
	
    public function index()
    {
       if ($this->request->is('post'))
       {			
			$this->loadModel('Rates');
			
			$this->loadModel('Monedas');	
			$moneda = $this->Monedas->get(2);
			$dollarExchangeRate = $moneda->tasa_cambio_dolar; 
			
			$lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => 'Mensualidad'],
				'order' => ['Rates.created' => 'DESC'] ]);
				
			$row = $lastRecord->first();
				
			if ($row)
			{
				$amountMonthly = round($row->amount * $dollarExchangeRate);	
			}
			else
			{
				$amountMonthly = 0;
			}

            $studenttransactions = $this->Studenttransactions->find('all')
				->where(['student_id' => $_POST['idStudent']]);
									
            $student = $_POST['student'];

            $this->set(compact('studenttransactions', 'student', 'amountMonthly'));
            $this->set('_serialize', ['studenttransactions', 'student', 'amountMonthly']);
       }
    }

    public function view($id = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id, [
            'contain' => []
        ]);

        $this->set('studenttransaction', $studenttransaction);
        $this->set('_serialize', ['studenttransaction']);
    }

    public function add()
    {
        $this->loadModel('Rates');

        $concept = 'Inscripci??n';

        $lastRecord = $this->Rates->find('all', ['conditions' => ['concept' => $concept], 
                               'order' => ['Rates.created' => 'DESC'] ]);

        $row = $lastRecord->first();
        
        echo $row['amount'];

        $studenttransaction = $this->Studenttransactions->newEntity();
        if ($this->request->is('post')) {
            $studenttransaction = $this->Studenttransactions->patchEntity($studenttransaction, $this->request->data);
            echo $studenttransaction;
            if ($this->Studenttransactions->save($studenttransaction)) {
                $this->Flash->success(__('The studenttransaction has been saved.'));

//                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
            }
        }
        
        $students = $this->Studenttransactions->Students->find('list', ['limit' => 200]);
        
        $this->set(compact('studenttransaction', 'students'));
        $this->set('_serialize', ['studenttransaction']);
    }

    public function edit($transaccion = null, $billNumber = null)
	{
        $studenttransaction = $this->Studenttransactions->get($transaccion->transactionIdentifier);

		if ($transaccion->descuentoAlumno != 1)
		{
			$studenttransaction->porcentaje_descuento = round((1 - $transaccion->descuentoAlumno) * 100, 2);
		}
						
		if ($studenttransaction->amount_dollar === null)
		{
			$studenttransaction->amount_dollar = $transaccion->montoAPagarDolar;
		}
		else
		{
			$studenttransaction->amount_dollar += $transaccion->montoAPagarDolar;
		}
		
		$studenttransaction->original_amount = $transaccion->tarifaDolarOriginal;	
		$studenttransaction->amount = $transaccion->tarifaDolar;
		
		if ($transaccion->tarifaDolarOriginal != $transaccion->tarifaDolar)
		{
			$eventos = new EventosController;
								
			$eventos->add('controller', 'Studenttransactions', 'edit', 'Se modific?? el monto de la cuota ' . $transaccion->monthlyPayment . ' de ' . $transaccion->tarifaDolarOriginal . ' a ' . $transaccion->tarifaDolar . ' $ del alumno ' . $transaccion->studentName . ' en la factura Nro. ' . $billNumber);
		}
						
		if ($transaccion->observation == "Abono")
		{
			$studenttransaction->partial_payment = 1;
			$studenttransaction->paid_out = 0;
		} 
		else
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 1;
		}
			
        $studenttransaction->bill_number = $billNumber;

        if (!($this->Studenttransactions->save($studenttransaction)))
        {
            $this->Flash->error(__('La transacci??n del alumno no pudo ser actualizada, vuelva a intentar.'));
        }

		$indicadorActualizarEstudiante = 0;

		if ($studenttransaction->transaction_type == 'Matr??cula')
		{
			$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);

			$year = substr($studenttransaction->transaction_description, 11, 4);

			$indicadorActualizarEstudiante = 1;	
		}
		elseif (substr($studenttransaction->transaction_description, 0, 3) == 'Sep')
		{
			$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);

			if ($student->tipo_descuento == 'Hijos' && $student->discount > 0)
			{
				$year = substr($studenttransaction->transaction_description, 4, 4);

				$indicadorActualizarEstudiante = 1;
			}
			elseif ($student->tipo_descuento == 'Empleado' && $student->discount > 0)
			{
				$year = substr($studenttransaction->transaction_description, 4, 4);

				$indicadorActualizarEstudiante = 1;
			}

		}
		
		if ($indicadorActualizarEstudiante == 1)
		{
			if ($student->number_of_brothers == 0)
			{
				$student->number_of_brothers = $year;
			}
			
			$student->balance = $year;

			$grado = $this->levelSublevel($student->level_of_study);

			$secciones = $this->Studenttransactions->Students->Sections->find('all')
			->where(['sublevel' => $grado, 'section' => 'A'])
			->order(['id' => 'DESC']);

			$seccion = $secciones->first();

			if ($seccion)
			{
				$student->section_id = $seccion->id;
			}

			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
			}	
		}
        return;
    }

    public function reverseTransaction($id = null, $amount = null, $billNumber = null, $tasaCambio = null)
    {
		$grados = 
		[
			"Pre-kinder",
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
			"5to. A??o"
		];

		$gradoEstudiante = 0;
		$gradoAnteriorEstudiante = 0;
		$indicadorGradoEncontrado = 0;
		$indice = 0;
		$indicadorActualizarEstudiante = 0;

        $studenttransaction = $this->Studenttransactions->get($id);
        		
		$montoReversoDolar = round($amount / $tasaCambio, 2); 

		$studenttransaction->amount_dollar = $studenttransaction->amount_dollar - $montoReversoDolar;
				
		if ($studenttransaction->original_amount != $studenttransaction->amount)
		{
			$studenttransaction->amount = $studenttransaction->original_amount;
		}
								
		if ($studenttransaction->amount > $studenttransaction->amount_dollar)
		{
			$studenttransaction->partial_payment = 1;
			$studenttransaction->paid_out = 0;
		} 
		else
		{
			$studenttransaction->partial_payment = 0;
			$studenttransaction->paid_out = 1;
		}
			
        if ($studenttransaction->bill_number == $billNumber)
        {
            $studenttransaction->bill_number = 0;
        }
							
        if (!($this->Studenttransactions->save($studenttransaction)))
        {
            $this->Flash->error(__('La transacci??n del alumno no pudo ser actualizada, vuelva a intentar.'));
        }
 
		if ($studenttransaction->transaction_type == 'Matr??cula')
		{		
			$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);
			$indicadorActualizarEstudiante = 1;
		}
		elseif (substr($studenttransaction->transaction_description, 0, 3) == 'Sep')
		{
			$student = $this->Studenttransactions->Students->get($studenttransaction->student_id);
			if ($student->tipo_descuento == 'Hijos' && $student->discount > 0)
			{
				$indicadorActualizarEstudiante = 1;
			}
			elseif ($student->tipo_descuento == 'Empleado' && $student->discount > 0)
			{
				$indicadorActualizarEstudiante = 1;
			}
		}

		if ($indicadorActualizarEstudiante == 1)
		{
			if ($student->balance == $student->number_of_brothers)
			{
				$student->balance = 0;
				$student->number_of_brothers = 0;
			}
			else
			{
				$student->balance = $student->balance - 1;

				$secciones = $this->Studenttransactions->Students->Sections->find('all');

				foreach ($secciones as $seccion)
				{
					if ($seccion->id == $student->section_id)
					{
						$gradoEstudiante = $seccion->sublevel;
						break;
					}
				}

				foreach ($grados as $grado)
				{
					if ($gradoEstudiante == $grado)
					{
						$indicadorGradoEncontrado = 1;
						break; 
					}
					$indice++;
				}

				if ($indicadorGradoEncontrado == 1)
				{
					if ($indice > 0)
					{
						$gradoAnteriorEstudiante = $grados[$indice - 1];
						foreach ($secciones as $seccion)
						{
							if ($seccion->sublevel == $gradoAnteriorEstudiante && $seccion->section == "A")
							{
								$student->section_id = $seccion->id;
								break;
							}
						}
					}
					else
					{
						$student->section_id = 1;
					}			
				}
				else
				{
					$student->section_id = 1;
				}
			}
		
			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
			}	
		}
		return;
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studenttransaction = $this->Studenttransactions->get($id);
        if ($this->Studenttransactions->delete($studenttransaction)) {
            $this->Flash->success(__('The studenttransaction has been deleted.'));
        } else {
            $this->Flash->error(__('The studenttransaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function createQuotasRegularPrevious($studentId = null)
    {
		$indicadorError = 0;
		
		$this->loadModel('Schools');
		
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->previous_year_registration;
		       
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        $studenttransaction->transaction_type = 'Matr??cula';
        $studenttransaction->transaction_description = 'Matr??cula' . ' ' . $quotaYear;
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
		}
		
		if ($indicadorError == 0)
		{

			$studenttransaction = $this->Studenttransactions->newEntity();
			
			$studenttransaction->student_id = $studentId;
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

            $studenttransaction->transaction_type = 'Seguro escolar';
            $studenttransaction->transaction_description = 'Seguro escolar' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}
		
		if ($quotaYear > 2018)
		{
			if ($indicadorError == 0)
			{
				$studenttransaction = $this->Studenttransactions->newEntity();
		
				$studenttransaction->student_id = $studentId;
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

				$studenttransaction->transaction_type = 'Thales';
				$studenttransaction->transaction_description = 'Thales' . ' ' . $quotaYear;

				if (!($this->Studenttransactions->save($studenttransaction)))
				{
					$indicadorError = 1;
				}
			}
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
					break;
				}
			}
             
        }
		
		return $indicadorError;
	}

    public function createQuotasRegular($studentId = null)
    {
		$indicadorError = 0;
		
		$this->loadModel('Schools');
		
		$school = $this->Schools->get(2);
			
		$quotaYear = $school->current_year_registration;
		        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        $studenttransaction->transaction_type = 'Matr??cula';
        $studenttransaction->transaction_description = 'Matr??cula' . ' ' . $quotaYear;
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
					break;
				}
			}    
        }

		return $indicadorError;
    }

    public function createQuotasNew($studentId = null, $startYear = null)
    {
		$indicadorError = 0;
		
        $quotaYear = $startYear;
        
        $nextYear = $quotaYear + 1;
        
        $studenttransaction = $this->Studenttransactions->newEntity();
        
        $studenttransaction->student_id = $studentId;
        
        $studenttransaction->transaction_type = 'Matr??cula';
        $studenttransaction->transaction_description = 'Matr??cula' . ' ' . $quotaYear;
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
		}
		/*
		if ($indicadorError == 0)
		{
			$studenttransaction = $this->Studenttransactions->newEntity();
			
			$studenttransaction->student_id = $studentId;	
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
               
            $studenttransaction->transaction_type = 'Servicio educativo';
            $studenttransaction->transaction_description = 'Servicio educativo' . ' ' . $quotaYear;

            if (!($this->Studenttransactions->save($studenttransaction)))
            {
                $indicadorError = 1;
            }
		}
		*/
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
                    break;
                }
            }
		}
		
		return $indicadorError;
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

    public function installmentsPayable($parentId = null, $studentId = null, $studentName = null, $description = null, $balance = null)
    {
        if ($description == 'Inscripci??n')
        {
            $checkInscription = $this->Studenttransactions->find('all', ['conditions' => ['student_id' => $studentId, 
                'transaction_description' => 'Matr??cula 2017'], 
                'order' => ['Studenttransactions.created' => 'DESC'] ]);
    
            $row = $checkInscription->first();
        
            if (!($row))
                $this->createQuotasInscription($studentId);
        }
        
        $query = $this->Studenttransactions->find('all')->where(['Studenttransactions.student_id' => $studentId, 'paid_out' => 0]);
        $this->set('studenttransactions', $this->paginate($query));

        $this->set(compact('studenttransactions', 'parentId', 'studentName', 'description', 'balance'));
        $this->set('_serialize', ['studenttransactions']);
    }
    
    public function checkIn($parentId = null, $studentTransactionId = null, $studentName, $description = null)
    {
        $this->loadModel('Parentsandguardians');

        $studenttransaction = $this->Studenttransactions->get($studentTransactionId, [
            'contain' => []
        ]);
        
        $studenttransaction->invoiced = 1;
        
        if ($this->Studenttransactions->save($studenttransaction)) 
        {
            $this->Flash->success(__('La cuota ha sido facturada'));
            
            $parentsandguardians = $this->Parentsandguardians->get($parentId);
        
            $parentsandguardians->balance = $parentsandguardians->balance + $studenttransaction->amount;
            
            if (!($this->Parentsandguardians->save($parentsandguardians))) 
                $this->Flash->error(__('El saldo de la factura no pudo ser actualizado, intente nuevamente'));
            
            return $this->redirect(['action' => 'installmentsPayable', $parentId, $studenttransaction->student_id, $studentName, $description, $parentsandguardians->balance]);
        }
        else 
        {
            $this->Flash->error(__('The studenttransaction could not be saved. Please, try again.'));
        }
        $this->set(compact('studenttransaction'));
        $this->set('_serialize', ['studenttransaction']);
    }
    public function searchQuotas($studentId = null)
    {
        $this->autoRender = false;

        $jsondata = [];

        $jsondata[0]["transaction_description"] = "Sin transacciones"; 
        $jsondata[1]["transaction_description"] = "Con transacciones"; 

        return $jsondata[1]["transaction_description"];
    }

    public function responsejson($studentId = null)
    {
        $studenttransactions = $this->Studenttransactions->find('all')->where(['student_id' => $studentId, 'invoiced' => 0]);
    
        $results = $studenttransactions->toArray();
        
        $json = json_encode($results); 
        
        return $json;
    }
    public function invoiceFee($id = null, $billNumber = null)
    {
        $studenttransaction = $this->Studenttransactions->get($id);
        
        $studenttransaction->invoiced = 1;
        $studenttransaction->bill_number = $billNumber;
        
        if (!($this->Studenttransactions->save($studenttransaction))) 
        {
            $this->Flash->error(__('La transacci??n del estudiante no pudo ser actualizada, intente nuevamente'));
        }
    }
    public function differenceAugust($newAmount = null, $yearDifference = null, $noDifference = null)
    {
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;

		$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', '$newAmount: ' . $newAmount . ' $yearDifference: ' . $yearDifference . ' $noDifference: ' . $noDifference );
		
		$accountRecords = 0;
		
		$swUpdate = 0;
					
		$swError = 0;
						
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		$arrayResult['adjust'] = 0;
		
		$arrayResult = $this->resetStudents();

		if ($arrayResult['indicator'] == 0)
		{
			$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['transaction_description' => "Ago " . $yearDifference]]);
							
			if ($studentTransactions)
			{			
				foreach ($studentTransactions as $studentTransaction)
				{
					$swUpdate = 0;
					$arrayResult = [];	
					$arrayResult['indicator'] = 0;
					$arrayResult['message'] = '';
										
					if ($noDifference == 0)
					{
						$swUpdate = 1;
						$arrayResult = $this->updateTransaction($studentTransaction, $newAmount);
					}	
					elseif ($studentTransaction->paid_out == 0)
					{
						$swUpdate = 1;
						$arrayResult = $this->updateTransaction($studentTransaction, $newAmount);						
					}
										
					if ($arrayResult['indicator'] == 0)
					{
						if ($swUpdate == 1)
						{
							$accountRecords++;
						}
					}
					else
					{
						$swError = 1;
						break;
					}
				}
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'No se encontraron transacciones de agosto ' . $yearDifference);
				$swError = 1;					
			}
			
			$arrayResult['indicator'] = $swError;
			
			if ($swError == 0)
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'Registros actualizados: ' . $accountRecords);
				$arrayResult['message'] = 'Se actualiz?? exitosamente la diferencia de agosto';
				$arrayResult['adjust'] = $accountRecords; 
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'Programa con error, solo se actualizaron ' . $accountRecords . ' transacciones');
				$arrayResult['message'] = 'No se actualiz?? exitosamente la diferencia de agosto';
				$arrayResult['adjust'] = $accountRecords;
			}
		}
		else
		{
			$arrayResult['adjust'] = 0;
		}
			
		return $arrayResult;
    }

    public function adjustTransactions()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) 
        {
            $transactions = json_decode($_POST['transactions']);
            $_POST = [];
    
            $transactionIndicator = 0;
    
            foreach ($transactions as $transaction) 
            {
                $studenttransaction = $this->Studenttransactions->get($transaction->idTransaction);
				
				if ($studenttransaction->original_amount != $transaction->originalAmount)
                {
					$studenttransaction->original_amount = $transaction->originalAmount;

					if ($studenttransaction->amount > $studenttransaction->original_amount)
					{
						$this->Flash->error(__('Error: El monto de la cuota no puede ser menor al monto abonado: ' . $studenttransaction->transaction_description . ' Cuota: ' . $studenttransaction->original_amount . ' Abonado: ' . $studenttransaction->amount));
						
						$transactionIndicator = 1;                     
					}
					else
					{
						if ($studenttransaction->amount == $studenttransaction->original_amount)
						{
							$studenttransaction->paid_out = 1;
							$studenttransaction->partial_payment = 0;                            
						}
						elseif ($studenttransaction->amount == 0)
						{
							$studenttransaction->paid_out = 0;
							$studenttransaction->partial_payment = 0;                                                
						}
						else
						{
							$studenttransaction->paid_out = 0;
							$studenttransaction->partial_payment = 1;                                                
						}

						if (!($this->Studenttransactions->save($studenttransaction)))  
						{
							$this->Flash->error(__('No se pudo actualizar la cuota' . $studenttransaction->transaction_description));
							
							$transactionIndicator = 1;   
						}
					}     
				}
            }

            if ($transactionIndicator == 0)
            {
                $this->Flash->success(__('Las cuotas fueron actualizadas correctamente'));
                
                return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
            }
            else
            {
                $this->Flash->error(__('Alguna cuota no fue actualizada, por favor intente nuevamente'));

                return $this->redirect(['controller' => 'Students', 'action' => 'modifyTransactions']);
            }
        }
        else
        {
            $this->Flash->error(__('Por motivos de seguridad se cerr?? la sesi??n. Por favor intente 
                actualizar las cuotas nuevamente'));

            return $this->redirect(['controller' => 'Students', 'action' => 'modifyTransactions']);
        }
    }
    public function newRegistration($newAmount = null, $yearRegistration = null)
    {
        $this->autoRender = false;
        
        $studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['transaction_description' => 'Matr??cula ' . $yearRegistration]]);

        $account = 0;

        if ($studentTransactions) 
        {
            foreach ($studentTransactions as $studentTransaction)
            {

                $studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);

                if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
                {
                    $studentTransactionGet->original_amount = $newAmount;
                    $studentTransactionGet->amount = $newAmount;
                    $studentTransactionGet->paid_out = 0;
                    $studentTransactionGet->partial_payment = 0;
                }
                elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
                {
                    $differenceAmount = $newAmount - $studentTransactionGet->original_amount;
                    $studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
                    $studentTransactionGet->original_amount = $newAmount;
                    $studentTransactionGet->paid_out = 0;
                    $studentTransactionGet->partial_payment = 1;
                }

                if (!($this->Studenttransactions->save($studentTransactionGet)))
                {
                    $this->Flash->error(__('No pudo ser grabada la matr??cula correspondiente al alumno cuyo ID es: ' . $studentTransaction->student_id));
                }

            $account++;
            
            }
            $this->Flash->success(__('Total matr??culas actualizadas:  ' . $account)); 
        }
        return;
    }
    
    public function newMonthlyPayment($previousMonthlyPayment = null, $newAmount = null, $monthFrom = null, $yearFrom = null, $defaulters = null, $swDateException = null,$dateException = null)
    {
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
		$excels = new ExcelsController();
		
		$binnacles = new BinnaclesController;
			
		$swError = 0;
						
		$arrayResult = [];
		$arrayResult['indicator'] = 0;
		$arrayResult['adjust'] = 0;

		$previousMonthlyPayment80 = $previousMonthlyPayment * 0.8;
		
		$previousMonthlyPayment50 = $previousMonthlyPayment * 0.5;
		
		$newAmount80 = $newAmount * 0.8;
		
		$newAmount50 = $newAmount * 0.5;

		$yearMonthFrom = $yearFrom . $monthFrom;
		
		$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
		
		$accountGeneral = 0;
		$accountDifferentAugust = 0;
		$accountAugust = 0;
		$accountPaymentException = 0;
		$accountAdjust = 0;
		$accountOutSequence = 0;
		$account20 = 0;
		$account50 = 0;
		$accountRegular = 0;
		$accountIrregular = 0;
		$swAdjust = 0;
		$previousIdStudent = 0;
		$accountDateFrom = 0;
		$accountAmountCero = 0;
		$accountStudentChange = 0;
		$accountSelect = 0;
		$adjustDefaulters = 0;
		
		if ($defaulters == 1)
		{
			$swError = $this->discountStudents($monthFrom, $yearFrom, $previousMonthlyPayment);
			if ($swError == 0)
			{
				$arrayResult = $this->adjustDefaulters($monthFrom, $yearFrom, $newAmount); 
			}
		}
		
		if ($arrayResult['indicator'] == 0)
		{	
			$adjustDefaulters = $arrayResult['adjust'];
			
			$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_type' => 'Mensualidad'], ['payment_date >=' => $dateFrom]], 
				'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
				
			$accountSelect = $studentTransactions->count();
			
			if ($studentTransactions) 
			{				
				foreach ($studentTransactions as $studentTransaction)
				{			
					$accountGeneral++;
					
					$month = substr($studentTransaction->transaction_description, 0, 3);
							
					if ($month != 'Ago')
					{
						$accountDifferentAugust++;
														
						if ($swDateException == 1)
						{							
							if ($studentTransaction->payment_date->year == $dateFrom->year && $studentTransaction->payment_date->month == $dateFrom->month)
							{			
								$accountDateFrom++;
								
								if ($studentTransaction->amount == 0)
								{
									$accountAmountCero++;
									
									if ($previousIdStudent != $studentTransaction->student_id)
									{
										$accountStudentChange++;
										
										$previousIdStudent = $studentTransaction->student_id;
									
										$swAdjust = $this->verifyPayment($dateFrom, $dateException, $studentTransaction->student_id);
																		
										if ($swAdjust == 0)
										{
											if ($accountPaymentException == 0)
											{
												$columns = [];
												$columns['report'] = 'Alumnos pago completo a??o escolar';
												$columns['start_end'] = 'start';
											
												$swError = $excels->add($columns);	
												if ($swError > 0)
												{
													$arrayResult['indicator'] = 1;
													$arrayResult['message'] = 'No se pudo inicializar la tabla excel con el reporte de Alumnos pago completo a??o escolar';
													break;
												}
											}											
											$accountPaymentException++;
											
											$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);

											$columns = [];
											$columns['report'] = 'Alumnos pago completo a??o escolar';
											$columns['number'] = $accountPaymentException;
											$columns['col1'] = $student->id;
											$columns['col2'] = $student->full_name;
											
											$swError = $excels->add($columns);
											
											if ($swError > 0)
											{
												$arrayResult['indicator'] = 1;
												$arrayResult['message'] = 'No se pudo grabar en la tabla excel el alumno pago completo a??o escolar id ' . student_id;
												break;
											}
										}
										else
										{
											$accountAdjust++;
										}
									}
									else
									{
										$swAdjust = 0;
										$accountOutSequence++;
									}
								}
								else
								{
									$swAdjust = 1;
									$accountAdjust++;
								}
							}
						}
						else
						{
							$accountAdjust++;
							$swAdjust = 1;
						}
						
						if ($swAdjust == 1)
						{               							
							$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
							
							if ($studentTransaction->original_amount == $previousMonthlyPayment80)
							{
								$account20++;
								
								if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
								{
									$studentTransactionGet->original_amount = $newAmount80;
									$studentTransactionGet->amount = $newAmount80;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 0;
								}
								elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
								{
									$differenceAmount = $newAmount80 - $studentTransactionGet->original_amount;
									$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
									$studentTransactionGet->original_amount = $newAmount80;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 1;
								}
							}
							elseif ($studentTransaction->original_amount == $previousMonthlyPayment50)
							{
								$account50++;
								if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
								{
									$studentTransactionGet->original_amount = $newAmount50;
									$studentTransactionGet->amount = $newAmount50;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 0;
								}
								elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
								{
									$differenceAmount = $newAmount50 - $studentTransactionGet->original_amount;
									$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
									$studentTransactionGet->original_amount = $newAmount50;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 1;
								}
							}
							elseif ($studentTransaction->original_amount == $previousMonthlyPayment)
							{
								$accountRegular++;    
								if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
								{
									$studentTransactionGet->original_amount = $newAmount;
									$studentTransactionGet->amount = $newAmount;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 0;
								}
								elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
								{
									$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
									$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
									$studentTransactionGet->original_amount = $newAmount;
									$studentTransactionGet->paid_out = 0;
									$studentTransactionGet->partial_payment = 1;
								}
							}
							else
							{
								$accountIrregular++;     
							}

							if (!($this->Studenttransactions->save($studentTransactionGet)))
							{
								$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', 'No se pudo grabar la transacci??n con el id ' . $studentTransactionGet->id);
								$swError = 1;
								break;
							} 
						}  
					}
					else
					{
						$accountAugust++;
					}
				}
				if ($swError == 0)
				{
					if ($swDateException == 1 && $accountAdjust > 0)
					{
						$columns = [];
						$columns['report'] = 'Alumnos pago completo a??o escolar';
						$columns['start_end'] = 'end';
					
						$swError = $excels->add($columns);	
						if ($swError == 0)
						{
							$arrayResult['indicator'] = 0;
							$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';							
						}
						else
						{
							$arrayResult['indicator'] = 1;
							$arrayResult['message'] = 'No se pudo finalizar la tabla excel con el reporte de alumnos pago completo a??o escolar';
						}						
					}
					else
					{
						$arrayResult['indicator'] = 0;
						$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';
					}
				}
				else
				{
					$arrayResult['indicator'] = 1;
					$arrayResult['message'] = 'Error al actualizar las mensualidades';				
				}
				
			}
			else
			{
				$arrayResult['indicator'] = 1;
				$arrayResult['message'] = 'No se encontraron mensualidades';
			}
		}
		else
		{ 
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudieron actualizar las mensualidades de alumnos morosos';		
		}
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$yearFrom: ' . $yearFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$monthFrom: ' . $monthFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom->year: ' . $dateFrom->year);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom->month: ' . $dateFrom->month);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateFrom: ' . $dateFrom);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountSelect: ' . $accountSelect);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountDifferentAugust: ' . $accountDifferentAugust);	
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAugust: ' . $accountAugust);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountDateFrom: ' . $accountDateFrom);	
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAmountCero: ' . $accountAmountCero);		
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountOutSequence: ' . $accountOutSequence);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountAdjust: ' . $accountAdjust);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$accountPaymentException: ' . $accountPaymentException);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$dateException: ' . $dateException);
		$binnacles->add('controller', 'Studenttransactions', 'newMonthlyPayment', '$adjustDefaulters: ' . $adjustDefaulters);		
		
		$arrayResult['adjust'] = $accountAdjust;
		$arrayResult['notAdjust'] = $accountPaymentException; 	
		$arrayResult['adjustDefaulters'] = $adjustDefaulters;		
        return $arrayResult;
    }

    function numberMonth($month = null)
    {
        $monthsSpanish = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $monthsEnglish = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $spanishMonth = str_replace($monthsEnglish, $monthsSpanish, $month);
        return $spanishMonth;
    }

    public function assignSection()
    {	
        if ($this->request->is('post'))
        {
			$this->loadModel('Schools');

			$school = $this->Schools->get(2);
			
			$currentYearRegistration = $school->current_year_registration;
			
			$anoEscolarActual = $school->current_school_year;
			
			setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
			date_default_timezone_set('America/Caracas');

			$fechaHoraActual = Time::now();
			
			if ($currentYearRegistration != $anoEscolarActual)
			{
				if ($fechaHoraActual->month == 9)
				{
					$estudiantes = $this->Studenttransactions->Students->find()
						->where(['Students.student_condition' => 'Regular']);
				
					$indicadorNoActualizado = 0;
					foreach ($estudiantes as $estudiante)
					{
						$estudianteBuscado = $this->Studenttransactions->Students->get($estudiante->id);
						
						$estudianteBuscado->becado_ano_anterior = $estudianteBuscado->scholarship;
						$estudianteBuscado->tipo_descuento_ano_anterior = $estudianteBuscado->tipo_descuento;
						$estudianteBuscado->descuento_ano_anterior = $estudianteBuscado->discount;
						
						if (!($this->Studenttransactions->Students->save($estudianteBuscado)))
						{
							$this->Flash->error(__('No se pudo actualizar el estudiante con el ID: ' . $estudianteBuscado->id));
							$indicadorNoActualizado = 1;
						}
					}
					if ($indicadorNoActualizado == 0)
					{
						$school->current_school_year = $school->current_year_registration;
						if (!($this->Schools->save($school))) 
						{
							$this->Flash->error(__('No se pudo actualizar el a??o escolar'));
							return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
						}	
						else
						{
							$this->Flash->success(__('Se actualizaron correctamente los datos para el nuevo a??o escolar'));
						}
					}
				}
				else
				{
					$this->Flash->error(__('Estimado usuario no se pueden asignar secciones cuando se inicia el per??odo de inscripci??n de alumnos regulares: ' . $fechaHoraActual->month));
					return $this->redirect(['controller' => 'Users', 'action' => 'wait']);
				}
			}
			
            if (isset($_POST['level'])) // Si el usuario requiere que se muestren los alumnos inscritos para un nivel de estudio espec??fico
            {
                $level = $_POST['level'];
            }
            else // El usuario ya actualiz?? las secciones en el formulario y se procede a actualizar en la base de datos
            {
                $result = 0;
                
                $accountStudent = 0;
                
                foreach ($_POST['student'] as $valor)
                {
                    $student = $this->Studenttransactions->Students->get($valor['id']);

                    if ($accountStudent == 0) // Si es el primer alumno de este grupo
                    {
                        $level = $student->level_of_study; // Tomamos el nivel de estudio del grupo
                        
                        $sublevel = $this->levelSublevel($level); 
                        
                        $sections = $this->Studenttransactions->Students->Sections->find('all')
                            ->where(['sublevel' => $sublevel])
                            ->order(['Sections.section' => 'ASC']);
                    }

                    foreach ($sections as $section)
                    {
                        if ($valor['section'] == $section->section)
                        {
                            $student->section_id = $section->id; // actualizamos la secci??n del alumno de acuerdo con la secci??n que asign?? el usuario
                        }
                    }
					
                    if (!($this->Studenttransactions->Students->save($student))) // Se actualizan los datos en la base de datos
                    {
                        $result = 1;
                        
                        $this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $valor['id']));            
                    }
					
                    $accountStudent++;
                }
                if ($result == 0) // Si todo ok
                {
                    $this->Flash->success(__('Los alumnos fueron asignados exitosamente a su secci??n'));
                } 
            }
        }
		
		$assign = 1;
		        
        if (isset($level))
        {
            $studentTransactions = TableRegistry::get('Studenttransactions');
            						
			$transactionDescription = 'Matr??cula ' . $currentYearRegistration;
			
			// Busqueda de todos los inscritos
			$inscribed = $studentTransactions->find()
				->select(
					['Studenttransactions.id',
					'Students.level_of_study'])
				->contain(['Students'])
				->where([['Studenttransactions.transaction_description' => $transactionDescription],
					['Students.balance' => $currentYearRegistration],
					['Students.level_of_study !=' => ""], 
					['Students.student_condition' => 'Regular']]); 
	
			$totalEnrolled = $inscribed->count();
						
			// Busqueda de todos los inscritos en el nivel de estudio que seleccion?? el usuario			
			$studentsLevel = $studentTransactions->find()
				->select(
					['Studenttransactions.id',
					'Studenttransactions.transaction_description',
					'Studenttransactions.amount',
					'Studenttransactions.original_amount',
					'Students.id',
					'Students.surname',
					'Students.second_surname',
					'Students.first_name',
					'Students.second_name',
					'Students.level_of_study',
					'Students.section_id',
					'Sections.level',
					'Sections.sublevel',
					'Sections.section'])
				->contain(['Students' => ['Sections']])
				->where([['Studenttransactions.transaction_description' => $transactionDescription],
					['Students.balance' => $currentYearRegistration],
					['Students.level_of_study' => $level],
					['Students.student_condition' => 'Regular']])
				->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);
				
			$totalLevel = $studentsLevel->count();
						
			$sectionA = 0;
			$sectionB = 0;
			$sectionC = 0;

			if ($level != '')
			{
				$sublevel = $this->levelSublevel($level);

				// B??squeda de todas las secciones que pertenecen al nivel de estudio 
				$sections = $this->Studenttransactions->Students->Sections->find('all')
					->where(['sublevel' => $sublevel])
					->order(['Sections.section' => 'ASC']);

				foreach ($sections as $section)
				{
					if ($section->section == 'A')
					{
						$idSectionA = $section->id; // Guardo el ID de la secci??n "A" del nivel de estudio
					}
				}                    
			}

			foreach ($studentsLevel as $studentsLevels) // Recorro todos los estudiantes inscritos en el nivel de estudio seleccionado
			{     
				if ($level != '')
				{
					$swSection = 0;

					foreach ($sections as $section) 
					{
						if ($studentsLevels->student->section_id == $section->id) // Si coincide la secci??n del estudiante con alguna de las secciones del nivel de estudio que seleccion?? el usuario
						{
							$swSection = 1; // Asigno el valor 1, que quiere decir que el estudiante ya fue asignado a la nueva secci??n en su nuevo nivel de estudio
						}
					}
					
					if ($swSection == 0) // Si no se le ha asignado la secci??n al estudiante en su nuevo nivel de estudio
					{
						$student = $this->Studenttransactions->Students->get($studentsLevels->student->id);

						$student->section_id = $idSectionA; // Le asigno la secci??n "A" como gen??rica        

						if (!($this->Studenttransactions->Students->save($student))) // Actualizo la base de datos con la nueva secci??n del alumno
						{                       
							$this->Flash->error(__('No pudo ser actualizado el alumno identificado con el id: ' . $student->id));            
						}
					}
					
				}

				if ($studentsLevels->student->section->section == 'A')
				{
					$sectionA++;
				}
				elseif ($studentsLevels->student->section->section == 'B')
				{
					$sectionB++;
				}
				elseif ($studentsLevels->student->section->section == 'C')
				{
					$sectionC++;
				}
				else
				{
					$sectionA++;
				}
			}
			
			$levelChat = $this->replaceCharacters($level);
		
			$this->set(compact('level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign'));
			$this->set('_serialize', ['level', 'studentsLevel', 'totalEnrolled', 'totalLevel', 'sectionA', 'sectionB', 'sectionC', 'levelChat', 'assign']);
        }
		else
		{
			$this->set(compact('assign'));
            $this->set('_serialize', ['assign']);
		}
    }
    public function levelSublevel($level = null)
    {
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
        $sublevel = str_replace($levelOfStudy, $sub, $level);
        return $sublevel;
    }
    public function searchSections()
    {
        if ($this->request->is('post')) 
        {
            return $this->redirect(['action' => 'reportSections', $_POST['level_of_study'],  $_POST['section']]);
        }

        $this->set(compact('sections'));
    }
    public function reportSections($level = null, $section = null)
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
        
        $studentTransactions = TableRegistry::get('Studenttransactions');

        $studentsFor = $studentTransactions->find()
            ->select(
                ['Studenttransactions.id',
                'Studenttransactions.transaction_description',
                'Studenttransactions.amount',
                'Students.id',
                'Students.surname',
                'Students.second_surname',
                'Students.first_name',
                'Students.second_name',
                'Students.level_of_study',
                'Students.section_id',
                'Sections.level',
                'Sections.sublevel',
                'Sections.section'])
            ->contain(['Students' => ['Sections']])
            ->where([['Studenttransactions.transaction_description' => 'Matr??cula 2017'],
                ['Studenttransactions.amount <' => 69500],
                ['Students.level_of_study' => $level],
                'Sections.section' => $section])
            ->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

        $account = $studentsFor->count();
        
        $totalPages = ceil($studentsFor->count() / 30);

        $this->set(compact('school', 'studentsFor', 'level', 'section', 'totalPages'));
        $this->set('_serialize', ['school', 'studentsFor', 'level', 'section', 'totalPages']);
    }
    public function reportLevel($level = null)
    {
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

        $fechaActual = Time::now();
		
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);

		$currentYearRegistration = $school->current_year_registration;
					
		$transactionDescription = 'Matr??cula ' . $currentYearRegistration;

		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.section_id',
				'Sections.level',
				'Sections.sublevel',
				'Sections.section'])
			->contain(['Students' => ['Sections']])
			->where([['Studenttransactions.transaction_description' => $transactionDescription],
				['Students.balance' => $currentYearRegistration],
				['Students.level_of_study' => $level],
				['Students.student_condition' => 'Regular']])
			->order(['Sections.section' => 'ASC', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

		$account = $studentsFor->count();
		
		$totalPages = ceil($studentsFor->count() / 30) + 2;
		
		$levelChatScript = $this->replaceChatScript($level);

		$this->set(compact('school', 'studentsFor', 'level', 'totalPages', 'levelChatScript', 'fechaActual'));
		$this->set('_serialize', ['school', 'studentsFor', 'level', 'totalPages', 'levelChatScript', 'fechaActual']);
    }
    public function replaceCharacters($level = null)
    {
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
        $chat = ['Pre-escolar%2c%20pre-kinder',                                
                        'Pre-escolar%2c%20kinder',
                        'Pre-escolar%2c%20preparatorio',
                        'Primaria%2c%201er.%20grado',
                        'Primaria%2c%202do.%20grado',
                        'Primaria%2c%203er.%20grado',
                        'Primaria%2c%204to.%20grado',
                        'Primaria%2c%205to.%20grado',
                        'Primaria%2c%206to.%20grado',
                        'Secundaria%2c%201er.%20a??o',
                        'Secundaria%2c%202do.%20a??o',
                        'Secundaria%2c%203er.%20a??o',
                        'Secundaria%2c%204to.%20a??o',
                        'Secundaria%2c%205to.%20a??o'];
        $levelChat = str_replace($levelOfStudy, $chat, $level);
        return $levelChat;
    }
    public function replaceChatScript($level = null)
    {
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
        $chat = ['Pre-kinder',                                
                    'Kinder',
                    'Preparatorio',
                    '1er_grado',
                    '2do_grado',
                    '3er_grado',
                    '4to_grado',
                    '5to_grado',
                    '6to_grado',
                    '1er_a??o',
                    '2do_a??o',
                    '3er_a??o',
                    '4to_a??o',
                    '5to_a??o'];
        $levelChatScript = str_replace($levelOfStudy, $chat, $level);
        return $levelChatScript;
    }
    public function reportStudentGeneral()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
		$concept = 'Matr??cula ' . $school->current_school_year;

		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
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
				'Parentsandguardians.type_of_identification',
				'Parentsandguardians.identidy_card',
				'Parentsandguardians.surname',
				'Parentsandguardians.second_surname',
				'Parentsandguardians.first_name',
				'Parentsandguardians.second_name'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $concept],
				['Studenttransactions.amount > ' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);

            $account = $studentsFor->count();
            
            $totalPages = ceil($studentsFor->count() / 20);

            setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
            date_default_timezone_set('America/Caracas');

            $currentDate = Time::now();

            $this->set(compact('school', 'studentsFor', 'totalPages', 'currentDate'));
            $this->set('_serialize', ['school', 'studentsFor', 'totalPages', 'currentDate']);

    }
    
    public function reportFamilyStudents()
    {
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
			
		$currentYearRegistration = $school->current_year_registration;
					
		$transactionDescription = 'Matr??cula ' . $currentYearRegistration;
		
		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.type_of_identification',
				'Students.identity_card',
				'Students.section_id',
				'Parentsandguardians.id',
				'Parentsandguardians.type_of_identification',
				'Parentsandguardians.identidy_card',
				'Parentsandguardians.surname',
				'Parentsandguardians.second_surname',
				'Parentsandguardians.first_name',
				'Parentsandguardians.second_name'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $transactionDescription],
				['Studenttransactions.amount < Studenttransactions.original_amount'], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);

		$account = $studentsFor->count();
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');

		$currentDate = Time::now();

		$idParent = 0;
		$accountRecords = 0;
		$accountChildren = 0;
		$accountFamily = 0;
		$accountUnHijo = 0;
		$accountDosHijos = 0;
		$accountTresHijos = 0;
		$accountCuatroHijos = 0;
		$accountCincoOMas = 0;

		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
				$accountChildren++;
				$accountFamily++;
				$accountRecords++;
			}
			else
			{
				if ($idParent != $studentsFors->student->parentsandguardian->id)
				{
					if ($accountChildren < 1)
					{
						$this->Flash->error(__('Error en contador de registros del padre identificado con el ID: ' . $studentsFors->student->parentsandguardian->id));
					}
					elseif ($accountChildren == 1)
					{
						$accountUnHijo++;
					}
					elseif ($accountChildren == 2)
					{
						$accountDosHijos++;
					}
					elseif ($accountChildren == 3)
					{
						$accountTresHijos++;
					}
					elseif ($accountChildren == 4)
					{
						$accountCuatroHijos++;
					}
					elseif ($accountChildren >= 5)
					{
						$accountCincoOMas++;
					}
					$idParent = $studentsFors->student->parentsandguardian->id;
					$accountChildren = 1;
					$accountFamily++;
					$accountRecords++;
				}
				else
				{
					$accountChildren++; 
					$accountRecords++;                        
				}
			}
		}
		if ($accountChildren < 1)
		{
			$this->Flash->error(__('Error en contador de registros del padre identificado con el ID: ' . $studentsFors->student->parentsandguardian->id));
		}
		elseif ($accountChildren == 1)
		{
			$accountUnHijo++;
		}
		elseif ($accountChildren == 2)
		{
			$accountDosHijos++;
		}
		elseif ($accountChildren == 3)
		{
			$accountTresHijos++;
		}
		elseif ($accountChildren == 4)
		{
			$accountCuatroHijos++;
		}
		elseif ($accountChildren >= 5)
		{
			$accountCincoOMas++;
		}

		$this->set(compact('school', 'studentsFor', 'currentDate', 'account', 'accountUnHijo', 'accountDosHijos', 'accountTresHijos', 'accountCuatroHijos', 'accountCincoOMas', 'accountFamily'));
		$this->set('_serialize', ['school', 'studentsFor', 'currentDate', 'account', 'accountUnHijo', 'accountDosHijos', 'accountTresHijos', 'accountCuatroHijos', 'accountCincoOMas', 'accountFamily']);
    }

    public function discountQuota20()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

		$idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $arrayStudents = [];
		$discountUpdate20 = 0;
		$accountStudents = 0;
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students20 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.tipo_descuento' => 'Hijos', 'Students.discount' => 20]]);
		
        if ($students20)
		{
			foreach ($students20 as $students20s)
			{
				$student = $this->Studenttransactions->Students->get($students20s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student20s->id));
				}
            }
		}
		
		$registration = 'Matr??cula ' . $startingYear;
		
		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_type',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.section_id',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
				
		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($idParent != $studentsFors->student->parentsandguardian->id)
			{
				if ($accountChildren == 3)
				{
					$this->discount20($arrayStudents);
					$discountUpdate20++;
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($school->current_school_year < $school->current_year_registration)
			{
				if ($studentsFors->student->section_id === null)
				{
					$this->Flash->success(__('Id Alumno ' . $studentsFors->student->id . ' section_id ' . $studentsFors->student->section_id));
					$level = "No asignado";
				}
				else
				{
					$seccion = $this->Sections->get($studentsFors->student->section_id);
					$level = $seccion->sublevel;
				}
				$order = $this->gradoPosicion($level);
			}
			else
			{
				$level = $studentsFors->student->level_of_study;
				$order = $this->orderLevel($level);	
			}
													
			$arrayStudents[$accountStudents]['order'] = $order;
			$arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;

			$accountStudents++;
			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren == 3)
		{
			$this->discount20($arrayStudents);
			$discountUpdate20++;
		}
				
		$this->Flash->success(__('Total alumnos a los que se les aplic?? el descuento del 20%: ' . $discountUpdate20));
    }
    
    public function discount20($arrayStudents)
    {
        arsort($arrayStudents);

        foreach ($arrayStudents as $arrayStudent)
        {
			$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
			$student->discount = 20;
			$student->tipo_descuento = "Hijos";

			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
			}
			break;
		}
    }

    public function discountQuota50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

		$idParent = 0;
        $accountRecords = 0;
        $accountChildren = 0;
        $arrayStudents = [];
		$discountUpdate50 = 0;
		$accountStudents = 0;
		
        $this->loadModel('Schools');
		
		$this->loadModel('Sections');

        $school = $this->Schools->get(2);

        $currentYear = $school->current_school_year;
        
        $lastYear = $currentYear - 1;
        
        $nextYear = $currentYear + 1;
        
        $startingYear = $currentYear;
            
        $finalYear = $nextYear;  

		$students50 = $this->Studenttransactions->Students->find('all', ['conditions' => ['Students.tipo_descuento' => 'Hijos', 'Students.discount' => 50]]);
		
        if ($students50)
		{
			foreach ($students50 as $students50s)
			{
				$student = $this->Studenttransactions->Students->get($students50s->id);
				
				$student->discount = 0;
				
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$this->Flash->error(__('No se pudo inicializar la columna discount en el registro Nro. ' . $student50s->id));
				}
            }
		}
		
		$registration = 'Matr??cula ' . $startingYear;
		
		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_type',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.section_id',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
				
		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($idParent != $studentsFors->student->parentsandguardian->id)
			{
				if ($accountChildren > 3)
				{
					$this->discount50($arrayStudents);
					$discountUpdate50++;
				}
				$accountStudents = 0;
				$accountChildren = 0;
				$arrayStudents = [];

				$idParent = $studentsFors->student->parentsandguardian->id;
			}
			
			if ($school->current_school_year < $school->current_year_registration)
			{
				if ($studentsFors->student->section_id === null)
				{
					$this->Flash->success(__('Id Alumno ' . $studentsFors->student->id . ' section_id ' . $studentsFors->student->section_id));
					$level = "No asignado";
				}
				else
				{
					$seccion = $this->Sections->get($studentsFors->student->section_id);
					$level = $seccion->sublevel;
				}
				$order = $this->gradoPosicion($level);
			}
			else
			{
				$level = $studentsFors->student->level_of_study;
				$order = $this->orderLevel($level);	
			}
													
			$arrayStudents[$accountStudents]['order'] =  $order;
			$arrayStudents[$accountStudents]['id'] = $studentsFors->student->id;

			$accountStudents++;
			$accountRecords++;
			$accountChildren++;	
		}			

		if ($accountChildren > 3)
		{
			$this->discount50($arrayStudents);
			$discountUpdate50++;
		}
				
		$this->Flash->success(__('Total alumnos a los que se les aplic?? el descuento del 50%: ' . $discountUpdate50));
    }
    
    public function discount50($arrayStudents)
    {
        arsort($arrayStudents);

        foreach ($arrayStudents as $arrayStudent)
        {
			$student = $this->Studenttransactions->Students->get($arrayStudent['id']);
				
			$student->discount = 50;
			$student->tipo_descuento = "Hijos";

			if (!($this->Studenttransactions->Students->save($student)))
			{
				$this->Flash->error(__('No se pudo actualizar la columna discount en el registro Nro. ' . $arrayStudent['id']));
			}
			break;
		}
    }
	
    public function discountFamily80()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();
	
        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
        $currentYear = $school->current_year_registration;
               
		$registration = 'Matr??cula ' . $currentYear;
		
		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_type',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
		
		$idParent = 0;
		$accountRecords = 0;
		$accountChildren = 0;
		$accountTresHijos = 0;
		$arrayFamily80 = [];
		$accountFamily80 = 0;

		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
				
				$currentFamily = $studentsFors->student->parentsandguardian->family;
				$currentFamilyId = $studentsFors->student->parentsandguardian->id;
				$accountChildren++;
				$accountRecords++;

			}
			else
			{
				if ($idParent != $studentsFors->student->parentsandguardian->id)
				{
					if ($accountChildren == 3)
					{
						$arrayFamily80[$accountFamily80]['family'] = $currentFamily;
						$arrayFamily80[$accountFamily80]['id'] = $currentFamilyId;
						$accountFamily80++;
						$accountTresHijos++;
					}
					$idParent = $studentsFors->student->parentsandguardian->id;
					
					$currentFamily = $studentsFors->student->parentsandguardian->family;
					$currentFamilyId = $studentsFors->student->parentsandguardian->id;
					
					$accountChildren = 1;
					$accountRecords++;

				}
				else
				{
					$accountChildren++;
					$accountRecords++;
				}
			}
		}
		if ($accountChildren == 3)
		{
			$arrayFamily80[$accountFamily80]['family'] = $currentFamily;
			$arrayFamily80[$accountFamily80]['id'] = $currentFamilyId;
			$accountFamily80++;
			$accountTresHijos++;
		}
		sort($arrayFamily80);

		$this->set(compact('school', 'currentDate', 'arrayFamily80', 'account', 'accountTresHijos'));
		$this->set('_serialize', ['school', 'currentDate', 'arrayFamily80', 'account', 'accountTresHijos']);

    }

    public function discountFamily50()
    {
        setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');

        $currentDate = time::now();

        $this->loadModel('Schools');

        $school = $this->Schools->get(2);
		
        $currentYear = $school->current_year_registration;

		$registration = 'Matr??cula ' . $currentYear;
		
		$studentTransactions = TableRegistry::get('Studenttransactions');

		$studentsFor = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_type',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.level_of_study',
				'Students.scholarship',
				'Parentsandguardians.id',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $registration],
				['Studenttransactions.amount >' => 0], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.id' => 'ASC']);
			
		$account = $studentsFor->count();
		
		$idParent = 0;
		$accountRecords = 0;
		$accountChildren = 0;
		$accountCuatroOmas = 0;
		$arrayFamily50 = [];
		$accountFamily50 = 0;

		foreach ($studentsFor as $studentsFors)
		{
			if ($accountRecords == 0)
			{
				$idParent = $studentsFors->student->parentsandguardian->id;
				
				$currentFamily = $studentsFors->student->parentsandguardian->family;
				$currentFamilyId = $studentsFors->student->parentsandguardian->id;
				$accountChildren++;
				$accountRecords++;

			}
			else
			{
				if ($idParent != $studentsFors->student->parentsandguardian->id)
				{
					if ($accountChildren > 3)
					{
						$arrayFamily50[$accountFamily50]['family'] = $currentFamily;
						$arrayFamily50[$accountFamily50]['id'] = $currentFamilyId;
						$accountFamily50++;
						$accountCuatroOmas++;
					}
					$idParent = $studentsFors->student->parentsandguardian->id;
					
					$currentFamily = $studentsFors->student->parentsandguardian->family;
					$currentFamilyId = $studentsFors->student->parentsandguardian->id;
					
					$accountChildren = 1;
					$accountRecords++;

				}
				else
				{
					$accountChildren++;
					$accountRecords++;
				}
			}
		}
		if ($accountChildren > 3)
		{
			$arrayFamily50[$accountFamily50]['family'] = $currentFamily;
			$arrayFamily50[$accountFamily50]['id'] = $currentFamilyId;
			$accountFamily50++;
			$accountCuatroOmas++;
		}
		sort($arrayFamily50);

		$this->set(compact('school', 'currentDate', 'arrayFamily50', 'account', 'accountCuatroOmas'));
		$this->set('_serialize', ['school', 'currentDate', 'arrayFamily50', 'account', 'accountCuatroOmas']);
    }

    public function orderLevel($level = null)
    {
        $levelOfStudy = ['',
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
                        'Secundaria, 5to. a??o'];
        $position = [0,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13,
                    14];
        $order = str_replace($levelOfStudy, $position, $level);
        return $order;
    }
	
    public function gradoPosicion($level = null)
    {
        $levelOfStudy = ['No asignado',
                        'Pre-kinder',                                
                        'Kinder',
                        'Preparatorio',
                        '1er. Grado',
                        '2do. Grado',
                        '3er. Grado',
                        '4to. Grado',
                        '5to. Grado',
                        '6to. Grado',
                        '1er. A??o',
                        '2do. A??o',
                        '3er. A??o',
                        '4to. A??o',
                        '5to. A??o'];
        $position = [0,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13,
                    14];
        $order = str_replace($levelOfStudy, $position, $level);
        return $order;
    }
	
	public function verifyPayment($dateFrom = null, $dateException = null,  $idStudent = null)
	{
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
		$this->loadModel('Bills');
		
		$swAdjust = 0;
		
		$previousBill = 0;
		
		$verifyTransactions = $this->Studenttransactions->find('all', ['conditions' => [['student_id' => $idStudent], ['transaction_type' => 'Mensualidad'], 
			['payment_date >' => $dateFrom]], 'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);			

        foreach ($verifyTransactions as $verifyTransaction)
        {			               
            $month = substr($verifyTransaction->transaction_description, 0, 3);
                        
            if ($month != 'Ago')
			{
				if ($verifyTransaction->amount == 0)
				{
					if ($verifyTransaction->bill_number > $previousBill)
					{
						$previousBill = $verifyTransaction->bill_number;
						
						$lastRecord = $this->Bills->find('all', ['conditions' => ['bill_number' => $verifyTransaction->bill_number], 
							'order' => ['created' => 'DESC'] ]);

						$bill = $lastRecord->first();
        
						if ($bill->date_and_time > $dateException)
						{
							$swAdjust = 1;
							break;
						}
					}
				}
				else
				{
					$swAdjust = 1;
					break;
				}
			}	
		}
		return $swAdjust;
	}
    public function modifyTransactions()
    {
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_description' => 'Matr??cula 2018']]]);
	
		$account1 = $studentTransactions->count();
		
		$account2 = 0;
	
		foreach ($studentTransactions as $studentTransaction)
        {		
			if ($studentTransaction->amount > 0)
			{
				$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
				$student->balance = substr($studentTransaction->transaction_description, 11, 4);
				if ($this->Studenttransactions->Students->save($student))
				{
					$account2++;
				}
				else
				{
					$this->Flash->error(__('No pudo ser grabada la matr??cula correspondiente al alumno cuyo ID es: ' . $studentTransactionGet->student_id));
				}
			}
		}

		$this->Flash->success(__('Total registros seleccionados: ' . $account1));
		$this->Flash->success(__('Total registros actualizados: ' . $account2));
		
		return $this->redirect(['controller' => 'users', 'action' => 'wait']);

	}	
    public function newMonthlyDefaulters()
    {	
		if ($this->request->is('post')) 
        {		
			$monthFrom = $_POST['month_from'];

			$yearFrom = $_POST['year_from'];
		
			$monthUntil = $_POST['month_until'];
		
			$yearUntil = $_POST['year_until'];
		
			$previousMonthlyPayment = $_POST['previous_amount'];
			
			$newAmount = $_POST['new_amount'];
			
			$this->Flash->success(__('Cuota anterior: ' . number_format($previousMonthlyPayment, 2, ",", ".") . ' Nueva cuota: ' . number_format($newAmount, 2, ",", ".")));
			
			$this->Flash->success(__('A??o mes desde: ' . $yearFrom . '-'. $monthFrom . ' A??o mes hasta: ' . $yearUntil . '-'. $monthUntil));
		
			$excels = new ExcelsController();
			
			$previousMonthlyPayment80 = $previousMonthlyPayment * 0.8;
			
			$previousMonthlyPayment50 = $previousMonthlyPayment * 0.5;
			
			$newAmount80 = $newAmount * 0.8;
			
			$newAmount50 = $newAmount * 0.5;

			$yearMonthFrom = $yearFrom . $monthFrom;
			
			$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
			
			$dateUntil = new Time($yearUntil . '-' . $monthUntil . '-01 00:00:00');
			
			$arrayResult = [];	       
			$accountGeneral = 0;
			$accountDifferentAugust = 0;
			$accountAugust = 0;
			$accountAdjust = 0;
			$accountOutSequence = 0;
			$account20 = 0;
			$account50 = 0;
			$accountRegular = 0;
			$accountIrregular = 0;
			$swAdjust = 0;
			$previousIdStudent = 0;
			$swErrorTransactions = 0;
			$accountStudentAdjust = 0;
			$accountSave = 0;
			$swSave = 0;
			$sw20 = 0;
			$sw50 = 0;
			$swRegular = 0;
					
			$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => [['transaction_type' => 'Mensualidad'], ['payment_date >=' => $dateFrom], ['payment_date <=' => $dateUntil]], 
				'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
				
			$accountSelect = $studentTransactions->count();
			
			if ($studentTransactions) 
			{
				foreach ($studentTransactions as $studentTransaction)
				{			
					$accountGeneral++;
					
					$month = substr($studentTransaction->transaction_description, 0, 3);
							
					if ($month != 'Ago')
					{
						$accountDifferentAugust++;
						
						if ($accountDifferentAugust == 0)
						{
							$previousIdStudent = $studentTransaction->student_id;
						}
						
						if ($previousIdStudent != $studentTransaction->student_id)
						{
							if ($swAdjust == 1)
							{
								$student = $this->Studenttransactions->Students->get($previousIdStudent);
								
								$accountStudentAdjust++;
								
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['number'] = $accountStudentAdjust;
								$columns['col1'] = $student->id;
								$columns['col2'] = $student->full_name;
								$columns['col3'] = $sw20;
								$columns['col4'] = $sw50;
								$columns['col5'] = $swRegular;
								$columns['col6'] = $previousMonthlyPayment;
								
								
								$swExcel = $excels->add($columns);

								if ($swExcel == 1)
								{
									$this->Flash->error(__('No pudo ser grabado en la tabla Excels el alumno: ' . $student->full_name));
								}
							}					
							$previousIdStudent = $studentTransaction->student_id;
							$swAdjust = 0;
							$sw20 = 0;
							$sw50 = 0;
							$swRegular = 0;
						}		
						
						$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
						
						if ($studentTransaction->original_amount == $previousMonthlyPayment80)
						{
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$sw20 = 1;
								$account20++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount80 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount80;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$sw20 = 1;
								$account20++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment50)
						{
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$sw50 = 1;
								$account50++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount50 - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount50;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$sw50 = 1;
								$account50++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						elseif ($studentTransaction->original_amount == $previousMonthlyPayment)
						{    
							if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
							{
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 0;
								$swRegular = 1;
								$accountRegular++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
							elseif ($studentTransactionGet->amount > 0)
							{
								$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
								$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
								$studentTransactionGet->original_amount = $newAmount;
								$studentTransactionGet->paid_out = 0;
								$studentTransactionGet->partial_payment = 1;
								$swRegular = 1;
								$accountRegular++;
								$accountAdjust++;
								$swAdjust = 1;
								$swSave = 1;
							}
						}
						else
						{
							$accountIrregular++;     
						}

						if ($swSave == 1)
						{
							if (!($this->Studenttransactions->save($studentTransactionGet)))
							{
								$swErrorTransactions = 1;
							} 
							$swSave = 0;
							$accountSave++;
						}
					}
					else
					{
						$accountAugust++;
					}
				}
				if ($swAdjust == 1)
				{
					$student = $this->Studenttransactions->Students->get($previousIdStudent);
					
					$accountStudentAdjust++;
					
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['number'] = $accountStudentAdjust;
					$columns['col1'] = $student->full_name;
					$columns['col2'] = $sw20;
					$columns['col3'] = $sw50;
					$columns['col4'] = $swRegular;
					
					$swExcel = $excels->add($columns);

					if ($swExcel == 1)
					{
						$this->Flash->error(__('No pudo ser grabado en la tabla Excels el alumno: ' . $student->full_name));
					}
				}					

				if ($swErrorTransactions == 0)
				{
					$arrayResult['indicator'] = 0;
					$arrayResult['message'] = 'Se actualizaron las mensualidades correctamente';	
					$this->Flash->success(__('Se actualizaron las mensualidades correctamente'));
				}
				else
				{
					$arrayResult['indicator'] = 1;
					$arrayResult['message'] = 'Error al actualizar las mensualidades';		
					$this->Flash->error(__('Error al actualizar las mensualidades'));
				}
				$arrayResult['adjust'] = $accountAdjust;
				$this->Flash->success(__('Alumnos a los que se les ajust?? las mensualidades: ' . $accountStudentAdjust));
				$this->Flash->success(__('Mensualidades ajustadas: ' . $accountAdjust));
				$this->Flash->success(__('Registros actualizados de Studenttransactions: ' . $accountSave));
				$this->Flash->success(__('Registros actualizados de Studenttransactions 20%: ' . $account20));
				$this->Flash->success(__('Registros actualizados de Studenttransactions 50%: ' . $account50));
				$this->Flash->success(__('Registros actualizados de Studenttransactions regulares: ' . $accountRegular));
			}
			else
			{
				$arrayResult['indicator'] = 1;
				$arrayResult['message'] = 'No se encontraron mensualidades';
				$arrayResult['adjust'] = 0;
				$this->Flash->error(__('No se encontraron mensualidades'));
			}
			return $this->redirect(['controller' => 'users', 'action' => 'wait']);
		}
	}
    public function adjustDefaulters($monthUntil = null, $yearUntil = null, $newAmount = null)
    {
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
		
		$binnacles = new BinnaclesController;	

		$excels = new ExcelsController();
		
		$swError = 0;
		
		$arrayResult = [];
		
		$dateUntil = new Time($yearUntil . '-' . $monthUntil . '-01 00:00:00');		
								
		$newAmount80 = $newAmount * 0.8;
		
		$newAmount50 = $newAmount * 0.5;
	
		$accountGeneral = 0;
		$accountDifferentAugust = 0;
		$accountAugust = 0;
		$accountAdjust = 0;
		$accountOutSequence = 0;
		$account20 = 0;
		$account50 = 0;
		$accountRegular = 0;
		$accountIrregular = 0;
		$swAdjust = 0;
		$previousIdStudent = 0;
		$accountStudentAdjust = 0;
		$accountSave = 0;
		$swSave = 0;
				
		$studentTransactions = $this->Studenttransactions->find('all', 
			['contain' => ['Students'],
			'conditions' => [['Students.student_condition' => 'Regular'], ['Students.section_id >' => 1], ['Studenttransactions.transaction_type' => 'Mensualidad'], ['Studenttransactions.payment_date <' => $dateUntil], ['Studenttransactions.paid_out' => 0]], 
			'order' => ['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
			
		$accountSelect = $studentTransactions->count();
				
		if ($studentTransactions) 
		{
			foreach ($studentTransactions as $studentTransaction)
			{			
				$accountGeneral++;
				
				$month = substr($studentTransaction->transaction_description, 0, 3);
						
				if ($month != 'Ago')
				{					
					if ($accountDifferentAugust == 0)
					{
						$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
						
						$previousIdStudent = $studentTransaction->student_id;
					}
					
					$accountDifferentAugust++;
					
					if ($previousIdStudent != $studentTransaction->student_id)
					{
						if ($swAdjust == 1)
						{
							if ($accountStudentAdjust == 0)
							{
								$columns = [];
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['start_end'] = 'start';
								
								$swError = $excels->add($columns);								
							}
							
							if ($swError == 0)
							{
								$accountStudentAdjust++;
								
								$columns = [];
								$columns['report'] = 'Alumnos morosos cuota ajustada';
								$columns['number'] = $accountStudentAdjust;
								$columns['col1'] = $student->id;
								$columns['col2'] = $student->full_name;
								$columns['col3'] = $student->discount;
							
								$swError = $excels->add($columns);

								if ($swError > 0)		
								{
									break;
								}
							}
							else
							{
								break;
							}
						}					
						$previousIdStudent = $studentTransaction->student_id;
						$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
						$swAdjust = 0;
					}		
					
					$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
										
					if ($student->discount == 20)
					{
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount80;
							$studentTransactionGet->amount = $newAmount80;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
							$account20++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
						elseif ($studentTransactionGet->amount > 0)
						{
							$differenceAmount = $newAmount80 - $studentTransactionGet->original_amount;
							$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
							$studentTransactionGet->original_amount = $newAmount80;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 1;
							$account20++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
					}
					elseif ($student->discount == 50)
					{
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount50;
							$studentTransactionGet->amount = $newAmount50;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
							$account50++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
						elseif ($studentTransactionGet->amount > 0)
						{
							$differenceAmount = $newAmount50 - $studentTransactionGet->original_amount;
							$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
							$studentTransactionGet->original_amount = $newAmount50;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 1;
							$account50++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
					} 
					elseif ($student->discount == null)
					{    
						if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
						{
							$studentTransactionGet->original_amount = $newAmount;
							$studentTransactionGet->amount = $newAmount;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 0;
							$accountRegular++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
						elseif ($studentTransactionGet->amount > 0)
						{
							$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
							$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
							$studentTransactionGet->original_amount = $newAmount;
							$studentTransactionGet->paid_out = 0;
							$studentTransactionGet->partial_payment = 1;
							$accountRegular++;
							$accountAdjust++;
							$swAdjust = 1;
							$swSave = 1;
						}
					}
					else
					{
						$accountIrregular++;     
					}

					if ($swSave == 1)
					{
						if ($this->Studenttransactions->save($studentTransactionGet))
						{ 
							$accountSave++;	
						}	
						else
						{
							$binnacles->add('controller', 'Studenttransactions', 'adjustDefaulters', 'No se pudo actualizar la mensualidad con id: ' . $studentTransactionGet->id);
							$swError = 1;
							break;
						}
						$swSave = 0;
					}
				}
				else
				{
					$accountAugust++;
				}
			}
			if ($swError == 0)
			{
				if ($swAdjust == 1)
				{				
					$accountStudentAdjust++;
					
					$columns = [];
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['number'] = $accountStudentAdjust;
					$columns['col1'] = $student->id;
					$columns['col2'] = $student->full_name;
					$columns['col3'] = $student->discount;
					
					$swError = $excels->add($columns);
				}
				if ($swError == 0 && $accountStudentAdjust > 0)
				{
					$columns = [];
					$columns['report'] = 'Alumnos morosos cuota ajustada';
					$columns['start_end'] = 'end';
				
					$swError = $excels->add($columns);
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'adjustDefaulters', 'No se encontraron alumnos con mensualidades morosas');
			$swError = 1;
		}
		$arrayResult['indicator'] = $swError;
		$arrayResult['adjust'] = $accountStudentAdjust;
		return $arrayResult;
	}

	public function discountStudents($monthFrom = null, $yearFrom = null, $monthlyPayment = null)
	{
		$this->autoRender = false;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');		
		
		$excels = new ExcelsController();
			
		$binnacles = new BinnaclesController;
		
		$swError = 0;
							
		$monthlyPayment80 = $monthlyPayment * 0.8;
		
		$monthlyPayment50 = $monthlyPayment * 0.5;
			
		$dateFrom = new Time($yearFrom . '-' . $monthFrom . '-01 00:00:00');
		
		$swError = $this->initialDiscount();
			
		if ($swError == 0)
		{
			$studentTransactions = $this->Studenttransactions->find('all', 
				['conditions' => 
				[['transaction_type' => 'Mensualidad'], 
				['payment_date' => $dateFrom],
				['OR' => [['Studenttransactions.original_amount' => $monthlyPayment80], ['Studenttransactions.original_amount' => $monthlyPayment50]]]], 
				'order' => 
				['Studenttransactions.student_id' => 'ASC', 'payment_date' => 'ASC']]);
							
			if ($studentTransactions) 
			{				
				$account20 = 0;
				$account50 = 0;
				$accountStudentDiscount = 0;
							
				foreach ($studentTransactions as $studentTransaction)
				{
					$student = $this->Studenttransactions->Students->get($studentTransaction->student_id);
					
					if ($studentTransaction->original_amount == $monthlyPayment80)
					{
						$account20++;
						$discountPercentage = 20;
						$student->discount = 20;
					}
					elseif ($studentTransaction->original_amount == $monthlyPayment50)
					{
						$account50++;
						$discountPercentage = 50;	
						$student->discount = 50;
					}		

					if ($this->Studenttransactions->Students->save($student))
					{
						if ($accountStudentDiscount == 0)
						{
							$columns = [];
							$columns['report'] = 'Alumnos con discount 20% y 50%';
							$columns['start_end'] = 'start';
							
							$swError = $excels->add($columns);								
						}
						
						if ($swError == 0)
						{
							$accountStudentDiscount++;

							$columns = [];											
							$columns['report'] = 'Alumnos con discount 20% y 50%';
							$columns['number'] = $accountStudentDiscount;
							$columns['col1'] = $student->id;
							$columns['col2'] = $student->full_name;
							$columns['col3'] = $studentTransaction->original_amount;
							$columns['col4'] = $discountPercentage;
																
							$swError = $excels->add($columns);
							
							if ($swError > 0)
							{
								break;
							}
						}
						else
						{
							break;
						}
					}
					else
					{
						$binnacles->add('controller', 'Studenttransactions', 'discountStudent', 'No se pudo actualizar la columna discount del alumno ' . $student->id);
						$swError = 1;
						break;
					}
				}
				if ($swError == 0 && $accountStudentDiscount > 0)
				{
					$columns = [];
					$columns['report'] = 'Alumnos con discount 20% y 50%';
					$columns['start_end'] = 'end';
				
					$swError = $excels->add($columns);
				}
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'discountStudent', 'No se encontraron alumnos con descuento del 20% y 50%');
				$swError = 1;				
			}
		}
		return $swError;
	}
	
	public function initialDiscount()
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
		$swError = 0;
		
		$discountStudents = $this->Studenttransactions->Students->find('all', ['conditions' => [['Students.id >' => 1], ['Students.discount IS NOT NULL']]]);
		
		if ($discountStudents)
		{			
			foreach ($discountStudents as $discountStudent)
			{			
				$student = $this->Studenttransactions->Students->get($discountStudent->id);
			
				$student->discount = null;
			
				if (!($this->Studenttransactions->Students->save($student)))
				{
					$binnacles->add('controller', 'Studenttransactions', 'initialDiscount', 'No se pudo inicializar la columna discount del alumno ' . $discountStudent->id);
					$swError = 1;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'initialDiscount', 'No se encontraron alumnos con descuento');
			$swError = 1;			
		}
		return $swError;
	}
	public function resetStudents()
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
				
		$currentDate = time::now();
		
		$lastYear = $currentDate->year - 1;
								
		$accountUpdate = 0;
					
		$swError = 0;
					
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';

		$students = $this->Studenttransactions->Students->find('all', 
			['conditions' => [['Students.id >' => 1], ['Students.student_condition' => 'Regular'], ['Students.balance <=' => $lastYear]]]);

		if ($students)
		{
			foreach ($students as $student)
			{
				$studentGet = $this->Studenttransactions->Students->get($student->id);
				
				if ($studentGet->section_id == 1)
				{
					$studentGet->student_condition = 'Retirado';
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Alumno retirado por section_id == 1: ' . $studentGet->full_name . ' id: ' . $studentGet->id);
				}					
				if ($studentGet->balance < $lastYear && $studentGet->level_of_study == "")
				{
					$studentGet->student_condition = 'Retirado';
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Alumno retirado por level_of_study == Blancos: ' . $studentGet->full_name . ' id: ' . $studentGet->id);					
				}
				$studentGet->level_of_study = "";
				$studentGet->new_student = 0;
                if ($this->Studenttransactions->Students->save($studentGet))
                { 
					$accountUpdate++;
				}
				else
				{
					$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'No se pudo actualizar el alumno con id ' . $studentGet->id);
					$swError = 1;	
					break;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'No se encontraron alumnos inscritos en a??os anteriores');
			$swError = 1;				
		}
		$arrayResult['indicator'] = $swError;
		
		if ($swError == 0)
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Se resetearon ' . $accountUpdate . ' alumnos');
			$arrayResult['message'] = 'Actualizaci??n exitosa de los estatus de los alumnos';
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'resetStudents', 'Error en la ejecuci??n del programa. Solo se resetearon ' . $accountUpdate . ' alumnos');
			$arrayResult['message'] = 'No se actualizaron correctamente los estatus de los alumnos';
		}
		return $arrayResult;
	}
	public function updateTransaction($studentTransaction = null, $newAmount = null)
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
				
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		
		$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
		
		$studentTransactionGet->original_amount = $newAmount;
		$studentTransactionGet->amount = $newAmount;
		$studentTransactionGet->paid_out = 0;
		$studentTransactionGet->partial_payment = 0;
		
		if ($this->Studenttransactions->save($studentTransactionGet))
		{ 
			$arrayResult['message'] = 'La transacci??n identificada con el id: ' . $studentTransactionGet->id . ' se actualiz?? exitosamente';			
		}
		else
		{ 
			$binnacles->add('controller', 'Studenttransactions', 'differenceAugust', 'No se pudo actualizar la transacci??n con el id ' . $studentTransactionGet->id);
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudo grabar la transacci??n con el id ' . $studentTransactionGet->id;
		} 
		return $arrayResult;
	}
	
    public function modifyPaymentDate()
    {
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
				
		$defaultDate = new Time();
			
		$defaultDate
			->year(1970)
			->month(01)
			->day(01)
			->hour(00)
			->minute(00)
			->second(00);
					
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['payment_date <' => $defaultDate]]);
	
		$account1 = $studentTransactions->count();
			
		$account2 = 0;
		
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
							
			$studentTransactionGet->payment_date = $defaultDate; 
			
			if ($this->Studenttransactions->save($studentTransactionGet))
			{
				$account2++;
			}
			else
			{
				$this->Flash->error(__('No pudo ser grabada la transacci??n con id: ' . $studentTransactionGet->id));
			}
		}

		$this->Flash->success(__('Total registros seleccionados: ' . $account1));
		$this->Flash->success(__('Total registros actualizados: ' . $account2));
		
		return $this->redirect(['controller' => 'users', 'action' => 'wait']);
	}
    public function monetaryReconversion()
    {				
		$binnacles = new BinnaclesController;
	
		$studentTransactions = $this->Studenttransactions->find('all', ['conditions' => ['id >' => 0]]);
	
		$account1 = $studentTransactions->count();
			
		$account2 = 0;
		
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
			
			$previousAmount = $studentTransactionGet->amount;
										
			$studentTransactionGet->amount = $previousAmount / 100000;

			$previousAmount = $studentTransactionGet->original_amount;
										
			$studentTransactionGet->original_amount = $previousAmount / 100000;			
			
			if ($this->Studenttransactions->save($studentTransactionGet))
			{
				$account2++;
			}
			else
			{
				$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'No se actualiz?? registro con id: ' . $studentTransactionGet->id);
			}
		}

		$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'Total registros seleccionados: ' . $account1);
		$binnacles->add('controller', 'Studenttransactions', 'monetaryReconversion', 'Total registros actualizados: ' . $account2);
		
		return $this->redirect(['controller' => 'Users', 'action' => 'logout']);	
	}
    public function differenceRegistration($newAmount = null, $yearDifference = null)
    {
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;

		$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', '$newAmount: ' . $newAmount . ' $yearDifference: ' . $yearDifference);
		
		$accountRecords = 0;
		
		$swError = 0;
						
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		$arrayResult['adjust'] = 0;
		
		$studentTransactions = $this->Studenttransactions->find('all', [
			'contain' => ['Students'],
			'conditions' => 
			[['Studenttransactions.transaction_description' => "Matr??cula " . $yearDifference], 
			['Students.new_student' => 0]], 
			]);
						
		if ($studentTransactions)
		{			
			foreach ($studentTransactions as $studentTransaction)
			{									
				$arrayResult = $this->updateRegistration($studentTransaction, $newAmount);
									
				if ($arrayResult['indicator'] == 0)
				{
					$accountRecords++;
				}
				else
				{
					$swError = 1;
					break;
				}
			}
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', 'No se encontraron transacciones de matr??cula de alumnos regulares ' . $yearDifference);
			$swError = 1;					
		}
		
		$arrayResult['indicator'] = $swError;
		
		if ($swError == 0)
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistration', 'Registros actualizados: ' . $accountRecords);
			$arrayResult['message'] = 'Se actualiz?? exitosamente la diferencia de Matr??cula';
			$arrayResult['adjust'] = $accountRecords; 
		}
		else
		{
			$binnacles->add('controller', 'Studenttransactions', 'differenceRegistrationRegular', 'Programa con error, solo se actualizaron ' . $accountRecords . ' transacciones');
			$arrayResult['message'] = 'No se actualiz?? exitosamente la diferencia de inscripci??n';
			$arrayResult['adjust'] = $accountRecords;
		}		
		return $arrayResult;
    }
	public function updateRegistration($studentTransaction = null, $newAmount = null)
	{
		$this->autoRender = false;
		
		$binnacles = new BinnaclesController;
								
		$arrayResult = [];	
		$arrayResult['indicator'] = 0;
		$arrayResult['message'] = '';
		
		$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
				
		if ($studentTransactionGet->original_amount == $studentTransactionGet->amount)
		{
			$studentTransactionGet->original_amount = $newAmount;
			$studentTransactionGet->amount = $newAmount;
			$studentTransactionGet->paid_out = 0;
			$studentTransactionGet->partial_payment = 0;
		}
		elseif ($studentTransactionGet->original_amount > $studentTransactionGet->amount)
		{
			$differenceAmount = $newAmount - $studentTransactionGet->original_amount;
			$studentTransactionGet->amount = $studentTransactionGet->amount + $differenceAmount;
			$studentTransactionGet->original_amount = $newAmount;
			$studentTransactionGet->paid_out = 0;
			$studentTransactionGet->partial_payment = 1;
		}
		
		if ($this->Studenttransactions->save($studentTransactionGet))
		{ 
			$arrayResult['message'] = 'La transacci??n identificada con el id: ' . $studentTransactionGet->id . ' se actualiz?? exitosamente';			
		}
		else
		{ 
			$binnacles->add('controller', 'Studenttransactions', 'updateRegistrationRegular', 'No se pudo actualizar la transacci??n con el id ' . $studentTransactionGet->id);
			$arrayResult['indicator'] = 1;
			$arrayResult['message'] = 'No se pudo actualizar la transacci??n con el id ' . $studentTransactionGet->id;
		}		
		return $arrayResult;
	}

    public function scholarshipIndex()
    {
		$this->loadModel('Schools');

		$school = $this->Schools->get(2);
				
		$yearFrom = $school->current_school_year;
		$yearUntil = $yearFrom + 1;

		$enrollment = 'Matr??cula ' . $yearFrom;
		
        $query = $this->Studenttransactions->find('all')
			->contain(['Students'])
            ->where([['Studenttransactions.transaction_description' => $enrollment],
				['Studenttransactions.amount >' => 0],
				['Students.id >' => 1],
				['Students.section_id >' => 1],
				['Students.balance' => $yearFrom],
				['Students.student_condition' => 'Regular'],
				['Students.scholarship' => 1]])				
            ->order(['Students.surname' => 'ASC', 'Students.second_surname' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC']);

        // $this->set('studenttransactions', $this->paginate($query));
		$studenttransactions = $query;

        $this->set(compact('studenttransactions'));
        $this->set('_serialize', ['studenttransactions']);
    }

// Funci??n creada para corregir cualquier error en la tabla Studenttransactions
	
	public function correctTransaction()
	{
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
		date_default_timezone_set('America/Caracas');
							
		$studentTransactions = $this->Studenttransactions->find('all', 
			['conditions' => ['Studenttransactions.transaction_description' => 'Ago 2019']]); 
				
		$contador = 0;
		foreach ($studentTransactions as $studentTransaction)
        {		
			$studentTransactionGet = $this->Studenttransactions->get($studentTransaction->id);
								
			$studentTransactionGet->amount_dollar = 0;
															
			if (!($this->Studenttransactions->save($studentTransactionGet)))
			{
				$this->Flash->error(__('No se pudo actualizar la transacci??n identificada con el ID: ' . $studentTransactionGet->id . ' Correspondiente al estudiante: ' . $studentTransaction->student->full_name));
			}   
			$contador++;	
		}
				
        $this->set(compact('studentTransactions', 'contador'));
        $this->set('_serialize', ['studentTransactions', 'contador']);
	}	
	public function reportePagos()
	{
		if ($this->request->is('post'))
		{
			if (isset($_POST["concepto"]) && isset($_POST["ano_concepto"]))
			{
				return $this->redirect(['action' => 'reportePagosConcepto', $_POST["concepto"], $_POST["ano_concepto"]]);
			}

		}	
	}
	public function reportePagosConcepto($concepto = null, $anoConcepto = null)
	{
		$conceptoReporte = $concepto . " " . $anoConcepto;
		
		setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); 
        date_default_timezone_set('America/Caracas');
		
        $fechaHoy = Time::now();
		
		$studentTransactions = TableRegistry::get('Studenttransactions');
		
		$pagosRecibidos = $studentTransactions->find()
			->select(
				['Studenttransactions.id',
				'Studenttransactions.transaction_description',
				'Studenttransactions.amount',
				'Students.id',
				'Students.surname',
				'Students.second_surname',
				'Students.first_name',
				'Students.second_name',
				'Students.student_condition',
				'Parentsandguardians.family'])
			->contain(['Students' => ['Parentsandguardians']])
			->where([['Studenttransactions.transaction_description' => $conceptoReporte],
				['Studenttransactions.amount > 0'], ['Students.student_condition' => 'Regular']])
			->order(['Parentsandguardians.family', 'Students.surname' => 'ASC', 'Students.second_name' => 'ASC', 'Students.first_name' => 'ASC', 'Students.second_name' => 'ASC' ]);			

		$contadorRegistros = $pagosRecibidos->count();
					
		$totalConcepto = 0;
			
		foreach ($pagosRecibidos as $pagosRecibido)
		{
			$totalConcepto = $totalConcepto + $pagosRecibido->amount;
		}
			
        $this->set(compact('pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy'));
        $this->set('_serialize', ['pagosRecibidos', 'conceptoReporte', 'totalConcepto', 'fechaHoy']);
	}
	
    public function notaTransaccion($idTransaccion = null, $numeroNotaContable = null, $valor = null, $tipoNota = null, $tasaCambio = null)
    {
		$estudianteController = new StudentsController();
        
		$codigoRetornoTransaccion = 0;
				
		$diferenciaOriginalActual = 0;
		
		$tarifaDolar = 0;
		
        $transaccionEstudiante = $this->Studenttransactions->get($idTransaccion);
				
		$montoNotaDolar = round($valor / $tasaCambio, 2); 
		
		if ($tipoNota == "Cr??dito")
		{
			$transaccionEstudiante->amount_dollar = $transaccionEstudiante->amount_dollar - $montoNotaDolar;
		}
		else
		{
			$transaccionEstudiante->amount_dollar = $transaccionEstudiante->amount_dollar + $montoNotaDolar;
		}
				
		$mesesTarifas = $estudianteController->mesesTarifas(0);
		$otrasTarifas = $estudianteController->otrasTarifas(0);
		
		if ($transaccionEstudiante->transaction_type == "Mensualidad" && substr($transaccionEstudiante->transaction_description, 0, 3) != "Ago")
		{				
			$ano = $transaccionEstudiante->payment_date->year;
								
			$mes = $transaccionEstudiante->payment_date->month;
																						
			if ($mes < 10)
			{
				$mesCadena = "0" . $mes;
			}
			else
			{
				$mesCadena = (string) $mes;
			}
			$anoMes = $ano . $mesCadena;
						
			foreach ($mesesTarifas as $mesTarifa)
			{
				if ($mesTarifa['anoMes'] == $anoMes)
				{
					$tarifaDolar = $mesTarifa['tarifaDolar'];

					$estudiante = $this->Studenttransactions->Students->get($transaccionEstudiante->student_id);
				   
					if ($estudiante->discount === null )
					{
						$descuentoFamilia = 1;
					}
					else
					{	
						$descuentoFamilia = (100 - $estudiante->discount) / 100;
					}
					
					$tarifaDolar = round($tarifaDolar * $descuentoFamilia, 2);
					break;
				}
			}
		}
		else
		{
			foreach ($otrasTarifas as $otras)
			{				
				if ($otras['conceptoAno'] == $transaccionEstudiante->transaction_description)
				{
					$tarifaDolar = $otras['tarifaDolar'];
					break;
				}
			}
		}
		
		$diferenciaOriginalActual = $transaccionEstudiante->original_amount - $transaccionEstudiante->amount;
		
		$tarifaDolar = $tarifaDolar - $diferenciaOriginalActual;	
		
		if ($transaccionEstudiante->amount_dollar == $tarifaDolar)
		{
			$transaccionEstudiante->partial_payment = 0;
			$transaccionEstudiante->paid_out = 1;
		}
		elseif ($transaccionEstudiante->amount_dollar > $tarifaDolar)
		{
			$transaccionEstudiante->partial_payment = 0;
			$transaccionEstudiante->paid_out = 1;
		}
		else
		{
			if ($transaccionEstudiante->amount_dollar == 0)
			{
				$transaccionEstudiante->partial_payment = 0;
				$transaccionEstudiante->paid_out = 0;
			}
			else
			{
				$transaccionEstudiante->partial_payment = 1;
				$transaccionEstudiante->paid_out = 0;
			}
		}

		if ($codigoRetornoTransaccion == 0)
		{
			$transaccionEstudiante->bill_number = $numeroNotaContable;

			if (!($this->Studenttransactions->save($transaccionEstudiante)))
			{
				$codigoRetornoTransaccion = 1;
				$this->Flash->error(__('La transacci??n del alumno no pudo ser actualizada, vuelva a intentar.'));
			}
			else
			{						
				if ($transaccionEstudiante->transaction_type == 'Matr??cula')
				{
					if ($transaccionEstudiante->amount == 0)
					{
						$estudiante = $this->Studenttransactions->Students->get($transaccionEstudiante->student_id);
						
						if ($estudiante->number_of_brothers == $estudiante->balance)
						{
							$estudiante->number_of_brothers = 0;
							$estudiante->balance = 0;
						}
						else
						{
							$estudiante->balance -= 1; 
						}
						
						if (!($this->Studenttransactions->Students->save($estudiante)))
						{
							$codigoRetornoTransaccion = 1;
							$this->Flash->error(__('Los datos del alumno no pudieron ser actualizados, vuelva a intentar.'));
						}
					}
				}
			}
		}
        return $codigoRetornoTransaccion;
    }
	
	public function modificarParciales()
	{
		$contadorBusqueda = 0;
		$contadorCaso1 = 0;
		$contadorCaso2 = 0;
		$contadorCaso3 = 0;

		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 1]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				if ($transaccionGet->paid_out == 0 && $transaccionGet->bill_number != 0)
				{
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso1++;
				}
				elseif ($transaccionGet->paid_out == 0 && $transaccionGet->bill_number == 0)
				{
					if ($transaccionGet->id != 49081 && $transaccionGet->bill_number != 49095) 
					{
						$transaccionGet->partial_payment = 0;
					}
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso2++;
				}
				elseif ($transaccionGet->paid_out == 1)
				{
					$transaccionGet->partial_payment = 0;
					$transaccionGet->amount = $transaccionGet->amount_dollar;
					$transaccionGet->original_amount = $transaccionGet->amount_dollar;
					$contadorCaso3++;
				}
				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total transaccciones caso 1 ' . $contadorCaso1));
		$this->Flash->success(__('Total transaccciones caso 2 ' . $contadorCaso2));
		$this->Flash->success(__('Total transaccciones caso 3 ' . $contadorCaso3));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function modificarTotales()
	{
		$contadorBusqueda = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 0, 'paid_out' => 1, 'amount_dollar !=' => 999999 ]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				$transaccionGet->amount = $transaccionGet->amount_dollar;
				$transaccionGet->original_amount = $transaccionGet->amount_dollar;

				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function modificarNoPagadas()
	{
		$contadorBusqueda = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')
			->where(['invoiced' => 0, 'partial_payment' => 0, 'paid_out' => 0 ]);
			
		$contadorBusqueda = $transacciones->count();
		
		if ($contadorBusqueda > 0)
		{
			foreach ($transacciones as $transaccion)
			{
				$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
				$transaccionGet->amount = 0;
				$transaccionGet->original_amount = 0;

				/* if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				} */
			}
		}
		
		$this->Flash->success(__('Total transaccciones encontradas ' . $contadorBusqueda));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}
	public function anoEscolar()
	{
		$contadorBusqueda = 0;
		$contadorMensualidad2018 = 0;
		$contadorMensualidad2019 = 0;
		$contadorMatricula2019 = 0;
		$contadorSeguro2019 = 0;
		$contadorServicio2019 = 0;
		$contadorThales2019 = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all')->where(['invoiced' => 0]);
			
		$contadorBusqueda = $transacciones->count();
		
		$this->Flash->success(__('Total transacciones activas ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$actualizar = 0;	
			$ano2019 = new Time('2019-09-01 00:00:00');

			$transaccionGet = $this->Studenttransactions->get($transaccion->id);
			
			if ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date < $ano2019)
			{
				$transaccionGet->ano_escolar = 2018;
				$contadorMensualidad2018++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date >= $ano2019)
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorMensualidad2019++;
				$actualizar = 1;
			}						
			elseif ($transaccion->transaction_type == 'Matr??cula' && $transaccion->transaction_description == 'Matr??cula 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorMatricula2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Seguro escolar' && $transaccion->transaction_description == 'Seguro escolar 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorSeguro2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Servicio educativo' && $transaccion->transaction_description == 'Servicio educativo 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorServicio2019++;
				$actualizar = 1;
			}
			elseif ($transaccion->transaction_type == 'Thales' && $transaccion->transaction_description == 'Thales 2019')
			{
				$transaccionGet->ano_escolar = 2019;
				$contadorThales2019++;
				$actualizar = 1;
			}
			
			if ($actualizar == 1)
			{			
				if (!($this->Studenttransactions->save($transaccionGet))) 
				{
					$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}
				else
				{
					$contadorActualizadas++;
				}
			}
		}
		
		$this->Flash->success(__('Total mensualidades 2018 ' . $contadorMensualidad2018));
		$this->Flash->success(__('Total mensualidades 2019 ' . $contadorMensualidad2019));
		$this->Flash->success(__('Total matr??culas 2019 ' . $contadorMatricula2019));
		$this->Flash->success(__('Total seguro 2019 ' . $contadorSeguro2019));
		$this->Flash->success(__('Total servicio educativo 2019 ' . $contadorServicio2019));
		$this->Flash->success(__('Total Thales 2019 ' . $contadorThales2019));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	public function cuotasPendientes()
	{
		
	}

	// Ejecutar al iniciar el a??o escolar

	public function marcarEliminado()
	{
		$contadorBusqueda = 0;
		$contadorMensualidades = 0;
		$contadorMatriculas = 0;
		$contadorSeguro = 0;
		$contadorServicio = 0;
		$contadorThales = 0;
		$contadorActualizadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all');
			
		$contadorBusqueda = $transacciones->count();
		
		$this->Flash->success(__('Total transacciones busqueda ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$marcar = 0;
			
			$fechaHasta = new Time('2019-09-01 00:00:00');
			
			if ($transaccion->invoiced == 0)
			{
				if ($transaccion->transaction_type == 'Mensualidad' && $transaccion->payment_date < $fechaHasta)
				{
					$marcar = 1;
					$contadorMensualidades++;
				}
				elseif ($transaccion->transaction_type == 'Matr??cula' && $transaccion->transaction_description != 'Matr??cula 2019' && $transaccion->transaction_description != 'Matr??cula 2020' && $transaccion->transaction_description != 'Matr??cula 2021')
				{
					$marcar = 1;
					$contadorMatriculas++;
				}
				elseif ($transaccion->transaction_type == 'Seguro escolar' && $transaccion->transaction_description != 'Seguro escolar 2019' && $transaccion->transaction_description != 'Seguro escolar 2020' && $transaccion->transaction_description != 'Seguro escolar 2021')
				{
					$marcar = 1;
					$contadorSeguro++;
				}
				elseif ($transaccion->transaction_type == 'Servicio educativo' && $transaccion->transaction_description != 'Servicio educativo 2019' && $transaccion->transaction_description != 'Servicio educativo 2020' && $transaccion->transaction_description != 'Servicio educativo 2021')
				{
					$marcar = 1;
					$contadorServicio++;
				}
				elseif ($transaccion->transaction_type == 'Thales' && $transaccion->transaction_description != 'Thales 2019' && $transaccion->transaction_description != 'Thales 2020' && $transaccion->transaction_description != 'Thales 2021')
				{
					$marcar = 1;
					$contadorThales++;
				}

				
				if ($marcar == 1)
				{
					$this->Flash->success(__('La Transacci??n ' . $transaccion->transaction_description . ' con el id ' . $transaccion->id . ' ser?? modificada'));

					$transaccionGet = $this->Studenttransactions->get($transaccion->id);
				
					$transaccionGet->invoiced = 1;
				
					if (!($this->Studenttransactions->save($transaccionGet))) 
					{
						$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
					}
					else
					{
						$contadorActualizadas++;
					} 
				}
			}
		}
		
		$this->Flash->success(__('Total mensualidades ' . $contadorMensualidades));
		$this->Flash->success(__('Total matr??culas ' . $contadorMatriculas));
		$this->Flash->success(__('Total seguro ' . $contadorSeguro));
		$this->Flash->success(__('Total servicio educativo ' . $contadorServicio));
		$this->Flash->success(__('Total Thales ' . $contadorThales));
		$this->Flash->success(__('Total actualizadas ' . $contadorActualizadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	// Ejecutar al iniciar el a??o escolar

	public function eliminarMarcado()
	{
		$contadorBusqueda = 0;
		$contadorEliminadas = 0;
		
		$transaccionesEstudiante = TableRegistry::get('Studenttransactions');
		
		$transacciones = $transaccionesEstudiante->find('all');
				
		$this->Flash->success(__('Total transacciones busqueda ' . $contadorBusqueda));
		
		foreach ($transacciones as $transaccion)
		{
			$marcar = 0;
					
			if ($transaccion->invoiced == 1)
			{		
				$studenttransaction = $this->Studenttransactions->get($transaccion->id);
				
				if (!($this->Studenttransactions->delete($studenttransaction)))
				{
					$this->Flash->error(__('La transacci??n con el id ' . $transaccion->id . ' no pudo ser actualizada'));
				}				
				else
				{
					$contadorEliminadas++;
				}
			}
		}
		
		$this->Flash->success(__('Total registros marcados para eliminar ' . $contadorBusqueda));
		$this->Flash->success(__('Total transacciones eliminadas ' . $contadorEliminadas));
	
        $this->set(compact('transacciones'));
        $this->set('_serialize', ['transacciones']);
	}

	public function actualizarTransaccionBecado($idEstudiante = null, $anoEscolar = null)
	{
		$this->autoRender = false;

		$codigoRetorno = 0;

		$errorActualizaci??n = 0;

		$estudianteController = new StudentsController();

		$mesesTarifas = $estudianteController->mesesTarifas(0);

		$transaccciones = $this->Studenttransactions->find('all')
			->where(['student_id' => $idEstudiante, 'ano_escolar' => $anoEscolar, 'transaction_type' => 'Mensualidad', 'paid_out' => 1]);

		$contadorBusqueda = $transaccciones->count();

		$this->Flash->success(__('Total transacciones ' . $contadorBusqueda . ' del estudiante con el ID: ' . $idEstudiante));		

		foreach ($transaccciones as $transaccion)
		{
			if (substr($transaccion->transaction_description, 0, 3) != "Ago")
			{				
				$ano = $transaccion->payment_date->year;
								
				$mes = $transaccion->payment_date->month;
													
				if ($mes < 10)
				{
					$mesCadena = "0" . $mes;
				}
				else
				{
					$mesCadena = (string) $mes;
				}

				$anoMes = $ano . $mesCadena;
							
				foreach ($mesesTarifas as $mesTarifa)
				{
					if ($mesTarifa['anoMes'] == $anoMes)
					{
						$tarifaDolar = $mesTarifa['tarifaDolar'];

						if ($transaccion->amount < $tarifaDolar)
						{
							$porcentajeDescontado = 100 - (($transaccion->amount / $tarifaDolar) * 100); 

							$transaccionModificar = $this->Studenttransactions->get($transaccion->id);

							$transaccionModificar->porcentaje_descuento = $porcentajeDescontado;

							if (!($this->Studenttransactions->save($transaccionModificar)))				
							{
								$this->Flash->error(__('No se pudo actualizar la transacci??n con el ID ' . $transaccionModificar->id));
								$errorActualizaci??n = 1;
								break;
							}
							else
							{
								$codigoRetorno++;
							}
						}
					}
				}
			}

			if ($errorActualizaci??n == 1)
			{
				$codigoRetorno = 99;
				break;
			}

		}

		return $codigoRetorno;
	}
}