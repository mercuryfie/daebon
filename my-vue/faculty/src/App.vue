<template>

<!--  <Header />-->
  <component :is="layoutComponent">
    <router-view /> <!-- 페이지별 콘텐츠 -->
  </component>
</template>

<script>
import data from './assets/movies';
// import Header from './components/Header.vue';
// import Footer from './components/Footer.vue';
import Layout1 from './layouts/LayoutDefault.vue'
import Layout2 from './layouts/LayoutWorkpage.vue'
// import LeftMenu from './components/LeftMenu.vue';
console.log( data );
export default {
  name: 'App',
  computed: {
    layoutComponent() {
      return this.$route.meta.layout === 'type2' ? Layout2 : Layout1;
    }
  }
  }
</script>

<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

a {
  text-decoration: none;
  color:inherit;
  cursor: pointer;
}


i {
  cursor: pointer;
}

:root {
  --color1: #6FFF74;
  --color2: #19CD1F;
  --color3: #43B747;
  --color4: #42b983;
  --bgColor1: #F9F9F9;
  --bgColor2: #F3F3F3;
  --main-gradient: linear-gradient(
      to bottom right,
      #6FFF74 10%,
      #19CD1F 70%
  );
}

::selection {
  background-color: #b0ddc2;
  color: #000;
}

input[type="checkbox"] {
  accent-color: #19CD1F;
  color:#fff;
}


.bg-yellow {
  background-color: blue;
  color:#fff;

}

.container {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;

}

.info {
  display: flex;
  flex-flow: column;
  justify-content: flex-start;
  align-items: flex-start;
}

.thum {
  width: 180px;
  height: 240px;
  object-fit: cover;
}


/* flexType1 -------------------------------- */

.fontType1 {
  font-family: "Gmarket Sans";
}

.fontType2 {
  font-family:"Noto Sans";
}

.flexType1 {
  display: flex;
  justify-content: center;
  align-items: center;
}

.flexType2 {
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.flexType3 {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.flexType4 {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
}

.flexType5 {
  display: flex;
  justify-content: flex-end;
  align-items: flex-start;
}

.flexType6 {
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
}

.flexCol {
  display: flex;
  flex-flow: column;
  justify-content: flex-start;
  align-items: flex-start;
}

.flexStart {
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.mr10 {
  margin-right: 10px;
}

.mb10 {
  margin-bottom: 10px;
}

.mb40 {
  margin-bottom: 40px;
}

</style>
