<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

<head>
    @include('components.main.head')

    <style>
        /* 1. Alpine Cloak */
        [x-cloak] { display: none !important; }

        /* 2. Custom Scrollbar (Biar kerasa Premium) */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #282a36; }
        ::-webkit-scrollbar-thumb { background: #44475a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #6272a4; }

        /* 3. Animasi Fade In (Pengganti animate-[fade-in]) */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }

        /* 4. Animasi Gradient Teks (Pengganti config theme.extend) */
        @keyframes gradient-move {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-text {
            background-size: 200% auto;
            -webkit-background-clip: text; 
            background-clip: text;
            color: transparent; 
            animation: gradient-move 3s linear infinite;
        }

        /* 5. Blob Animation (Buat background yang gerak-gerak) */
        @keyframes blob-bounce {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob-bounce 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200 text-base-content overflow-x-hidden selection:bg-primary selection:text-primary-content">

    <div id="splash-screen" 
         class="fixed inset-0 z-[9999] flex flex-col items-center justify-center 
                bg-base-100/90 backdrop-blur-xl transition-all duration-700 ease-in-out">
        
        <div class="relative flex flex-col items-center justify-center space-y-8">
            <div class="absolute top-0 -left-10 w-40 h-40 bg-primary/20 rounded-full mix-blend-screen filter blur-3xl opacity-60 animate-blob"></div>
            <div class="absolute bottom-0 -right-10 w-40 h-40 bg-secondary/20 rounded-full mix-blend-screen filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>

            <span class="loading loading-infinity loading-lg text-primary scale-[2]"></span>
            
            <div class="text-center z-10 space-y-2">
                <h1 class="text-4xl font-extrabold tracking-widest">
                    {{ __('seo.app_name') }}
                </h1>
                <p class="text-xs font-bold tracking-[0.3em] text-base-content/50 uppercase">
                    {{ __('seo.tagline') }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex flex-min-h-screen">
        <main class="flex-grow w-full mx-auto animate-fade-in">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('splash-screen');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                splash.classList.add('opacity-0', 'pointer-events-none', 'scale-105');
            }, 600);
        });

        // Handle BFCache (Back Button Issue)
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                document.getElementById('splash-screen').classList.add('opacity-0', 'pointer-events-none');
            }
        });
        
        // Reset splash on unload (SPA feel)
        window.addEventListener('beforeunload', () => {
            const splash = document.getElementById('splash-screen');
            splash.classList.remove('opacity-0', 'pointer-events-none', 'scale-105');
        });

        function closeAllModals(el) {
            document.querySelectorAll("dialog.modal").forEach(modal => {
                if (modal.open) modal.close();
            });
        }
    </script>
</body>
</html>