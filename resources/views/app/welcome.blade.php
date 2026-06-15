<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Skoolyst SMS — Complete school management software for owners. Manage students, fees, attendance, exams, and more from one platform.">

    <title>Skoolyst SMS | School Management System for School Owners</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-display { font-family: 'Poppins', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 45%, #2563eb 100%);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(37, 99, 235, 0.25);
        }
        .gradient-text {
            background: linear-gradient(90deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .whatsapp-btn {
            background: #25D366;
        }
        .whatsapp-btn:hover {
            background: #1da851;
        }
        .site-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Navigation --}}
    <header class="site-navbar fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    @if(!empty($school->logo))
                        <img src="{{ asset('assets/' . $school->logo) }}" alt="Skoolyst" class="h-10">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/></svg>
                        </div>
                    @endif
                    <span class="text-xl font-bold text-gray-900 font-display">Skoolyst <span class="text-blue-600">SMS</span></span>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="#why" class="text-gray-700 hover:text-blue-600 transition">Why Skoolyst</a>
                    <a href="#modules" class="text-gray-700 hover:text-blue-600 transition">What We Handle</a>
                    <a href="#roles" class="text-gray-700 hover:text-blue-600 transition">For Your Team</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a>
                </nav>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition">Login</a>
                            <a href="#contact" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">Get Demo</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="hero-bg pt-28 pb-20 lg:pt-36 lg:pb-28 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-blue-200 text-sm font-medium mb-6 border border-white/20">
                        Built for School Owners & Principals
                    </span>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Run Your School Business on <span class="gradient-text">One Smart Platform</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-blue-100 mb-8 leading-relaxed max-w-xl">
                        Skoolyst SMS replaces registers, spreadsheets, and scattered tools. Manage admissions, academics, fees, attendance, exams, and parent communication — all from a single dashboard built for Pakistani schools.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#contact" class="px-8 py-4 bg-white text-blue-700 font-bold rounded-xl text-center hover:bg-blue-50 transition shadow-lg">
                            Request a Free Demo
                        </a>
                        <a href="https://wa.me/923340673401?text=Hi%20Khalid%2C%20I%20want%20to%20know%20more%20about%20Skoolyst%20SMS%20for%20my%20school." target="_blank" rel="noopener" class="whatsapp-btn px-8 py-4 text-white font-bold rounded-xl text-center transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.883 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp Us
                        </a>
                    </div>
                    <div class="mt-10 flex flex-wrap gap-6 text-sm text-blue-200">
                        <span class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 24/7 Support</span>
                        <span class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Multi-branch Ready</span>
                        <span class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Role-based Portals</span>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/20 shadow-2xl">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-5 text-gray-800">
                                <div class="text-3xl font-bold text-blue-600 mb-1">1,200+</div>
                                <div class="text-sm text-gray-500">Students Managed</div>
                            </div>
                            <div class="bg-white rounded-xl p-5 text-gray-800">
                                <div class="text-3xl font-bold text-green-600 mb-1">98%</div>
                                <div class="text-sm text-gray-500">Fee Collection Rate</div>
                            </div>
                            <div class="bg-white rounded-xl p-5 text-gray-800">
                                <div class="text-3xl font-bold text-purple-600 mb-1">80+</div>
                                <div class="text-sm text-gray-500">Teachers on Platform</div>
                            </div>
                            <div class="bg-white rounded-xl p-5 text-gray-800">
                                <div class="text-3xl font-bold text-orange-500 mb-1">12+</div>
                                <div class="text-sm text-gray-500">Modules in One App</div>
                            </div>
                        </div>
                        <p class="text-center text-blue-100 text-sm mt-4">Everything your school needs — no more juggling multiple tools</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why School Owners Need This --}}
    <section id="why" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Why Your School Needs Skoolyst SMS</h2>
                <p class="text-lg text-gray-600">Running a school is a business. You deserve software that saves time, reduces errors, and helps you grow with confidence.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">Stop Losing Money on Fees</h3>
                    <p class="text-gray-600 leading-relaxed">Track every invoice, partial payment, and outstanding balance. Your accountant gets receipts, PDF reports, and collection dashboards — no more missed collections.</p>
                </div>
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">Cut Admin Workload by Half</h3>
                    <p class="text-gray-600 leading-relaxed">Automate attendance, timetables, notices, and report cards. Your staff spends less time on paperwork and more time on education quality.</p>
                </div>
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">Keep Parents in the Loop</h3>
                    <p class="text-gray-600 leading-relaxed">Parents see attendance, fees, results, notices, and timetables from their own portal. Fewer phone calls, fewer complaints, stronger trust.</p>
                </div>
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">One Truth for Academics</h3>
                    <p class="text-gray-600 leading-relaxed">Classes, sections, subjects, teacher allocation, and timetables live in one system. No conflicting schedules or duplicate records.</p>
                </div>
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">Decisions Backed by Data</h3>
                    <p class="text-gray-600 leading-relaxed">Built-in reports for fees, attendance, exams, library, and inventory. See what is working and what needs attention — instantly.</p>
                </div>
                <div class="p-8 rounded-2xl border border-gray-100 bg-gray-50 card-hover transition duration-300">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-display">Scale Across Branches</h3>
                    <p class="text-gray-600 leading-relaxed">Opening a new campus? Skoolyst supports multi-branch setup so you manage all locations from one owner dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Handle --}}
    <section id="modules" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Everything Your School Runs On — Handled</h2>
                <p class="text-lg text-gray-600">Skoolyst SMS is a complete school ERP. Here is what you get out of the box.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach([
                    ['Students & Parents', 'Admissions, profiles, documents, parent linking'],
                    ['Teachers & Staff', 'Profiles, subject allocation, class teacher roles'],
                    ['Academic Setup', 'Classes, sections, subjects, curriculum'],
                    ['Timetable', 'Weekly schedules with teacher validation'],
                    ['Attendance', 'Daily marking, history, and reports'],
                    ['Fee Management', 'Invoices, collections, receipts, PDF reports'],
                    ['Exams & Results', 'Tests, marks entry, result cards'],
                    ['Library', 'Books catalog, issue & return tracking'],
                    ['Inventory', 'Stock in/out, low-stock alerts'],
                    ['Notices', 'Target by role, class, or whole school'],
                    ['Notifications', 'Real-time alerts in the app navbar'],
                    ['Reports & Export', 'Fees, attendance, exams, Excel export'],
                ] as $mod)
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm card-hover transition duration-300">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $mod[0] }}</h3>
                        <p class="text-sm text-gray-500">{{ $mod[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Role Portals --}}
    <section id="roles" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Dedicated Portals for Every Role</h2>
                <p class="text-lg text-gray-600">Each person sees only what they need. You stay in control as the owner.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['Admin / Owner', 'Full control — users, academics, fees, reports, school profile, branch settings', 'bg-blue-600'],
                    ['Teacher', 'Attendance, marks, timetable, assigned subjects & students', 'bg-indigo-600'],
                    ['Student', 'Timetable, results, fees, notices & notifications', 'bg-purple-600'],
                    ['Parent', 'Children\'s attendance, fees, results, books & notices', 'bg-pink-600'],
                    ['Accountant', 'Fee invoices, payment collection, receipts & financial reports', 'bg-green-600'],
                ] as $role)
                    <div class="rounded-2xl overflow-hidden shadow-md card-hover transition duration-300">
                        <div class="{{ $role[2] }} px-6 py-4">
                            <h3 class="text-lg font-bold text-white font-display">{{ $role[0] }}</h3>
                        </div>
                        <div class="bg-white px-6 py-5">
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $role[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
    <section class="py-16 bg-blue-600">
        <div class="max-w-4xl mx-auto px-4 text-center text-white">
            <h2 class="font-display text-3xl sm:text-4xl font-bold mb-4">Ready to Modernize Your School?</h2>
            <p class="text-xl text-blue-100 mb-8">Join school owners who are saving hours every week and improving parent satisfaction with Skoolyst SMS.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:skoolyst@gmail.com?subject=Skoolyst%20SMS%20Demo%20Request" class="px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition">Email for Demo</a>
                <a href="https://wa.me/923340673401?text=Hi%20Khalid%2C%20I%20want%20a%20demo%20of%20Skoolyst%20SMS." target="_blank" rel="noopener" class="whatsapp-btn px-8 py-4 text-white font-bold rounded-xl transition">Chat on WhatsApp</a>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Get in Touch</h2>
                <p class="text-lg text-gray-600">Talk directly with our team. We offer <strong>24/7 support</strong> to help you set up and grow.</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-10">
                <div class="space-y-6">
                    {{-- Contact Person --}}
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold font-display">KK</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 font-display">Khalid Khan</h3>
                                <p class="text-blue-600 font-medium">Founder & Support Lead</p>
                                <p class="text-sm text-gray-500 mt-1">Available 24/7 for school owners</p>
                            </div>
                        </div>
                        <div class="space-y-5">
                            <a href="https://maps.google.com/?q=Gulzar+E+Hijri+Scheme+33+Karachi" target="_blank" rel="noopener" class="flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-blue-600 transition">Address</div>
                                    <div class="text-gray-600">Gulzar E Hijri Scheme 33, Karachi</div>
                                </div>
                            </a>
                            <a href="https://wa.me/923340673401" target="_blank" rel="noopener" class="flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.883 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-green-600 transition">WhatsApp</div>
                                    <div class="text-gray-600">0334 0673401</div>
                                </div>
                            </a>
                            <a href="mailto:skoolyst@gmail.com" class="flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-purple-600 transition">Email</div>
                                    <div class="text-gray-600">skoolyst@gmail.com</div>
                                </div>
                            </a>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Support Hours</div>
                                    <div class="text-gray-600"><span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mr-2">24/7</span> Round-the-clock assistance for school owners</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 h-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 font-display">Request a Demo</h3>
                        <p class="text-gray-600 mb-6 text-sm">Send us a message on WhatsApp or email — we will walk you through the full system for your school.</p>
                        <div class="space-y-4">
                            <a href="https://wa.me/923340673401?text=Hi%20Khalid%2C%20I%20am%20a%20school%20owner%20interested%20in%20Skoolyst%20SMS.%20Please%20share%20demo%20details." target="_blank" rel="noopener" class="whatsapp-btn flex items-center justify-center gap-3 w-full py-4 text-white font-bold rounded-xl transition">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.883 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Message on WhatsApp — 0334 0673401
                            </a>
                            <a href="mailto:skoolyst@gmail.com?subject=Skoolyst%20SMS%20—%20Demo%20Request&body=Hi%20Khalid%2C%0A%0AI%20am%20interested%20in%20Skoolyst%20SMS%20for%20my%20school.%0A%0ASchool%20Name%3A%20%0ACity%3A%20%0AStudents%3A%20%0A%0APlease%20contact%20me." class="flex items-center justify-center gap-3 w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Email skoolyst@gmail.com
                            </a>
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="flex items-center justify-center gap-3 w-full py-4 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-blue-300 hover:text-blue-600 transition">
                                    Already a customer? Login to your portal
                                </a>
                            @endif
                        </div>
                        <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <p class="text-sm text-blue-800"><strong>Tip for school owners:</strong> Ask us for a live demo covering fees, attendance, and parent portal — we set it up around your school's actual workflow.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map --}}
    <div class="h-80 bg-gray-200">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.5!2d67.12!3d24.98!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zR3VsemFyIGUgSGijcmksIFNjaGVtZSAzMywgS2FyYWNoaQ!5e0!3m2!1sen!2spk!4v1"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Skoolyst SMS — Gulzar E Hijri Scheme 33, Karachi">
        </iframe>
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl font-bold text-white font-display">Skoolyst <span class="text-blue-400">SMS</span></span>
                    </div>
                    <p class="text-sm leading-relaxed">Complete school management software for owners who want less chaos and more growth. Based in Karachi, serving schools across Pakistan.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#why" class="hover:text-white transition">Why Skoolyst</a></li>
                        <li><a href="#modules" class="hover:text-white transition">Modules</a></li>
                        <li><a href="#roles" class="hover:text-white transition">Role Portals</a></li>
                        <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Khalid Khan — 24/7 Support</li>
                        <li>Gulzar E Hijri Scheme 33, Karachi</li>
                        <li><a href="tel:+923340673401" class="hover:text-white transition">0334 0673401</a></li>
                        <li><a href="mailto:skoolyst@gmail.com" class="hover:text-white transition">skoolyst@gmail.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Skoolyst SMS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp --}}
    <a href="https://wa.me/923340673401?text=Hi%20Khalid%2C%20I%20need%20help%20with%20Skoolyst%20SMS." target="_blank" rel="noopener"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 whatsapp-btn rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
       title="Chat on WhatsApp">
        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.883 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

</body>
</html>
