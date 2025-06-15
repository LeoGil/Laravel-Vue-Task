<script setup lang="ts">
import {
    Pagination,
    PaginationContent,
    PaginationFirst,
    PaginationLast,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination'

import { router } from '@inertiajs/vue3'

interface Props {
    currentPage: number
    perPage: number
    total: number
}

const props = defineProps<Props>()

function goToPage(page: number) {
    if (page >= 1 && page <= Math.ceil(props.total / props.perPage)) {
        router.visit(`?page=${page}`, { preserveScroll: true })
    }
}
</script>

<template>
    <Pagination v-slot="{ page }" :default-page="currentPage" :items-per-page="perPage" :total="total"
        @update:page="goToPage">
        <PaginationContent v-slot="{ items }">
            <PaginationFirst />
            <PaginationPrevious />

            <template v-for="(item, index) in items" :key="index">
                <PaginationItem v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page">
                    {{ item.value }}
                </PaginationItem>
            </template>

            <PaginationNext />
            <PaginationLast />
        </PaginationContent>
    </Pagination>
</template>
