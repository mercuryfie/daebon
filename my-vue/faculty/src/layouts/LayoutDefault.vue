<template>
  <div id="app">
    <HeaderView />
    <GlobalView />
    <main>
      <router-view />
    </main>

    <!-- Footer -->
    <FooterView />
  </div>
</template>

<script>
// 각 include를 Vue 컴포넌트로 분리하여 import
import Header from '../components/Header.vue';
import Global from '../components/Global.vue';
import Footer from '../components/Footer.vue';

export default {
  name: 'App',
  components: {
    Header,
    Global,
    Footer
  }
};
</script>

<style>
/* Fonts & Reset CSS */
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&family=Kanit:wght@100;200;300;400;500;600;700;800;900&family=Noto+Sans+KR:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Birthstone&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* 기존 style.css 그대로 불러오기 */
@import '/assets/web/css/style.css';
</style>