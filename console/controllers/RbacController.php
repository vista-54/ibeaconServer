<?php

/**
 * Created by PhpStorm.
 * User: �������
 * Date: 25.03.2016
 * Time: 16:21
 */
namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //������� ������ ������
        //�������� ��� ������� ����� ��� ������� � �������
        $event = $auth->createPermission('event');
        $event->description = 'EVENT';
        $auth->add($event);
        //�������� ��� ����������
        $rule = new UserRoleRule();
        $auth->add($rule);
        //��������� ����
        $superAdmin = $auth->createRole('superAdmin');
        $superAdmin->description = 'super admin';
        $superAdmin->ruleName = $rule->name;
        $auth->add($superAdmin);

        $eventAdmin = $auth->createRole('admin');
        $eventAdmin->description = 'AdminEvent';
        $eventAdmin->ruleName = $rule->name;
        $auth->add($eventAdmin);
        //��������� ��������
        $auth->addChild($superAdmin, $eventAdmin);

//        $auth->addChild($moder, $dashboard);
//        $admin = $auth->createRole('admin');
//        $admin->description = '�������������';
//        $admin->ruleName = $rule->name;
//        $auth->add($admin);
//        $auth->addChild($admin, $moder);
    }
}