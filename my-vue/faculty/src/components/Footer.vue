<template>
  <footer class="grayFoot">
    <p class="add">서울특별시 강남구 테헤란로 152</p>

    <div class="termsBox flexType1">
      <p class="terms">DAEBON EMS 이용약관</p>
      <p class="border"></p>
      <p class="terms">개인정보처리방침</p>
      <p class="border"></p>
      <p class="terms">윤리경영</p>
      <p class="border"></p>
      <p class="terms">고객센터</p>
    </div>

    <div class="footBox flexType1">
      <img src="/assets/web/src/logo_origin.png" alt="Daebon 로고">
      <p class="copyright">
        Copyright © Daebon Inc. All Rights Reserved
      </p>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'FooterComponent'
};
</script>

<style scoped>


.footWrap {
  margin: 0 auto;
  width: 1050px;
  height: 160px;
  text-align: center;

}
.grayFoot {
  margin: 0 auto;
  width: 1050px;
  height: 200px;
  text-align: center;
  background-color: var(--bgColor2);
}


.grayFoot .termsBox,
.footWrap .termsBox {
  height: 80px;

}


.grayFoot .add,
.grayFoot .termsBox .terms,
.footWrap .add,
.footWrap .termsBox .terms {
  width: auto;
  height: 22px;
  line-height: 22px;
  font-size: 12px;
  color:#5c5c5c;

}


.grayFoot .add,
.footWrap .add {
  padding-top: 60px;
}

.grayFoot .termsBox .terms,
.footWrap .termsBox .terms {
  padding: 0 10px;
}


.grayFoot .termsBox .border,
.footWrap .termsBox .border {
  height: 12px;
  border-right: 1px solid #ccc;
}

.footBox {
  height: 60px;
}

.footBox  img{
  width: 40px;
  height: 40px;
  object-fit: cover;
}
.footBox .copyright {
  margin-left: 40px;
  font-size: 14px;
  color:#5c5c5c;
}

</style>
