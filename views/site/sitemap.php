<?php

$this->title = "HTML Sitemap of " . DOMAIN;
$this->registerMetaTag(["name" => "description", "content" => "History of all downloaded videos from youtube.com by " . DOMAIN]);

?>
<div style="max-width:1000px;padding:20px;margin:auto;text-align:left;">
<h1>Sitemap</h1>
<ul>
  <li>
    <a href="http://<?= DOMAIN ?>/"><?= DOMAIN ?></a>
    <ul>   
      <li>
        <a href="http://<?= DOMAIN ?>/<?= $_SERVER['lang']['navod_url'][LANGUAGE] ?>/"><?= $_SERVER['lang']['navod'][LANGUAGE] ?></a>
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