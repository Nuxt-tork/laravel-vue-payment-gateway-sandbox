<template>
    <div class="p-4 max-w-md mx-auto bg-white shadow-md rounded">
      <h2 class="text-xl font-semibold mb-2">Hello, {{ userName || 'Guest' }} 👋</h2>
  
      <input
        v-model="userName"
        type="text"
        placeholder="Enter your name"
        class="border px-2 py-1 w-full mb-4 rounded"
      />
  
      <p v-if="showGreeting" class="text-green-600 mb-2">Welcome to the course!</p>
  
      <ul class="mb-4">
        <li
          v-for="(topic, index) in topics"
          :key="index"
          class="text-gray-700"
        >
          ✅ {{ topic }}
        </li>
      </ul>
  
      <button @click="toggleGreeting" class="bg-blue-500 text-white px-4 py-2 rounded">
        {{ showGreeting ? 'Hide' : 'Show' }} Greeting
      </button>
      <div>
            <button @click="checkout" class="bg-blue-500 text-white p-2 rounded">
            Checkout - ${{ coursePrice }}
            </button>
        </div>
      <p class="mt-4 text-sm text-gray-500">You have {{ topicCount }} topics to learn!</p>
    </div>
  </template>
  

<script setup>
import { ref, computed } from 'vue';

const userName = ref('');
const showGreeting = ref(true);

const topics = ref([
  'Vue Basics',
  'Props & Events',
  'Reactivity',
  'Directives',
  'Lifecycle Hooks',
]);

const toggleGreeting = () => {
  showGreeting.value = !showGreeting.value;
};

const topicCount = computed(() => topics.value.length);


const props = defineProps(['courseId', 'courseName', 'coursePrice']);

const checkout = async () => {
  const res = await fetch('/stripe/checkout-session', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      course_id: props.courseId,
      course_name: props.courseName,
      course_price: props.coursePrice
    })
  });

  const data = await res.json();

  console.log('data:', data);

  const stripe = Stripe('pk_test_51RMQEdQuxQRcfg4atAUBTZGAjBXyswKk2Pcw01vs9Q9M8bjE5TSnf2XQw7h5giTwKSu8EIgxU5SYrPfClAEavNoR00ULQEfsHo'); // Replace with production key in production
  
  stripe.redirectToCheckout({ sessionId: data.id });
};
</script>

<style scoped>
input:focus {
  outline: none;
  border-color: #60a5fa; /* Tailwind blue-400 */
}
</style>
