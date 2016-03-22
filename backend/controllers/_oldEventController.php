<?php

namespace backend\controllers;

use backend\models\Location;
use Yii;
use backend\models\Event;
use backend\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider = $searchModel->search(['']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->redirect(array('calendar/index', 'event_id' => $model->id));
    }

    public function actionAddLocations($id)
    {
//        var_dump($id);
        $model = $this->findModel($id);
        return $this->render('addLocations', [
            'model' => $this->$model,
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

//        $ih = new CImageHandler(); //�������������

//        var_dump(Yii::$app->request->post());
        //if post request we upload image
        if (Yii::$app->request->isPost) {
            $model->mapImage = UploadedFile::getInstance($model, 'mapImage');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }
        $model->mapImgLink = $model->dir;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->changeImg($model->id)){
                $model=$this->findModel($model->id);
                $model->mapImgLink=$model->mapImgLink;
                if($model->save()){
                    return $this->render('addLocations',
                        ['model' => $model, 'id' => $model->id]
                    );
                }

            }else{
                echo "Timeout Error";
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('addLocations',
                ['model' => $model, 'id' => $model->id]
            );
//            return $this->redirect(['add-Locations', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
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
//        var_dump(Yii::$app->request->post());

    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}