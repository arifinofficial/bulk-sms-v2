<template>
    <inertia-link :href="route(meta.route, data.id)" class="hover:text-blue-500 hover:underline">
        {{ title }}
    </inertia-link>
</template>

<script>
export default {
    props: {
        data: {},
        meta: {}
    },
    computed: {
        title(){
            return eval(`this.data.${this.meta.title}`);
        }
    }
}
</script>
