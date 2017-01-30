<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\helpers\MyString;
use app\models\Video;
use app\models\Download;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
     * Vypnutie CSRF validacie pre konkretne akcie
     */
    public function beforeAction($action)
    {            
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }


    public function actionIndex($v = null, $format = null)
    {
        $download = new Download();
        $video = new Video();
        $error = "";
        $more = [];
        $filename = null;
        
        if ($v != null) {
            $data = Video::find()->where(['id' => $v, 'language' => LANGUAGE])->one();
            $download->url = "https://www.youtube.com/watch?v=".$v;
            if ($data == NULL) {
                $data = $video->loadInfo($v);
            }
            if ($data) {
                $video = $data;
            }
            else {
                return $this->redirect('/',302);                
            }
            if (isset($format) && in_array($format, ['mp3', 'mp4'])) {
                $download->format = $format;
                $session = Yii::$app->session;
                if (isset($session['downloads'][$format][$v])) {
                    $download->video_id = $v;
                    $filename = $download->downloadVideo();
                }
            }
        }
        if (isset($_POST['Download']['url'], $_POST['Download']['format']) && in_array($_POST['Download']['format'], ['mp3', 'mp4'])) {
            $id = explode("youtube.com/watch?v=", $_POST['Download']['url']);
            if (count($id) == 2) {
                $id = substr($id[1], 0, 11);
            }
            else {
                $id = explode("youtu.be/", $id[0]);
                if (count($id) == 2) {
                    $id = substr($id[1], 0, 11);
                }
                else {
                    return $this->redirect('/',302);
                }
            }

            $data = Video::find()->where(['id' => $id, 'language' => LANGUAGE])->one();
            if ($data == NULL) {
                $video = new Video();
                $data = $video->loadInfo($id);
            }

            $download->format = $_POST['Download']['format'];
            $download->video_id = $id;
            $download_link = $download->downloadVideo();
            return $this->redirect('/?v=' . $id . '&format=' . $_POST['Download']['format'],302);
        }
        return $this->render('index', ['download' => $download, 'video' => $video, 'error' => $error, 'more' => $more, 'filename' => $filename]);
    }
}
