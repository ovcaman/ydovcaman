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
    if (IS_FINAL_DOMAIN) {
        $this->registerMetaTag(["name" => "googlebot", "content" => 'noindex']);
    }
    if ($video->dmca == 1) 
    {
        $this->registerMetaTag(["name" => "googlebot", "content" => 'noindex']);
    }
}
?>
<div id="url_form">
  <div style="max-width:1200px;margin:auto;" class="row">
    <div class="col-md-8">
        <?php if ($video->title) {?>
        <h2><?= $video->title ?></h2>
        <div class="br"></div>   
        <div class="video-container">
          <div id="ytplayer"></div>
          <div class="clearfix"></div>
        </div>
        <div class="br"></div>               
        <?php } ?>
        <script type='text/javascript'><!--// <![CDATA[
            OA_show(<?= IS_FINAL_DOMAIN ? 8 : ['sk' => 3, 'cz' => 1, 'en' => 6][LANGUAGE] ?>);
        // ]]> -->
        </script>

        <?php
        $form = ActiveForm::begin(['id' => 'mainForm', 'action' => "http://" . substr(DOMAIN, 0, 4) . "online-converter.us/"]);
        ?>
        <div class="br"></div>
        <div style="background:#fff;border:1px solid #444;margin-bottom:15px;margin-top:5px;border-radius:4px;" class="row panel panel-danger" id="download_form">
            <div class="panel-heading">YouTube Downloader</div>
            <div class="panel-body">
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <?= $form->field($download, 'url', ['template' => '{label}{input}{error}'])->textInput(['placeholder' => 'https://www.youtube.com/watch?v=8H7FnfnSEMA'])->label('URL:'); ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-7">
                    <?= $form->field($download, 'format', ['template' => '{label}{input}{error}'])->dropDownList(['mp3' => 'mp3 (audio)', 'mp4' => 'mp4 (audio + video)'], ['prompt' => ''])->label("Format:") ?>
                </div>
                <?= Html::hiddenInput('language', LANGUAGE); ?>
                <div class="col-md-2 col-sm-2 col-xs-5">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <?= Html::submitButton('Download', ['class' => 'btn btn-danger form-control', 'disabled']); ?>
                    </div>
                </div>
                <?php if ($filename) {?>
                    <div class="col-sm-12" style="padding:5px;">
                        <script type='text/javascript'><!--// <![CDATA[
                            OA_show(<?= IS_FINAL_DOMAIN ? 9 : ['sk' => 5, 'cz' => 4, 'en' => 6][LANGUAGE] ?>);
                        // ]]> -->
                        </script>
                        <div class="br"></div>
                        <a href="/tmp/<?= $filename ?>" class="btn btn-success btn-lg" style="width:100%;" onclick="return link_click();"  onmouseover="setTimeout(mad, 300);var date = new Date();msec = date.getTime();"><span><i class="glyphicon glyphicon-save"></i> Download: <?= $filename ?></span></a>
                    </div>

                <?php }?>

            </div>
        </div>
        <?php
        ActiveForm::end();
        ?>
        <script type='text/javascript'><!--// <![CDATA[
            OA_show(<?= IS_FINAL_DOMAIN ? 8 : ['sk' => 5, 'cz' => 7, 'en' => 6][LANGUAGE] ?>);
        // ]]> -->
        </script>
        <br />
    </div>
    <div class="col-md-4">
          <script type='text/javascript'><!--// <![CDATA[
              OA_show(<?= IS_FINAL_DOMAIN ? 10 : ['sk' => 12, 'cz' => 11, 'en' => 13][LANGUAGE] ?>);
          // ]]> -->
          </script>
    </div>
  </div>
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
 var random = Math.random();
 
 function mad() {
     var date = new Date(); 
     var body = document.body;

     if (mouse && moved != 1 && random > 0.4) {
         //$('.br').css('height', '5px');

         body.scrollTop += 100;
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
         setTimeout(function() { $('body').addClass('like_popup');$('#like_popup').removeClass('hidden'); }, 2000);
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
      <?= str_replace("{title}", $video->title, $lang['video_help'][LANGUAGE]) ?>
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