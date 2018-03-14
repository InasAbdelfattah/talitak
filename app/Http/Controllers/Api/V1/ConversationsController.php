<?php

namespace App\Http\Controllers\Api\V1;

use App\Conversation;
use App\Events\AddNewComment;
use App\Events\AddNewMessage;
use App\Libraries\PushNotification;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Notification;
use Psy\Test\Exception\RuntimeExceptionTest;

class ConversationsController extends Controller
{


    public $push;

    function __construct(PushNotification $push)
    {

        $this->push = $push;
    }


    public function sendMessage(Request $request)
    {
        $sender = User::whereApiToken($request->api_token)->first();
        $receiver = User::whereId($request->userId)->first();

        if ($sender && $receiver) {
            $hasConversation = Conversation::whereHas('users', function ($q) use ($sender) {
                $q->whereId($sender->id);
            })->whereHas('users', function ($q) use ($receiver) {
                $q->whereId($receiver->id);
            })->first();
        }

        if (!$hasConversation) {

            $conversation = new Conversation;
            if ($conversation->save()) {
                $conversation->users()->attach([$sender->id, $receiver->id]);
                $message = new Message;
                $message->message = $request->message;
                $message->conversation_id = $conversation->id;
                $message->user_id = $sender->id;
                $message->save();

                //event(new \App\Events\TaskEvent($user->id, $message));

                //$userAdv = User::whereId($adv->user_id)->first();
                // $userAdv->notify(new \App\Notifications\PostCommentForAdvertisement($request->message, 1, $adv->id, 1));

                // $countMessage = $userAdv->unreadNotifications()->where('n_type', 1)->get()->count();
                // $countNotify = $userAdv->unreadNotifications()->where('n_type', 0)->get()->count();
                //event(new AddNewMessage($request->message, $countMessage, $countNotify, $userAdv->id, 1, $user, $adv ));
                //$this->pushNotification('لديك رسالة جديدة' , $userAdv , 'message', $conversation->id);

                // DB::table('conversation_user')->where(['user_id' => $user->id, 'conversation_id' => $message->conversation_id])->update(['is_online' => 1]);


                // $userAdv = User::whereId($adv->user_id)->first();
                //$userAdv->notify(new \App\Notifications\PostCommentForAdvertisement($request->message, 1, $request->advId, 1));

                // $countMessage = $userAdv->unreadNotifications()->where('n_type', 1)->get()->count();
                // $countNotify = $userAdv->unreadNotifications()->where('n_type', 0)->get()->count();

                // $conversation = Conversation::whereId($message->conversation_id)->first();
//                event(new AddNewMessage($message, $countMessage, $countNotify, $userAdv->id, 1, $user, $message->conversation_id));
//
//                $notify = $userAdv->notifications()->orderBy('created_at', 'desc')->first();
//                $this->push->sendPushNotification('لديك رسالة جديدة ', $userAdv, $user, $additional = ['notify' => $notify, 'convId' => $message->conversation_id], true);


                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'data' => $conversation
                ]);
//                event(new \App\Events\TaskEvent($user->id, $adv->user_id, $adv->id, $request->message));
                // event(new \App\Events\TaskEvent($adv->user_id, $request->message));
            } else {
                return response()->json([
                    'status' => false,

                ]);
            }
        } else {


            $to = $hasConversation->users()->where('id', '!=', $sender->id)->first();
            //$isHaveConversationWithAdv->users()->attach($user->id);
            $message = new Message;
            $message->message = $request->message;
            $message->conversation_id = $hasConversation->id;
            $message->user_id = $sender->id;
            $message->save();


            $conversationUsers = DB::table('conversation_user')
                ->where(['conversation_id' => $message->conversation_id])
                ->where('user_id', '!=', $sender->id)
                ->get();


//            $userOnline = DB::table('conversation_user')->where(['user_id' => $conversationUsers[0]->user_id, 'conversation_id' => $isHaveConversationWithAdv->id])->first();


//            if ($userOnline->is_online == 0) {
//                $notify = $to->notifications()->orderBy('created_at', 'desc')->first();
//                $this->push->sendPushNotification('لديك رسالة جديدة ', $to, $sender, $additional = ['notify' => $notify, 'convId' => $isHaveConversationWithAdv->id], true);


//            $userAdv = User::whereId($adv->user_id)->first();
            // $to->notify(new \App\Notifications\PostCommentForAdvertisement($request->message, 1, $request->advId, 1));

        }

