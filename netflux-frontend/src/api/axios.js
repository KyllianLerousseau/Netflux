import axios from "axios";
import { useUserStore } from "@/stores/user";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL + "/api",
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      const userStore = useUserStore();
      console.warn("Token expiré ou invalide. Déconnexion automatique.");
      userStore.logout();
    }
    return Promise.reject(error);
  }
);
export default api;
