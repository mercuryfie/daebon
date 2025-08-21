<template>
  <div class="event" :class="{show : isOpen}">
    <p>{{ text }}</p>
    <button @click="isOpen=false">X</button>
  </div>
</template>

<script>
export default {
  name: 'EventComponent',
  props: {
    text: String,
    isEventOpen:Boolean,
  },
  data() {
    return {
      isOpen : true
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .event {
    background-color: #000;
    color:#fff;
    text-align: center;
    padding: 20px;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items:center;
    display: none;
  }

  .show {
    display: flex;
  }

  .event p {
    margin: 0;
    font-family: "Gmarket Sans";
  }
</style>
