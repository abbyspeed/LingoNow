<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <h2>Manage Slangs</h2>
    <slangTable></slangTable>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router'

export default {
  setup() {
    const route = useRoute();
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

    return {
      currentRoute,
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