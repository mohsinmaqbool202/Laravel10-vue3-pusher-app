<template>
    <li @click="selectUser" :class="[selectedUserId == user.id ? 'user-selected' : '']">
        <div class="user-name">
            <UserIcon />
            <span>{{ user.name }}</span>
        </div>
    </li>
</template>

<script setup>
import UserIcon from './icons/UserIcon.vue';

// emits
const emits = defineEmits(['select-user'])

// props
const props = defineProps({
    user: {
        type: Object,
        default() {
            return {}
        }
    },
    selectedUserId: {
        type: Number,
        default: null
    }
});

// methods
const selectUser = () => {
    emits('select-user', props.user)
}
</script>

<style scoped>
.users-list li {
    display: flex;
    justify-content: space-between;
    padding: 15px;
    cursor: pointer;
    border-bottom: 1px solid lightgray;
}

.users-list li:first-child {
    border-top-right-radius: 12px;
    border-top-left-radius: 12px;
}

.users-list li:hover {
    background-color: #236f9f;
    color: white;
    transition: all ease-in-out .2s;
}

.user-name {
    display: flex;
    gap: 10px;
    font-weight: 600;
}

.users-list li svg {
    width: 40px;
    height: 40px;
    border: 1px solid lightgrey;
    border-radius: 100px;
    padding: 5px;
}

.user-selected {
    color: white;
    background-color: #236f9f;
}
</style>