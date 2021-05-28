<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Broadcast Manager
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="store">
                    <template #title> Create Broadcast </template>

                    <template #description>
                        If Your message contains Unicode or special character,
                        it may not be supported by Operator(s). We recommend you
                        to do test by sending SMS to your own MSISDN for each
                        destination Operator, to make sure the operator can
                        support the Unicode/Special Character that you used in
                        your Message.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="group" value="Select Group" />
                            <select
                                name="group"
                                id="group"
                                v-model="form.group_id"
                                @change="handlerChangeGroup($event)"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            >
                                <option
                                    v-for="group in data.groups"
                                    :key="group.value"
                                    v-bind:value="group.value"
                                >
                                    {{ group.text }}
                                </option>
                            </select>
                            <jet-input-error
                                :message="form.errors.group_id"
                                class="mt-2"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="sms" value="Text" />
                            <textarea
                                name="sms_text"
                                id="sms"
                                cols="30"
                                rows="5"
                                v-model="form.sms_text"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            ></textarea>
                            <jet-input-error
                                :message="form.errors.sms_text"
                                class="mt-2"
                            />
                        </div>
                        <div
                            class="col-span-6 sm:col-span-2"
                            v-if="data.meta.length > 0"
                        >
                            <jet-label
                                for="available_variable"
                                value="Available Variable"
                            />
                            <div class="mt-1 block w-full">
                                <span
                                    v-for="(meta, i) in data.meta"
                                    :key="i"
                                    @click="handlerClickMeta(meta)"
                                    class="text-xs px-3 bg-indigo-200 text-indigo-800 rounded-full cursor-pointer mr-2"
                                >
                                    [{{ meta }}]
                                </span>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="" value="Broadcast Type" />
                            <input
                                type="radio"
                                id="now"
                                value="NOW"
                                v-model="form.broadcast_type"
                                @change="() => (form.schedule_time = null)"
                            />
                            <jet-label
                                for="now"
                                value="Now"
                                class="inline-block align-bottom ml-1"
                            />

                            <input
                                type="radio"
                                id="schedule"
                                value="SCHEDULE"
                                v-model="form.broadcast_type"
                                class="ml-4"
                            />
                            <jet-label
                                for="schedule"
                                value="Schedule"
                                class="inline-block align-bottom ml-1"
                            />
                            <jet-input-error
                                :message="form.errors.broadcast_type"
                                class="mt-2"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4" v-if="form.broadcast_type === 'SCHEDULE'">
                            <jet-label for="schedule_time" value="Date Time" />
                            <datetime
                                v-model="form.schedule_time"
                                id="schedule_time"
                                :min-datetime="minDate"
                                type="datetime"
                                input-class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            ></datetime>
                            <jet-input-error
                                :message="form.errors.schedule_time"
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
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import { Datetime } from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";

export default {
    components: {
        AppLayout,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        Datetime,
    },
    props: ["groups", "broadcastTypes"],
    data() {
        return {
            form: this.$inertia.form({
                group_id: "",
                group_title: "",
                sms_text: "",
                broadcast_type: "NOW",
                schedule_time: null,
            }),
            data: {
                groups: [],
                meta: [],
            },
        };
    },
    created() {
        this.groups.forEach((val) => {
            this.data.groups.push({
                value: val.id,
                text: val.title,
            });
        });
    },
    methods: {
        store() {
            this.form.post(route("broadcast-manager.store"), {
                preserveScroll: true,
            });
        },
        handlerChangeGroup($event) {
            let groupFilter = this.groups.find(
                (val) => val.id == $event.target.value
            );

            this.form.group_title = groupFilter.title;
            this.data.meta = groupFilter.meta;
            this.form.sms_text = "";
        },
        handlerClickMeta(meta) {
            this.form.sms_text += `[${meta}]`;
        },
    },
    computed: {
        minDate() {
            var d = new Date(),
                month = "" + (d.getMonth() + 1),
                day = "" + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = "0" + month;
            if (day.length < 2) day = "0" + day;

            return [year, month, day].join("-");
        },
    },
};
</script>
