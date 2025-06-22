<script setup lang="ts">
const emit = defineEmits<{
    (e: 'success'): void
}>()

import { useForm } from 'laravel-precognition-vue-inertia'
import { Button } from '@/components/ui/button'
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from '@/components/ui/form'
import { Textarea } from '@/components/ui/textarea'
import { Input } from '@/components/ui/input'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { toast } from 'vue-sonner'

const props = defineProps<{
    method: 'post' | 'patch'
    action: string
    initial: {
        title?: string
        description?: string | null
        due_date?: string
        priority?: string
    }
}>()

function formatDateForInput(iso: string): string {
    return iso.split('T')[0]
}

const form = useForm(props.method, props.action, {
    title: props.initial.title || '',
    description: props.initial.description || '',
    due_date: props.initial.due_date ? formatDateForInput(props.initial.due_date) : '',
    priority: props.initial.priority || '',
})

function onSubmit() {
    form.submit({
        preserveScroll: true,
        onError: () => {
            toast.error('Por favor, corrija os erros antes de enviar.', { position: 'top-center' })
        },
        onSuccess: () => {
            emit('success')
            toast.success(
                props.method === 'post'
                    ? 'Tarefa criada com sucesso!'
                    : 'Tarefa atualizada com sucesso!',
                { position: 'top-center' }
            )
        },
    })
}

</script>
<template>
    <Form @submit="onSubmit" class="space-y-4" :initial-values="form">
        <FormField name="title" v-slot="{ componentField }">
            <FormItem>
                <FormLabel :data-error="form.invalid('title')">Title</FormLabel>
                <FormControl>
                    <Input v-model="form.title" :aria-invalid="form.invalid('title')" v-bind="componentField" />
                </FormControl>
                <div class="text-destructive-foreground text-sm" v-if="form.invalid('title')">
                    {{ form.errors.title }}
                </div>
            </FormItem>
        </FormField>
        <FormField name="description" v-slot="{ componentField }">
            <FormItem>
                <FormLabel :data-error="form.invalid('description')">Description</FormLabel>
                <FormControl>
                    <Textarea v-model="form.description" :aria-invalid="form.invalid('description')"
                        v-bind="componentField" />
                </FormControl>
                <div class="text-destructive-foreground text-sm" v-if="form.invalid('description')">
                    {{ form.errors.description }}
                </div>
            </FormItem>
        </FormField>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <FormField name="due_date" v-slot="{ componentField }">
                    <FormItem>
                        <FormLabel :data-error="form.invalid('due_date')">Due Date</FormLabel>
                        <FormControl>
                            <Input type="date" v-model="form.due_date" :aria-invalid="form.invalid('due_date')"
                                v-bind="componentField" />
                        </FormControl>
                        <div class="text-destructive-foreground text-sm" v-if="form.invalid('due_date')">
                            {{ form.errors.due_date }}
                        </div>
                    </FormItem>
                </FormField>
            </div>
            <div>
                <FormField name="priority" v-slot="{ componentField }">
                    <FormItem>
                        <FormLabel :data-error="form.invalid('priority')">Priority</FormLabel>
                        <FormControl>
                            <Select v-model="form.priority" v-bind="componentField">
                                <SelectTrigger class="w-full" :aria-invalid="form.invalid('priority')">
                                    <SelectValue placeholder="Select a priority" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem value="low">Low</SelectItem>
                                        <SelectItem value="medium">Medium</SelectItem>
                                        <SelectItem value="high">High</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <div class="text-destructive-foreground text-sm" v-if="form.invalid('priority')">
                            {{ form.errors.priority }}
                        </div>
                    </FormItem>
                </FormField>
            </div>
        </div>
        <Button type="submit" :disabled="form.processing">
            {{ form.processing ? (props.method === 'post' ? 'Creating...' : 'Saving...') :
                (props.method === 'post' ? 'Create Task' : 'Update Task') }}
        </Button>
    </Form>
</template>