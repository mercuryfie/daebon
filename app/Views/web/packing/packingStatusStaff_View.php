<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/packingProcessStaff_Do.js?rnd=<?=rand();?>"> </script>

<section class="mainContentStaff ">
    <input type="hidden" id="p_status" name="p_status" value="<?=$body['info']['p_status'];?>" />
    <input type="hidden" id="orstep" name="orstep" value="<?=$body['order']['orstep'];?>" />
    <div class="pack_status_wrap">
        <div class="titleBox">
<!--            <p class="headTitle">-->
<!--                포장발송화면 / 상품확인dd-->
<!--            </p>-->
        </div>
        <div class="pack_status_box">
            <div class="area area5 flexType3-1 ">
                <div class="progress_boxatq flexType2-1">
                    <p class='title'>작업상태</p>
                    <div class="flexType2">
                        <div class="progress flexCol2">
                            <button class="squareType2" id="p_status1" name="p_status1">
                                <i class="fa-solid fa-print"></i>
                            </button>
                            <p class="status">포장중</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2" id="p_status2" name="p_status2">
                                <i class="fa-solid fa-receipt"></i>
                            </button>
                            <p class="status">송장출력</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2" id="p_status3" name="p_status3">
                                <i class="fa-solid fa-box-open"></i>
                            </button>
                            <p class="status">포장완료</p>
                        </div>
                    </div>

                </div>
                <div class="right flexType5-2" id="delicode_button">
            <?if($body['info']['deli_code']!=''){?>
                <?if($body['order']['orstep']==2){?>
                    <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('<?=$body['order']['orcode'];?>','');">송장<br>재출력</button>
                <?}else{?>
                    <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('<?=$body['order']['orcode'];?>','New');">송장<br>추가출력</button>
                    <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('<?=$body['order']['orcode'];?>','');">송장<br>재출력</button>
                <?}?>
            <?}else{?>
                    <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('<?=$body['order']['orcode'];?>','');">송장<br>출력</button>
            <?}?>
                </div>
            </div>
            <div class="area area1 flexType4">
                <div class="inner left">
                    <p class='title'>상품정보/수량 확인</p>
                    <div class="productCheck_boxarv">
                        <div class="productCheck flexType2">
                            <p class="category">포장코드</p>
                            <p class="data"><?=$body['opcode'];?></p>
                        </div>
                        <div class="productCheck flexType2">
                            <p class="category">주문번호</p>
                            <p class="data"><pre><?=$body['order_str'];?></pre></p>
                        </div>
                        <div class="productCheck flexType2">
                            <p class="category">송장번호</p>
                            <p class="data" id="packing_delicode" name="packing_delicode"><?=fn_formatInvoiceNumber($body['info']['deli_code']);?></p>
                        </div>

                        <div class="productCheck flexType2">
                            <p class="category">주소지</p>
                            <p class="data"><?=$body['order']['receive_zipcode'];?> <?=$body['order']['receive_address1'];?> <?=$body['order']['receive_address2'];?></p>
                        </div>
                        <div class="productCheck flexType2">
                            <p class="category">수량</p>
                            <p class="data">총 <?=$body['tCnt'];?>건</p>
                        </div>
                    </div>
                </div>
                <div class="inner imgBox_box2ck" id="check_product">
                <?foreach($body['product'] as $d){?>
                    <div class="prod_box flexType2" name="btn_noirbox" data-choice="0">
                       <div class="thumBox">
                           <div class="doneBox flexType1" name="noir_active">
                               <div class="checkBox flexType1">
                                   <i class="fa-solid fa-check "></i>
                               </div>

                           </div>
                           <div class="imgBox">
                               <img src="/assets/web/src/packing_1.png" alt="img" class="">
                           </div>
                       </div>
                        <p class="ttl mr10"><?=$d['pdname'];?></p>
                        <p class="count"><?=$d['gcnt'];?> 봉</p>
                    </div>
                <?}?>
                </div>
            </div>
            <div class="area area3 flexType4" >
                <p class="title">포장과정 촬영</p>
            <?if($body['order']['orstep']==2){?>
                <div class="imgBox_boxdzu pack_staff_imgbox flexType2" name="">
                <?foreach($body['image'] as $url){?>
                    <div class="dashedLayer">
                        <p class="inputArea"><image src="https://daebon.djmedi.net<?=$url;?>" /></p>
                    </div>
                <?}?>
                </div>
            <?}else{?>
                <p class="category unsupported_cam" id="unsupported_cam"></p>
                <div class="imgBox_boxdzu flexType2" name="" id="cam_area">
                    <div class="planeLayer">
                        <div class="noir" id="pick"></div>
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
                </div>
            <?}?>
<!--                    <div class="btnBox">-->
<!--                        <button type="button" class="btn cam_btn" id="btn_prn">촬영</button>-->
<!--                    </div>-->

<!--                <div class="lastBox flexType5 ">-->
<!--                    <button type="button" class="btn80Type1 mr10" onclick="go_packingListStaff();">이전</button>-->
<!--                    <button type="button" class="btn80Type2">완료</button>-->
<!---->
<!--                </div>-->

            </div>
            <div class="area lastArea flexType5-1">
                <button type="button" class="btn80Type1 mr10" onclick="go_packingListStaff();">목록</button>
                <?if($body['order']['orstep']<2){?>
                <button type="button" class="btn80Type2" id="btn_complete" data-opcode="<?=$body['opcode'];?>" data-orcode="<?=$body['order']['orcode'];?>">완료</button>
                <?}?>
            </div>

        </div>
    </div>
</section>

<?= $this->include('/web/include/pop_MagImg_View'); ?>
<?= $this->endSection() ?>