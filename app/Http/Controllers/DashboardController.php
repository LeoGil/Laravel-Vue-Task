<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user = Auth::user();
        $baseQuery = Task::where('user_id', $user->id);

        // Estatísticas básicas
        $totalTasks = (clone $baseQuery)->count();
        $completedTasks = (clone $baseQuery)->where('completed', true)->count();
        $pendingTasks = (clone $baseQuery)->where('completed', false)->count();

        // Tarefas recentes (últimas 5)
        $recentTasks = (clone $baseQuery)
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'completed', 'created_at']);

        // Estatísticas da semana atual
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklyStats = [
            'created' => (clone $baseQuery)
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->count(),
            'completed' => (clone $baseQuery)
                ->where('completed', true)
                ->whereBetween('updated_at', [$weekStart, $weekEnd])
                ->count(),
        ];

        // Tarefas por prioridade (se existir campo priority)
        $tasksByPriority = (clone $baseQuery)
            ->selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Tarefas vencidas (se existir campo due_date)
        $overdueTasks = (clone $baseQuery)
            ->where('completed', false)
            ->where('due_date', '<', Carbon::now())
            ->count();

        // Produtividade dos últimos 7 dias
        $productivityData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $completedOnDay = (clone $baseQuery)
                ->where('completed', true)
                ->whereDate('updated_at', $date)
                ->count();

            $productivityData[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->translatedFormat('D'),
                'completed' => $completedOnDay,
            ];
        }

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'pendingTasks' => $pendingTasks,
                'completionRate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0,
                'weeklyStats' => $weeklyStats,
                'overdueTasks' => $overdueTasks,
                'tasksByPriority' => $tasksByPriority,
            ],
            'recentTasks' => $recentTasks,
            'productivityData' => $productivityData,
        ]);
    }
}