//            $to->notify(new \App\Notifications\PostCommentForAdvertisement($request->message, 1, $request->advId, 1));
//            $countMessage = $to->unreadNotifications()->where('n_type', 1)->get()->count();
//            $countNotify = $to->unreadNotifications()->where('n_type', 0)->get()->count();
//            event(new AddNewComment($request->message, $countMessage, $countNotify, $to->id, 1));
//            event(new \App\Events\TaskEvent($to->id, $message));
//            $this->pushNotification('لديك رسالة جديدة'  , $to , 'message', $request->convId);


//            DB::table('conversation_user')
//                ->where(['user_id' => $to->id, 'conversation_id' => $request->convId])
//                ->update(['read_at' => null]);

//
//            DB::table('conversation_user')
//                ->where(['user_id' => $user->id, 'conversation_id' => $request->convId])
//                ->update(['read_at' => date('Y-m-d H:i:s')]);
//

//            if ($request->convId) {
//                $conversation = Conversation::where('id', $request->convId)->first();
//                $conversation->updated_at = date('Y-m-d H:i:s');
//                $conversation->update();
//            }


//            $countMessage = DB::table('conversation_user')->where(['user_id' => $to->id, 'read_at' => null, 'deleted_at' => null])->get()->count();

        //$countMessage = $to->unreadNotifications()->where('n_type', 1)->get()->count();
//            $countNotify = $to->unreadNotifications()->where('n_type', 0)->get()->count();


//            event(new AddNewMessage($message, $countMessage, $countNotify, $to->id, 1, $user, $message->conversation_id));

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $hasConversation,

        ]);

