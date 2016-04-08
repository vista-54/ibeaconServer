<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "eventUser".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $user_id
 * @property string $username
 * @property string $userpass
 * @property string $usermail
 */
class EventUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eventUser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'username', 'userpass', 'usermail'], 'required'],
            [['event_id', 'user_id'], 'integer'],
            [['usermail'], 'string'],
            [['username', 'userpass'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'userpass' => 'Userpass',
            'usermail' => 'Usermail',
        ];
    }
}
