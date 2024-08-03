<template>
  <section class="pet-l-s-2">
    <div class="pet-l-s">
      <div class="pet-l-s-child" />
      <div class="card-layout">
        <div class="pet-tags">
          <div class="pet-tag">
            <div class="pet-tag-child" />
            <b class="dog">DOG</b>
          </div>
          <div class="blacky-card">
            <div class="blacky-details">
              <div class="pet-w-1" @click="onPetWClick">
                <div class="pet-w-1-child" />
                <div class="pet-info">
                  <img class="pet-icon" alt="" src="/pet@2x.png" />
                  <div class="details-label" />
                  <div class="blacky-description">
                    <div class="blacky-name">
                      <div class="blacky">Blacky</div>
                      <div class="german-shepherd">German Shepherd</div>
                      <div class="blacky-image">
                        <img
                          class="image-10-icon"
                          loading="lazy"
                          alt=""
                          src="/image-10@2x.png"
                        />
                        <div class="blacky-owner">
                          <div class="juan-d">Juan D.</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <v-btn
                    class="pet-gender-vbtn"
                    color="primary"
                    variant="flat"
                  />
                </div>
              </div>
            </div>
            <div class="pet-tag1">
              <div class="pet-tag-item" />
              <b class="cat">CAT</b>
            </div>
          </div>
        </div>
        <div class="card-items">
          <div class="pet-w-2">
            <div class="pet-w-1-child" />
            <div class="pet-info1">
              <img class="pet-icon" alt="" src="/pet1@2x.png" />
              <div class="details-label" />
              <div class="details-button">
                <div class="blacky-name">
                  <div class="gummy">Gummy</div>
                  <div class="german-shepherd">Dachshund</div>
                  <div class="dog-image">
                    <img
                      class="image-10-icon"
                      alt=""
                      src="/image-10-1@2x.png"
                    />
                    <div class="blacky-owner">
                      <div class="gorge-b">Gorge B.</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="pet-gender">
                <div class="pet-gender-child" />
                <div class="female">Female</div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-items1">
          <div class="frame-parent21">
            <div class="frame-parent22">
              <div class="see-more-wrapper">
                <h3 class="see-more">See more</h3>
              </div>
              <img
                class="weuiarrow-outlined-icon"
                loading="lazy"
                alt=""
                src="/weuiarrowoutlined.svg"
              />
            </div>
            <div class="second-card">
              <div class="pet-w-2">
                <div class="pet-w-1-child" />
                <div class="pet-info2">
                  <img class="pet-icon" alt="" src="/pet2@2x.png" />
                  <div class="details-label" />
                  <div class="second-card-details">
                    <div class="blacky-name">
                      <div class="pomy">Pomy</div>
                      <div class="german-shepherd">Pomeranian</div>
                      <div class="dog-image">
                        <img
                          class="image-10-icon"
                          alt=""
                          src="/image-10-2@2x.png"
                        />
                        <div class="blacky-owner">
                          <div class="alice-w">Alice W.</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <v-btn
                    class="pet-gender-vbtn"
                    color="primary"
                    variant="flat"
                  />
                </div>
              </div>
              <div class="second-card-button">
                <div class="see-more1">
                  <h3 class="see-more2">See more</h3>
                </div>
                <img
                  class="weuiarrow-outlined-icon1"
                  alt=""
                  src="/weuiarrowoutlined.svg"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pet-w-1-parent">
        <div class="pet-w-11">
          <div class="pet-w-1-item" />
          <div class="pet-info3">
            <img class="pet-icon3" alt="" src="/pet3@2x.png" />
            <div class="pet-info-child" />
            <div class="sian">Sian</div>
            <div class="siamese">Siamese</div>
            <div class="juan-d1">Juan D.</div>
            <div class="pet-gender1">
              <div class="pet-gender-item" />
              <div class="female1">Female</div>
            </div>
            <img class="image-10-icon3" alt="" src="/image-10@2x.png" />
          </div>
        </div>
        <div class="pet-w-21">
          <div class="pet-w-1-item" />
          <div class="pet-info3">
            <img class="pet-icon3" alt="" src="/pet4@2x.png" />
            <div class="pet-info-child" />
            <div class="sian">Gessy</div>
            <div class="siamese">Maine Coon</div>
            <div class="juan-d1">Gorge B.</div>
            <div class="pet-gender2">
              <div class="pet-gender-inner" />
              <div class="female2">Female</div>
            </div>
            <img class="image-10-icon3" alt="" src="/image-10-1@2x.png" />
          </div>
        </div>
        <div class="pet-w-11">
          <div class="pet-w-1-item" />
          <div class="pet-info3">
            <img class="pet-icon3" alt="" src="/pet5@2x.png" />
            <div class="pet-info-child" />
            <div class="sian">Cleo</div>
            <div class="siamese">Sphynx</div>
            <div class="juan-d1">Alice W.</div>
            <div class="pet-gender3">
              <div class="pet-gender-child1" />
              <div class="male">Male</div>
            </div>
            <img class="image-10-icon3" alt="" src="/image-10-2@2x.png" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "PETLS",
  methods: {
    onPetWClick() {
      this.$router.push("/10-p-p");
    },
  },
});
</script>
<style scoped>
.pet-l-s-child {
  width: 1593px;
  height: 2614px;
  position: relative;
  background-color: var(--theme-white-default);
  display: none;
  max-width: 100%;
}
.pet-tag-child {
  height: 76px;
  width: 229px;
  position: relative;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-xl) var(--br-xl) 0px;
  background-color: var(--color-cornflowerblue-100);
  display: none;
}
.dog {
  position: relative;
  display: inline-block;
  min-width: 69px;
  z-index: 1;
}
.pet-tag {
  width: 229px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-xl) var(--br-xl) 0px;
  background-color: var(--color-cornflowerblue-100);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-3xl) var(--padding-57xl) var(--padding-lg);
  box-sizing: border-box;
  z-index: 1;
}
.pet-w-1-child {
  align-self: stretch;
  width: 411px;
  position: relative;
  box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, 0.25);
  border-radius: var(--br-21xl);
  background-color: var(--color-gainsboro-300);
  display: none;
  max-width: 100%;
}
.pet-icon {
  height: 520px;
  width: 411px;
  position: relative;
  border-radius: var(--br-21xl);
  object-fit: cover;
  display: none;
  max-width: 100%;
  z-index: 0;
}
.details-label {
  height: 182px;
  width: 100%;
  position: absolute;
  margin: 0 !important;
  right: 0px;
  bottom: 0px;
  left: 0px;
  box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-21xl) var(--br-21xl) var(--br-21xl);
  background-color: var(--theme-white-default);
  z-index: 1;
}
.blacky {
  position: relative;
  font-weight: 600;
  color: var(--color-black);
  display: inline-block;
  min-width: 82px;
  z-index: 2;
}
.german-shepherd {
  position: relative;
  z-index: 2;
}
.image-10-icon {
  height: 50px;
  width: 50px;
  position: relative;
  border-radius: var(--br-31xl);
  object-fit: cover;
  z-index: 2;
}
.juan-d {
  position: relative;
  display: inline-block;
  min-width: 90px;
  z-index: 2;
}
.blacky-owner {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-3xs) 0px 0px;
}
.blacky-image {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-2xs);
}
.blacky-name {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-7xs);
}
.blacky-description {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-10xs) 0px 0px;
  box-sizing: border-box;
  min-width: 140px;
}
.pet-gender-vbtn {
  z-index: 2;
}
.pet-info {
  flex: 1;
  border-radius: var(--br-21xl);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-350xl) var(--padding-21xl) var(--padding-7xl);
  box-sizing: border-box;
  position: relative;
  gap: var(--gap-7xs);
  background-image: url("/public/pet@2x.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: top;
  max-width: 100%;
  z-index: 1;
}
.pet-w-1 {
  width: 411px;
  box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, 0.25);
  border-radius: var(--br-21xl);
  background-color: var(--color-gainsboro-300);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  max-width: 100%;
  cursor: pointer;
  z-index: 1;
}
.blacky-details {
  align-self: stretch;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-end;
  max-width: 100%;
}
.pet-tag-item {
  position: absolute;
  top: 0px;
  left: 0px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-xl) var(--br-xl) 0px;
  background-color: var(--color-cornflowerblue-100);
  width: 100%;
  height: 100%;
  display: none;
}
.cat {
  position: absolute;
  top: 22px;
  left: 76px;
}
.pet-tag1 {
  width: 229px;
  height: 76px;
  position: relative;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-xl) var(--br-xl) 0px;
  background-color: var(--color-cornflowerblue-100);
  font-size: var(--font-size-11xl);
  color: var(--theme-white-default);
}
.blacky-card {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-31xl);
  max-width: 100%;
  font-size: var(--font-size-6xl);
  color: var(--color-dimgray-100);
}
.pet-tags {
  width: 503px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-39xl);
  max-width: calc(100% - 862px);
  flex-shrink: 0;
}
.gummy {
  position: relative;
  font-weight: 600;
  color: var(--color-black);
  display: inline-block;
  min-width: 94px;
  z-index: 2;
}
.gorge-b {
  position: relative;
  display: inline-block;
  min-width: 104px;
  z-index: 2;
}
.dog-image {
  align-self: stretch;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  gap: var(--gap-2xs);
}
.details-button {
  width: 165px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-10xs) 0px 0px;
  box-sizing: border-box;
  min-width: 165px;
}
.pet-gender-child {
  height: 40px;
  width: 101px;
  position: relative;
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  display: none;
}
.female {
  position: relative;
  font-weight: 600;
  display: inline-block;
  min-width: 70px;
  z-index: 1;
}
.pet-gender {
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-5xs) var(--padding-mini) var(--padding-5xs)
    var(--padding-base);
  z-index: 2;
  font-size: var(--font-size-xl);
  color: var(--theme-white-default);
}
.pet-info1 {
  flex: 1;
  border-radius: var(--br-21xl);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  padding: var(--padding-350xl) var(--padding-29xl) var(--padding-7xl)
    var(--padding-21xl);
  box-sizing: border-box;
  position: relative;
  background-image: url("/public/pet1@2x.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: top;
  max-width: 100%;
  gap: var(--gap-xl);
  z-index: 1;
}
.pet-w-2 {
  align-self: stretch;
  box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, 0.25);
  border-radius: var(--br-21xl);
  background-color: var(--color-gainsboro-300);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  max-width: 100%;
  z-index: 1;
}
.card-items {
  width: 411px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-115xl) 0px 0px;
  box-sizing: border-box;
  max-width: calc(100% - 954px);
  flex-shrink: 0;
  font-size: var(--font-size-6xl);
  color: var(--color-dimgray-100);
}
.see-more {
  margin: 0;
  position: relative;
  font-size: inherit;
  font-weight: 600;
  font-family: inherit;
  z-index: 1;
}
.see-more-wrapper {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-12xs) 0px 0px;
}
.weuiarrow-outlined-icon {
  height: 47px;
  width: 26px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
  z-index: 1;
}
.frame-parent22 {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px 0px 0px var(--padding-xl);
  gap: var(--gap-sm);
}
.pomy {
  position: relative;
  font-weight: 600;
  color: var(--color-black);
  display: inline-block;
  min-width: 68px;
  z-index: 2;
}
.alice-w {
  position: relative;
  display: inline-block;
  min-width: 95px;
  z-index: 2;
}
.second-card-details {
  width: 156px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-10xs) 0px 0px;
  box-sizing: border-box;
  min-width: 156px;
}
.pet-info2 {
  flex: 1;
  border-radius: var(--br-21xl);
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  padding: var(--padding-350xl) var(--padding-29xl) var(--padding-7xl)
    var(--padding-21xl);
  box-sizing: border-box;
  position: relative;
  background-image: url("/public/pet2@2x.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: top;
  max-width: 100%;
  gap: var(--gap-xl);
  z-index: 1;
}
.see-more2 {
  margin: 0;
  align-self: stretch;
  position: relative;
  font-size: inherit;
  font-weight: 600;
  font-family: inherit;
}
.see-more1 {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-12xs) 0px 0px;
}
.weuiarrow-outlined-icon1 {
  height: 47px;
  width: 26px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.second-card-button {
  width: 220px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0px 0px 0px var(--padding-xl);
  box-sizing: border-box;
  gap: var(--gap-sm);
  font-size: var(--font-size-16xl);
  color: var(--color-cornflowerblue-400);
}
.second-card {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: flex-start;
  gap: var(--gap-55xl);
  max-width: 100%;
  font-size: var(--font-size-6xl);
  color: var(--color-dimgray-100);
}
.frame-parent21 {
  align-self: stretch;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: flex-start;
  gap: var(--gap-44xl);
  max-width: 100%;
}
.card-items1 {
  height: 654px;
  width: 411px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: var(--padding-5xl) 0px 0px;
  box-sizing: border-box;
  max-width: calc(100% - 954px);
  font-size: var(--font-size-16xl);
  color: var(--color-cornflowerblue-400);
}
.card-layout {
  align-self: stretch;
  height: 723px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  padding: 0px 0px var(--padding-50xl);
  box-sizing: border-box;
  gap: var(--gap-xl);
  max-width: 100%;
}
.pet-w-1-item {
  position: absolute;
  top: 0px;
  left: 0px;
  box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, 0.25);
  border-radius: var(--br-21xl);
  background-color: var(--color-gainsboro-300);
  width: 100%;
  height: 100%;
  display: none;
}
.pet-icon3 {
  position: absolute;
  top: 0px;
  left: 0px;
  border-radius: var(--br-21xl);
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: none;
}
.pet-info-child {
  position: absolute;
  top: 338px;
  left: 0px;
  box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.25);
  border-radius: 0px var(--br-21xl) var(--br-21xl) var(--br-21xl);
  background-color: var(--theme-white-default);
  width: 411px;
  height: 182px;
}
.sian {
  position: absolute;
  top: 372px;
  left: 40px;
  font-weight: 600;
  color: var(--color-black);
}
.siamese {
  position: absolute;
  top: 406px;
  left: 40px;
}
.juan-d1 {
  position: absolute;
  top: 454px;
  left: 101px;
}
.pet-gender-item {
  position: absolute;
  top: calc(50% - 20px);
  left: calc(50% - 50.5px);
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  width: 100%;
  height: 100%;
  display: none;
}
.female1 {
  position: absolute;
  top: 8px;
  left: calc(50% - 35.5px);
  font-weight: 600;
}
.pet-gender1 {
  position: absolute;
  top: calc(50% + 109px);
  left: calc(50% + 56.5px);
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  width: 101px;
  height: 40px;
  font-size: var(--font-size-xl);
  color: var(--theme-white-default);
}
.image-10-icon3 {
  position: absolute;
  top: 444px;
  left: 40px;
  border-radius: var(--br-31xl);
  width: 50px;
  height: 50px;
  object-fit: cover;
}
.pet-info3 {
  position: absolute;
  top: 0px;
  left: 0px;
  border-radius: var(--br-21xl);
  width: 100%;
  height: 100%;
  background-image: url("/public/pet-info@3x.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: top;
}
.pet-w-11 {
  height: 520px;
  width: 411px;
  position: relative;
  box-shadow: 0px 0px 4px 2px rgba(0, 0, 0, 0.25);
  border-radius: var(--br-21xl);
  background-color: var(--color-gainsboro-300);
  max-width: 100%;
}
.pet-gender-inner {
  position: absolute;
  top: 0px;
  left: 0px;
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  width: 100%;
  height: 100%;
  display: none;
}
.female2 {
  position: absolute;
  top: 8px;
  left: 16px;
  font-weight: 600;
}
.pet-gender2 {
  position: absolute;
  top: 369px;
  left: 262px;
  border-radius: var(--br-3xs);
  background-color: var(--color-orchid);
  width: 101px;
  height: 40px;
  font-size: var(--font-size-xl);
  color: var(--theme-white-default);
}
.pet-w-21 {
  height: 520px;
  width: 411px;
  position: relative;
  max-width: 100%;
}
.pet-gender-child1 {
  position: absolute;
  top: 0px;
  left: 0px;
  border-radius: var(--br-3xs);
  background-color: var(--color-cornflowerblue-100);
  width: 100%;
  height: 100%;
  display: none;
}
.male {
  position: absolute;
  top: 8px;
  left: 27px;
  font-weight: 600;
}
.pet-gender3 {
  position: absolute;
  top: 369px;
  left: 262px;
  border-radius: var(--br-3xs);
  background-color: var(--color-cornflowerblue-100);
  width: 101px;
  height: 40px;
  font-size: var(--font-size-xl);
  color: var(--theme-white-default);
}
.pet-w-1-parent {
  width: 1419px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: space-between;
  padding: 0px 0px 0px var(--padding-xl);
  box-sizing: border-box;
  max-width: 100%;
  gap: var(--gap-xl);
  font-size: var(--font-size-6xl);
  color: var(--color-dimgray-100);
}
.pet-l-s {
  flex: 1;
  background-color: var(--theme-white-default);
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: flex-start;
  padding: var(--padding-24xl) var(--padding-83xl) var(--padding-1194xl) 0px;
  box-sizing: border-box;
  max-width: 100%;
}
.pet-l-s-2 {
  align-self: stretch;
  height: 100vh;
  overflow-y: visible;
  flex-shrink: 0;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  max-width: 100%;
  text-align: left;
  font-size: var(--font-size-11xl);
  color: var(--theme-white-default);
  font-family: var(--font-inter);
}

@media screen and (max-width: 1500px) {
  .pet-w-1-parent {
    flex-wrap: wrap;
  }
}
@media screen and (max-width: 1225px) {
  .pet-tags {
    display: none;
    max-width: 100%;
  }

  .card-items {
    display: none;
    max-width: 100%;
  }

  .card-items1 {
    display: none;
    max-width: 100%;
  }

  .card-layout {
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    padding-bottom: var(--padding-26xl);
    box-sizing: border-box;
  }

  .pet-l-s {
    padding-top: var(--padding-xl);
    padding-right: var(--padding-32xl);
    padding-bottom: var(--padding-493xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 850px) {
  .dog {
    font-size: var(--font-size-5xl);
  }

  .pet-info {
    padding-top: var(--padding-221xl);
    padding-bottom: var(--padding-xl);
    box-sizing: border-box;
  }

  .cat {
    font-size: var(--font-size-5xl);
  }

  .blacky-card {
    gap: var(--gap-6xl);
  }

  .pet-tags {
    gap: var(--gap-10xl);
  }

  .pet-info1 {
    padding-top: var(--padding-221xl);
    padding-bottom: var(--padding-xl);
    box-sizing: border-box;
  }

  .card-items {
    padding-top: var(--padding-68xl);
    box-sizing: border-box;
  }

  .see-more {
    font-size: var(--font-size-9xl);
  }

  .pet-info2 {
    padding-top: var(--padding-221xl);
    padding-bottom: var(--padding-xl);
    box-sizing: border-box;
  }

  .see-more2 {
    font-size: var(--font-size-9xl);
  }

  .pet-l-s {
    gap: var(--gap-38xl);
    padding-right: var(--padding-6xl);
    padding-bottom: var(--padding-314xl);
    box-sizing: border-box;
  }
}
@media screen and (max-width: 450px) {
  .dog {
    font-size: var(--font-size-lg);
  }

  .blacky {
    font-size: var(--font-size-xl);
  }

  .german-shepherd {
    font-size: var(--font-size-xl);
  }

  .juan-d {
    font-size: var(--font-size-xl);
  }

  .pet-info {
    flex-wrap: wrap;
  }

  .cat {
    font-size: var(--font-size-lg);
  }

  .gummy {
    font-size: var(--font-size-xl);
  }

  .gorge-b {
    font-size: var(--font-size-xl);
  }

  .details-button {
    flex: 1;
  }

  .female {
    font-size: var(--font-size-base);
  }

  .pet-info1 {
    flex-wrap: wrap;
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .see-more {
    font-size: var(--font-size-2xl);
  }

  .pomy {
    font-size: var(--font-size-xl);
  }

  .alice-w {
    font-size: var(--font-size-xl);
  }

  .second-card-details {
    flex: 1;
  }

  .pet-info2 {
    flex-wrap: wrap;
    padding-left: var(--padding-xl);
    padding-right: var(--padding-xl);
    box-sizing: border-box;
  }

  .see-more2 {
    font-size: var(--font-size-2xl);
  }

  .second-card {
    gap: var(--gap-18xl);
  }

  .frame-parent21 {
    gap: var(--gap-12xl);
  }

  .card-items1 {
    height: auto;
  }

  .card-layout {
    height: auto;
    padding-bottom: var(--padding-10xl);
    box-sizing: border-box;
  }

  .sian {
    font-size: var(--font-size-xl);
  }

  .siamese {
    font-size: var(--font-size-xl);
  }

  .juan-d1 {
    font-size: var(--font-size-xl);
  }

  .female1 {
    font-size: var(--font-size-base);
  }

  .female2 {
    font-size: var(--font-size-base);
  }

  .male {
    font-size: var(--font-size-base);
  }

  .pet-l-s {
    gap: var(--gap-10xl);
  }

  .pet-l-s-2 {
    height: auto;
  }
}
</style>
