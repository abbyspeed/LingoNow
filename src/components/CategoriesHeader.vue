<template>
<div class="categoriesHeader">
    <div class="description">
      <h2>Categories</h2>
      <div class="buttons-container">
        <button v-for="category in categories" :key="category.categoryId" @click="selectCategory(category)">
          {{ category.title }}
        </button>
      </div>
    </div>
      <div class="penguin">
        <img src="@/assets/logo.png" alt="Penguin Flat Image" height="300px" width="300px">
      </div>
    </div>
  </template>
  
 <script>
export default {
  name: 'CategoriesPage',

  data() {
    return {
      categories: [],
    };
  },

  mounted() {
    this.fetchCategories();
  },

  methods: {
    async fetchCategories() {
      try {
        const response = await fetch('http://localhost/lingonowAPI/index.php/categories');
        if (!response.ok || response == null) {
          throw new Error('Failed to fetch categories');
        } else {
          const data = await response.json();
          this.categories = data && data.map(cat => ({ categoryId: cat.categoryId, title: cat.title }));
        }
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    selectCategory(category) {
      this.$emit('category-selected', category);
    },
  },
};
</script>
  
  <style scoped>
  .categoriesHeader {
    background-color: #FF9B3F;
    padding: 50px 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .description {
    flex: 1;
    margin-right: 2rem;
  }
  
  .description h2 {
    margin-bottom: 1rem;
    color: black;
  }
  
  .buttons-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  
  .buttons-container button {
    flex: 1 1 calc(25% - 10px);
    padding: 10px 20px;
    border-radius: 20px;
    background-color: white;
    color: black;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
  }
  
  .buttons-container button:hover,
  .buttons-container button:active {
    background-color: black;
    color: white;
  }
  
  .penguin {
    display: flex;
    align-items: center;
  }
  </style>