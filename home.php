<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: white;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/config/database.php';
    require_once __DIR__ . '/models/user.php';
    session_start();

    // Flash message helper
    function setFlashMessage($type, $message) {
        $_SESSION['flashMessage'] = ['type' => $type, 'message' => $message];
    }
    function getFlashMessage() {
        if (!empty($_SESSION['flashMessage'])) {
            $msg = $_SESSION['flashMessage'];
            unset($_SESSION['flashMessage']);
            return $msg;
        }
        return null;
    }

    // Logout handler
    if (isset($_GET['logout'])) {
        $userModel = new Pengguna();
        $userModel->logout();
        setFlashMessage('success', 'Berhasil logout!');
        header(header: 'Location: home.php');
        exit;
    }

    // Jika sudah login, langsung ke dashboard
    if (isset($_SESSION['user_id'])) {
        header('Location: views/dashboard.php');
        exit;
    }

    $flashMessage = getFlashMessage();

    // Proses login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $userModel = new Pengguna();
        if ($userModel->login($username, $password)) {
            header('Location: views/dashboard.php');
            exit;
        } else {
            setFlashMessage('error', 'Username atau password salah!');
            header('Location: home.php');
            exit;
        }
    }
    
    ?>    <?php if (isset($flashMessage)): ?>
        <div
            class="fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg backdrop-blur-sm <?= $flashMessage['type'] === 'success' ? 'bg-blue-500/90' : 'bg-red-500/90' ?> text-white font-medium animate-fade-in-down">
            <?= $flashMessage['message'] ?>
        </div>
    <?php endif; ?><form action="" method="POST" class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl text-sm p-8 py-12 w-96 mx-4 border border-blue-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold bg-gradient-to-r from-blue-700 to-blue-400 bg-clip-text text-transparent">
                Selamat Datang
            </h1>
            <p class="text-blue-700 mt-2">Silahkan login untuk melanjutkan</p>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-blue-800 font-medium mb-2">Username</label>
                <div class="relative">
                    <input type="text" name="username" placeholder="Masukkan username..." required
                        class="w-full px-4 py-3 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-blue-800 placeholder-blue-400">
                </div>
            </div>

            <div>
                <label class="block text-blue-800 font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Masukkan password..." required
                        class="w-full px-4 py-3 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-blue-800 placeholder-blue-400">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-700 to-blue-400 text-white py-3 rounded-lg font-medium hover:bg-blue-800 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                Login
            </button>
        </div>
    </form>
</body>

</html>