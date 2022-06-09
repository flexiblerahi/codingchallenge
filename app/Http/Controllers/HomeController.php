<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Network::where('user_id', auth()->id())->get();
        $networks = ($data->first()) ? $data->first() : Network::create(['user_id' => auth()->id()]);
        // dd($networks->receive);
        $sentreqlist = ($networks->sent) ? User::whereIn('id', explode(',', $networks->sent))->get(['id', 'name', 'email']) : array();
        
        $recievereqlist = ($networks->receive) ? User::whereIn('id', explode(',', $networks->receive))->get(['id', 'name', 'email']) : array();
        $connectionlist = ($networks->connection) ? User::whereIn('id', explode(',', $networks->connection))->get(['id', 'name', 'email']) : array();
        $condition = array_merge(explode(',', $networks->sent), explode(',', $networks->receive), explode(',', $networks->connection), [0=> auth()->id()]);
        $suggestioncount = User::whereNotIn('id', $condition)->count();
        return view('home', compact('sentreqlist', 'recievereqlist', 'connectionlist', 'suggestioncount'));
    }
}
