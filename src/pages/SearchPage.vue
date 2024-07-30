<template>
    <navBar :activeRoute="currentRoute"></navBar>
    <div class="search-section">
        <div class="search-content">
            <h2 class="search-title">Search the SLANG</h2>
            <div class="search-box">
                <input type="text" placeholder="Search" v-model="searchQuery" @input="filterSlang" />
            </div>
        </div>
        <!-- <div class="logoSection">
            <img :src="require('/src/assets/search.png')" alt="LingoNow" class="logo" height="100px" width="100px" />
        </div> -->
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

.search-section {
    display: flex;
    align-items: center;
    background-color: #FF9B3F;
    justify-content: space-between;
    padding: 10px 20px; 
    padding-bottom: 30px;
}
    
.search-content {
    display: flex;
    flex-direction: column;
    margin-left: 200px;
    margin-right: auto;
    margin-top: 10px; 
}

.search-title {
    font-size: 40px; 
    margin-bottom: 10px; 
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
    border-radius: 25px; 
    background-color: white;
    padding: 5px 10px;
    margin-top: 40px; 
}

.search-box input {
    flex: 1;
    padding: 8px;
    border: none;
    outline: none; 
}

.search-box i {
    margin-left: 10px; 
    color: #007bff; 
    cursor: pointer;
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
