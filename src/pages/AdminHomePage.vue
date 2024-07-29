<template>
  <adminNavBar :activeRoute="currentRoute"></adminNavBar>
  <h2>Manage Slangs</h2>
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
      switch (route.path) {
        case '/Admin/Home':
          return 'adminHome';

        case '/Admin/About':
          return 'adminAbout';

        // case '/Admin/Categories':
        //   return 'categories';
        
        case 'Admin/Manage':
          return 'adminManage';
          
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
.newSlang {
    background-color: #ff9b3f;
    border-radius: 5px;
    border: none;
    margin-bottom: 30px;
    padding: 10px;
    cursor: pointer;
    color: #2C3E50;
}
</style>