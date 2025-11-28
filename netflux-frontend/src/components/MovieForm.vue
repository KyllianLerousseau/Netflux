<template>
    <div class="main">
        <button @click="router.back()">← Retour</button>
        <div v-if="isLoading" class="loadingText">Chargement du formulaire...</div>
        <h1>{{ isEdit ? 'Modifier le film' : 'Créer un nouveau film' }}</h1>

        <form @submit.prevent="handleSubmit">
            <div class="title-container">
                <label>Titre</label>
                <input id="title" v-model="form.title" :class="{ error: errors.title || globalError }" />
            </div>
            <span v-if="errors.title" class="error-msg">{{ errors.title }}</span>
            <div class="synopsis-container">
                <label>Synopsis</label>
                <textarea id="synopsis" rows="8" v-model="form.synopsis"
                    :class="{ error: errors.synopsis || globalError }"></textarea>
            </div>
            <span v-if="errors.synopsis" class="error-msg">{{ errors.synopsis }}</span>
            <div class="releaseDate-container">
                <label>Date de réalisation</label>
                <input type="date" v-model="form.date" :class="{ error: errors.releaseDate || globalError }">
            </div>
            <span v-if="errors.releaseDate" class="error-msg">{{ errors.releaseDate }}</span>
            <div class="duration-container">
                <label>Durée</label>
                <input type="number" v-model="form.duration" :class="{ error: errors.duration }">
            </div>
            <span v-if="errors.duration" class="error-msg">{{ errors.duration }}</span>
            <div class="imageLink-container">
                <label>Lien de l'affiche</label>
                <input type="file" @change="onFileChange" class="file-hidden" />
                <p class="imgText">Fichier pré-selectionné : {{ form.imagePath }}</p>
            </div>

            <div class="videoLink-container">
                <label>Bande-annonce</label>
                <input type="text" v-model="form.videoUrl" placeholder="(Lien youtube valide)">
            </div>

            <div class="type-container">
                <label>Type</label>
                <select id="type" v-model="form.type">
                    <option value="movie">Film</option>
                    <option value="serie">Série</option>
                </select>
            </div>
            <span v-if="errors.type" class="error-msg">{{ errors.type }}</span>

            <div class="selectGenres-container">
                <label>Genres</label>
                <div class="genres" v-for="genre in allGenres" :key="genre.id">
                    <input type="checkbox" :id="'genre-' + genre.id" :value="genre.id" v-model="form.genres">
                    <label :for="'genre-' + genre.id">{{ genre.name }}</label>
                </div>
                <span v-if="errors.genres" class="error-msg">{{ errors.genres }}</span>
            </div>
            <div class="buttons">
                <button type="submit" :disabled="isLoading">{{ isEdit ? 'Mettre à jour' : 'Créer' }}</button>
                <button @click="router.back()">Annuler</button>
            </div>
            <div v-if="globalError" class="global-error">{{ globalError }}</div>
        </form>
    </div>
</template>
<script setup>
import { useRouter, useRoute } from 'vue-router';
import { useMovies } from '@/composables/useMovies';
import { computed, onMounted, reactive } from 'vue';
import { useGenres } from '@/composables/useGenres';
import { useMovieErrors } from '@/composables/useMovieErrors';

const { errors, isLoading, fetchMovie, createMovie, updateMovie, movie, globalError } = useMovies();
const { resetErrors } = useMovieErrors()
const { genres: allGenres, fetchGenres } = useGenres();

const router = useRouter();
const route = useRoute();
const id = route.params.id;

const isEdit = computed(() => !!id);

const form = reactive({
    title: '',
    synopsis: '',
    date: '',
    duration: 0,
    videoUrl: '',
    type: 'movie',
    genres: [],
    imagePath: '',
    image: null,
});

const onFileChange = (e) => {
    const file = e.target.files[0]
    if (!file) return
    form.image = file
    form.imagePath = file.name
}

onMounted(async () => {
    await fetchGenres();
    resetErrors();
    if (isEdit.value) {

        await fetchMovie(id);

        if (movie.value) {

            form.title = movie.value.title
            form.synopsis = movie.value.synopsis
            form.date = movie.value.releaseDate.split("T")[0]
            form.duration = movie.value.duration
            form.imagePath = movie.value.imagePath
            form.videoUrl = movie.value.videoUrl
            form.type = movie.value.type
            form.genres = movie.value.genres.map(g => g.id)
        }
    }
});


const handleSubmit = async () => {
    resetErrors();

    if (!form.title.trim() || !form.synopsis.trim()) {
        globalError.value = "Veuillez remplir le champ nécessaire.";
        return
    }

    if (!form.date) {
        errors.date = "Veuillez choisir une date.";
        return;
    }

    try {

        const formData = new FormData();
        formData.append('title', form.title);
        formData.append('synopsis', form.synopsis);
        formData.append('releaseDate', form.date);
        formData.append('duration', form.duration);
        formData.append('videoUrl', form.videoUrl);
        formData.append('type', form.type);

        form.genres.forEach(id => formData.append('genres[]', `/api/genres/${id}`))

        if (form.image) {
            formData.append('image', form.image);
        }
        if (isEdit.value) {
            await updateMovie(id, formData);
        } else {
            await createMovie(formData);
        }

        router.push('/admin/movies');
    } catch (err) {
        globalError.value = err;
    }
}
</script>
<style scoped>
form {
    align-items: center;
    padding: 8px 0px;
    height: fit-content;
    width: 500px;
    gap: 10px;
}

input {
    background-color: transparent;
    color: var(--white);
}

.title-container,
.synopsis-container,
.releaseDate-container,
.duration-container,
.imageLink-container,
.videoLink-container {
    display: flex;
    flex-direction: column;
    padding: 5px;
}

.synopsis-container textarea {
    width: 300px;
    height: 100px;
    resize: none;
    outline: none;
    background: transparent;
    border: 3px solid var(--graphite);
    color: var(--white);
    border-radius: 10px;
}

.buttons {
    padding: 10px 0px;
    display: flex;
    gap: 15px;
}

.selectGenres-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}

.selectGenres-container label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #fff;
}

.genres {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.genres>div {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 8px;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.05);
    transition: background 0.2s;
    cursor: pointer;
    min-width: 120px;
}

.genres input[type="checkbox"] {
    margin-right: 8px;
    accent-color: var(--blue-ice-dark);
    transform: scale(1.2);
}

.genres label {
    display: flex;
    align-items: center;
    color: var(--white);
    cursor: pointer;
    padding: 5px 8px;
    border-radius: 5px;
    transition: background 0.2s;
    white-space: nowrap;
}

.type-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.type-container select {
    padding: 4px 10px;
    outline: none;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    background-color: var(--blue-ice);
    color: var(--white);
}

h1 {
    text-align: center;
}

.error-msg {
    color: red !important;
    font-weight: bold;
    text-align: center;
    margin-bottom: 5px;
}

.error {
    border: 2px solid red !important;
}

.global-error {
    background: rgba(255, 0, 0, 0.1);
    border-left: 4px solid red;
    padding: 8px;
    margin-bottom: 12px;
    color: red;
}

.imgText {
    color: var(--silver);
    text-align: center;
}


@media only screen and (max-width: 600px) {
    form {
        width: 100%;
        box-sizing: border-box;
    }

    .genres {
        flex-direction: column;
    }

    .genres>div {
        min-width: 0;
        width: 100%;
    }
}
</style>