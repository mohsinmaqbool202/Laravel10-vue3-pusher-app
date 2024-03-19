<template>
    <AuthDefaultLayout>
        <template #title>
            <h1>Register</h1>
        </template>
        <template #default>
            <form @submit.prevent="register">
                <div class="input-element">
                    <input type="name" placeholder="Name" v-model="user.name" required>
                </div>
                <div class="input-element">
                    <input type="email" placeholder="Email" v-model="user.email" required>
                </div>
                <div class="input-element">
                    <input type="password" placeholder="Password" v-model="user.password" required>
                </div>
                <div class="input-element">
                    <input type="password_confirmation" placeholder="Confirm Password" v-model="user.password_confirmation" required>
                </div>
                <div class="input-element">
                    <button type="submit">Register</button>
                    <p>Already have an account? <router-link :to="{ name: 'Login' }">Login</router-link></p>
                </div>
            </form>
        </template>
    </AuthDefaultLayout>
</template>

<script setup>
import { ref } from 'vue'
import { toast } from 'vue3-toastify'; 
import { useRouter } from 'vue-router';
import axiosClient from '../plugins/axios'
import AuthDefaultLayout from '../components/auth/AuthDefaultLayout.vue';

const router = useRouter();
const user = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});


function register() {
    axiosClient.post('/register', user.value).then((res) => {
        router.push({name: 'Login'});
        toast.success("You'r registered successfully!")
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
    margin-top: 10px;
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

input, button {
    width: 100%;
    padding: 10px 5px;
}
</style>