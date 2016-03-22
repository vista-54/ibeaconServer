<?php
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 09.03.2016
 * Time: 16:54
 */


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
/* @var $location backend\models\Location */
/* @var $form yii\widgets\ActiveForm */
?>
<h1><?= $model->event_name ?>: Create Locations</h1>
<h4>Click right mouse button to north-east point, after then click south-west poin</h4>
<!--<h1>--><? //=?><!--</h1>-->
<div>
    <div class="location-view">
        <div id="gmaps" style="height: 500px;width: 100%"></div>
        <button name="addLoc" class="btn btn-success">Add location</button>
        <script>
            $(document).ready(function () {
                console.log("ready");
                window.localStorage.setItem('mapLink', '<?=$model->mapImgLink?>');
                window.localStorage.setItem('eventName', '<?=$model->event_name?>');
                window.localStorage.setItem('eventId', '<?=$model->id?>');
                initBtns();
                initMap();
            });

        </script>

    </div>

    <div class="formParent">

        <form class="locationForm" onsubmit="SaveLocation()">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
            <input class="form-control" name="locationId" type="hidden">
            <input class="form-control" name="eventId" type="hidden">
            <label>Location Name:<input class="form-control" name="name"></label>
            <label>North:<input class="form-control" name="north"></label>
            <label>South:<input class="form-control" name="south"></label>
            <label>East:<input class="form-control" name="east"></label>
            <label>West:<input class="form-control" name="west"></label>
            <button name="saveLoc" type="button" class="btn btn-success">Save Location</button>
        </form>
    </div>
    <div class="msgLocationSuccess" name="msg">Location succsessful added</div>
    <div class="msgLocationError" name="msg">Location adding error</div>
    <div class="locationsList">

    </div>
</div>
<!--<script async defer-->
<!--        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-A3pAC0iRrTZGPVHZV-i1XPDSISU_NEA&callback=initMap">-->
<!--</script>-->
