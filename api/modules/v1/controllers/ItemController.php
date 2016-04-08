<?php
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 30.03.2016
 * Time: 14:53
 */

namespace api\modules\v1\controllers;

use common\models\Calendar;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\helpers\Json;

class ItemController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
            'only' => [
                'get-items',
                'create',
                'delete',
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'get-items',
                'create',
                'delete',

            ],
            'rules' => [
                [
                    'actions' => ['get-items', 'create', 'delete'],
                    'allow' => true,
                    'roles' => ['admin']
                ],

            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-items' => ['GET'],
                'create' => ['POST'],
                'delete' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetItems()
    {
        $locationId = Yii::$app->request->get('locationId');
        $model = new Calendar();
        $AllowLocations = array();
        $items = $model->find()->where(['location_id' => $locationId])->all();
        foreach ($items as $item) {
            array_push($AllowLocations, $item);
        }
        return $AllowLocations;
    }

    public function actionCreate()
    {

        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model->id;
        } else {
            return false;
        }
//        $model->location_id = Yii::$app->request->post('location_id');
//        $model->date = Yii::$app->request->post('date');
//        $model->title = Yii::$app->request->post('title');
//        $model->link = Yii::$app->request->post('link');
//        $model->place_name = Yii::$app->request->post('place_name');
//        $model->place_id = Yii::$app->request->post('place_id');


    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = new Calendar();
        if ($model->find()->where(['id' => $id])->one()->delete()) {
            return true;
        } else {
            return false;
        }
    }
}