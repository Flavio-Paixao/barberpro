<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderByDesc('created_at')->get();
        return view('superadmin.index', compact('tenants'));
    }

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->status = $tenant->status === 'inativo' ? 'ativo' : 'inativo';
        $tenant->save();
        return back()->with('success', 'Status atualizado!');
    }
}
