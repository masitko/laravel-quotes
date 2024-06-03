<script setup lang="ts">

import { ref } from 'vue'
import { object, string } from 'zod';
import { useForm } from "vee-validate";
import { toTypedSchema } from '@vee-validate/zod';
import { useAuthService } from '@/services/auth.service';
import { useRouter } from 'vue-router'


const { errors, handleSubmit, defineField } = useForm({
  validationSchema: toTypedSchema(
    object({
      email: string(),
      password: string(),
    })
  )
});

const [email, emailAttrs] = defineField('email');
const [password, passwordAttrs] = defineField('password');

const loading = ref(false);
const message = ref('');
const router = useRouter();
const authService = useAuthService();

if (authService.isLoggedIn()) {
  router.push({ name: 'quotes' });
}

const onSubmit = handleSubmit(user => {
  console.log('onSumbit', user)
  loading.value = true;
  const credencials: ICredentials = {
    email: user.email,
    password: user.password
  };

  authService.login(credencials)
    .then((response) => {
      console.log(response);
      loading.value = false;
      if (response?.error) {
        message.value = response.error;
      } else {
        router.push("/");
      }
    }
    );
});

</script>

<template>
  <div class="flex flex-col justify-center font-[sans-serif] text-[#333] sm:h-full p-4">
    <div class="max-w-md w-full mx-auto border border-gray-300 rounded-md p-6">
      <div class="text-center mb-12">
        <h1 class="text-2xl font-semibold">Login</h1>
      </div>
      <form @submit="onSubmit">
        <div class="space-y-6">
          <div>
            <label class="text-sm mb-2 block">Email</label>
            <input v-model="email" v-bind="emailAttrs" name="email" type="text"
              class="bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="Enter email" />
            <div class="text-red-500 text-xs italic">{{ errors.email }}</div>
          </div>
          <div>
            <label class="text-sm mb-2 block">Password</label>
            <input v-model="password" v-bind="passwordAttrs" name="password" type="password"
              class="bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="Enter password" />
            <div class="text-red-500 text-xs italic">{{ errors.password }}</div>
          </div>
        </div>
        <div class="!mt-10">
          <button type="submit" :disabled="loading"
            class="w-full py-3 px-4 text-sm font-semibold rounded text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
            Submit
          </button>
        </div>
        <p class="text-sm mt-6 text-center">Don't have an account?
          <RouterLink class="text-blue-600 font-semibold hover:underline ml-1" :to="{ name: 'register' }">Register here</RouterLink>
        </p>
      </form>
      <div v-if="message" class="alert mt-5">
        {{ message }}
      </div>

    </div>
  </div>
</template>