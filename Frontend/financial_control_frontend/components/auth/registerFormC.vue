<script setup lang="ts">
    import type {FormRegister} from '@/types/auth/registerType';

    import {useAuthStore} from '@/stores/auth/authStore';
    const authStoreInstance = useAuthStore(); // Passando essa constante ela já tem acesso aos Get e Settrs que colocamos
    const userFormRegister = reactive<FormRegister>({ 
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    });

    // Metodo de submissão
    const submitRegister = async () => {
        await authStoreInstance.register(userFormRegister);

        // Limpar o formulario
        userFormRegister.name = '';
        userFormRegister.email= '';
        userFormRegister.password= '';
        userFormRegister.password_confirmation= '';
    }
</script>

<template>
    <div>
        <section class="form-container">
            <form @submit.prevent="submitRegister">

                <div class="form-inputs">
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Register Name"
                        v-model="userFormRegister.name"
                    />
                </div>

                <div class="form-inputs">
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Register Email"
                        v-model="userFormRegister.email"
                    />
                </div>

                <div class="form-inputs">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Register Password"
                        v-model="userFormRegister.password"
                    />
                </div>

                <div class="form-inputs">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="Password Confirmation"
                        v-model="userFormRegister.password_confirmation"
                    />
                </div>
                
                <button type="submit">
                    Register
                </button>
            </form>
        </section>
    </div>
</template>


<style scoped>
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    @layer components{
        .form-container{
            @apply
            h-full
            flex flex-col items-center justify-between;
            ;
        }
        form{
            @apply
            bg-slate-700
            rounded-md
            h-[20rem]
            flex flex-col items-center justify-between
            px-10 py-3;
        }
        .form-inputs{
            @apply
            flex flex-col;
        }
        .form-inputs > input {
            @apply
            w-64
            bg-slate-600
            p-1
            outline-none
            rounded-md
            mt-1;
        }
        .form > button{
            @apply
            bg-blue-700
            px-16
            py-1
            rounded-md
            font-semibold
            text-white
            text-lg;
        }
    };
    @layer utilities {
        .form-inputs > input {
            @apply placeholder:text-gray-400;
        }
    }
</style>