

<script src="<?=URL_COMMON_ASSETS?>/leftMenu.js"> </script>
<div class="leftBox ">
    <div class="leftMenu searchBox1 ">
        <select name="searchtop" id="searchtop" class="">
            <option value="">선택하세요.</option>
            <option value="1" <?if($left['searchtyp']=='1') echo('selected');?> >구매자명</option>
            <option value="2" <?if($left['searchtyp']=='2') echo('selected');?>>수취인명</option>
            <option value="3" <?if($left['searchtyp']=='3') echo('selected');?>>구매자ID</option>
            <option value="4" <?if($left['searchtyp']=='4') echo('selected');?>>주문번호</option>
            <option value="5" <?if($left['searchtyp']=='5') echo('selected');?>>상품</option>
        </select>
        <div class="searchBox1-1 flexType2">
            <input type="search" name="searchval" id="searchval" value="<?=$left['searchval'];?>">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>


    <div class="leftMenu merleft1-3">
        <div class="menuWrap ">
            <?=$left['html'];?>
        </div>
    </div>
</div>
