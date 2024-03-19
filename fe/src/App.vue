<template>
  <div class="logout" v-if="authStore.userData">
    <button type="button" @click="logout">Logout</button>
  </div>
  <div class="container">
    <router-view></router-view>
  </div>
</template>

<script setup>
import { toast } from 'vue3-toastify'; 
import { useRouter } from 'vue-router';
import axiosClient from './plugins/axios';
import { useAuthStore } from './store/auth';

const router = useRouter();
const authStore = useAuthStore();

function logout() {
  axiosClient.get('/logout').then(() => {
        authStore.clearUserData()
        router.push({name: 'Login'});
        toast.success("You'r logged out!")
    })
    .catch((err) => {
        toast.error(err.response.data.message)
    })
}

</script>

<style scoped>
.container {
  width: 1400px;
  height: 100vh;
  overflow: hidden;
  margin: auto;
}

.logout {
  width: 80px;
  position: absolute;
  right: 5px;
  top: 5px;
}

button {
  cursor: pointer;
  border-radius: 5px;
}
</style>


