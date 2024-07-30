<template>
  <div>
    <navBar :activeRoute="currentRoute"></navBar>
    <div class="background">
      <categoriesHeader @category-selected="handleCategorySelected" />
      <categoriesList v-if="selectedCategory" :category="selectedCategory" />
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router'
import { useStore } from 'vuex';
import categoriesHeader from '../components/CategoriesHeader.vue';
import categoriesList from '../components/CategoriesList.vue';

export default {
  setup() {
    const route = useRoute();
    const store = useStore();

    const currentRoute = computed(() => {
      console.log('Current path:', route.path);
      switch (route.path) {
        case '/':
          return 'home';

        case '/Search':
          return 'search';
        
        case '/About':
          return 'about';

        case '/Categories':
          return 'categories';

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

  components: {
    categoriesHeader,
    categoriesList,
  },
  data() {
    return {
      selectedCategory: null,
    };
  },
  methods: {
    handleCategorySelected(category) {
      this.selectedCategory = category;
    },
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
  background-color: FF9B3F;
  background-size: cover;
  padding-top: 70px;
}
</style>
  