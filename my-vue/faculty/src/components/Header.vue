<template>
  <header>
    <div class="headerwrap">
      <!--      <img src="../assets/1.jpeg" alt="img">-->
      <img src="../assets/logo_daebon.png" alt="img">
      <div class="loginBox flexType5 ">
        <a href="javascript:;" class="text text1">로그인</a>
        <a href="javascript:;" class="text text2">도움말</a>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'HeaderComponent',
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.headerwrap {
  /*border:1px solid red;*/
  border-bottom: 1px solid #ececec;
  width: 100vw;
  height: 60px;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  padding: 0 60px 20px 60px;

}

.headerBox {
  margin: 0 auto;
  width: 1050px;

}

.loginBox{
  display: flex;
}

.loginBox .text {
  color:#1c1c1c;
  width: 120px;
  text-align: center;
  font-family: "Gmarket Sans";
}


.headerwrap .loginBox .text2 {
  border-left: 1px solid #ccc;
}

</style>
