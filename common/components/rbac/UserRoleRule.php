<?php
namespace common\components\rbac;
/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 25.03.2016
 * Time: 15:51
 */
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;
class UserRoleRule extends  Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'superAdmin') {
                return $role == User::ROLE_SUPERADMIN;
            } elseif ($item->name === 'admin') {
                //moder является потомком admin, который получает его права
                return $role == User::ROLE_SUPERADMIN || $role == User::ROLE_ADMIN;
            }
//            elseif ($item->name === 'user') {
//                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER
//                || $role == User::ROLE_USER;
//            }
        }
        return false;
    }
}