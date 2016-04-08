<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacons".
 *
 * @property integer $id
 * @property integer $location
 * @property string $uuid
 * @property string $major
 * @property string $minor
 * @property string $lat
 * @property string $lng
 * @property string $msgForEnter
 * @property string $msgForExit
 * @property string $data
 * @property integer $eventId
 *
 * @property Event $event
 * @property Location $location0
 * @property Location $location1
 */
class Beacons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location', 'uuid', 'major', 'minor', 'msgForEnter', 'msgForExit', 'data', 'eventId'], 'required'],
            [['location', 'eventId'], 'integer'],
            [['msgForEnter', 'msgForExit', 'data'], 'string'],
            [['uuid'], 'string', 'max' => 50],
            [['major', 'minor', 'lat', 'lng'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location' => 'Location',
            'uuid' => 'Uuid',
            'major' => 'Major',
            'minor' => 'Minor',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'msgForEnter' => 'Msg For Enter',
            'msgForExit' => 'Msg For Exit',
            'data' => 'Data',
            'eventId' => 'Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'eventId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation0()
    {
        return $this->hasOne(Location::className(), ['id' => 'location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation1()
    {
        return $this->hasOne(Location::className(), ['id' => 'location']);
    }
}
