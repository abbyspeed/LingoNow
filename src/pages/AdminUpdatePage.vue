<template>
  <adminNavBar :activeRoute="currentRoute"></adminNavBar>
  <div class="title-section">
    <h2>Keep the Slang Up to Date</h2>
    <p>Our users are looking forward to receive the most accurate representation of the slang.
      <br>
      Update the slang accordingly and get our users connected!
    </p>
  </div>

  <div class="form-container">
    <form @submit.prevent="updateForm">
      <table>
        <tr class="double">
          <td>
            <label for="word">Slang </label>
            <input v-model="slang.word" type="text" id="word" required />
          </td>
          <td>
            <label for="categoryId">Category </label>
            <select v-model="slang.categoryId" id="categoryId" required>
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
            <textarea v-model="slang.meaning" id="meaning" required></textarea>
          </td>
        </tr>

        <tr class="single">
          <td colspan="2">
            <label for="example">Example </label>
            <textarea v-model="slang.example" id="example" required></textarea>
          </td>
        </tr>
        
        <tr class="single">
          <td colspan="2">
            <label for="lastUpdated">Date </label>
            <input v-model="slang.lastUpdated" type="date" id="lastUpdated" required />
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

        alert('Slang updated successfully!');

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
      fetchSlang(); 
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