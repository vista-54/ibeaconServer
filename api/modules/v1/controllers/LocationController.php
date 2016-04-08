<?php
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 29.03.2016
 * Time: 18:10
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\base\Controller;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use common\models\Location;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

class LocationController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'auth_key',
            'only' => [
                'get-locations',
                'create-location',
                'delete',
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'get-locations',
                'create-location',
                'delete',

            ],
            'rules' => [
                [
                    'actions' => ['get-locations', 'create-location', 'delete'],
                    'allow' => true,
                    'roles' => ['admin']
                ],

            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-locations' => ['GET'],
                'create-location' => ['GET'],
                'delete' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetLocations()
    {
        $eventId = Yii::$app->request->get('eventId');
        $model = new Location();
        $AllowLocations = array();
        $locations = $model->find()->select(['id', 'name'])->where(["event" => $eventId])->all();
//        return
        foreach ($locations as $item) {

            array_push($AllowLocations, $item);
        }
        return Json::encode($AllowLocations);
    }

    public function actionCreateLocation()
    {
        $id = Yii::$app->request->post('eventId');
        $model = new Location();
        if (Yii::$app->request->isPost) {
            $model->mapImage = UploadedFile::getInstance($model, 'mapImage');
            if ($model->upload()) {
                $model->event = $id;
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    if ($model->changeImg($model->id)) {
                        return $model->id;
                    } else {
                        echo "Timeout Error";
                    }

                } else {
                    return false;
                }
            }
        }


    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = new Location();
        if ($model->find()->where(['id' => $id])->one()->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /* не доработанна
        public function actionUpdate()
        {
            $eventId = Yii::$app->request->post('eventId');
            $id = Yii::$app->request->post('id');
            $model = $this->findModel($id);
            if (Yii::$app->request->isPost) {
                $model->mapImage = UploadedFile::getInstance($model, 'mapImage');
                if ($model->upload()) {
                    $model->event = $id;
                    if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        if ($model->changeImg($model->id)) {
                            return $model->id;
                        } else {
                            echo "Timeout Error";
                        }

                    } else {
                        return false;
                    }
                }
            }
        }
    */
    protected function findModel($id)
    {
        if (($model = Location::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}