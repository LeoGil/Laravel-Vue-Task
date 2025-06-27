<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { router } from '@inertiajs/vue3'

import PaginationWrapper from '../PaginationWrapper.vue'
import { Task } from '@/types';
import { format } from 'date-fns'
import { ptBR } from 'date-fns/locale'
import { toast } from 'vue-sonner'
import TaskDialog from './TaskDialog.vue'
import { ref } from 'vue'
import type { Component } from 'vue'
import { MoveUp, MoveRight, MoveDown } from 'lucide-vue-next'

const open = ref(false)

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

const priorityIcons: Record<string, Component> = {
    high: MoveUp,
    medium: MoveRight,
    low: MoveDown,
}

function getPriorityIcon(priority: string): Component | undefined {
    return priorityIcons[priority]
}

function completeTask(taskId: number) {
    router.patch(route('tasks.complete', taskId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Tarefa concluída com sucesso!', {
                position: 'top-center',
                duration: 6000,
                actionButtonStyle: {
                    backgroundColor: 'var(--color-primary)',
                    color: 'var(--color-primary-foreground)',
                },
                action: {
                    label: 'Undo',
                    onClick: () => {
                        undoCompleteTask(taskId)
                    },
                }
            })
        },
    })
}

function undoCompleteTask(taskId: number) {
    router.patch(route('tasks.incomplete', taskId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Tarefa desfeita com sucesso!', {
                position: 'top-center',
            })
        },
    })
}

function deleteTask(taskId: number) {
    confirm('Are you sure you want to delete this task?') && router.delete(route('tasks.destroy', taskId), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Tarefa excluída com sucesso!', {
                position: 'top-center',
            })
        },
    })
}


function getStatusClass(status: boolean): string {
    return status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
}

function getTextDecorationClass(completed: boolean): string {
    return completed ? 'line-through text-muted-foreground' : '';
}
</script>

<template>
    <div class="w-full">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Due Date</TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Priority</TableHead>
                    <TableHead class="text-right">
                        Status
                    </TableHead>
                    <TableHead class="text-center">
                        Actions
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="task in tasks.data" :key="task.id">
                    <TableCell>
                        <span :class="getTextDecorationClass(task.completed)">
                            {{ formatDate(task.due_date) }}
                        </span>
                    </TableCell>
                    <TableCell>
                        <span :class="getTextDecorationClass(task.completed)">
                            {{ task.title.length > 50 ? task.title.slice(0, 50) + '...' : task.title }}
                        </span>
                    </TableCell>
                    <TableCell>
                        <span :class="getTextDecorationClass(task.completed)">
                            {{ task.description !== null && task.description.length > 50 ? task.description.slice(0, 50) + '...' : task.description }}
                        </span>
                    </TableCell>
                    <TableCell>
                        <span class="px-2 py-1 rounded-full capitalize">
                            <component :is="getPriorityIcon(task.priority)" class="inline-block mr-2 h-4 w-4 text-muted-foreground" />
                            {{ task.priority }}
                        </span>
                    </TableCell>
                    <TableCell class="text-right">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full"
                            :class="getStatusClass(task.completed)">
                            {{ task.completed ? 'Completed' : 'Pending' }}
                        </span>
                    </TableCell>
                    <TableCell class="text-center">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="icon">
                                    ...
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="() => !task.completed && completeTask(task.id)"
                                    :disabled="task.completed">
                                    {{ task.completed ? 'Already Done' : 'Mark as Completed' }}
                                </DropdownMenuItem>
                                <TaskDialog dialogTitle="Edit Task" dialogDescription="Edit the task." :task="task">
                                    <template #trigger>
                                        <DropdownMenuItem as-child @select.prevent="open = true">
                                            <span>Edit</span>
                                        </DropdownMenuItem>
                                    </template>
                                </TaskDialog>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="deleteTask(task.id)" variant="destructive">Delete
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <div class="flex justify-end mt-4">
            <PaginationWrapper :current-page="tasks.current_page" :per-page="tasks.per_page" :total="tasks.total" />
        </div>
    </div>
</template>