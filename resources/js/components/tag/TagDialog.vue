<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { FunctionalComponent, ref } from 'vue';
import TagForm from './TagForm.vue';

interface Props {
    triggerText?: string
    triggerClass?: string
    dialogTitle: string
    dialogDescription?: string
    icon?: FunctionalComponent
    tag?: {
        id: number
        name: string
        color: string
        user_id: number
        created_at: string
        updated_at: string
    }
}

defineProps<Props>()

const open = ref(false)
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <template v-if="$slots.trigger">
                <slot name="trigger" />
            </template>
            <template v-else>
                <Button :class="triggerClass ?? ''">
                    <component :is="icon" v-if="icon" class="h-4 w-4 mr-1" />
                    {{ triggerText }}
                </Button>
            </template>
        </DialogTrigger>

        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>{{ dialogTitle }}</DialogTitle>
                <DialogDescription>
                    {{ dialogDescription }}
                </DialogDescription>
            </DialogHeader>
            <TagForm @success="open = false" :method="tag ? 'patch' : 'post'"
                :action="tag ? route('tags.update', tag.id) : route('tags.store')" :initial="tag ?? {}" />
        </DialogContent>
    </Dialog>
</template>