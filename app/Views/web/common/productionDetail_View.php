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
                    <p class="count" id="gicode" name="gicode" data-cd="<?=$body['gicode'];?>" ></p>
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
                            <td class="ltThead productNo checkCol">공정번호</td>
                            <td class="ltThead">지시날짜</td>
                            <td class="ltThead">공정명</td>
                            <td class="ltThead">예상측정량(시작/종료)</td>
                            <td class="ltThead">실측정량</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">시작작업자</td>
                            <td class="ltThead">완료작업자</td>
                        </tr>
                        </thead>
                        <tbody id="tList" name="tList">
                        <?if(fn_ArrayCnt($body['info']) > 0){?>
                            <?foreach ($body['info'] as $d){?>
                                <tr class="" name="view_detail" data-nd="<?=$d['gicode']?>">
                                    <td class="ltTbody numbering"><?=$d['stepNum']?></td>
                                    <td class="ltTbody  "><?=$d['indate']?></td>
                                    <td class="ltTbody  "><?=$d['step_name']?></td>
                                    <td class="ltTbody  "><?=$d['guess']?></td>
                                    <td class="ltTbody  "><?=$d['real']?></td>
                                    <td class="ltTbody  "><?=$d['status']?></td>
                                    <td class="ltTbody  "><?=$d['start']?></td>
                                    <td class="ltTbody  "><?=$d['end']?></td>
                                </tr>
                            <?}?>
                        <?}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>