//        }

    }


    public function getListOfConversations(Request $request, $pageSize = 15)
    {


        $user = User::whereApiToken($request->api_token)->first();


//        return $user;

//        foreach ($token->unreadNotifications()->where('n_type', 1)->get() as $notification) {
//            $notification->markAsRead();
//        }

        $arr = [];
        foreach ($user->conversations as $row) {
            $arr[] = $row->id;
        }


        $pageSize = $request->pageSize;
        $skipCount = $request->skipCount;
        $itemId = $request->itemId;
        $page = $request->page;

        $currentPage = $request->get('page', $page); // Default to 1


        $query = Conversation::orderBy('updated_at', 'DESC')->select();
        $query->whereIn('id', $arr);


        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        //return $query->get();


        //  $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        // $query->take($pageSize);


        $convs = $query->orderBy('created_at', 'DESC')->get();


//        $conversations = Conversation::orderBy('created_at', 'DESC')->select();
//        $conversations->whereIn('id', $arr);
//        $query = $conversations
//            ->with('advs')
//            ->paginate($request->page_size);

        $convs->map(function ($q) use ($user) {
            $q->read_at = DB::table('conversation_user')->where(['user_id' => $user->id, 'conversation_id' => $q->id])->first()->read_at;
//            $q->deleted_at = DB::table('conversation_user')->where(['user_id' => $token->id, 'conversation_id' => $q->id])->first()->deleted_at;
            $q->deleted_at = DB::table('conversation_user')->where(['user_id' => $user->id, 'conversation_id' => $q->id])->first() ? DB::table('conversation_user')->where(['user_id' => $user->id, 'conversation_id' => $q->id])->first()->deleted_at : null;

            $q->lastMessage = is_object($q->messages()->orderBy('created_at', 'desc')->first()) ? $q->messages()->orderBy('created_at', 'desc')->first()->created_at->toDateTimeString() : null;
            $q->lastmsg = is_object($q->messages()->orderBy('created_at', 'desc')->where('conversation_id', $q->id)->first()) ? $q->messages()->orderBy('created_at', 'desc')->where('conversation_id', $q->id)->first()->message : null;
            $q->user = $q->users()->where('id', '!=', $user->id)->first();
            $q->dateDiff = strtotime(Carbon::now()) - strtotime($q->lastMessage);
        });


        $data = $convs->filter(function ($q) {
            $q->orderBy($q->lastMessage, 'DESC');
            return date('Y-m-d H:i:s', strtotime($q->lastMessage)) > date('Y-m-d H:i:s', strtotime($q->deleted_at));

            //  return $q;

        })->slice($skipCount + (($currentPage - 1) * $pageSize))
            ->take($pageSize)
            ->values();


        return response()->json([
            'status' => true,
            'data' => $data
        ]);


    }


    public function getLangsNames($id)
    {

        $ad = \App\Advertisement::whereId($id)->first();

        return [
            [
                'language' => 'ar',
                'name' => ($ad) ? $ad->{'name:ar'} : " ",
                'description' => ($ad) ? $ad->{'description:ar'} : ""
            ],
            [
                'language' => 'en',
                'name' => ($ad) ? $ad->{'name:en'} : " ",
                'description' => ($ad) ? $ad->{'description:en'} : ""
            ]

        ];

    }

    public function getAllMessages(Request $request)
    {
        $pageSize = $request->pageSize;
        $skipCount = $request->skipCount;
;

        $currentPage = $request->get('page', 1); // Default to 1

        // API authenticated user is considered the sender in this case.
        $authUserId = auth()->user()->id;


        DB::table('conversation_user')
            ->where(['user_id' => $authUserId, 'conversation_id' => $request->convId])
            ->update(['is_online' => 1]);


        $conversation = Conversation::with(['users', 'messages'])->find($request->convId);



        $sender = collect($conversation->users)->reject(function ($user) use ($authUserId) {
            return $user->id != $authUserId;
        })->first();


        $senderConversationDeletedAt = $sender->pivot->deleted_at ?: null;

        $messages = collect($conversation->messages)->reject(function ($message) use ($senderConversationDeletedAt) {
            return $message->created_at < $senderConversationDeletedAt;
        })->slice($skipCount + (($currentPage - 1) * $pageSize))
            ->take($pageSize)
            ->values();


        $messages->map(function ($q) {
            $q->user = $this->getUserInfo($q->user_id);
            $q->dateDiff = strtotime(Carbon::now()) - strtotime($q->created_at);
            return $q;

        });

        if ($messages->count() > 0) {
            return response()->json([
                'status' => true,
                'data' => $messages
            ]);

        } else {
            return response()->json([
                'status' => true,
                'data' => []
            ]);
        }
    }


    public function getUserInfo($id)
    {

        $user = User::whereId($id)->first();

        if ($user) {

            return [
                'username' => $user->name,
                'image' => $user->image
            ];

        } else {

            return [
                'username' => 'غير موجود',
                'image' => 'notfound'
            ];

        }


    }


    public function markConversationAsRead(Request $request)
    {

        $user = User::whereApiToken($request->api_token)->first();


        $data = DB::table('conversation_user')
            ->where(['user_id' => $user->id, 'conversation_id' => $request->convId])
            ->update(['read_at' => date('Y-m-d H:i:s')]);


        $dataCount = DB::table('conversation_user')
            ->where(['user_id' => $user->id, 'read_at' => null]);


        if ($data) {
            $countMessage = DB::table('conversation_user')->where(['user_id' => $user->id, 'read_at' => null, 'deleted_at' => null])->get()->count();
            //  $countMessage = $user->unreadNotifications()->where('n_type', 1)->get()->count();
            return response()->json([
                'status' => true,
                'data' => $data,
                'count' => $countMessage
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);

        }


    }


    public function pushNotification($message, $user, $type, $id)
    {

        $content = array(
            "en" => $message
        );


        $devices = [$user->device];


//        foreach ($users as $user) {
//
//            if ($user->id == $current) {
//                continue;
//            }
//
//            if ($user->device && $user->device != NULL)
//                $devices[] = $user->device;
//
//        }


        $data = [
            'status' => 'public',
            'type' => $type,
            'created_at' => date('Y-m-d H:i:s'),
            'convId' => $id
        ];

        $fields = array(
            'app_id' => "960a09cd-5d50-45f8-b96c-87cc85e58506",
            'include_player_ids' => $devices,
            'contents' => $content,
            'data' => $data,
            'android_group' => 'harag',
            'ios_badgeType' => 'Increase',
            'ios_badgeCount' => 1,

        );


        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZDQ2MzEzZDctMzI3Ny00NTNjLWJmMDQtMTMxYjg1OGIzZWNj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        $response;


    }


    public function deleteConversation(Request $request)
    {
        // get authenticated user
        $user = User::whereApiToken($request->api_token)->first();

        // get conversation want to be delete.
        $coversation = Conversation::whereId($request->convId)->first();

        // get conversation for auth user
        $sender = collect($coversation->users)->reject(function ($user1) use ($user) {
            return $user1->id != $user->id;
        })->first();

        // set delete conversation at NOW
        $sender->pivot->deleted_at = date('Y-m-d H:i:s');

        /**
         * @return response json after delete message.
         */

        if ($sender->pivot->save()) {
            return response()->json([
                'status' => true,
                'message' => 'convdeleted'
            ]);
        }
    }


    public function deleteUserDevices(Request $request)
    {
        $user = User::whereApiToken($request->api_token)->first();
        if ($user) {
            $device = \App\Device::where(['device' => $request->playerId, 'user_id' => $user->id])->first();
            $device->delete();
        }
    }


    public function makeUserConversationOffline(Request $request)
    {
        // get authenticated user
        $user = User::whereApiToken($request->api_token)->first();

        $offline = DB::table('conversation_user')
            ->where(['user_id' => $user->id, 'conversation_id' => $request->convId])
            ->update(['is_online' => 0]);

        return response()->json([
            'status' => true,
            'message' => 'user offline'
        ]);
    }


}
