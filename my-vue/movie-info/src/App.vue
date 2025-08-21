<script>
export default {
  data () {
    return {
      score : false,
      subscribe:2677,
    }
  },

}
</script>

<template>
  <pre>hel
  dl
  dl</pre>
  <h1 v-if="score">평점 : A if</h1>
<!--  <h1 v-else-if="score >= 80">평점 : B</h1>-->
<!--  <h1 v-else-if="score >= 70">평점 : C</h1>-->
<!--  <h1 v-else>score : F</h1>-->
  <h1 v-show="score"> v-show is working</h1>
  <h1>num of subscribers: {{ subscribe }}</h1>
  <p>the lucky number of today : {{ Math.ceil(Math.random()*45) }}</p>
  <p v-html="channel"> </p>
  <p v-text="subscribe"></p>
</template>




<style>


</style>
