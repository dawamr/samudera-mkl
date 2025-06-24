<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\mkl;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Sidebar Component - Komponen untuk navigasi sidebar AdminLTE
 *
 * Component ini menghitung dan menyediakan badge counts untuk setiap menu
 * di sidebar. Data counts dibagikan ke semua view menggunakan view()->share()
 *
 * @author Your Team
 * @version 1.0
 */
class Sidebar extends Component
{
    /**
     * Membuat instance component baru dan menghitung badge counts
     *
     * Method ini akan dijalankan setiap kali sidebar di-render
     * Semua counting disimpan dalam global view data menggunakan view()->share()
     * sehingga bisa diakses dari sidebar.blade.php
     */
    public function __construct()
    {
        // Counting untuk Users menu
        $userCount = User::count();
        view()->share('userCount', $userCount);

        // Counting untuk Roles menu
        $RoleCount = Role::count();
        view()->share('RoleCount', $RoleCount);

        // Counting untuk Permissions menu (currently commented out in view)
        $PermissionCount = Permission::count();
        view()->share('PermissionCount', $PermissionCount);

        // Counting untuk Categories menu (legacy)
        $CategoryCount = Category::count();
        view()->share('CategoryCount', $CategoryCount);

        // Counting untuk SubCategories menu (legacy)
        $SubCategoryCount = SubCategory::count();
        view()->share('SubCategoryCount', $SubCategoryCount);

        // Counting untuk Collections menu (legacy)
        $CollectionCount = Collection::count();
        view()->share('CollectionCount', $CollectionCount);

        // Counting untuk Products menu (legacy)
        $ProductCount = Product::count();
        view()->share('ProductCount', $ProductCount);

        // Counting untuk MKL menu - menampilkan total data MKL
        $MTKCount = mkl::count();
        view()->share('MTKCount', $MTKCount);
    }

    /**
     * Mengembalikan view yang akan di-render untuk komponen sidebar
     *
     * Method ini mengembalikan view components.sidebar yang berisi
     * struktur navigasi sidebar dengan badge counts yang sudah dihitung
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
