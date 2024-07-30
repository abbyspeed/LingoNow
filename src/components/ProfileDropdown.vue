<template>
    <div class="dropdown">
      <div class="dropdown-trigger" @click="toggleDropdown">
        <slot name="trigger">Click me</slot>
      </div>
      
      <div v-if="isDropdownOpen" class="dropdown-menu">
        <ul v-for="(option, index) in options" :key="index">
          <router-link :to="option.path" @click="handleMenuClick(option.label)">
            <li>    
              {{ option.label }}
            </li>
          </router-link>
        </ul>
      </div>
    </div>
</template>
  
<script>
import { ref } from 'vue';
  
export default {
    name: 'ProfileDropdown',
    props: {
      options: {
        type: Array,
        required: true
      }
    },
    setup() {
      const isDropdownOpen = ref(false);

      const toggleDropdown = () => {
          isDropdownOpen.value = !isDropdownOpen.value;
      };

      const handleMenuClick = (option) => {
        if(option.callback){
          option.callback();
        }
        
        console.log(`Selected: ${option}`);
        isDropdownOpen.value = false;
      };

      return {
        isDropdownOpen,
        toggleDropdown,
        handleMenuClick
      };
    }
};
</script>

<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
  width: 100%;
  justify-content: center; 
  align-items: center;
}

.dropdown-trigger {
  padding: 10px;
  color: white;
  cursor: pointer;
  display: flex; 
  align-items: center; 
  justify-content: center;
}

.dropdown-menu {
  display: block;
  position: absolute;
  top: 100%;
  width: 100%;
  margin-top: 5px;
  left: 0;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  display: flex;
  flex-direction: column; 
}

.dropdown-menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.dropdown-menu li {
  padding: 10px 12px;
  cursor: pointer;
  background-color: FF9B3F;
  color: black;
}

.dropdown-menu li:hover {
  background-color: #f1f1f1;
}

a {
    text-decoration: none;
    font-size: 14px;
}
</style>