<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ConsultantController extends Controller
{
    
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
        	// Retrieve all Consultants https://stackoverflow.com/questions/52149031/laravel-join-query-with-conditions
    		$consultants = 	User::whereHas('consultants', function($query) {

    			$query	->where('co_sistema', 1)
    					->where('in_ativo', 'S')
    					->whereIn('co_tipo_usuario', [0,1,2]);
    		})->get();

    		if($request->developer) {
    			echo "Consultants";
    			dd($consultants);
    		}

            return view('dashboard.consultant.index')->with(['consultants'=> $consultants]);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return $exception->render();
        }
    }

    /**
     * Retrieves relatory dataset from the consultant.
     */
    public function relatory(Request $request)
    {
    	/*$request->consultants = [
    		'carlos.arruda',
            'anapaula.chiodaro'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';*/

        try {

        	$consultants =  $request->consultants;

        	$from = Carbon::parse($request['from-date']);
        	$to = Carbon::parse($request['to-date']);

            if(!$from || !$to)
                throw new Exception("Please fill all the dates from the period.", 1);

            if($from->gt($to)) 
                throw new Exception("The start date is greater that the end date.", 1);

        	$period = CarbonPeriod::create($from, '1 month', $to);

        	if(!$consultants)
    			throw new Exception("No consultant has been selected.", 1);
        	
        	if($request->developer) {
        		echo "Consultants";
        		dump($consultants);

        		echo "From";
        		dump($from);

        		echo "To";
        		dump($to);
        	}

        	$relatory = [];
        	foreach ($consultants as $consultant) {

        		$consultant = User::find($consultant);

        		if($request->developer) {
        			echo "Consultant";
        			dump($consultant);
        		}

				// Custo Fixo
        		$salary = $consultant->salary;

        		if(!$salary)
        			throw new Exception("The consultant '$consultant->no_usuario' doesn't have a salary.", 1);
        			
        		$custo_fixo = $salary->brut_salario;

        		$relatory[ $consultant->co_usuario ]['no_usuario'] = $consultant->no_usuario;
        		foreach ($period as $date) {
	    			$relatory[ $consultant->co_usuario ]['period'][$date->format('Y-m')]['receita_liquida'] = 0;
	    			$relatory[ $consultant->co_usuario ]['period'][$date->format('Y-m')]['custo_fixo'] = $custo_fixo;
	    			$relatory[ $consultant->co_usuario ]['period'][$date->format('Y-m')]['comissao'] = 0;
	    			$relatory[ $consultant->co_usuario ]['period'][$date->format('Y-m')]['lucro'] = 0;
	    		}

        		$service_orders = $consultant->service_orders;

        		foreach ($service_orders as $service_order) {

        			$invoices = $service_order->invoices;

        			foreach ($invoices as $invoice) {
        				$created_at = Carbon::parse($invoice->data_emissao);

        				if( $created_at->between($from, $to) ) {
							// Receita liquida
        					$receita_liquida = $invoice->valor - ( $invoice->valor * ( $invoice->total_imp_inc / 100 ) );

							// Comissao
        					$comissao = $receita_liquida * ( $invoice->comissao_cn / 100 );

        					$created_at_s = $created_at->format('Y-m');

							$relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['receita_liquida'] += $receita_liquida;
							$relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['comissao'] += $comissao;

							// Lucro 
							$relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['lucro'] = 
							$relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['receita_liquida'] - 
							( $relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['custo_fixo'] +
								$relatory[ $consultant->co_usuario ]['period'][ $created_at_s ]['comissao'] );

        				}
        			}

        		}
        	}

        	if($request->developer) {
        		echo "Relatives data";
        		dd($relatory);
        	}

        	return view('dashboard.consultant.relatory')->with(['relatory'=> $relatory]);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return back()
                    ->with('notification_error', $exception->getMessage())
                    ->withInput();
        }
    }

    /**
     * Retrieves graphic dataset from the consultant.
     */
    public function graphic(Request $request)
    {
    	/*$request->consultants = [
    		'carlos.arruda'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';*/

    	try {

	    	$consultants =  $request->consultants;

	    	$from = Carbon::parse($request['from-date']);
        	$to = Carbon::parse($request['to-date']);

        	if(!$from || !$to)
                throw new Exception("Please fill all the dates from the period.", 1);

            if($from->gt($to)) 
                throw new Exception("The start date is greater that the end date.", 1);

        	$period = CarbonPeriod::create($from, '1 month', $to);

        	$months = [];
        	foreach ($period as $date) {
        		$months[] = $date->format('Y M');
        	}

	    	if(!$consultants)
    			throw new Exception("No consultant has been selected.", 1);

	    	if($request->developer) {
				echo "Consultants";
				dump($consultants);

				echo "From";
				dump($from);

				echo "To";
				dump($to);
			}

	    	$graphic = [];
	    	$graphic['months'] = $months;
	    	$custo_fixo_medio = 0;
	    	foreach ($consultants as $consultant) {

	    		$consultant = User::find($consultant);
	    		$graphic['consultants'][ $consultant->co_usuario ]['no_usuario'] = $consultant->no_usuario;

	    		foreach ($period as $date) {
	    			$graphic['consultants'][ $consultant->co_usuario ]['graphic']['period'][$date->format('Y-m')] = 0;
	    		}
	    		

	    		// Custo Fixo
	    		$salary = $consultant->salary;

	    		if(!$salary)
        			throw new Exception("The consultant '$consultant->no_usuario' doesn't have a salary.", 1);
	    		
	    		$custo_fixo_medio += $salary->brut_salario;

	    		if($request->developer) {
	    			echo "Consultant";
	    			dump($consultant);
	    		}

	    		$service_orders = $consultant->service_orders;

	    		foreach ($service_orders as $service_order) {

	    			$invoices = $service_order->invoices->sortBy('data_emissao');

	    			foreach ($invoices as $invoice) {
	    				$created_at = Carbon::parse($invoice->data_emissao);

		    			if( $created_at->between($from, $to) ) {
		    				// Receita liquida
		    				$receita_liquida = $invoice->valor - ( $invoice->valor * ( $invoice->total_imp_inc / 100 ) );
		    				$receita_liquida = round($receita_liquida);
		    				$created_at_s = $created_at->format('Y-m');

	    					$graphic['consultants'][ $consultant->co_usuario ]['graphic']['period'][ $created_at_s ] += $receita_liquida;
		    			}
	    			}
	    		}
	    	}

			$graphic['custo_fixo_medio'] = $custo_fixo_medio / count($consultants);

			if($request->developer) {
				echo "Graphic data";
				dd($graphic);
			}

	        return view('dashboard.consultant.graphic')->with(['graphic'=> $graphic]);

	    } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return back()
                    ->with('notification_error', $exception->getMessage())
                    ->withInput();
        }
    }

    /**
     * Retrieves cake dataset from the consultant.
     */
    public function cake(Request $request)
    {
    	/*$request->consultants = [
    		'carlos.arruda',
    		'carlos.carvalho'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';*/

    	try {

	    	$consultants =  $request->consultants;

	    	$from = Carbon::parse($request['from-date']);
        	$to = Carbon::parse($request['to-date']);

        	if(!$from || !$to)
                throw new Exception("Please fill all the dates from the period.", 1);

            if($from->gt($to)) 
                throw new Exception("The start date is greater that the end date.", 1);

	    	if(!$consultants)
    			throw new Exception("No consultant has been selected.", 1);

	    	if($request->developer) {
				echo "Consultants";
				dump($consultants);

				echo "From";
				dump($from);

				echo "To";
				dump($to);
			}

	    	$cake = [];
	    	$cake['total'] = 0;
	    	foreach ($consultants as $consultant) {

	    		$consultant = User::find($consultant);

	    		if($request->developer) {
	    			echo "Consultant";
	    			dump($consultant);
	    		}

	    		$service_orders = $consultant->service_orders;

	    		foreach ($service_orders as $service_order) {

	    			$invoices = $service_order->invoices;

	    			foreach ($invoices as $invoice) {
	    				$created_at = Carbon::parse($invoice->data_emissao);

		    			if( $created_at->between($from, $to) ) {
		    				// Receita liquida
		    				$receita_liquida = $invoice->valor - ( $invoice->valor * ( $invoice->total_imp_inc / 100 ) );

		    				if( !isset($cake['cake'][ $consultant->co_usuario ] ) ) {
		    					$cake['cake'][ $consultant->co_usuario ]['receita_liquida'] = 0;
		    				} else {
		    					$cake['total'] += $receita_liquida;
		    					$cake['cake'][ $consultant->co_usuario ]['receita_liquida'] += $receita_liquida;
		    				}
		    			}
	    			}
	    		}
	    	}

	    	if(!array_key_exists('cake', $cake)) {
	    		throw new Exception("None of the consultants has invoices", 1);
	    	}

	    	foreach ($cake['cake'] as $co_usuario => $consultant) {
	    		$cake['cake'][ $co_usuario ]['percentage'] = round(($consultant['receita_liquida'] * 100) / ($cake['total']), 2);
	    	}

			if($request->developer) {
				echo "Cake data";
				dd($cake);
			}

	    	return view('dashboard.consultant.cake')->with(['cake'=> $cake]);
	    } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return back()
                    ->with('notification_error', $exception->getMessage())
                    ->withInput();
        }
    }
}
