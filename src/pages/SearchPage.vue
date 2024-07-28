<template>
<navBar></navBar>
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
            <ul class="slang-list">
                <li v-for="slang in filteredSlang" :key="slang.word" class="slang-item">
                    <h3 class="slang-word">{{ slang.word }}</h3>
                    <strong>Meaning:</strong> {{ slang.meaning }}<br>
                    <strong>Example:</strong> {{ slang.example }}
                </li>
            </ul>
        </div>
</template>

<script>
export default {
    data() {
        return {
            slangList: [
                {
                    word: 'Lit',
                    meaning: 'Amazing, exciting, cool',
                    example: 'The party last night was lit!'
                },
                {
                    word: 'Stan',
                    meaning: 'An overzealous fan of a particular celebrity or thing',
                    example: "I'm such a stan of Beyoncé; I know all her songs by heart and have seen all her concerts."
                },
                {
                    word: 'Yeet',
                    meaning: 'An exclamation of excitement, approval, or triumph',
                    example: "I got an A on my test—yeet! I'm so happy and relieved!"
                },
                {
                    word: 'Savage',
                    meaning: 'Fierce, brutally honest, or badass',
                    example: "Did you see how she roasted him? She's so savage! She doesn't hold back and speaks her mind."
                },
                {
                    word: 'GOAT',
                    meaning: 'Greatest of all time',
                    example: "Michael Jordan is the GOAT of basketball. He is widely regarded as the greatest basketball player of all time."
                }
            ],
            searchQuery: ''
        };
    },
    computed: {
        filteredSlang() {
            return this.slangList.filter(slang =>
                slang.word.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    methods: {
        filterSlang() {
            this.filteredSlang = this.slangList.filter(slang =>
                slang.word.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    }
};
</script>

<style scoped>


.search-section {
    display: flex;
    align-items: flex-start;
    background-color: #FF9B3F;
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
    padding: 20px; 
    height: 33.33%; 
}

.slang-list {
    list-style: none; 
    padding: 0; 
}

.slang-item {
    background-color: #f5f5f5; 
    border-radius: 10px; 
    padding: 20px; 
    margin-bottom: 20px; 
}

.slang-word {
    font-size: 24px; 
    margin-bottom: 10px; 
    font-style: italic; 
}
</style>
