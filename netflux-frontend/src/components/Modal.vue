<template>
    <div v-if="isOpen" class="modal-overlay" @click="close">
        <div class="modal-content" @click.stop>
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
defineProps({
    isOpen: Boolean
})

const emit = defineEmits(['close']);
const close = () => emit('close');
</script>
<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: var(--bg-start);
    color: var(--white);
    padding: 12px;
    border-radius: 12px;
    box-shadow: 10px 12px 10px rgba(0, 0, 0, 1);
    text-align: center;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>