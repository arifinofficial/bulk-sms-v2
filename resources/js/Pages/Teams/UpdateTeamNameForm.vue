<template>
    <jet-form-section @submitted="updateTeamName">
        <template #title> Organization Core Setting </template>

        <template #description>
            The organization's information and SMS API credential.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <jet-label value="Organization Owner" />

                <div class="flex items-center mt-2">
                    <img
                        class="w-12 h-12 rounded-full object-cover"
                        :src="team.owner.profile_photo_url"
                        :alt="team.owner.name"
                    />

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Organization Name" />

                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    :disabled="!permissions.canUpdateTeam"
                />

                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="msisdn_sender" value="Msisdn Sender" />

                <jet-input
                    id="msisdn_sender"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.msisdn_sender"
                    :disabled="!permissions.canUpdateTeam"
                />

                <jet-input-error
                    :message="form.errors.msisdn_sender"
                    class="mt-2"
                />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="api_username" value="API Username" />

                <jet-input
                    id="api_username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.api_username"
                    :disabled="!permissions.canUpdateTeam"
                />

                <jet-input-error
                    :message="form.errors.api_username"
                    class="mt-2"
                />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="api_password" value="API Password" />

                <jet-input
                    id="api_password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.api_password"
                    :disabled="!permissions.canUpdateTeam"
                />

                <jet-input-error
                    :message="form.errors.api_password"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    props: ["team", "permissions"],

    data() {
        return {
            form: this.$inertia.form({
                name: this.team.name,
                api_username: this.team.api_username,
                api_password: this.team.api_password,
                msisdn_sender: this.team.msisdn_sender,
            }),
        };
    },

    methods: {
        updateTeamName() {
            this.form.put(route("teams.update", this.team), {
                errorBag: "updateTeamName",
                preserveScroll: true,
            });
        },
    },
};
</script>
