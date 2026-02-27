<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/halfListLog_Do.js?rnd=<?=rand();?>"> </script>

<section class="mainContentStaff flexType2">
    <div class="half_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                외포장 완료 로그
            </p>
        </div>
        <div class="areaBoxStaff prod_list_box ">
            <div class="area area1 flexType3">
                <div class="left flexType2">
<!--                    <input type="search"-->
<!--                           class="searchArea mr20"-->
<!--                           placeholder="바코드를 스캔하십시오" name="incode" id="incode" autofocus>-->
<!--                    <div class="left2 flexType2">-->
<!--                        <p class="title mr10">총</p>-->
<!--                        <p class="count mr10" id="tcnt" name="tcnt" data-val="0"></p>-->
<!--                        <p class="unit">건</p>-->
<!--                    </div>-->
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <button type="button" class="btn_long mr10" name="searchType" data-val="0" onclick="go_halfList();">반제품 목록</button>

                    <button type="button" class="btnType60 " id="btn_reload" name="btn_reload">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </div>
            <div class="area area2 flexType2">
                <table class="prod_list_table">
                    <thead>
                    <tr>
                        <th class="ltThead">지시서 코드</th>
                        <th class="ltThead">반제품 코드</th>
                        <th class="ltThead">반제품명</th>
                        <th class="ltThead">팩</th>
                        <th class="ltThead">공정명</th>

                        <th class="ltThead">수량</th>
                        <th class="ltThead">작업자</th>
                        <th class="ltThead">날짜</th>
                    </tr>
                    </thead>
                    <tbody name="clist" id="clist">
                    <tr>
                        <td class="ltThead">123421341234</td>
                        <td class="ltThead">123421341234</td>
                        <td class="ltThead">우엉차 원물</td>
                        <td class="ltThead">25</td>
                        <td class="ltThead">우엉차 원물 - 파쇄</td>

                        <td class="ltThead">20</td>
                        <td class="ltThead">김생산</td>
                        <td class="ltThead">2025-01-01</td>
                    </tr>
                    <tr>
                        <td class="ltThead">123421341234</td>
                        <td class="ltThead">123421341234</td>
                        <td class="ltThead">우엉차 원물</td>
                        <td class="ltThead">25</td>
                        <td class="ltThead">우엉차 원물 - 파쇄</td>

                        <td class="ltThead">20</td>
                        <td class="ltThead">김생산</td>
                        <td class="ltThead">2025-01-01</td>
                    </tr>
                    </tbody>
                </table>
            </div>
<!--            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">-->
<!--                <p class="more mr10">더보기</p>-->
<!--                <i class="fa-solid fa-angle-down"></i>-->
<!--            </div>-->
        </div>
    </div>
</section>

<?= $this->include('/web/include/pop_AddHalfProduct_View'); ?>
<?= $this->endSection() ?>