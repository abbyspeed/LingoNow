<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <div class="title-section">
        <h2>One Slang a New Day Keeps the Ignorance Away</h2>
        <p>Our users are looking forward to receive the most accurate representation of the slang.
        <br>
        Add the latest slang and get our users connected!
        </p>
    </div>
    <div class="form-container">
        <form @submit.prevent="submitForm">
        <table>
            <tr class="double">
            <td>
                <label for="word">Slang </label>
                <input v-model="newSlang.word" type="text" id="word" required />
            </td>
            <td>
                <label for="categoryId">Category </label>
                <select v-model="newSlang.categoryId" id="categoryId" required>
                <option value="">Select Category</option>
                <option v-for="category in categories" :key="category.categoryId" :value="category.categoryId">
                    {{ category.title }}
                </option>
                </select>
            </td>
            </tr>

            <tr class="single">
            <td colspan="2">
                <label for="meaning">Meaning </label>
                <textarea v-model="newSlang.meaning" id="meaning" required></textarea>
            </td>
            </tr>

            <tr class="single">
            <td colspan="2">
                <label for="example">Example </label>
                <textarea v-model="newSlang.example" id="example" required></textarea>
            </td>
            </tr>
            
            <tr class="single">
            <td colspan="2">
                <label for="lastUpdated">Date </label>
                <input v-model="newSlang.lastUpdated" type="date" id="lastUpdated" required />
            </td>
            </tr>

            <tr>
            <td colspan="2" style="text-align: center;">
                <button type="submit">Save</button>
            </td>
            </tr>
        </table>
        </form>
    </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
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
            case '/Admin/Home':
            return 'adminHome';

            case '/Admin/About':
            return 'adminAbout';
            
            case '/Admin/Manage':
            return 'adminManage';

            case '/Admin/Manage/Create':
            return 'adminManage';

            case '/Admin/Manage/${route.params.id}/Update':
            return 'adminManage';

            case '/Admin/Stats':
            return 'adminStats';
            
            default:
            return '';
        }});

        const username = computed(() => store.state.user?.username || 'User');

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
                const response = await axios.get('http://localhost/lingonowAPI/index.php/categories');
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
                const response = await axios.post('http://localhost/lingonowAPI/index.php/slangs/create', newSlang);
                console.log('New Slang added:', response.data);

                alert('Slang created successfully!');

                router.push('/Admin/Manage'); 
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
            submitForm,
            currentRoute,
            username,
        };
    }
};
</script>

<style scoped>
.title-section {
  margin-top: 130px;
  margin-bottom: 50px;
}

h2 {
  padding: 10px 0;
  font-size: 36px;
}

.form-container {
  width: 50%;
  margin: 0 auto; 
  background-color: white;
  margin-bottom: 40px;
  box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.1);
  padding: 20px 10px;
}

table {
  width: 100%;
  border-spacing: 10px;
}

td {
  vertical-align: top;
  padding: 8px;
}

label {
  display: block;
  text-align: left;
  margin-bottom: 4px;
}

input,
textarea,
select {
  width: 100%;
  padding: 8px;
  margin-top: 4px;
  box-sizing: border-box;
  border-radius: 5px;
}

textarea {
  height: 100px;
}

button {
  padding: 10px 20px;
  cursor: pointer;
  width: 50%;
  border-radius: 10px;
  border: 1px solid #FF9B3F;
  background-color: #FF9B3F;
  transition: 0.3s;
  font-weight: 600;
  color: black;
}

button:hover {
  border: 1px solid #FF9B3F;
  background-color: white;
  color: #FF9B3F;
  font-weight: 600;
}

tr.double td {
  width: 50%;
}

tr.single td {
  width: 100%;
  padding-top: 8px;
}
</style>
