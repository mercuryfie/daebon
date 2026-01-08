<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/linkMallsLogs_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <input type="hidden" id="code" name="code" value="<?=$body['code'];?>" />
    <div class="merright1-0 linkLog_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                쇼핑몰연동-로그
            </p>
        </div>
<!--        <div class="areaBox mb10 ">-->
<!--            <div class="area1 flexType2">-->
<!--                <div class="left flexType2">-->
<!--                    <a href="javascript:;" class="period">오늘</a>-->
<!--                    <a href="javascript:;" class="period">1주일</a>-->
<!--                    <a href="javascript:;" class="period">1개월</a>-->
<!--                    <a href="javascript:;" class="period">3개월</a>-->
<!--                </div>-->
<!--                <div class="date_boxtc6 flexType2">-->
<!--                    <label for="date1" class="dateLabel1">-->
<!--                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" placeholder="2025/01/01" >-->
<!--                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>-->
<!--                    </label>-->
<!--                    <p class="wave">~</p>-->
<!--                    <label for="date2" class="dateLabel2">-->
<!--                        <input type="text" id="e_date" name="date2" class="inputType160 datepicker" placeholder="2025/12/31" >-->
<!--                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>-->
<!--                    </label>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--            <div class="area2 flexType2 areaHidden">-->
<!--                <select name="" id="" class="inputType2 selMall">-->
<!--                    <option value="">쇼핑몰선택</option>-->
<!--                    <option value="">지마켓</option>-->
<!--                    <option value="">옥션</option>-->
<!--                    <option value="">쿠팡</option>-->
<!--                </select>-->
<!---->
<!--            </div>-->
<!--        </div>-->
        <div class="areaBox pb100">
            <div class="area3 mb10">
                <button type="button" class="btnType1" id="btn_show">목록보기</button>
            </div>
            <div class="area4 ">
                <table class="linkMallsTable ">
                    <thead>
                        <tr>
                            <td class="ltThead col2">쇼핑몰명</td>
<!--                                <td class="ltThead">쇼핑몰</td>-->
                            <td class="ltThead">Status</td>
                            <td class="ltThead">내용(log)</td>
                            <td class="ltThead">날짜</td>
                        </tr>
                    </thead>
                    <tbody id="tList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>