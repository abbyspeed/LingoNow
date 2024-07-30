<template>
  <adminNavBar :activeRoute="currentRoute"></adminNavBar>
  <div class="background">
    <welcomeAdmin></welcomeAdmin>
    <slangStatistic></slangStatistic>
  </div>
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

body {
  background-color: #f0f0f0;
  color: black;
}

.background {
  width: 100%;
  background-color: #FF9B3F;
  background-size: cover;
}
</style>