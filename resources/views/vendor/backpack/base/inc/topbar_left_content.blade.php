{{-- This file is used to store topbar (left) items --}}

{{-- <li class="nav-item px-3"><a class="nav-link" href="/admin/registration">Qeydiyyat</a></li> --}}
{{-- If we are in the /admin/registration page make this link active otherwise not --}}
<li class="nav-item px-3"><a class="nav-link {{ Request::is('admin/registration') ? 'active' : '' }}" href="/admin/registration">Qeydiyyat</a></li>
<li class="nav-item px-3"><a class="nav-link {{ Request::is('admin/patient') ? 'active' : '' }}" href="/admin/patient">Xəstələr</a></li>
<li class="nav-item px-3"><a class="nav-link {{ Request::is('admin/checkout') ? 'active' : '' }}" href="/admin/checkout">Kassa</a></li>

