import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);

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
        login({ commit }, user){
            commit('setUser', user);
        },

        logout({ commit }){
            commit('clearUser');
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

