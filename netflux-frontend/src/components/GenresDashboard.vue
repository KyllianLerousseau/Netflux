<template>
    <div class="genres-container">
        <h1>Genres</h1>
        <div class="loading" v-if="isLoading">Chargements des données...</div>
        <div class="error" v-else-if="error">Erreur : {{ error }}</div>
        <div v-else class="table-container">
            <button class="add-genre"><router-link class="link" to="/admin/movies/genres/new">Ajouter un
                    genre</router-link></button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Genres</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="genre in genresName" :key="genre.id">
                        <td class="td-text">{{ genre.id }}</td>
                        <td class="td-text">{{ genre.name }}</td>
                        <td class="td-actions">
                            <button><router-link class="link" :to="`/admin/movies/genres/${genre.id}`">Modifier le
                                    genre</router-link></button>
                            <button class="delete-genre" @click="deleteGenre(genre.id)">Supprimer le genre</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted } from 'vue';
import { useGenres } from '@/composables/useGenres';


const { fetchGenres, genres, isLoading, error, deleteGenre } = useGenres();

const genresName = computed(() => {
    const map = new Map();

    genres.value.forEach(g => {
        const id = Number(g['@id'].split('/').pop());

        if (!map.has(g.name)) {
            map.set(g.name, { id, name: g.name });
        }
    });

    return [...map.values()];
});

onMounted(async () => {
    await fetchGenres();

});

</script>
<style scoped>
h1 {
    color: var(--white);
    text-align: center;
    font-size: 2rem;
    padding: 5px;
}

.link {
    text-decoration: none;
    color: var(--white);
    font-size: 0.8rem;
}

.genres-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.table-container {
    width: 100%;
    max-width: 900px;
    overflow-x: auto;
    box-sizing: border-box;
    padding: 5px;
}

table {
    width: 100%;
    min-width: 500px;
    border-collapse: collapse;
    border: 4px solid var(--graphite);
    border-radius: 8px;
    overflow: hidden;
}

thead {
    background-color: var(--graphite);
    color: var(--white);
    font-size: 16px;
}

th,
td {
    padding: 10px 8px;
    font-size: 14px;
}

.td-text {
    color: var(--white);
    text-align: center;
    font-size: 18px;
}

.td-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.delete-genre {
    background-color: red;
    font-weight: bold;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    width: auto;
    min-width: 80px;
    cursor: pointer;
    transition: 0.2s;
}

.delete-genre:hover {
    background-color: brown;
}

.add-genre {
    margin-bottom: 8px;
}

@media only screen and (max-width: 600px) {
    thead {
        font-size: 14px;
    }

    th,
    td {
        font-size: 12px;
        padding: 6px 4px;
    }

    table {
        min-width: 100%;
    }

    .td-actions {
        display: flex;
        flex-direction: column;
    }

    .delete-genre {
        font-size: 12px;
        border-radius: 8px;
        min-width: 60px;
    }

    button {
        height: 40px;
        font-size: 12px;
        min-width: 60px;
    }
}
</style>