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


    public function actionIndex($v = null, $format = null, $setlang = null)
    {
        $download = new Download();
        $video = new Video();
        $error = "";
        $more = [];
        $filename = null;

        if ($setlang != null)
        {
            return $this->redirect("/" . ($v == null ? '' : 'v/' . $v . '/') . ($format == null ? '' : '?format=' . $format),301);
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
            return $this->redirect('/v/' . $id . '/?format=' . $_POST['Download']['format'],302);
        }
        if ($v != null) {
            if (substr($_SERVER['REQUEST_URI'], 0, 3) != "/v/") {
                return $this->redirect( "/v/{$v}/?format=" . $format);
            }
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
        return $this->render('index', ['download' => $download, 'video' => $video, 'error' => $error, 'more' => $more, 'filename' => $filename]);
    }

    public function actionSitemap()
    {
        $videos = Video::find()->select('video.*, COUNT(*) AS `download_count`')->from('`video` LEFT JOIN `download` ON `video`.`id` = `video_id`')->where(['language' => LANGUAGE])->groupBy('`video`.`id`')->orderBy('`download_count` DESC')->all();
        return $this->render('sitemap', ['videos' => $videos]);
    }

    public function actionStahovanieZYoutube()
    {
        return $this->render('stahovanieZYoutube');
    }

    public function actionStahovaniZYoutube()
    {
        return $this->render('stahovaniZYoutube');
    }

    public function actionDownloadVideoFromYoutube()
    {
        return $this->render('downloadVideoFromYoutube');
    }
}
