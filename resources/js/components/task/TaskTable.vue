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
    return format(date, "dd 'de' MMMM 'de' yyyy", { locale: ptBR })
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
                    <TableCell>{{ task.priority }}</TableCell>
                    <TableCell class="text-right">
                        {{ task.completed ? 'Completed' : 'Pending' }}
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <div class="flex justify-end mt-4">
            <PaginationWrapper :current-page="tasks.current_page" :per-page="tasks.per_page" :total="tasks.total" />
        </div>
    </div>
</template>