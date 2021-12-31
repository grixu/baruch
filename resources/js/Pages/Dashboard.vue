<template>
  <Head title="Dashboard"/>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- Replace with your content -->
    <div class="py-4">
      <h2>Witaj, {{ $page.props.auth.user.name }}</h2>
    </div>
    <!-- /End replace -->
  </div>
</template>

<script>
import AuthLayout from '@/Layouts/Auth.vue'
import {Head} from '@inertiajs/inertia-vue3';

export default {
  layout: AuthLayout,

  components: {
    Head,
  },
}
</script>
