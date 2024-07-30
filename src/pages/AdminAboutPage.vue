<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <div class="background">
        <aboutLingo></aboutLingo>
        <visionMission></visionMission>
        <ourTeam></ourTeam>
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
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}

body {
    background-color: #f0f0f0;
    color: black;
}

.background {
    width: 100%;
    padding-top: 70px;
    background-color: FF9B3F;
    background-size: cover;
}
</style>
    