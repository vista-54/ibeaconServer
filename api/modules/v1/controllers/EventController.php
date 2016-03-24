<?php
namespace api\modules\v1\controllers;

/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 24.03.2016
 * Time: 14:28
 */
use api\modules\v1\models\Event;
use yii\rest\ActiveController;
use yii\helpers\Json;

class EventController extends ActiveController
{
    public function actionIndex()
    {
        $model = new Event();
        return 'hello api';
    }
}