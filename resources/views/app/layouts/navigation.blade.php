{{-- <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}



<div class="header-advance-area">
    <div class="header-top-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <div class="header-top-wraper">
                        <div class="row">
                            <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                <div class="menu-switcher-pro">
                                    <button type="button" id="sidebarCollapse"
                                        class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                        <i class="educate-icon educate-nav"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                {{-- <div class="header-top-menu tabl-d-n">
                                    <ul class="nav navbar-nav mai-top-nav">
                                        <li class="nav-item"><a href="#" class="nav-link">Home</a>
                                        </li>
                                        <li class="nav-item"><a href="#" class="nav-link">About</a>
                                        </li>
                                        <li class="nav-item"><a href="#" class="nav-link">Services</a>
                                        </li>
                                        <li class="nav-item dropdown res-dis-nn">
                                            <a href="#" data-toggle="dropdown" role="button"
                                                aria-expanded="false" class="nav-link dropdown-toggle">Project
                                                <span class="angle-down-topmenu"><i
                                                        class="fa fa-angle-down"></i></span></a>
                                            <div role="menu" class="dropdown-menu animated zoomIn">
                                                <a href="#" class="dropdown-item">Documentation</a>
                                                <a href="#" class="dropdown-item">Expert Backend</a>
                                                <a href="#" class="dropdown-item">Expert FrontEnd</a>
                                                <a href="#" class="dropdown-item">Contact Support</a>
                                            </div>
                                        </li>
                                        <li class="nav-item"><a href="#" class="nav-link">Support</a>
                                        </li>
                                    </ul>
                                </div> --}}
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="header-right-info">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-toggle="dropdown" role="button"
                                                aria-expanded="false" class="nav-link dropdown-toggle"><i
                                                    class="educate-icon educate-message edu-chat-pro"
                                                    aria-hidden="true"></i><span
                                                    class="indicator-ms"></span></a>
                                            <div role="menu"
                                                class="author-message-top dropdown-menu animated zoomIn">
                                                <div class="message-single-top">
                                                    <h1>Message</h1>
                                                </div>
                                                <ul class="message-menu">
                                                    <li>
                                                        <a href="#">
                                                            <div class="message-img">
                                                                <img src="{{ asset('backend/img/contact/1.jpg') }}" alt="">
                                                            </div>
                                                            <div class="message-content">
                                                                <span class="message-date">16 Sept</span>
                                                                <h2>Advanda Cro</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="message-img">
                                                                <img src="{{ asset('backend/img/contact/4.jpg') }}" alt="">
                                                            </div>
                                                            <div class="message-content">
                                                                <span class="message-date">16 Sept</span>
                                                                <h2>Sulaiman din</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="message-img">
                                                                <img src="{{ asset('backend/img/contact/3.jpg') }}" alt="">
                                                            </div>
                                                            <div class="message-content">
                                                                <span class="message-date">16 Sept</span>
                                                                <h2>Victor Jara</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="message-img">
                                                                <img src="{{ asset('backend/img/contact/2.jpg') }}" alt="">
                                                            </div>
                                                            <div class="message-content">
                                                                <span class="message-date">16 Sept</span>
                                                                <h2>Victor Jara</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="message-view">
                                                    <a href="#">View All Messages</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button"
                                                aria-expanded="false" class="nav-link dropdown-toggle"><i
                                                    class="educate-icon educate-bell"
                                                    aria-hidden="true"></i><span
                                                    class="indicator-nt"></span></a>
                                            <div role="menu"
                                                class="notification-author dropdown-menu animated zoomIn">
                                                <div class="notification-single-top">
                                                    <h1>Notifications</h1>
                                                </div>
                                                <ul class="notification-menu">
                                                    <li>
                                                        <a href="#">
                                                            <div class="notification-icon">
                                                                <i class="educate-icon educate-checked edu-checked-pro admin-check-pro"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <span class="notification-date">16 Sept</span>
                                                                <h2>Advanda Cro</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="notification-icon">
                                                                <i class="fa fa-cloud edu-cloud-computing-down"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <span class="notification-date">16 Sept</span>
                                                                <h2>Sulaiman din</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="notification-icon">
                                                                <i class="fa fa-eraser edu-shield"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <span class="notification-date">16 Sept</span>
                                                                <h2>Victor Jara</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <div class="notification-icon">
                                                                <i class="fa fa-line-chart edu-analytics-arrow"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <span class="notification-date">16 Sept</span>
                                                                <h2>Victor Jara</h2>
                                                                <p>Please done this project as soon possible.
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="notification-view">
                                                    <a href="#">View All Notification</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button"
                                                aria-expanded="false" class="nav-link dropdown-toggle">
                                                <img src="{{ auth()->user()->profile_pic ? asset(auth()->user()->profile_pic):asset('backend/img/product/pro4.jpg') }}" alt="" />
                                                <span class="admin-name">{{ auth()->user()->name??"--" }}</span>
                                                <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                            </a>
                                            <ul role="menu"
                                                class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                               
                                                <li>
                                                    <a href="{{ route('profile.edit') }}"><span class="edu-icon edu-user-rounded author-log-ic"></span>My Profile</a>
                                                </li>
                                                <li>
                                                    {{-- <a href="#">Log Out</a> --}}
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <span class="edu-icon edu-locked author-log-ic"></span>
                                                        <x-responsive-nav-link :href="route('logout')"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                                            {{ __('Log Out') }}
                                                        </x-responsive-nav-link>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item nav-setting-open"><a href="#" data-toggle="dropdown"
                                                role="button" aria-expanded="false"
                                                class="nav-link dropdown-toggle"><i
                                                    class="educate-icon educate-menu"></i></a>

                                            <div role="menu"
                                                class="admintab-wrap menu-setting-wrap menu-setting-wrap-bg dropdown-menu animated zoomIn">
                                                <ul class="nav nav-tabs custon-set-tab">
                                                    <li class="active"><a data-toggle="tab"
                                                            href="#Notes">Notes</a>
                                                    </li>
                                                    <li><a data-toggle="tab" href="#Projects">Projects</a>
                                                    </li>
                                                    <li><a data-toggle="tab" href="#Settings">Settings</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content custom-bdr-nt">
                                                    <div id="Notes" class="tab-pane fade in active">
                                                        <div class="notes-area-wrap">
                                                            <div class="note-heading-indicate">
                                                                <h2><i class="fa fa-comments-o"></i> Latest
                                                                    Notes</h2>
                                                                <p>You have 10 new message.</p>
                                                            </div>
                                                            <div class="notes-list-area notes-menu-scrollbar">
                                                                <ul class="notes-menu-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/4.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/1.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/2.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/3.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/4.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/1.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/2.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/1.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/2.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="notes-list-flow">
                                                                                <div class="notes-img">
                                                                                    <img src="{{ asset('backend/img/contact/3.jpg') }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="notes-content">
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more-or-less normal.</p>
                                                                                    <span>Yesterday 2:45
                                                                                        pm</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Projects" class="tab-pane fade">
                                                        <div class="projects-settings-wrap">
                                                            <div class="note-heading-indicate">
                                                                <h2><i class="fa fa-cube"></i> Latest projects
                                                                </h2>
                                                                <p> You have 20 projects. 5 not completed.</p>
                                                            </div>
                                                            <div
                                                                class="project-st-list-area project-st-menu-scrollbar">
                                                                <ul class="projects-st-menu-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Web Development</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">1
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content">
                                                                                    <p>Completion with: 28%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 28%;"
                                                                                            class="progress-bar progress-bar-danger hd-tp-1">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Software Development
                                                                                    </h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">2
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content project-rating-cl">
                                                                                    <p>Completion with: 68%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 68%;"
                                                                                            class="progress-bar hd-tp-2">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Graphic Design</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">3
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content">
                                                                                    <p>Completion with: 78%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 78%;"
                                                                                            class="progress-bar hd-tp-3">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Web Design</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">4
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content project-rating-cl2">
                                                                                    <p>Completion with: 38%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 38%;"
                                                                                            class="progress-bar progress-bar-danger hd-tp-4">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Business Card</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">5
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content">
                                                                                    <p>Completion with: 28%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 28%;"
                                                                                            class="progress-bar progress-bar-danger hd-tp-5">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Ecommerce Business</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">6
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content project-rating-cl">
                                                                                    <p>Completion with: 68%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 68%;"
                                                                                            class="progress-bar hd-tp-6">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Woocommerce Plugin</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">7
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content">
                                                                                    <p>Completion with: 78%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 78%;"
                                                                                            class="progress-bar">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="project-list-flow">
                                                                                <div
                                                                                    class="projects-st-heading">
                                                                                    <h2>Wordpress Theme</h2>
                                                                                    <p> The point of using Lorem
                                                                                        Ipsum is that it has a
                                                                                        more or less normal.</p>
                                                                                    <span
                                                                                        class="project-st-time">9
                                                                                        hours ago</span>
                                                                                </div>
                                                                                <div
                                                                                    class="projects-st-content project-rating-cl2">
                                                                                    <p>Completion with: 38%</p>
                                                                                    <div
                                                                                        class="progress progress-mini">
                                                                                        <div style="width: 38%;"
                                                                                            class="progress-bar progress-bar-danger">
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>Project end: 4:00 pm -
                                                                                        12.06.2014</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Settings" class="tab-pane fade">
                                                        <div class="setting-panel-area">
                                                            <div class="note-heading-indicate">
                                                                <h2><i class="fa fa-gears"></i> Settings Panel
                                                                </h2>
                                                                <p> You have 20 Settings. 5 not completed.</p>
                                                            </div>
                                                            <ul class="setting-panel-list">
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Show notifications</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Disable Chat</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example3">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example3">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Enable history</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example4">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example4">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Show charts</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example7">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example7">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Update everyday</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        checked=""
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example2">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example2">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Global search</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        checked=""
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example6">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example6">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox-setting-pro">
                                                                        <div class="checkbox-title-pro">
                                                                            <h2>Offline users</h2>
                                                                            <div class="ts-custom-check">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox"
                                                                                        name="collapsemenu"
                                                                                        checked=""
                                                                                        class="onoffswitch-checkbox"
                                                                                        id="example5">
                                                                                    <label
                                                                                        class="onoffswitch-label"
                                                                                        for="example5">
                                                                                        <span
                                                                                            class="onoffswitch-inner"></span>
                                                                                        <span
                                                                                            class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">
                                @if (Auth::user()->Role('admin'))
                                    <!-- Admin Mobile Menu -->
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('schools.show') }}">School Profile</a></li>
                                    
                                    <li><a data-toggle="collapse" data-target="#academic" href="#">Academic <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="academic" class="collapse dropdown-header-top">
                                            <li><a href="{{ route('admin.academic.classes.index') }}">Classes</a></li>
                                            <li><a href="{{ route('admin.academic.sections.index') }}">Sections</a></li>
                                            <li><a href="{{ route('admin.academic.subjects.index') }}">Subjects</a></li>
                                            <li><a href="{{ route('admin.timetable.index') }}">Time Table</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a data-toggle="collapse" data-target="#people" href="#">People <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="people" class="collapse dropdown-header-top">
                                            <li><a href="{{ route('dashboard.teachers') }}">Teachers</a></li>
                                            <li><a href="{{ route('dashboard.students') }}">Students</a></li>
                                            <li><a href="{{ route('dashboard.parents') }}">Parents</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="{{ route('admin.attendance.index') }}">Attendance</a></li>
                                    
                                    <li><a data-toggle="collapse" data-target="#fees" href="#">Fees Management <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="fees" class="collapse dropdown-header-top">
                                            <li><a href="#">Categories</a></li>
                                            <li><a href="#">Structures</a></li>
                                            <li><a href="#">Payments</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a data-toggle="collapse" data-target="#exams" href="#">Exams <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="exams" class="collapse dropdown-header-top">
                                            <li><a href="#">Schedule</a></li>
                                            <li><a href="#">Results</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a data-toggle="collapse" data-target="#library" href="#">Library <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="library" class="collapse dropdown-header-top">
                                            <li><a href="#">Books</a></li>
                                            <li><a href="#">Issues</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="#">Inventory</a></li>
                                    <li><a href="#">Notices</a></li>
                                    <li><a href="#">Holidays</a></li>
                                    <li><a href="#">Reports</a></li>
                                    <li><a href="#">Settings</a></li>
                                    
                                @elseif (Auth::user()->Role('teacher'))
                                    <!-- Teacher Mobile Menu -->
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">My Profile</a></li>
                                    <li><a href="#">My Students</a></li>
                                    <li><a href="#">Mark Attendance</a></li>
                                    
                                    <li><a data-toggle="collapse" data-target="#exams" href="#">Exams <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="exams" class="collapse dropdown-header-top">
                                            <li><a href="#">Create Tests</a></li>
                                            <li><a href="#">Enter Marks</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="#">Subjects</a></li>
                                    <li><a href="#">My Reports</a></li>
                                    
                                @elseif (Auth::user()->Role('parent'))
                                    <!-- Parent Mobile Menu -->
                                    <li><a href="#">Dashboard</a></li>
                                    
                                    <li><a data-toggle="collapse" data-target="#children" href="#">My Children <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                        <ul id="children" class="collapse dropdown-header-top">
                                            <li><a href="#">Profile</a></li>
                                            <li><a href="#">Attendance</a></li>
                                            <li><a href="#">Results</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="#">Fee Payments</a></li>
                                    <li><a href="#">Library Books</a></li>
                                    <li><a href="#">Notices</a></li>
                                    
                                @elseif (Auth::user()->Role('student'))
                                    <!-- Student Mobile Menu -->
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">My Profile</a></li>
                                    <li><a href="#">My Attendance</a></li>
                                    <li><a href="#">My Results</a></li>
                                    <li><a href="#">Fee Status</a></li>
                                    <li><a href="#">Book Issues</a></li>
                                @endif
                                
                                <!-- Common Mobile Menu Items -->
                                <li><a data-toggle="collapse" data-target="#account" href="#">Account <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                    <ul id="account" class="collapse dropdown-header-top">
                                        <li><a href="#">Notifications</a></li>
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="{{ route('logout') }}">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu end -->
    
</div>