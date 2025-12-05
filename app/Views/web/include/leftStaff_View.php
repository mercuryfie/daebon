<div class="leftBoxStaff ">
    <div class="leftMenuStaff ">
        <div class="menuWrap menuWrap0">
        <?if(($left['gicode']!='') && (fn_ArrayCnt($left['i_info']) >0)){?>
            <div class="boxd0q flexType2 ">
                <p class="title">지시서날짜</p>
                <p class="data"><?=$left['i_info']['indate'];?></p>
            </div>
            <div class="boxd0q flexType2">
                <p class="title">지시서코드</p>
                <p class="data"><?=$left['i_info']['gicode'];?></p>
            </div>
            <div class="boxd0q flexType2">
                <p class="title">제품명</p>
                <p class="data"><?=$left['i_info']['gname'];?></p>
            </div>
            <div class="boxd0q flexType2">
                <p class="title">총 공정 수</p>
                <p class="data"><?=$left['i_info']['step_cnt'];?></p>
            </div>
        <?}?>
        </div>
    <?if(($left['gicode']!='') && (fn_ArrayCnt($left['p_info']) > 0)){?>
        <?$i=1;?>
        <?foreach($left['p_info'] as $d){?>
        <div class="menuWrap menuWrap1">
            <?if($d['status']==0){?>
            <div class="topMenu topMenu1 progQueue flexType2 <?if($d['fk_prcode']==$left['prcode']) echo('active2');?>" name="stepnode" data-prcode="<?=$d['fk_prcode'];?>">
            <?}else if($d['status']==1){?>
            <div class="topMenu topMenu2 progNow flexType2 <?if($d['fk_prcode']==$left['prcode']) echo('active2');?>" name="stepnode" data-prcode="<?=$d['fk_prcode'];?>">
            <?}else if($d['status']==2){?>
            <div class="topMenu topMenu3 progDone flexType2 <?if($d['fk_prcode']==$left['prcode']) echo('active2');?>" name="stepnode" data-prcode="<?=$d['fk_prcode'];?>">
            <?}?>
                <h1><?=fn_padNumber($i++,2);?></h1>
                <p class="title"><?=$d['step_name'];?></p>
            </div>
        </div>
        <?}?>
    <?}?>
    </div>
</div>
