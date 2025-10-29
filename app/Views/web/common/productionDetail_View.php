<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/producingControl_Do.js?rnd=--><?php //=rand();?><!--"> </script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox producing_boxr8j">
            <p class="headTitle">
                생산현황 상세
            </p>
        </div>
        <div class="areaBox area_boxg4q ">
            <div class="elementBox flexType2">
                <div class="element flexType2 left">
                    <p class="title">작업번호</p>
                    <p class="data data1">1234</p>
                </div>
                <div class="element flexType2">
                    <p class="title">작업명</p>
                    <p class="data data1">우엉차티백 생산공정</p>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxg4q ">
            <div class="elementBox">
                <div class="element flexType2">
                    <p class="title">제품명</p>
                    <p class="data">우엉차티백</p>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxg4q sang_boxu9d">
            <div class="elementBox">
                <div class="element flexType2 prog_boxl1p">
                    <div class="left flexType2">
                        <p class="title">공정명</p>
                        <p class="data">재료배합</p>
                    </div>
                    <div class="right prog_boxo6r">
                        <div class="status_boxr5j flexType2">
                            <label for="status" class="statusLabel flexType2">
                                <input type="radio" class="status" name="status" id="" autofocus checked>대기
                            </label>
                            <label for="status" class="statusLabel flexType2">
                                <input type="radio" class="status" name="status" id="" >작업중
                            </label>
                            <label for="status" class="statusLabel flexType2">
                                <input type="radio" class="status" name="status" id="" >완료
                            </label>
                        </div>

<!--                        <div class="status_boxi3f flexType3">-->
<!--                            <p class="status standby">대기</p>-->
<!--                            <p class="status start">작업중</p>-->
<!--                            <p class="status end">완료</p>-->
<!--                        </div>-->
<!--                       <div class="prog_Box">-->
<!--                           <div class="prog_background flexType4">-->
<!--                               <div class="standbyBox flexType2 ">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox ">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox">-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                           </div>-->
<!--                       </div>-->
<!--                           <div class="prog_now flexType4" name="progNow">-->
<!--                               <div class="standbyBox  ">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox ">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox">-->
<!--                                   <p class="line"></p>-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                               <div class="standbyBox">-->
<!--                                   <i class="fa-solid fa-circle-check"></i>-->
<!--                               </div>-->
<!--                           </div>-->
<!--                           <div class=" prog_background flexType3">-->
<!--                               <div class="stanbyBox stanbyBox1 flexType1">-->
<!--                                   <p class="stanby"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox stanbyBox2 flexType1">-->
<!--                                   <p class="stanby"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox stanbyBox3 flexType1">-->
<!--                                   <p class="stanby"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox stanbyBox4 flexType1">-->
<!--                                   <p class="stanby"></p>-->
<!--                               </div>-->
<!--                           </div>-->
<!--                           <div class="prog_now" name="progNow">-->
<!--                               <div class="stanbyBox flexType1">-->
<!--                                   <p class="stanby"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox2 flexType1">-->
<!--                                   <p class="stanby2"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox2 flexType1">-->
<!--                                   <p class="stanby2"></p>-->
<!--                               </div>-->
<!--                               <div class="stanbyBox2 flexType1">-->
<!--                                   <p class="stanby2"></p>-->
<!--                               </div>-->
<!--                           </div>-->
                    </div>
                </div>

                <div class="element flexType2-1 status_boxv2l">
                    <div class="left flexType2">
                        <p class="title">저울측정</p>
                        <p class="data">50</p>
<!--                        <p class="ml10 unit">kg</p>-->
                    </div>
                    <div class="right">
                        <div class="ingBox">
                            <table class="weight_tablevufb">
                                <thead>
                                <tr>
                                    <td class="title title1">재료명</td>
                                    <td class="title">예상 입고량</td>
                                    <td class="title">실제 입고량</td>
                                    <td class="title">-</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="weight title1">우엉차</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight ">
                                        <button type="button" class="wConfirm">확인</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="weight">우엉차</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight ">
                                        <button type="button" class="wConfirm">확인</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="weight">우엉차</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight">50kg</td>
                                    <td class="weight ">
                                        <button type="button" class="wConfirm">확인</button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="elemment memo_boxb5h">
                    <textarea name="" id="" cols="" rows="" readonly placeholder="배합물의 상태를 확인한다. (건조도 확인, 용량 확인) "></textarea>
                </div>
                <div class="submitBox flexType5">
                    <button type="button" class="btnType2" onclick="go_productionStatus();">확인</button>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>