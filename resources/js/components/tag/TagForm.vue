<script setup lang="ts">
import { Tag } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { toast } from 'vue-sonner';

interface Props {
    method: 'post' | 'patch'
    action: string
    initial: Tag | {}
}
const props = defineProps<Props>()

const form = useForm({
    name: '',
    color: '',
})

const emit = defineEmits<{
    (e: 'success'): void
}>()

const submit = () => {
    let formRoute
    if ('id' in props.initial) {
        formRoute = props.method === 'post' ? route('tags.store') : route('tags.update', props.initial.id);
    } else {
        formRoute = route('tags.store');
    }

    form[props.method](formRoute, {
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
    <form @submit.prevent="submit" class="space-y-4">
        <div class="flex flex-col gap-4">
            <div>
                <Label for="name" class="mb-2">Tag name</Label>
                <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                <InputError :message="form.errors.name" />
            </div>
            <div>
                <Label for="color" class="mb-2">Color</Label>
                <div class="flex items-center gap-2">
                    <Input id="color" type="color" class="w-12 h-12 p-0 rounded" v-model="form.color" />
                    <Input id="color-hex" class="mt-1 block w-full" v-model="form.color" placeholder="#000000" />
                </div>
                <InputError :message="form.errors.color" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <Button :disabled="form.processing">Save</Button>
        </div>
    </form>
</template>