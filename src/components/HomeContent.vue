<template>
    <div class="rectangle-container">
        <div class="rectangle-div">
            <h3 class="section-title">Recently Added</h3>
            <div v-for="(slang, index) in recentSlangs" :key="index" class="recent-slang">
                {{ slang.word }}
            </div>
        </div>

        <div class="rectangle-div">
            <h3 class="section-title">Today's Slang</h3>
            <div class="slang-term">{{ todaysSlang.word }}</div>
            <p class="slang-description">{{ todaysSlang.meaning }}</p>
        </div>

        <div class="rectangle-div">
            <h3 class="section-title">Top Used Slang</h3>
            <div v-for="(slang, index) in topSlangs" :key="index" class="slang-list">
                {{ slang.word }}
            </div>
        </div>
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
            recentSlangs: [], 
            todaysSlang: { term: '', description: '' }, 
            topSlangs: []
        };
    },

    async mounted(){
        await this.fetchSlangs();
    },

    methods: {
        async fetchSlangs() {
            try {
                const response = await fetch('http://localhost/lingonowAPI/index.php/slangs');
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const data = await response.json();
                // this.results.value = data;
                // this.processSlangs(data);

                const slangs = data.slangs || [];

                if (Array.isArray(slangs)) {
                    this.processSlangs(slangs);
                    
                } else {    
                    console.error('Slangs is not an array:', slangs);
                    this.recentSlangs = [];
                    this.todaysSlang = { term: 'No slang available', description: '' };
                    this.topSlangs = [];
                }

        } catch (error) {
                console.error('Error fetching data:', error);
        }
        },

    processSlangs(slangs){
        if(!Array.isArray(slangs)){
            console.error('Slangs is not an array: ', slangs);
            return;
        }
        // Sort slangs by creation date to get the most recent ones
        const sortedByDate = slangs.slice().sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));

        // Get the top 3 recent slangs
        this.recentSlangs = sortedByDate.slice(0, 3);

        // Filter slangs added today
        const today = new Date().toISOString().split('T')[0];
        const todaysOptions = slangs.filter(slang => slang.lastUpdated.startsWith(today));

        // Select one random slang from today's options if available
        if (todaysOptions.length > 0) {
            this.todaysSlang = todaysOptions[Math.floor(Math.random() * todaysOptions.length)];
        
        } else {
            this.todaysSlang = { term: 'No slang for today', description: '' };
        }

        // Get 5 random slangs for topSlangs
        const shuffled = slangs.slice().sort(() => 0.5 - Math.random());
        this.topSlangs = shuffled.slice(0, 5);

        console.log();
    }
  },
};
</script>

<style>
.rectangle-container {
    background-color: white;
    display: flex;
    flex-direction: row; 
    align-items: center; 
    justify-content: center; 
    padding: 100px;
    height: 500px; 
}

.rectangle-div {
    color: black;
    border: 2px solid black;
    border-radius: 15px; 
    width: 400px; 
    height: 300px; 
    margin: 0 20px; 
    text-align: center; 
    padding: 20px; 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    position: relative; 
}

.section-title {
    margin-bottom: 5px; 
    font-size: 25px;
}

.recent-slang, .slang-term {
    background-color: #FF9B3F;
    border-radius: 15px;
    font-family: 'Courier New', Courier, monospace; 
    font-size: 20px;
    font-weight: bold;
    padding: 10px; 
    width: calc(100% - 20px); 
    margin: auto; 
    box-sizing: border-box; 
}

.slang-description {
    padding: 10px; 
    margin-top: 10px; 
}

.slang-list {
    padding: 12px; 
    font-family: 'Courier New', Courier, monospace; 
    font-size: 20px;
    font-weight: bold;
}
</style>
