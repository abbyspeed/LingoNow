<template>
  <adminNavBar :activeRoute="currentRoute"></adminNavBar>
  <h2>Update Slang</h2>

  <div class="form-container">
    <form @submit.prevent="updateForm">
      <label for="word">Slang: </label>
      <input v-model="slang.word" type="text" id="word" required />
      <p></p>
      <label for="categoryId">Category: </label>
      <select v-model="slang.categoryId" id="categoryId" required>
          <option value="">Select Category</option>
          <option v-for="category in categories" :key="category.categoryId" :value="category.categoryId">
              {{ category.title }}
          </option>
      </select>
      <p></p>
      <label for="meaning">Meaning: </label>
      <textarea v-model="slang.meaning" id="meaning" required></textarea>
      <p></p>
      <label for="example">Example: </label>
      <textarea v-model="slang.example" id="example" required></textarea>
      <p></p>
      <label for="lastUpdated">Date: </label>
      <input v-model="slang.lastUpdated" type="date" id="lastUpdated" required />
      <p></p>
      <button type="submit">Submit</button>
    </form>
</div>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router'
import { useStore } from 'vuex';
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

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
      }
    });

    const username = computed(() => store.state.user?.username || 'User');

    const categories = ref([]);
    const router = useRouter();
    const { id } = route.params;

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
  ``};

    const fetchSlang = async () => {
      try {
        const response = await axios.get(`http://localhost/lingonowAPI/index.php/slangs/${id}`);
        Object.assign(slang, response.data);
        console.log('Fetched slang:', slang);
      } catch (error) {
        console.error('Error fetching slang:', error);
      }
    };

    let slang = reactive({
        word: '',
        meaning: '',
        example: '',
        lastUpdated: '',
        categoryId: ''
    });

    const updateForm = async () => {
      try {
        console.log('Updating selected slang:', slang);
        const response = await axios.put(`http://localhost/lingonowAPI/index.php/slangs/${id}/update`, slang);
        console.log('Slang updated:', response.data);
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
      fetchSlang(); // Fetch slang data to populate the form
    });

    return {
      currentRoute,
      username,
      updateForm,
      slang,
      onMounted,
      categories,
      fetchSlang
    };
  },
};
</script>