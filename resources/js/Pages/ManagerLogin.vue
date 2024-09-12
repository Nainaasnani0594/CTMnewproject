<template>
    <div>
      <h1>Manager Login</h1>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input v-model="form.email" type="email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input v-model="form.password" type="password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <div v-if="errors">
        <p v-for="error in errors" :key="error">{{ error }}</p>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/inertia-vue3';
  
  export default {
    setup() {
      const { data, setData, post, errors } = useForm({
        email: '',
        password: '',
      });
  
      const form = ref(data);
  
      const login = () => {
        post('/manager-login', form.value);
      };
  
      return { form, login, errors };
    },
  };
  </script>
  