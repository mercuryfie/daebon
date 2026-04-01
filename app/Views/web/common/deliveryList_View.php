<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/deliveryList_Do.js?rnd=<?= rand(); ?>"></script>

<script>
</script>

<section class="merright">
    <div class="deli_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                배송목록
            </p> 
        </div>
        <div class="areaBox mb10 ">
            <div class="area1 flexType3">
                <div class="left flexType2">
<!--                        <p class="title">기간</p>-->
                    <a href="javascript:;" class="period active">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
<!--                    <a href="javascript:;" class="period">전체</a>-->
                    <div class="date_boxtc6 flexType2 ml10">
                        <label for="date1" class="dateLabel1">
                            <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" >
                            <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                        </label>
                        <p class="wave">~</p>
                        <label for="date2" class="dateLabel2">
                            <input type="text" id="e_date" name="date2" class="inputType160 datepicker" >
                            <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                        </label>
                    </div>
                </div>
            </div>
            <div class="area2 ">
                <div class="left flexType2">
                    <select name="select_typ" id="select_typ" class="btnType1 mr10 ">
                        <option value="">검색조건</option>
                        <option value="1">송장번호</option>
                        <option value="2">수취인 이름</option>
                        <option value="3">수취인 전화번호</option>
                        <option value="4">쇼핑몰 주문번호</option>
                    </select>
                    <input type="search" name="stxt" id="stxt" class="searchArea" placeholder="검색어 입력">
                    <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                </div>
            </div>
        </div>
        <div class="areaBox pb100 min70vh">
            <div class="flexType3 mt10">
                <div class="left ml20">
<!--                    <p class="status">전체 주문 : 100 건 | 발송 : 10 건 | 발송완료 : 10 건</p>-->
                </div>
                <div class="right">
                    <button type="button" class="btnType1 mr60">엑셀다운로드</button>
                </div>
            </div>
            <div class="area4 ">
                <div class="common_tbl_wrap ml20 mt20">
                    <table class="common_tbl  ">
                        <thead>
                        <tr>
                            <th class="ltThead productNo">쇼핑몰</th>
                            <th class="ltThead productNo">쇼핑몰주문번호</th>
                            <th class="ltThead productNo">송장번호</th>
                            <th class="ltThead productNo">송장등록일</th>
                            <th class="ltThead productNo">주문일</th>
                            <th class="ltThead productNo">상품명</th>
                            <th class="ltThead productNo">수량</th>
                            <th class="ltThead productNo">수령인</th>
                            <th class="ltThead productNo">수령인 전화번호</th>
                            <th class="ltThead productNo">수령인 주소</th>
                        </tr>
                        </thead>
                        <tbody id="cList">

                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div class="area lastArea flexType1 mt20" id="cpage" name="cpage" data-page="1">-->
<!--                <p class="more mr10">더보기</p>-->
<!--                <i class="fa-solid fa-angle-down"></i>-->
<!--            </div>-->
        </div>
    </div>

</section>

<?= $this->endSection() ?>