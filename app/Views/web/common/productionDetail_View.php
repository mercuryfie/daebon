<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productionDetail_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>
<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox producing_boxr8j">
            <p class="headTitle">
                생산현황 상세
            </p>
<!--            <button type="button" class="btnType1 mr10vw" onclick="go_productionList();">목록</button>-->
        </div>
        <div class="areaBox area_boxmxh mb10">
            <div class="goods_boxkfg production_boxs7c flexType3">
                <div class="left flexType2">
                    <p class="title">지시서코드</p>
                    <p class="count" id="gicode" name="gicode" data-cd="<?=$body['gicode'];?>" data-nd="<?=$body['material']['fk_prcode'];?>"><?=$body['gicode'];?></p>
                </div>
                <div class="right">
                    <button type="button" class="btnType1 mr10" name="vwReport" onclick="" data-cd="<?=$body['gicode'];?>" >품질보고서</button>
                    <button type="button" class="btnType2" onclick="go_productionList();">목록</button>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol">번호</td>
                            <td class="ltThead">지시날짜</td>
                            <td class="ltThead">공정명</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">작업자</td>
                        </tr>
                        </thead>
                        <tbody id="tList" name="tList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--        <div class="areaBox area_boxg4q production_boxu9d p20" id="dList" name="dList">-->
<!--            <div class="upside flexType4 mt10">-->
<!--                <div class="left">-->
<!--                    <div class="element flexType2">-->
<!--                        <p class="title">제품명</p>-->
<!--                        <p class="data inputType220">--><?php //=$body['info']['g_name'];?><!--</p>-->
<!--                    </div>-->
<!--                    <div class="element flexType2 mb40">-->
<!--                        <p class="title">공정명</p>-->
<!--                        <p class="data inputType220">--><?php //=$body['info']['p_name'];?><!--</p>-->
<!--                    </div>-->
<!--                    <div class="element flexType4 mt40">-->
<!--                        <p class="title">부자재</p>-->
<!--                        <div class="coverBox">-->
<!--                            --><?//if(fn_ArrayCnt($body['info']['material'])>0){?>
<!--                                --><?//foreach ($body['info']['material'] as $d){?>
<!--                                    <p class="data data4 inputType220 mb10">--><?php //=$d['mtname'];?><!--[--><?php //=$d['capacity'];?><!--개]</p>-->
<!--                                --><?//}?>
<!--                            --><?//}else{?>
<!--                                <p class="data data4 inputType220 mb10">없음<br>없음<br>없음<br>없음<br>없음<br>없음<br>없음<br>없음</p>-->
<!--                            --><?//}?>
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="right">-->
<!--                    <div class="element flexType2">-->
<!--                        <p class="title">작업자</p>-->
<!--                        <p class="data inputType220">--><?php //=$body['info']['worker']['name'];?><!--</p>-->
<!--                    </div>-->
<!--                    <div class="flexType2">-->
<!--                        <div class="element flexType2 mr10">-->
<!--                            <p class="title">작업시간</p>-->
<!--                            <p class="data inputType220">--><?php //=$body['info']['worker']['actdate'];?><!--</p>-->
<!--                        </div>-->
<!--                        <div class="element flexType2 ">-->
<!--                            <p class="mr10"> ~ </p>-->
<!--                            <p class="data inputType220">--><?php //=$body['info']['worker']['actdate'];?><!--</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="table_boxqqq flexType4">-->
<!--                        <div class="leftArea">-->
<!--                            <p class="title">무게</p>-->
<!---->
<!--                        </div>-->
<!--                        <table class="weight_tablevufb ">-->
<!--                            <thead>-->
<!--                            <tr>-->
<!--                                <td class="title">예상 입고량</td>-->
<!--                                <td class="title">예상 출고량</td>-->
<!--                                <td class="title">실제 출고량</td>-->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                            <tr>-->
<!--                                <td class="weight">--><?php //=number_format($body['info']['input']);?><!--g</td>-->
<!--                                <td class="weight">--><?php //=number_format($body['info']['output']);?><!--g</td>-->
<!--                                <td class="weight" id="afterweight" data-val=""></td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="memo_boxb5h mt20 flexType4">-->
<!--                <p class="title ">레시피</p>-->
<!--                <textarea name="" id="" cols="" rows="" readonly placeholder="">--><?php //=$body['info']['method'];?><!--</textarea>-->
<!--            </div>-->
<!--        </div>-->
    </div>

</section>

<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>