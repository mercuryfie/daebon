<div class="out_wrapiaj" id="outWrap" name="" style="">
    <input type="hidden" id="pop_omtcode" name="pop_omtcode" />
    <div class="out_conrlo chulgo_box">
        <div class="padding_area">
            <p class="head_title" id="">출고하기</p>
            <i class="fa-solid fa-xmark " id="Xbtn" name="Xbtn"></i>
            <div class="area area1 flexType2">
                <div class="copyArea copyArea1 flexType2">
                    <p class="category ">검색</p>
                    <input type="search" class="inputBorder " id="txt_pop_output" name="txt_pop_output" placeholder="검색어 입력후 Enter" onfocus="">
<!--                    <button type="button"><i class="fa-solid fa-caret-down copyDropdown"></i></button>-->
                </div>
                <div class="copyArea copyArea2 mr10 flexCol" id="outputlist" name="outputlist">
                </div>
            </div>
            <div class="area area2 flexType2">
                <p class="category">구분</p>
                <p class="merName" id="o_mttype" name="o_mttype"></p>
            </div>
            <div class="area area2 flexType2">
                <p class="category">원재료코드</p>
                <p class="merName" id="o_mtcode" name="o_mtcode"></p>
            </div>
            <div class="area area2 flexType2">
                <p class="category">원재료명</p>
                <p class="merName" id="o_mtname" name="o_mtname"></p>
            </div>
            <div class="area area2 flexType2">
                <p class="category">제조사</p>
                <p class="merName" id="o_mtmaker" name="o_mtmaker"></p>
            </div>
            <div class="area area2 flexType2">
                <p class="category">기본공급사</p>
                <p class="merName" id="o_mtsupplier" name="o_mtsupplier"></p>
            </div>
            <div class="area area3 flexType2">
                <p class="category">출고사유</p>
                <select name="o_reason" id="o_reason" class="inputBorder">
                    <option value="">선택</option>
                    <option value="1">판매</option>
                    <option value="2">폐기</option>
                    <option value="3">반품</option>
                    <option value="4">기타</option>
                </select>
            </div>

            <div class="area area4 flexType2">
                <p class="category">출고수량</p>
                <input type="search" name="txt_pop_outcome" id="txt_pop_outcome" placeholder="숫자만 입력하세요." class="inputBorder mr10">
                <p class="unit" id="pop_ounit" name="pop_ounit"></p>

            </div>
            <div class="area area6 flexType4">
                <p class="category">출고 메모</p>
                <textarea name="txt_omtmemo" id="txt_omtmemo" cols="30" rows="10" class="content"></textarea>
            </div>
            <div class="area lastArea mt20 flexType5">
                <button type="button" class="btnType1 mr10" id="Xbtn2" name="Xbtn">닫기</button>
                <button type="button" class="btnType2" id="btn_outcome">확인</button>

            </div>
        </div>
    </div>
</div>
