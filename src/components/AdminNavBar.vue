<template>
  <div class="navbar">
    <router-link to="/Admin/Home">
      <div class="logoSection">
        <img :src="require('/src/assets/logo.png')" alt="LingoNow" class="logo" />
        <h2>LingoNow</h2>
      </div>
    </router-link>
    <div class="menu">
      <ul :class="{ 'nav-links': true, 'nav-active': isActive }">
        <li :class="{ 'active-link': activeRoute === 'adminHome'}">
          <router-link to="/Admin/Home" active-class="active-link" exact>Home</router-link>
        </li>
        <li :class="{ 'active-link': activeRoute === 'adminAbout'}">
          <router-link to="/Admin/About" active-class="active-link" exact>About Us</router-link>
        </li>
        <li :class="{ 'active-link': activeRoute === 'adminManage'}">
          <router-link to="/Admin/Manage" active-class="active-link" exact>Manage</router-link>
        </li>
        <li :class="{ 'active-link': activeRoute === 'adminStats'}">
          <router-link to="/Admin/Stats" active-class="active-link" exact>Statistics</router-link>
        </li>
      </ul>
    </div>
    <div class="userProfile">
      <profileDropdown :options="dropdownOptions">
        <template #trigger>
          <img :src="require('/src/assets/user.png')" alt="user" class="user" />
          <p>User</p>
        </template>
      </profileDropdown>
    </div>
  </div>
</template>
  
<script>
// import { mapActions } from 'vuex';
import { useRouter } from 'vue-router';

export default {
  props: {
    activeRoute: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      isActive: false,
      dropdownOptions: [
        { label: 'Profile', path: '/Admin/Profile' },
        { label: 'Logout', path: '/', callback: this.logout }  
      ]
    };
  },

  methods: {
    // ...mapActions(['logout']),

    async logout(){
      // await this.$store.dispatch('logout');
      console.log("Logged out");

      useRouter.push('/'); 
    }
  }
};
</script>

<style scoped>
.navbar {
  width: 100%;
  height: 75px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
  box-sizing: border-box;
  color: white;
  background-color: #FF9B3F;
  font-family: 'Inter', sans-serif;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}

.navbar a {
  text-decoration: none;
}

.logoSection {
  display: flex;
  align-items: center;
  flex: 1;
  min-width: 200px;
  padding: 0px;
  color: white;
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

.menu {
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 2;
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
  transition: color 0.3s;
}

.menu ul li a:hover {
  color: black;
}

.menu ul li .active-link {
  color: black; /* Active link color */
  font-weight: bold; /* Optional: make it bold */
}

.userProfile {
  display: flex;
  align-items: center;
  flex: 1;
  justify-content: flex-end;
  max-width: 200px;
  flex-direction: column;
}

.user {
  width: 40px;
  height: auto;
  border-radius: 50%;
  margin-left: 10px;
}

.userProfile p {
  margin-left: 10px;
}

@media (max-width: 780px) {
  .menu ul {
    flex-direction: column;
    align-items: center;
  }

  .menu ul li {
    padding: 10px 20px;
  }
}
</style>