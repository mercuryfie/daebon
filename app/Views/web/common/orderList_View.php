<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/orderList_Do.js?rnd=<?= rand(); ?>"></script>
<script>
</script>

<section class="merright">
    <div class="order_box28f">
        <div class="titleBox">
            <p class="headTitle">
                주문목록
            </p>
        </div>
        <div class="swich_boxli6 ">
            <i class="fa-regular fa-calendar" onclick="go_dashboard();"></i>
            <p class="binder"></p>
            <i class="fa-solid fa-list" onclick="go_orderList();"></i>
        </div>
        <div class="areaBox areaBox1 mb10">
            <div class="status_boxi3f flexType2">
                <div class="progress flexType2">
                    <button class="squareType ">
                        <i class="fa-regular fa-square-check"></i>
                    </button>
                    <div class="right ">
                        <p class="status">전체</p>
                        <div class="countBox flexType2">
                            <p class="count">10</p>
                            <p class="unit">건</p>
                        </div>
                    </div>
                </div>
                <div class="progress flexType2">
                    <button class="squareType2">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </button>
                    <div class="right ">
                        <p class="status">재고 10개 이하</p>
                        <div class="countBox flexType2">
                            <p class="count">10</p>
                            <p class="unit">건</p>
                        </div>
                    </div>
                </div>
                <div class="progress flexType2">
                    <button class="squareType2">
                        <i class="fa-solid fa-chart-line"></i>
                    </button>
                    <div class="right ">
                        <p class="status">주간 평균판매량</p>
                        <div class="countBox flexType2">
                            <p class="count">10</p>
                            <p class="unit">건</p>
                        </div>
                    </div>
                </div>
                <div class="progress flexType2">
                    <button class="squareType2">
                        <i class="fa-solid fa-chart-line"></i>
                    </button>
                    <div class="right">
                        <p class="status">월간 평균판매량</p>
                        <div class="countBox flexType2">
                            <p class="count">10</p>
                            <p class="unit">건</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="area1 flexType2">
                <div class="left flexType2">
<!--                        <p class="title">기간</p>-->
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
                </div>
                <div class="date_boxtc6 flexType2">
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" placeholder="2025/01/01" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                    <p class="wave">~</p>
                    <label for="date2" class="dateLabel2">
                        <input type="text" id="e_date" name="date2" class="inputType160 datepicker" placeholder="2025/12/31" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                    </label>
                </div>

            </div>
            <div class="area2 flexType3">
                <div class="left flexType2">
<!--                        <p class="title">검색조건</p>-->
<!--                        <select name="" id="" class="searchFilter ">-->
<!--                            <option value="">상태필터</option>-->
<!--                            <option value="">등록대기</option>-->
<!--                            <option value="">작업대기</option>-->
<!--                            <option value="">작업중</option>-->
<!--                            <option value="">작업완료</option>-->
<!--                        </select>-->
<!--                    <select name="" id="" class="searchFilter">-->
<!--                        <option value="">주문번호</option>-->
<!--                        <option value="">상품번호</option>-->
<!--                        <option value="">구매자명</option>-->
<!--                        <option value="">구매자ID</option>-->
<!--                    </select>-->
                    <input type="search" name="" id="" class="searchArea" placeholder="통합 검색">
                    <button type="button" class="btnType1">검색</button>
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>등록대기
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >작업대기
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >작업중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >완료
                    </label>
                </div>
            </div>
        </div>
        <div class="areaBox areaBox2 pb100">
            <div class="area3 flexType3 mr20 mt10 ">
                <div class="left performStatusBox">
                    <p class="performStatus status1">전체 주문: 16건 | 작업중 16건 | 발송완료 14건 | 취소: 000건</p>
                    <p class="performStatus status2">옥션1: 000건,  옥션2 : 004건, 지마켓: 002건  농협몰:  010건 </p>
                </div>
                <div class="right">
                    <button type="button" class="btnType1 mr10" onclick="add_packingQueue();">묶음배송</button>
                    <button type="button" class="btnType1 mr10" onclick="upload_Xlx();">엑셀업로드</button>
                    <button type="button" class="btnType1 mr10">엑셀다운로드</button>
                    <button type="button" class="btnType2" onclick="go_orderRegister();">주문등록</button>
                </div>
            </div>
            <div class="area4 order_boxfxp">
                <div class="table_scroll">
                    <table class="order_tabledj1 ">
                        <thead class="tbl_head">
                        <tr>
                            <td class="ltThead fixedCol checkCol td40">-</td>
                            <td class="ltThead fixedCol" onclick=""><div class="inner1"><p class="text">진행상태</p></div></td>
                            <td class="ltThead fixedCol"><div class="inner1"><p class="text">등록</p></div></td>
                            <td class="ltThead fixedCol"><div class="inner2"><p class="text">주문번호</p></div></td>
                            <td class="ltThead fixedCol"><div class="inner2 last_inner"><p class="text">상품번호</p></div></td>

                            <td class="ltThead scrollableCol">판매자ID<div class="resize-handle"></div></td>
                            <td class="ltThead scrollableCol">구매자ID</td>
                            <td class="ltThead scrollableCol">상품명</td>
                            <td class="ltThead scrollableCol">구매자명</td>
                            <td class="ltThead scrollableCol">수신인명</td>

                            <td class="ltThead scrollableCol">구매금액</td>
                            <td class="ltThead scrollableCol">수량</td>
                            <td class="ltThead scrollableCol">송장출력일</td>
                            <td class="ltThead scrollableCol">등록일</td>
                            <td class="ltThead scrollableCol">비고</td>
                        </tr>
                        </thead>
                        <tbody id="cList" name="cList">
