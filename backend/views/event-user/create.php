<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EventUser */

$this->title = 'Create Event User';
$this->params['breadcrumbs'][] = ['label' => 'Event Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id'=>$id
    ]) ?>

</div>
