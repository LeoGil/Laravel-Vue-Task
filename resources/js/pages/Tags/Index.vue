<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Tag } from '@/types';
import { Head } from '@inertiajs/vue3';
import TagDialog from '@/components/tag/TagDialog.vue';
import { Plus } from 'lucide-vue-next';
import TagTable from '@/components/tag/TagTable.vue';

interface Props {
    tags: {
        data: Tag[];
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    }
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tags',
        href: '/tags',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Tags" />
        <TagDialog :icon="Plus" triggerText="New Tag" dialogDescription="Create a new tag for your tasks."
            triggerClass="absolute right-4 top-4" dialogTitle="New Tag" />

        <div v-if="tags.data.length > 0" class="flex flex-col gap-4 p-4">
            <TagTable :tags="tags" />
        </div>
        <div v-else class="flex gap-4 p-4 flex-col items-center">
            <p class="text-muted-foreground text-center">No tags found.</p>
            <TagDialog triggerText="Create your first tag" dialogTitle="New Tag"
                dialogDescription="Create a new tag for your tasks." />
        </div>
    </AppLayout>
</template>