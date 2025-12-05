<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/deliList_Do.js?rnd=<?= rand(); ?>"></script>

<script>
</script>

<section class="merright">
    <div class="deli_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                배송목록
            </p> 
        </div>
        <div class="areaBox mb10">
            <div class="area1 flexType3">
                <div class="left flexType2">
<!--                        <p class="title">기간</p>-->
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
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
            </div>
            <div class="area2 ">
                <div class="left flexType2">
                    <input type="search" name="" id="" class="searchArea" placeholder="통합검색어 입력">
                    <button type="button" class="btnType1">검색</button>
                </div>
            </div>
        </div>
        <div class="areaBox pb100">
            <div class="flexType3 mt10">
                <div class="left ml20">
                    <p class="status">전체 주문 : 100 건 | 발송 : 10 건 | 발송완료 : 10 건</p>
                </div>
                <div class="right">
                    <select name="" id="" class="btnType1 mr10 ">
                        <option value="">전체마켓</option>
                        <option value="">옥션</option>
                        <option value="">지마켓</option>
                    </select>
                    <select name="" id="" class="btnType1 mr10">
                        <option value="">20개씩</option>
                        <option value="">50개씩</option>
                        <option value="">100개씩</option>
                    </select>
                    <button type="button" class="btnType1 mr10">엑셀다운로드</button>
                    <button type="button" class="btnType1 mr20">초기화</button>
                </div>
            </div>
            <div class="area4 ">
                <div class="deli_box1od">
                    <table class="deliInfoTable ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead productNo">송장번호</td>
                            <td class="ltThead productNo">송장등록일</td>
                            <td class="ltThead productNo">주문일</td>
                            <td class="ltThead productNo">쇼핑몰</td>

                            <td class="ltThead productNo">상품명</td>
                            <td class="ltThead productNo">수량</td>
                            <td class="ltThead productNo">주문자</td>
                            <td class="ltThead productNo">수령인</td>
                            <td class="ltThead productNo">수령인 주소</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="ltTbody">
                                <input type="checkbox" name="" id="">
                            </td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>

                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>