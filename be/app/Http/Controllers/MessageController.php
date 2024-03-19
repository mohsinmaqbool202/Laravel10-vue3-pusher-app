<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Models\User;
use Exception;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**\
     * @param $friend_id
     * @return jsonResponse
    */
    public function fetchMessages($friend_id) : JsonResponse
    {
        try {
            $friend = User::find($friend_id);
            $authUser = Auth::user();

            if($friend_id == $authUser->id) {
                #broadcast messages
                $messages = Message::with('user')->whereNull('receiver_id')->get();
            }
            else {
                #one to one messages
                $messages = Message::with('user')
                    ->where(['user_id' => $authUser->id, 'receiver_id' => $friend->id])
                    ->orWhere(function($query) use($friend, $authUser) {
                        $query->where(['user_id' => $friend->id, 'receiver_id' => $authUser->id]);
                    })
                    ->get();
            }
            return $this->successMessage($messages, 'Messages list');
        }
        catch(Exception $e) {
            return $this->errorMessage(null, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return jsonResponse
    */
    public function sendMessage(Request $request) : JsonResponse
    {
        try {
            $authUser = Auth::user();
            if($authUser->id === $request->friend_id) {
                #broadcast message
                $message = Auth::user()->messages()->create(['message' => $request->message]);
                broadcast(new MessageSent(Auth::user(), $message->load('user')))->toOthers();
            }
            else {
                #one to one message
                $message = Auth::user()->messages()->create(['message' => $request->message, 'receiver_id' => $request->friend_id]);
                broadcast(new PrivateMessageSent($message->load('user')))->toOthers();
            }
            return $this->successMessage($message, 'Message has been delievered');
        }
        catch(Exception $e) {
            return $this->errorMessage(null, 'Unable to send message');
        }
    }
}
