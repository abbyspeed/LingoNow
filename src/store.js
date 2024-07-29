import Vuex from 'vuex';
import axios from 'axios';

export default new Vuex.Store({
    state: {
        user: null,
    },

    mutations: {
        setUser(state, user){
            state.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },

        resetUser(state){
            state.user = null;
            localStorage.removeItem('user');
        }
    },

    actions: {
        async login({ commit }, credentials){
            try{
                const response = await axios.post('http://localhost:3000/login', credentials);
                const user = response.data.user;
                const token = response.data.token;

                commit('setUser', user);
                localStorage.setItem('token', token);
            
            } catch (error){
                console.error('Login error: ', error);
                throw error;
            }  
        },

        logout({ commit }){
            commit('clearUser');
            localStorage.removeItem('token');
        }
    }
});

// // To be used in components
// computed: {
//     user(){
//         return this.$store.state.user;
//     }
// },

// methods: {
//     login(){
//         const userData = { id: 1, name: 'Nabihah' };
//         this.$store.dispatch('login', userData);
//     },

//     logout(){
//         this.$store.dispatch('logout');
//     }
// }

// // To be added to Vue.js or main.js
// const user = JSON.parse(localStorage.getItem('user'));
// if(user){
//     store.commit('setUser', user);
// }

