<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'KuaKhunPlub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fff;
            font-family: "Prompt", sans-serif;
            margin: 0;
        }
        /* Sidebar Styles */
        .sidebar {
            background: #fbb034;
            height: 100vh;
            color: #fff;
            padding: 20px;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            z-index: 1100;
        }
        .sidebar a {
            color: #fff;
            display: block;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        /* Navbar Styles */
        .navbar-custom {
            background: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 220px;
            right: 0;
            top: 0;
            height: 60px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }
        .profile-btn {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        /* Profile Popup Styles */
        .profile-popup {
            position: absolute;
            top: 70px;
            right: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            display: none;
            z-index: 1200;
        }
        .profile-popup.active {
            display: block;
            animation: fadeIn 0.2s ease;
        }
        .profile-popup .profile-info {
            padding: 15px;
            text-align: center;
        }
        .profile-popup .profile-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        .profile-popup .profile-info h6 {
            margin: 10px 0 0;
            font-weight: 600;
        }
        .profile-popup .menu {
            border-top: 1px solid #eee;
        }
        .profile-popup .menu a,
        .profile-popup .menu button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            background: none;
            border: none;
            outline: none;
            color: #333;
            text-decoration: none;
            font-size: 15px;
            text-align: left;
        }
        .profile-popup .menu a:hover,
        .profile-popup .menu button:hover {
            background: #f8f9fa;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .content {
            margin-left: 220px;
            margin-top: 60px;
            padding: 20px;
        }
    </style>

    @yield('styles')
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <h4 class="mb-4">KuaKhunPlub</h4>
        @auth
            @if(auth()->user()->role === 'employee')
                <a href="{{ route('c_in.checkin') }}">✅ เช็คอิน</a>
                <a href="{{ route('employee.salary') }}">💰 เงินเดือน</a>
                <a href="/leaves">📄 คำขอใบลา</a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('c_in.checkin') }}">✅ เช็คอิน</a>
                <a href="{{ route('employee.salary') }}">💰 เงินเดือน</a>
                <a href="/admin/leaves">🧾 จัดการคำขอ</a>
                <a href="{{ route('admin.employee.list') }}">รายชื่อพนักงาน</a>
                <a href="{{ route('admin.salary.employee.form')}}">💰 เงินเดือนพนักงาน</a>
            @endif
        @endauth
    </div>

    {{-- Navbar --}}
    <div class="navbar-custom">
        @auth
        <button class="profile-btn" id="profileBtn">
            @php
                $user = Auth::user();
                $photoPath = $user->employee && $user->employee->profile_image
                    ? asset('storage/' . $user->employee->profile_image)
                    : asset('images/default-avatar.png');
            @endphp
            <img src="{{ $photoPath }}" class="profile-img" alt="โปรไฟล์">
        </button>
        @endauth
    </div>

    {{-- Profile Popup --}}
 {{-- Profile Popup --}}
@auth
@php
    $user = Auth::user();
    $photoPath = $user->employee && $user->employee->profile_image
        ? asset('storage/' . $user->employee->profile_image)
        : asset('images/default-avatar.png');
@endphp
<div class="profile-popup" id="profilePopup">
    <div class="profile-info text-center p-3">
        <img src="{{ $photoPath }}" alt="Profile" class="rounded-circle mb-2" width="80" height="80">
        <h6 class="mb-0">{{ $user->name }}</h6>
        <small class="text-muted">{{ $user->email }}</small>
    </div>
    <hr class="my-2">
    <div class="menu text-center pb-2">
        <a href="{{ route('employee.profile') }}">👤 โปรไฟล์ของฉัน</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-danger text-decoration-none">🚪 ออกจากระบบ</button>
        </form>
    </div>
</div>
@endauth

    {{-- Content --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Script --}}
    @yield('scripts')
    <script>
        const profileBtn = document.getElementById('profileBtn');
        const profilePopup = document.getElementById('profilePopup');

        document.addEventListener('click', (e) => {
            if (profileBtn && profileBtn.contains(e.target)) {
                profilePopup.classList.toggle('active');
            } else if (profilePopup && !profilePopup.contains(e.target)) {
                profilePopup.classList.remove('active');
            }
        });
    </script>
</body>
</html>
