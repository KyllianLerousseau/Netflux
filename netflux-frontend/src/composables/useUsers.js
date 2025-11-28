import { ref } from "vue";
import api from "@/api/axios";
import { useUserStore } from "@/stores/user";

export function useUsers() {
  const users = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const auth = useUserStore();

  const fetchUsers = async () => {
    loading.value = true;
    try {
      const { data } = await api.get("/users");
      users.value = data.member ?? data;
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  };

  const fetchUser = async (id) => {
    loading.value = true;
    try {
      const { data } = await api.get(`/users/${id}`);
      if (auth.user?.id === id) {
        auth.user = data;
      }
      return data;
    } catch (err) {
      error.value = err;
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const updateUser = async (id, payload) => {
    loading.value = true;
    try {
      const { data } = await api.patch(`/users/${id}`, payload, {
        headers: {
          "Content-Type": "application/merge-patch+json",
        },
      });

      if (auth.user?.id === id) {
        auth.user = data;
      }

      const index = users.value.findIndex((u) => u.id === id);
      if (index !== -1) users.value[index] = data;
      return data;
    } catch (err) {
      error.value = err;
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const deleteUser = async (id) => {
    loading.value = true;
    try {
      await api.delete(`/users/${id}`);
      users.value = users.value.filter((u) => u.id !== id);
    } catch (err) {
      error.value = err;
      throw err;
    } finally {
      loading.value = false;
    }
  };

  return {
    users,
    loading,
    error,
    fetchUsers,
    fetchUser,
    updateUser,
    deleteUser,
  };
}
