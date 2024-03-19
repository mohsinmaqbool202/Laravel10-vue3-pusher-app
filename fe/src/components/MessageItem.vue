<template>
    <li class="msg-item" :class="[message.user_id == authStore.userData.id ? 'sent' : 'received']">
        <small class="msg-user"> {{ message.user_id == authStore.userData.id ? 'You' : message.user.name }} </small>
        {{ message.message }}
        <small class="msg-time"> 9:12 am </small>
    </li>
</template>

<script setup>
import { useAuthStore } from '../store/auth';

defineProps({
    message: {
        type: Object,
        default() {
            return {}
        }
    }
});

const authStore = useAuthStore();

</script>

<style scoped>
.msg-item {
    border: none;
    font-size: 12px;
    width: 70%;
    list-style-type: none;
    background-color: #F0F0F0;
    padding: 10px;
    margin-bottom: 30px;
    cursor: pointer;
    position: relative;
}

.msg-item.received {
    border-radius: 10px;
    border-top-left-radius: 0;
    float: left;
}

.msg-item.sent {
    border-radius: 10px;
    border-top-right-radius: 0;
    background-color: lightblue;
    float: right;
}

.msg-time {
    color: cornflowerblue;
    position: absolute;
    right: 6px;
    bottom: -14px;
}

.msg-user {
    position: absolute;
    top: -14px;
    left: 2px;
    color: #236f9f;
}
</style>