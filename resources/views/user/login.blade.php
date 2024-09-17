<x-layout>

    {{-- <div class="h-screen flex items-center justify-center"> --}}
        <x-ui.card class="mt-20">
            <x-slot:header>
                <x-ui.title>Login</x-ui.title>
            </x-slot:header>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-2">
                    <x-ui.form.input label="Email" name="email" value="{{ old('email', $user->email) }}" />
                </div>

                <div class="mt-2">
                    <x-ui.form.input label="Password" name="password" type="password" value="{{ old('password', $user->password) }}" />
                </div>

                <!-- form controls -->
                <div class="flex items-center gap-2 mt-8">
                    <x-ui.button variant="dark">Login</x-ui.button>
                    <x-ui.link variant="light" href="/">Cancel</x-ui.link>
                </div>

            </form>
        </x-ui.card>
    {{-- </div> --}}
</x-layout>
