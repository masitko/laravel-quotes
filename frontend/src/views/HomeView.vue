<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useQuotesService } from '@/services/quotes.service';
import { useAuthService } from '@/services/auth.service';

import TheQuotes from '@/components/TheQuotes.vue';

const quotesService = useQuotesService();
const authService = useAuthService();
const quotes = ref([]);
const loading = ref(false);

onMounted(() => {
  console.log('HomeView mounted')
  loading.value = true;
  quotesService.getQuotes().then((response) => {
    console.log(response)
    quotes.value = response.quotes;
    loading.value = false;
  })
})

const refreshQuotes = () => {
  loading.value = true;
  quotesService.refreshQuotes().then((response) => {
    console.log(response)
    quotes.value = response.quotes;
    loading.value = false;
  })
}

</script>

<template>
  <main>
    <TheQuotes v-if="authService.isLoggedIn()" :quotes="quotes" @refresh-quotes="refreshQuotes()" />
    <div v-if="!authService.isLoggedIn()" class="mt-5 text-center ">
      <h3>You need to be logged in to see quotes!</h3>
      Would you like to <RouterLink :to="{ name: 'login' }" class="text-blue-600 font-semibold hover:underline ml-1">Login</RouterLink> ?
    </div>
  </main>
</template>
