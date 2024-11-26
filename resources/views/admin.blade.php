<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">
    <!-- Back Button -->
    <div class="absolute top-0 left-0 m-6">
        <button onclick="history.back()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Back
        </button>
    </div>

    <!-- Main Container -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-4xl w-full mt-20">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Admin Dashboard</h1>

        <!-- Role Assignment Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Assign Roles</h2>
            <form action="{{ route('assign.role') }}" method="POST" class="space-y-4">
                @csrf
                <!-- User Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-medium">Select User</label>
                    <select name="user_id" id="user_id" class="block w-full border border-gray-300 rounded p-2" required>
                        @foreach(App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium">Select Role</label>
                    <select name="role" id="role" class="block w-full border border-gray-300 rounded p-2" required>
                        @foreach(App\Models\Role::all() as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Assign Role
                </button>
            </form>
        </div>

        <!-- User Management Section -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Manage Users</h2>
            <table class="table-auto w-full bg-gray-100 rounded shadow">
                <thead>
                    <tr class="bg-gray-200 text-gray-800">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Roles</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(App\Models\User::all() as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('remove.role', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        Remove Roles
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
