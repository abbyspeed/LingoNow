<template>
    <div class="rectangle-container">
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
                <div class="number">4</div>
                <div class="description">Total Like</div>
            </div>
            <div class="icon">
                <img src="@/assets/thumb-ups.svg" alt="Like Icon" height="70px" width="70px" />
            </div>
        </div>
        <div class="statistic-div">
            <div class="text-container">
                <div class="number">4</div>
                <div class="description">Total Dislike</div>
            </div>
            <div class="icon">
                <img src="@/assets/thumb-down.png" alt="Dislike Icon" height="60px" width="60px" />
            </div>
        </div>
        <div class="graph-div">
            <canvas id="slangChart"></canvas>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
    name: 'SlangStatistic',
    props: {
        totalSlangs: {
            type: String,
            required: true
        }
    },
    setup() {
        const totalSlangs = ref(0);

        //Calculate TotalSlangs
        const fetchTotalSlangs = async () => {
            try {
                const response = await fetch('http://localhost/lingonowAPI/slang/total');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                totalSlangs.value = data.total;
            } catch (error) {
                console.error('Error fetching total slangs:', error);
            }
        };

        const renderChart = () => {
            const ctx = document.getElementById('slangChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Slangs Added',
                        data: [12, 19, 3, 5, 2, 3, 7], //NEED TO ADD BACKEND 
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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

        onMounted(async () => {
            await fetchTotalSlangs();
            renderChart();
        });

    }
}
</script>

<style scoped>
.rectangle-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    height: auto;
}

.statistic-div {
    width: 400px; 
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
}
</style>
