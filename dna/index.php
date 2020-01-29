<?php require('parts/dnaConverter.php');?>
<?php
  $siteTitle = "でぃ〜えぬえ〜へんかん";
  require('parts/head.php');
?>
<?php require('parts/header.php');?>
<div class="contents">
  <form action="index.php" method="post">
    <div>
      <input type="radio" id="radio1" name="mode" value="0" <?php if($mode==0) echo 'checked'?>> <label for="radio1">ことば</label>
      <input type="radio" id="radio2" name="mode" value="1" <?php if($mode==1) echo 'checked'?>> <label for="radio2">ぬくれおちど</label>
    </div>
    <div class="text-area">
      <textarea class="text-input" placeholder="入力してください" rows="10" name="value"><?php if(!empty($_POST['value'])) echo $_POST['value']?></textarea>
    </div>
    <div class="text-area div-result">
      <?php if(!empty($_POST['value'])) {
        $convertedText = convert($_POST['value'], $mode);
        echo $convertedText;
      } ?>
    </div>
    <input class="button button-convert" type="submit" value="変換する">
  </form>
  <button class="button tweet" type=“button” onclick="location.href='<?php echo getTwitterURL();?>'"><img src="img/icon_twitter.png" alt="ツイッター" /></button>
</div>
<div class="store_badge_area">
  <a href="https://apps.apple.com/jp/app/dna%E5%A4%89%E6%8F%9B/id1493994947?mt=8" style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/ja-jp/badge-lrg.svg?releaseDate=2020-01-22&kind=iossoftware&bubble=ios_apps) no-repeat;width:135px;height:40px;margin:8px;background-size:contain;"></a>
  <a href="https://apps.apple.com/jp/app/dna%E5%A4%89%E6%8F%9B/id1494127578?mt=12" style="display:inline-block;overflow:hidden;background:url(img/badge_mac_app_store.svg) no-repeat;width:135px;height:40px;margin:8px;background-size:contain;"></a>
  <a href='https://play.google.com/store/apps/details?id=am10.dnaconverter&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Google Play で手に入れよう' width="144px" height="56px" src='https://play.google.com/intl/us-en/badges/static/images/badges/ja_badge_web_generic.png'/></a>
</div>
<?php require('parts/footer.php');?>
