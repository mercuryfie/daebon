<template>
  <div class="modal">
    <div class="inner">
      <h3> {{ data[selectedMovie].title }}</h3>
      <p>영화 상세정보</p>
      <!-- vue 에서는 자식 컴포넌트에서 부모 컴포넌트의 유형 변경을 요청할 수 있음
그럴 경우에는 $emit 사용-->
      <button @click="$emit('closeModal')">close</button>
    </div>
  </div>
</template>



<script>
export default {
  name: 'ModalComponent',
  props: {
    data: Array,
    isModal: Boolean,
    selectedMovie: Number,

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .modal {
    background: #00000021;
    position:fixed;
    left:0;
    top:0;
    width:100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items:center;
  }

  .modal .inner {
    background : #fff;
    width:220px;
    padding: 20px;
    border-radius: 10px;
  }
</style>
