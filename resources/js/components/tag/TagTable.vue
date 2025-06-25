<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Tag } from '@/types';
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { getBadgeStyle } from '@/lib/utils';
import TagDialog from './TagDialog.vue';
import { ref } from 'vue';

const open = ref(false)

interface Props {
    tags: {
        data: Tag[],
        current_page: number,
        per_page: number,
        total: number,
    }
}

defineProps<Props>()

</script>

<template>
    <div class="w-full">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Color</TableHead>
                    <TableHead>Badge Example</TableHead>
                    <TableHead class="text-center">
                        Actions
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="tag in tags.data" :key="tag.id">
                    <TableCell class="font-medium">
                        {{ tag.name }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ tag.color }}
                    </TableCell>
                    <TableCell class="font-medium">
                        <span class="px-2 py-1 rounded-full capitalize text-xs font-semibold" :style="getBadgeStyle(tag.color)">
                            {{ tag.name }}
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
                                <TagDialog dialogTitle="Edit Tag" dialogDescription="Edit the tag." :tag="tag">
                                    <template #trigger>
                                        <DropdownMenuItem as-child @select.prevent="open = true">
                                            <span>Edit</span>
                                        </DropdownMenuItem>
                                    </template>
                                </TagDialog>
                                <DropdownMenuSeparator />
                                <!-- <DropdownMenuItem @click="deleteTask(task.id)" variant="destructive">Delete
                                </DropdownMenuItem> -->
                                <DropdownMenuItem variant="destructive">Delete</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>