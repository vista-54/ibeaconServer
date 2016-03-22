<?php

namespace backend\controllers;

use backend\models\Location;
use Yii;
use backend\models\Place;
use backend\models\PlaceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PlaceController implements the CRUD actions for Place model.
 */
class PlaceController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new PlaceSearch();
        $dataProvider = $searchModel->search($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id
        ]);
    }

    /**
     * Displays a single Place model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Place model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {

//    var_dump($id);
//        $id=Yii::$app->request->post('id');
////            var_dump($id);
//        if ($id !== '') {
//            $model = $this->findModel($id);
//
//        } else {
            $model = new Place();

//        }
        $model->location = $id;
//        var_dump($id !== '');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Place model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Place model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetLocation()
    {
//        return "hello world";
        $id = Yii::$app->request->post()['id'];
//        var_dump($id);
//        if (($model = Place::findOne($id)) !== null) {
        $model = Place::findAll(['location' => $id]);
        if ($model !== null) {
//            $res=array("id"=>$model->id,"event_id"=>$model->event_id);
//            return $model;
//            return ArrayHelper::toArray($model);
            return Json::encode($model);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetPlaces(){
//        var_dump(Yii::$app->request->post());
        $id = Yii::$app->request->post()['locationId'];
//        $map=Location::find()
//            ->select(['id'])
//            ->where(['id'=>$id])
//            ->all();
//        var_dump($id);
        $result = Place::find()
            ->where(['location' => $id])
            ->all();
//
        return Json::encode(array('map'=>'','Places'=>$result));
    }

    /**
     * Finds the Place model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Place the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
