<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; 
$date = date('c', strtotime(date("Y-m-d H:00:00")));
if ($page == null) { 
echo '<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">';
for ($i = 1; $i <= $pages; $i++) {
    echo "<sitemap><loc>http://{$_SERVER['SERVER_NAME']}/sitemap.xml?page={$i}</loc>
        <lastmod>{$date}</lastmod>
    </sitemap>";
}
echo "</sitemapindex>";
} else {
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/</loc>
    <changefreq>hourly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/<?= $_SERVER['lang']['navod_url'][LANGUAGE] ?>/</loc>
    <changefreq>monthly</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/sitemap/</loc>
    <changefreq>hourly</changefreq>
    <priority>0.9</priority>
  </url>
  <?php foreach ($videos AS $video) { ?>
  <url>
    <loc><?= "http://".$_SERVER['SERVER_NAME']."/v/".$video->id."/" ?></loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <?php } ?>
</urlset>  
<?php } ?> 