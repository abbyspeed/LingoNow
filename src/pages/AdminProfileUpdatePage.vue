<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <h2>UPDATE SOON</h2>
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
    padding-top: 100px;
}
</style>