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
import { type PropType, defineProps } from 'vue'

const props = defineProps({
    triggerText: { type: String, default: 'Add Task' },
    triggerClass: { type: String, default: 'absolute right-4 top-4' },
    dialogTitle: { type: String, default: 'Add Task' },
    dialogDescription: { type: String, default: 'Just an example.' },
})
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button :class="triggerClass">
                {{ triggerText }}
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ dialogTitle }}</DialogTitle>
                <DialogDescription>
                    {{ dialogDescription }}
                </DialogDescription>
            </DialogHeader>

            <p>Conteúdo do form aqui</p>

            <DialogFooter>
                <Button type="submit" form="dialogForm">
                    Save changes
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
