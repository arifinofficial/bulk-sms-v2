<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Group Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="text-right mb-4">
                        <inertia-link :href="route('group-management.create')">
                            <jet-button> Create </jet-button>
                        </inertia-link>
                    </div>
                    <data-table
                        :columns="columns"
                        order-dir="desc"
                        framework="tailwind"
                        url="/data-grid/group-management"
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
                    name: "title",
                    orderable: true,
                    component: ClickableColumn,
                    meta: {
                        route: 'group-management.edit',
                        title: 'title',
                    }
                },
                {
                    label: "Created At",
                    name: "created_at",
                    orderable: true,
                    width: 30,
                    transform: (value) => new Date(value.data.updated_at).toLocaleString()
                },
                {
                    label: "Updated At",
                    name: "updated_at",
                    orderable: true,
                    width: 30,
                    transform: (value) => new Date(value.data.updated_at).toLocaleString()
                }
            ]
        }
    }
};
</script>
