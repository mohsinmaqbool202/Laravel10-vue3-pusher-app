<template>
    <div class="chat-box-container">
        <UsersLIst @select-user="handleSelectedUser"/>
        <MessagesContainer :mode="mode" :oneToOneSelectedUser="selectedUser"/>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import UsersLIst from './UsersLIst.vue';
import MessagesContainer from './MessagesContainer.vue';

// props
const props = defineProps(['mode'])

// states
const selectedUser = ref({});

// methods
const handleSelectedUser = (user) => {
    selectedUser.value = user
}
</script>

<style scoped>
.chat-box-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
    box-sizing: border-box;
    display: flex;
    gap: 10px;
    padding: 10px 0;
}
</style>