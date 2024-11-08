<script setup lang="js">
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'text',
        validator: (value) => ['text', 'email', 'password'].includes(value)
    },
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false
    },
    error: {
        type: String,
        default: ''
    },
    showErrorMessage:{
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue'])

const errorMessage = computed(() => props.error)
</script>

<template>
    <div class="flex flex-col w-full gap-2">
        <label
            :class="`input input-bordered flex items-center gap-2 ${
                errorMessage && 'input-error'
            }`"
        >
            <i v-if="icon" :class="`pi ${icon}`"></i>
            <input
                class="grow border-none focus:ring-0"
                :type="type"
                :placeholder="placeholder"
                :value="modelValue"
                :required="required"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </label>
        <span
            v-if="errorMessage && showErrorMessage"
            class="text-error text-xs pl-4"
            >{{ errorMessage }}</span
        >
    </div>
</template>
