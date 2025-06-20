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
import FormItem from '../ui/form/FormItem.vue';

const props = defineProps<{
    status: string | null;
    priority: string | null;
}>();

function normalize(value: string | null) {
    return value || 'all';
}

const selectedStatus = ref(normalize(props.status));
const selectedPriority = ref(normalize(props.priority));

function applyFilters() {
    router.get('/tasks', {
        status: selectedStatus.value !== 'all' ? selectedStatus.value : undefined,
        priority: selectedPriority.value !== 'all' ? selectedPriority.value : undefined,
        page: 1,
    }, {
        preserveScroll: true,
        preserveState: true,
    });
}

watch(selectedStatus, applyFilters);
watch(selectedPriority, applyFilters);
</script>

<template>
    <div class="flex gap-2">
        <FormItem>
            <Label>Filter by priority</Label>
            <Select id="priority" v-model="selectedPriority">
                <SelectTrigger class="w-[180px]">
                    <SelectValue placeholder="Filter by priority" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="all">All</SelectItem>
                        <SelectItem value="high">High</SelectItem>
                        <SelectItem value="medium">Medium</SelectItem>
                        <SelectItem value="low">Low</SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </FormItem>
        <FormItem>
            <Label>Filter by status</Label>
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
        </FormItem>
    </div>
</template>
