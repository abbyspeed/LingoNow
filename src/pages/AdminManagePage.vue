<template>
  <adminNavBar :activeRoute="currentRoute" class="adminNavBar"></adminNavBar>
    <div class="background">
      <div class="title-section">
        <div class="text">
          <h2>Manage Slangs</h2>
          <p>Welcome to the Manage Slangs page! Here, you can add, edit, or remove slang entries to keep everyone in the loop.</p>
        </div>
      </div>
      
      <div class="manage">
        <img :src="require('/src/assets/settings.png')" alt="Manage Slangs" height="300px" width="300px"/>
      </div>
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
  margin: 0;
  padding-top: 0px;
  box-sizing: border-box;
  font-family: 'Roboto', sans-serif;
}

.body {
  background-color: #f0f0f0;
  color: black;
}

.background {
  width: 100%;
  background-color: #FF9B3F;
  background-size: cover;
  padding: 80px 100px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.title-section {
  flex: 1;
  margin-right: 2rem;
  width: fit-content;
}

.title-section h2,
.title-section p {
  text-align: left;
  padding-left: 40px;
  color: black;
}

.title-section h2 {
  color: #000;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 30px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 20px;
}

</style>