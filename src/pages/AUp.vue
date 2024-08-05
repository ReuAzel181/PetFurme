<template>
  <div class="a-up">
    <div class="extension9" />
    <div class="a-up-child" />
    <PO userPhoto="/user-photo1@2x.png" />
    <div class="details-divider" />
    <img
      class="mdiclock-outline-icon2"
      loading="lazy"
      alt=""
      src="/mdiclockoutline1.svg"
    />
    <img
      class="phdots-three-bold-icon8"
      loading="lazy"
      alt=""
      src="/phdotsthreebold2@2x.png"
    /><PO
      appointmentDateTop="930px"
      appointmentDateHeight="340px"
      userPhotoIconHeight="24.8px"
      userPhoto="/user-photo-12@2x.png"
    />
    <div class="a-up-item" />
    <img class="mdiclock-outline-icon3" alt="" src="/mdiclockoutline1.svg" />
    <img
      class="phdots-three-bold-icon9"
      alt=""
      src="/phdotsthreebold2@2x.png"
    />
    <div class="appointment3">Appointment :</div>
    <div class="modification-for-pet">Modification for Pet Tim</div>
    <div class="border-a1" />
    <div class="border-b1" />
    <main class="page-header">
      <PageHeader /><AppointmentView />
      <div class="appointment-list-container">
        <div class="appointment-card">
          <div class="thu-july-5">Thu July 5 · 9:00 - 10:30 AM</div>
          <div class="second-appointment-info">
            <div class="appointment-info1">
              <div class="owner-and-date">
                <div class="pet-owner3">Pet owner :</div>
                <div class="appointment-info2">
                  <div class="appointment4">Appointment :</div>
                </div>
                <div class="footer-container">
                  <div class="pet-owner3">Contact :</div>
                </div>
              </div>
              <div class="owner-and-date1">
                <div class="jan-jan">Jan Jan</div>
                <div class="modification-for-pet-sam-wrapper">
                  <div class="modification-for-pet1">
                    Modification for Pet Sam
                  </div>
                </div>
                <div class="modification-for-pet-sam-wrapper">
                  <div class="div3">09113456789</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="appointment-card-container">
        <div class="second-appointment-card">
          <div class="mon-july-1">Mon July 1 · 3:00 - 4:30 PM</div>
          <div class="second-appointment-info">
            <div class="owner-and-contact">
              <div class="owner-info">
                <div class="pet-owner4">Pet owner :</div>
                <div class="second-contact-info">
                  <div class="contact3">Contact :</div>
                </div>
              </div>
              <div class="custom-name">
                <div class="jon-jon">Jon Jon</div>
                <div class="pet-owner-details">09111456789</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <FrameComponent4 />
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import PO from "../components/PO.vue";
import PageHeader from "../components/PageHeader.vue";
import AppointmentView from "../components/AppointmentView.vue";
import FrameComponent4 from "../components/FrameComponent4.vue";

