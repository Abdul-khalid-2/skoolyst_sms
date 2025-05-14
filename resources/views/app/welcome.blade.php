{{-- 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else

        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <h1 class="mb-1 font-medium">Let's get started</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Laravel has an incredibly rich ecosystem. <br>We suggest starting with the following.</p>
                    <ul class="flex flex-col mb-4 lg:mb-6">
                        <li class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute">
                            <span class="relative py-1 bg-white dark:bg-[#161615]">
                                <span class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
                                    <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
                                </span>
                            </span>
                            <span>
                                Read the
                                <a href="https://laravel.com/docs" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
                                    <span>Documentation</span>
                                    <svg
                                        width="10"
                                        height="11"
                                        viewBox="0 0 10 11"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-2.5 h-2.5"
                                    >
                                        <path
                                            d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001"
                                            stroke="currentColor"
                                            stroke-linecap="square"
                                        />
                                    </svg>
                                </a>
                            </span>
                        </li>
                        <li class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:bottom-1/2 before:top-0 before:left-[0.4rem] before:absolute">
                            <span class="relative py-1 bg-white dark:bg-[#161615]">
                                <span class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
                                    <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
                                </span>
                            </span>
                            <span>
                                Watch video tutorials at
                                <a href="https://laracasts.com" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
                                    <span>Laracasts</span>
                                    <svg
                                        width="10"
                                        height="11"
                                        viewBox="0 0 10 11"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-2.5 h-2.5"
                                    >
                                        <path
                                            d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001"
                                            stroke="currentColor"
                                            stroke-linecap="square"
                                        />
                                    </svg>
                                </a>
                            </span>
                        </li>
                    </ul>
                    <ul class="flex gap-3 text-sm leading-normal">
                        <li>
                            <a href="https://cloud.laravel.com" target="_blank" class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                                Deploy now
                            </a>
                        </li>
                    </ul>
                </div>

            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>

--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $school->name }} - Powered by YourRange School Management System">

        <title>{{ $school->name }} | School Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        @endif

        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            .school-primary {
                background-color: {{ $school->primary_color ?? '#2563eb' }};
            }
            .school-secondary {
                background-color: {{ $school->secondary_color ?? '#1e40af' }};
            }
        </style>
    </head>
    <body class="font-sans bg-gray-50 text-gray-900 antialiased">
        <!-- Navigation -->
        <header class="fixed w-full bg-white shadow-sm z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @if($school->logo)
                            <img src="{{ asset('tenancy/assets/' . $school->logo) }}" alt="{{ $school->name }} Logo" class="h-10">
                        @else
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        @endif
                        <span class="ml-2 text-2xl font-bold text-gray-800">{{ $school->name }}</span>
                    </div>
                    <nav class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-blue-600 transition">Features</a>
                        <a href="#admissions" class="text-gray-600 hover:text-blue-600 transition">Admissions</a>
                        <a href="#academics" class="text-gray-600 hover:text-blue-600 transition">Academics</a>
                        <a href="#contact" class="text-gray-600 hover:text-blue-600 transition">Contact</a>
                    </nav>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                                        Enroll Now
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="pt-32 pb-20 hero-gradient">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 text-white mb-12 md:mb-0">
                        <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Welcome to {{ $school->name }}</h1>
                        <p class="text-xl md:text-2xl mb-8 opacity-90">{{ $school->motto ?? 'Excellence in Education' }}</p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="#admissions" class="px-8 py-4 bg-white text-blue-600 font-bold rounded-lg text-center hover:bg-gray-100 transition duration-300">
                                Apply Now
                            </a>
                            <a href="#tour" class="px-8 py-4 border-2 border-white text-white font-bold rounded-lg text-center hover:bg-white hover:bg-opacity-10 transition duration-300">
                                Take a Virtual Tour
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        @if($school->hero_image)
                            <img src="{{ asset($school->hero_image) }}" alt="{{ $school->name }}" class="rounded-xl shadow-2xl border-8 border-white">
                        @else
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="School Building" class="rounded-xl shadow-2xl border-8 border-white">
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- School Highlights -->
        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $school->established_year ?? '1995' }}</div>
                        <div class="text-gray-600">Established</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $school->student_count ?? '1200+' }}</div>
                        <div class="text-gray-600">Students</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $school->teacher_count ?? '80+' }}</div>
                        <div class="text-gray-600">Qualified Teachers</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $school->facility_count ?? '25+' }}</div>
                        <div class="text-gray-600">Modern Facilities</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose {{ $school->name }}</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover what makes our school community special</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Academic Excellence</h3>
                        <p class="text-gray-600">Our rigorous curriculum and dedicated faculty ensure students achieve their highest potential.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Holistic Development</h3>
                        <p class="text-gray-600">We nurture students' intellectual, physical, social and emotional growth.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Inclusive Community</h3>
                        <p class="text-gray-600">We celebrate diversity and foster a welcoming environment for all students.</p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Modern Facilities</h3>
                        <p class="text-gray-600">State-of-the-art classrooms, labs, and sports facilities enhance learning.</p>
                    </div>
                    
                    <!-- Feature 5 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Affordable Education</h3>
                        <p class="text-gray-600">Quality education with flexible payment options and scholarship programs.</p>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="bg-white p-8 rounded-xl shadow-md feature-card transition duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Parent Engagement</h3>
                        <p class="text-gray-600">YourRange portal keeps parents informed and involved in their child's education.</p>
                    </div>
                </div>
            </div>
        </section>
                <!-- Academics Section -->
                <section id="academics" class="py-20 bg-white">
                    <div class="container mx-auto px-6">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Our Academic Programs</h2>
                            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive curriculum designed for student success</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach($school->programs as $program)
                            <div class="bg-gray-50 p-8 rounded-xl">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-center text-gray-800 mb-3">{{ $program->name }}</h3>
                                <p class="text-gray-600 text-center">{{ $program->description }}</p>
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:text-blue-800">Learn more →</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
        
                <!-- Admissions Section -->
                <section id="admissions" class="py-20 bg-blue-600 text-white">
                    <div class="container mx-auto px-6">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 mb-12 md:mb-0">
                                <h2 class="text-3xl md:text-4xl font-bold mb-6">Admissions Process</h2>
                                <p class="text-xl opacity-90 mb-8">Join our community of learners and achievers</p>
                                <div class="space-y-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-white bg-opacity-20">
                                                <span class="text-white font-bold">1</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium">Submit Application</h4>
                                            <p class="opacity-90">Complete our online application form with required documents</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-white bg-opacity-20">
                                                <span class="text-white font-bold">2</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium">Assessment</h4>
                                            <p class="opacity-90">Student assessment to determine grade placement</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-white bg-opacity-20">
                                                <span class="text-white font-bold">3</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium">Interview</h4>
                                            <p class="opacity-90">Family interview with school administration</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-white bg-opacity-20">
                                                <span class="text-white font-bold">4</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium">Enrollment</h4>
                                            <p class="opacity-90">Complete registration and payment process</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/2 md:pl-12">
                                <div class="bg-white p-8 rounded-xl text-gray-800">
                                    <h3 class="text-2xl font-bold mb-6">Request Information</h3>
                                    <form class="space-y-4">
                                        <div>
                                            <label for="parent-name" class="block text-gray-700 mb-2">Parent Name</label>
                                            <input type="text" id="parent-name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="student-name" class="block text-gray-700 mb-2">Student Name</label>
                                            <input type="text" id="student-name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="admission-email" class="block text-gray-700 mb-2">Email Address</label>
                                            <input type="email" id="admission-email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="grade" class="block text-gray-700 mb-2">Grade Applying For</label>
                                            <select id="grade" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option>Pre-Kindergarten</option>
                                                <option>Kindergarten</option>
                                                <option>Elementary (Grades 1-5)</option>
                                                <option>Middle School (Grades 6-8)</option>
                                                <option>High School (Grades 9-12)</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                                            Submit Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        
                <!-- Testimonials Section -->
                <section class="py-20 bg-gray-50">
                    <div class="container mx-auto px-6">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What Our Community Says</h2>
                            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Hear from parents, students, and teachers about their experiences</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach($school->testimonials as $testimonial)
                            <div class="bg-white p-8 rounded-xl shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center">
                                        @for($i = 0; $i < $testimonial->rating; $i++)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-6 italic">"{{ $testimonial->content }}"</p>
                                <div class="flex items-center">
                                    <img class="w-12 h-12 rounded-full mr-4" src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->author }}">
                                    <div>
                                        <h4 class="font-bold text-gray-800">{{ $testimonial->author }}</h4>
                                        <p class="text-gray-600">{{ $testimonial->role }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
        
                <!-- Virtual Tour Section -->
                <section id="tour" class="py-20 bg-white">
                    <div class="container mx-auto px-6">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 mb-12 md:mb-0 md:pr-12">
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Explore Our Campus</h2>
                                <p class="text-xl text-gray-600 mb-8">Take a virtual tour of our facilities and learning environments</p>
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Interactive 360° views</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Video walkthroughs</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Meet our faculty</span>
                                    </li>
                                </ul>
                                <a href="#" class="mt-8 inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                                    Start Virtual Tour
                                </a>
                            </div>
                            <div class="md:w-1/2">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-xl overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="School Classroom" class="object-cover w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <button class="w-16 h-16 bg-white bg-opacity-75 rounded-full flex items-center justify-center hover:bg-opacity-100 transition">
                                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        
                <!-- Contact Section -->
                <section id="contact" class="py-20 bg-gray-50">
                    <div class="container mx-auto px-6">
                        <div class="text-center mb-16">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Contact Us</h2>
                            <p class="text-xl text-gray-600 max-w-3xl mx-auto">We'd love to hear from you</p>
                        </div>
                        
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/2 mb-12 md:mb-0">
                                <div class="bg-white p-8 rounded-xl shadow-sm">
                                    <h3 class="text-xl font-bold text-gray-800 mb-6">School Information</h3>
                                    <div class="space-y-6">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mt-1">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-medium text-gray-800">Address</h4>
                                                <p class="text-gray-600">{{ $school->address }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mt-1">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-medium text-gray-800">Phone</h4>
                                                <p class="text-gray-600">{{ $school->phone }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mt-1">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-medium text-gray-800">Email</h4>
                                                <p class="text-gray-600">{{ $school->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mt-1">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-medium text-gray-800">Office Hours</h4>
                                                <p class="text-gray-600">Monday - Friday: 8:00 AM - 4:00 PM</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/2 md:pl-12">
                                <div class="bg-white p-8 rounded-xl shadow-sm">
                                    <h3 class="text-xl font-bold text-gray-800 mb-6">Send Us a Message</h3>
                                    <form class="space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="contact-name" class="block text-gray-700 mb-2">Your Name</label>
                                                <input type="text" id="contact-name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label for="contact-email" class="block text-gray-700 mb-2">Email Address</label>
                                                <input type="email" id="contact-email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="contact-subject" class="block text-gray-700 mb-2">Subject</label>
                                            <input type="text" id="contact-subject" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="contact-message" class="block text-gray-700 mb-2">Message</label>
                                            <textarea id="contact-message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                                            Send Message
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        
                <!-- Map Section -->
                <div class="h-96 bg-gray-200">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215209179035!2d-73.98784468459382!3d40.74844047932799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzU0LjQiTiA3M8KwNTknMTkuNyJX!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
        
                <!-- Footer -->
                <footer class="bg-gray-900 text-gray-400 py-12">
                    <div class="container mx-auto px-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div>
                                <div class="flex items-center mb-4">
                                    @if($school->logo)
                                        <img src="{{ asset($school->logo) }}" alt="{{ $school->name }} Logo" class="h-8">
                                    @endif
                                    <span class="ml-2 text-xl font-bold text-white">{{ $school->name }}</span>
                                </div>
                                <p class="mb-4">{{ $school->short_description }}</p>
                                <div class="flex space-x-4">
                                    <a href="#" class="text-gray-400 hover:text-white transition">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-white transition">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-white transition">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-4">Quick Links</h3>
                                <ul class="space-y-2">
                                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                                    <li><a href="#academics" class="hover:text-white transition">Academics</a></li>
                                    <li><a href="#admissions" class="hover:text-white transition">Admissions</a></li>
                                    <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-4">Resources</h3>
                                <ul class="space-y-2">
                                    <li><a href="#" class="hover:text-white transition">Calendar</a></li>
                                    <li><a href="#" class="hover:text-white transition">Parent Portal</a></li>
                                    <li><a href="#" class="hover:text-white transition">Lunch Menu</a></li>
                                    <li><a href="#" class="hover:text-white transition">School Policies</a></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-4">Newsletter</h3>
                                <p class="mb-4">Subscribe to our newsletter for updates and announcements</p>
                                <form class="flex">
                                    <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-md focus:outline-none">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition">
                                        Subscribe
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                            <p>&copy; {{ date('Y') }} {{ $school->name }}. All rights reserved. Powered by <a href="https://yourrange.com" class="text-blue-400 hover:text-blue-300">YourRange</a></p>
                        </div>
                    </div>
                </footer>
                @if (Route::has('login'))
                    <div class="h-14.5 hidden lg:block"></div>
                @endif
            </body>
        </html>