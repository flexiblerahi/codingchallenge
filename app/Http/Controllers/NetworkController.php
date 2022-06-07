<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
   public function sendrequest(Request $request)
   {
        $user = Network::where('user_id', auth()->id())->firstorfail();
        $user->sent = ($user->sent==null) ? $request->user_id : $user->sent.','.$request->user_id;
        $user->save();

        $sentreqlist = User::whereIn('id', explode(',', $user->sent))->get(['id', 'name', 'email']);
        $recievereqlist = User::whereIn('id', explode(',', $user->receive))->get(['id', 'name', 'email']);
        $connectionlist = User::whereIn('id', explode(',', $user->connection))->with('network')->get(['id', 'name', 'email']);
        $condition = array_merge(explode(',', $user->sent), explode(',', $user->receive), explode(',', $user->connection), [0=> auth()->id()]);
        $suggestioncount = User::whereNotIn('id', $condition)->get(['id', 'name', 'email']);
        return view('components.network_connections', compact('sentreqlist', 'recievereqlist', 'connectionlist', 'suggestioncount'))->render();
        // return view('frontend.product.productpaginate', compact('products', 'searchproduct'))->render();
   }

   
}
