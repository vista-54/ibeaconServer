<?php
namespace api\modules\v1\controllers;

use common\models\EventSearch;
use common\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
//use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use common\models\Event;
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
                    'actions' => ['get-events', 'get-users'],
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
        $model = new Event();
        $model->load(Yii::$app->request->get(), '');
        $query = Event::find();
        $pagination = new Pagination([
            'defaultPageSize' => $model->page_size,
            'page' => intval($model->current_page - 1),
            'totalCount' => $query->count(),
            'pageSizeLimit' => $model->current_page * $model->page_size,
            'pageParam'=>array('page'=>$model->current_page)
        ]);
        $sort = $model->order_attr . ' ' . $model->order_sorting;
        $events = $query->orderBy($sort)
            ->offset(($pagination->offset))
            ->limit($pagination->limit)
            ->all();

        return array(
            'events' => $events,
            'paginations' => $pagination
        );

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
        $eventId = Yii::$app->request->get()['eventId'];
        $model = new EventUser();
        $AllowUsers = array();
        $users = $model::find()->select('user_id')->where(['event_id' => intval($eventId)])->all();
        foreach ($users as $item) {
            $currEvent = User::find()->select(['username', 'id'])->where(['id' => $item['user_id']])->one();
            array_push($AllowUsers, $currEvent);
        }
        return $AllowUsers;
    }


}