<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Carbon\Carbon;

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
    public function index()
    {
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

        return view('dashboard.consultant.index')->with($consultants);
    }

    /**
     * Retrieves relatory dataset from the consultant.
     */
    public function relatory(Request $request)
    {
    	/*$request->consultants = [
    		'carlos.arruda'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';*/

    	$consultants =  $request->consultants;

    	$from = Carbon::parse($request->from);
    	$to = Carbon::parse($request->to);

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
    		$custo_fixo = $salary->brut_salario;

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

	    				if( !isset($relatory[ $consultant->co_usuario ][ $created_at_s ] ) ) {
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['receita_liquida'] = 0;
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['custo_fixo'] = $custo_fixo;
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['comissao'] = 0;
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['lucro'] = 0;
	    				} else {
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['receita_liquida'] += $receita_liquida;
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['comissao'] += $comissao;

	    					// Lucro 
	    					$relatory[ $consultant->co_usuario ][ $created_at_s ]['lucro'] = 
	    						$relatory[ $consultant->co_usuario ][ $created_at_s ]['receita_liquida'] - 
	    						( $relatory[ $consultant->co_usuario ][ $created_at_s ]['custo_fixo'] +
	    						  $relatory[ $consultant->co_usuario ][ $created_at_s ]['comissao'] );
	    				}
	    			}
    			}

    		}
    	}

    	if($request->developer) {
			echo "Relatives data";
			dd($relatory);
		}

        return view('dashboard.consultant.relatory')->with($relatory);
    }

    /**
     * Retrieves graphic dataset from the consultant.
     */
    public function graphic(Request $request)
    {
    	$request->consultants = [
    		'carlos.arruda'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';

    	$consultants =  $request->consultants;

    	$from = Carbon::parse($request->from);
    	$to = Carbon::parse($request->to);

    	if($request->developer) {
			echo "Consultants";
			dump($consultants);

			echo "From";
			dump($from);

			echo "To";
			dump($to);
		}

    	$graphic = [];
    	$custo_fixo_medio = 0;
    	foreach ($consultants as $consultant) {

    		$consultant = User::find($consultant);

    		// Custo Fixo
    		$salary = $consultant->salary;
    		$custo_fixo_medio += $salary->brut_salario;

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
	    				
	    				$created_at_s = $created_at->format('Y-m');

	    				if( !isset($graphic['graphic'][ $consultant->co_usuario ][ $created_at_s ] ) ) {
	    					$graphic['graphic'][ $consultant->co_usuario ][ $created_at_s ]['receita_liquida'] = 0;
	    				} else {
	    					$graphic['graphic'][ $consultant->co_usuario ][ $created_at_s ]['receita_liquida'] += $receita_liquida;
	    				}
	    			}
    			}
    		}
    	}

		$graphic['custo_fixo_medio'] = $custo_fixo_medio / count($consultants);

		if($request->developer) {
			echo "Graphic data";
			dd($graphic);
		}

        return view('dashboard.consultant.graphic')->with($graphic);
    }

    /**
     * Retrieves cake dataset from the consultant.
     */
    public function cake(Request $request)
    {
    	$request->consultants = [
    		'carlos.arruda',
    		'carlos.carvalho'
    	];
    	$request->from = '2007-01-01';
    	$request->to = '2008-01-01';

    	$consultants =  $request->consultants;

    	$from = Carbon::parse($request->from);
    	$to = Carbon::parse($request->to);

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

    	foreach ($cake['cake'] as $co_usuario => $consultant) {
    		$cake['cake'][ $co_usuario ]['percentage'] = round(($consultant['receita_liquida'] * 100) / ($cake['total']), 2);
    	}

		if($request->developer) {
			echo "Cake data";
			dd($cake);
		}

    	return view('dashboard.consultant.cake')->with($cake);
    }
}
