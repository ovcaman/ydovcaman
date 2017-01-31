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
        $lang = LANGUAGE;
        if (isset($_POST['language']))
        {
            $lang = $_POST['language'];
        }

        if ($setlang != null)
        {
            return $this->redirect("/" . ($v == null ? '' : 'v/' . $v . '/') . ($format == null ? '' : '?format=' . $format),301);
        }
        
        
        if ($v != null) {
            if (substr($_SERVER['REQUEST_URI'], 0, 3) != "/v/") {
                return $this->redirect( "/v/{$v}/?format=" . $format);
            }
            $data = Video::find()->where(['id' => $v, 'language' => $lang])->one();
            $download->url = "https://www.youtube.com/watch?v=".$v;
            if (!$data) {
                $data = $video->loadInfo($v);
            }
            if ($data) {
                $video = $data;
            }
            else {
                return $this->redirect('/', 302);                
            }
            if ($video->ban == 1)
            {
                return $this->redirect( "/", 302);
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

            $data = Video::find()->where(['id' => $id, 'language' => $lang])->one();
            if (!$data) {
                $video = new Video();
                $data = $video->loadInfo($id);
            }
            if ($data) {
                $video = $data;
            }

            $download->format = $_POST['Download']['format'];
            $download->video_id = $id;
            $download_link = $download->downloadVideo();
            return $this->redirect('/v/' . $id . '/?format=' . $_POST['Download']['format'],302);
        }
        return $this->render('index', ['download' => $download, 'video' => $video, 'error' => $error, 'more' => $more, 'filename' => $filename]);
    }

    public function actionSitemap()
    {
        $videos = [];
        if (!IS_FINAL_DOMAIN) {
            $videos = Video::find()->select('video.*, COUNT(*) AS `download_count`')->from('`video` LEFT JOIN `download` ON `video`.`id` = `video_id`')->where(['language' => LANGUAGE, 'ban' => 0, 'dmca' => 0])->groupBy('`video`.`id`')->orderBy('`download_count` DESC')->limit(15000)->all();
        }
        return $this->render('sitemap', ['videos' => $videos]);
    }

    public function actionSitemapXml($page = null)
    {   
        Yii::$app->response->headers->add('Content-Type', 'text/xml; charset=utf-8');
        header('Content-Type: text/xml; charset=utf-8');
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $per_page = 10000;
        $offset = 0;
        $pages = 1;
        $videos = [];
        if ($page != null && !IS_FINAL_DOMAIN) {
            $videos = Video::find()->select('video.*, COUNT(*) AS `download_count`')->from('`video` LEFT JOIN `download` ON `video`.`id` = `video_id`')->where(['language' => LANGUAGE, 'ban' => 0, 'dmca' => 0])->groupBy('`video`.`id`')->orderBy('`download_count` DESC')->limit($per_page)->offset(($page - 1) * $per_page)->all();
        }
        if (!IS_FINAL_DOMAIN) {
            $total = Video::find()->where(['language' => LANGUAGE, 'ban' => 0, 'dmca' => 0])->count();
            $pages = ceil($total / $per_page);
        }
        echo trim($this->renderPartial('sitemapXml', ['videos' => $videos, 'pages' => $pages, 'page' => $page]));
        return "";
    }

    public function actionRobotsTxt() {
        $txt = "User-agent: * \r\nDisallow: \r\n\r\nUser-agent: Googlebot \r\n";
        $banned = Video::find()->where(['OR', ['dmca' => 1], ['ban' => 1]])->andWhere(['language' => LANGUAGE])->asArray()->all();
        foreach ($banned AS $video) {
            $txt .= "Disallow: /v/" . $video['id'] . "/ \r\n";
        }
        return $txt;
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

    public function actionGetDmca()
    {
        $this->getDmca('sk');
        $this->getDmca('cz');
        $this->getDmca('en');
    }

    public function getDmca($lang)
    {
        $api_url = [
            'sk' => 'http://googledmca.info/api/find-domain-urls/?domain=youtube-download.sk',
            'cz' => 'http://googledmca.info/api/find-domain-urls/?domain=youtube-download.cz',
            'en' => 'http://googledmca.info/api/find-domain-urls/?domain=youtube-download.us',
        ];
        $urls = file_get_contents($api_url[$lang]);
        $urls = json_decode($urls, true);
        $ids = [];
        foreach ($urls AS $url) {
            preg_match_all("/\?v=([a-zA-Z0-9-_]+)/i", $url, $match);
            if (isset($match[1][0])) {
                $ids[] = $match[1][0];
            }
            elseif (!isset($match[1][0])) {
                preg_match_all("/\/v\/([a-zA-Z0-9-_]+)/i", $url, $match);
                if (isset($match[1][0])) {
                    $ids[] = $match[1][0];
                }
                else {
                    var_dump($url);
                }
            }
            else {
                var_dump($match[1][0]);
            }
        }
        foreach ($ids AS $id) {
            $video = Video::find()->where(['id' => $id, 'language' => $lang])->one();
            if ($video) {
                $video->dmca = 1;
                $video->save();
            }
        }
    }
}
