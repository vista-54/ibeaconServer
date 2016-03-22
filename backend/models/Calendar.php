<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property integer $location_id
 * @property string $date
 * @property string $title
 * @property string $link
 * @property string $place_name
 * @property integer $place_id
 *
 * @property Location $location
 * @property Place $place
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'date', 'title', 'link', 'place_name', 'place_id'], 'required'],
            [['location_id', 'place_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'link', 'place_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'Location ID',
            'date' => 'Date',
            'title' => 'Title',
            'link' => 'Link',
            'place_name' => 'Place Name',
            'place_id' => 'Place ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }
}
