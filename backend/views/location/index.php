<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locations';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Location', ['location/create/' . $id], ['class' => 'btn btn-success']) ?>
        <!--        --><? //= Html::a('Create Location', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
//            'mapImgLink:ntext',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}{delete}{items}{beacons}', 'visible' => true,
                'buttons' => [
                    'items' => function ($url, $model, $key) {
                        $url = Yii::$app->urlManager->createUrl(['calendar/index', 'id' => $model->id]);
                        $options = array_merge([
                            'title' => Yii::t('app', 'The items of location'),
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-pushpin"></span>', $url, $options);
                    },
                    'beacons' => function ($url, $model, $key) {
                        $url = Yii::$app->urlManager->createUrl(['beacons/index', 'id' => $model->id]);
                        $options = array_merge([
                            'title' => Yii::t('app', 'The beacons of location'),
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-tree-conifer"></span>', $url, $options);
                    },


                ]
            ],
        ],
    ]); ?>

</div>
