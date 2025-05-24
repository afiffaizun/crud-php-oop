

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/config/Database.php';
    require_once __DIR__ . '/models/UserModel.php';
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
        header('Location: home.php');
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
    ?>

    <?php if (isset($flashMessage)): ?>
        <div
            class="fixed top-4 right-4 px-4 py-2 rounded-md <?= $flashMessage['type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?> text-white">
            <?= $flashMessage['message'] ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST"
        class="bg-white rounded-lg shadow-xl text-sm text-gray-500 border border-gray-200 p-8 py-12 w-80 sm:w-[352px]">
        <p class="text-2xl font-medium text-center">
            <span class="text-indigo-500">Akun</span> Login
        </p>

        <div class="mt-4">
            <label class="block">Username</label>
            <input type="text" name="username" placeholder="masukkan username..." required
                class="border border-gray-200 rounded w-full p-2 mt-1 outline-indigo-500">
        </div>

        <div class="mt-4">
            <label class="block">Password</label>
            <input type="password" name="password" placeholder="masukkan password..." required
                class="border border-gray-200 rounded w-full p-2 mt-1 outline-indigo-500">
        </div>

        <button type="submit"
            class="bg-indigo-500 hover:bg-indigo-600 transition-all text-white w-full py-2 rounded-md mt-4 cursor-pointer">
            Login
        </button>
    </form>
</body>

</html>