<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/noticeList_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright">
    <div class=notice_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                공지사항
            </p>
        </div>
        <div class="areaBox notice_list_box min80vh">
            <div class="area area1 ">
                <button type="button" class="btnType2" id="add_btn" name="add_btn" onclick="go_noticeRegister();">글쓰기</button>
            </div>
            <div class="area area2 ">
                <table class="notice_list_table">
                    <thead>
                        <tr>
                            <th class="num td_spec">번호</th>
                            <th>제목</th>
                            <th class="name">이름</th>
                            <th class="date">날짜</th>
                        </tr>
                    </thead>
                    <tbody id="nList" name="nList">
<!--                        <tr class="fixed">-->
<!--                            <td class="num">-->
<!--                                <p class="type">공지</p>-->
<!--                            </td>-->
<!--                            <td>제목</td>-->
<!--                            <td>이름</td>-->
<!--                            <td>날짜</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td class="num">번호</td>-->
<!--                            <td>제목</td>-->
<!--                            <td>이름</td>-->
<!--                            <td>날짜</td>-->
<!--                        </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>