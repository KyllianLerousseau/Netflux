<template>
    <div class="home-container">
        <h1>Netflux</h1>
        <p>Une platforme de streaming avec VueJS et Symfony !</p>
        <div class="routes-container">
            <button><router-link class="route" to="/movies">Voir nos Films/Séries</router-link></button>
            <button><router-link class="route" :to="store.user ? '/profil' : '/login'">{{ store.user ? "Profil"
                :
                    "Connexion" }}</router-Link></button>
            <button v-if="!store.user"><router-link class="route" to="/register">S'inscrire</router-link></button>
        </div>
    </div>
</template>
<script setup>
import { useUserStore } from '@/stores/user';
import { onMounted } from 'vue';
const store = useUserStore();

onMounted(() => {
    store.initUserFromToken();
});
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

.home-container {
    display: flex;
    align-items: center;
    flex-direction: column;
}

.routes-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.route {
    text-decoration: none;
    color: var(--white);
}

h1 {
    color: var(--cyan-cold);
    font-weight: bold;
    font-size: 5rem;
    text-shadow: 6px 4px 4px black;
}

p {
    font-size: 3rem;
    color: var(--white);
    text-shadow: 6px 4px 4px black;
}

button {
    width: 400px;
    background-color: var(--graphite);
    font-size: 20px;
    box-shadow: 6px 6px 6px black;
}

button:hover {
    background-color: var(--cyan-cold);
}

@media only screen and (max-width: 600px) {
    .home-container {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        width: 100%;
    }

    h1 {
        font-size: 4rem;
    }

    button {
        width: 300px;
    }
}
</style>