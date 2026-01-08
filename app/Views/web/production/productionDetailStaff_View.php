<?= $this->extend("/web/template/layout_staffLeft") ?>
<?= $this->section("content") ?>
<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productionDetailStaff_Do.js?rnd=<?=rand();?>"> </script>

<section class="mainContentStaff mainContentStaff2">
    <input type="hidden" id="gicode" name="gicode" value="<?=$body['gicode'];?>" />
    <input type="hidden" id="prcode" name="prcode" value="<?=$body['prcode'];?>" />
    <input type="hidden" id="gubun" name="gubun" value="<?=$body['info']['ptype']['gubun'];?>" />
    <input type="hidden" id="ptyp" name="ptyp" value="<?=$body['info']['ptype']['typ'];?>" />
    <input type="hidden" id="unit_weight" name="unit_weight" value="<?=$body['info']['unit_weight'];?>" />
    <div class="goods_boxfv6 ">
        <div class="area area1 flexType3">
            <div class="detailTitleBox producing_boxr8j">
                <p class="headTitle ">
                    생산현황 상세
                </p>
                <input type="search" class="inputType520 " placeholder="무게를 측정하세요." name="incode" id="incode" autofocus>
            </div>
        <?if($body['info']['btype']==1){?>
            <div class="trackBox flexType1">
                <img src="/assets/web/src/light.png" alt="img" class="lightImg mr10">
                <p class="status">작업시작등록</p>
            </div>
        <?}else{?>
            <div class="trackBox flexType1 active">
                <img src="/assets/web/src/light.png" alt="img" class="lightImg mr10">
                <p class="status">작업완료등록</p>
            </div>
        <?}?>
        </div>
        <div class="areaBoxStaff areaBoxStaff2 area_boxg4q production_boxu10">
            <div class="upside flexType4 mt10 ml10">
                <div class="left">
                    <div class="element flexType2">
                        <p class="title">제품명</p>
                        <p class="data inputType220"><?=$body['info']['g_name'];?></p>
                    </div>
                    <div class="element flexType2 ">
                        <p class="title">공정명</p>
                        <p class="data inputType220"><?=$body['info']['p_name'];?></p>
                    </div>
                    <div class="element flexType4 ">
                        <p class="title">부자재</p>
                        <div class="coverBox">
                            <?if(fn_ArrayCnt($body['info']['material'])>0){?>
                                <?foreach ($body['info']['material'] as $d){?>
                                    <p class="data data4 inputType220 mb10"><?=$d['mtname'];?>[<?=$d['capacity'];?>개]</p>
                                <?}?>
                            <?}else{?>
                                <p class="data data4 inputType220 mb10">없음</p>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="element flexType2">
                        <p class="title">작업자</p>
                        <p class="data inputType220"><?=$body['info']['worker']['name'];?></p>
                    </div>
                    <div class="flexType2">
                        <div class="element flexType2 mr10 ">
                            <p class="title">작업시간</p>
                            <p class="data inputType220"><?=$body['info']['worker']['actdate'];?></p>
                        </div>
                    </div>
                    <div class="element flexType2">
                        <p class="title">BOM입고량</p>
                        <p class="data inputType220"><?=$body['material']['input_material'];?>g</p>
                    </div>
                    <div class="element flexType2">
                        <p class="title">BOM출고량</p>
                        <p class="data inputType220"><?=$body['material']['output_material'];?>g</p>
                    </div>
                    <div class="table_boxqqq flexType4">
                        <div class="leftArea">
                            <p class="title mt10">무게</p>
                        </div>
                        <table class="weight_tablevufb ">
                            <thead>
                            <tr>
                                <?if($body['info']['ptype']['typ']==1){?>
                                <td class="title">실제무게</td>
                                <?}else if($body['info']['ptype']['typ']==2){?>
                                <td class="title">실제무게 / 갯수</td>
                                <?}?>
                                <td class="title">저울잠금</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="weight" id="afterweight" data-val=""></td>
                                <?if(($body['info']['status']==0) || ($body['info']['status']==1)){?>
                                    <td class="weight ">
                                        <button type="button" class="wConfirm btn60Type3 " id="btn_act" data-act="yes">
                                            <i class="fa-solid fa-lock-open" id="btn_act_i"></i>
                                        </button>
                                    </td>
                                <?}else{?>
                                    <td class="weight"><?=number_format($body['info']['after']);?>g</td>
                                    <td class="weight ">
                                        <button type="button" class="wConfirm btn60Type2" id="btn_act" data-act="no">
                                            <i class="fa-solid fa-lock"></i>
                                        </button>
                                    </td>
                                <?}?>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="memo_boxb5h mt10 ml10 flexType4">
                <p class="title">레시피</p>
                <textarea name="" id="" cols="" rows="" readonly placeholder=""><?=$body['info']['method'];?></textarea>
            </div>
            <div class="submitBox flexType5-1 ">
                <div class="right flexType2">
                    <button type="button" class="btn80Type1 mr10" onclick="go_productionListStaff();">이전</button>
                    <?if($body['info']['btype']==1){?>
                    <button type="button" class="btn80Type3 active" id="btn_confirm">시작</button>
                    <?}else{?>
                    <button type="button" class="btn80Type3 active" id="btn_confirm">완료</button>
                    <?}?>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>