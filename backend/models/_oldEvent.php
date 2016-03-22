<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property string $event_name
 * @property string $mapImgLink
 *
 * @property Locations[] $places
 */
class Event extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $mapImage;
    public $dir;
    public $currEvent;
    public $tmpName;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_name'], 'required'],
            [['event_name'], 'string', 'max' => 50],
            [['mapImage'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_name' => 'Event Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Locations::className(), ['event_id' => 'id']);
    }

    public function upload()
    {
        $path = Yii::getAlias('@backend/web/');
        $folder = 'maps';
        $fileName = $this->mapImage->baseName . '.' . $this->mapImage->extension;
        $this->tmpName = $fileName;
        $this->dir = Yii::$app->urlManager->createAbsoluteUrl([
            $folder . "/$fileName"
        ]);
        $this->mapImage->saveAs($path . $folder . "/$fileName");
    }

    public function changeImg($eventId)
    {
        $path = Yii::getAlias('@backend/web/');
        $folder = 'maps';
        $dir = $path . $folder . "/$this->tmpName";
        $counter = 1;
        for ($z = 0; $z < 4; $z++) {
            if ($z === 0) {
                $counter = 1;
            } else {
                $counter = $counter * 2;
            }
            for ($i = 0; $i < $counter; $i++) {
                for ($j = 0; $j < $counter; $j++) {
                    $dirTmp = $path . $folder . "/$eventId" . "/$z" . "/$i";
                    $image = Yii::$app->image->load($dir);
                    $image->resize(256 * $counter, 256 * $counter);
                    BaseFileHelper::createDirectory($dirTmp, 509, true);
                    $image->crop(256, 256, $i * 256, $j * 256);
                    $b = $counter - $j - 1;
                    $image->save($dirTmp . "/$b" . ".jpg");
                }

            }
        }
        $this->currEvent = $path . $folder . "/$eventId";
        return true;
    }
}
