<template>
    <adminNavBar></adminNavBar>

    <div class="form-container">
        <form @submit.prevent="submitForm">
            <label for="word">Slang: </label>
            <input v-model="newSlang.word" type="text" id="word" required />
            <p></p>
            <label for="categoryId">Category: </label>
            <select v-model="newSlang.categoryId" id="categoryId" required>
                <option value="">Select Category</option>
                <option v-for="category in categories" :key="category.categoryId" :value="category.categoryId">
                    {{ category.title }}
                </option>
            </select>
            <p></p>
            <label for="meaning">Meaning: </label>
            <textarea v-model="newSlang.meaning" id="meaning" required></textarea>
            <p></p>
            <label for="example">Example: </label>
            <textarea v-model="newSlang.example" id="example" required></textarea>
            <p></p>
            <label for="lastUpdated">Date: </label>
            <input v-model="newSlang.lastUpdated" type="date" id="lastUpdated" required />
            <p></p>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const newSlang = reactive({
            word: '',
            meaning: '',
            example: '',
            lastUpdated: '',
            categoryId: ''
        });

        const categories = ref([]);
        const router = useRouter();

        const fetchCategories = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/Categories');
                if (response.data.categories) {
                    categories.value = response.data.categories;
                } else {
                    categories.value = response.data;
                }
                console.log('Fetched categories:', categories.value);
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        };

 const submitForm = async () => {
    try {
        console.log('Submitting new slang:', newSlang);
        const response = await axios.post('http://localhost/lingonowAPI/index.php/Create', newSlang);
        console.log('New Slang added:', response.data);
        router.push('/Manage'); 
    } catch (error) {
        if (error.response) {
            console.error('Error response data:', error.response.data);
            console.error('Error response status:', error.response.status);
            console.error('Error response headers:', error.response.headers);
        } else if (error.request) {
            console.error('Error request:', error.request);
        } else {
            console.error('Error message:', error.message);
        }
        console.error('Error config:', error.config);
    }
};
        onMounted(() => {
            fetchCategories();
        });

        return {
            newSlang,
            categories,
            submitForm
        };
    }
};
</script>

<style scoped>
.form-container {
    padding: 25px;
}

input, textarea {
    border-radius: 10px;
    color: #2C3E50;
    height: 3vh;
    width: 25vh;
    margin-bottom: 10px;
}

textarea {
    height: 6vh;
}

button {
    background-color: #ff9b3f;
    border-radius: 5px;
    border: none;
    padding: 10px;
    cursor: pointer;
    color: #2C3E50;
}
</style>
