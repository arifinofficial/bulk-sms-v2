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
                        <jet-button class="text-xs capitalize" @click.native="reloadGrid">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="ml-2">Refresh</span>
                        </jet-button>
                    </div>
                    <data-table
                        :columns="columns"
                        order-dir="desc"
                        framework="tailwind"
                        url="/data-grid/broadcast-history"
                        ref="datatable"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import ClickableColumn from '@/Components/ClickableColumn';

export default {
    components: {
        AppLayout,
        JetButton,
        ClickableColumn
    },
    data(){
        return {
            columns: [
                {
                    label: "Group Title",
                    name: "group_title",
                    orderable: true,
                    component: ClickableColumn,
                    meta: {
                        route: 'broadcast-history.show',
                        title: 'group_title',
                    }
                },
                {
                    label: "Broadcast Type",
                    name: "broadcast_type",
                    orderable: false,
                    transform: (value) => {
                        let str = value.data.broadcast_type.toLowerCase();
                        return str.replace(/^./, str[0].toUpperCase());
                    }
                },
                {
                    label: "Status",
                    name: "status",
                    orderable: true,
                    transform: (value) => {
                        let str = value.data.status.toLowerCase();
                        return str.replace(/^./, str[0].toUpperCase());
                    }
                },
                {
                    label: "Created At",
                    name: "created_at",
                    orderable: true,
                    width: 20,
                    transform: (value) => new Date(value.data.updated_at).toLocaleString()
                },
                {
                    label: "Updated At",
                    name: "updated_at",
                    orderable: true,
                    width: 20,
                    transform: (value) => new Date(value.data.updated_at).toLocaleString()
                }
            ]
        }
    },
    methods: {
        reloadGrid(){
            this.$refs.datatable.getData();
        }
    }
};
</script>
