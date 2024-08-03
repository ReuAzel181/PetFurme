<template>
  <div class="prod">
    <div class="extension1" />
    <div class="prod-child" />
    <div class="prod-item" />
    <div class="rectangle-parent">
      <div class="frame-item" />
      <div class="home-wrapper">
        <a class="home">HOME</a>
      </div>
      <div class="dashboard-wrapper">
        <a class="dashboard" @click="onDashboardTextClick">Dashboard</a>
      </div>
      <div class="dashboard-wrapper">
        <div class="notification" @click="onNotificationTextClick"> 
          Notification
        </div>
      </div>
      <div class="dashboard-wrapper">
        <div class="notification" @click="onAppointmentTextClick">
          Appointment
        </div>
      </div>
      <div class="dashboard-wrapper">
        <div class="messages" @click="onMessagesTextClick">Messages</div>
      </div>
      <div class="user-management-wrapper">
        <b class="user-management">USER MANAGEMENT</b>
      </div>
      <div class="pet-owner-wrapper">
        <div class="pet-owner2" @click="onPetOwnerTextClick">Pet Owner</div>
      </div>
      <div class="pet-owner-wrapper">
        <div class="sub-admin">Sub Admin</div>
      </div>
      <div class="pet-owner-wrapper">
        <div class="place-h">Place H</div>
      </div>
      <div class="frame-div">
        <div class="pet-owner-wrapper">
          <div class="pets" @click="onPetsTextClick">Pets</div>
        </div>
        <div class="rectangle-group">
          <div class="frame-inner" />
          <b class="products">Products</b>
        </div>
        <div class="pet-owner-wrapper">
          <div class="order" @click="onOrderTextClick">Order</div>
        </div>
      </div>
      <div class="pet-owner-wrapper">
        <div class="report">Report</div>
      </div>
    </div>
    <main class="header-content-parent">
      <HeaderContent1 /><ProductFilter />
      <section class="product-display"><ProductBox /></section>
    </main>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import HeaderContent1 from "../components/HeaderContent1.vue";
import ProductFilter from "../components/ProductFilter.vue";
import ProductBox from "../components/ProductBox.vue";

export default defineComponent({
  name: "Prod",
  components: { HeaderContent1, ProductFilter, ProductBox },
  methods: {
    onDashboardTextClick() {
      this.$router.push("/3-main");
    },
    onNotificationTextClick() {
      this.$router.push("/4-notif");
    },
    onAppointmentTextClick() {
      this.$router.push("/5-a-up");
    },
    onMessagesTextClick() {
      this.$router.push("/7-mes");
    },
    onPetOwnerTextClick() {
      this.$router.push("/8-peto");
    },
    onPetsTextClick() {
      this.$router.push("/9-p");
    },
    onOrderTextClick() {
      this.$router.push("/14-order");
    },
  },
});
</script>
<style scoped>
.extension1 {
  position: absolute;
  top: 1080px;
  left: 327px;
  background-color: var(--color-whitesmoke-100);
  width: 1593px;
  height: 1847px;
  display: none;
}
.prod-child {
  position: absolute;
  top: 293px;
  left: 326px;
  background-color: var(--color-whitesmoke-100);
  width: 1593px;
  height: 37px;
  display: none;
}
.prod-item {
  position: absolute;
  top: 1020px;
  left: 327px;
  background-color: var(--theme-white-default);
  width: 1593px;
  height: 60px;
  z-index: 2;
}
.frame-item {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 2;
}
.home-wrapper {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 2;
}
.dashboard-wrapper {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification {
  position: relative;
  cursor: pointer;
  z-index: 2;
}
.messages {
  position: relative;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 2;
}
.user-management {
  position: relative;
  z-index: 2;
}
.user-management-wrapper {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner2 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 2;
}
.pet-owner-wrapper {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.sub-admin {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 2;
}
.place-h {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 2;
}
.pets {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 2;
}
.frame-inner {
  height: 67px;
  width: 325px;
  position: relative;
  background-color: var(--color-lightgreen);
  display: none;
  max-width: 100%;
}
.products {
  position: relative;
  display: inline-block;
  min-width: 111px;
  z-index: 3;
}
.rectangle-group {
  align-self: stretch;
  background-color: var(--color-lightgreen);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-lg) var(--padding-47xl) var(--padding-lgi);
  box-sizing: border-box;
  max-width: 100%;
  z-index: 2;
}
.order {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 2;
}
.frame-div {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-9xl-5);
  max-width: 100%;
}
.report {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 2;
}
.rectangle-parent {
  position: absolute;
  top: 0px;
  left: 0px;
  background-color: var(--color-darkslategray);
  width: 327px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-3);
  max-width: 100%;
  z-index: 1;
}
.product-display {
  align-self: stretch;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-end;
  padding: 0px var(--padding-15xl);
  box-sizing: border-box;
  min-height: 1482px;
  max-width: 100%;
  flex-shrink: 0;
}
.header-content-parent {
  position: absolute;
  top: 0px;
  left: 327px;
  width: 1593px;
  height: 1080px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: flex-start;
  padding: 0px 0px 617px;
  box-sizing: border-box;
  gap: var(--gap-12xs);
  max-width: 100%;
}
.prod {
  width: 100%;
  height: 1080px;
  position: relative;
  background-color: var(--color-whitesmoke-100);
  overflow: hidden;
  line-height: normal;
  letter-spacing: normal;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1500px) {
  .header-content-parent {
    height: auto;
  }

  .prod {
    height: auto;
    min-height: 1080;
  }
}
@media screen and (max-width: 450px) {
  .home {
    font-size: var(--font-size-xl);
  }

  .dashboard {
    font-size: var(--font-size-xl);
  }

  .notification {
    font-size: var(--font-size-xl);
  }

  .messages {
    font-size: var(--font-size-xl);
  }

  .user-management {
    font-size: var(--font-size-xl);
  }

  .pet-owner2 {
    font-size: var(--font-size-xl);
  }

  .sub-admin {
    font-size: var(--font-size-xl);
  }

  .place-h {
    font-size: var(--font-size-xl);
  }

  .pets {
    font-size: var(--font-size-xl);
  }

  .products {
    font-size: var(--font-size-xl);
  }

  .order {
    font-size: var(--font-size-xl);
  }

  .report {
    font-size: var(--font-size-xl);
  }
}
</style>
