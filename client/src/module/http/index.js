import axios from "axios";
import { LocalStorage, Notify } from "quasar";
import router from "src/router";

const http = axios.create({
  baseURL: process.env.API_URL,
  headers: {
    "X-Requested-With": "XMLHttpRequest",
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

if (LocalStorage.has("token")) {
  http.defaults.headers.common[
    "Authorization"
  ] = `Bearer ${LocalStorage.getItem("token")}`;
}

http.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      LocalStorage.remove("token");
      LocalStorage.remove("user");
      http.defaults.headers.common["Authorization"] = "Bearer";
      Notify.create({ message: "Não autorizado.", type: "negative" });
      router().push({ name: "login" });
    }
    return Promise.reject(error);
  }
);

export default http;
