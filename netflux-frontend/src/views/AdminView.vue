<template>
    <div class="split">
        <router-link class="movie-panel" to="/admin/movies">
            <div>
                <h1>Films & Genres</h1>
            </div>
        </router-link>
        <router-link class="user-panel" to="/admin/users">
            <div>
                <h1>Utilisateurs</h1>
            </div>
        </router-link>
    </div>
</template>
<script setup>
</script>
<style scoped>
:root {
    /* Dégradé */
    --bg-start: #434343;
    --bg-end: #000000;
    --bg-middle: #111111;

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

.split {
    display: flex;
    height: 93vh;
    width: 100%;
}

.movie-panel {
    flex: 1;
    display: flex;
    width: 100%;
    padding: 1.5rem;
    border-right: 3px solid var(--graphite);
    justify-content: center;
    align-items: center;
    font-size: 3rem;
    text-decoration: none;
}

.movie-panel h1 {
    color: var(--black);
}

.movie-panel:hover {
    background-color: var(--bg-start);
    cursor: pointer;
}

.movie-panel:hover h1 {
    color: var(--white);
}

.user-panel {
    flex: 1;
    display: flex;
    width: 100%;
    padding: 1.5rem;
    justify-content: center;
    align-items: center;
    font-size: 3rem;
    text-decoration: none;
}

.user-panel h1 {
    color: var(--black);
}

.user-panel:hover {
    background-color: var(--bg-start);
    cursor: pointer;
}

.user-panel:hover h1 {
    color: var(--white);
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

    .movie-panel {
        border-bottom: 3px solid var(--graphite);
    }
}
</style>