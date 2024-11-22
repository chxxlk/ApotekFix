<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #sidebar {
            min-height: 100vh;
            width: 250px;
            transition: all 0.3s;
            position: fixed;
            left: 0;
            top: 0;
        }

        #content {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s;
            width: calc(100% - 250px);
        }

        .sidebar-link {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar-link:hover {
            background: #4b545c;
            color: white;
        }

        .sidebar-submenu {
            padding-left: 25px;
        }

        .user-profile {
            padding: 15px;
            color: white;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
                width: 100%;
            }

            #content.active {
                margin-left: 250px;
            }
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="bg-dark">
        <div class="p-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{route('admin.dashboard')}}">
                    <h4 class="text-white">Apotik</h4>
                </a>
                <button class="btn btn-dark d-lg-none" id="sidebarToggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <hr class="bg-white">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="sidebar-link" href="{{route('admin.users')}}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="{{route('admin.obat.index')}}">
                        <i class="fas fa-pills"></i> Product
                    </a>
                </li>
            </ul>
            <div class="user-profile mt-auto">
                <div class="dropdown">
                    <a class="sidebar-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <button class="btn btn-dark d-lg-none position-fixed" style="z-index: 1000; left: 10px; top: 10px;" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>