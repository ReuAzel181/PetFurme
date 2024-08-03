<template>
  <div class="admin-menu">
    <div class="admin-menu-child" />
    <div class="admin-navigation-items">
      <a class="home8">HOME</a>
    </div>
    <div class="admin-navigation-items1">
      <a class="dashboard7" @click="onDashboardTextClick">Dashboard</a>
    </div>
    <div class="admin-navigation-items1">
      <div class="notification7" @click="onNotificationTextClick">
        Notification
      </div>
    </div>
    <FrameComponent
      uSERMANAGEMENT="Appointment"
      :onAppointmentTextClick="onAppointmentTextClick"
      propFontWeight="unset"
      subAdmin="USER MANAGEMENT"
      propDisplay="unset"
      propMinWidth="unset"
      propFontWeight2="bold"
    />
    <div class="admin-navigation-items3">
      <div class="pet-owner12" @click="onPetOwnerTextClick">Pet Owner</div>
    </div>
    <div class="admin-navigation-items3">
      <div class="sub-admin8">Sub Admin</div>
    </div>
    <div class="admin-navigation-items5">
      <div class="place-h11">Place H</div>
    </div>
    <div class="admin-navigation-items5">
      <div class="pets8" @click="onPetsTextClick">Pets</div>
    </div>
    <div class="admin-navigation-items5">
      <div class="products10" @click="onProductsTextClick">Products</div>
    </div>
    <div class="admin-navigation-items5">
      <div class="order8" @click="onOrderTextClick">Order</div>
    </div>
    <div class="admin-navigation-items5">
      <div class="report8">Report</div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import FrameComponent from "./FrameComponent.vue";

export default defineComponent({
  name: "AdminMenu",
  components: { FrameComponent },
  methods: {
    onAppointmentTextClick() {
      this.$router.push("/5-a-up");
    },
    onDashboardTextClick() {
      this.$router.push("/3-main");
    },
    onNotificationTextClick() {
      this.$router.push("/4-notif");
    },
    onPetOwnerTextClick() {
      this.$router.push("/8-peto");
    },
    onPetsTextClick() {
      this.$router.push("/9-p");
    },
    onProductsTextClick() {
      this.$router.push("/12-prod");
    },
    onOrderTextClick() {
      this.$router.push("/14-order");
    },
  },
});
</script>
<style scoped>
.admin-menu-child {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home8 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 4;
}
.admin-navigation-items {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard7 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 4;
}
.admin-navigation-items1 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification7 {
  position: relative;
  cursor: pointer;
  z-index: 4;
}
.pet-owner12 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 4;
}
.admin-navigation-items3 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.sub-admin8 {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 4;
}
.place-h11 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 4;
}
.admin-navigation-items5 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.pets8 {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 4;
}
.products10 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 4;
}
.order8 {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 4;
}
.report8 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 4;
}
.admin-menu {
  width: 327px;
  height: 100vh;
  background-color: var(--color-darkslategray);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-3);
  max-width: 100%;
  z-index: 3;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1225px) {
  .admin-menu {
    padding-top: var(--padding-23xl);
    padding-bottom: var(--padding-15xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .home8 {
    font-size: var(--font-size-xl);
  }

  .dashboard7 {
    font-size: var(--font-size-xl);
  }

  .admin-navigation-items1 {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .notification7 {
    font-size: var(--font-size-xl);
  }

  .pet-owner12 {
    font-size: var(--font-size-xl);
  }

  .admin-navigation-items3 {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .sub-admin8 {
    font-size: var(--font-size-xl);
  }

  .place-h11 {
    font-size: var(--font-size-xl);
  }

  .pets8 {
    font-size: var(--font-size-xl);
  }

  .products10 {
    font-size: var(--font-size-xl);
  }

  .order8 {
    font-size: var(--font-size-xl);
  }

  .report8 {
    font-size: var(--font-size-xl);
  }

  .admin-menu {
    gap: var(--gap-5xl);
    padding-top: var(--padding-8xl);
    padding-bottom: var(--padding-3xl);
    box-sizing: border-box;
  }
}
</style>
