<template>
    <div>
        <form @submit.prevent="submitLogin">
            <h2>Connexion</h2>
            <div v-if="store.isLoading" class="loading">Chargement...</div>
            <p class="error-msg">{{ store.error }}</p>
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
}
</script>
<style scoped>
:root {
    /* Dégradé */
    --bg-start: #434343;
    --bg-end: #000000;

    /* Accents froids */
    --blue-ice: #4EA8DE;
    /* Bleu glacé principal */
    --blue-ice-light: #74c0fc;
    /* Lumière froide */
    --blue-ice-dark: #1c6693;
    /* Accent profond */

    /* Froids neutres */
    --frost: #dce4eb;
    /* Bordures froides / textes clairs */
    --silver: #9aa6b2;
    /* Gris froid métallique */
    --graphite: #5c6770;
    /* Gris ardoise */

    /* Couleurs complémentaires froides */
    --cyan-cold: #3bc9db;
    /* Cyan polaire, très lumineux */
    --teal-frozen: #0ca6b6;
    /* Teal glacial */
    --mint-cold: #a1f2e1;
    /* Vert d’eau froid */

    /* Neutres généraux */
    --white: #f2f6f8;
    --black: #000000;
}

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

@media only screen and (max-width: 600px) {
    form {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>