export default defineComponent({
  name: "AUp",
  components: { PO, PageHeader, AppointmentView, FrameComponent4 },
});
</script>
<style scoped>
.extension9 {
  position: absolute;
  top: 1080px;
  left: 327px;
  background-color: var(--color-whitesmoke-100);
  width: 1593px;
  height: 1847px;
  display: none;
}
.a-up-child {
  position: absolute;
  top: 160px;
  left: 327px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  background-color: var(--theme-white-default);
  width: 1593px;
  height: 69px;
  display: none;
}
.details-divider {
  position: absolute;
  top: 530px;
  left: 430px;
  border-right: 10px solid var(--color-lightgreen);
  box-sizing: border-box;
  width: 10px;
  height: 350px;
  z-index: 2;
}
.mdiclock-outline-icon2 {
  position: absolute;
  top: 599px;
  left: 459.4px;
  width: 30.3px;
  height: 30px;
  overflow: hidden;
  z-index: 2;
}
.phdots-three-bold-icon8 {
  position: absolute;
  top: 562px;
  left: 1744px;
  width: 60.6px;
  height: 60px;
  overflow: hidden;
  object-fit: contain;
  z-index: 2;
}
.a-up-item {
  position: absolute;
  top: 930px;
  left: 430px;
  border-right: 10px solid var(--color-lightgreen);
  box-sizing: border-box;
  width: 10px;
  height: 350px;
  z-index: 2;
}
.mdiclock-outline-icon3 {
  position: absolute;
  top: 999px;
  left: 459.4px;
  width: 30.3px;
  height: 30px;
  overflow: hidden;
}
.phdots-three-bold-icon9 {
  position: absolute;
  top: 962px;
  left: 1744px;
  width: 60.6px;
  height: 60px;
  overflow: hidden;
  object-fit: contain;
  z-index: 2;
}
.appointment3 {
  position: absolute;
  top: 1138px;
  left: 590.8px;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  display: inline-block;
  width: 217.3px;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 3;
}
.modification-for-pet {
  position: absolute;
  top: 1138px;
  left: 877.8px;
  font-size: var(--font-size-6xl);
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  display: inline-block;
  width: 312.3px;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 3;
}
.border-a1 {
  position: absolute;
  top: 545px;
  left: 327px;
  background-color: var(--color-whitesmoke-100);
  width: 93px;
  height: 2382px;
  display: none;
}
.border-b1 {
  position: absolute;
  top: 535px;
  left: 1830px;
  background-color: var(--color-whitesmoke-100);
  width: 90px;
  height: 2392px;
  display: none;
}
.thu-july-5 {
  position: relative;
  letter-spacing: 0.05em;
  font-weight: 500;
  display: inline-block;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  white-space: nowrap;
  max-width: 100%;
  z-index: 2;
}
.pet-owner3 {
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  flex-shrink: 0;
  z-index: 3;
}
.appointment4 {
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  flex-shrink: 0;
  z-index: 2;
}
.appointment-info2 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px 0px 0px var(--padding-11xs);
  margin-top: -4px;
}
.footer-container {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-11xs);
  margin-top: -4px;
}
.owner-and-date {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  min-width: 219.3px;
}
.jan-jan {
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  display: inline-block;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  min-width: 102px;
  flex-shrink: 0;
  z-index: 2;
}
.modification-for-pet1 {
  margin-top: -4px;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  flex-shrink: 0;
  z-index: 3;
}
.modification-for-pet-sam-wrapper {
  height: 46px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px 0px 0px;
  box-sizing: border-box;
}
.div3 {
  margin-top: -4px;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  flex-shrink: 0;
  z-index: 4;
}
.owner-and-date1 {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  min-width: 320.4px;
  max-width: 100%;
  font-size: var(--font-size-6xl);
}
.appointment-info1 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  gap: 69.7px;
  max-width: 100%;
}
.appointment-card {
  width: 699.4px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-44xl);
  max-width: 100%;
}
.appointment-list-container {
  width: 1042.2px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: center;
  padding: 0px var(--padding-xl) var(--padding-88xl);
  box-sizing: border-box;
  max-width: 100%;
  flex-shrink: 0;
}
.mon-july-1 {
  position: relative;
  letter-spacing: 0.05em;
  font-weight: 500;
  display: inline-block;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  white-space: nowrap;
  max-width: 100%;
}
.pet-owner4 {
  align-self: stretch;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 2;
}
.contact3 {
  align-self: stretch;
  flex: 1;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 4;
}
.second-contact-info {
  width: 147.5px;
  flex: 1;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px var(--padding-11xs);
  box-sizing: border-box;
}
.owner-info {
  height: 142px;
  width: 176.9px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-23xl);
  min-width: 176.9px;
}
.jon-jon {
  width: 104px;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  display: inline-block;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 2;
}
.pet-owner-details {
  align-self: stretch;
  position: relative;
  letter-spacing: 0.05em;
  line-height: 50px;
  font-weight: 300;
  text-shadow:
    1px 0 0 #fff,
    0 1px 0 #fff,
    -1px 0 0 #fff,
    0 -1px 0 #fff;
  z-index: 4;
}
.custom-name {
  width: 168.8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-23xl);
  min-width: 168.8px;
  font-size: var(--font-size-6xl);
}
.owner-and-contact {
  width: 457.8px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  gap: var(--gap-xl);
  max-width: 100%;
}
.second-appointment-info {
  align-self: stretch;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-end;
  max-width: 100%;
  font-size: var(--font-size-11xl);
}
.second-appointment-card {
  width: 547.8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-44xl);
  max-width: 100%;
}
.appointment-card-container {
  width: 890.6px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: center;
  padding: 0px var(--padding-xl);
  box-sizing: border-box;
  max-width: 100%;
  flex-shrink: 0;
}
.page-header {
  position: absolute;
  top: 0px;
  left: 327px;
  width: 100vh;
  height: 1080px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px 0px var(--padding-227xl);
  box-sizing: border-box;
  gap: var(--gap-39xl);
  max-width: 100%;
  text-align: left;
  font-size: var(--font-size-6xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}
.a-up {
  width: 100%;
  height: 100vh;
  position: relative;
  background-color: var(--color-whitesmoke-100);
  overflow: hidden;
  line-height: normal;
  letter-spacing: normal;
  text-align: left;
  font-size: var(--font-size-11xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1500px) {
  .page-header {
    height: auto;
  }

  .a-up {
    height: auto;
    min-height: 1080;
  }
}
@media screen and (max-width: 850px) {
  .appointment3 {
    font-size: var(--font-size-5xl);
    line-height: 40px;
  }

  .pet-owner3 {
    font-size: var(--font-size-5xl);
    line-height: 40px;
  }

  .appointment4 {
    font-size: var(--font-size-5xl);
    line-height: 40px;
  }

  .owner-and-date {
    flex: 1;
  }

  .owner-and-date1 {
    flex: 1;
  }

  .appointment-info1 {
    flex-wrap: wrap;
  }

  .pet-owner4 {
    font-size: var(--font-size-5xl);
    line-height: 40px;
  }

  .contact3 {
    font-size: var(--font-size-5xl);
    line-height: 40px;
  }
}
@media screen and (max-width: 450px) {
  .appointment3 {
    font-size: var(--font-size-lg);
    line-height: 30px;
  }

  .modification-for-pet {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .thu-july-5 {
    font-size: var(--font-size-xl);
  }

  .pet-owner3 {
    font-size: var(--font-size-lg);
    line-height: 30px;
  }

  .appointment4 {
    font-size: var(--font-size-lg);
    line-height: 30px;
  }

  .jan-jan {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .modification-for-pet1 {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .div3 {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .mon-july-1 {
    font-size: var(--font-size-xl);
  }

  .pet-owner4 {
    font-size: var(--font-size-lg);
    line-height: 30px;
  }

  .contact3 {
    font-size: var(--font-size-lg);
    line-height: 30px;
  }

  .owner-info {
    flex: 1;
  }

  .jon-jon {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .pet-owner-details {
    font-size: var(--font-size-xl);
    line-height: 40px;
  }

  .custom-name {
    flex: 1;
  }

  .owner-and-contact {
    flex-wrap: wrap;
  }
}
</style>
