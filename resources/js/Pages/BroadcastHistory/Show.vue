<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Broadcast History
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="text-right mb-4">
                        <jet-button
                            class="text-xs capitalize"
                            @click.native="reloadGrid"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                            <span class="ml-2">Refresh</span>
                        </jet-button>
                    </div>
                    <data-table
                        :columns="columns"
                        order-dir="desc"
                        framework="tailwind"
                        :url="gridUrl"
                        ref="datatable"
                    />
                </div>
            </div>
        </div>

        <div v-if="showModal">
            <jet-dialog-modal :show="showModal" @close="closeModal">
                <template #title>
                    <h2>Detail Broadcast History</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Msisdn" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.msisdn"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Broadcast ID" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.broadcast_id"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Session ID" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.session_id"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Key" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.key"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Status" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.status"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Response Code" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.response_code"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Response Code Desc." />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.response_code_display"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Final Response Code" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.final_response_code"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Final Response Code Desc." />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="
                                    selectedData.final_response_code_display
                                "
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Operator SMSC ACK" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.operator_smsc_ack"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Operator DLR" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.operator_dlr"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <jet-label value="Billable" />
                            <jet-input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="selectedData.billable"
                                disabled
                            />
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <jet-label value="SMS Text" />
                            <textarea
                                cols="30"
                                rows="3"
                                v-model="selectedData.sms_text"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                disabled
                            ></textarea>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Close
                    </jet-secondary-button>
                </template>
            </jet-dialog-modal>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import ClickableColumn from "@/Components/ClickableColumn";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";

export default {
    components: {
        AppLayout,
        JetButton,
        ClickableColumn,
        JetDialogModal,
        JetSecondaryButton,
        JetLabel,
        JetInput,
    },
    props: ["id"],
    data() {
        return {
            columns: [
                {
                    label: "Msisdn",
                    name: "msisdn",
                    orderable: true,
                    component: ClickableColumn,
                    event: "click",
                    handler: this.handlerClick,
                    meta: {
                        route: "broadcast-history.show",
                        title: "msisdn",
                        modal: true,
                    },
                },
                {
                    label: "Status",
                    name: "status",
                    orderable: true,
                    transform: (value) => {
                        let str = value.data.status.toLowerCase();
                        return str.replace(/^./, str[0].toUpperCase());
                    },
                },
                {
                    label: "Response Code",
                    name: "response_code",
                    orderable: true,
                },
                {
                    label: "Billable",
                    name: "billable",
                    orderable: true,
                    transform: (value) => {
                        if (value.data.billable == null) return;

                        return value.data.billable ? "True" : "False";
                    },
                },
                {
                    label: "Created At",
                    name: "created_at",
                    orderable: true,
                    width: 20,
                    transform: (value) =>
                        new Date(value.data.updated_at).toLocaleString(),
                },
                {
                    label: "Updated At",
                    name: "updated_at",
                    orderable: true,
                    width: 20,
                    transform: (value) =>
                        new Date(value.data.updated_at).toLocaleString(),
                },
            ],
            showModal: false,
            selectedData: null,
        };
    },
    methods: {
        reloadGrid() {
            this.$refs.datatable.getData();
        },
        handlerClick(data) {
            this.showModal = true;
            this.selectedData = data;
        },
        closeModal(){
            let bodyElement = document.getElementById("body");
            bodyElement.style.overflow = null;
            this.showModal = false;
            this.selectedData = null;
        }
    },
    computed: {
        gridUrl() {
            return `/data-grid/broadcast-history-detail/${this.id}`;
        },
    },
};
</script>
