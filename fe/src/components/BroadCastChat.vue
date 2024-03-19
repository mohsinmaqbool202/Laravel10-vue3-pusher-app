<template>
    <div class="chat-box-container">
        <MessagesContainer :mode="mode" />
    </div>
</template>

<script setup>
import MessagesContainer from './MessagesContainer.vue';

defineProps(['mode'])

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