<template>
    <div>
        <form @submit.prevent="submitLogin">
            <h2>Connexion</h2>
            <div v-if="store.isLoading" class="loading">Chargement...</div>
            <p v-else-if="store.error" class="error-msg">{{ store.error }}</p>
            <p v-else-if="store.succes" class="succes-msg">{{ store.succes }}</p>
            <div class="credentials-container">
                <label>Email</label>
                <input v-model="email" type="text" :class="{ error: store.error }">
            </div>
            <div class="credentials-container">
                <label>Mot de passe</label>
                <input v-model="password" type="password" :class="{ error: store.error }">
            </div>
            <button class="connexionBtn" type="submit">Se connecter</button>
            <p class="registerText">Vous n'avez pas encore de compte ? <router-link to="/register"
                    class="registerText2">Créez-en un !</router-link></p>
        </form>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';

const store = useUserStore();

const email = ref("");
const password = ref("");

const submitLogin = async () => {
    store.error = null;

    if (!email.value || !password.value) {
        store.error = "Veuillez renseignez vos identifiants.";
        return;
    }

    store.isLoading = true;

    store.login(email.value, password.value);

    if (store.succes === true) {
        store.isLoading = false;
    }

}
</script>
<style scoped>
form {
    gap: 22px;
}

.credentials-container {
    padding: 10px;
    display: flex;
    flex-direction: column;
}

.credentials-container input {
    background-color: transparent;
    color: var(--white);
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
    font-size: 1.4rem;
}

.error {
    border: 2px solid red;
}

.succes-msg {
    color: green;
    font-weight: bold;
    font-size: 1.4rem;
    text-align: center;
}

@media only screen and (max-width: 600px) {
    form {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>