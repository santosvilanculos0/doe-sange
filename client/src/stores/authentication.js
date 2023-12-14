import { defineStore } from "pinia";
import { LocalStorage } from "quasar";
import http from "src/module/http";
import { ref } from "vue";

export const useAuth = defineStore("authentication", () => {
  const token = ref(LocalStorage.getItem("token"));
  const user = ref(LocalStorage.getItem("user"));
  const authenticated = ref(false);

  const setToken = (value) => {
    LocalStorage.set("token", value);
    token.value = value;
    authenticated.value = true;
  };

  const setUser = (value) => {
    LocalStorage.set("user", value);
    user.value = value;
  };

  const checkToken = () => {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await http.get("/user", {
          headers: {
            Authorization: `Bearer ${token.value}`,
          },
        });
        resolve(response);
      } catch (error) {
        reject(error);
      }
    });
  };

  const clear = () => {
    token.value = null;
    user.value = null;
    authenticated.value = false;
    LocalStorage.remove("token");
    LocalStorage.remove("user");
    authenticated.value = false;
  };

  const isAuthenticated = async () => {
    if (!token.value) {
      return false;
    }

    if (authenticated) {
      return true;
    }

    try {
      const response = await checkToken();
      console.log(response);
      return true;
    } catch (error) {
      console.log(error);
      clear();
      return false;
    }
  };

  const login = async (input) => {
    return new Promise(async (resolve, error) => {
      try {
        const response = await http.post("/login", input);
        setToken(response.data?.token);
        setUser(response.data?.user);
        resolve(response);
      } catch (errord) {
        error(errord);
      }
    });
  };

  const logout = async () => {
    clear();
  };

  const register = async () => {};

  return {
    login,
    logout,
    token,
    user,
    setToken,
    setUser,
    isAuthenticated,
    clear,
  };
});
