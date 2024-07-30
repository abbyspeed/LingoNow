<template>
    <div class="rectangle-container">
        <div class="statistic-container">
            <div class="statistic-div">
                <div class="text-container">
                    <div class="number">{{ totalSlangs }}</div>
                    <div class="description">Total Slang</div>
                </div>
                <div class="icon">
                    <img src="@/assets/slang.png" alt="Slang Icon" height="90px" width="90px" />
                </div>
            </div>
            
            <div class="statistic-div">
                <div class="text-container">
                    <div class="number">{{ totalLikes }}</div>
                    <div class="description">Total Like</div>
                </div>
                <div class="icon">
                    <img src="@/assets/thumb-ups.svg" alt="Like Icon" height="70px" width="70px" />
                </div>
            </div>
            
            <div class="statistic-div">
                <div class="text-container">
                    <div class="number">{{ totalDislikes }}</div>
                    <div class="description">Total Dislike</div>
                </div>
                <div class="icon">
                    <img src="@/assets/thumb-down.png" alt="Dislike Icon" height="60px" width="60px" />
                </div>
            </div>
        </div>
        <div class="graph-div">
            <h2>Graph Number of Slangs Added VS Month</h2><br>
            <canvas id="slangChart"></canvas>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
    setup() {
        const totalSlangs = ref(0);
        const totalLikes = ref(0);
        const totalDislikes = ref(0);
        const slangChart = ref(null);

        const fetchTotalSlangs = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/total');
                if (response.data && response.data.total.length > 0) {
                    totalSlangs.value = response.data.total; 
                } else {
                    console.error('Expected a number of slang, but got:', response.data);
                }
                    
            } catch (error) {
                console.error('Error fetching total slangs:', error);
            }
        };

        const fetchLikeDislike = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/like-dislike');
                if (response.data && response.data.totalLikes !== undefined && response.data.totalDislikes !== undefined) {
                    totalLikes.value = response.data.totalLikes; 
                    totalDislikes.value = response.data.totalDislikes;
                } else {
                    console.error('Expected totalLikes and totalDislikes, but got:', response.data);
                }
                    
            } catch (error) {
                console.error('Error fetching like-dislike slangs:', error);
            }
        };

        const fetchSlangsByMonth = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/chart');
                return response.data;
            } catch (error) {
                console.error('Error fetching slangs by month:', error);
                return [];
            }
        };


        const renderChart = async () => {
            const data = await fetchSlangsByMonth();

            const labels = [];
            const counts = [];

            data.forEach(item => {
                const [year, month] = item.month.split('-');
                const monthName = new Date(Date.UTC(year, month - 1)).toLocaleString('default', { month: 'long' });
                labels.push(`${monthName} ${year}`);
                counts.push(item.count);
            });

            const ctx = document.getElementById('slangChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Slangs Added',
                        data: counts,
                        backgroundColor: '#FF9B3F',
                        borderColor: '#FF9B3F',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };

        onMounted(() => {
            fetchTotalSlangs();
            fetchLikeDislike();
            renderChart();
        });

        return {
            totalSlangs,
            totalDislikes,
            totalLikes,
            slangChart
        };
    }
}
</script>

<style scoped>
.rectangle-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: auto;
}

.statistic-container {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: center;
    width: 100%;
    padding-bottom: 30px;
}

.statistic-div {
    width: 250px; 
    height: 100px; 
    margin: 10px 20px; 
    border-radius: 10px; 
    padding: 10px;
    display: flex;
    flex-direction: row; 
    justify-content: space-between; 
    align-items: center; 
}

.statistic-div:nth-child(1) {
    background-color: rgb(0, 151, 216);
}

.statistic-div:nth-child(2) {
    background-color: rgb(3, 178, 143);
}

.statistic-div:nth-child(3) {
    background-color: rgb(177, 46, 32);
}

.text-container {
    display: flex;
    flex-direction: column; 
    justify-content: center;
    padding-left: 10px;
}

.number {
    font-size: 30px;
    font-weight: bold;
    color: white;
    text-align: left;
    padding-bottom: 5px;
}

.description {
    font-size: 15px;
    color: white;
    text-align: left;
}

.icon {
    display: flex;
    align-items: center; 
    padding-right: 10px;
}

.graph-div {
    width: 90%;
    margin: 20px;
    padding: 30px;
    border: 2px solid black;
    border-radius: 10px;
}
</style>
