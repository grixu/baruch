<template>
    <Head title="Zaakceptuj zaproszenie" />

    <div class="mb-4 text-sm text-gray-600" data-testid="accept-invitation-info">
        Witaj, {{ name }}! Zostałeś zaproszony do zboru: {{ congregation }}
    </div>

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
      <div class="mt-4">
        <BreezeLabel for="password" value="Hasło" />
        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
      </div>

      <div class="mt-4">
        <BreezeLabel for="password_confirmation" value="Powtórz hasło" />
        <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
      </div>

        <div class="flex justify-end mt-4">
            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Potwierdź
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import GuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    layout: GuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
    },

    data() {
        return {
            form: this.$inertia.form({
                password: '',
              password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.confirm'), {
                onFinish: () => this.form.reset(),
            })
        }
    }
}
</script>
