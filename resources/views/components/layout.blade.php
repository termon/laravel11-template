<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Laravel11</title>
        @livewireStyles
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body class="flex min-h-screen flex-col">
        <header>
            <x-ui.nav class="bg-slate-50">
                <x-ui.nav.title>Laravell11</x-ui.nav.title>

                <x-ui.nav.link class="px-2" active="home" href="/">
                    Home
                </x-ui.nav.link>
                
                <x-ui.nav.drop label="About">                    
                    <x-ui.nav.drop.link class="px-2" active="about" :href="route('about')">About</x-ui.nav.drop.link>
                    <x-ui.nav.drop.link class="px-2" active="contact" :href="route('contact')">Contact</x-ui.nav.drop.link>
                </x-ui.nav.drop>
               

                <x-slot:right>
                    <x-ui.nav.drop position="left">
                        <x-slot:title>                            
                            @guest
                                <div class="flex items-center"> 
                                    <x-ui.nav.link href="{{route('azure.login')}}">Azure Login</x-ui.nav.link>
                                    <x-ui.nav.link href="{{route('login')}}">Local Login</x-ui.nav.link>
                                    <x-ui.nav.link href="{{route('register')}}">Local Register</x-ui.nav.link>
                                </div>
                                @endguest 
                                @auth
                                    <x-ui.avatar class="h-6 w-6" />
                                    <div class="py-1.5 text-gray-400 text-xs">
                                        ({{ auth()?->user()?->name }}) 
                                    </div> 
                                @endauth
                        </x-slot>

                        @auth
                            <form method="post" action="{{ route('logout') }}" class="flex gap-2 p-0 m-0">
                                @csrf   
                                <x-ui.nav.button type="submit">
                                    Logout
                                </x-ui.nav.button>
                            </form>
                        @endauth
                    </x-ui.nav.drop>
                </x-slot>
            </x-ui.nav>
        </header>


        <main class="container mx-auto my-2 flex-grow">
            {{ $slot }}
        </main>

        <footer class="border-t-2 bg-gray-50 border-gray-100 py-2 px-4 text-center">
            Copyright@ Ulster University {{ date("Y") }}
        </footer>
        
        @livewireScripts
    </body>
</html>
