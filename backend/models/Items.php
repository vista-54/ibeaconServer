<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $id_location
 * @property string $title
 * @property string $date
 * @property string $link
 *
 * @property Locations $idLocation
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_location', 'title', 'date', 'link'], 'required'],
            [['id_location'], 'integer'],
            [['title', 'date'], 'safe'],
            [['link'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_location' => 'Id Location',
            'title' => 'Title',
            'date' => 'Date',
            'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'id_location']);
    }
}
