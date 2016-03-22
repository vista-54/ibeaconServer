<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\cldwdg\CalendarView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Calendar */
/*
$this->title = 'Calendars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Calendar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'val',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
*/
//var_dump($id)?>
<input name="locationId" hidden value="<?=$id?>">

<?
echo CalendarView::widget(
    [
        // mandatory
        'dataProvider'  => $dataProvider,
        'dateField'     => 'date',
        'valueField'    => 'title',


        // optional params with their defaults
        'weekStart' => 1, // date('w') // which day to display first in the calendar
        'title'     => 'Items List ',

        'views'     => [
            'calendar' => '@common/components/cldwdg/views/calendar',
            'month' => '@common/components/cldwdg/views/month',
            'day' => '@common/components/cldwdg/views/day',
        ],

        'startYear' => date('Y') - 1,
        'endYear' => date('Y') + 1,

        'link' => false,
        /* alternates to link , is called on every models valueField, used in Html::a( valueField , link )
        'link' => 'site/view',
        'link' => function($model,$calendar){
            return ['calendar/view','id'=>$model->id];
        },
        */

        'dayRender' => false,
        /* alternate to dayRender
        'dayRender' => function($model,$calendar) {
            return '<p>'.$model->id.'</p>';
        },
        */

    ]
);
?>
<div class="ModalView">

</div>
