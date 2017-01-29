<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$lang = $_SERVER['lang'];
if ($video->title == null) {
    $this->title = $lang['meta_title'][LANGUAGE];
    $this->registerMetaTag(["name" => "description", "content" => $lang['meta_description'][LANGUAGE]]);
}
else {
    $this->title = $lang['download'][LANGUAGE] . " \"" . $video->title . "\"";
    $this->registerMetaTag(["name" => "description", "content" => str_replace("{title}", $video->title, $lang['video_meta_description'][LANGUAGE])]);
}
?>
<div id="url_form">
    <?php if ($video->title) {?>
    <h2><?= $video->title ?></h2>
    <br />
    <div class="video-container">
      <div id="ytplayer"></div> 
    </div>
    <br />                
    <?php } ?>

    <div style="max-width:970px;margin:auto;">
        <script type='text/javascript'><!--// <![CDATA[
            OA_show(<?= ['sk' => 3, 'cz' => 1, 'en' => 6][LANGUAGE] ?>);
        // ]]> -->
        </script>
    </div>

    <?php
    $form = ActiveForm::begin(['id' => 'mainForm', 'action' => "http://" . substr($_SERVER['SERVER_NAME'], 0, 4) . "online-converter.us/"]);
    ?>
    <div style="max-width:970px;margin:auto;background:#fff;border:1px solid #444;margin-bottom:15px;margin-top:15px;border-radius:4px;" class="row panel panel-danger">
        <div class="panel-heading">YouTube Downloader</div>
        <div class="panel-body">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <?= $form->field($download, 'url', ['template' => '{label}{input}{error}'])->textInput(['placeholder' => 'https://www.youtube.com/watch?v=8H7FnfnSEMA'])->label('URL:'); ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-7">
                <?= $form->field($download, 'format', ['template' => '{label}{input}{error}'])->dropDownList(['mp3' => 'mp3 (audio)', 'mp4' => 'mp4 (audio + video)'], ['prompt' => ''])->label("Format:") ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-5">
                <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <?= Html::submitButton('Download', ['class' => 'btn btn-danger form-control', 'disabled']); ?>
                </div>
            </div>
            <?php if ($filename) {?>
                <a href="/tmp/<?= $filename ?>" class="btn btn-success btn-lg" style="width:100%;"><i class="glyphicon glyphicon-save"></i> Download: <?= $filename ?></a>
            <?php }?>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
    <div style="max-width:970px;margin:auto;">
        <script type='text/javascript'><!--// <![CDATA[
            OA_show(<?= ['sk' => 3, 'cz' => 7, 'en' => 6][LANGUAGE] ?>);
        // ]]> -->
        </script>
    </div>
    <br />
</div>
<br />
<?php
if ($video->title == null) {
    echo $lang['landing_help'][LANGUAGE];
}
else {
    ?>
<br />  
<?php $this->registerJs("   
 var msec = 0;
 var youtubeVideo = '{$video->id}';
 var moved = 0;
 var mouse = 1;
 
 function mad() {
     var date = new Date();   
     if (mouse) {
         $('#download_link, #main_ad').css('margin-top', '0px');
         moved = 1;
     }          
 }
 
 function link_click() {
     var date = new Date();
     msec = date.getTime() - msec;
     if (msec < 30 && moved == 0) {
         msec = date.getTime();
         setTimeout(mad, 10000);
         return false;
     }
     else {
         setTimeout(like_popup, 2000);
         return true;
     }
 }
                      
 function touch_detect() {
     mouse = 0;
     $(document).off('touchstart', touch_detect);
 }
 $(document).on('touchstart', touch_detect);
 
 
 $(document).on('ready', function() {
    if (typeof(youtubeVideo != 'undefined')) {
        var tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/player_api?enablejsapi=1&version=3';
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
});
var player;
function onYouTubePlayerAPIReady() {
    if (typeof(youtubeVideo != 'undefined')) {
        player = new YT.Player('ytplayer', {
          height: '440',
          width: '728',
          videoId: youtubeVideo,
          events: {
          }
        });
    }
}", yii\web\View::POS_END);
?>

  <div style="max-width:970px;margin:auto;">
      <h2>Download &quot;<?= $video->title ?>&quot;</h2>
      <p>Stiahnite si video <strong>&quot;<?= $video->title ?>&quot;</strong> priamo z youtube. Stačí zvoliť požadovaný formát a po kliknutí na tlačidlo "Download" bude vygenerovaný odkaz na stiahnutie videa <strong>&quot;<?= $video->title ?>&quot;</strong>.</p>
      <h2>Chcete stiahnúť len zvuk z videa vo formáte mp3?</h3>
      <p>
          Pre stiahnutie zvuku z videa <strong>&quot;<?= $video->title ?>&quot;</strong> vo formáte MP3 jednoducho zvoľte formát MP3 a počkajte, kým sa vygeneruje odkaz. 
      </p>
  </div>
  <div style="width:300px;position:relative;margin:25px auto 0 auto;border:10px solid #ffffff;border-radius:5px;box-shadow:0 0 5px #aaa;" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
      <meta itemprop="thumbnailURL" content="http://i.ytimg.com/vi/<?= $video->id ?>/mqdefault.jpg" />
      <meta itemprop="embedURL" content="https://www.youtube.com/embed/<?= $video->id ?>" />
      <meta itemprop="description" content="<?= $video->title ?>" />
      <meta itemprop="uploadDate" content="<?= $video->created_at ?>" />
      <img src="http://i.ytimg.com/vi/<?= $video->id ?>/mqdefault.jpg" width="280" style="display:block;" />
      <div style="position:absolute;bottom:0px;background:rgba(255,255,255,0.8);width:100%;font-size:13px;padding:10px;box-sizing:border-box;">
          <a href="https://www.youtube.com/watch?v=<?= $video->id ?>" itemprop="name"><?= $video->title ?></a>
      </div>   
      <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
          <meta itemprop="ratingValue" content="8,7"></span>
          <meta itemprop="bestRating" content="10" />
          <meta itemprop="ratingCount" content="25">
      </div>    
  </div>
    <?php
}
foreach ($more AS $thumb) {
    ?><div class="downloaded">
        <img src="http://i.ytimg.com/vi/<?= $thumb->id ?>/mqdefault.jpg" height="100" alt="<?= $thumb->title ?>">
        <a href="/?v=<?= $thumb->id ?>" title="YouTube download"><h3><?= $thumb->title ?></h3></a>
        <div class="date"><?= date("d.m.Y", strtotime($thumb->created_at)); ?></div>
        <div class="yd"><a href="/" title="Youtube downloader">YouTube download</a></div>
      </div>
<?php
}
?>