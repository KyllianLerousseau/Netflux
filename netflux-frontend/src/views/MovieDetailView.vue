<template>
    <div class="loading" v-if="isLoading">Chargement...</div>
    <div v-else-if="movie">
        <VideoEmbed :url="`${movie.videoUrl}`" />
        <div class="movieDetailsHeader">
            <h2 class="movieTitleDetails">{{ movie.title }}</h2>
            <button class="addFavoriteBtn" :disabled="!isLoggedIn" @click.once=" isFavorite ? removeFavorite(movie.id) : addFavorite(movie.id)">
                {{
                    isFavorite ? "Retirer des favoris" : "Ajouter aux favoris" }}</button>
        </div>

        <div class="movieDetails">
            <MovieItem :movie="movie" />
            <p class="synopsis">{{ movie.synopsis }}</p>
            <button class="backBtn" @click="router.back()">← Retour</button>
        </div>
    </div>
    <div v-else="error">Erreur : {{ error }}</div>
</template>
<script setup>
import MovieItem from '@/components/MovieItem.vue';
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user';
import { useMovies } from '@/composables/useMovies';
import VideoEmbed from '@/components/VideoEmbed.vue';

const route = useRoute();
const router = useRouter();
const id = ref(route.params.id);

const { isLoading, error, movie, fetchMovie } = useMovies();
const userStore = useUserStore();
const isFavorite = ref(false);
const isLoggedIn = computed(() => !!userStore.user);

const addFavorite = async () => {
    if (!movie || !userStore.user) {
        console.warn("Utilisateur non connecté ou film non chargé");
        return; 
    }

    try {
        await userStore.addFavorite(id.value);
        isFavorite.value = true;
    } catch (error) {
        console.error('Erreur lors de l\'ajout aux favoris :', error);
    }
};

const removeFavorite = async () => {
    if (!movie || !userStore.user) {
        console.warn("Utilisateur non connecté ou film non chargé");
        return;
    }

    try {
        await userStore.removeFavorite(id.value);
        isFavorite.value = false;
    } catch (error) {
        console.error('Erreur lors du retrait du favori :', error);
    }
};



function verifyFavorites() {

    const alreadyFavorite = userStore.favorites.some(f => f.id === id.value);

    if (alreadyFavorite) {
        isFavorite.value = true;
    }
}

onMounted(async () => {
    await fetchMovie(id.value);
    await userStore.fetchUserFavorites();

    verifyFavorites();
});

</script>
<style>

.movieTitleDetails {
    text-align: left;
    font-size: 3rem;
    color: var(--frost);
    font-weight: bold;
}



.movieDetailsHeader {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 0px 10px;
}

.movieDetails {
    height: 100%;
    padding: 0px 10px;
    color: var(--white);
    font-size: 1.5rem; 
}

.synopsis {
    text-align: left;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    white-space: normal;
    overflow-wrap: break-word;
}

.addFavoriteBtn {
    height: 50px;
    width: 100px;
    padding: 10px 12px;
    border: none;
    outline: none;
    cursor: pointer;
    color: var(--white);
    border-radius: 8px;
    background-color: var(--blue-ice);
}

.addFavoriteBtn:hover {
    background-color: var(--blue-ice-light);
}

.addFavoriteBtn:disabled {
    cursor: default;
    background-color: var(--blue-ice-dark);
    opacity: 0.7;
}
</style>