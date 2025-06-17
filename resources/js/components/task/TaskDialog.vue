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

import { ref } from 'vue';
import TaskForm from './TaskForm.vue';


/** Props vindas do parent */
defineProps<{
    triggerText: string
    triggerClass: string
    dialogTitle: string
    dialogDescription: string
}>()

const open = ref(false)
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button :class="triggerClass">
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
