<template>
  <div class="leftBox">
    <!-- 검색 박스 -->
    <div class="leftMenu searchBox1">
      <select v-model="searchType">
        <option value="buyerName">구매자명</option>
        <option value="receiverName">수취인명</option>
        <option value="buyerId">구매자ID</option>
        <option value="orderNo">주문번호</option>
        <option value="product">상품</option>
      </select>
      <div class="searchBox1-1 flexType2">
        <input type="search" v-model="searchKeyword" />
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
    </div>

    <!-- 메뉴 -->
    <div class="leftMenu merleft1-3">
      <div class="menuWrap">
        <div
            class="menuBox"
            v-for="(menu, index) in menuList"
            :key="index"
        >
          <div
              class="topmenu flexType3"
              :class="{ active: activeIndex === index }"
              @click="toggleMenu(index)"
              @mouseover="hoverIndex = index"
              @mouseleave="hoverIndex = null"
              :style="{
              backgroundColor: hoverIndex === index ? '#ececec' : ''
            }"
          >
            <a href="javascript:;" class="topText">{{ menu.title }}</a>
            <i
                class="fa-solid"
                :class="activeIndex === index ? 'fa-angle-up' : 'fa-angle-down'"
            ></i>
          </div>

          <div
              v-show="activeIndex === index"
              class="submenu flexCol"
          >
            <a
                v-for="(sub, subIndex) in menu.sub"
                :key="subIndex"
                href="javascript:;"
                class="subtext"
                @mouseover="subHover = `${index}-${subIndex}`"
                @mouseleave="subHover = ''"
                :style="{
                color:
                  subHover === `${index}-${subIndex}` ? '#42b983' : ''
              }"
            >
              {{ sub }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LeftMenuComponent",
  data() {
    return {
      searchType: "buyerName",
      searchKeyword: "",
      activeIndex: null,
      hoverIndex: null,
      subHover: "",
      menuList: [
        {
          title: "주문 관리",
          sub: ["쇼핑몰 연동", "주문정보", "배송정보"],
        },
        {
          title: "기준정보 관리",
          sub: ["제품 관리", "제품마스터 관리", "제품원재료 관리"],
        },
        {
          title: "입출고 관리",
          sub: ["원재료 입고", "원재료 출고", "원재료 재고"],
        },
        {
          title: "입출고 관리",
          sub: ["원재료 입고", "원재료 출고", "원재료 재고"],
        },
        {
          title: "입출고 관리",
          sub: ["원재료 입고", "원재료 출고", "원재료 재고"],
        },
      ],
    };
  },
  methods: {
    toggleMenu(index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    },
  },
};
</script>

<style scoped>


.merwrap {
  display: flex;
  width: 100%;
}

.merleft {
  height: 100vh;
  /*overflow-y: auto;  */
  /*flex-shrink: 0;  */
  width: 220px;
}

.merright {
  flex-grow: 1;
  width: 100%;
  background-color: var(--bgColor2);
}

.leftBox {
  width: 220px;
  height: 100vh;
  overflow-y: scroll;
  background-color: var(--bgColor1);
}

.searchBox1 {
  margin-top: 20px;
  width: 200px;
  height: 80px;
}
.searchBox1 select {
  border:none;
  background-color: transparent;
  border-radius: 5px;
  width: 160px;
  height: 32px;
  margin-left: 20px;

}
.searchBox1-1 {
  position: relative;
  margin: 0 auto;
  border:1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  width: 160px;
  height: 32px;
}


.searchBox1-1 input{
  margin-left: 0;
  border:none;
  background-color: transparent;
  width: 130px;
  height: 32px;
}

.searchBox1-1 input:focus {
  outline: none;
  box-shadow: none;
  border: none;
}


.searchBox1-1 i {
  position: absolute;
  top:50%;
  transform: translateY(-50%);
  right:10px;
  color:#7c7c7c;
  font-size: 16px;
}

.menuWrap {
  width: 200px;
}
.menuBox .topmenu {
  /*width:160px;*/
  padding: 0px 20px;

}
.menuBox .topText {
  width:100px;
  height: 50px;
  line-height: 50px;
  text-align: left;
  font-family: "Gmarket Sans";
}

.topmenu i {
  color:#7c7c7c;
}

.hidden {
  display: none;

}

.submenu {
  display: none;
}

.submenu .subtext {
  width: 200px;
  height: 40px;
  line-height: 40px;
  font-size: 14px;
  padding: 0px 20px;
  color:#7c7c7c;
}


</style>