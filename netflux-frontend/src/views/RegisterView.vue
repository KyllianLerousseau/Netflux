<template>
    <div>
        <form @submit.prevent="submitRegister">
            <h2>Inscription</h2>
            <div v-if="store.isLoading" class="loading">Chargement...</div>
            <div class="credentials-container">
                <label>Email</label>
                <input v-model="email" type="email" :class="{ error: store.errors.email }">
            </div>
            <span v-if="store.errors.email" class="error-msg">{{ store.errors.email }}</span>
            <div class="credentials-container">
                <label>Nom d'utilisateur</label>
                <input v-model="pseudo" type="text" :class="{ error: store.errors.pseudo }"></input>
            </div>
            <span v-if="store.errors.pseudo" class="error-msg">{{ store.errors.pseudo }}</span>
            <div class="credentials-container">
                <label>Mot de passe</label>
                <input v-model="password" type="password" :class="{ error: store.errors.password }">
            </div>
            <span v-if="store.errors.password" class="error-msg">{{ store.errors.password }}</span>
            <div class="credentials-container">
                <label>Confirmer le mot de passe</label>
                <input v-model="confirmPassword" type="password" :class="{ error: store.errors.confirmPassword }">
            </div>
            <span v-if="store.errors.confirmPassword" class="error-msg">{{ store.errors.confirmPassword }}</span>
            <button type="submit">S'inscrire</button>
            <p class="registerText">Vous avez déjà un compte ? <router-link to="/login" class="registerText2">Connectez
                    vous !</router-link></p>
        </form>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';

const store = useUserStore();

const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const pseudo = ref("");



const submitRegister = async () => {
    store.register(email.value, pseudo.value, password.value, confirmPassword.value);
}
</script>
<style scoped>

form {
    height: 650px;
}

input {
    background-color: transparent !important;
    color: var(--white) !important;
}

.credentials-container {
    padding: 10px;
    display: flex;
    flex-direction: column;
}

.registerText {
    color: var(--white);
}

.registerText2 {
    color: var(--teal-frozen);
    text-decoration: none;
    font-weight: bold;
}

.error-msg {
    color: red;
    font-weight: bold;
    text-align: center;
    margin-bottom: 5px;
}

.error {
    border: 2px solid red;
}

@media only screen and (max-width: 600px) {
    form {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>