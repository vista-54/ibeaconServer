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
 * @property string $location_name
 * @property integer $event_id
 *
 * @property Events $event
 * @property Locations $location
 */
class Calendar extends \yii\db\ActiveRecord
{
    public  $eventId;
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
            [['location_id', 'date', 'title', 'link', 'location_name', 'event_id'], 'required'],
            [['location_id', 'event_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'link', 'location_name'], 'string']
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
            'location_name' => 'Location Name',
            'event_id' => 'Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location_id']);
    }
}
