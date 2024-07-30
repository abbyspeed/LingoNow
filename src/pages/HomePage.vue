<template>
  <div class="cont">
    <header class="header">
      <navBar :activeRoute="currentRoute"></navBar>
      <div class="search-section">
        <h2 class="search-title">Search the SLANG</h2>
        <section class="search-container">
          <form class="search-form" role="search">
            <label for="search-input" class="visually-hidden">Search your slang...</label>
            <input type="search" id="search-input" class="search-input" placeholder="Search your slang..." aria-label="Search your slang...">
            <button type="submit" class="search-button">
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/29febdd82fa653c3bfa21b2be25d8331191af8f5bcd2e611cb48f49ca70e8ace?apiKey=d314e47cd2b145d4ba1bdf6144e8401a" alt="Search Icon" class="search-icon">
            </button>
          </form>
        </section>
      </div>
      <aside class="image-column">
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/47c5ca4f2082069e4c5389ff4a00f7678d0f6bb81bb554cab645de1bce1fc080?apiKey=d314e47cd2b145d4ba1bdf6144e8401a" alt="Decorative image" class="decorative-image">
      </aside> 
    </header>

    <main class="main-content">
      <div class="rectangle-container">
        <div class="rectangle-div">
          <section class="recent-section">
            <h2 class="section-title">Recently Added</h2>
            <div class="item-button">Bussin’</div>
            <div class="item-button">Vibe check</div>
            <div class="item-button">Ditch</div>
          </section>
        </div>

        <div class="rectangle-div">
          <section class="todays-slang">
            <h2 class="section-title">Today’s Slang</h2>
              <div class="item-button">Delulu</div>
              <p class="slang-description">The term “delulu” is a slang abbreviation of the word “delusional”. Describe individuals who display odd or extreme behaviour, particularly superfans or dating partners.</p>
          </section>
        </div>

        <div class="rectangle-div">
          <section class="top-used-slang">
            <h2 class="section-title">Top Used Slang</h2>
              <div style="height: 20px"></div>
              <div class="list">1. IYKYK</div>
              <div class="list">2. Slay</div>
              <div class="list">3. Lit</div>
              <div class="list">4. Goat</div>
              <div class="list">5. Rizz</div>
          </section>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router'

export default {
  setup() {
    const route = useRoute();
    const currentRoute = computed(() => {
      switch (route.path) {
        case '/':
          return 'home';

        case '/About':
          return 'about';

        case '/Categories':
          return 'categories';

        default:
          return '';
      }
    });

    return {
      currentRoute,
    };
  },
};
</script>

<style scoped>
.cont {
  background-color: #fff;
  display: flex;
  flex-direction: column;
  margin: 0;
  padding: 0;
  overflow: hidden;
  height: 1040px;
  height: max-content; 
  padding-top: 70px;
}

.header {
  background-color: #ff9b3f;
  height: 400px;
  flex-shrink: 0;
  position: relative;
}

.navbar {
  width: 1850px;
  height: 75px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
  box-sizing: border-box;
  color: white;
  background-color: #FF9B3F;
  font-family: 'Inter', sans-serif;
}

.logo {
  font-size: 24px;
  color: #000;
  font-weight: 700;
  text-align: center;
  font-family: Inter, sans-serif;
  margin-left: 100px;
  margin-right: 300px;
}

.menu {
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 2;
  border-left: 100px;
}

.menu ul {
  list-style: none;
  display: flex;
  padding: 0;
  margin: 0;
}

.menu ul li {
  margin-left: 20px;
}

.menu ul li a {
  text-decoration: none;
  color: #fff;
  font-family: Arial;
  font-weight: bold;
  transition: 0.4s ease-in-out;
  padding: 10px 30px;
  font-size: 16px;
}

.menu ul li a:hover {
  color: #ff7200;
}

