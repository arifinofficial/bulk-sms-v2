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
                    <div class="text-right">
                        <inertia-link :href="route('group-management.create')">
                            <jet-button> Create </jet-button>
                        </inertia-link>

                        <!-- <data-table
                            :columns="columns"
                            order-dir="desc"
                            framework="tailwind"
                            ref="datatable"
                        >
                        </data-table> -->
                    </div>
                </div>
            </div>
            <test />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
// import DataTable from 'laravel-vue-datatable';

export default {
    components: {
        AppLayout,
        JetButton,
        // DataTable
    },
};
</script>
