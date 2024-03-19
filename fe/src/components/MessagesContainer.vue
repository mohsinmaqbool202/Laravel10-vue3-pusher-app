<template>
    <div class="messages-container" :style="[mode == 'broadcast' ? 'width: 100%' : 'width: 70%']">
        <!-- message header -->
        <div class="msg-header">
            <UserIcon />
            <span v-if="selectedUser">{{ selectedUser.name }}</span>
        </div>

        <!-- messages -->
        <Messages :messages="messages" />
        <!-- msg input -->
        <MessageInput @send-msg="sendMessage" v-if="selectedUser" />
    </div>
</template>

<script setup>
import Messages from './Messages.vue';
import axiosClient from '../plugins/axios';
import UserIcon from './icons/UserIcon.vue';
import { ref, onMounted, watch } from 'vue';
import { useAuthStore } from '../store/auth';
import MessageInput from './MessageInput.vue';

//props
const props = defineProps({
    mode: {
        type: String,
        default: ''
    },
    oneToOneSelectedUser: {
        type: Object,
        default: null
    }
})

//auth store
const authStore = useAuthStore();

//states
const selectedUser = ref(null);
const messages = ref([]);

// mounted hook
onMounted(() => {
    // if mode is broadcast listen to public messages
    // and set the auth user as selected user
    if (props.mode === 'broadcast') {
        const channel = window.Echo.private('m-chat');
        channel.listen('MessageSent', (e) => {
            handleReceivedMessage(e);
        })

        selectedUser.value = authStore.userData
        fetchMessages();
    }
});

//methods
const sendMessage = (msg) => {
    msg.friend_id = selectedUser.value.id
    axiosClient.post('/messages', msg).then(() => {
        fetchMessages();
    })
}

const fetchMessages = () => {
    axiosClient.get(`/messages/${selectedUser.value.id}`).then(({ data }) => {
        messages.value = data.data
    })
}

const handleOneToOneSelectedUser = (user) => {
    selectedUser.value = user
    messages.value = []
    fetchMessages();

    // set listener for one to one messages
    const channel = window.Echo.private('private-chat.' + authStore.userData.id);
    channel.listen('PrivateMessageSent', (e) => {
        handleReceivedMessage(e);
    })
}

const handleReceivedMessage = (e) => {
    let { message } = e;
    let { user } = message;
    messages.value.push({
        id: message.id,
        message: message.message,
        user_id: message.user_id,
        created_at: message.created_at,
        user: {
            id: user.id,
            name: user.name,
            email: user.email
        }
    })

    window.scrollTo(0, 99999);
}

//watchers
watch(
    () => props.oneToOneSelectedUser,
    (val) => handleOneToOneSelectedUser(val)
)
</script>

<style scoped>
.messages-container {
    position: relative;
    height: calc(100% - 50px);
    background-color: #fff;
    border-radius: 15px;
}

/* msg-header */
.msg-header {
    display: flex;
    gap: 15px;
    align-items: center;
    padding: 10px;
    color: #fff;
    background-color: #236f9f;
    border-top-right-radius: 12px;
    border-top-left-radius: 12px;
}

.msg-header svg {
    width: 45px;
    height: 45px;
    border: 1px solid lightgrey;
    border-radius: 100px;
    padding: 5px;
}
</style>