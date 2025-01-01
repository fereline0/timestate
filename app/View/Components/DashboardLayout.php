<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardLayout extends Component
{
    public function render(): View
    {
        $links = [
            ['name' => 'Рабочие часы сотрудников', 'url' => 'dashboard.working-times.index'],
            ['name' => 'Больничные дни сотрудников', 'url' => 'dashboard.sick-leaves.index'],
            ['name' => 'Отпуска сотрудников', 'url' => 'dashboard.vacations.index'],
            ['name' => 'Отделы', 'url' => 'dashboard.departments.index'],
            ['name' => 'Сотрудники', 'url' => 'dashboard.users.index'],
        ];

        return view('layouts.dashboard', [
            'links' => $links
        ]);
    }
}
