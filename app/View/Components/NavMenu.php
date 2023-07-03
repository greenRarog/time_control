<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NavMenu extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        if (Auth::check()) {
            $user = Auth::User();
            if ($user->role == 'teacher') {
                return view('components.nav-menu-teacher');
            } else {
                $id = $user->id;
                return view('components.nav-menu-student',[
                    'id' => $id
                ]);
            }
        } else {
            return view('components.nav-menu');//components.nav-menu');
        }
    }
}
