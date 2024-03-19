<template>
    <div class="header">
        <ul>
            <li @click="selectChatMode('broadcast')">
                BroadCast Chat
            </li>
            <li @click="selectChatMode('one-to-one')">
                One to One Chat
            </li>
        </ul>
    </div>

    <!-- dynamic component -->
    <component :is="chatMode" :mode="mode"></component>
</template>

<script setup>
import { ref, shallowRef  } from 'vue';
import BroadCastChat from '../components/BroadCastChat.vue';
import OneToOneChat from '../components/OneToOneChat.vue';

let chatMode = shallowRef(BroadCastChat);
const mode = ref('broadcast');

const selectChatMode = (m) => {
    if(m == 'broadcast') {
        chatMode.value = BroadCastChat;
        mode.value = 'broadcast'
    }
    else {
        chatMode.value = OneToOneChat;
        mode.value = 'one-to-one'
    }
}
</script>

<style scoped>
.header {
    width: 100%;
    padding: 10px 0;
}
.header ul {
    display: flex;
    gap: 20px;
    justify-content: center;
    color: white;
    list-style: none;
    cursor: pointer;
}

.header ul li {
    border-bottom: 1px solid #fff;
}
</style>