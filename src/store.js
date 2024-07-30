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
                    localStorage.setItem('token', token);

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

                localStorage.removeItem('token');

            } catch (error) {
                console.error('Logout error:', error);
                throw error;
            }
        }
    }
});

// // To be used in components
// computed: {
//     user(){
//         return this.$store.state.user;
//     }
// },