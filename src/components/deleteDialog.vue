<template>
    <div class="overlay" v-if="isVisible">
        <div class="dialog">
        <p>{{ message }}</p>
        <button @click="confirm">Confirm</button>
        <button @click="cancel">Cancel</button>
        </div>
    </div>
    </template>

    <script>
    export default {
    props: {
        isVisible: { type: Boolean, default: false },
        message: { type: String, default: 'Are you sure you want to delete this item?' },
    },
    emits: ['confirm', 'cancel'],
    methods: {
        confirm() {
        this.$emit('confirm');
        },
        cancel() {
        this.$emit('cancel');
        },
    },
    };
</script>

<style scoped>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.dialog {
    background: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}

button {
    margin: 0 5px;
    padding: 10px 20px;
}
</style>