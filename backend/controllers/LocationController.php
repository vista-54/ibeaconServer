<?php

namespace backend\controllers;

use backend\models\Event;
use Yii;
use common\models\Location;
use common\models\LocationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LocationController implements the CRUD actions for Location model.
 */
class LocationController extends Controller
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
     * Lists all Location models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search($id);
//        $dataProvider = $searchModel->search(['event'=>$id]);
//        $v = Event::find()->where(['id' => $id]);
//        $location=Location::find()->where(['event' => $id]);
//        var_dump($location);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id
        ]);
    }

    /**
     * Displays a single Location model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
        return $this->redirect(array('place/index/'.$id));
    }

    /**
     * Creates a new Location model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {

        $model = new Location();
        if (Yii::$app->request->isPost) {
            $model->mapImage = UploadedFile::getInstance($model, 'mapImage');
            if ($model->upload()) {
                return;
            }
        }
        $model->event = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->changeImg($model->id)) {
//                return $this->redirect(array('place/create', 'id' => $model->id));
                return $this->render('view', [
                    'model' => $model,
                ]);
            } else {
                echo "Timeout Error";
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Location model.
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
     * Deletes an existing Location model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPlace($id)
    {
        return $this->redirect(array('place/create', 'id' => $id));
    }

    /**
     * Finds the Location model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Location the loaded model
     * @throws NotFoundHttpException if the model cannot be found
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
