<template>
    <navBar :activeRoute="currentRoute"></navBar>
        <div class="search">
        <div class="search-section">
            <h2 class="search-title">Search the SLANG</h2>
            <section class="search-container">
                <form class="search-form" role="search" @submit.prevent>
                    <label for="search-input" class="visually-hidden">Search your slang...</label>
                    <input type="search" id="search-input" class="search-input" placeholder="Search your slang..." aria-label="Search your slang..." v-model="searchQuery" @input="filterSlang" />
                    <button type="submit" class="search-button">
                        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/29febdd82fa653c3bfa21b2be25d8331191af8f5bcd2e611cb48f49ca70e8ace?apiKey=d314e47cd2b145d4ba1bdf6144e8401a" alt="Search Icon" class="search-icon">
                    </button>
                </form>
            </section>
        </div>

        <div class="penguin">
            <img src="@/assets/logo.png" alt="Penguin Flat Image" height="300px" width="300px" />
        </div>
    </div>
    
    <div class="slanglist-section">
         <div v-for="(slang, index) in filteredSlang" :key="slang.slangId">
            <div class="result-row">
                <div class="word-bar">{{ slang.word }}</div>
                <div class="likes-dislikes">
                    <span>{{ slang.likes }}</span>
                    <button @click="like(slang.slangId, index)"><img src="@/assets/like-icon.png" alt="Like"></button>
                    <span>{{ slang.dislikes }}</span>
                    <button @click="dislike(slang.slangId, index)"><img src="@/assets/dislike-icon.png" alt="Dislike"></button>
                </div>
            </div>
            <div class="meaning">
                Meaning:
                <p>{{ slang.meaning }}</p>
                <hr v-if="index < filteredSlang.length - 1" />
            </div>
        </div>
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
    data() {
        return {
            slangList: [],  
            searchQuery: '',
        };
    },
    computed: {
        filteredSlang() {
            if (Array.isArray(this.slangList)) {
                return this.slangList.filter(slang =>
                    slang.word.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            return []; 
        }
    },
    methods: {
        async fetchSlangData() {
            try {
                const response = await fetch('http://localhost/lingonowAPI/index.php/slangs');
                if (!response.ok) {
                    throw new Error(`Failed to fetch data: ${response.statusText}`);
                }
                const data = await response.json();
                if (Array.isArray(data.slangs)) {
                    this.slangList = data.slangs;
                } else {
                    console.error('Fetched data does not contain an array in "slangs":', data);
                    this.slangList = []; 
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        async like(slangId) {
            try {
                await fetch(`/api/slang/${slangId}/like`, { method: 'POST' });
                const slang = this.slangList.find(s => s.slangId === slangId);
                if (slang) slang.likes += 1;
            } catch (error) {
                console.error('Error liking:', error);
            }
        },
        async dislike(slangId) {
            try {
                await fetch(`/api/slang/${slangId}/dislike`, { method: 'POST' });
                const slang = this.slangList.find(s => s.slangId === slangId);
                if (slang) slang.dislikes += 1;
            } catch (error) {
                console.error('Error disliking:', error);
            }
        }
    },
    mounted() {
        this.fetchSlangData();
    }
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

.search {
  background-color: #FF9B3F;
  padding: 100px 100px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.search-section {
  flex: 1;
  margin-right: 2rem;
  width: fit-content;
}

.search-title {
  color: #000;
  text-align: center;
  font-family: Arial, Helvetica, sans-serif;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 10px;
}

.search-container {
  border-radius: 50px;
  background-color: rgba(255, 255, 255, 1);
  display: flex;
  margin-top: 0px;
  font-size: 20px;
  color: #6e6e6e;
  font-weight: 400;
  padding: 18px 30px;
  width: 500px;
  height: 40px;
  margin: auto;
}

@media (max-width: 991px) {
  .search-container {
    max-width: 100%;
    flex-wrap: wrap;
    padding: 0 20px;
  }
}

.search-form {
  display: flex;
  align-items: center;
  width: 100%;
}

.search-input {
  font-family: Inter, sans-serif;
  flex-grow: 1;
  flex-basis: auto;
  border: none;
  outline: none;
  font-size: inherit;
  color: inherit;
}

.visually-hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}

.search-button {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.search-icon {
  aspect-ratio: 1.03;
  object-fit: auto;
  object-position: center;
  width: 36px;
}


.slanglist-section {
    background-color: white;
    padding: 50px 100px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start; 
}

.slang-list {
    list-style: none; 
    padding: 0; 
}

.slang-item {
    display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin-bottom: 1rem;
}

.slang-word {
    font-size: 24px; 
    margin-bottom: 10px; 
    font-style: italic; 
}

.likes-dislikes {
    display: flex;
    align-items: center;
    margin-top: 10px; 
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
</style>
