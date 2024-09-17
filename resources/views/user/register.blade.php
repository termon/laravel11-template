<x-layout>


    <x-ui.card class="mt-20">
        <x-slot:header>
            <x-ui.title>Register</x-ui.title>
        </x-slot:header>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-2">
                <x-ui.form.input label="Name" name="name" value="{{ old('name') }}" />
            </div>

            <div class="mt-2">
                <x-ui.form.input label="Email" name="email" value="{{ old('email') }}" />
            </div>

            <div class="mr-2">
                <x-ui.form.input label="Password" name="password" value="{{ old('password') }}" type="password" />
            </div>

            <div class="mt-2">
                <x-ui.form.input label="Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" />
            </div>
            <div class="mt-2">
                <x-ui.form.select label="Role" name="role" value="{{ old('role') }}" :options="App\Enums\Role::options()" />
            </div>

            <div class="flex items-center gap-2 mt-4">
                <x-ui.button variant="dark">Register</x-ui.button>
                <x-ui.link variant="light" href="/">Cancel</x-ui.link>
            </div>

        </form>
    </x-ui.card>
</x-layout>
