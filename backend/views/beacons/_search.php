<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BeaconsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beacons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'uuid') ?>

    <?= $form->field($model, 'major') ?>

    <?= $form->field($model, 'minor') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'msgForEnter') ?>

    <?php // echo $form->field($model, 'msgForExit') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'eventId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
