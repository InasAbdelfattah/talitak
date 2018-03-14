<?php

namespace App\Libraries;

use App\Libraries\FirebasePushNotifications\Firebase;
use App\Libraries\FirebasePushNotifications\Push;

class PushNotification
{

//    public $push;
//    public $firebase;
//
//    public function __construct(Push $push, Firebase $firebase)
//    {
//        $this->push = $push;
//        $this->firebase = $firebase;
//    }

    /**
     * @param $message -> message will be sent in notification body.
     * @param $users -> users will receive notification
     * @param $current -> current user for prevent notification created for this user.
     * @param array $additional -> additional data will be send with notification
     * @param bool $single -> check for sending group or send single.
     *
     */

    public function sendPushNotification()
    {

        //Type error: Too few arguments to function App\Libraries\PushNotification::__construct(), 0 passed in E:\Saned Projects\_Shaqrady\routes\api.php on line 22 and exactly 2 expected

        $push = new Push();
        $firebase = new Firebase();


        // optional payload
        $payload = array();
        $payload['team'] = 'Saned Egypt';
        $payload['backendDeveloper'] = 'Hassan Saeed';
        $payload['FrontendDeveloper01'] = 'Mohamed Dawood';
        $payload['FrontendDeveloper02'] = 'Ahmed Maher';

        $title = "Hassan";
        // notification title
        $push->setTitle($title);

        // notification message
        $message = 'Message of Notification (HASSAN)';

        // push type - single user / topic
//        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : 'topic';

        $push_type = 'individual';

        // whether to include to image or not
        $include_image = isset($_GET['include_image']) ? TRUE : FALSE;


        $push->setMessage($message);

        if ($include_image) {
            $push->setImage('https://api.androidhive.info/images/minion.jpg');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(TRUE);
        $push->setPayload($payload);


        $json = '';
        $response = '';
        $pushData = array('title' => 'okay', 'body' => 'Okay Mr Davd', 'image' => 'https://api.androidhive.info/images/minion.jpg');

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : 'dVRONID1al8:APA91bHdUFINArcXeD50YoxwBKK2spUqw7h_-s0nSsdy_HQDeUqVWWg-02XKyXt4ia3VQ0F_Ij77CawiYq_wZu4WfDVDvHHf52s2Ub_Bg6CZ67Hnc1VTMnoWkEWBYklmsWygRs5MgyLe';
            $response = $firebase->send($regId, $json, $pushData);
        }

        return $response;
    }

    
}