<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

import PaginationWrapper from '../PaginationWrapper.vue'
import { Task } from '@/types';
import { format } from 'date-fns'
import { ptBR } from 'date-fns/locale'

interface Props {
    tasks: {
        data: Task[]
        current_page: number
        total: number
        per_page: number
    }
}

defineProps<Props>();

function formatDate(dateString: string) {
    const date = new Date(dateString)
    return format(date, "dd/MM/yyyy", { locale: ptBR })
}

function getPriorityClass(priority: string): string {
    switch (priority.toLowerCase()) {
        case 'high':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        case 'medium':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
        case 'low':
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    }
}

function getStatusClass(status: boolean): string {
    return status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
}
</script>

<template>
    <div class="w-full m-4">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Due Date</TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>Priority</TableHead>
                    <TableHead class="text-right">
                        Status
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="task in tasks.data" :key="task.id">
                    <TableCell class="font-medium">
                        {{ formatDate(task.due_date) }}
                    </TableCell>
                    <TableCell>{{ task.title }}</TableCell>
                    <TableCell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full"
                            :class="getPriorityClass(task.priority)">
                            {{ task.priority }}
                        </span>
                    </TableCell>
                    <TableCell class="text-right">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full"
                            :class="getStatusClass(task.completed)">
                            {{ task.completed ? 'Completed' : 'Pending' }}
                        </span>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <div class="flex justify-end mt-4">
            <PaginationWrapper :current-page="tasks.current_page" :per-page="tasks.per_page" :total="tasks.total" />
        </div>
    </div>
</template>