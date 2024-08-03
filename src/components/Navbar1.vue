<template>
  <div class="navbar">
    <div class="navbar-child" />
    <div class="navbar-items">
      <a class="home6">HOME</a>
    </div>
    <div class="dashboard-header-parent">
      <div class="dashboard-header">
        <a class="dashboard5" @click="onDashboardTextClick">Dashboard</a>
      </div>
      <div class="dashboard-content1">
        <v-btn class="notification-link-vbtn" color="primary" variant="plain"
          >Notifications</v-btn
        >
        <div class="dashboard-header">
          <div class="appointment10" @click="onAppointmentTextClick">
            Appointment
          </div>
        </div>
      </div>
    </div>
    <div class="dashboard-header">
      <div class="messages6" @click="onMessagesTextClick">Messages</div>
    </div>
    <div class="navbar-items2">
      <b class="user-management7">USER MANAGEMENT</b>
    </div>
    <div class="report-link">
      <div class="pet-owner10" @click="onPetOwnerTextClick">Pet Owner</div>
    </div>
    <div class="report-link">
      <div class="sub-admin6">Sub Admin</div>
    </div>
    <div class="report-link">
      <div class="place-h9">Place H</div>
    </div>
    <div class="report-link">
      <div class="pets6" @click="onPetsTextClick">Pets</div>
    </div>
    <div class="report-link">
      <div class="products8" @click="onProductsTextClick">Products</div>
    </div>
    <div class="report-link">
      <div class="order6" @click="onOrderTextClick">Order</div>
    </div>
    <div class="report-link">
      <div class="report6">Report</div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "Navbar1",
  methods: {
    onDashboardTextClick() {
      this.$router.push("/3-main");
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
.navbar-child {
  align-self: stretch;
  height: 1080px;
  position: relative;
  background-color: var(--color-darkslategray);
  display: none;
}
.home6 {
  text-decoration: none;
  position: relative;
  font-weight: 700;
  color: inherit;
  display: inline-block;
  min-width: 77px;
  z-index: 1;
}
.navbar-items {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-21xl);
}
.dashboard5 {
  text-decoration: none;
  position: relative;
  color: inherit;
  display: inline-block;
  min-width: 129px;
  cursor: pointer;
  z-index: 1;
}
.dashboard-header {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-49xl);
}
.notification-link-vbtn {
  align-self: stretch;
  max-width: 100%;
  z-index: 1;
}
.appointment10 {
  position: relative;
  cursor: pointer;
  z-index: 1;
}
.dashboard-content1 {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-7xl);
  max-width: 100%;
}
.dashboard-header-parent {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-10xl);
  max-width: 100%;
}
.messages6 {
  position: relative;
  display: inline-block;
  min-width: 121px;
  cursor: pointer;
  z-index: 1;
}
.user-management7 {
  position: relative;
  z-index: 1;
}
.navbar-items2 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-14xl);
}
.pet-owner10 {
  position: relative;
  display: inline-block;
  min-width: 125px;
  cursor: pointer;
  z-index: 1;
}
.sub-admin6 {
  position: relative;
  display: inline-block;
  min-width: 129px;
  z-index: 1;
}
.place-h9 {
  position: relative;
  display: inline-block;
  min-width: 91px;
  z-index: 1;
}
.pets6 {
  position: relative;
  display: inline-block;
  min-width: 53px;
  cursor: pointer;
  z-index: 1;
}
.products8 {
  position: relative;
  display: inline-block;
  min-width: 106px;
  cursor: pointer;
  z-index: 1;
}
.order6 {
  position: relative;
  display: inline-block;
  min-width: 68px;
  cursor: pointer;
  z-index: 1;
}
.report6 {
  height: 36px;
  position: relative;
  display: inline-block;
  min-width: 80px;
  z-index: 1;
}
.report-link {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-47xl);
}
.navbar {
  position: absolute;
  top: 0px;
  height: 100vh;
  left: 0px;
  background-color: var(--color-darkslategray);
  width: 327px;
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

@media screen and (max-width: 450px) {
  .home6 {
    font-size: var(--font-size-xl);
  }

  .dashboard5 {
    font-size: var(--font-size-xl);
  }

  .appointment10 {
    font-size: var(--font-size-xl);
  }

  .messages6 {
    font-size: var(--font-size-xl);
  }

  .user-management7 {
    font-size: var(--font-size-xl);
  }

  .pet-owner10 {
    font-size: var(--font-size-xl);
  }

  .sub-admin6 {
    font-size: var(--font-size-xl);
  }

  .place-h9 {
    font-size: var(--font-size-xl);
  }

  .pets6 {
    font-size: var(--font-size-xl);
  }

  .products8 {
    font-size: var(--font-size-xl);
  }

  .order6 {
    font-size: var(--font-size-xl);
  }

  .report6 {
    font-size: var(--font-size-xl);
  }
}
</style>
