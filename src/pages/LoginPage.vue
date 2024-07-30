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

                <div v-if="errorMessage" class="errorMessage">{{ errorMessage }}</div>
            
                <button type="submit" class="mainBtn">Login</button>
            </form>
            <center>To register, please reach out to us at lingo@gmail.com</center>
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
            ],
            errorMessage: '',
            hasLoggedError: false
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
            if (this.hasLoggedError) {
                return;
            }

            this.hasLoggedError = true;
            this.errorMessage = '';

            try {
                const credentials = {
                    username: this.form[0].inputData,
                    password: this.form[1].inputData,
                };

                console.log(credentials);

                // await this.login(credentials);
                await this.$store.dispatch('login', credentials);

                if (this.$store.state.user) {
                    await this.$router.push("/Admin/Home");

                } else {
                    console.error("Login failed: User not set");
                    this.errorMessage = "Login failed. Please check your credentials.";
                }

            } catch (error) {
                console.error("Login failed:", error);
                this.errorMessage = "Login failed. Please try again.";
                // window.location.reload();
            } finally {
                this.hasLoggedError = false;
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

.errorMessage {
    font-size: 12px;
    color: red;
}

center {
    font-size: 10px;
    color: gray;
}
</style>