<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function __invoke(Request $request)
    {
        if ($request->expectsJson()) {

            return Car::query()->orderBy('car_name')->where('in_stock',true)->get();
        }

        return view('dashboard');
    }
}