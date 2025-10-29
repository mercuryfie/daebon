<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="odRoast_boxfxp">
        <table class="odRoast_Table">
            <thead>
                <tr>
                    <td class="keyCol headCol" colspan="8">생산작업지시서</td>
                </tr>
                <tr class="">
                    <td class="keyCol barcodeBox" colspan="4" rowspan="2">
                        <div id="barcodeDiv" class="barcodeArea" data-pcode="<?=$body['info_arr']['gcode']?>" style=""></div>
                        <p class="barcodeNo"><?=$body['info_arr']['gcode']?></p>
                    </td>
                    <td class="keyCol" colspan="1">등록자</td>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['writer']?></td>
                </tr>
                <tr>
                    <td class="keyCol" colspan="1">등록일</td>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['indate']?></td>
                </tr>
                <tr>
                    <td class="keyCol " >품명</td>
                    <td class="keyCol productName" colspan="3" ><?=$body['info_arr']['gname']?></td>
                    <td class="keyCol" >기준수량</td>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['tquantity']?>개</td>
                </tr>
                <tr>
                    <td class="keyCol" >생산의뢰수량</td>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['quantity']?></td>
                    <td class="keyCol" >개</td>
                    <td class="keyCol" >생산분류</td>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
                </tr>

                <tr>
                    <td class="row row1">공정명</td>
                    <td class="row row2">원료명</td>
                    <td class="row row3">입고량</td>
                    <td class="row row4">단위</td>
                    <td class="row row5" colspan="2">옵션내용</td>

                    <td class="row row6">검사확인</td>
                </tr>

                <tr>
                    <td class="row row1" rowspan="3">원자재 입고</td>
                    <td class="row row2">연근원물</td>
                    <td class="row row3">3500</td>
                    <td class="row row4">g</td>
                    <td class="row row5" colspan="2">-</td>

                    <td class="row row6"></td>
                </tr>
                <tr>
                    <td class="row row2">연근원물</td>
                    <td class="row row3">3500</td>
                    <td class="row row4">g</td>
                    <td class="row row5" colspan="2">-</td>

                    <td class="row row6"></td>
                </tr>
                <tr>
                    <td class="row row2">-</td>
                    <td class="row row3">-</td>
                    <td class="row row4">-</td>
                    <td class="row row5" colspan="2">-</td>

                    <td class="row row6"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="row subTitle" colspan="7"></td>
                </tr>
                <tr>
                    <td class="row row1">공정명</td>
                    <td class="row row2">원재료</td>
                    <td class="row row3" colspan="3">가이드</td>
                    <td class="row row4">부자재</td>

                    <td class="row row6">검사확인</td>
                </tr>
                <tr>
                    <td class="row row1">세척</td>
                    <td class="row row2">연근</td>
                    <td class="row row3 " colspan="3">
                        <p class="desc">
                            입고된 연근을 품질은 확인하고 세척기를 사용하여 정제수를 투입하고 연근을 넣고 30분 이상 사용하여
                        </p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">건조</td>
                    <td class="row row2">연근재료</td>
                    <td class="row row3 " colspan="3">
                        <p class="desc">
                            세척완료된 원물을 건조기에서 80도로 설정하고 120분간 건조시킨다. 건조중 30분 단위로 내용물을 확인 하고 한번씩 저어서 내용물이 상하로 뒤집힐수 있도록 한다.
                        </p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">분쇄</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc"></p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">로스팅<br>CCP-2B</td>
                    <td class="row row2"></td>
                    <td class="row row3 " colspan="3">
                        <p class="desc">
                            로스팅기기를 사용<br>
                            온도 : 200~250℃ / 시간 : 40~1시간 20분(min)
                        </p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">진동이물제거</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc"></p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">삼각티백<br>내외포장</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc"></p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">내포장</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc"></p>
                    </td>
                    <td class="row row2">내포장재 1000개</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">이물질검사</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc">
                            철(Fe)  :  2.0  mmɸ  이상  불검출<br>
                            스텐리스(Sus)  :  3.0  mmɸ  이상  불검출
                        </p>
                    </td>
                    <td class="row row2">-</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1">실링포장</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="3">
                        <p class="desc"></p>
                    </td>
                    <td class="row row2">실링포장재 1000개</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row3">목표완성량</td>
                    <td class="row row2">1000</td>
                </tr>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row3">실제완성량</td>
                    <td class="row row4">1,200</td>
                </tr>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row5">남은원물</td>
                    <td class="row row6">200g</td>
                </tr>
                <tr class="signArea">
                    <td class="row row1" colspan="" rowspan="">작업자 확인</td>
                    <td class="row row2">작업완료일시</td>
                    <td class="row row3">2025.01.01 12:00</td>
                    <td class="row row4" colspan="2">이름</td>
                    <td class="row row5" colspan="2">사인</td>
                </tr>
            </tbody>
        </table>
        <div class="btnBox flexType1">
            <button type="button" class="btnType1 mr10">닫기</button>
            <button type="button" class="btnType1">출력</button>
        </div>
    </div>

</section>

<?= $this->endSection() ?>