<template>
  <div class="navigation">
    <div class="navigation-child" />
    <div class="menu-options">
      <a class="home2">HOME</a>
    </div>
    <div class="menu-options1">
      <a class="dashboard2" @click="onDashboardTextClick">Dashboard</a>
    </div>
    <div class="menu-options1">
      <div class="notification2" @click="onNotificationTextClick">
        Notification
      </div>
    </div>
    <div class="menu-options1">
      <div class="notification2" @click="onAppointmentTextClick">S
        Appointment
      </div>
    </div>
    <div class="menu-options1">
      <div
        class="messages2"
        @click="onMessagesTextClick"
        :style="messagesStyle"
      >
        Messages
      </div>
    </div>
    <div class="menu-options5">
      <b class="user-management3">USER MANAGEMENT</b>
    </div>
    <div class="menu-options6">
      <div class="pet-owner6" @click="onPetOwnerTextClick">Pet Owner</div>
    </div>
    <div class="menu-options6">
      <div class="sub-admin2">Sub Admin</div>
    </div>
    <div class="content">
      <div class="place">
        <div class="place-h5">Place H</div>
      </div>
      <div class="rectangle-parent18">
        <div class="frame-child24" />
        <b class="pets2">Pets</b>
      </div>
      <div class="place">
        <div class="products3" @click="onProductsTextClick">Products</div>
      </div>
    </div>
    <div class="place">
      <div class="order3" @click="onOrderTextClick">Order</div>
    </div>
    <div class="place">
      <div class="report2">Report</div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "Navigation1",
  props: {
    uSERMANAGEMENTTextDecoration: { type: String },
    onPetOwnerTextClick: { type: Function },
  },
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
    onPetOwnerTextClick1() {
      this.$router.push("/8-peto");
    },
    onProductsTextClick() {
      this.$router.push("/12-prod");
    },
    onOrderTextClick() {
      this.$router.push("/14-order");
    },
  },
  computed: {
    messagesStyle() {
      return {
        textDecoration: this.uSERMANAGEMENTTextDecoration,
      };
    },
  },
});
</script>
<style scoped>
.navigation-child {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home2 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 1;
}
.menu-options {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard2 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 1;
}
.menu-options1 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification2 {
  position: relative;
  cursor: pointer;
  z-index: 1;
}
.messages2 {
  position: relative;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 1;
}
.user-management3 {
  position: relative;
  z-index: 1;
}
.menu-options5 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner6 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 1;
}
.menu-options6 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.sub-admin2 {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 1;
}
.place-h5 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 1;
}
.place {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.frame-child24 {
  height: 70px;
  width: 325px;
  position: relative;
  background-color: var(--color-lightgreen);
  display: none;
  max-width: 100%;
}
.pets2 {
  position: relative;
  display: inline-block;
  min-width: 55px;
  z-index: 2;
}
.rectangle-parent18 {
  align-self: stretch;
  background-color: var(--color-lightgreen);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-xl) var(--padding-47xl);
  box-sizing: border-box;
  max-width: 100%;
  z-index: 1;
}
.products3 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 1;
}
.content {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-8xl-5);
  max-width: 100%;
}
.order3 {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 1;
}
.report2 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 1;
}
.navigation {
  height: 100vh;
  width: 327px;
  background-color: var(--color-darkslategray);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-2);
  max-width: 100%;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1225px) {
  .navigation {
    padding-top: var(--padding-23xl);
    padding-bottom: var(--padding-15xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .home2 {
    font-size: var(--font-size-xl);
  }

  .dashboard2 {
    font-size: var(--font-size-xl);
  }

  .menu-options1 {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .notification2 {
    font-size: var(--font-size-xl);
  }

  .messages2 {
    font-size: var(--font-size-xl);
  }

  .user-management3 {
    font-size: var(--font-size-xl);
  }

  .pet-owner6 {
    font-size: var(--font-size-xl);
  }

  .menu-options6 {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .sub-admin2 {
    font-size: var(--font-size-xl);
  }

  .place-h5 {
    font-size: var(--font-size-xl);
  }

  .pets2 {
    font-size: var(--font-size-xl);
  }

  .products3 {
    font-size: var(--font-size-xl);
  }

  .order3 {
    font-size: var(--font-size-xl);
  }

  .report2 {
    font-size: var(--font-size-xl);
  }

  .navigation {
    gap: var(--gap-5xl);
    padding-top: var(--padding-8xl);
    padding-bottom: var(--padding-3xl);
    box-sizing: border-box;
  }
}
</style>
