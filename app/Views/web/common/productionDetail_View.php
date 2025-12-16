<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productionDetail_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>
<section class="merright">
    <input type="hidden" id="gicode" name="gicode" value="<?=$body['gicode'];?>" data-cd="<?=$body['gicode'];?>"  />
    <input type="hidden" id="stepnow" name="stepnow" value="<?=$body['stepnow'];?>" />
    <div class="goods_boxfv6 ">
        <div class="titleBox producing_boxr8j">
            <p class="headTitle">
                생산현황 상세
            </p>
        </div>
        <div class="areaBox area_boxmxh mb10">
            <div class="goods_boxkfg production_boxs7c flexType3">
                <div class="left flexType2">
                    <p class="title">지시서코드</p>
                    <p class="count" id="code" name="code"></p>
                </div>
                <div class="right">
                    <button type="button" class="btnType1 mr10" name="vwReport" data-cd="">품질보고서</button>
                    <button type="button" class="btnType2" onclick="go_productionList();">목록</button>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol">공정번호</td>
                            <td class="ltThead">공정명</td>
                            <td class="ltThead">예상측정량(시작/끝)</td>
                            <td class="ltThead">실측정량(시작/끝)</td>
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
    </div>

</section>

<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>

