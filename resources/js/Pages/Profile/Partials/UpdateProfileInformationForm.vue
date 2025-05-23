<script setup>
import ActionMessage from '@/Components/ActionMessage.vue'
import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    user: Object,
})

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
})

const verificationLinkSent = ref(null)
const photoPreview = ref(null)
const photoInput = ref(null)

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0]
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    })
}

const sendEmailVerification = () => {
    verificationLinkSent.value = true
}

const selectNewPhoto = () => {
    photoInput.value.click()
}

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0]

    if (!photo) return

    const reader = new FileReader()

    reader.onload = (e) => {
        photoPreview.value = e.target.result
    }

    reader.readAsDataURL(photo)
}

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null
            clearPhotoFileInput()
        },
    })
}

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null
    }
}
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title> Profile Information </template>

        <template #description> Update your account's profile information and email address. </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input id="photo" ref="photoInput" class="hidden" type="file" @change="updatePhotoPreview" />

                <InputLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img class="size-20 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name" />
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block size-20 rounded-full bg-cover bg-center bg-no-repeat"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <SecondaryButton class="me-2 mt-2" type="button" @click.prevent="selectNewPhoto"> Select A New Photo </SecondaryButton>

                <SecondaryButton v-if="user.profile_photo_path" class="mt-2" type="button" @click.prevent="deletePhoto">
                    Remove Photo
                </SecondaryButton>

                <InputError class="mt-2" :message="form.errors.photo" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" class="mt-1 block w-full" type="text" required autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" class="mt-1 block w-full" type="email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="mt-2 text-sm dark:text-white">
                        Your email address is unverified.

                        <Link
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <ActionMessage class="me-3" :on="form.recentlySuccessful"> Saved. </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </PrimaryButton>
        </template>
    </FormSection>
</template>
