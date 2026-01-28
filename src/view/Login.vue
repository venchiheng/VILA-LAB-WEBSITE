<template>
  <div class="login-container">
    <div class="login-card">
      <h2>Admin Login</h2>

      <input
        v-model="memberId"
        type="text"
        placeholder="Member ID"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Password"
      />

      <button @click="login">
        Login
      </button>

      <p v-if="error" class="error">
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script>
import { loginApi } from "@/services/auth/api";

export default {
  name: "Login",
  data() {
    return {
      memberId: "",
      password: "",
      error: "",
      loading: false
    };
  },
  methods: {
    async login() {
      this.error = "";
      this.loading = true;

      try {
        const data = await loginApi(this.memberId, this.password);

        // Save token & user from backend response
        localStorage.setItem("token", data.user.token);
        localStorage.setItem("user", JSON.stringify(data.user));

        // Redirect after login
        this.$router.push("/dashboard");

      } catch (err) {
        this.error = err.message || "Invalid Member ID or Password";
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>


<style scoped>
:root {
  --color-primary: #0049AF;
  --color-secondary: #BAD6EB;
  --color-bg: #FFFFFF;
}

.login-container {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: var(--color-bg);
}

.login-card {
  width: 320px;
  padding: 32px;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  text-align: center;
}

.login-card h2 {
  margin-bottom: 24px;
  color: var(--color-primary);
}

.login-card input {
  width: 100%;
  padding: 12px;
  margin-bottom: 16px;
  border-radius: 8px;
  border: none;
  background-color: var(--color-secondary);
  font-size: 14px;
  outline: none;
}

.login-card button {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: none;
  background-color: var(--color-primary);
  color: #fff;
  font-size: 15px;
  cursor: pointer;
}

.login-card button:hover {
  opacity: 0.9;
}

.error {
  margin-top: 12px;
  font-size: 13px;
  color: red;
}
</style>
