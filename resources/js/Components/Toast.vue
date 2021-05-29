<template>
    <div
        v-if="toast && visible && !popstate"
        class="fixed flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-white rounded shadow-xl p-4 z-10 border-opacity-50 border"
        :class="isSuccess ? 'border-green-600' : 'border-red-600'"
    >
        <div class="mr-2">
            <svg
                v-if="isSuccess"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-green-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-red-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
        </div>
        <div
            class="flex-1"
            :class="isSuccess ? 'text-green-800' : 'text-red-600'"
        >
            {{ toast.message }}
        </div>
        <div class="ml-2">
            <button
                @click="visible = false"
                class="align-top text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        toast: Object,
        popstate: Boolean,
    },
    data() {
        return {
            isSuccess: true,
            visible: false,
            timeout: null,
        };
    },
    watch: {
        toast: {
            deep: true,
            immediate: true,
            handler(value) {
                if (!value) return;

                if (value?.isSuccess == false) this.isSuccess = false;

                this.visible = true;

                if (this.timeout) clearTimeout(this.timeout);

                this.timeout = setTimeout(() => (this.visible = false), 5000);
            },
        },
    },
};
</script>
