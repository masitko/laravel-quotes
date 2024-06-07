<script setup lang="ts">
defineProps<{
  avatarUrl: string | null,
  quotes: Array<string>
}>()
</script>

<template>
  <div class="flex flex-col justify-center font-[sans-serif] text-[#333] sm:h-full p-4">
    <div class="max-w-md w-full mx-auto border border-gray-300 rounded-md p-6">
      <div class="text-center mb-12">
        <h1 class="text-2xl font-semibold">Kanye West Qoutes</h1>
        <img v-if="avatarUrl" :src="avatarUrl" alt="avatar" class="w-50 h-50 mx-auto rounded-full mt-4" />
      </div>
      <ul>
        <li class="text-center italic p-3" v-for="quote in quotes" :key="quote">"{{ quote }}"</li>
      </ul>
      <div class="!mt-10">
          <button @click="$emit('refreshQuotes')"
            class="w-full py-3 px-4 text-sm font-semibold rounded text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
            Refresh Quotes
          </button>
        </div>

    </div>
  </div>
</template>
