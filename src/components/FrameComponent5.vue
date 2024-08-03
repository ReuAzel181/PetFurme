<template>
  <div class="rectangle-parent20">
    <div class="frame-child29" />
    <div class="home-notification-options-parent">
      <div class="home-notification-options">
        <a class="home5">HOME</a>
      </div>
      <v-btn class="frame-vbtn" color="primary" variant="plain"
        >Dashboard</v-btn
      >
      <div class="appointment-frame">
        <h2 class="notification5" @click="onNotificationTextClick">
          Notification
        </h2>
      </div>
    </div>
    <div class="appointment-frame">
      <h2 class="notification5" @click="onAppointmentTextClick">Appointment</h2>
    </div>
    <div class="appointment-frame">
      <a class="messages5" @click="onMessagesTextClick">Messages</a>
    </div>
    <div class="user-management-frame">
      <h2 class="user-management6">USER MANAGEMENT</h2>
    </div>
    <div class="pet-owner-frame">
      <h2 class="pet-owner9" @click="onPetOwnerTextClick">Pet Owner</h2>
    </div>
    <div class="pet-owner-frame">
      <h2 class="sub-admin5">Sub Admin</h2>
    </div>
    <div class="pets-frame">
      <h2 class="place-h8">Place H</h2>
    </div>
    <div class="pets-frame">
      <h2 class="pets5" @click="onPetsTextClick">Pets</h2>
    </div>
    <div class="pets-frame">
      <h2 class="products6" @click="onProductsTextClick">Products</h2>
    </div>
    <div class="pets-frame">
      <h2 class="order5" @click="onOrderTextClick">Order</h2>
    </div>
    <div class="pets-frame">
      <h2 class="report5">Report</h2>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "FrameComponent5",
  methods: {
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
    onOrderTextClick() {
      this.$router.push("/14-order");
    },
  },
});
</script>
<style scoped>
.frame-child29 {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home5 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 1;
}
.home-notification-options {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.frame-vbtn {
  align-self: stretch;
  height: 70px;
  z-index: 1;
}
.notification5 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  cursor: pointer;
  z-index: 1;
}
.home-notification-options-parent {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-8xl-5);
}
.appointment-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.messages5 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 1;
}
.user-management6 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 700;
  font-family: inherit;
  z-index: 1;
}
.user-management-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner9 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 1;
}
.pet-owner-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.sub-admin5 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 129px;
  z-index: 1;
}
.place-h8 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 91px;
  z-index: 1;
}
.pets5 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 1;
}
.pets-frame {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.products6 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 1;
}
.order5 {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 1;
}
.report5 {
  margin: 0;
  height: 36px;
  position: relative;
  font-size: inherit;
  font-weight: 400;
  font-family: inherit;
  display: inline-block;
  min-width: 80px;
  z-index: 1;
}
.rectangle-parent20 {
  width: 327px;
  position: relative;
  height: 100vh;
  left: 0px;
  background-color: var(--color-darkslategray);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-45xl) 0px var(--padding-34xl) var(--padding-11xs);
  box-sizing: border-box;
  gap: var(--gap-28xl-2);
  max-width: calc(100% - 1593px);
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1725px) {
  .rectangle-parent20 {
    max-width: 100%;
  }
}
@media screen and (max-width: 1350px) {
  .rectangle-parent20 {
    display: none;
  }
}
@media screen and (max-width: 900px) {
  .rectangle-parent20 {
    padding-top: var(--padding-23xl);
    padding-bottom: var(--padding-15xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .home5 {
    font-size: var(--font-size-xl);
  }

  .notification5 {
    font-size: var(--font-size-xl);
  }

  .appointment-frame {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .messages5 {
    font-size: var(--font-size-xl);
  }

  .user-management6 {
    font-size: var(--font-size-xl);
  }

  .pet-owner9 {
    font-size: var(--font-size-xl);
  }

  .pet-owner-frame {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .sub-admin5 {
    font-size: var(--font-size-xl);
  }

  .place-h8 {
    font-size: var(--font-size-xl);
  }

  .pets5 {
    font-size: var(--font-size-xl);
  }

  .products6 {
    font-size: var(--font-size-xl);
  }

  .order5 {
    font-size: var(--font-size-xl);
  }

  .report5 {
    font-size: var(--font-size-xl);
  }

  .rectangle-parent20 {
    gap: var(--gap-5xl);
    padding-top: var(--padding-8xl);
    padding-bottom: var(--padding-3xl);
    box-sizing: border-box;
  }
}
</style>
