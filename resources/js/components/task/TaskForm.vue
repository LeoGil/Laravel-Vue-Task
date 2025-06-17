<script setup lang="ts">
import { useForm } from 'vee-validate'
import { Button } from '@/components/ui/button'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
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
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';
import { toast } from 'vue-sonner'

const formSchema = toTypedSchema(z.object({
    title: z.string().min(2).max(50),
    description: z.string().min(2).max(255),
    due_date: z.string(),
    priority: z.enum(['low', 'medium', 'high']),
}))

const { isFieldDirty, handleSubmit } = useForm({
    validationSchema: formSchema,
})

const open = ref(false)

const onSubmit = handleSubmit((values) => {
    router.post(route('tasks.store'), {
        ...values,
    }, {
        onSuccess: () => {
            open.value = false
            toast.success('Task ' + values.title + ' created successfully!', {
                position: 'top-center'
            })
        },
        onError: () => {
            toast.error('Something went wrong!', {
                position: 'top-center',
                description: 'Please try again.'
            })
        }
    })
})
</script>
<template>
    <form @submit="onSubmit" class="space-y-4">
        <FormField v-slot="{ componentField }" name="title" :validate-on-blur="!isFieldDirty">
            <FormItem>
                <FormLabel>Title</FormLabel>
                <FormControl>
                    <Input type="text" v-bind="componentField" />
                </FormControl>
                <FormMessage />
            </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="description" :validate-on-blur="!isFieldDirty">
            <FormItem>
                <FormLabel>Description</FormLabel>
                <FormControl>
                    <Textarea type="text" v-bind="componentField" />
                </FormControl>
                <FormMessage />
            </FormItem>
        </FormField>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <FormField v-slot="{ componentField }" name="due_date" :validate-on-blur="!isFieldDirty">
                    <FormItem>
                        <FormLabel>Due Date</FormLabel>
                        <FormControl>
                            <Input type="date" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
            <div>
                <FormField v-slot="{ componentField }" name="priority" :validate-on-blur="!isFieldDirty">
                    <FormItem>
                        <FormLabel>Priority</FormLabel>
                        <FormControl>
                            <Select id="priority" v-bind="componentField">
                                <SelectTrigger class="w-full">
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
                        <FormMessage />
                    </FormItem>
                </FormField>
            </div>
        </div>
        <Button type="submit">
            Submit
        </Button>
    </form>
</template>