<template>
    <div class="rectangle-container">
        <div class="rectangle-div">
            <h3 class="section-title">Recently Added</h3>
            <div class="recent-slang">Bussin'</div>
            <div class="recent-slang">Vibe check</div>
            <div class="recent-slang">Ditch'</div>
        </div>

        <div class="rectangle-div">
            <h3 class="section-title">Today's Slang</h3>
            <div class="slang-term">Delulu</div>
            <p class="slang-description">The term “delulu” is a slang abbreviation of the word “delusional”. Describe individuals who display odd or extreme behaviour, particularly superfans or dating partners.</p>
        </div>

        <div class="rectangle-div">
            <h3 class="section-title">Top Used Slang</h3>
            <div class="slang-list">1. IYKYK</div>
            <div class="slang-list">2. Slay</div>
            <div class="slang-list">3. Lit</div>
            <div class="slang-list">4. GOAT</div>
            <div class="slang-list">5. Rizz</div>
        </div>
    </div>
</template>

<script>
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
