<template>
  <section class="main-content1">
    <div class="main-f-pp2">
      <div class="pp-f3">
        <div class="pp-content3">
          <div class="bg4" />
          <div class="prescription-1">
            <div class="prescription-1-child" />
            <PrescriptionNames trifexis50Lb="Trifexis 50 lb" />
            <div class="descriptions">
              <div class="administer-1-tablet">
                Administer 1 tablet orally once a month with food to prevent
                fleas, heartworms, and other common parasites. This dosage helps
                maintain your pet's health by providing continuous protection
                against these parasites.
              </div>
              <div class="expires-june-11-2023-parent">
                <b class="expires-june-11">Expires: June 11, 2023</b>
                <div class="reminder2">
                  <v-btn class="rem-tag-vbtn" color="#59b2f3" variant="flat"
                    >Sent to user</v-btn
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="prescription-2">
            <div class="prescription-2-child" />
            <PrescriptionNames
              propPosition="absolute"
              propTop="42px"
              propLeft="40px"
              propHeight="45px"
              trifexis50Lb="Peticillin 50 lb"
              propHeight1="50px"
            />
            <div class="peticillin-is-prescribed-to-tr-parent">
              <div class="peticillin-is-prescribed">
                Peticillin is prescribed to treat your pet’s bacterial
                infection. Please give the medication orally as directed, with
                or without food. Ensure you complete the entire course for best
                results. If you have any questions, don’t hesitate to contact
                us.
              </div>
              <div class="expires-june-11-2023-group">
                <b class="expires-june-111">Expires: June 11, 2023</b>
                <div class="rem-tag-wrapper">
                  <div class="rem-tag1">
                    <div class="rem-tag-item" />
                    <div class="send-to-user">Send to User</div>
                  </div>
                </div>
              </div>
            </div>
            <img class="message-user-icon" alt="" src="/message-user.svg" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import PrescriptionNames from "./PrescriptionNames.vue";

