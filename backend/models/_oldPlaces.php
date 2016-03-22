<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "places".
 *
 * @property integer $id
 * @property integer $event_id
 * @property string $name
 * @property string $crd_north
 * @property string $crd_south
 * @property string $crd_east
 * @property string $crd_west
 *
 * @property Events $event
 * @property Markers[] $markers
 */

class Places extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'places';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'name', 'crd_north', 'crd_south', 'crd_east', 'crd_west'], 'required'],
            [['event_id'], 'integer'],
            [['name', 'crd_north', 'crd_south', 'crd_east', 'crd_west'], 'string', 'max' => 25]
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
            'name' => 'Name',
            'crd_north' => 'Crd North',
            'crd_south' => 'Crd South',
            'crd_east' => 'Crd East',
            'crd_west' => 'Crd West',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers()
    {
        return $this->hasMany(Markers::className(), ['id_location' => 'id']);
    }
}
