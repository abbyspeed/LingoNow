<template>
    <div class="container">
        <div class="logoSection">
            <img :src="require('/src/assets/logo.png')" alt="LingoNow" class="logo" />
            <h2>LingoNow</h2>
        </div>
        <div class="loginForm">
            <h3>Log into LingoNow</h3>
            <form @submit.prevent="login">
                <customForm v-for="form in form" 
                    :title="form.title" 
                    :placeholderText="form.placeholderText"
                    :isPassword="form.isPassword" 
                    :key="form.id"
                    v-model="form.inputData"></customForm>
            
                <button type="submit" class="mainBtn">Login</button>
            </form>
            <router-link :to="{ name: 'Signup' }">
                <center>Don't have an account? Sign up now!</center>
            </router-link>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            form: [
                {
                    title: "Username",
                    placeholderText: "e.g Qistina Ridhwan",
                    isPassword: false,
                    inputData: ""
                },
                {
                    title: "Password",
                    placeholderText: "e.g *********",
                    isPassword: true,
                    inputData: ""
                }
            ]
        }
    },
    methods: {
        validateUser(){
            const userData = [];

            for(let i=0; i<this.form.length; i++){
                userData.push(this.form[i].inputData);
            }

            // this.$router.push('/Create');
        },

        ...mapActions(["login"]),

        async login() {
            try {
                const credentials = {
                    username: this.form[0].inputData,
                    password: this.form[1].inputData,
                };

                await this.login(credentials);

                this.$router.push("/Admin/Home");
            } catch (error) {
                console.error("Login failed:", error);
                // Handle error (e.g., show a notification or message)
            }
        },
    }
}
</script>

<style scoped>
.container {
    display: flex;
    width: 50%;
    height: 100%;
    justify-content: center;
    background-color: white;
    border-radius: 25px;
    border: 1px solid grey;
    transform: translate(50%, 35%);
}

.logoSection {
    flex: 1;
    background-color: #FF9B3F;
    border-radius: 25px;
    padding: 55px 0;
}

.logo {
    width: 200px;
    height: 200px;
}

.loginForm {
    flex: 1;
    height: 100%;
    text-align: left;
    padding: 15px 20px;
}

h3 {
    text-align: center;
    margin: 20px;
}

a {
    color: black;
    font-size: 12px;
    text-align: center;
}
</style>