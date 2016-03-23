<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Place */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="place-form">
    <input name="locationId" value="<?= $model->location ?>" hidden>

    <div id="gmaps" style="height: 500px;width: 100%">
        This is google maps
    </div>
    <button name="addPlace" class="btn btn-success">Add Place</button>
    <script>
        $(document).ready(function () {
            console.log("ready");
//            window.localStorage.setItem('mapLink', '<?//=$model->mapImgLink?>//');
            window.localStorage.setItem('eventName', '<?=$model->name?>');
            window.localStorage.setItem('eventId', '<?=$model->id?>');
//            window.localStorage.setItem('locationId', '<?//=$model->location?>//');
            initBtns();
            initMap();
        });

    </script>

    <?php $form = ActiveForm::begin([

        'options' => [
            'class' => 'placeForm'
        ]
    ]); ?>

<!--    --><?//= $form->field($model, 'location')->textInput() ?>
    <?= $form->field($model, 'id')->textInput()->hiddenInput()->label(false) ?>
    <!--    --><? //= $form->field($model, 'location')->textInput() ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'crd_north')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'crd_south')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'crd_east')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'crd_west')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
