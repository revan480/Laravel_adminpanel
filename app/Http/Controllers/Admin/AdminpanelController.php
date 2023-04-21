<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * Class AdminpanelController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminpanelController extends Controller
{
    public function index()
    {
        return view('admin.adminpanel', [
            'title' => 'Adminpanel',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Adminpanel' => true,
            ],
            'page' => 'resources/views/admin/adminpanel.blade.php',
            'controller' => 'app/Http/Controllers/Admin/AdminpanelController.php',
        ]);
    }
}
