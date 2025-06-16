<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import TaskDialog from '@/components/task/TaskDialog.vue';
import TaskTable from '@/components/task/TaskTable.vue';
import { Task } from '@/types';
import TaskFilter from '@/components/task/TaskFilter.vue';

defineProps<{
    tasks: {
        data: Task[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    }
    filters: {
        status: string | null;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: '/tasks',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Tasks" />

        <TaskDialog triggerText="Add Task" triggerClass="absolute right-4 top-4" dialogTitle="New Task"
            dialogDescription="Create a new task.">
        </TaskDialog>
        <div class="flex flex-col gap-4 p-4">
            <TaskFilter :status="filters.status" />
            <TaskTable :tasks="tasks" />
        </div>
    </AppLayout>
</template>