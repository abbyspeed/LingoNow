<template>
  <router-view/>
</template>

<script>
export default {
  name: 'LingoNow',
  // const user = JSON.parse(localStorage.getItem('user'));
  // if(user){
  //     store.commit('setUser', user);
  // }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

*{
  margin: 0;
  padding: 0;
}

html {
  overflow-y: scroll; /* Always show the vertical scrollbar */
}
</style>
