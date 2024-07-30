<template>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th v-for="column in columns" :key="column">
                        {{ column }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, rowIndex) in displayedSlangs" :key="rowIndex">
                    <td class="medium">{{ row.word }}</td>
                    <td class="long">{{ row.meaning }}</td>
                    <td class="medium">{{ formatDate(row.lastUpdated) }}</td>
                    <td class="short">
                        <i class="far fa-edit" @click="editSlang(row.slangId)"></i>
                        <div style="width: 10px"></div>
                        <i class="fas fa-trash" @click="showDeleteConfirmation(row.slangId)"></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="pageCount > 1">
            <button @click="prevPage" :disabled="currentPage === 1">Prev</button>
            Page {{ currentPage }} of {{ pageCount }}
            <button @click="nextPage" :disabled="currentPage === pageCount">Next</button>
        </div>

        <button class="newSlang">
            <router-link to="/Admin/Manage/Create">Create a new slang</router-link>
        </button>

        <deleteDialog
            :isVisible="isDialogVisible"
            @confirm="confirmDelete"
            @cancel="cancelDelete"/>
    </div>
</template>

<script>
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const slang = ref([]);
        const pageSize = 10;
        const currentPage = ref(1);
        const isDialogVisible = ref(false);
        const slangToDelete = ref(null);

        const router = useRouter();

        const fetchSlangs = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/slangs'); 
                if (Array.isArray(response.data.slangs)) {
                    slang.value = response.data.slangs; 
                } else {
                    console.error('Expected array but got:', response.data);
                }
            } catch (error) {
                console.error('Error fetching slangs:', error);
            }
        };

        onMounted(() => {
            fetchSlangs();
        });

        const pageCount = computed(() => Math.ceil(slang.value.length / pageSize));

        const displayedSlangs = computed(() => {
            if (!Array.isArray(slang.value)) return [];
            const startIndex = (currentPage.value - 1) * pageSize;
            return slang.value.slice(startIndex, startIndex + pageSize);
        });

        const nextPage = () => {
            if (currentPage.value < pageCount.value) {
                currentPage.value += 1;
            }
        };

        const prevPage = () => {
            if (currentPage.value > 1) {
                currentPage.value -= 1;
            }
        };

        const editSlang = (slangId) => {
            console.log(`Edit slang with ID: ${slangId}`);
            router.push({ name: 'UpdateSlang', params: { id: slangId } });
        };

        const showDeleteConfirmation = (slangId) => {
            slangToDelete.value = slangId;
            isDialogVisible.value = true;
        };

        const confirmDelete = async (slangId) => {
            if (slangToDelete.value) {
                try {
                    await axios.delete(`http://localhost/lingonowAPI/index.php/slangs/${slangToDelete.value}/delete`);
                    slang.value = slang.value.filter(item => item.slangId !== slangToDelete.value);
                    console.log('Slang deleted successfully:', response.data);
                } catch (error) {
                    console.error('Error deleting slang:', error);
                } finally {
                    isDialogVisible.value = false;
                    slangToDelete.value = null;
                }
            }
        };

        const cancelDelete = () => {
            isDialogVisible.value = false;
            slangToDelete.value = null;
        };

        const formatDate = (dateString) => {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        };

        return {
            slang,
            displayedSlangs,
            columns: ['Word', 'Meaning', 'Last Updated', 'Manage'],
            currentPage,
            pageCount,
            nextPage,
            prevPage,
            editSlang,
            showDeleteConfirmation,
            slangToDelete,
            isDialogVisible,
            cancelDelete,
            confirmDelete,
            formatDate
        };
    }
};
</script>


<style scoped>
.newSlang {
    margin-bottom: 20px;
}

.table-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
}

thead {
    background-color: #FF9B3F;
    color: #2C3E50;
}

tbody tr:nth-child(odd) {
    background-color: #fde4cb;
}

tbody tr:nth-child(even) {
    background-color: #fef2e6;
}

table .short {
    width: 100px;
    display: flex;
    justify-content: center;
    padding-top: 20px;
}

table .medium {
    width: 120px;
}

table .long {
    text-align: justify;
}

.fa-edit,
.fa-trash {
    color: black;
}

.fa-edit:hover {
    color: #FF9B3F;
    cursor: pointer;
}

.fa-trash:hover {
    color: red;
    cursor: pointer;
}

button {
    background-color: #ff9b3f;
    border: none;
    border-radius: 10px;
    padding: 10px 15px;
    cursor: pointer;
    color: #2C3E50;
}

button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
