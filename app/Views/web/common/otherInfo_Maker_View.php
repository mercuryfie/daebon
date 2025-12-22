<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/otherInfoMaker_Do.js?rnd=<?=rand();?>"> </script>

<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="oinfo_box23e">
        <div class="titleBox">
            <p class="headTitle">
                기타정보관리
            </p>
        </div>
        <div class="areaBox  ">
            <div class="area1 flexType2">
                <button type="button" class="tab" onclick="go_otherInfo_Maker();">제조사관리</button>
                <button type="button" class="tab" onclick="go_otherInfo_Supplier();">공급사관리</button>
<!--                <button type="button" class="tab">ㅇㅇ관리</button>-->
<!--                <button type="button" class="tab">ㅇㅇ관리</button>-->
<!--                <button type="button" class="tab">ㅇㅇ관리</button>-->

<!--                <p class="title">제품정보</p>-->
<!--                <div class="right flexType1">-->
<!--                    <i class="fa-solid fa-angle-down"></i>-->
<!--                </div>-->
            </div>
            <div class="area2 flexType3">
                <div class="left flexType2">
                    <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="통합 검색">
                    <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                </div>
                <div class="flexType2">
                    <input type="file" id="attachExcel" name="attachExcel" accept=".xlsx,.xls" style="display:none;">
                    <button type="button" class="btnType1 mr10" id="execlUp" name="execlUp">엑셀업로드</button>
<!--                    <button type="button" class="btnType1 mr10">엑셀다운로드</button>-->
                    <button class="btnType2 " id="addMaker" name="addMaker" onclick="add_Maker();">제조사 등록</button>

                </div>

            </div>
            <div class="area3 area_box2qd ">
                <div class="elBox">
                    <div class="element element1 flexType2">
                        <p class="text ttl mr10">총</p>
                        <p class="text data fontType4 mr10" id="tcnt" data-cnt="0"></p>
                        <p class="text unit">건</p>
                    </div>
                    <div class="element element2">
                        <table class="fac_tablexx9" >
                            <thead>
                            <tr>
                                <th>제조사코드</th>
                                <th>제조사</th>
                                <th>위치</th>
                                <th>삭제</th>
                            </tr>
                            </thead>
                            <tbody name="mList" id="mList">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="area lastArea flexType1 pb100" id="cpage" name="cpage" data-page="1">
                <p class="more mr10">더보기</p>
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </div>
<!--        <div class="lastBox flexType5">-->
<!--            <button type="button" class="btnType1 mr10">취소</button>-->
<!--            <button type="button" id="submitBtn" name="submitBtn" class="btnType2" >확인</button>-->
<!--        </div>-->
    </div>

</section>

<?= $this->include('/web/include/pop_AddMaker_View'); ?>
<?= $this->endSection() ?>