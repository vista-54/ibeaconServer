<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Class userController    * @package api\modules\v1\controllers
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return 'Index!';
    }
}
