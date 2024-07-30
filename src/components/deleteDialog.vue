<template>
    <div class="overlay" v-if="isVisible">
        <div class="dialog">
            <i class="fas fa-exclamation-triangle"></i>
            <p>{{ message }}</p>
            <button @click="confirm" class="btnConfirm">Confirm</button>
            <button @click="cancel" class="btnCancel">Cancel</button>
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
    z-index: 1000;
}

.dialog {
    background: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}

.dialog i {
    font-size: 38px;
    color: red;
}

.dialog p {
    padding: 20px 0 20px;
}

button {
    margin: 0 5px;
    padding: 10px 30px;
    border-radius: 20px;
    border: none;
}

button:hover {
    cursor: pointer;
}

.btnCancel {
    background-color: white;
    border: 1px solid #FF9B3F;
}

.btnCancel:hover {
    background-color: #FF9B3F;
    color: white;
}

.btnConfirm:hover {
    background-color: white;
    border: 1px solid black;
}
</style>