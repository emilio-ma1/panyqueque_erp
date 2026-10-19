<?php
/**
 * Login & Authentication Portal
 * Panadería y Pastelería Pan y Queque
 * Designed under Atelier Architectural ERP Standards
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/AuthService.php';

AuthService::startSession();

// If already logged in, redirect to intended target or index
if (AuthService::isLoggedIn()) {
    $target = $_GET['redirect'] ?? 'index.php';
    header("Location: {$target}");
    exit;
}

$error = null;
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Por favor ingrese su usuario y contraseña.';
    } else {
        if (AuthService::login($username, $password)) {
            $target = $_GET['redirect'] ?? 'index.php';
            header("Location: {$target}");
            exit;
        } else {
            $error = 'Credenciales no válidas. Verifique su nombre de usuario y contraseña.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema ERP | Pan y Queque</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-zinc-950 text-zinc-100 antialiased font-sans">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo Corporativo Sólido -->
        <div class="flex justify-center">
            <div class="w-12 h-12 bg-amber-600 text-white flex items-center justify-center font-bold text-xl rounded-none">
                PQ
            </div>
        </div>
        
        <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-white uppercase font-sans">
            Pan y Queque ERP
        </h2>
        <p class="mt-1 text-center text-xs font-mono text-zinc-400">
            Control Perimetral de Acceso // Autenticación de Cuentas
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-zinc-900 border border-zinc-800 p-6 sm:p-8 rounded-none shadow-none space-y-6">

            <!-- Mensaje de Error si aplica -->
            <?php if ($error): ?>
            <div class="p-3.5 bg-rose-950/80 border border-rose-800 text-rose-200 text-xs font-mono flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm text-rose-400">error</span>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-xs font-mono font-semibold uppercase tracking-wider text-zinc-300 mb-1">
                        Nombre de Usuario
                    </label>
                    <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($username); ?>" placeholder="ej. gerente, cajero, chofer..." class="w-full px-3 py-2 bg-zinc-950 border border-zinc-700 text-white text-xs font-mono rounded-none focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label for="password" class="block text-xs font-mono font-semibold uppercase tracking-wider text-zinc-300 mb-1">
                        Contraseña de Seguridad
                    </label>
                    <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-3 py-2 bg-zinc-950 border border-zinc-700 text-white text-xs font-mono rounded-none focus:outline-none focus:border-amber-500">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 text-white font-mono font-bold text-xs uppercase tracking-wider rounded-none transition-none flex items-center justify-center space-x-2">
                        <span class="material-symbols-outlined text-sm">lock_open</span>
                        <span>Ingresar al Sistema ERP</span>
                    </button>
                </div>
            </form>

            <!-- Acceso Rápido de Prueba por Rol (Demo Switcher) -->
            <div class="pt-5 border-t border-zinc-800">
                <div class="text-[11px] font-mono uppercase text-zinc-400 font-bold mb-3 flex items-center justify-between">
                    <span>Acceso Rápido por Rol:</span>
                    <span class="text-amber-500 text-[10px]">1-CLICK DEMO</span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs font-mono">
                    <button type="button" onclick="fillAndSubmit('gerente', 'admin123')" class="p-2.5 bg-zinc-950 hover:bg-zinc-800 border border-zinc-800 text-left rounded-none group transition-none">
                        <div class="font-bold text-white group-hover:text-amber-400">👑 Gerente</div>
                        <div class="text-[10px] text-zinc-500">Acceso Total</div>
                    </button>

                    <button type="button" onclick="fillAndSubmit('cajero', 'caja123')" class="p-2.5 bg-zinc-950 hover:bg-zinc-800 border border-zinc-800 text-left rounded-none group transition-none">
                        <div class="font-bold text-white group-hover:text-amber-400">💳 Cajero</div>
                        <div class="text-[10px] text-zinc-500">Caja / POS</div>
                    </button>

                    <button type="button" onclick="fillAndSubmit('chofer', 'chofer123')" class="p-2.5 bg-zinc-950 hover:bg-zinc-800 border border-zinc-800 text-left rounded-none group transition-none">
                        <div class="font-bold text-white group-hover:text-amber-400">🚚 Chofer</div>
                        <div class="text-[10px] text-zinc-500">Rutas / Despacho</div>
                    </button>

                    <button type="button" onclick="fillAndSubmit('finanzas', 'finanzas123')" class="p-2.5 bg-zinc-950 hover:bg-zinc-800 border border-zinc-800 text-left rounded-none group transition-none">
                        <div class="font-bold text-white group-hover:text-amber-400">📊 Finanzas</div>
                        <div class="text-[10px] text-zinc-500">Proveedores</div>
                    </button>
                </div>
            </div>

            <!-- Información Institucional de Red -->
            <div class="pt-4 border-t border-zinc-800/60 text-[10px] font-mono text-zinc-500 space-y-1">
                <div class="flex justify-between">
                    <span>Servidor Web ERP:</span>
                    <span class="text-zinc-400"><?php echo SERVER_WEB_ERP; ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Base de Datos:</span>
                    <span class="text-zinc-400">MariaDB 10.11 (3306)</span>
                </div>
            </div>

        </div>
    </div>

    <script>
        function fillAndSubmit(user, pass) {
            document.getElementById('username').value = user;
            document.getElementById('password').value = pass;
            document.forms[0].submit();
        }
    </script>

</body>
</html>