export default defineComponent({
  name: "MainContent1",
  components: { PrescriptionNames },
});
</script>
<style scoped>
.bg4 {
  width: 1466px;
  height: 1185px;
  position: relative;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--color-whitesmoke-300);
  display: none;
  max-width: 100%;
}
.prescription-1-child {
  width: 1357px;
  height: 497px;
  position: relative;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--theme-white-default);
  display: none;
  max-width: 100%;
}
.administer-1-tablet {
  align-self: stretch;
  position: relative;
  line-height: 40px;
  z-index: 1;
}
.expires-june-11 {
  position: relative;
  display: inline-block;
  max-width: 100%;
  z-index: 1;
}
.rem-tag-vbtn {
  box-shadow: 0px 4px 1px 1px rgba(0, 0, 0, 0.01);
  white-space: nowrap;
  z-index: 1;
}
.reminder2 {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-8xl) 0px 0px;
}
.expires-june-11-2023-parent {
  width: 1269px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  max-width: 100%;
  gap: var(--gap-xl);
}
.descriptions {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-18xl);
  max-width: 100%;
  font-size: var(--font-size-11xl);
  color: var(--color-darkgray-400);
}
.prescription-1 {
  align-self: stretch;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--theme-white-default);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-23xl) var(--padding-11xl) var(--padding-21xl)
    var(--padding-21xl);
  box-sizing: border-box;
  gap: var(--gap-39xl);
  max-width: 100%;
  z-index: 1;
}
.prescription-2-child {
  position: absolute;
  top: 0px;
  left: 0px;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--theme-white-default);
  width: 100%;
  height: 100%;
  display: none;
}
.peticillin-is-prescribed {
  align-self: stretch;
  position: relative;
  line-height: 120px;
  z-index: 1;
}
.expires-june-111 {
  width: 326px;
  position: relative;
  display: inline-block;
  max-width: 100%;
  z-index: 1;
}
.rem-tag-item {
  height: 73px;
  width: 276px;
  position: relative;
  box-shadow: 0px 4px 1px 1px rgba(0, 0, 0, 0.01);
  border-radius: var(--br-31xl);
  background-color: var(--color-deepskyblue);
  display: none;
}
.send-to-user {
  align-self: stretch;
  flex: 1;
  position: relative;
  font-weight: 600;
  z-index: 1;
}
.rem-tag1 {
  align-self: stretch;
  height: 73px;
  box-shadow: 0px 4px 1px 1px rgba(0, 0, 0, 0.01);
  border-radius: var(--br-31xl);
  background-color: var(--color-deepskyblue);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-lgi) var(--padding-25xl) var(--padding-lg)
    var(--padding-26xl);
  box-sizing: border-box;
  white-space: nowrap;
  z-index: 1;
}
.rem-tag-wrapper {
  height: 73px;
  width: 276px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-8xl) 0px 0px;
  box-sizing: border-box;
  color: var(--theme-white-default);
}
.expires-june-11-2023-group {
  width: 1269px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  min-height: 100px;
  max-width: 100%;
  gap: var(--gap-xl);
}
.peticillin-is-prescribed-to-tr-parent {
  position: absolute;
  top: 200px;
  left: 40px;
  width: 1287px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-18xl);
  max-width: 100%;
}
.message-user-icon {
  position: absolute;
  top: -62px;
  right: -16px;
  width: 150px;
  height: 150px;
}
.prescription-2 {
  align-self: stretch;
  height: 497px;
  position: relative;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--theme-white-default);
  max-width: 100%;
  z-index: 1;
  font-size: var(--font-size-11xl);
  color: var(--color-darkgray-400);
}
.pp-content3 {
  flex: 1;
  box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: var(--br-xl);
  background-color: var(--color-whitesmoke-300);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-41xl) var(--padding-35xl) var(--padding-49xl)
    var(--padding-36xl);
  box-sizing: border-box;
  gap: var(--gap-44xl);
  max-width: 100%;
  flex-shrink: 0;
}
.pp-f3 {
  height: 782px;
  flex: 1;
  box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
  overflow-y: auto;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-6xs) var(--padding-4xs) var(--padding-755xl)
    var(--padding-3xs);
  box-sizing: border-box;
  max-width: 100%;
}
.main-f-pp2 {
  flex: 1;
  overflow-y: auto;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  max-width: 100%;
  width: calc(100% - 328);
}
.main-content1 {
  width: 1571px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-end;
  padding: 0px var(--padding-24xl);
  box-sizing: border-box;
  max-width: 100%;
  text-align: left;
  font-size: var(--font-size-21xl);
  color: var(--color-black);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1225px) {
  .pp-content3 {
    padding: var(--padding-20xl) var(--padding-8xl) var(--padding-25xl);
    box-sizing: border-box;
  }

  .pp-f3 {
    padding-top: var(--padding-xl);
    padding-bottom: var(--padding-484xl);
    box-sizing: border-box;
  }

  .main-content1 {
    padding-left: var(--padding-2xl);
    padding-right: var(--padding-2xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 850px) {
  .administer-1-tablet {
    font-size: var(--font-size-5xl);
    line-height: 32px;
  }

  .expires-june-11 {
    font-size: var(--font-size-5xl);
  }

  .expires-june-11-2023-parent {
    flex-wrap: wrap;
  }

  .descriptions {
    gap: var(--gap-lg);
  }

  .prescription-1 {
    gap: var(--gap-10xl);
    padding-top: var(--padding-8xl);
    padding-bottom: var(--padding-7xl);
    box-sizing: border-box;
  }

  .peticillin-is-prescribed {
    font-size: var(--font-size-5xl);
    line-height: 32px;
  }

  .expires-june-111 {
    font-size: var(--font-size-5xl);
  }

  .expires-june-11-2023-group {
    flex-wrap: wrap;
  }

  .prescription-2 {
    height: auto;
    min-height: 497;
  }

  .pp-content3 {
    gap: var(--gap-12xl);
    padding-top: var(--padding-6xl);
    padding-bottom: var(--padding-10xl);
    box-sizing: border-box;
  }

  .pp-f3 {
    height: auto;
    padding-bottom: var(--padding-308xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .administer-1-tablet {
    font-size: var(--font-size-lg);
    line-height: 24px;
  }

  .expires-june-11 {
    font-size: var(--font-size-lg);
  }

  .rem-tag-vbtn {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .peticillin-is-prescribed {
    font-size: var(--font-size-lg);
    line-height: 24px;
  }

  .expires-june-111 {
    font-size: var(--font-size-lg);
  }

  .pp-content3 {
    gap: var(--gap-base);
  }

  .pp-f3 {
    padding-bottom: var(--padding-194xl);
    box-sizing: border-box;
  }
}
</style>
