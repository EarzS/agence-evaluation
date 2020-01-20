<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.client.index');
    }

    /**
     * Retrieves relatory dataset from the client.
     */
    public function relatory()
    {
        return view('dashboard.client.relatory');
    }

    /**
     * Retrieves cake dataset from the client.
     */
    public function cake()
    {
        return view('dashboard.client.cake');
    }

    /**
     * Retrieves graphic dataset from the client.
     */
    public function graphic()
    {
        return view('dashboard.client.graphic');
    }
}
