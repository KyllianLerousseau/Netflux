<template>
    <div class="profil-header">
        <h1>Bienvenue, {{ user.pseudo }} !</h1>
    </div>
    <div class="split">
        <div class="profil-container">
            <h1>Infos Utilisateur</h1>
            <div class="profil-element">
                <label>Adresse mail</label>
                <input type="text" v-model="user.email" disabled>
            </div>
            <div class="profil-element">
                <label>Nom d'utilisateur</label>
                <input type="text" v-model="user.pseudo" disabled>
            </div>
        </div>
        <div class="favorites-container">
            <h1>Infos Favoris</h1>
            <div class="card">
                <h3>Votre total de favoris :</h3>
                <p class="favorite-length">{{ store.favorites.length }}</p>
            </div>
        </div>
    </div>

    <div class="profil-footer">
        <button @click="store.logout()">Déconnexion</button>
    </div>

</template>
<script setup>
import { useUserStore } from '@/stores/user';
import { onMounted } from 'vue';

const store = useUserStore();

onMounted(async () => {
    store.initUserFromToken();

    await store.fetchUserFavorites();

});

const user = store.user;

</script>
<style scoped>

.profil-header {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.split {
    display: flex;
    height: 93vh;
    width: 100%;
    margin-bottom: 10px;
    background-color: var(--bg-start);
}

.profil-container {
    flex: 1;
    border-top: 3px solid var(--graphite);
    border-bottom: 3px solid var(--graphite);
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: 10px;
    gap: 20px;
}

.profil-element {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1.5rem;
    position: relative;
    left: 4%;
}

input {
    position: relative;
    left: 2%;
    background-color: transparent;
    color: var(--white);
    font-size: 1.4rem;
}

.favorites-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    width: 100%;
    border-left: 3px solid var(--graphite);
    border-top: 3px solid var(--graphite);
    border-bottom: 3px solid var(--graphite);
    text-decoration: none;
    color: var(--black);

}

.profil-footer {
    display: flex;
    align-items: center;
    justify-content: center;
}

.text-user {
    color: var(--white);
    font-size: 1.4rem;
}

.profil-container h1 {
    text-align: center;
}

.favorites-container h1 {
    text-align: center;
}

button {
    width: 200px;
    padding: 10px;
    box-shadow: 6px 6px 4px black;
    background-color: red;
    font-weight: bold;
    font-size: 20px;
    margin: 10px;
}

button:hover {
    transform: scale(1.2);
    background-color: brown;
}

.card {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    margin-left: 20px;
    padding: 8px;
    border: 3px solid var(--frost);
    width: 200px;
    height: 200px;
}

h3 {
    color: var(--silver);
    font-size: 20px;
}

.favorite-length {
    text-align: center;
    font-size: 6rem;
    line-height: 0%;
    color: var(--white);
    text-shadow: 6px 6px 4px black;
}

@media only screen and (max-width: 600px) {
    .split {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        align-items: center;
        width: 100%;
        overflow-x: hidden;
    }

    .favorites-container {
        display: flex;
        align-items: center;
    }
}
</style>