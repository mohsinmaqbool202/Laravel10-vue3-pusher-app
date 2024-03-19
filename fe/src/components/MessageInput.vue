<template>
     <div class="msg-input">
            <input type="text" placeholder="Type message..." v-model="message" @keyup.enter="sendMessage()"/>
        </div>
</template>

<script setup>
import { ref } from 'vue';
// import { defineEmits } from 'vue';

const emits = defineEmits(['send-msg']);
const message = ref('');

const sendMessage = () => {
    if(message.value) {
        emits('send-msg', {message: message.value})
        message.value = ''
    }
}
</script>

<style scoped>
.msg-input {
    width: 100%;
    position: absolute;
    bottom: .3px;
    box-shadow: 0 30px 30px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.msg-input input {
    width: 100%;
    padding: 15px 10px;
    border-bottom-right-radius: 12px;
    border-bottom-left-radius: 12px;
    outline: none;
    color: #fff;
    border: none;
    background-color: #236f9f;
}

.msg-input input::placeholder {
    color: #fff;
}
</style>