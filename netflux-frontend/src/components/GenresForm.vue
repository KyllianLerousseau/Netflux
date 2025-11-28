<template>
    <div class="main">
        <button @click="router.back()">← Retour</button>
        <div v-if="isLoading" class="loadingText">Chargement du formulaire...</div>
        <h1>{{ isEdit ? 'Modifier le genre' : 'Créer un nouveau genre' }}</h1>

        <form @submit.prevent="handleSubmit">
            <div class="genre-container">
                <label>Nom du genre</label>
                <input id="name" v-model="form.name" :class="{ error: error }" />
            </div>

            <div class="buttons">
                <button type="submit" :disabled="isLoading">{{ isEdit ? 'Mettre à jour' : 'Créer' }}</button>
                <button @click="router.back()">Annuler</button>
            </div>

            <p v-if="error" class="error-msg">{{ error }}</p>
        </form>
    </div>
</template>
<script setup>
import { useRouter, useRoute } from 'vue-router';
import { useGenres } from '@/composables/useGenres';
import { computed, onMounted, reactive } from 'vue';

const { isLoading, error, fetchGenre, addGenre, updateGenre, genre } = useGenres();

const route = useRoute()
const router = useRouter()
const id = route.params.id

const isEdit = computed(() => !!id);

const form = reactive({
    name: ''
});

onMounted(async () => {
    if (isEdit.value) {
        await fetchGenre(id)

        if (genre.value) {
            form.name = genre.value.name || ''
        }
    }
})

const handleSubmit = async () => {
    if (!form.name.trim()) {
        error.value = "Veuillez remplir le champ nécessaire.";
        return
    }

    try {
        if (isEdit.value) {
            await updateGenre(id, { name: form.name });
        } else {
            await addGenre({ name: form.name });
        }

        router.push('/admin/movies/genres');
    } catch (err) {
        console.error(err);
    }
}

</script>
<style scoped>
.genre-container {
    display: flex;
    flex-direction: column;
    padding: 10px;
}

.genre-container input {
    background: transparent;
    color: var(--white);
}

form {
    height: fit-content;
    padding: 8px 0px;
    width: fit-content;
}

.main {
    padding: 8px;
}

h1 {
    text-align: center;
}

.loadingText {
    text-align: center;
    font-weight: 500;
    font-size: 1.4rem;
    color: var(--silver);
}

.buttons {
    display: flex;
    gap: 15px;
}

.error-msg {
    color: red;
    font-weight: bold;
    font-size: 1.2rem;
}

.error {
    border: 2px solid red;
}
</style>