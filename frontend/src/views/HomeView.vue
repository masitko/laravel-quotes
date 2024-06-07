<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useQuotesService } from '@/services/quotes.service';
import { useAuthService } from '@/services/auth.service';
import { useAvatarService } from '@/services/avatar.service';

import TheQuotes from '@/components/TheQuotes.vue';

const avatarService = useAvatarService();
const quotesService = useQuotesService();
const authService = useAuthService();
const quotes = ref<string[]>([]);
const loading = ref(false);
const avatarUrl = ref<string|null>(null);

onMounted(async () => {
  loading.value = true;
  avatarService.getAvatar().then((response) => {
    console.log(response)
    avatarUrl.value = response.avatarUrl;
  })
  const quotesResponse = await quotesService.getQuotes();
  console.log(quotesResponse)
  quotes.value = quotesResponse.quotes;
  loading.value = false;
});

const refreshQuotes = async () => {
  loading.value = true;
  const response = await quotesService.refreshQuotes();
  console.log(response)
  quotes.value = response.quotes;
  loading.value = false;
}

</script>

<template>
  <main>
    <TheQuotes v-if="authService.isLoggedIn()" :quotes="quotes" :avatarUrl="avatarUrl" @refresh-quotes="refreshQuotes()" />
    <div v-if="!authService.isLoggedIn()" class="mt-5 text-center ">
      <h3>You need to be logged in to see quotes!</h3>
      Would you like to <RouterLink :to="{ name: 'login' }" class="text-blue-600 font-semibold hover:underline ml-1">Login</RouterLink> ?
    </div>
  </main>
</template>
