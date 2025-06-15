<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import TaskDialog from '@/components/task/TaskDialog.vue';
import TaskTable from '@/components/task/TaskTable.vue';
import { Task } from '@/types';

defineProps<{
  tasks: {
    data: Task[];
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
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
            dialogDescription="Just an example.">
        </TaskDialog>
        <!-- <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
        </div> -->
        <div class="flex">
            <TaskTable :tasks="tasks"/>
        </div>
    </AppLayout>
</template>