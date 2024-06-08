<script setup lang="ts">

import { ref } from 'vue';
import { object, string } from 'zod';
import { useForm } from "vee-validate";
import { toTypedSchema } from '@vee-validate/zod';
import { useAuthService } from '@/services/auth.service';

const { errors, handleSubmit, defineField } = useForm({
  validationSchema: toTypedSchema(
    object({
      name: string().min(5),
      email: string().email().min(5),
      password: string().min(5),
      cpassword: string().min(5),
    }).refine((data) => data.password === data.cpassword, {
      message: 'Passwords do not match',
      path: ['cpassword']
    })
  )
});

const [name, nameAttrs] = defineField('name');
const [email, emailAttrs] = defineField('email');
const [password, passwordAttrs] = defineField('password');
const [cpassword, cpasswordAttrs] = defineField('cpassword');

const loading = ref(false);
const successful = ref(false);
const message = ref('');
const authService = useAuthService();

const onSubmit = handleSubmit(user => {
  message.value = "";
  successful.value = false;
  loading.value = true;

  authService.register({
    name: user.name,
    email: user.email,
    password: user.password,
  })
    .then(data => {
      console.log(data);
      message.value = data?.message || 'Registration Successful!';
      successful.value = !data.errors;
      loading.value = false;
    })
    .catch(error => {
      message.value = error.message || error.toString();
      successful.value = false;
      loading.value = false;
    }
    );
});

</script>

<template>
  <div class="flex flex-col justify-center font-[sans-serif] text-[#333] sm:h-full p-4">
    <div class="max-w-md w-full mx-auto border border-gray-300 rounded-md p-6">
      <div class="text-center mb-12">
        <h1 class="text-2xl font-semibold">Create an account</h1>
      </div>
      <form @submit="onSubmit" v-if="!successful">
        <div class="space-y-6">
          <div>
            <label class="text-sm mb-2 block">Name</label>
            <input v-model="name" v-bind="nameAttrs" name="name" type="text"
              class="bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500" placeholder="Enter your name" />
            <div class="text-red-500 text-xs italic">{{ errors.name }}</div>
          </div>
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
          <div>
            <label class="text-sm mb-2 block">Confirm Password</label>
            <input v-model="cpassword" v-bind="cpasswordAttrs" name="cpassword" type="password"
              class="bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500"
              placeholder="Enter confirm password" />
            <div class="text-red-500 text-xs italic">{{ errors.cpassword }}</div>
          </div>
        </div>
        <div class="!mt-10">
          <button type="submit" :disabled="loading"
            class="w-full py-3 px-4 text-sm font-semibold rounded text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
            Create an account
          </button>
        </div>
        <p class="text-sm mt-6 text-center">Already have an account?
          <RouterLink class="text-blue-600 font-semibold hover:underline ml-1" :to="{ name: 'login' }">Login here</RouterLink>
        </p>
      </form>
      <div v-if="message" class="alert mt-5" :class="successful ? 'alert-success' : 'alert-danger'">
        {{ message }}
      </div>
      <div v-if="successful" class="mt-5">
        Would you like to <RouterLink :to="{ name: 'login' }" class="text-blue-600 font-semibold hover:underline ml-1">Login</RouterLink> ?
      </div>
    </div>
  </div>
</template>