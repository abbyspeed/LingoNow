<template>
  <div class="team">
    <h3>Developer Team</h3>
    <div class="developers">
      <OurDeveloper name="Hana Humaira" :imgSrc="require('@/assets/hana_humaira.jpg')" />
      <OurDeveloper name="Haneen Mo'men" :imgSrc="require('@/assets/haneen.jpg')" />
      <OurDeveloper name="Wan Nurnabihah" :imgSrc="require('@/assets/wan_nurnabihah.jpg')" />
      <OurDeveloper name="Norliyana Aisyah" :imgSrc="require('@/assets/norliyana.jpg')" />
      <OurDeveloper name="Sakif Hossain" :imgSrc="require('@/assets/user.png')" />
    </div>
  </div>
</template>

<script>
import OurDeveloper from './OurDeveloper.vue';

export default {
  components: {
    OurDeveloper
  }
};
</script>

<style scoped>
.team {
  background-color: #FF9B3F;
  padding: 50px 100px;
  color: black;
}

.team h3 {
  text-align: center;
  margin-bottom: 2rem;
}

.developers {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 50px;
}
</style>
