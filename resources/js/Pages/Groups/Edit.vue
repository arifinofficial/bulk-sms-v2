<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="update">
                    <template #title> Edit Group Management </template>

                    <template #description> Edit a group management. </template>

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
                    </template>

                    <template #actions>
                        <inertia-link
                            :href="route('group-management.index')"
                            class="mr-4"
                        >
                            <jet-secondary-button> Close </jet-secondary-button>
                        </inertia-link>

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Update
                        </jet-button>
                    </template>
                </jet-form-section>
                <h3 class="text-lg font-medium text-gray-900 mt-16">Member</h3>
                <p class="mt-1 text-sm text-gray-600 mb-6">Member list of an {{ groupModel.title }} group.</p>
                <div class="p-6 sm:px-10 bg-white shadow-xl sm:rounded-tl-md sm:rounded-tr-md">
                    <member-grid :groupId="groupModel.id" :meta="groupModel.meta" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import MemberGrid from "./MemberGrid";

export default {
    components: {
        AppLayout,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        MemberGrid,
    },
    props: ["groupModel"],
    data() {
        return {
            form: this.$inertia.form({
                title: "",
            }),
        };
    },
    created() {
        this.form.title = this.groupModel.title;
    },
    methods: {
        update() {
            this.form.put(
                route("group-management.update", this.groupModel.id),
                {
                    preserveScroll: true,
                }
            );
        },
    },
};
</script>
