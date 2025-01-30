<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">

      <img src="{{ asset('img/avatars/logo.png') }}" style="width: 50px; height: auto;">

  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    @role('admin')
    <!-- Admins -->
    <li class="menu-item {{ request()->is('admin/admins*') ? ' active' : '' }}">
      <a href="{{ route('admins.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user-circle"></i>
        <div data-i18n="Admins">Admins</div>
      </a>
    </li>

    <!-- Employees -->
    <li class="menu-item {{ request()->is('admin/employees*') ? ' active' : '' }}">
      <a href="{{ route('employees.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Employees">Employees</div>
      </a>
    </li>

    <!-- Adjustment Types -->
    <li class="menu-item {{ request()->is('admin/adjustment-types*') ? ' active' : '' }}">
      <a href="{{ route('adjustment-types.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-adjustments-horizontal"></i>
        <div data-i18n="Adjustment Types">Adjustment Types</div>
      </a>
    </li>

    <!-- Payroll Periods -->
    <li class="menu-item {{ request()->is('admin/payroll-periods*') ? ' active' : '' }}">
      <a href="{{ route('payroll-periods.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-calendar"></i>
        <div data-i18n="Payroll Periods">Payroll Periods</div>
      </a>
    </li>

    <!-- Salary Slips -->
    <li class="menu-item {{ request()->is('admin/salary-slips*') ? ' active' : '' }}">
      <a href="{{ route('admin.salary-slips.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-invoice"></i>
        <div data-i18n="Salary Slips">Salary Slips</div>
      </a>
    </li>
    @endrole

    @role('employee')
    <!-- Salary Slips -->
    <li class="menu-item {{ request()->is('employee/salary-slips*') ? ' active' : '' }}">
        <a href="{{ route('employee.salary-slips') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-invoice"></i>
          <div data-i18n="Salary Slips">Salary Slips</div>
        </a>
      </li>
    @endrole
  </ul>
</aside>
