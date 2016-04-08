<?php
namespace api\modules\v1\controllers;

use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
//use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use api\modules\v1\models\Event;
use common\models\SignupForm;
use yii\web\Response;
use common\models\EventUser;

class EventController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
            'only' => [
                'get-events',
                'add-user',
                'get-users'
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'get-events',
                'add-user',
                'get-users'
            ],
            'rules' => [
                [
                    'actions' => ['get-events','get-users'],
                    'allow' => true,
                    'roles' => ['admin']
                ],
                [
                    'actions' => ['add-user'],
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-events' => ['GET'],
                'add-user' => ['GET'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetEvents()
    {
        $userId = Yii::$app->user->id;
        $model = new EventUser();
        $AllowEvents = array();
        $events = $model::find()->select('event_id')->where(['user_id' => intval($userId)])->all();
        foreach ($events as $item) {
            $currEvent = Event::find()->where(['id' => $item['event_id']])->one();
            array_push($AllowEvents, $currEvent);
        }
        return $AllowEvents;
    }

    public function actionAddUser()
    {
        $signAup = new SignupForm();
        $model = new EventUser();
        $data = Yii::$app->request->get();
        $signAup->email = $data['usermail'];
        $signAup->username = $data['username'];
        $signAup->password = $data['userpass'];
        if ($user = $signAup->signup()) {
            $model->userpass = Yii::$app->security->generatePasswordHash($signAup->password);
            $model->user_id = $user->id;
            $model->username = $signAup->username;
            $model->usermail = $signAup->email;
            $model->event_id = $data['eventId'];
            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function actionGetUsers()
    {
        $eventId=Yii::$app->request->get()['eventId'];
        $model=new EventUser();
        $AllowUsers = array();
        $users = $model::find()->select('user_id')->where(['event_id' => intval($eventId)])->all();
        foreach ($users as $item) {
            $currEvent = User::find()->select(['username','id'])->where(['id' => $item['user_id']])->one();
            array_push($AllowUsers, $currEvent);
        }
        return $AllowUsers;
    }



}