<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/linkMalls_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="merright1-0 link_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                쇼핑몰연동
            </p>
        </div>
        <div class="areaBox mb10 ">
            <div class="area2 flexType2 areaHidden">
                <input type="search" name="" id="" class="searchArea" placeholder="검색어 입력">
                <button type="button" class="btnType1">검색</button>

            </div>
        </div>
        <div class="areaBox pb100">
            <div class="area3 mb10">
                <button type="button" class="btnType1 mr10" onclick="go_linkMallsLogs();">로그보기</button>
                <button type="button" class="btnType2">주문수집</button>
            </div>
            <div class="area4">
                <table class="linkMallsTable ">
                    <thead>
                        <tr>
                            <td class="ltThead col1"></td>
                            <td class="ltThead col2">번호</td>
<!--                                <td class="ltThead">쇼핑몰</td>-->
                            <td class="ltThead">쇼핑몰명</td>
                            <td class="ltThead">구매자명</td>

                            <td class="ltThead">구매자ID</td>
                            <td class="ltThead">수집시점(주문)</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">수집시점(클레임)</td>
                            <td class="ltThead">상태</td>

                            <td class="ltThead">비고</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ltTbody">
                                <input type="checkbox" name="" id="">
                            </td>
                            <td class="ltTbody">1</td>
                            <td class="ltTbody">옥션</td>
                            <td class="ltTbody">홍길동</td>
                            <td class="ltTbody">hongkd</td>


                            <td class="ltTbody">2025. 01 01</td>
                            <td class="ltTbody">
                                <p class="positive">정상</p>
                            </td>
                            <td class="ltTbody">2025. 01 01</td>
                            <td class="ltTbody">
                                <p class="negative">오류</p>
                            </td>

                            <td class="ltTbody">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>