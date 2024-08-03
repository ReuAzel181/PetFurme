<template>
  <div class="rectangle-parent21">
    <div class="frame-child30" />
    <div class="navigation-items11">
      <a class="home7">HOME</a>
    </div>
    <div class="navigation-items12">
      <a class="dashboard6" @click="onDashboardTextClick">Dashboard</a>
    </div>
    <div class="bottom-navigation">
      <div class="navigation-items12">
        <div class="notification6" @click="onNotificationTextClick">
          Notification
        </div>
      </div>
      <div class="appointment-and-messages">
        <v-btn class="appointment-panel-vbtn" color="primary" variant="plain"
          >Appointment</v-btn
        >
        <div class="navigation-items12">
          <a
            class="messages7"
            @click="onMessagesTextClick"
            :style="messagesStyle"
            >Messages</a
          >
        </div>
      </div>
    </div>
    <div class="navigation-items15">
      <b class="notification6">USER MANAGEMENT</b>
    </div>
    <div class="report-navigation">
      <div class="pet-owner11" @click="onPetOwnerTextClick">Pet Owner</div>
    </div>
    <div class="report-navigation">
      <div class="sub-admin7">Sub Admin</div>
    </div>
    <div class="report-navigation">
      <div class="place-h10">Place H</div>
    </div>
    <div class="report-navigation">
      <div class="pets7" @click="onPetsTextClick">Pets</div>
    </div>
    <div class="report-navigation">
      <div class="products9" @click="onProductsTextClick">Products</div>
    </div>
    <div class="report-navigation">
      <div class="order7" @click="onOrderTextClick">Order</div>
    </div>
    <div class="report-navigation">
      <div class="report7">Report</div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "FrameComponent4",
  props: {
    propTextDecoration: { type: String },
    onNotificationTextClick: { type: Function },
  },
  methods: {
    onDashboardTextClick() {
      this.$router.push("/3-main");
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
  computed: {
    uSERMANAGEMENT1Style() {
      return {
        textDecoration: this.propTextDecoration,
      };
    },
  },
});
</script>
<style scoped>
.frame-child30 {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home7 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 4;
}
.navigation-items11 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard6 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 4;
}
.navigation-items12 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification6 {
  position: relative;
  z-index: 4;
}
.appointment-panel-vbtn {
  align-self: stretch;
  max-width: 100%;
  z-index: 4;
}
.messages7 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 4;
}
.appointment-and-messages {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-6xl);
  max-width: 100%;
}
.bottom-navigation {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-10xl);
  max-width: 100%;
}
.navigation-items15 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner11 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 4;
}
.sub-admin7 {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 4;
}
.place-h10 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 4;
}
.pets7 {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 4;
}
.products9 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 4;
}
.order7 {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 4;
}
.report7 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 4;
}
.report-navigation {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.rectangle-parent21 {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 100vh;
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
  z-index: 3;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 450px) {
  .home7 {
    font-size: var(--font-size-xl);
  }

  .dashboard6 {
    font-size: var(--font-size-xl);
  }

  .notification6 {
    font-size: var(--font-size-xl);
  }

  .messages7 {
    font-size: var(--font-size-xl);
  }

  .pet-owner11 {
    font-size: var(--font-size-xl);
  }

  .sub-admin7 {
    font-size: var(--font-size-xl);
  }

  .place-h10 {
    font-size: var(--font-size-xl);
  }

  .pets7 {
    font-size: var(--font-size-xl);
  }

  .products9 {
    font-size: var(--font-size-xl);
  }

  .order7 {
    font-size: var(--font-size-xl);
  }

  .report7 {
    font-size: var(--font-size-xl);
  }
}
</style>
