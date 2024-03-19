<template>
    <div class="messages">
        <MessageItem v-for="message in messages" :key="message.id" :message="message" />
    </div>
</template>

<script setup>
import MessageItem from './MessageItem.vue';
defineProps({
    messages: {
        type: Array,
        default() {
            return []
        }
    }
})
</script>

<style scoped>
/* messages */
.messages {
    width: 100%;
    height: calc(100% - 110px);
    padding: 15px;
    background-color: #fff;
    overflow-y: auto;
}
</style>