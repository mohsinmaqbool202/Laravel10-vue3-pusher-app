<template>
    <AuthDefaultLayout>
        <template #title>
            <h1>Login</h1>
        </template>
        <template #default>
            <form @submit.prevent="login">
                <div class="input-element">
                    <input type="email" placeholder="Email" v-model="credentials.email" required>
                </div>
                <div class="input-element">
                    <input type="password" placeholder="Password" v-model="credentials.password" required>
                </div>
                <div class="input-element">
                    <button type="submit">Login</button>
                </div>
                <p>Don't have an account? <router-link :to="{ name: 'Register' }">Register</router-link></p>
            </form>
        </template>
    </AuthDefaultLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'
import axiosClient from '../plugins/axios';
import { useAuthStore } from '../store/auth';
import { toast } from 'vue3-toastify';
import AuthDefaultLayout from '../components/auth/AuthDefaultLayout.vue';


const authStore = useAuthStore();
const router = useRouter();
const credentials = ref({
    email: '',
    password: ''
});

function login() {
    axiosClient.post('/login', credentials.value).then(({data}) => {
        authStore.setUserData(data.data)
        toast.success("Welcome to chat room")
        router.push({name: 'Chat'});
    })
    .catch((err) => {
        toast.error(err.response.data.message)
    })
}
</script>

<style>
h1 {
    color: #fff;
    text-align: center;
}

p {
    color: white;
}

form {
    width: 100%;
    height: auto;
    background: #236f9f;
    padding: 20px;
    border-radius: 10px;
}

.input-element {
    width: 100%;
    padding: 10px 0;
}

input,
button {
    width: 100%;
    padding: 10px 5px;
}
</style>