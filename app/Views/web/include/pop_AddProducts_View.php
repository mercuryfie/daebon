
<div class="addMate_wrapdej" id="addMateWrap"  name="" style="">
    <div class="addMate_conkol">
        <div class="padding_area">
            <p class="head_title" id="p_title" name="p_title"></p>
            <i class="fa-solid fa-xmark " id="Xbtn" name="Xbtn"></i>
            <div class="area area1 flexType2">
                <p class="category">분류</p>
                <select name="category" id="category" class="inputType220">
                    <option value="">선택하세요.</option>
                    <?=$body['category'];?>
                </select>
            </div>
            <div class="area area2 flexType2">
                <p class="category">이름</p>
                <input type="search" name="gname" id="gname" placeholder="예:우엉차" class="inputType220 mr10">
            </div>
            <div class="area area3 flexType2">
                <p class="category">적정수량</p>
                <input type="search" name="inventory" id="inventory" placeholder="숫자만 가능" class="inputType220 mr10 only-number">개

            </div>
            <div class="area area4 flexType2">
                <p class="category">단위용량</p>
                <input type="search" name="unit_weight" id="unit_weight" placeholder="숫자만 가능" class="inputType220 mr10 only-number">g
            </div>
            <div class="area area6 flexType2" id="tBag_box" name="tBag_box">
                <p class="category">티백 수</p>
                <input type="search" name="tBag_cnt" id="tBag_cnt" placeholder="숫자만 가능" class="inputType220 mr10 only-number">개
            </div>
            <div class="area area5 mt20 flexType5">
                <button type="button" class="btnType1 mr10" id="Xbtn2" name="Xbtn">닫기</button>
                <button type="button" class="btnType2" id="btn_pop" name="btn_pop" data-type="" data-code="">확인</button>
            </div>
        </div>
    </div>
</div>
