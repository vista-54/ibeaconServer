<?php

namespace backend\controllers;

use Yii;
use common\models\Calendar;
use common\models\CalendarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id
        ]);
    }

    public function actionGetItems()
    {
//        var_dump(Yii::$app->request->post());
        $date = Yii::$app->request->post()['date'];
//        var_dump($date);
        $result = Calendar::find()
//            ->where(['date' => '2016-03-15 00:00:00'])
            ->orderBy('date DESC')
            ->andFilterWhere(['like', 'date', $date])
            ->all();

//        echo $date;
        return Json::encode($result);
//       return $date;
    }

    /**
     * Displays a single Calendar model.
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
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id=Yii::$app->request->post('id');
//        var_dump(Yii::$app->request->post());
        if($id!==''){
            $model = $this->findModel($id);
        }
        else{
            $model = new Calendar();
        }

        $model->location_id=Yii::$app->request->post('location_id');
        $model->date=Yii::$app->request->post('date');
        $model->title=Yii::$app->request->post('title');
        $model->link=Yii::$app->request->post('link');
        $model->place_name=Yii::$app->request->post('place_name');
        $model->place_id=Yii::$app->request->post('place_id');

        if ($model->save()) {
            return true;
        } else {
            return false;
        }

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing Calendar model.
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
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionGetInfoAboutItem()
    {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        return Json::encode($model);
    }
    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
