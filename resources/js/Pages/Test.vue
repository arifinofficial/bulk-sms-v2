<template>
    <div>
        <jet-form-section @submitted="store">
            <template #title> Update Password </template>

            <template #description>
                Ensure your account is using a long, random password to stay
                secure.
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Name" />
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <input type="file"
                            ref="file"
                            @change="fileChange">
                </div>
            </template>

            <template #actions>
                <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Save
                </jet-button>
            </template>
        </jet-form-section>
    </div>
</template>

<script>
import JetFormSection from "@/Jetstream/FormSection";
import JetButton from "@/Jetstream/Button";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetInput from '@/Jetstream/Input'

export default {
    components: {
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data(){
        return {
            form: this.$inertia.form({
                name: '',
                file: null
            }),
        }
    },
    methods: {
        store(){
            this.form.post(route('test.store'), {
                preserveScroll: true,
                onSuccess: () => console.log('Halo'),
            })
        },
        fileChange(){
            this.form.file = this.$refs.file.files[0]
        }
    }
};
</script>
