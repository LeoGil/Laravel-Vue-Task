<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Progress } from '@/components/ui/progress';
import TaskDialog from '@/components/task/TaskDialog.vue';
import {
    CalendarDays,
    CheckCircle,
    Clock,
    Plus,
    TrendingUp,
    ChartNoAxesColumnIncreasing
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    stats: {
        totalTasks: number;
        completedTasks: number;
        pendingTasks: number;
        weeklyStats: {
            created: number;
            completed: number;
        };
        overdueTasks: number;
        tasksByPriority: {
            low: {
                completed: number;
                pending: number;
            };
            medium: {
                completed: number;
                pending: number;
            };
            high: {
                completed: number;
                pending: number;
            };
        };
    };
    recentTasks: {
        id: number;
        title: string;
        completed: boolean;
        created_at: string;
    }[];
    productivityData: {
        date: string;
        day: string;
        completed: number;
    }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

const completionPercentage = computed(() => {
    if (props.stats.totalTasks === 0) return 0;
    return Math.round((props.stats.completedTasks / props.stats.totalTasks) * 100);
});

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now.getTime() - date.getTime());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays === 1) return 'Hoje';
    if (diffDays === 2) return 'Ontem';
    if (diffDays <= 7) return `${diffDays} dias atrás`;

    return date.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>

    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                    <p class="text-muted-foreground">Acompanhe o progresso das suas tarefas</p>
                </div>
                <TaskDialog :icon=Plus triggerText="Nova Tarefa" dialogTitle="New Task"
                    dialogDescription="Create a new task." />
            </div>

            <!-- Cards básicos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Total de Tarefas</CardTitle>
                        <TrendingUp class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ props.stats.totalTasks }}</div>
                        <p class="text-xs text-muted-foreground">+{{ recentTasks.length }} criadas recentemente</p>
                    </CardContent>
                </Card>
                <!-- Concluídas -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Concluídas</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-600" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ props.stats.completedTasks }}</div>
                        <p class="text-xs text-muted-foreground">{{ completionPercentage }}% do total</p>
                    </CardContent>
                </Card>
                <!-- Pendentes -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Pendentes</CardTitle>
                        <Clock class="h-4 w-4 text-yellow-600" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-yellow-600">{{ props.stats.pendingTasks }}</div>
                        <p class="text-xs text-muted-foreground">Aguardando conclusão</p>
                    </CardContent>
                </Card>
                <!-- Progresso -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Progresso</CardTitle>
                        <CalendarDays class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ completionPercentage }}%</div>
                        <Progress :modelValue="completionPercentage" class="mt-2" />
                    </CardContent>
                </Card>
            </div>

            <!-- Estatísticas Avançadas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                <!-- Semana Criadas -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Criadas esta semana</CardTitle>
                        <CalendarDays class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ props.stats.weeklyStats.created }}</div>
                        <p class="text-xs text-muted-foreground">desde início da semana</p>
                    </CardContent>
                </Card>
                <!-- Semana Concluídas -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Concluídas esta semana</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-600" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ props.stats.weeklyStats.completed }}</div>
                        <p class="text-xs text-muted-foreground">até agora</p>
                    </CardContent>
                </Card>
                <!-- Atrasadas -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Atrasadas</CardTitle>
                        <Clock class="h-4 w-4 text-red-600" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-red-600">{{ props.stats.overdueTasks }}</div>
                        <p class="text-xs text-muted-foreground">não concluídas</p>
                    </CardContent>
                </Card>
                <!-- Prioridades -->
                <Card>
                    <CardHeader class="flex items-center justify-between pb-2">
                        <CardTitle class="text-sm font-medium">Por Prioridade</CardTitle>
                        <ChartNoAxesColumnIncreasing class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent class="space-y-1">
                        <div v-for="(status, priority) in props.stats.tasksByPriority" :key="priority"
                            class="space-y-1">
                            <div class="flex justify-between text-sm font-medium">
                                <span class="capitalize">{{ priority }}</span>
                                <span>{{ status.completed }} / {{ status.completed + status.pending }}</span>
                            </div>
                            <Progress :modelValue="(status.completed / (status.completed + status.pending)) * 100" />
                        </div>
                        <div v-if="Object.keys(props.stats.tasksByPriority).length === 0"
                            class="text-xs text-muted-foreground">
                            Sem prioridades definidas
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Tarefas Recentes e Produtividade -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recentes -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <CalendarDays class="h-5 w-5" /> Tarefas Recentes
                        </CardTitle>
                        <CardDescription>Suas últimas {{ recentTasks.length }} tarefas criadas</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div v-for="task in recentTasks" :key="task.id"
                                class="flex items-center justify-between p-3 rounded-lg border bg-card hover:bg-accent/50 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium truncate">{{ task.title }}</p>
                                    <p class="text-sm text-muted-foreground">{{ formatDate(task.created_at) }}</p>
                                </div>
                                <Badge :variant="task.completed ? 'default' : 'secondary'" class="ml-2">
                                    <CheckCircle v-if="task.completed" class="h-3 w-3 mr-1" />
                                    <Clock v-else class="h-3 w-3 mr-1" />
                                    {{ task.completed ? 'Concluída' : 'Pendente' }}
                                </Badge>
                            </div>
                            <div v-if="recentTasks.length === 0" class="text-center py-6">
                                <Clock class="h-12 w-12 mx-auto text-muted-foreground mb-4" />
                                <p class="text-muted-foreground">Nenhuma tarefa encontrada</p>
                                <Button asChild class="mt-2" variant="outline">
                                    <Link href="/tasks/create">Criar primeira questão</Link>
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Produtividade -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <TrendingUp class="h-5 w-5" /> Resumo de Produtividade
                        </CardTitle>
                        <CardDescription>Sua performance atual</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Taxa de Conclusão</span>
                                <span class="text-sm text-muted-foreground">{{ completionPercentage }}%</span>
                            </div>
                            <Progress :modelValue="completionPercentage" />

                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ props.stats.completedTasks }}
                                    </div>
                                    <div class="text-xs text-muted-foreground">Finalizadas</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600">{{ props.stats.pendingTasks }}</div>
                                    <div class="text-xs text-muted-foreground">Em Andamento</div>
                                </div>
                            </div>

                            <div class="pt-4 border-t">
                                <div class="flex items-center justify-between text-sm">
                                    <span>Meta diária</span>
                                    <Badge variant="outline">{{ Math.ceil(props.stats.pendingTasks / 7) }} tarefas/dia
                                    </Badge>
                                </div>
                            </div>

                            <!-- Gráfico 7 dias -->
                            <div class="pt-4 border-t space-y-2">
                                <h3 class="text-sm font-medium">Produtividade (7 dias)</h3>
                                <div v-for="data in productivityData" :key="data.date" class="flex items-center gap-2">
                                    <span class="w-8 text-xs">{{ data.day }}</span>
                                    <Progress
                                        :modelValue="Math.min(100, (data.completed / (Math.ceil(props.stats.pendingTasks / 7) || 1)) * 100)"
                                        class="flex-1 h-2" />
                                    <span class="w-6 text-xs text-right">{{ data.completed }}/{{ Math.ceil(props.stats.pendingTasks / 7) }}</span>
                                </div>
                            </div>

                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Ações Rápidas -->
            <Card>
                <CardHeader>
                    <CardTitle>Ações Rápidas</CardTitle>
                    <CardDescription>Navegue rapidamente para as principais funcionalidades</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-wrap gap-2">
                        <Button asChild variant="default">
                            <Link :href="route('tasks.index')">Ver Todas as Tarefas</Link>
                        </Button>
                        <Button asChild variant="default">
                            <Link :href="route('tasks.index', { status: 'pending' })">Tarefas Pendentes</Link>
                        </Button>
                        <Button asChild variant="default">
                            <Link :href="route('tasks.index', { status: 'completed' })">Tarefas Concluídas</Link>
                        </Button>
                        <Button asChild variant="default">
                            <Link href="/reports">Relatórios</Link>
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
