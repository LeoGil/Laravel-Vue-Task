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
                    <TableCell class="text-center">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="secondary" size="sm">Actions</Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem>View</DropdownMenuItem>
                                <DropdownMenuItem>Update</DropdownMenuItem>
                                <DropdownMenuItem>Remove</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>