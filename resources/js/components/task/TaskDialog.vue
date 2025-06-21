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

import { Plus } from 'lucide-vue-next'

import { FunctionalComponent, ref } from 'vue';
import TaskForm from './TaskForm.vue';


/** Props vindas do parent */
defineProps<{
    triggerText: string
    triggerClass?: string | undefined
    dialogTitle: string
    dialogDescription: string
    icon?: FunctionalComponent
}>()

const open = ref(false)
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button :class="triggerClass">
                <component :is="icon" v-if="icon" class="h-4 w-4" />
                {{ triggerText }}
            </Button>
        </DialogTrigger>

        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>{{ dialogTitle }}</DialogTitle>
                <DialogDescription>
                    {{ dialogDescription }}
                </DialogDescription>
                <TaskForm @success="open = false" />
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>
