import {defineStore} from 'pinia';
import {useCookie} from '#app';

import type {FormRegister} from '@/types/auth/registerType';
import type {UserRegister, RegisterResponse} from '@/types/auth/responseRegister';

import type {FormLogin} from '@/types/auth/loginType';
import type {UserLogin, loginResponse} from '@/types/auth/responseLogin';

export const useAuthStore = defineStore('authStore', () => {
    let user = ref<UserLogin | UserRegister | null>(null);
    let token = ref<string |null>(null);

    const userCookie = ref( useCookie<UserLogin | UserRegister | null>('user', {maxAge:60*60**24*7}) ) // Tempo de duração do cookie é de 7 dias
    const tokenCookie = ref( useCookie<string |null>('token', {maxAge:60*60*24*7})) // Tempo de duração do cookie é de 7 dias

    const register = async (userRegister: FormRegister)=>{
        try {
            const response: RegisterResponse = await $fetch('http://localhost:8000/api/register', {
                method: 'POST',
                body: userRegister,
            })
            
            user.value = response.userRegistred;
            userCookie.value = response.userRegistred;
            
            console.log('User Register', user.value);
            console.log('User Cookie', userCookie.value);
        
        } catch(error){
            console.error(error);
        }
    }
    const login = async (userLogin: FormLogin) => {
        try{
            const response: loginResponse = await $fetch('http://localhost:8000/api/login', {
                method: 'POST',
                body: userLogin
            });

            user.value = response.user;
            token.value = response.token.plainTextToken;

            userCookie.value = response.user;
            tokenCookie.value = response.token.plainTextToken;

            console.log('User Login', user.value);
            console.log('Token Login', token.value);
            console.log('User Cookie Login', userCookie.value);
            console.log('Token Cookie Login', tokenCookie.value);
        } catch (error){

        }
    }

    const logout = async () => {
        try {
            console.log('Token usado no logout:', token.value);

            const response = await $fetch('http://localhost:8000/api/logout', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token.value}`
            }
            });

            console.log('Logout response:', response);

            // Sem isso o vue segue achando que o usuario segue logado ainda
            user.value = null;            // Limpa o estado reativo
            token.value = null;           // Limpa o token em memória
            userCookie.value = null;      // Limpa o cookie 'user'
            tokenCookie.value = null;     // Limpa o cookie 'token'
        } catch (error) {
            console.error('Erro no logout:', error);
        }
};



    return {
        user,
        userCookie,
        register,
        login,
        logout
    };
});
