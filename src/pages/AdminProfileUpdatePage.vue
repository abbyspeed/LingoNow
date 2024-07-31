<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <div class="title-section">
      <h2>Your Profile is A Reflection of You</h2>
      <p>Edit any details that are outdated anytime with ease. 
        <br>
        A good admin profile surely guarantees more trust within our users.
      </p>
    </div>
  
    <div class="form-container">
      <form @submit.prevent="updateProfile">
        <table>
          <tr class="single">
            <td>
              <label for="username">Username </label>
              <input v-model="profile.username" type="text" id="username" required />
            </td>
          </tr>

          <tr class="single">
            <td colspan="2">
              <label for="fullName">Full Name </label>
              <input v-model="profile.fullName" type="text" id="fullName" required />
            </td>
          </tr>

          <tr class="single">
            <td colspan="2">
              <label for="fullName">Email Address </label>
              <input v-model="profile.email" type="text" id="fullName" required />
            </td>
          </tr>

          <tr class="single">
            <td colspan="2">
              <label for="fullName">Phone Number</label>
              <input v-model="profile.phoneNo" type="text" id="fullName" required />
            </td>
          </tr>
  
          <tr>
            <td colspan="2" style="text-align: center;">
              <button type="submit">Save </button>
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
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
setup() {
    const route = useRoute();
    const router = useRouter();
    const store = useStore();

    const userId = computed(() => store.state.user?.userId);

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

    const profile = reactive({
        userId: '',
        username: '',
        fullName: '',
        email: '',
        phoneNo: '',
        password: '', 
    });

    const fetchProfile = async () => {
        try {
            const response = await axios.get(`http://localhost/lingonowAPI/index.php/profile/${userId.value}`, {
              headers: {
                  Authorization: `Bearer ${localStorage.getItem('token')}`,
              },
            }); 
            console.log(response.data);

            if (response.data) {
                Object.assign(profile, response.data.profile);

            } else {
                console.error('Expected array but got:', response.data);
            }
        } catch (error) {
            console.error('Error fetching profile:', error);
        }
    };

    const { id } = route.params;

    const updateProfile = async () => {
        try {
            console.log('Updating profile:', profile);
            const response = await axios.put(`http://localhost/lingonowAPI/index.php/profile/${id}/update`, profile);
            console.log('Profile updated:', response.data);

            router.push('/Admin/Profile'); 

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
        fetchProfile();
    });

    return {
        currentRoute,
        // session,
        fetchProfile,
        profile,
        updateProfile,
        onMounted,
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