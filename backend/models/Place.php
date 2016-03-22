<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "place".
 *
 * @property integer $id
 * @property integer $location
 * @property string $name
 * @property string $crd_north
 * @property string $crd_south
 * @property string $crd_east
 * @property string $crd_west
 *
 * @property Location $location0
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'crd_north', 'crd_south', 'crd_east', 'crd_west'], 'required'],
//            [['location'], 'integer'],
            [['name'], 'string'],
            [['crd_north', 'crd_south', 'crd_east', 'crd_west'], 'string', 'max' => 25]
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
    public function getLocation0()
    {
        return $this->hasOne(Location::className(), ['id' => 'location']);
    }
}
