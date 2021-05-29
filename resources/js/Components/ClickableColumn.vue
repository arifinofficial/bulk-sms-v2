<template>
    <inertia-link
        v-if="meta.modal"
        @click.prevent="click(data)"
        :href="route(meta.route, data.id)"
        class="hover:text-blue-500 hover:underline"
    >
        {{ title }}
    </inertia-link>
    <inertia-link
        v-else
        :href="route(meta.route, data.id)"
        class="hover:text-blue-500 hover:underline"
    >
        {{ title }}
    </inertia-link>
</template>

<script>
export default {
    props: {
        data: {},
        meta: {},
        click: {
            type: Function,
            default: () => {},
        },
    },
    computed: {
        title() {
            return eval(`this.data.${this.meta.title}`);
        },
    },
};
</script>
