<script setup lang="ts">
import type { FormLogin } from '@/types/auth/loginType';

import { useAuthStore } from '@/stores/auth/authStore';
const authStoreInstance = useAuthStore();

const userFormLogin = reactive<FormLogin>({
  email: '',
  password: ''
});

const submitLogin = async () => {
  await authStoreInstance.login(userFormLogin);

  userFormLogin.email = '';
  userFormLogin.password = '';
}

const userLogin = async () => {
  await authStoreInstance.login(userFormLogin);
}
</script>

<template>
    <div>
        <section class="form-container">
            <form @submit.prevent="submitLogin">
                <div class="form-inputs">
                    <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email"
                    v-model="userFormLogin.email"/>
                </div>

                <div class="form-inputs">
                    <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    v-model="userFormLogin.password"/>
                </div>
                <button type="submit">Login</button>
            </form>
        </section>
        <button @click="authStoreInstance.logout" type="button"> Logout</button>
    </div>
</template>

<style scoped>
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    @layer components {
  .form-container {
    @apply 
    h-full 
    flex flex-col items-center justify-center;
  }

  form {
    @apply 
    bg-slate-700 
    h-64 flex 
    flex-col items-start justify-between 
    px-10 py-3 
    rounded-md;
  }

  .form-inputs {
    @apply flex flex-col;
  }

  .form-inputs>label {
    @apply text-white text-lg font-semibold;
  }

  .form-inputs>input {
    @apply 
    w-64 
    bg-slate-600 
    p-1 
    outline-none 
    rounded-md 
    mt-1;
  }

  form>button {
    @apply 
    bg-blue-700 
    px-16 py-1 
    rounded-md 
    font-semibold text-white text-lg;
  }
}

@layer utilities {
  .form-inputs>input {
    @apply placeholder:text-gray-400;
  }
}

</style>