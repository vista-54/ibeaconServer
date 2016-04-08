<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BeaconsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beacons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacons-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Beacons', ['beacons/create/'.$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'location',
            'uuid',
            'major',
            'minor',
            // 'lat',
            // 'lng',
            // 'msgForEnter:ntext',
            // 'msgForExit:ntext',
            // 'data:ntext',
            // 'eventId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
