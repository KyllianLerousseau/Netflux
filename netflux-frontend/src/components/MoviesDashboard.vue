<template>
    <h2>Movie Dashboard</h2>
    <div class="loading" v-if="isLoading">Chargements des données...</div>
    <div class="error" v-else-if="error">Erreur : {{ error }}</div>
    <div class="content" v-else>
        <div class="button-container">
            <button><router-link class="link" to="/admin/movies/new">Ajouter un film</router-link></button>
            <button><router-link to="/admin/movies/genres" class="link">Afficher les genres</router-link></button>
        </div>
        <div class="filters">
            <input v-model="searchQuery" type="text" placeholder="Rechercher un film ou une série...">
            <div class="categoriesBtn">
                <button @click="selected = ''" class="moviesBtn">Tous</button>
                <button @click="selected = 'movie'" class="moviesBtn">Films</button>
                <button @click="selected = 'serie'" class="moviesBtn">Séries</button>
                <select class="selectGenres" v-model="selectedGenre">
                    <option value="">Tous</option>
                    <option v-for="genre in genres" :key="genre" :value="genre">
                        {{ genre }}
                    </option>
                </select>
            </div>
        </div>
        <div v-if="filteredMovies.length > 0" class="results">
            <div v-for="(movie, index) in filteredMovies" :key="movie.id" class="card"
                :class="{ filter: activeIndexes.includes(index) }">
                <div class="imgContainer">
                    <img class="imgMovie" :src="`http://127.0.0.1:8000/uploads/${movie.imagePath}`"
                        :alt="`${movie.title}`">
                </div>
                <h3 class="movieTitle">{{ movie.title }}</h3>
                <div class="button-container">
                    <button><router-link class="link" :to="`/admin/movies/${movie.id}`">Modifier</router-link></button>
                    <button @click="deleteMovie(movie.id)">Supprimer</button>
                </div>
            </div>
        </div>
        <div class="noResults" v-else>
            <h2>Aucun contenu correspondant</h2>
        </div>
        <div class="pagination">
            <ul v-for="pageIndex in totalPages">
                <button class="paginationBtn" @click="goToPage(pageIndex)"> {{ pageIndex }}</button>
            </ul>
        </div>
    </div>
</template>
<script setup>
import { useMovies } from '@/composables/useMovies';
import { ref, computed, onMounted, watch } from 'vue';

const { isLoading, error, movies, fetchMovies, totalItems, page, limit, deleteMovie } = useMovies()

const searchQuery = ref("");
const selectedGenre = ref("");
const selected = ref(null);

const totalPages = computed(() =>
    Math.ceil(totalItems.value / limit.value));

const goToPage = async (newPage) => {

    page.value = newPage;
    await fetchMovies();
}

const genres = computed(() => {
    const allGenres = [...new Set(movies.value.flatMap(movie => movie.genres.map(g => g.name)))]

    return allGenres;
});

const filteredMovies = computed(() => {

    let listFiltree = movies.value;

    if (searchQuery.value.trim() !== "") {
        listFiltree = listFiltree.filter(movie => movie.title.toLowerCase().includes(searchQuery.value.toLowerCase()));
    }

    if (selectedGenre.value !== "") {
        listFiltree = listFiltree.filter(movie => movie.genres.some(g => g.name === selectedGenre.value));
    }

    if (selected.value) {
        listFiltree = listFiltree.filter(movie => movie.type === selected.value);
    }

    return listFiltree;
})


const activeIndexes = ref([]);

function animationCards() {
    activeIndexes.value = [];

    filteredMovies.value.forEach((_, index) => {
        setTimeout(() => {
            activeIndexes.value.push(index);
        }, (index + 1) * 100);
    });
}

watch(filteredMovies, () => {
    animationCards();
});


onMounted(async () => {
    await fetchMovies();

    animationCards();
});

</script>
<style scoped>
h2 {
    text-align: center;
}

.button-container {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.content {
    display: flex;
    flex-direction: column;
}

.filters {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    flex-direction: column;
}

.filters input {
    width: 300px;
    padding: 10px;
    border: none;
    outline: none;
    border-radius: 8px;
}

.results {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(4, 1fr);
    flex-wrap: wrap;
    margin-top: 15px;
    padding: 0px 10px;
    gap: 5px;
}

.card {
    height: 300px;
    width: 200px;
    text-align: center;
    flex: 1;
    margin-bottom: 40px;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    transition: all 0.3s ease;
}

.card.filter {
    transform: translate(0) scale(1);
    opacity: 1;
}

.link {
    text-decoration: none;
    color: var(--white);
}

.noResults {
    text-align: center;
    color: var(--silver);
    font-weight: bold;
}

.imgContainer {
    height: 250px;
    width: 200px;
    border-radius: 4px;
    overflow: hidden;
}

.imgMovie {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.movieTitle {
    color: var(--frost);
    margin-bottom: 10px;
    font-size: 1rem;
}

.categoriesBtn {
    padding-top: 12px;
    display: flex;
    gap: 18px;
}

.moviesBtn {
    padding: 8px 14px;
    width: 75px;
    border: none;
    outline: none;
    border-radius: 25px;
    background-color: var(--blue-ice);
    color: var(--white);
    cursor: pointer;
    box-shadow: 5px 8px rgba(0, 0, 0, 0.25);
}

.moviesBtn:hover {
    background-color: var(--blue-ice-light);
}

.moviesBtn:active {
    transform: scale(1.2);
}

.moviesBtn:focus {
    background-color: var(--blue-ice-dark);
}

.selectGenres {
    padding: 8px 14px;
    width: 145px;
    border: none;
    outline: none;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    background-color: var(--blue-ice);
    color: var(--white);
    box-shadow: 0px 8px rgba(0, 0, 0, 0.25);
}

.pagination {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;

}

.paginationBtn {
    border: none;
    outline: none;
    border-radius: 50%;
    padding: 8px 12px;
    background-color: var(--blue-ice);
    color: var(--white);
    cursor: pointer;
}

.paginationBtn:active {
    transform: scale(1.2);
}

.paginationBtn:focus {
    background-color: var(--blue-ice-dark);
}

.paginationBtn:hover {
    background-color: var(--blue-ice-light);
}

@media only screen and (max-width: 600px) {
    .content {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        width: 100%;
        overflow: auto;
    }

    .categoriesBtn {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 20px;
    }

    .results {
        width: 100%;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(4, 1fr);
        box-sizing: border-box;
        gap: 15px;
    }

    .card {
        width: 100%;
        height: 100%;
        margin-bottom: 10px;
    }

    .imgContainer {
        width: 100%;
        height: 150px;
    }
}
</style>