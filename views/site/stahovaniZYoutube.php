<?php

$this->title = "Stahování videí z youtube.com";
$this->registerMetaTag(["name" => "description", "content" => "Rýchly návod, jak zdarma stahovat video z youtube. Online youtube downloader."]);
$this->registerMetaTag(["name" => "keywords", "content" => "stahování videa z youtube, stáhnout video z youtube, download videa z youtube, jak stahovat video z youtube, stahování videa z youtube, youtube download, download youtube, jak stahnout video z youtube"]);

?>
<div style="padding:10px 20px;max-width:1000px;margin:auto;">
    <h1>Jak stahovat video z youtube?</h1>
    <p class="strong">Existuje několik způsobů, jak stahovat videa z youtube. Nejrychlejší z nich je jednoduchá editace URL adřesy videa.</p>
    <p class="strong">Druhý způsob je stejne rýchly a to otevřít si <a href="http://www.youtube-download.cz/">online youtube downloader</a> a zadat URL adresu videa.</p>
    <h2>Stahování dopsaním -x do URL</h2>
    <p>Nejrýchlejší způsob stahování je dopsat <strong>-x</strong> do adřesy videa.</p>
    <p>
        Takže jestli chcete stáhnout video: <br />
        <a href="https://www.youtube.com/watch?v=<?= EXAMPLE ?>">https://www.youtube.com/watch?v=<?= EXAMPLE ?><a><br />
        stačí adřesu přepsat na: <br />
        <a href="https://www.youtube-x.com/watch?v=<?= EXAMPLE ?>">https://www.youtube<strong class="red">-x</strong>.com/watch?v=<?= EXAMPLE ?></a>  
    </p>
    <p>Následne budete přesměřovaní na downloader, kde si vyběrete požadovaný formát (MP3/MP4). Po potvrzení bude vygenerovaná adřesa pro stáhnutí videa.</p>
    <h2>Použitím online youtube downloadera</h2>
    <p>Postup je prakticky stejný, jak při úpravě URL. Rozdíl je jedine v prvním kroku. Tady místo editace URL přejdete na <a href="http://www.youtube-download.cz/">www.youtube-download.cz</a>, zvolíte formát a po odeslání formuláře Vám bude vygenerovaná adřesa pro stáhnutí videa.</p>
</div>