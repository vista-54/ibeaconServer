<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Beacons */

$this->title = 'Create Beacons';
$this->params['breadcrumbs'][] = ['label' => 'Beacons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'location'=>$location,
        'eventId'=>$eventId
    ]) ?>

</div>
