<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="store">
                    <template #title> Create Group Management </template>

                    <template #description>
                        Create a management group to group member lists with xlsx,
                        xlx, or csv files.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="title" value="Title" />
                            <jet-input
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                autofocus
                            />
                            <jet-input-error
                                :message="form.errors.title"
                                class="mt-2"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="file" value="File" />
                            <input id="file" type="file" class="mt-1 block w-full" ref="file" @change="changeFile">
                            <jet-input-error
                                :message="form.errors.file"
                                class="mt-2"
                            />
                        </div>
                    </template>

                    <template #actions>
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Create
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";

export default {
    components: {
        AppLayout,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: "",
                file: null,
            }),
        };
    },
    methods: {
        store(){
            this.form.post(route('group-management.store'), {
                preserveScroll: true,

            })
        },
        changeFile() {
            console.log(this.$refs.file.files[0]);
            this.form.file = this.$refs.file.files[0];
        }
    }
};
</script>
