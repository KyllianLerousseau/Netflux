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