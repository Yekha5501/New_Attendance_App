<!-- resources/views/livewire/mobile-users-list.blade.php -->
 <div class="bg-white p-4 rounded-lg shadow-md ">
    <h2 class="text-lg font-semibold mb-4">Mobile Users</h2>
    <div class="flex flex-col space-y-2">
        @foreach($mobileUsers as $user)
            <div class="flex items-center">
                <div class="w-3 h-3 {{ $user['status'] == 'active' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                <span>{{ $user['name'] }}</span>
            </div>
        @endforeach
    </div>
    </div>

