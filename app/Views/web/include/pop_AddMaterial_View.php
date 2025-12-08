<div class="addMate_wrapdej" id="addMateWrap"  name="" style="">
    <div class="addMate_conkol">
        <div class="padding_area">
            <p class="head_title" id="p_title" name="p_title"></p>
            <i class="fa-solid fa-xmark " id="Xbtn" name="Xbtn"></i>
            <div class="area area1 flexType2">
                <p class="category">구분</p>
                <select name="division" id="division" class="inputType220">
                    <option value="">선택하세요.</option>
                    <?=$main['material'];?>
                </select>
            </div>
            <div class="area area2 flexType2">
                <p class="category">이름</p>
                <input type="search" name="mname" id="mname" placeholder="예:우엉차" class="inputType220 mr10">

            </div>

            <div class="area area3 flexType2">
                <p class="category">제조사</p>
                <select name="maker" id="maker" class="inputType220 ">
                    <option value="">선택하세요.</option>
                    <option value="bySelf">직접입력</option>
                    <?=$main['maker'];?>
                </select>
                <input type="search" name="makeCom" id="makeCom" placeholder="회사이름"
                       class="inputType220 mr10" style="display:none;">
            </div>
            <div class="area area4 flexType2">
                <p class="category">공급사</p>
                <select name="supply" id="supply" class="inputType220 ">
                    <option value="">선택하세요.</option>
                    <option value="bySelf">직접입력</option>
                    <?=$main['supply'];?>
                </select>
                <input type="search" name="suppCom" id="suppCom" placeholder="회사이름"
                       class="inputType220 mr10" style="display:none;">
            </div>
            <div class="area area2 flexType2">
                <p class="category">적정재고량</p>
                <input type="search" name="suppCom" id="suppCom" placeholder="1000(숫자만입력)" class="inputType220 mr10">

            </div>
            <div class="area area6 flexType2">
                <p class="category">원자재단위</p>
                <select name="unit" id="unit" class="inputType220">
                    <option value="">선택하세요.</option>
                    <?=$main['unit'];?>
                </select>
            </div>
            <div class="area area5 mt20 flexType5">
                <button type="button" class="btnType1 mr10" id="Xbtn2" name="Xbtn">닫기</button>
                <button type="button" class="btnType2" id="btn_pop" name="btn_pop" data-type="" data-code="">확인</button>

            </div>
        </div>
    </div>
</div>
