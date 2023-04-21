{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-title">Patients</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('registration') }}"><i class="nav-icon la la-address-book"></i> Registration</a></li>

<li class="nav-title">Admin</li>


<li class="nav-item nav-dropdown">
    <a href="#" class="nav-link nav-dropdown-toggle">
        <i class="nav-icon la la-user"></i> Adminpanel
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('room') }}">
                <i class="nav-icon la la-door-open"></i> Rooms
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('doctor') }}">
                <i class="nav-icon la la-briefcase"></i> Employee
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('bill') }}">
                <i class="nav-icon la la-money-check"></i> Payment types
            </a>
        </li>
    </ul>
</li>

<li class="nav-title">Checkout</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('checkout') }}"><i class="nav-icon la la-money"></i> Checkout</a></li>



{{-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('adminpanel') }}"><i class="nav-icon la la-user"></i> Adminpanel</a></li> --}}





