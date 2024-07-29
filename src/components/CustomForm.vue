<template>
    <p>{{ title }}</p>
    <input v-if="isPassword === false" type="text" :placeholder="placeholderText" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        required>
    <input v-else type="password" :placeholder="placeholderText" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        required>
</template>

<script>
export default{
    props: {
        title: { type: String },
        placeholderText: { type: String },
        isPassword: { type: Boolean },
        modelValue: { type: String }
    }
}
</script>

<style scoped>
input[type="text"],
input[type="password"]{
    width: 90%;
    padding: 15px;
    margin: 5px 0;
    border: 0.5px solid lightgray;
    border-radius: 5px;
}

p{
    font-size: 14px;
    padding: 0;
    margin-top: 10px;
    margin-bottom: 5px;
}
</style>