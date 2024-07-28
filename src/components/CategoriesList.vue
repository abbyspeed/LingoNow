<template>
  <div class="category">
    <h3>Category: {{ category.title }}</h3>
    <div v-for="(result, index) in results" :key="index">
      <div class="result-row">
        <div class="word-bar">{{ result.word }}</div>
        <div class="likes-dislikes">
          <span>{{ result.likes }}</span>
          <button @click="like(result.slangId, index)"><img src="@/assets/like-icon.png" alt="Like"></button>
          <span>{{ result.dislikes }}</span>
          <button @click="dislike(result.slangId, index)"><img src="@/assets/dislike-icon.png" alt="Dislike"></button>
        </div>
      </div>
      <div class="meaning">
        Meaning:
        <p>{{ result.meaning }}</p>
        <hr v-if="index < results.length - 1" />
      </div>
    </div>
    <!-- <div class="paging">
      <button @click="changePage(1)" :disabled="currentPage === 1">1</button>
      <button @click="changePage(2)" :disabled="currentPage === 2">2</button>
      <button @click="changePage(3)" :disabled="currentPage === 3">3</button>
    </div> -->
  </div>
</template>

<script>
export default {
  name: 'CategoryList',
  props: {
    category: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      results: [],
    };
  },
  watch: {
    category: {
      handler(newCategory) {
        if (newCategory) {
          this.fetchSlangData(newCategory.categoryId);
        }
      },
      immediate: true,
    },
  },
  methods: {
    async fetchSlangData(categoryId) {
      try {
        const response = await fetch('http://localhost/lingonowAPI/index.php/Categories');
        if (!response.ok) {
          throw new Error('Failed to fetch data');
        }
        const data = await response.json();
        const categoryData = data.find(cat => cat.categoryId === categoryId);
        this.results = categoryData ? categoryData.slangTerms : [];
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    async like(slangId, index) {
      try {
        await fetch(`/api/slang/${slangId}/like`, { method: 'POST' });
        this.results[index].likes += 1;
      } catch (error) {
        console.error('Error liking:', error);
      }
    },
    async dislike(slangId, index) {
      try {
        await fetch(`/api/slang/${slangId}/dislike`, { method: 'POST' });
        this.results[index].dislikes += 1;
      } catch (error) {
        console.error('Error disliking:', error);
      }
    },
  },
};
</script>

<style scoped>
.category {
  background-color: white;
  padding: 50px 100px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: flex-start;
}

.result-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin-bottom: 1rem;
}

.word-bar {
  background-color: orange;
  padding: 5px 10px;
  border-radius: 5px;
  font-weight: bold;
  color: black;
}

.likes-dislikes {
  display: flex;
  align-items: center;
}

.likes-dislikes span {
  margin-right: 0.5rem;
  font-weight: bold;
}

.likes-dislikes button {
  background-color: white;
  border: none;
  cursor: pointer;
  margin-left: 0.5rem;
}

.likes-dislikes button img {
  width: 20px;
  height: 20px;
}

.likes-dislikes button:hover img {
  filter: invert(100%);
}

.meaning {
  font-weight: bold;
  margin-top: 1rem;
  text-align: left;
}

.meaning p {
  margin-top: 0.5rem;
  font-weight: normal;
  text-align: left;
}

.paging {
  text-align: center;
  margin-top: 20px;
}

.paging button {
  margin: 0 5px;
}
</style>