<script setup>
import SectionBorder from '@/Components/SectionBorder.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
})
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">Profile</h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm class="mt-10 sm:mt-0" :requires-confirmation="confirmsTwoFactorAuthentication" />

                    <SectionBorder />
                </div>

                <LogoutOtherBrowserSessionsForm class="mt-10 sm:mt-0" :sessions="sessions" />

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <SectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
