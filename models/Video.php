<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property string $id
 * @property string $title
 * @property integer $duration
 * @property string $language
 * @property integer $ban
 * @property integer $dmca
 * @property integer $proxy
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Download[] $downloads
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'duration', 'language'], 'required'],
            [['duration', 'ban', 'dmca', 'proxy'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 11],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'duration' => 'Duration',
            'language' => 'Language',
            'ban' => 'Ban',
            'dmca' => 'Dmca',
            'proxy' => 'Proxy',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDownloads()
    {
        return $this->hasMany(Download::className(), ['video_id' => 'id']);
    }

    public function loadInfo($id)
    {
        $exec_prefix = "LC_ALL=en_US.UTF-8 ";
        $exec_prefix = "";
        exec($exec_prefix . "youtube-dl -j \"https://www.youtube.com/watch?v={$id}\"", $out, $err);
        $this->proxy = 0;
        if (count($out) == 0) {
            $proxy = " --proxy 188.166.44.11:9999";
            exec($exec_prefix . "youtube-dl{$proxy} -j \"https://www.youtube.com/watch?v={$id}\"", $out, $err);
            $this->proxy = 1;
        }
        if (count($out) > 0) {

            $data = json_decode($out[0], true);
            if (isset($data['fulltitle'])) {
                $this->id = $data['id'];
                $this->title = $data['fulltitle'];   
                $this->duration = $data['duration'];   
                $this->ban = 0;
                $this->dmca = 0;
                $this->language = LANGUAGE;
                if (isset($_POST['language']) && in_array($_POST['language'], ['cz', 'sk', 'en'])) {
                    $this->language = $_POST['language'];
                }
                $this->save();
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}