<!--                        <tr class="">-->
<!--                            <td class="ltTbody td40 fixedCol">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!---->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltThead productNo fixedCol" onclick="add_packingQueue();">-->
<!--                                <button type="button" class="btnType4">등록대기</button>-->
<!--                            </td>-->
<!--                            <td class="ltTbody scrollableCol">우엉차</td>-->
<!--                            <td class="ltTbody scrollableCol">홍길동</td>-->
<!--                            <td class="ltTbody scrollableCol">홍길동</td>-->
<!--                            <td class="ltTbody scrollableCol">10,000</td>-->
<!--                            <td class="ltTbody scrollableCol">10</td>-->
<!---->
<!--                            <td class="ltTbody scrollableCol">2025.01.01</td>-->
<!--                            <td class="ltTbody scrollableCol">2025.01.01</td>-->
<!--                            <td class="ltTbody scrollableCol">엑셀</td>-->
<!--                            <td class="ltTbody scrollableCol">-</td>-->
<!--                        </tr>-->
<!--                        <tr class="">-->
<!--                            <td class="ltTbody td40 fixedCol">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!---->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltThead productNo fixedCol" onclick="add_packingQueue();">-->
<!--                                <button type="button" class="btnType4">등록대기</button>-->
<!--                            </td>-->
<!--                            <td class="ltTbody scrollableCol">우엉차</td>-->
<!--                            <td class="ltTbody scrollableCol">홍길동</td>-->
<!--                            <td class="ltTbody scrollableCol">홍길동</td>-->
<!--                            <td class="ltTbody scrollableCol">10,000</td>-->
<!--                            <td class="ltTbody scrollableCol">10</td>-->
<!---->
<!--                            <td class="ltTbody scrollableCol">2025.01.01</td>-->
<!--                            <td class="ltTbody scrollableCol">2025.01.01</td>-->
<!--                            <td class="ltTbody scrollableCol">엑셀</td>-->
<!--                            <td class="ltTbody scrollableCol">-</td>-->
<!--                        </tr>-->
<!--                        <tr class="">-->
<!--                            <td class="ltTbody td40 fixedCol">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!--                            <td class="ltTbody fixedCol">abcabc</td>-->
<!---->
<!--                            <td class="ltTbody fixedCol">12341234</td>-->
<!--                            <td class="ltThead productNo fixedCol" onclick="add_packingQueue();">-->
<!--                                <button type="button" class="btnType4">등록대기</button>-->
<!--                            </td>-->
<!--                            <td class="ltTbody">우엉차</td>-->
<!--                            <td class="ltTbody">홍길동</td>-->
<!--                            <td class="ltTbody">홍길동</td>-->
<!--                            <td class="ltTbody">10,000</td>-->
<!--                            <td class="ltTbody">10</td>-->
<!---->
<!--                            <td class="ltTbody">2025.01.01</td>-->
<!--                            <td class="ltTbody">2025.01.01</td>-->
<!--                            <td class="ltTbody">엑셀</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                        </tr>-->

                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">-->
<!--                <p class="more mr10">더보기</p>-->
<!--                <i class="fa-solid fa-angle-down"></i>-->
<!--            </div>-->
        </div>
    </div>
</section>

<?= $this->include('/web/include/pop_AddOrder_View'); ?>
<?= $this->include('/web/include/pop_AddPackingQueue_View'); ?>
<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?php //= $this->include('/web/include/pop_AddOrder_View'); ?>
<?= $this->endSection() ?>