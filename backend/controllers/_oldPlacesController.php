<?php

namespace backend\controllers;

use Yii;
use backend\models\Places;
use backend\models\Event;
use backend\models\PlacesSearch;
//use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlacesController implements the CRUD actions for Places model.
 */
class PlacesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
//                    's-location' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * Lists all Places models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlacesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Places model.
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
     * Creates a new Places model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Places();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Places model.
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
     * Deletes an existing Places model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSaveLocation()
    {

        $id=Yii::$app->request->post()['id'];
//        var_dump(is_nan($id));
        if($id==='NaN'){
        $model = new Places();
        }
        else{
            $model = $this->findModel($id);
        }
//  var_dump(Yii::$app->request->post());
//        $data=Yii::$app->request->post();
//        $model->event_id=$data['eventId'];
//        $model->lat=$data['eventId'];
//        $model->lng=$data['lng'];
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $model->id;
        } else {
            return false;
        }

    }
    public function actionGetPlaces(){
        $id = Yii::$app->request->post()['eventId'];
        $map=Event::find()
            ->select(['mapImgLink'])
            ->where(['id'=>$id])
            ->all();
        $result = Places::find()
            ->where(['event_id' => $id])
            ->all();

        return Json::encode(array('map'=>$map[0],'Places'=>$result));
    }

    public function actionSLocation()
    {
//        return "hello world";
        $id = Yii::$app->request->post()['id'];

        if (($model = Places::findOne($id)) !== null) {
//            $res=array("id"=>$model->id,"event_id"=>$model->event_id);
//            return $model;
//            return ArrayHelper::toArray($model);
            return Json::encode($model);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Places model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Places the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Places::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
