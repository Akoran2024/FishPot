@extends('layouts.admin')

@section('header', 'Vista General')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Card 1 -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
        <div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Usuarios Totales</p>
            <h3 class="text-3xl font-black text-slate-900">1,245</h3>
            <p class="text-emerald-500 text-xs font-bold mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +12% este mes
            </p>
        </div>
        <div class="p-4 bg-primary-50 rounded-2xl text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <!-- Stats Card 2 -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
        <div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Ventas Hoy</p>
            <h3 class="text-3xl font-black text-slate-900">540€</h3>
            <p class="text-emerald-500 text-xs font-bold mt-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +5% vs ayer
            </p>
        </div>
        <div class="p-4 bg-accent-50 rounded-2xl text-accent-600 group-hover:bg-accent-500 group-hover:text-primary-950 transition-colors duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <!-- Stats Card 3 -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
        <div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Pedidos Pendientes</p>
            <h3 class="text-3xl font-black text-slate-900">12</h3>
            <p class="text-amber-500 text-xs font-bold mt-2 flex items-center">
                Requieren atención
            </p>
        </div>
        <div class="p-4 bg-amber-50 rounded-2xl text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
    </div>
    
     <!-- Stats Card 4 -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-lg transition-all duration-300">
        <div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Productos</p>
            <h3 class="text-3xl font-black text-slate-900">85</h3>
            <p class="text-slate-400 text-xs font-bold mt-2 flex items-center">
                En catálogo
            </p>
        </div>
        <div class="p-4 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Activity -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-6 flex items-center">
            <span class="w-2 h-8 bg-primary-600 rounded-full mr-3"></span>
            Actividad Reciente
        </h3>
        <div class="space-y-6">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Nuevo usuario registrado</p>
                    <p class="text-xs text-slate-500 mt-1">Hace 5 minutos &bull; Juan Pérez</p>
                </div>
            </div>
             <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Nueva compra #12345</p>
                    <p class="text-xs text-slate-500 mt-1">Hace 2 horas &bull; 45.00€</p>
                </div>
            </div>
             <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Stock bajo: Señuelos Rapala</p>
                    <p class="text-xs text-slate-500 mt-1">Hace 4 horas &bull; Quedan 2 unidades</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions or Chart Placeholder -->
    <div class="bg-primary-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-primary-800 rounded-full opacity-50 blur-3xl"></div>
        <div class="relative z-10">
            <h3 class="text-xl font-black mb-6">Mareas de Hoy</h3>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 mb-6">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-primary-300 font-bold mb-1">Próxima Pleamar</p>
                        <p class="text-4xl font-black">14:30</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs uppercase tracking-widest text-primary-300 font-bold mb-1">Coeficiente</p>
                        <p class="text-2xl font-black">85</p>
                    </div>
                </div>
            </div>
            <button class="w-full bg-accent-500 hover:bg-accent-400 text-primary-950 py-4 rounded-xl font-black transition-colors shadow-lg shadow-accent-950/20">
                Ver Tabla Completa
            </button>
        </div>
    </div>
</div>
@endsection