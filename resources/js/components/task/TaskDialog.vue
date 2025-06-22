<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'

import { FunctionalComponent, ref } from 'vue';
import TaskForm from './TaskForm.vue';


/** Props vindas do parent */
defineProps<{
    triggerText?: string
    triggerClass?: string
    dialogTitle: string
    dialogDescription: string
    icon?: FunctionalComponent
    task?: {
        id: number
        title: string
        description: string | null
        due_date: string
        priority: 'low' | 'medium' | 'high'
    }
}>()


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
                <TaskForm @success="open = false" :method="task ? 'patch' : 'post'"
                    :action="task ? route('tasks.update', task.id) : route('tasks.store')" :initial="task ?? {}" />
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>
