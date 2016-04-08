<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <? if (Yii::$app->user->identity->role == User::ROLE_SUPERADMIN) {
            echo Html::a('Create Event', ['create'], ['class' => 'btn btn-success']);
        } ?>
        <!--        --><? //= Html::button('Create Event', ['value' => Url::to('../event-user/create'), 'class' => 'btn btn-success']) ?>
    </p>

    <?
    Modal::begin([
        'header' => '<h4>Header</h4>',
        'id' => 'modal',
        'size' => 'modal-lg'
    ]);
    echo "<div id='modalContent'>test</div>";

    Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn', 'template' => Yii::$app->user->identity->role == User::ROLE_SUPERADMIN ? '{view}{update}{delete}{locations}{users}' : '{view}{locations}{users}', 'visible' => true,
                'buttons' => [
                    'locations' => function ($url, $model, $key) {
                        $url = Yii::$app->urlManager->createUrl(['location/index', 'id' => $model->id]);
                        $options = array_merge([
                            'title' => Yii::t('app', 'The locations of this event'),
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-globe"></span>', $url, $options);
                    },
                    'users' => function ($url, $model, $key) {
//                        $url = Yii::$app->urlManager->createUrl(['event-user/create', 'id' => $model->id]);
                        $options = array_merge([
                            'title' => Yii::t('app', 'The locations of this event'),
                            'id' => 'modalButton',
                            'data-link' => Url::to('../event-user/create')
                        ]);
                        if (Yii::$app->user->identity->role == User::ROLE_ADMIN) {
                            return Html::button('Add user', ['value' => Url::to('../../event-user/create?id=' . $model->id), 'class' => ' modalButton glyphicon glyphicon-user']);

                        }
                        return Html::button('Add user', ['value' => Url::to('../event-user/create?id=' . $model->id), 'class' => ' modalButton glyphicon glyphicon-user']);

                        //                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>
    <script>
        $(function () {
            modalLoad();
        });
    </script>
</div>