.login-item {
  padding-top: 20px;
  margin-left: 10px;
  font-size: 32px;
  display: inline-block;
  font-family: Inter;
  color: #000;
  text-align: center;
}

.menu-icon {
  width: 30px;
  height: auto;
  margin-left: 570px;
}

.search-section {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  position: absolute;
  top: 50%;
  left: 10%;
  transform: translateY(-50%);
}

.search-title {
  color: #000;
  text-align: center;
  font-family: Inter;
  font-size: 64px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin: 20px 0;
}

.search-container {
  border-radius: 50px;
  background-color: rgba(255, 255, 255, 1);
  display: flex;
  margin-top: 0px;
  font-size: 32px;
  color: #6e6e6e;
  font-weight: 400;
  padding: 18px 30px;
}

@media (max-width: 991px) {
  .search-container {
    max-width: 100%;
    flex-wrap: wrap;
    padding: 0 20px;
  }
}

.search-form {
  display: flex;
  align-items: center;
  width: 100%;
}

.search-input {
  font-family: Inter, sans-serif;
  flex-grow: 1;
  flex-basis: auto;
  border: none;
  outline: none;
  font-size: inherit;
  color: inherit;
}

.visually-hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}

.search-button {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.search-icon {
  aspect-ratio: 1.03;
  object-fit: auto;
  object-position: center;
  width: 36px;
}

.image-column { 
  display: flex; 
  flex-direction: column; 
  width: 100px; 
  margin-left: 1500px;
  margin-top: 30px;
}

.decorative-image { 
  width: 350.5px; 
}

.main-content {
  justify-content: space-between;
  margin-top: 75px;
}

.rectangle-container {
  display: flex;
  align-items: center;
  justify-content: center;
  column-gap: 50px;
}

.rectangle-div {
  width: 350px; 
  position: relative;
  border-radius: 25px;
  background-color: rgba(117, 117, 117, 0);
  border: 3px solid #757575;
  box-sizing: border-box;
  height: 380px;
}

.recent-section,
.todays-slang,
.top-used-slang {
  padding: 20px;
  display: grid;
  justify-items: center;
}

.section-title {
  width: 249px;
  position: relative;
  font-size: 32px;
  display: inline-block;
  font-family: Inter;
  color: #000;
  text-align: center;
}

.item-button {
  font-family: JetBrains Mono, sans-serif;
  border-radius: 20px;
  background-color: rgba(255, 155, 63, 1);
  margin-top: 15px;
  justify-content: center;
  padding: 20px 50px;
  cursor: pointer;
  border: none;
  width: 160px;
  font-size: 16px;
}

.list {
  text-align: left;
  width: 100%;
}

@media (max-width: 991px) {
  .item-button {
    white-space: initial;
    padding: 0 20px;
  }
  .list {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    padding-left: 32px;
    text-align: left !important;
  }
}

.top-used-slang {
  text-align: left;
}

/* .slang-item {
  font-family: JetBrains Mono, sans-serif;
  border-radius: 10px;
  background-color: rgba(255, 155, 63, 1);
  padding: 5px 10px;
  text-align: center;
}

.slang-term {
  font-family: JetBrains Mono, sans-serif;
  border-radius: 20px;
  background-color: rgba(255, 155, 63, 1);
  margin-top: 15px;
  white-space: nowrap;
  justify-content: center;
  padding: 19px 60px;
  cursor: pointer;
  border: none;
  width: 160px; /* Assuming 40% of a container width of 1850px */
  /* margin-left: 50px;
  font-size: 24px; 
} */

.slang-description {
  font-size: 17px;
  font-family: Inter;
  color: #000;
  text-align: justify;
  margin-top: 20px;
}

.logoSection {
  display: flex;
  align-items: center;
  flex: 1;
  min-width: 200px;
  padding: 0px;
}

.logoSection h2 {
  margin: 0;
  font-size: 18px;
}

.logo {
  width: 40px;
  height: auto;
  margin-right: 10px;
}

</style>