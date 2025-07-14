<aside class="silde-bars float-start position-fixed">
    <a href="{{ route('admin.dashboard') }}" class="s-logos">
        <img src="{{ asset('assets/images/logo-w.svg')}}" alt="logo" />
    </a>
    <ul class="m-0 mt-3 p-0">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/Home-i.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/home-active.svg')}}" class="active-add" alt="logo" />
                </span> Homepage
            </a>
        </li>
        <li>
            <a href="{{ route('appointments.index') }}"
                class="{{ request()->routeIs('appointments.index') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/appointment-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/appointment-active.svg')}}" class="active-add" alt="logo" />

                </span> Appointments
            </a>
        </li>
        <li>
            <a href="{{ route('pets.index')}}" class="{{ request()->routeIs('pets.index') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/patient-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/appointment-active.svg')}}" class="active-add" alt="logo" />
                </span> Patient Flow
            </a>
        </li>
        <li>
            <a href="{{ route('pet.directory')}}"
                class="{{ request()->routeIs('pet.directory') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/directory-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/directory-active.svg')}}" class="active-add" alt="logo" />
                </span> Pet Directory
            </a>
        </li>
        <li>
            <a href="{{ route('messages') }}" class="{{ request()->is('messages*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/message-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/message-active.svg')}}" class="active-add" alt="logo" />
                </span> Messages
            </a>
        </li>
        <li>
            <a href="{{route('billing.view')}}" class="{{ request()->routeIs('billing.view') ? 'active-menus' : '' }}">
                <span>

                    <img src="{{ asset('assets/images/Vector.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/billing-active.svg')}}" class="active-add" alt="logo" />
                </span> Billing
            </a>
        </li>
        <li>
            <a href="{{ route('inventory') }}" class="{{ request()->is('inventory*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/inventory-inactive.svg') }}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/inventory-active.svg') }}" class="active-add" alt="logo" />
                </span> Inventory
            </a>
        </li>
        <li>
            <a href="{{ URL::to('overdue') }}" class="{{ request()->is('overdue*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/overdue-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/overdue-active.svg')}}" class="active-add" alt="logo" />
                </span> Overdue Visit
            </a>
        </li>
        <li>
            <a href="{{ route('analytics') }}" class="{{ request()->is('analytics*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/analytics-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/analytics-inactive.svg')}}" class="active-add" alt="logo" />

                </span> Data Analytics
            </a>
        </li>
        <li>
            <a href="{{ route('reminders.index') }}" class="{{ request()->is('reminder*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/reminder-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/reminder-inactive.svg')}}" class="active-add" alt="logo" />
                </span> Reminder
            </a>
        </li>
        <li>
            <a href="{{ route('smartlou') }}" class="{{ request()->routeIs('smartlou') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/lou-active.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/inventory-active.svg')}}" class="active-add" alt="logo" />
                </span>
                Smart Lou
            </a>
        </li>
        <li class="logout01">
            <a href="{{ route('settings') }}" class="{{ request()->is('settings*') ? 'active-menus' : '' }}">
                <span>
                    <img src="{{ asset('assets/images/settings-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/settings-active.svg')}}" class="active-add" alt="logo" />
                </span> Settings
            </a>
        </li>
        <li>
            <a href="{{ URL::to('/logout') }}">
                <span>
                    <img src="{{ asset('assets/images/LogOut-inactive.svg')}}" class="active-no" alt="logo" />
                    <img src="{{ asset('assets/images/settings-active.svg')}}" class="active-add" alt="logo" />
                </span> Log Out
            </a>
        </li>
    </ul>
</aside>