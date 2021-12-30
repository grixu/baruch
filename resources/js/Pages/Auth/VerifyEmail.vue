<template>
    <Head title="Potwierdzenie adresu email" />

    <div class="mb-4 text-sm text-gray-600">
        Dziękujemy za rejestację! Zanim będziesz mógł przejść dalej, zajrzyj do maila którego Ci właśnie wysłaliśmy i prosimy kliknij w link w nim zamieszczony. Jeśli nie otrzymałeś maila, kliknij przycisk "Ponownie wyślij email weryfikacyjny".
    </div>

    <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
        Nowy link weryfikacyjny został wysłany na adres email podany w formularzu rejestracyjnym.
    </div>

    <form @submit.prevent="submit">
        <div class="mt-4 flex items-center justify-between">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Ponownie wyślij email weryfikacyjny
            </BreezeButton>

            <Link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Wyloguj się</Link>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        Head,
        Link,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
}
</script>
