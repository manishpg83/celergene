<!-- Sidebar -->
<div x-data="{ open: false }"
    class="flex h-full bg-white border-r transition-all duration-500 ease-in-out"
    :class="{ 'w-64': open, 'w-20': !open }"
    @mouseenter="open = true" @mouseleave="open = false"
    style="box-shadow: 0 .125rem .5rem 0 rgba(47, 43, 61, .12);">
<div class="flex flex-col flex-1 overflow-y-auto">
   <!-- Sidebar Header (Logo) -->
   <div class="flex items-center justify-center h-16 bg-purple-600">
       <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 d="M13 10V3L4 14h7v7l9-11h-7z"/>
       </svg>
   </div>
   <!-- Sidebar Links -->
   <nav class="flex-1 px-2 py-4 space-y-2">
       <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
           <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
           </svg>
           <span class="ml-3" x-show="open">Dashboard</span>
       </a>
       <a href="{{ route('admin.vendors.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
           <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
           </svg>
           <span class="ml-3" x-show="open">Vendor</span>
       </a>
       <a href="{{ route('admin.entities.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
           <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
           </svg>
           <span class="ml-3" x-show="open">Entities</span>
       </a>
       <a href="{{ route('admin.customer.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
           <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
           </svg>
           <span class="ml-3" x-show="open">Customers</span>
       </a>
   </nav>
</div>
</div>
