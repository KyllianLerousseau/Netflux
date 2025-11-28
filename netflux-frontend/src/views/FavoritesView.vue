<template>
    <div class="favoris-container">
        <div class="favoris-card" v-for="favori in store.favorites">
            <h1>{{ favori.title }}</h1>
            <div class="img-container">
                <router-link :to="`/movies/${favori.id}`">
                    <img class="img-movie" :src="`http://127.0.0.1:8000/uploads/${favori.imagePath}`"
                        :alt="favori.title">
                </router-link>
            </div>
            <button class="deleteBtn" @click="store.removeFavorite(favori.id)">Supprimer le favori</button>
        </div>
    </div>
</template>
<script setup>
import { useUserStore } from '@/stores/user';
import { onMounted } from 'vue';

const store = useUserStore();

onMounted(async () => {
    await store.fetchUserFavorites();

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

.favoris-card {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    border: 2px solid var(--graphite);
    width: 250px;
    height: 400px;
    padding: 8px;
    border-radius: 8px;
    margin: 5px auto;
}

.favoris-container {
    padding: 20px 0px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(auto, 1fr);
    gap: 10px;
}

.favoris-card h1 {
    font-size: 2rem;
    font-weight: bold;
    color: var(--silver);
}

.deleteBtn {
    border: none;
    background-color: var(--blue-ice);
    color: var(--white);
    cursor: pointer;
}

.deleteBtn:hover {
    transform: translateY(-5px);
    background-color: var(--blue-ice-dark);
    box-shadow: 6px 6px 4px black;
}

.img-movie {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.img-container {
    height: 250px;
    width: 200px;
    border-radius: 4px;
    overflow: hidden;
}

@media only screen and (max-width: 600px) {
    .favoris-card h1 {
        font-size: 1.5rem;
    }

    .favoris-container {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
    }
}
</style>