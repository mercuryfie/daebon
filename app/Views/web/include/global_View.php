<?if($header['islogin']==true){?>
    <input type="hidden" id="tUid" name="tUid" value="<?= $header['uid']?>" />
    <input type="hidden" id="token" name="token" value="<?= $header['token']?>" />
<?}else{?>
    <input type="hidden" id="tUid" name="tUid"  />
    <input type="hidden" id="token" name="token"/>
<?}?>

<div class="spinnerBox" id="spinnerBox"><img src="/assets/web/src/spinner.gif" alt="img" id="spinner" class="spinner" style=""></div>