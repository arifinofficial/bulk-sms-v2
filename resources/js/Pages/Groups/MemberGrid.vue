<template>
    <div>
        <data-table
            :columns="columns"
            order-dir="desc"
            framework="tailwind"
            :url="gridUrl"
            ref="datatable"
        />
    </div>
</template>

<script>
export default {
    props: ["groupId", "meta"],
    data() {
        return {
            columns: [],
        };
    },
    created() {
        this.meta.forEach((value) => {
            this.columns.push({
                label: value.toUpperCase(),
                name: value === 'msisdn' ? value : `attribute.${value}`,
                orderable: value === 'msisdn' ? true : false,
            });
        });
    },
    computed: {
        gridUrl() {
            return `/data-grid/member/${this.groupId}`;
        },
    },
};
</script>
