<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<link href="/assets/web/src/smarteditor/css/ko_KR/smart_editor2.css?rnd=<?=rand();?>" rel="stylesheet" type="text/css" />
<!--<link href="/assets/web/src/smarteditor/css/ko_KR/smart_editor2_in.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/assets/web/src/smarteditor/css/ko_KR/smart_editor2_items.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/assets/web/src/smarteditor/css/ko_KR/smart_editor2_out.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="/assets/web/src/smarteditor/js/service/HuskyEZCreator.js" charset="utf-8"></script>

<script src="<?=URL_COMMON_ASSETS?>/noticeRegister_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright">
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                공지사항 글쓰기
            </p>
        </div>
        <div class="areaBox notice_list_box ">
            <div class="area area1 ">
<!--                    <label for="add_msg" class="checkType flexType2">-->
<!--                        <input type="checkbox" id="dd" name="add_msg" class="add_msg"><p class="text">대시보드 등록</p>-->
<!--                    </label>-->
                <div class="selBox flexType2">
                    <select name="is_fixed" id="is_fixed" class="inputBorder mr10" required>
                        <option value="" disabled >게시타입</option>
                        <option value="0" selected>일반</option>
                        <option value="1">공지</option>
                    </select>
                    <select name="is_notice" id="is_notice" class="inputBorder mr10" required>
                        <option value="" disabled>전광판 노출</option>
                        <option value="0" selected>안 함</option>
                        <option value="1"  >노출</option>
                    </select>
                    <p class="msg">※ 전광판은 제목만 노출됩니다. </p>
<!--                        <label for="add_msg" class="checkType flexType2">-->
<!--                            <input type="checkbox" id="dd" name="add_msg" class="add_msg"><p class="text">대시보드 등록</p>-->
<!--                        </label>-->
                </div>
                <div class="titleBox">
                    <input type="search" placeholder="제목을 입력하십시오" class="title" id="n_title" name="n_title">
                </div>

                <textarea name="ir1" id="ir1" rows="10" cols="100" placeholder="내용을 입력하십시오"></textarea>
<!--                <div id="ck_editor" class="editor">-->
<!--                </div>-->
<!--                <textarea name="" id="" cols="30" rows="10" ></textarea>-->
<!--                <label for="add_msg" class="checkType flexType2">-->
<!--                    <input type="checkbox" id="dd" name="add_msg" class="add_msg"><p class="text">대시보드 등록</p>-->
<!--                </label>-->

<!--                <label class="chk_wrap">-->
<!--                    <input type="checkbox" id="dd" name="add_msg">-->
<!--                    <span class="chk_box">대시보드 메시지</span>-->
<!--                    <span class="chk_box active">등록</span>-->
<!--                    <span class="chk_box">안 함</span>-->
<!--                </label>-->
            </div>
            <div class="area area2 ">
            </div>
            <div class="area lastBox ">
                <button type="button" class="btnType1 mr10" onclick="go_noticeList();">목록</button>
                <button type="button" id="submit_btn" name="submit_btn" class="btnType2" onclick="Add_Content();">확인</button>

            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>