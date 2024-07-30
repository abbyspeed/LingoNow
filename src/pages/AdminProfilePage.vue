<template>
    <adminNavBar :activeRoute="currentRoute"></adminNavBar>
    <div class="top">
        <div class="userBg"></div>
        <img :src="require('/src/assets/user.png')" alt="user" class="user" />
        <div class="profileText">
            <p>{{ profile.username }}</p>
            <p>{{ profile.email }}</p>
        </div>
    </div>
    <div class="bottom">
        <div class="accountBox">
            <div class="textBox">
                <h4>Username</h4>
                <p>{{ profile.username || 'N/A' }}</p>
            </div>
            
            <div class="textBox">
                <h4>Name</h4>
                <p>{{ profile.fullName }}</p>
            </div>
            
            <div class="textBox">
                <h4>Email</h4>
                <p>{{ profile.email }}</p>
            </div>

            <div class="textBox">
                <h4>Phone number</h4>
                <p>{{ profile.phoneNo }}</p>
            </div>
            
            <div class="textBox">
                <h4>Password</h4>
                <p>********</p>
            </div>

            <div class="editBtn" @click="goToEditProfile">
                <p>Update Profile</p>
            </div>
        </div>
    </div>
</template>
  
<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
// import { useStore } from 'vuex';

export default {
    setup() {
        const route = useRoute();
        const router = useRouter();
        // const store = useStore();
    
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
        
                case '/Admin/Manage/:id/Update':
                    return 'adminManage';
        
                case '/Admin/Stats':
                    return 'adminStats'; 
                    
                default:
                    return '';
            }
        });
    
        // const userSession = computed(() => store.state.user?.username || 'User');

        const profile = ref({
            userId: '',
            username: '',
            fullName: '',
            email: '',
            phoneNo: '',
            password: '', // Consider using a placeholder or asterisks for display purposes.
        });

        const fetchProfile = async () => {
            try {
                const response = await axios.get('http://localhost/lingonowAPI/index.php/profile'); 
                console.log(response);
                if (response.data) {
                    profile.value = response.data.profile; 
                } else {
                    console.error('Expected array but got:', response.data);
                }
            } catch (error) {
                console.error('Error fetching slangs:', error);
            }
        };

        const goToEditProfile = () => {
            const userId = profile.value.userId;
            console.log(`Edit profile with ID: ${userId}`);
            router.push({ name: 'UpdateProfile', params: { id: userId } });
        };

        onMounted(() => {
            fetchProfile();
        });

        return {
            currentRoute,
            goToEditProfile,
            // username,
            profile
        };
    },
};
</script>
  
<style scoped>
.top {
    margin-top: 50px;
    position: relative; 
    height: 380px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.top .profileText {
    position: absolute;
    top: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
    z-index: 2;
}

.userBg {
    position: absolute;
    width: 100%;
    height: 300px;
    background-color: aqua;
    top: -50px;
    left: 0;
    z-index: 0;
}

.user {
    position: absolute;
    width: 100px;
    height: auto;
    border-radius: 50%;
    margin-left: 10px;
    top: 50%;
    z-index: 1; 
}

.bottom {
    display: flex;
    position: relative;
    padding-bottom: 20px;
    justify-content: center;
    align-items: center;
    z-index: 1;
}

.accountBox {
    border-radius: 10px;
    margin: 10px 20px;
    width: 40%;
    /* padding: 20px; */
    background-color: white; 
    z-index: 1;
}

.textBox {
    flex-direction: column;
    text-align: left;
    margin: 15px 0;
}

.textBox h4 {
    font-size: 12px;
    color: gray;
    font-weight: 500;
    margin-bottom: 5px;
}

.textBox p {
    font-weight: 700;
    color: black;
}

.editBtn {
    background-color: white;
    border: 1px solid #FF9B3F;
    border-radius: 20px;
    width: 100%;
    padding: 10px 0;
    transition: 0.3s;
    z-index: 1;
}

.editBtn:hover {
    border: 1px solid white;
    border-radius: 20px;
    color: white;
    cursor: pointer;
}
</style>