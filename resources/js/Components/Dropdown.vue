<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'py-1',
    },
    trigger: {
        type: String,
        default: 'click', // 'click' or 'hover'
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        '48': 'w-48',
        '56': 'w-56',
        '64': 'w-64',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'origin-top-left left-0';
    } else if (props.align === 'right') {
        return 'origin-top-right right-0';
    } else {
        return 'origin-top';
    }
});

const open = ref(false);

const mouseEnter = () => {
    if (props.trigger === 'hover') {
        open.value = true;
    }
};

const mouseLeave = () => {
    if (props.trigger === 'hover') {
        open.value = false;
    }
};
</script>

<template>
    <div class="relative" @mouseenter="mouseEnter" @mouseleave="mouseLeave">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay (Click Mode Only) -->
        <div v-show="open && trigger === 'click'" class="fixed inset-0 z-40" @click="open = false"></div>

        <transition enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95 translate-y-2"
            enter-to-class="transform opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="transform opacity-100 scale-100 translate-y-0"
            leave-to-class="transform opacity-0 scale-95 translate-y-2">
            <div v-show="open"
                class="absolute z-50 mt-2 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/40 bg-white/95 backdrop-blur-xl ring-1 ring-black ring-opacity-5 overflow-hidden transform origin-top"
                :class="[widthClass, alignmentClasses]">
                <div class="py-1" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>
