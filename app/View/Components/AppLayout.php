<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;


class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $name = Route::currentRouteName();
        if (isset($name)) {
            $title = $name;
        } else {
            $title = 'Сайт time_control';
        }
        return view('layouts.app', [
            'title' => $title,
        ]);
    }
}
