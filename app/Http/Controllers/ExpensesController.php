<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;

class ExpensesController extends Controller
{
    public function index()
    {
        $category_expenses = CategoryExpense::all();
        $expenses = Expense::with('user.admin', 'user.manager')->get();
                return view('pengeluaran/pengeluaran', compact('category_expenses', 'expenses'),["title" => "pengeluaran"]);
    }
}
