<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nerdyz</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center  flex-col">
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
        <div class="flex items-center justify-center p-4">
            <main class="flex flex-col lg:min-w-[500px] max-w-[700px] bg-gray-300 p-7 rounded-lg shadow-lg">
                <h1 class="text-2xl font-bold text-gray-900 text-center">Benvenuto su NERDYZ!</h1>
                <div class="my-4 border-t border-gray-400"></div> <!-- Spacer -->
                <div class="text-gray-800 mb-2 text-center">
                    Il social network per i <strong class="font-bold text-black">GAMER!</strong>
                </div>
                <div class="text-gray-800 mb-2">
                    Attualmente <strong class="font-bold text-black">NERDYZ!</strong> è ancora in fase sviluppo! La versione corrente è <strong class="font-bold text-black">ALPHA 0.0.1</strong>
                </div>
                <div class="text-gray-800 mb-2">
                    Se sei qui è perchè ti ho scelto come <strong class="font-bold text-black">TESTER</strong> e ti ringrazio in anticipo per l'apporto che darai al progetto semplicemente utilizzando il sito e comunicando i vari bug e i possibili miglioramenti da apportare.
                </div>
                <div class="text-gray-800 mb-2">
                    Per iniziare effettua il <strong class="font-bold text-black">LOG IN</strong> se hai già un account, oppure <strong class="font-bold text-black">REGISTRATI</strong> utilizzando i pulsanti in alto a destra.
                </div>
                <div class="text-gray-800 mb-2">
                    Una volta loggato, troverai nella <strong class="font-bold text-black">DASHBOARD</strong> una lista delle funzionalità attive attualmente, quelle che apporterò in futuro e tutte le restanti informazioni riguardanti il sito.
                </div>
                <div class="text-gray-800 mb-2">
                    Ti ricordo che <strong class="font-bold text-black">NERDYZ!</strong> è un progetto non a scopo di lucro, sviluppato interamente da me. Ma se hai delle idee o se vorresti partecipare attivamente a questo progetto non esitare a contattarmi <strong class="font-bold text-black">michele.lafronza91@gmail.com</strong>
                </div>
                {{-- <strong class="font-bold text-black">parole in grassetto</strong> --}}
            </main>
        </div>
        

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
