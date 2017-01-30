<?php

$this->title = "HTML Sitemap of " . $_SERVER['SERVER_NAME'];
$this->registerMetaTag(["name" => "description", "content" => "History of all downloaded videos from youtube.com by " . $_SERVER['SERVER_NAME']]);

?>
<div style="max-width:1000px;padding:20px;margin:auto;text-align:left;">
<h1>Sitemap</h1>
<ul>
  <li>
    <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/"><?= $_SERVER['SERVER_NAME'] ?></a>
    <ul>   
      <li>
        <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/<?= $_SERVER['lang']['navod_url'][LANGUAGE] ?>/"><?= $_SERVER['lang']['navod'][LANGUAGE] ?></a>
      </li>
      <?php foreach ($videos AS $video) { ?>
	      <li>
	        <a href="/v/<?= $video->id ?>/">Download <?= $video->title ?></a>
	      </li>
      <?php } ?>
    </ul>
  </li>
</ul>                     
</div>