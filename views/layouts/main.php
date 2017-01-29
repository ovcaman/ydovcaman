<?php
$session = Yii::$app->session;
$session->open();
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$lang = $_SERVER['lang'];         

AppAsset::register($this);
$this->registerJsFile("/js/ads.js");
$this->registerJsFile("/js/scripts.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_END]);
if (YII_ENV != 'dev') $this->registerJs("
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga')

  ga('create', 'UA-68535642-1', 'auto');
  ga('send', 'pageview');
");


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" hreflang="sk" href="http://www.youtube-download.sk<?= $_SERVER['REQUEST_URI']?>" />
    <link rel="alternate" hreflang="cs" href="http://www.youtube-download.cz<?= $_SERVER['REQUEST_URI']?>" />
    <link rel="alternate" hreflang="en" href="http://www.youtube-download.us<?= $_SERVER['REQUEST_URI']?>" />


    <script type='text/javascript' src='http://openx.wtools.sk/www/delivery/spcjs.php?id=2'></script>
    <script src="https://apis.google.com/js/platform.js" async defer>
      {lang: 'sk'}
    </script>


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body><div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sk_SK/sdk.js#xfbml=1&version=v2.5&appId=229853657066437";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function liked() {
    FB.Event.subscribe('edge.create', function() {
        setCookie("FBlike", "1", 365);
        $("body").removeClass("like_popup");
    });
    FB.Event.subscribe('edge.remove', function() {
        setCookie("FBlike", "0", 365);
    });
}

setTimeout(liked, 1000);

</script>

<?php $this->beginBody() ?>
<div id="adbOverlay">
    <table><tr><td>
        <?= $lang['adblock'][LANGUAGE] ?>
    </td></tr></table>
</div>

<div id="like_popup" class="blackOpaque hidden">  
  <table><tr><td>
  Pomohla ti táto stránka?<br />Pomôž aj ty svojim lajkom!<br />
  <div style="position:relative;">
    <div class="fb-like" id="popup_like_button" data-href="https://www.facebook.com/youtube.download.sk" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
    <img src="/layout/arrow.png?v=1" style="position:absolute;top:33px;margin-left:80px;">
  </div>
  <br /><br />
  <i class="fa fa-times-circle close"></i>
  </td></tr></table>
</div>

<div id="loader">
  <table>
    <tr>
      <td style="vertical-align:middle;">
          <div><img src="/layout/loader.gif" /></div>
          Converting video
      </td>
    </tr>
  </table>
</div>



<div id="top">
    <a href="/"><h1><?= LANGUAGE == "sk" || LANGUAGE == "cz" ? "YouTube-Download." . LANGUAGE : (LANGUAGE == eu ? 'YouTube-Download.us' : 'Online-Converter.us')  ?></h1></a>
    <div class="fb-like" id="like" style="position:relative;bottom:7px;border:" data-href="https://www.facebook.com/youtube.download.sk" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
    <div id="lang">
        <a href="http://www.youtube-download.sk<?= $_SERVER['REQUEST_URI']?>" class="<?= LANGUAGE == 'sk' ? 'activeLang' : ''?>" hreflang="sk">SK</a> | 
        <a href="http://www.youtube-download.cz<?= $_SERVER['REQUEST_URI']?>" class="<?= LANGUAGE == 'cz' ? 'activeLang' : ''?>" hreflang="cs">CZ</a> | 
        <a href="http://www.youtube-download.us<?= $_SERVER['REQUEST_URI']?>" class="<?= LANGUAGE == 'en' ? 'activeLang' : ''?>" hreflang="en">EN</a>
    </div>
</div>


<div id="content">
    <?php
    ?>

    <?= $content ?>
</div>

<div id="footer">
    <div style="display:none;">
        <a href="http://www.alexa.com/siteinfo/www.youtube-download.sk"><script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/s/a?url=www.youtube-download.sk'></script></a><br />
    </div>
    <a href="/sitemap/">
        &lt;Sitemap&gt;
    </a>
    &nbsp;
    <a href="/<?= $lang['navod_url'][LANGUAGE] ?>/">
        &lt;<?= $lang['navod'][LANGUAGE] ?>&gt;
    </a>
    <br />
    <a href="/" title="Youtube Downloader">&copy; YouTube-Download.<?= LANGUAGE == 'en' ? 'us' : LANGUAGE ?></a>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
