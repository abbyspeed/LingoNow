<template>
    <div class="container">
        <div class="signupForm">
            <h3>Sign up an Account</h3>
            <form @submit.prevent="createUser()">
                <customForm v-for="form in form" 
                    :title="form.title" 
                    :placeholderText="form.placeholderText" 
                    :isPassword="form.isPassword"
                    :key="form.id + 1"
                    v-model="form.inputData"></customForm>
            
                <button type="submit" class="mainBtn">Sign Up</button>
            </form>
            <!-- <router-link :to="{ name: 'Login' }">
                <center>Have an account? Log in now!</center>
            </router-link> -->
        </div>
        <div class="logoSection">
            <img :src="require('/src/assets/logo.png')" alt="LingoNow" class="logo"/>
            <h2>LingoNow</h2>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const id = 0;

export default{
    data(){
        return{
            form: [
                {
                    id: id,
                    title: "Full name",
                    placeholderText: "e.g Qistina Ridhwan",
                    isPassword: false,
                    inputData: ""
                },
                {
                    id: id,
                    title: "Email address",
                    placeholderText: "e.g qistina@gmail.com",
                    isPassword: false,
                    inputData: ""
                },
                {
                    id: id,
                    title: "Username",
                    placeholderText: "e.g Qistina901",
                    isPassword: false,
                    inputData: ""
                },
                {
                    id: id,
                    title: "Phone Number",
                    placeholderText: "e.g 019-0981292",
                    isPassword: false,
                    inputData: ""
                },
                {
                    id: id,
                    title: "Password",
                    placeholderText: "e.g *********",
                    isPassword: true,
                    inputData: ""
                },
                {
                    id: id,
                    title: "Confirm password",
                    placeholderText: "e.g *********",
                    isPassword: true,
                    inputData: ""
                }
            ],
            isSubmitting: false
        }
    },
    methods: {
        async createUser() {
            const [fullName, email, username, phoneNo, password, confirmPassword] = this.form.map(
                (field) => field.inputData
            );

            const newUserData = {
                fullName: this.form[0].inputData,
                email: this.form[1].inputData,
                username: this.form[2].inputData,
                phoneNo: this.form[3].inputData,
                password: this.form[4].inputData,
                confirmPassword: this.form[5].inputData,
            };
            console.log('User data:', newUserData);

            if (!fullName || !email || !username || !phoneNo || !password || !confirmPassword) {
                alert('Please fill in all fields');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            if (this.isSubmitting) return;
            this.isSubmitting = true;

            try {
                axios.post('http://localhost/lingonowAPI/index.php/users', newUserData)
                .then(response => {
                    console.log('Response:', response.data);

                alert('Account is signed up successfully!');

                    this.$router.push('/Login');
                })
                .catch(error => {
                    console.error('Error:', error.response ? error.response.data : error.message);
                });
                
            } catch (error) {
                console.error('Error creating user:', error);
                alert('An error occurred while creating the account.');
            } finally {
                this.isSubmitting = false;
            }
        },
    }
}
</script>

<style>
.container{
    display: flex;
    width: 50%;
    height: 100%;
    justify-content: center;
    background-color: white;
    border-radius: 25px;
    border: 1px solid grey;
    transform: translate(50%, 0%);
    margin-top: 60px;
}

.logoSection{
    flex: 1;
    background-color: #FF9B3F;
    border-radius: 25px;
    padding: 170px 0;
}

.logo{
    width: 200px;
    height: 200px;
}

.signupForm{
    flex: 1;
    height: 100%;
    text-align: left;
    padding: 10px 20px 25px 20px;
}

h3{
    text-align: center;
    margin: 30px 0;
}

a{
    color: black;
    font-size: 12px;
    text-align: center;
}
</style>
