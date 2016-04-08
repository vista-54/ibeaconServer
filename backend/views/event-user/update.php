<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventUser */

$this->title = 'Update Event User: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Event Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
