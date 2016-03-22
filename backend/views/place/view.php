<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Place */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Place', ['create', 'id' => $model->location], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'location',
            'name:ntext',
            'crd_north',
            'crd_south',
            'crd_east',
            'crd_west',
        ],
    ]) ?>

</div>
