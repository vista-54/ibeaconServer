<?php
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 30.03.2016
 * Time: 14:00
 */

namespace api\modules\v1\controllers;

use Yii;
use common\models\Place;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class PlacesController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
            'only' => [
                'get-places',
                'create-place',
                'delete',
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'get-places',
                'create-place',
                'delete',

            ],
            'rules' => [
                [
                    'actions' => ['get-places','create-place','delete'],
                    'allow' => true,
                    'roles' => ['admin']
                ],

            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-places' => ['GET'],
                'create-place' => ['POST'],
                'delete' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetPlaces()
    {

        $locationId = Yii::$app->request->get('locationId');
        $model = new Place();
        $places = $model->find()->where(['location' => $locationId])->all();
        $AllowPlaces = array();
        foreach ($places as $item) {
            array_push($AllowPlaces, $item);
        }
        return Json::encode($AllowPlaces);
    }

    public function actionCreatePlace()
    {
        $locationId = Yii::$app->request->post('locationId');

        $model = new Place();

        $model->location = $locationId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model->id;
        } else {
            return false;
        }
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = new Place();
        if ($model->find()->where(['id' => $id])->one()->delete()) {
            return true;
        } else {
            return false;
        }
    }

    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}