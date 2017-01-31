<?php

$this->title = "Sťahovanie videa z youtube.com";
$this->registerMetaTag(["name" => "description", "content" => "Bezplatný online youtube downloader na sťahovanie videa z youtube. Sťahujte zadarmo a bez čakania."]);
$this->registerMetaTag(["name" => "keywords", "content" => "sťahovanie videa z youtube, sťahovanie z youtube, stiahnuť video z youtube, download videa z youtube, ako sťahovať video z youtube, sťahovanie videa z youtube, youtube download, download youtube, ako stiahnut video z youtube"]);

?>
<div style="padding:10px 20px;max-width:1000px;margin:auto;">
    <h1>Ako sťahovať z youtube?</h1>
    <p class="strong">Existuje niekoľko spôsobov, ako sťahovať video z youtube. Najrýchlejší z nich je jednoduchá editácia URL adresy videa.</p>
    <p class="strong">Druhý spôsob je podobne rýchly a to otvoriť si <a href="http://www.youtube-download.sk/">online youtube downloader</a> a zadať URL adresu videa.</p>
    <h2>Sťahovanie dopísaním -x do URL</h2>
    <p>Najrýchlejší spôsob sťahovania je dopísať <strong>-x</strong> do adresy videa.</p>
    <p>
        Takže ak chcete stiahnuť video: <br />
        <a href="https://www.youtube.com/watch?v=<?= EXAMPLE ?>">https://www.youtube.com/watch?v=<?= EXAMPLE ?><a><br />
        stačí adresu prepísať na: <br />
        <a href="https://www.youtube-x.com/watch?v=<?= EXAMPLE ?>">https://www.youtube<strong class="red">-x</strong>.com/watch?v=<?= EXAMPLE ?></a>  
    </p>
    <p>Následne budete presmerovaní na downloader, kde si vyberiete požadovaný formát (MP3/MP4). Po potvrdení bude vygenerovaná adresa na stiahnutie videa.</p>
    <h2>Použite online youtube downloader</h2>
    <p>Postup je prakticky rovnaký, ako pri úprave URL. Rozdiel je jedine v prvom kroku. Tu namiesto editácie url prejdete na <a href="http://www.youtube-download.sk/">www.youtube-download.sk</a>, zvolíte formát a po odoslaní formulára Vám bude vygenerovaná adresa na stiahnutie videa.</p>
</div>