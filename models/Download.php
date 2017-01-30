<?php

namespace app\models;

use Yii;
use app\helpers\MyString;

/**
 * This is the model class for table "download".
 *
 * @property integer $id
 * @property string $video_id
 * @property string $ip
 * @property string $timestamp
 *
 * @property Video $video
 */
class Download extends \yii\db\ActiveRecord
{
    public $url;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'download';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'ip', 'format', 'url'], 'required'],
            [['timestamp'], 'safe'],
            [['video_id'], 'string', 'max' => 11],
            [['ip'], 'string', 'max' => 64],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['video_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'ip' => 'Ip',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    public function downloadVideo() {
        ini_set("max_execution_time", 150);
        if ($this->video_id != null && $this->format != null) {
            $path = Yii::getAlias('@webroot') . "/tmp/";
            $session = Yii::$app->session;
            if (isset($session['downloads'][$this->format][$this->video_id]) && file_exists($path . $session['downloads'][$this->format][$this->video_id])) {
                return $session['downloads'][$this->format][$this->video_id];
            }
            $proxy = "";
            $video = Video::find()->where(['id' => $this->video_id, 'language' => LANGUAGE])->one();
            if (!$video) {
                return false;
            }

            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->save();

            if ($video->proxy) $proxy = " --proxy 188.166.44.11:9999";
            $filename = $video->id . "-" . MyString::strToURL($video->title);
            $unix = "";
            if (YII_ENV != "dev") $unix="LC_ALL=en_US.UTF-8 ";
            $err = 1;
            if ($this->format == "mp4") {
                //echo "{$unix}youtube-dl{$proxy} -f \"bestvideo[ext=mp4][height <= 720]+bestaudio[ext=m4a]/best[ext=mp4][height <= 720]/best[height <= 720]/best\" -o \"" . $path . "{$filename}.%(ext)s\" \"https://www.youtube.com/watch?v={$video->id}\"";
                exec("{$unix}youtube-dl{$proxy} -f \"bestvideo[ext=mp4][height <= 720]+bestaudio[ext=m4a]/best[ext=mp4][height <= 720]/best[height <= 720]/best\" -o \"" . $path . "{$filename}.%(ext)s\" \"https://www.youtube.com/watch?v={$video->id}\"", $out, $err);
            }
            elseif ($this->format == "mp3") {
                //echo "{$unix}youtube-dl{$proxy} -f bestaudio -x --audio-format mp3 -o \"" . Yii::getAlias('@webroot') . "/tmp/{$filename}.%(ext)s\" \"https://www.youtube.com/watch?v={$video->id}\"";
                exec("{$unix}youtube-dl{$proxy} -f bestaudio -x --audio-format mp3 -o \"" . $path . "{$filename}.%(ext)s\" \"https://www.youtube.com/watch?v={$video->id}\"", $out, $err);
            }
            if ($err == 0 && file_exists($path.$filename.".".$this->format)) {
                $_SESSION['downloads'][$this->format][$this->video_id] = $filename.".".$this->format;
                return $_SESSION['downloads'][$this->format][$this->video_id];
            }
            elseif ($err == 0 && file_exists($path.$filename.".mkv")) {
                $_SESSION['downloads'][$this->format][$this->video_id] = $filename.".mkv";
                return $_SESSION['downloads'][$this->format][$this->video_id];
            }
        }
        return false;
    } 
}
