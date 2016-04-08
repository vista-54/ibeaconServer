<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use common\models\User;
use common\models\SignupForm;
use yii\web\Response;

/**
 * Class userController    * @package api\modules\v1\controllers
 */
class SiteController extends Controller
{

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(['SignupForm' => Yii::$app->request->post()]) && $model->validate()) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return ['model' => true];
                }
            }
            return ['model' => false];
        }
        return ['model' => $model->getErrors()];
    }

    public function actionLogin()
    {
//        var_dump(Yii::$app->request->post());
        Yii::$app->response->format = Response::FORMAT_JSON;
        $login = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');

        /**
         * @var User $model
         */
        $model = User::findByUsername(Yii::$app->request->post('login'));

        if (!$model) {
            return [
                'status' => 'error',
                'error' => array('login' => 'User with login ' . $login . ' is not registered.')
            ];
        } elseif (!$model->validatePassword($password)) {
            return [
                'status' => 'error',
                'error' => array('password' => 'Password incorrect.')
            ];
        } else {
            return [
                'userId' => $model->getId(),
                'username' => $login,
                'status' => 'success',
                'token' => $model->getAuthKey()
            ];
        }
    }

    public function actionIndex()
    {
        return 'Index!';
    }
}
