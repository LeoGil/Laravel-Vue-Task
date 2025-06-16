<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    status: string | null;
}>();

const selectedStatus = ref(props.status || 'all');

watch(() => props.status, (newStatus) => {
    selectedStatus.value = newStatus || 'all';
});

watch(selectedStatus, (newStatus) => {
    router.get('/tasks', {
        status: newStatus !== 'all' ? newStatus : undefined,
    }, {
        preserveScroll: true,
        preserveState: true,
    });
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <Label for="status">Filter by status</Label>
        <Select id="status" v-model="selectedStatus">
            <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Filter by status" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectItem value="all">All</SelectItem>
                    <SelectItem value="completed">Completed</SelectItem>
                    <SelectItem value="pending">Pending</SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    </div>
</template>
