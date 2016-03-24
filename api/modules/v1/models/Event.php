<?php

/**
 * Created by PhpStorm.
 * User: Виталий
 * Date: 24.03.2016
 * Time: 14:26
 */
namespace api\modules\v1\models;
use yii\db\ActiveRecord;

class Event extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }
    public function rules()
    {
        return [
            [['name', 'author'], 'required'],
            [['name', 'author'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['author'], 'unique']
        ];
    }


}