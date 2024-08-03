<template>
  <div class="peto">
    <main class="dashboard-content-parent">
      <DashboardContent />
      <section class="user-management1">
        <HEADER
          propAlignSelf="stretch"
          propPosition="unset"
          propTop="unset"
          propLeft="unset"
          propWidth="unset"
          propHeight="unset"
          propMinHeight="unset"
          propHeight1="unset"
        /><POComp /><User /><User1 /><User2 />
      </section>
    </main>
    <div class="peto-child" />
    <div class="extension4" />
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import DashboardContent from "../components/DashboardContent.vue";
import HEADER from "../components/HEADER.vue";
import POComp from "../components/POComp.vue";
import User from "../components/User.vue";
import User1 from "../components/User1.vue";
import User2 from "../components/User2.vue";

export default defineComponent({
  name: "PetO",
  components: { DashboardContent, HEADER, POComp, User, User1, User2 },
});
</script>
<style scoped>
.user-management1 {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  min-width: 1035px;
  max-width: 100%;
}
.dashboard-content-parent {
  height: 100vh;
  align-self: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: flex-start;
  justify-content: flex-start;
  flex-shrink: 0;
  row-gap: 20px;
  max-width: 100%;
}
.peto-child {
  width: 1593px;
  height: 69px;
  position: relative;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  background-color: var(--theme-white-default);
  display: none;
  max-width: 100%;
}
.extension4 {
  width: 1613px;
  height: 1847px;
  position: relative;
  background-color: var(--color-whitesmoke-100);
  flex-shrink: 0;
  max-width: 100%;
}
.peto {
  width: 100%;
  position: relative;
  background-color: var(--color-whitesmoke-100);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: flex-start;
  line-height: normal;
  letter-spacing: normal;
}

@media screen and (max-width: 1525px) {
  .peto {
    height: auto;
  }
}
@media screen and (max-width: 1225px) {
  .user-management1 {
    min-width: 100%;
  }
}
</style>
