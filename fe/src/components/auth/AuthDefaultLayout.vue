<template>
    <div class="auth-wrapper">
        <div class="auth-content">
            <slot name="title"></slot>
            <slot></slot>
            <slot name="links"></slot>
        </div>
    </div>
</template>

<style scoped>
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}
.auth-content {
    display: flex;
    flex-direction: column;
    width: 600px;
}
</style>