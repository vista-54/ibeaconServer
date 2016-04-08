<?php
/**
 * Created by PhpStorm.
 * User: �������
 * Date: 24.03.2016
 * Time: 15:39
 *//* @var $this yii\web\View */
/* @var $model backend\models\Beacons */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
?>
<div> <div id="mapParent">
        <div id="iBmaps" style="height: 500px;width: 50%;float:left">
            This is google maps
        </div>
    </div>

    <div class="beaconList" style="width: 50%;float:left">
    <h1>ListBeacons</h1>
        <ul>
            <li id="beacon">fist</li>
            <li>fist</li>
            <li>fist</li>
            <li>fist</li>
            <li>fist</li>
        </ul>
    </div>

    <script>
                    $(document).ready(function(){
                        editBeaconMap(<?= $location ?>);
                        AddMarkerToMap();
                        console.log("loaded");
                    })
    </script>
</div>
