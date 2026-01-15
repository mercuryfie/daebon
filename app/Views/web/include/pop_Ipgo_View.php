

<script src="<?=URL_COMMON_ASSETS?>/inoutMaterial_Do.js?rnd=<?=rand();?>"> </script>

<div class="ipgo_wrapdej" id="ipgoWrap"  name="" style="">
    <div class="ipgo_conkol ipgo_box">
        <div class="padding_area">
            <p class="head_title" id="">입고하기</p>
            <i class="fa-solid fa-xmark " id="Xbtn" name="Xbtn"></i>
            <div class="area area1 flexType2">
<!--                <input type="search" name="" id="" placeholder="예:우엉차20g" class="schInput mr10">-->
<!--                <button type="button" class="btnType1" name="search_mat" id="search_mat">검색</button>-->

                <div class="copyArea copyArea1 flexType2">
                    <p class="category ">검색</p>
                    <input type="search" class="copySearch " id="txt_before" name="txt_before" placeholder="원재료명+엔터" onfocus="">
                    <button class="copyDropdown" type="button" id="btn_before" name="btn_before"> <i class="fas fa-caret-down"></i></button>
                </div>
                <div class="copyArea copyArea2  mr10 flexCol" id="beforelist" name="beforelist">
                </div>
            </div>
            <div class="area area2 flexType2 fs14">
                <p class="category ">구분</p>
                <p class="merName" id="cat_data" name="cat_data">12341234</p>
            </div>
            <div class="area area3 flexType2 fs14">
                <p class="category ">원재료코드</p>
                <p class="merName" id="m_code" name="m_code">12341234</p>
            </div>
            <div class="area area4 flexType2 fs14">
                <p class="category ">원재료명</p>
                <p class="merName " id="m_name" name="m_name">허브(농산물)</p>
            </div>
            <div class="area area5 flexType2 fs14">
                <p class="category">제조사</p>
                <p class="merName" id="m_maker" name="m_maker">ㅇㅇ제조사</p>
            </div>
            <div class="area area6 flexType2 fs14">
                <p class="category">기본공급사</p>
                <p class="merName" id="m_supplier" name="m_supplier">ㅇㅇ공급사</p>
            </div>
            <div class="area area7 flexType2 fs14">
                <p class="category">실제 공급사</p>
                <div class="flexCol">
                    <select name="" id="supply" class="inputType220" >
                        <option value="">자체</option>
<!--                        <option value="bySelf">직접입력</option>-->
                        <option value="">OEM</option>
                        <option value="">농산물센터</option>
                        <option value="">기타</option>
                    </select>
                </div>
            </div>
            <div class="area area8 flexType2 fs14">
                <p class="category">입고수량</p>
                <input type="search" name="" id="" placeholder="예:10" class="inputType220 mr10">
<!--                <p class="unit">개</p>-->
            </div>
            <div class="area area9 flexType2 fs14">
                <p class="category">원자재단위</p>
                <select name="unit" id="unit" class="inputType220">
                    <option value="">선택하세요.</option>
                    <option value="">기타</option>
                </select>
            </div>
            <div class="area area11 flexType4 fs14">
                <p class="category">입출고 메모</p>
                <textarea name="" id="" cols="30" rows="5" class="content" placeholder="메모를 남기십시오." ></textarea>
            </div>
            <div class="area lastArea mt20 flexType5">
                <button type="button" class="btnType1 mr10" id="Xbtn2" name="Xbtn">닫기</button>
                <button type="button" class="btnType2">확인</button>

            </div>
        </div>
    </div>
</div>
