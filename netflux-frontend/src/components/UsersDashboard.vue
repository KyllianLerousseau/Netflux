<template>
    <div class="users-container">
        <div>
            <h1>Utilisateurs</h1>
        </div>

        <div v-if="loading">
            <h2>Chargement...</h2>
        </div>
        <div v-else class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="left">Id</th>
                        <th class="left">Email</th>
                        <th class="left">Rôles</th>
                        <th class="center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in users" :key="u.id">
                        <td class="td-text">{{ u.id }}</td>
                        <td class="td-text">{{ u.email }}</td>
                        <td class="td-text">{{ u.roles.join(", ") }}</td>
                        <td class="td-actions">
                            <button @click="toggleAdmin(u)">{{ u.roles.includes("ROLE_ADMIN") ? "Retirer admin" :
                                "Rendre admin" }}</button>
                            <button class="delete-user" @click="deleteUser(u.id)">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import { onMounted } from 'vue';
import { useUsers } from '@/composables/useUsers';

const { users, loading, fetchUsers, deleteUser, updateUser } = useUsers();

onMounted(async () => {
    await fetchUsers()

});

const toggleAdmin = async (u) => {
    try {
        const newRoles = u.roles.includes("ROLE_ADMIN")
            ? u.roles.filter(r => r !== "ROLE_ADMIN")
            : [...u.roles, "ROLE_ADMIN"];
        await updateUser(u.id, { roles: newRoles });
    } catch (err) {
        console.error(err);
    }
};
</script>
<style scoped>
.users-container {
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

tr {
    color: var(--white);
    border: 2px solid var(--graphite);
}

.left {
    text-align: left;
}

.center {
    text-align: center;
}

.td-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.delete-user {
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

.delete-user:hover {
    background-color: brown;
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

    .delete-user {
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