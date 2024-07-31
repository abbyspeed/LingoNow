import Vuex from 'vuex';
import axios from 'axios';

export default new Vuex.Store({
    state: {
        user: null,
        token: null
    },

    mutations: {
        setUser(state, user){
            state.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },

        setToken(state, token){
            state.token = token;
            localStorage.setItem('token', token);
        },

        resetUser(state){
            state.user = null;
            state.token = null;
            localStorage.removeItem('user');
            localStorage.removeItem('token');
        }
    },

    actions: {
        async login({ commit }, credentials){
            try{
                const response = await axios.post(`http://localhost/lingonowAPI/index.php/login`, credentials, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                console.log('Login response:', response.data);
                const user = response.data.user;
                const token = response.data.token;

                if(user && token){
                    commit('setUser', user);
                    commit('setToken', token);

                } else{
                    throw new Error('User or token not received');
                }    
            
            } catch (error){
                console.error('Login error: ', error);
                throw error;
            }  
        },

        async logout({ commit }) {
            try {
                await axios.post(`http://localhost/lingonowAPI/index.php/logout`, null, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}` 
                    }
                });

                commit('resetUser');

                console.log(localStorage.getItem('token'));
                console.log(this.$store.state.user);

            } catch (error) {
                console.error('Logout error:', error);
                throw error;
            }
        }
    }
});