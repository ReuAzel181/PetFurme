<template>
  <div class="dashboard-content">
    <div class="dashboard-content-child" />
    <div class="home-frame">
      <a class="home4">HOME</a>
    </div>
    <div class="dashboard-frame">
      <a class="dashboard4" @click="onDashboardTextClick">Dashboard</a>
    </div>
    <div class="dashboard-frame">
      <div class="notification-parent">
        <div class="notification4" @click="onNotificationTextClick">
          Notification
        </div>
        <div class="notification4" @click="onAppointmentTextClick">
          Appointment
        </div>
        <a class="messages4" @click="onMessagesTextClick">Messages</a>
      </div>
    </div>
    <FrameComponent
      uSERMANAGEMENT="USER MANAGEMENT"
      petOwner="Pet Owner"
      subAdmin="Sub Admin"
    />
    <div class="place-h-frame">
      <div class="place-h7">Place H</div>
    </div>
    <div class="place-h-frame">
      <div class="pets4" @click="onPetsTextClick">Pets</div>
    </div>
    <div class="place-h-frame">
      <div class="products5" @click="onProductsTextClick">Products</div>
    </div>
    <div class="place-h-frame">
      <div class="order4" @click="onOrderTextClick">Order</div>
    </div>
    <div class="place-h-frame">
      <div class="report4">Report</div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import FrameComponent from "./FrameComponent.vue";

export default defineComponent({
  name: "DashboardContent",
  components: { FrameComponent },
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
.dashboard-content-child {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home4 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 1;
}
.home-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard4 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 1;
}
.dashboard-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification4 {
  position: relative;
  cursor: pointer;
  z-index: 1;
}
.messages4 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 1;
}
.notification-parent {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-28xl);
}
.place-h7 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 1;
}
.place-h-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.pets4 {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 1;
}
.products5 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 1;
}
.order4 {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 1;
}
.report4 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 1;
}
.dashboard-content {
  height: 100vh;
  width: 327px;
  background-color: var(--color-darkslategray);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-3);
  max-width: 100%;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1225px) {
  .dashboard-content {
    padding-top: var(--padding-23xl);
    padding-bottom: var(--padding-15xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .home4 {
    font-size: var(--font-size-xl);
  }

  .dashboard4 {
    font-size: var(--font-size-xl);
  }

  .dashboard-frame {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .notification4 {
    font-size: var(--font-size-xl);
  }

  .messages4 {
    font-size: var(--font-size-xl);
  }

  .place-h7 {
    font-size: var(--font-size-xl);
  }

  .pets4 {
    font-size: var(--font-size-xl);
  }

  .products5 {
    font-size: var(--font-size-xl);
  }

  .order4 {
    font-size: var(--font-size-xl);
  }

  .report4 {
    font-size: var(--font-size-xl);
  }

  .dashboard-content {
    gap: var(--gap-5xl);
    padding-top: var(--padding-8xl);
    padding-bottom: var(--padding-3xl);
    box-sizing: border-box;
  }
}
</style>
