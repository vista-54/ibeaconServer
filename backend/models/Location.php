<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property integer $event
 * @property string $name
 *
 * @property Event $event0
 */
class Location extends \yii\db\ActiveRecord
{
    public $mapImage;
    public $dir;
    public $currEvent;
    public $tmpName;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'name'], 'required'],
            [['event'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent0()
    {
        return $this->hasOne(Event::className(), ['id' => 'event']);
    }

    public function upload()
    {
        $path = Yii::getAlias('@backend/web/');
        $folder = 'maps';
        $fileName = $this->mapImage->baseName . '.' . $this->mapImage->extension;
        $this->tmpName = $fileName;
//        $this->dir = Yii::$app->urlManager->createAbsoluteUrl([
//            $folder . "/$fileName"
//        ]);
        $this->mapImage->saveAs($path . $folder . "/$fileName");
    }

    public function changeImg($eventId)
    {
        $path = Yii::getAlias('@backend/web/');
        $folder = 'maps';
        $templates = '/templates/';
        $dir = $path . $folder . "/$this->tmpName";
        $counter = 1;
        for ($z = 0; $z < 2; $z++) {
            if ($z === 0) {
                $counter = 1;
            } else {
                $counter = $counter * 2;
            }
            $newZoom = $z + 4;
            for ($i = 0; $i < $counter; $i++) {
                for ($j = 0; $j < $counter; $j++) {
                    $dirTmp = $path . $folder . "/$eventId" . "/$newZoom";
                    $image = Yii::$app->image->load($dir);
                    $image->resize(256 * $counter, 256 * $counter);
                    BaseFileHelper::createDirectory($dirTmp, 509, true);
                    $src = $path . $folder . $templates . ($z + 4);
                    BaseFileHelper::copyDirectory($src, $dirTmp);
                    $image->crop(256, 256, $i * 256, $j * 256);
//                    $b = $counter - $j - 1;
//                    $b = $newZoom *2;

                    //m8 I could create better, but my brain didn't support me
                    if($z===0){
//                        BaseFileHelper::createDirectory($dirTmp, 509, true);
//                        BaseFileHelper::findFiles()
                        $image->save($dirTmp . "/8". "/8" . ".jpg");
                    }else if($z===1){
                        $k=16+$i;
                        $m=17-$j;
                        $image->save($dirTmp . "/$k". "/$m" . ".jpg");
                    }

                }

            }
        }
//        $this->currEvent=Yii::$app->urlManager->createAbsoluteUrl([
//            $path . $folder . "/$eventId"
//        ]);
        return true;
    }
}
