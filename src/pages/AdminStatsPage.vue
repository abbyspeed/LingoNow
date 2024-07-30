<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <h2>UPDATE LATER</h2>
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
      // if (route.path === '/Admin/Home') return 'adminHome';
      // if (route.path === '/Admin/About') return 'adminAbout';
      // if (route.path.startsWith('/Admin/Manage')) return 'adminManage'; // Match any sub-routes under /admin/manage
      // if (route.path === '/Admin/Stats') return 'adminStats';

      // return '';

    });

    const username = computed(() => store.state.user?.username || 'User');

    return {
      currentRoute,
      username
    };
  },
};
</script>