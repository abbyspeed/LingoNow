<template>
  <adminNavBar :activeRoute="currentRoute" class="adminNavBar"></adminNavBar>
    <div class="background"></div>
    <div class="title-section">
      <div class="text">
        <h2>Manage Slangs</h2>
        <p>Welcome to the Manage Slangs page! Here, you can add, edit, or remove slang entries to keep everyone in the loop.</p>
      </div>
      <img :src="require('/src/assets/settings.png')" alt="Manage Slangs" class="manage" />
    </div>
  <slangTable></slangTable>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router'
import { useStore } from 'vuex';

export default {
  setup() {
    const route = useRoute();
    const store = useStore();

    const currentRoute = computed(() => {
      console.log('Current path:', route.path);
      switch (route.path) {
        case '/Admin/Home':
          return 'adminHome';

        case '/Admin/About':
          return 'adminAbout';
        
        case '/Admin/Manage':
          return 'adminManage';

        case '/Admin/Manage/Create':
          return 'adminManage';

        case '/Admin/Manage/:id/Update':
          return 'adminManage';

        case '/Admin/Stats':
          return 'adminStats';
          
        default:
          return '';
      }
    });

    const username = computed(() => store.state.user?.username || 'User');

    return {
      currentRoute,
      username
    };
  },
};
</script>

<style scoped>
* {
  box-sizing: border-box;
  /* overflow-x: hidden; */
}

.background {
  position: absolute; 
  width: 100vw; 
  height: 400px;  
  background-color: #FF9B3F;  
  color: white; 
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px; 
  top: 0px;  
  z-index: 0; 
}

.title-section {
  display: flex;
  padding: 100px 25px 20px 25px;
  justify-content: space-around;
  align-items: center; 
  flex-direction: row;
  position: relative; 
  z-index: 2;  
  width: 100%;
}

.title-section h2,
.title-section p {
  text-align: left;
}

.title-section h2 {
  color: #000;
  font-family: Inter;
  font-size: 64px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 20px;
}

.manage {
  width: auto;
  height: auto;
  border-radius: 50%;
  /* margin-left: 10px; */
  margin: 20px 25px 20px 25px;
}
</style>