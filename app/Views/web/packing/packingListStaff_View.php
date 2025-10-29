<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/deliListStaff_Do.js?rnd=<?=rand();?>"> </script>
<!-- calendar ----------------------------  -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>

<script>
</script>

<section class="mainContentStaff ">
    <div class="deli_wrapghj deliStaff_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                포장목록 staff
            </p>
            <div class="left flexType2">
                <p class="progress mr10">발송완료 / 대기건수 : </p>
                <p class="progress count">30 / 80</p>
            </div>
<!--            <div class="deli_box2w9 flexType3">-->
<!--                <p class="status">전체 주문 : 100 건 / 발송 : 10 건 / 발송완료 : 10 건</p>-->
<!--                <div class="swich_boxli6 ">-->
<!--                    <i class="fa-regular fa-calendar"></i>-->
<!--                    <p class="binder"></p>-->
<!--                    <i class="fa-solid fa-list"></i>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="areaBox areaBoxStaff">
<!--            <div class="area1 flexType3">-->
<!--                <div class="left flexType2">-->
<!--                    <p class="title">기간</p>-->
<!--                    <a href="javascript:;" class="period">오늘</a>-->
<!--                    <a href="javascript:;" class="period">1주일</a>-->
<!--                    <a href="javascript:;" class="period">1개월</a>-->
<!--                    <a href="javascript:;" class="period">3개월</a>-->
<!--                    <div class="date_boxtc6 flexType2">-->
<!--                        <label for="date1" class="dateLabel1">-->
<!--                            <input type="text" id="s_date" name="date1" class="inputType160 date1" placeholder="2025/01/01" >-->
<!--                            <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>-->
<!--                        </label>-->
<!--                        <p class="wave">~</p>-->
<!--                        <label for="date2" class="dateLabel2">-->
<!--                            <input type="text" id="e_date" name="date2" class="inputType160 " placeholder="2025/12/31" >-->
<!--                            <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="right flexType1">-->
<!--                    <select name="" id="" class="btnType1 mr10">-->
<!--                        <option value="">20개씩</option>-->
<!--                        <option value="">50개씩</option>-->
<!--                        <option value="">100개씩</option>-->
<!--                    </select>-->
<!--                    <button type="button" class="btnType1">엑셀다운로드</button>-->
<!--                </div>-->
<!--            </div>-->
            <div class="area2 flexType3">
                <div class="left flexType2">
<!--                    <p class="title">검색조건</p>-->
<!--                    <select name="" id="" class="searchFilter ">-->
<!--                        <option value="">쇼핑몰</option>-->
<!--                        <option value="">옥션</option>-->
<!--                        <option value="">지마켓</option>-->
<!--                    </select>-->
<!--                    <select name="" id="" class="searchFilter">-->
<!--                        <option value="">주문번호</option>-->
<!--                        <option value="">상품번호</option>-->
<!--                        <option value="">구매자명</option>-->
<!--                        <option value="">구매자ID</option>-->
<!--                    </select>-->
                    <input type="search" name="" id="" class="searchArea" autofocus placeholder="바코드를 스캔하십시오">
                    <button type="button" class="btnType2">검색</button>
                </div>
                <div class="right flexType2">
                    <div class=" flexType2 filter_boxa6m">
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" checked>
                            <p class="text">상품준비중</p>
                        </label>
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" checked>포장중
                        </label>
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" >완료
                        </label>
                    </div>
                    <button type="button" class="btnType60 mr10">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>

                </div>
            </div>

            <div class="area4  ">
                <div class="deli_box1od flexType1">
                    <table class="deliInfoTable ">
                        <thead>
                        <tr>
                            <!--                            <td class="ltThead productNo checkCol"></td>-->
                            <th class="ltThead productNo">주문일</th>
                            <th class="ltThead productNo">송장번호</th>
                            <th class="ltThead productNo">송장등록일</th>
                            <th class="ltThead productNo">쇼핑몰</th>

                            <th class="ltThead productNo">상품명</th>
                            <th class="ltThead productNo">수량</th>
                            <th class="ltThead productNo">주문자</th>
                            <th class="ltThead productNo">수령인</th>
                            <th class="ltThead productNo">수령인 주소</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr onclick="go_packingStatusStaff();">
                            <!--                            <td class="ltTbody">-->
                            <!--                                <input type="checkbox" name="" id="">-->
                            <!--                            </td>-->
                            <td class="ltTbody">2025.01.01</td>
                            <td class="ltTbody" onclick="">13242134</td>
                            <td class="ltTbody">2025.01.01</td>
                            <td class="ltTbody">amazon</td>

                            <td class="ltTbody">ginger tea</td>
                            <td class="ltTbody">10</td>
                            <td class="ltTbody">john doe</td>
                            <td class="ltTbody">john doe</td>
                            <td class="ltTbody">GA, United States</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>