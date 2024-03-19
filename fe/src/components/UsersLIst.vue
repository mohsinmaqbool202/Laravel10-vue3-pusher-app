<template>
    <div class="users-list">
        <ul>
            <UserItem 
                v-for="user in users"
                :key="user.id" 
                :user="user" 
                :selectedUserId="selectedUserId"
                @select-user="selectedUserId = user.id; emits('select-user', user)"
            />
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import UserItem from './UserItem.vue';
import axiosClient from '../plugins/axios';

const users = ref([]);
const selectedUserId = ref(null);

// emits
const emits = defineEmits(['select-user'])

onMounted(() => {
    fetchUsers();
});

const fetchUsers = () => {
    axiosClient.get('/users').then(({data}) => {
        users.value = data.data
    })
}
</script>

<style scoped>
.users-list {
    width: 30%;
    height: calc(100% - 50px);
    background-color: #fff;
    border-radius: 15px;
    overflow-y: auto;
}
</style>