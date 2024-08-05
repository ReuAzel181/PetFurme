<template>
  <div class="order1">
    <div class="extension3" />
    <TotalOrd /><HEADER
      propAlignSelf="unset"
      propPosition="absolute"
      propTop="0px"
      propLeft="327px"
      propWidth="1593px"
      propHeight="unset"
    /><OHTab />
    <div class="order-child" />
    <NavigationContainer />
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import TotalOrd from "../components/TotalOrd.vue";
import HEADER from "../components/HEADER.vue";
import OHTab from "../components/OHTab.vue";
import NavigationContainer from "../components/NavigationContainer.vue";

export default defineComponent({
  name: "Order",
  components: { TotalOrd, HEADER, OHTab, NavigationContainer },
});
</script>
<style scoped>
.extension3 {
  position: absolute;
  top: 1080px;
  left: 327px;
  background-color: var(--color-whitesmoke-100);
  width: 1593px;
  height: 1847px;
  display: none;
}
.order-child {
  position: absolute;
  top: 449px;
  left: 327px;
  background-color: var(--color-whitesmoke-100);
  width: 1593px;
  height: 60px;
  display: none;
}
.order1 {
  width: 100%;
  height: 100vh;
  position: relative;
  background-color: var(--color-whitesmoke-100);
  overflow-y: auto;
  line-height: normal;
  letter-spacing: normal;
}

@media screen and (max-width: 1500px) {
  .order1 {
    height: auto;
    min-height: 1080;
  }
}
</style>
