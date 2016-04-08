<?php
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 30.03.2016
 * Time: 15:54
 */

namespace api\modules\v1\controllers;

use Yii;
use common\models\Beacons;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class BeaconController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
            'only' => [
                'get-beacons',
//                'create',
//                'delete',
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'get-beacons',
                'create',
                'delete',

            ],
            'rules' => [
                [
                    'actions' => ['get-beacons'],
                    'allow' => true,
                    'roles' => ['admin']
                ],

            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-beacons' => ['GET'],
//                'create' => ['POST'],
//                'delete' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetBeacons()
    {
        $locationId = Yii::$app->request->get('locationId');
        $model = new Beacons();
        $AllowLocations = array();
        $items = $model->find()->where(['location' => $locationId])->all();
        foreach ($items as $item) {
            array_push($AllowLocations, $item);
        }
        return $AllowLocations;

    }

    public function actionCreate()
    {
        $model = new Beacons();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model->id;
        } else {
            return false;
        }
    }
    public function actionDelete(){
        $id = Yii::$app->request->post('id');
        $model = new Beacons();
        if ($model->find()->where(['id' => $id])->one()->delete()) {
            return true;
        } else {
            return false;
        }
    }
}