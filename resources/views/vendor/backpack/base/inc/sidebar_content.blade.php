{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> Idarə Paneli</a></li>

<li class="nav-title">Xəstələr</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('registration') }}"><i class="nav-icon la la-address-book"></i> Qeydiyyat</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('registration') }}"><i class="nav-icon la la-bed"></i> Xəstələr</a></li>


<li class="nav-title">Admin</li>


<li class="nav-item nav-dropdown">
    <a href="#" class="nav-link nav-dropdown-toggle">
        <i class="nav-icon la la-user"></i> Adminpanel
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('room') }}">
                <i class="nav-icon la la-door-open"></i> Otaqlar
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('doctor') }}">
                <i class="nav-icon la la-briefcase"></i> Mütəxəssislər
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('bill') }}">
                <i class="nav-icon la la-money-check"></i> Ödəniş növü
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('packet') }}">
                <i class="nav-icon la la-gift"></i> Paketlər
            </a>
        </li>
    </ul>
</li>

<li class="nav-title">Kassa</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('checkout') }}"><i class="nav-icon la la-money"></i>Kassa</a></li>



{{-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('adminpanel') }}"><i class="nav-icon la la-user"></i> Adminpanel</a></li> --}}
