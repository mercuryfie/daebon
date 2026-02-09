
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
            <div class="area area1 flexType2">
                <p class="category">기본단위</p>
                <select id="unit_typ" name="unit_typ" class="inputType220">
                    <option value="">선택하세요.</option>
                    <option value="kg">kg</option>
                    <option value="g">g</option>
                    <option value="개">개</option>
                </select>
            </div>
            <div class="area area3 flexType2">
                <p class="category">적정용량(수량)</p>
                <input type="search" name="inventory" id="inventory" placeholder="숫자만 가능" class="inputType220 mr10 only-number"><span name="u_type1"></span>
            </div>
            <div class="area area4 flexType2">
                <p class="category">단위용량</p>
                <input type="search" name="unit_weight" id="unit_weight" placeholder="숫자만 가능" class="inputType220 mr10 only-number"><span name="u_type2"></span>
            </div>
            <div class="area area6 flexType2" >
                <p class="category" >제품용량(수량)</p>
                <input type="search" name="total_weight" id="total_weight" placeholder="숫자만 가능" class="inputType220 mr10 only-number"><span name="u_type1"></span>
            </div>
            <div class="area lastArea mt20 flexType5">
                <button type="button" class="btnType1 mr10" id="Xbtn2" name="Xbtn">닫기</button>
                <button type="button" class="btnType2" id="btn_pop" name="btn_pop" data-type="" data-code="">확인</button>
            </div>
        </div>
    </div>
</div>
