<template>
  <div class="search-box">
    <!--           vue에서는 v-model이라는 문법을 쓸 수 있음
    @input="inputText = $event.target.value">-->

    <input type="search" placeholder="검색어 입력"
      @change="
      $emit('searchMovie',$event.target.value);
      inputText = $event.target.value;
      $event.target.value='';">
    <button>enter</button>
  </div>
  <p> {{ inputText }}</p>
</template>

<script>
export default {
  name: 'SearchBarComponent',
  data() {
    return {
      inputText : ''
    }
  },
  props: {
    data: Array,

  },
  watch: {
    inputText(name) {
      // 입력한 영화 제목이 데이터에 있는지 확인
      const findName = this.data.filter(movie => {
        return movie.title.includes(name);
      })
      console.log(findName);
      if(findName==0) {
        alert('thers is no movie');
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
