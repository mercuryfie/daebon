<template>
  <Navbar />
  <Event :text="text[eventTextNum]"/>
  {{ eventTextNum }}
  <SearchBar
    :data="data_temp"
    @searchMovie="searchMovie($event)"/>
  <p>
    <buttton @click="showAllMovie();">전체보기</buttton>
  </p>
  <Movies
      :data="data"
      @openModal="isModal=true; selectedMovie=$event"
      @increaseLike="increaseLike($event)"
  />

<!-- : colon == v바인딩 문법, isModal == Modal 이 열렸는지 닫혔는지-->
<!-- 관례상 콜론 다음에 속성명하고 "" 안에 변수명하고 같은 이름으로 전달-->
  <Modal class="modal" v-if="isModal"
      :data="data_temp"
      :isModal="isModal"
      :selectedMovie="selectedMovie"
      @closeModal="isModal=false"
  > </Modal>
</template>

<script> 
import data from './assets/movies';
import Navbar from './components/Navbar.vue';
import Event from './components/Event.vue';
import Modal from './components/Modal.vue';
import Movies from './components/Movies.vue';
import SearchBar from './components/SearchBar.vue';
// import {clear} from "core-js/internals/task";
console.log( data );
export default {
    name: 'App',
    data() {
      return {
        isModal: false,
        data : data, // origin
        data_temp : [...data], // pasted
        selectedMovie:0,
        text : [
            "NEFLIX 강렬한",
          "디즈니 100주년 기념작",
          "지브리 100주년 기념작"
        ],
        eventTextNum: 0,
        interval: null,
      }

    },
    methods: {
      increaseLike(id) {
        // this.data[i].like += 1;
        this.data.find(movie => {
          if(movie.id == id) {
            movie.like += 1;
          }
        })
      },
      searchMovie(title) {
        // 영화 제목이 포함된 데이터를 가져옴
        this.data_temp = this.data.filter(movie => {
          return movie.title.includes(title);
        })
      },
      showAllMovie() {
        this.data_temo = [...this.data];

      }
    },
    components: {
      Navbar: Navbar, // 불러온 component이름이 네브바
      Event: Event,
      Modal : Modal,
      Movies : Movies,
      SearchBar : SearchBar
    },
    mounted() {
      console.log('mounted');
      this.interval = setInterval(() => {
        if(this.eventTextNum == this.text.length -1) {
          this.eventTextNum = 0;
        } else {
          this.eventTextNum += 1;
        }
      },3000)
    },
    unmounted() {
        clearInterval(this.interval); // 인터벌 해제
    }
}
</script>

<style> 
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


</style>
