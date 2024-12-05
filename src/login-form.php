<?php
session_start();
require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Chonburi&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Chakra-Petch";
        }
    </style>
</head>

<body class="h-full min-h-screen w-full grid grid-rows-[auto,1fr,10vh] md:grid-rows-[10vh,1fr,10vh] bg-gradient-to-tl from-[#220e45] to-[#145885] bg-cover bg-no-repeat justify-self-center">

    <!-- Navbar -->
    <nav class="container-fluid bg-black py-5 px-4 flex flex-col md:flex-row justify-between text-white sticky top-0 z-50 ">
        <!-- Brand -->
        <div class="md:text-4xl text-3xl self-center">
            <a href="index.php">Pongsakorn.F</a>
        </div>
        <!-- Menu link -->
        <div class="hidden md:flex self-center" id="menu-link">
            <ul class="md:flex md:gap-4 md:text-xl">
                <li class="menu-link"><a href="index.php">Home</a></li>
                <li class="menu-link"><a href="register-form.php">Register</a></li>
                <li class="menu-link"><a href="login-form.php">Log-in</a></li>
                <li class="menu-link"><a href="index.php?logout='true'">Log-out</a></li>
            </ul>
        </div>
        <!-- Hamburger menu toggle -->
        <div class="md:hidden flex justify-center my-2" id="menu-toggle">
            <button class="" onclick="menuToggle()">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden justify-center" id="mobile-menu">
            <ul class="gap-2 text-lg flex">
                <li class="text-center rounded-md p-1 transition-all duration-200 ease-in-out hover:scale-[1.10] hover:bg-white"><a href="index.php" class="text-white hover:text-black">Home</a></li>
                <li class="text-center rounded-md p-1 transition-all duration-200 ease-in-out hover:scale-[1.10] hover:bg-white"><a href="register-form.php" class="text-white hover:text-black">Register</a></li>
                <li class="text-center rounded-md p-1 transition-all duration-200 ease-in-out hover:scale-[1.10] hover:bg-white"><a href="login-form.php" class="text-white hover:text-black">Log-in</a></li>
                <li class="text-center rounded-md p-1 transition-all duration-200 ease-in-out hover:scale-[1.10] hover:bg-white"><a href="index.php?logout='true'" class="text-white hover:text-black">Log-out</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container-fluid place-content-center my-5">
        <div class="justify-self-center bg-white/50 shadow-imageShadow backdrop-blur-md rounded-md flex flex-col w-2/4 h-auto px-5 py-2 shadow-black/60 my-8">
            <h1 class="text-center text-2xl md:text-5xl pb-3">Log-in</h1>
            <!-- Login form -->
            <form action="login-db.php" method="POST">
                <?php include('errors.php') ?>
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="bg-red-500 my-3 p-2 ring ring-black rounded-md text-center text-white flex justify-self-center justify-center w-2/5">
                        <h1><?php echo $_SESSION['error'] ?></h1>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php } ?>
                <!-- Email -->
                <div class="my-2 md:text-2xl">
                    <label class="md:mx-5" for="email">E-mail</label>
                    <input type="email" name="email" class="w-full text-center rounded-md">
                </div>
                <!-- Passwor -->
                <div class="my-2 md:text-2xl">
                    <label class="md:mx-5" for="password1">Password</label>
                    <input type="password" name="password" class="w-full text-center rounded-md">
                </div>
                <div class="my-4 flex justify-self-center gap-2">
                    <h1 class="md:text-xl place-self-center">Are you a member?</h1>
                    <a href="register-form.php" class="md:text-xl p-2 bg-black text-white rounded-md hover:animate-bounce">Nahh ~</a>
                </div>
                <!-- Button -->
                <div class="my-2 md:text-xl flex gap-4 justify-self-center text-white">
                    <button type="submit" name="login-submit" class=" bg-[#378af0] rounded-md p-1 border-2 border-black shadow-2xl">Save</button>
                    <button type="reset" class="bg-[#fc2d1e] rounded-md p-1 border-2 border-black shadow-2xl">Clear</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="container-fluid bg-black ">

    </footer>

</body>

</html>