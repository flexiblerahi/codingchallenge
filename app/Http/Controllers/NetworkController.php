<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
   public function getsuggestion(Request $request)
   {
      $user = Network::where('user_id', auth()->id())->get()->first();
      $condition = array_merge(explode(',', $user->sent), explode(',', $user->receive), explode(',', $user->connection), [0=> auth()->id()]);
      $data = array();
      if($request->lastid) {
         $data = User::where('id', '>', $request->lastid)->whereNotIn('id', $condition)->limit(10)->get(['id', 'name', 'email']);
      } else {
         $data = User::whereNotIn('id', $condition)->limit(10)->get(['id', 'name', 'email']);
      }
      // $condition = array_merge(explode(',', $user->sent), explode(',', $user->receive), explode(',', $user->connection), [0=> auth()->id()]);
      // $suggestioncount = User::whereNotIn('id', $condition)->get(['id', 'name', 'email']);
      // $data  = [];
      // if ($id) {
      //     $posts = Post::where('id', '>', $id)
      //         ->orderBy('id', 'ASC')
      //         ->with('user:id,created_at,name,profile_img', 'comments:id,post_id,comment', 'likes:id,post_id')
      //         ->select(['id', 'image', 'description', 'created_at', 'user_id'])
      //         ->limit(5)
      //         ->get();
      //     $data = array('posts' => PostResource::collection($posts));
      // } else {
      //     $posts = Post::orderBy('id', 'ASC')
      //         ->with('user:id,created_at,name,profile_img', 'comments:id,post_id,comment', 'likes:id,post_id')
      //         ->select(['id', 'image', 'description', 'created_at', 'user_id'])
      //         ->limit(5)
      //         ->get();
      //     $data = [
      //         'posts' => PostResource::collection($posts),
      //         'authuser' => AuthUserResource::make(auth()->user()),
      //     ];
      // }
      return response()->json($data);
   }

   public function sendrequest(Request $request)
   {
      $users = Network::whereIn('user_id', [auth()->id(), $request->user_id])->get();
      $user = $users->where('user_id', auth()->id())->first();
      $user->sent = ($user->sent==null) ? $request->user_id : $user->sent.','.$request->user_id;
      $user->save();
      
      $user1 = $users->where('user_id', $request->user_id)->first();
      $user1->receive = ($user1->receive==null) ? auth()->id() : $user1->receive.','.auth()->id();
      $user1->save();
      return $this->renderlist($user);
   }

   public function removeconnection(Request $request)
   {
      $users = Network::whereIn('user_id', [auth()->id(), $request->user_id])->get();
      $user = $users->where('user_id', auth()->id())->first();
      $connectionarray = explode(',', $user->connection);
      unset($connectionarray[array_search($request->user_id, $connectionarray)]);
      $user->connection = count($connectionarray) == 0 ? null : implode(',', $connectionarray);
      $user->save();

      $user1 = $users->where('user_id', $request->user_id)->first();
      $connection1array = explode(',', $user1->connection);
      unset($connection1array[array_search(auth()->id(), $connection1array)]);
      $user1->connection = count($connection1array) == 0 ? null : implode(',', $connection1array);
      $user1->save();
      return $this->renderlist($user);
   }

   public function acceptrequest(Request $request)
   {
      $users = Network::whereIn('user_id', [auth()->id(), $request->user_id])->get();
      $user = $users->where('user_id', auth()->id())->first();
      $receivearray = explode(',', $user->receive);
      unset($receivearray[array_search($request->user_id, $receivearray)]);
      $user->receive = count($receivearray) == 0 ? null : implode(',', $receivearray);
      $user->connection = ($user->connection==null) ? $request->user_id : $user->connection.','.$request->user_id;
      $user->save();

      $user1 = $users->where('user_id', $request->user_id)->first();
      $sentarray = explode(',', $user1->sent);
      unset($sentarray[array_search(auth()->id(),$sentarray)]);
      $user1->sent = (count($sentarray) == 0) ? null : implode(',', $sentarray);
      $user1->connection = ($user1->connection==null) ? auth()->id() : $user1->connection.','.auth()->id();
      $user1->save();
      return $this->renderlist($user);
   }

   public function withdrawrequest(Request $request)
   {
      $users = Network::whereIn('user_id', [auth()->id(), $request->user_id])->get();
      $user = $users->where('user_id', auth()->id())->first();
      $sentarray = explode(',', $user->sent);
      unset($sentarray[array_search($request->user_id,$sentarray)]);
      $user->sent = (count($sentarray) == 0) ? null : implode(',', $sentarray);
      $user->save();

      $user1 = $users->where('user_id', $request->user_id)->first();
      $receivearray = explode(',', $user1->receive);
      unset($receivearray[array_search($request->user_id,$receivearray)]);
      $user1->receive = (count($receivearray) == 0) ? null : implode(',', $receivearray);
      $user1->save();
      return $this->renderlist($user);
   }

   public function renderlist($user)
   {
      $sentreqlist = User::whereIn('id', explode(',', $user->sent))->get(['id', 'name', 'email']);
      $recievereqlist = User::whereIn('id', explode(',', $user->receive))->get(['id', 'name', 'email']);
      $connectionlist = User::whereIn('id', explode(',', $user->connection))->with('network')->get(['id', 'name', 'email']);
      $condition = array_merge(explode(',', $user->sent), explode(',', $user->receive), explode(',', $user->connection), [0=> auth()->id()]);
      $suggestioncount = User::whereNotIn('id', $condition)->get(['id', 'name', 'email']);
      return view('components.network_connections', compact('sentreqlist', 'recievereqlist', 'connectionlist', 'suggestioncount'))->render();
   }
}
