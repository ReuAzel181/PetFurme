<template>
  <div class="navigation-container">
    <div class="navigation-container-child" />
    <div class="navigation-items1">
      <a class="home3">HOME</a>
    </div>
    <div class="navigation-items2">
      <a class="dashboard3" @click="onDashboardTextClick">Dashboard</a>
    </div>
    <div class="navigation-items2">
      <div class="notification3" @click="onNotificationTextClick">
        Notification
      </div>
    </div>
    <div class="navigation-items2">
      <div class="notification3" @click="onAppointmentTextClick">
        Appointment
      </div>
    </div>
    <div class="navigation-items2">
      <div class="messages3" @click="onMessagesTextClick">Messages</div>
    </div>
    <div class="navigation-items6">
      <b class="user-management4">USER MANAGEMENT</b>
    </div>
    <div class="product-button">
      <div class="pet-owner7" @click="onPetOwnerTextClick">Pet Owner</div>
    </div>
    <div class="product-button">
      <div class="sub-admin3">Sub Admin</div>
    </div>
    <div class="product-button">
      <div class="place-h6">Place H</div>
    </div>
    <div class="product-button">
      <div class="pets3" @click="onPetsTextClick">Pets</div>
    </div>
    <div class="product-navigation">
      <div class="product-button">
        <div class="products4" @click="onProductsTextClick">Products</div>
      </div>
      <div class="report-order-navigation">
        <v-btn class="order-button-vbtn" color="primary" variant="plain"
          >Order</v-btn
        >
        <div class="product-button">
          <div class="report3">Report</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "NavigationContainer",
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
    onProductsTextClick() {
      this.$router.push("/12-prod");
    },
  },
});
</script>
<style scoped>
.navigation-container-child {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home3 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 3;
}
.navigation-items1 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard3 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 3;
}
.navigation-items2 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification3 {
  position: relative;
  cursor: pointer;
  z-index: 3;
}
.messages3 {
  position: relative;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 3;
}
.user-management4 {
  position: relative;
  z-index: 3;
}
.navigation-items6 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner7 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 3;
}
.sub-admin3 {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 3;
}
.place-h6 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 3;
}
.pets3 {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 3;
}
.products4 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 3;
}
.product-button {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.order-button-vbtn {
  align-self: stretch;
  max-width: 100%;
  z-index: 3;
}
.report3 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 3;
}
.report-order-navigation {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-10xl);
  max-width: 100%;
}
.product-navigation {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-6xl);
  max-width: 100%;
}
.navigation-container {
  position: absolute;
  top: 0px;
  left: 0px;
  background-color: var(--color-darkslategray);
  width: 327px;
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-3);
  max-width: 100%;
  z-index: 2;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 450px) {
  .home3 {
    font-size: var(--font-size-xl);
  }

  .dashboard3 {
    font-size: var(--font-size-xl);
  }

  .notification3 {
    font-size: var(--font-size-xl);
  }

  .messages3 {
    font-size: var(--font-size-xl);
  }

  .user-management4 {
    font-size: var(--font-size-xl);
  }

  .pet-owner7 {
    font-size: var(--font-size-xl);
  }

  .sub-admin3 {
    font-size: var(--font-size-xl);
  }

  .place-h6 {
    font-size: var(--font-size-xl);
  }

  .pets3 {
    font-size: var(--font-size-xl);
  }

  .products4 {
    font-size: var(--font-size-xl);
  }

  .report3 {
    font-size: var(--font-size-xl);
  }
}
</style>
