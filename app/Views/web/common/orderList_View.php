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
<!--        <div class="swich_boxli6 ">-->
<!--            <i class="fa-regular fa-calendar" onclick="go_main();"></i>-->
<!--            <p class="binder"></p>-->
<!--            <i class="fa-solid fa-list" onclick="go_orderList();"></i>-->
<!--        </div>-->
        <div class="areaBox areaBox1 flexType3">
            <div class="area1 flexType2">
                <div class="left2 flexType2">
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
            <button type="button" class="btnType2 mr20" onclick="go_orderRegister();">주문등록</button>
        </div>
        <div class="areaBox areaBox2 pb100 min70vh">
            <div class="area2 flexType3  mt10 ">
                <div class="left flexType2">
                    <input type="search" name="skey" id="skey" class="searchArea" placeholder="주문번호,이름,연락처로 검색">
                    <button type="button" class="btnType1" id="btn_sch" name="btn_sch">검색</button>
                </div>
                <div class="right">
<!--                    <button type="button" class="btnType1 mr10" id="btn_orderconfirm">주문확인</button>-->
                    <button type="button" class="btnType1 mr10" id="btn_ininstruct">개별포장지시</button>
                    <button type="button" class="btnType1 mr10" id="btn_package">묶음포장지시</button>
                    <button type="button" class="btnType1 mr10" onclick="upload_Xlx();">엑셀업로드</button>
                    <button type="button" class="btnType1 mr10">엑셀 다운</button>
                    <button type="button" class="btnType1 " onclick="template_Download();">양식 다운</button>
                </div>
            </div>
            <div class="area2 ">
                <div class="order_list_tbl_wrap">
                    <table class="order_list_tbl ">
                        <thead class="tbl_head">
                        <tr>
                            <th class="ltThead fixedCol checkCol td40"><div class="inner40 flexCol2"><p class="text">-</p></div></th>
                            <th class="ltThead fixedCol" onclick=""><div class="inner1 flexCol2"><p class="text">진행상태</p></div></th>
                            <th class="ltThead fixedCol"><div class="inner2 flexCol2"><p class="text">MES 주문번호</p><p class="text">마켓 주문번호</p></div></th>
                            <th class="ltThead fixedCol"><div class="inner2 flexCol2 last_inner"><p class="text">MES 상품번호</p><p class="text">마켓 상품번호</p></div></th>

                            <th class="ltThead scrollableCol"><div class="inner4 g_name flexCol2"><p class="text">상품명</p></div></th>
                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2 fs14"><p class="text">구매자명</p><p class="text">연락처</p><p class="text">수취인명</p><p class="text">연락처</p></div></th>
                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2 "><p class="text">수량</p><p class="text">총액</p></div></th>
                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2 "><p class="text">주문일자</p></div></th>

                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2"><p class="text">배송지시일</p></div></th>
                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2"><p class="text">등록</p></div></th>
                            <th class="ltThead scrollableCol"><div class="inner4 flexCol2"><p class="text">연동정보</p></div></th>
                            <th class="ltThead scrollableCol">주문확인</th>
                            <th class="ltThead scrollableCol">주문취소</th>
                        </tr>
                        </thead>
                        <tbody id="cList" name="cList">
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
<?= $this->include('/web/include/pop_UploadExcel_View'); ?>
<?= $this->endSection() ?>