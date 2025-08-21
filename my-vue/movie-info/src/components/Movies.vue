<template>
  <div class="container">
    <h1>movie info</h1>
    <div class="container" v-for="(movie) in data" :key="movie.id">
      <figure>
        <img class="thum" :src="`${movie.imgUrl}`" :alt="movie.title">
      </figure>
      <div class="info">
        <h3 class="bg-yellow" :style="textRed">{{ movie.title }}</h3>
        <p>개봉 : {{ movie.year }}</p>
        <p>장르: {{ movie.category }}</p>
        <button @click="$emit('increaseLike',movie.id)">like</button>
        <span>{{ movie.like }}</span>
        <!-- emit 함수는 두번째 매개변수에서 값을 전달할 수 있음 -->
        <p><button @click="$emit('openModal',movie.id);">상세보기</button></p>
      </div>
      <div class="modal" v-if="isModal">
        <div class="inner">
          <h3>{{data[selectedMovie].title}}</h3>
          <p>{{data[selectedMovie].category}}</p>
          <button @click="isModal=false">닫기</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MoviesComponent',
  props: {
    data: Array

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .container {
    padding: 20px;
  }

</style>
