<?php
session_start();
require('dbconnect.php');
if (!isset($_SESSION['username'])) {
    header("location:login-form.php");
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location:login-form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pongsakorn.F web</title>
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
    <main class="container-fluid bg-black-800 bg-center bg-no-repeat bg-cover">
        <?php if (isset($_SESSION['username'])) { ?>
            <!-- Welcom msg & Weather -->
            <main class="py-6 px-4 grid md:grid-cols-1 bg-[url('https://cdn.pixabay.com/photo/2016/07/09/07/48/blue-sky-1505848_960_720.jpg')] bg-cover bg-no-repeat bg-center">
                <article class="bg-white/70 backdrop-blur-md rounded-lg shadow-black/60 shadow-imageShadow flex flex-col justify-center justify-self-center md:w-[50vw] flex-wrap pb-3">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-deepBlue text-white w-full p-3">Daily Weather</h1>
                    <div class="text-center my-2 p-2">
                        <label for="search" class="md:text-2xl font-bold text-lg">Province</label>
                        <input type="text" name="search-place" id="search-province" placeholder="Type province in TH" class="rounded-md ring-1 ring-black my-2 bg-white mx-3 p-1 text-center">
                        <button type="submit" id="confirm-search" class="rounded-md bg-black text-white py-1 px-2">Go!</button>
                    </div>
                    <div class="grid grid-cols-2 my-2 text-center px-3">
                        <!-- Temperature -->
                        <div class="col-span-1 md:text-3xl bg-white m-2 rounded my-2">
                            <h1 class="font-bold text-deepBlue">Temperature</h1>
                            <div>
                                <h1 id="temp-cel" class="text-center text-2xl md:text-5xl"></h1>
                            </div>
                        </div>
                        <!-- Humidity -->
                        <div class="col-span-1 md:text-3xl bg-white m-2 rounded my-2 ">
                            <h1 class="font-bold text-deepBlue">Humidity</h1>
                            <div>
                                <h1 id="humidity" class="text-center text-2xl md:text-5xl"></h1>
                            </div>
                        </div>
                        <!-- Weather condition -->
                        <div class="col-span-2 md:text-3xl bg-white m-2 rounded my-2 ">
                            <h1 class="font-bold text-deepBlue">Weather condition</h1>
                            <div>
                                <h1 id="condition" class="text-center text-2xl md:text-5xl"></h1>
                            </div>
                        </div>
                    </div>
                </article>
            </main>

            <!-- Profile -->
            <main class="py-6 px-4 grid md:grid-cols-6 bg-skyBlue relative">
                <!-- Profile pic -->
                <picture data-faded-bottom class="md:w-[15vw] w-[30vw] place-self-center md:col-span-1 m-2 transtition-all duration-700 opacity-0">
                    <img src="./img/6D80E5D1-1C71-48B2-AF98-F276C4DA2856.jpg" alt="" class="rounded-xl hover:scale-[1.05] transition-all duration-500 shadow-imageShadow shadow-black/60">
                </picture>
                <!-- Personal info -->
                <article data-faded-top class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-2 m-2 rounded-xl shadow-imageShadow shadow-black/60 opacity-0 relative">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-waterBlue text-white w-full p-3">Pongsakorn Pattakor</h1>
                    <ul class="md:text-2xl pb-5 pr-8 pl-8">
                        <li><span class="font-bold">Nickname :</span> First (1st)</li>
                        <li><span class="font-bold">Age :</span> 26</li>
                        <li><span class="font-bold">Birth date :</span> 09/09/1998</li>
                        <li><span class="font-bold">Gender :</span> Male</li>
                        <li><span class="font-bold">Personalities :</span>
                            <ul class="list-[disc] list-inside md:text-lg">
                                <li>Calm</li>
                                <li>Friendly</li>
                                <li>Optimistic</li>
                                <li>Reasonable</li>
                            </ul>
                        </li>
                        <li><span class="font-bold">Languages :</span>
                            <ul class="list-[disc] list-inside md:text-lg ">
                                <li>Thai : Native</li>
                                <li>English : Good in reading & listening</li>
                                <li class="list-none ml-6 font-bold">
                                    <button class="bg-seaBlue p-1 text-white rounded-md" data-modal-target="modal-toeic" onclick="showModal()">TOEIC score = 625</button>
                                </li>
                            </ul>
                        </li>
                        <li><span class="font-bold">Educational backgrounds :</span>
                            <ul class="list-[disc] list-inside md:text-lg ">
                                <li>Bacheler degree : Prince of Songkhla University</li>
                                <li class="list-none ml-6">GPAX = 3.50 <strong>(First-class honor)</strong></li>
                                <li>High school eduction : Phuketwittayalai school</li>
                                <li class="list-none ml-6">GPAX = 3.17 </li>
                            </ul>
                        </li>
                    </ul>
                </article>
                <!-- About me -->
                <article data-faded-right class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-3 m-2 rounded-xl shadow-imageShadow shadow-black/60 opacity-0 h-fit">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-waterBlue text-white w-full p-3">About Me</h1>
                    <div class="flex flex-col place-self-center pb-5 pr-8 pl-8">
                        <p class="text-xl md:text-2xl my-4"> <span class="md:text-4xl text-3xl">Nice to meet you,</span> my name is Pongsakorn Pattakor.
                            I am highly interested in <strong>programming</strong> and <strong>development</strong>. Although my academic background is not directly related to this field,
                            but I am confident in my ability to transfer in this career through skills and the experience I have gained in other areas.
                        </p>
                        <p class="text-xl md:text-2xl my-4">To begin my journey in Front-end Development, I have studied essential fundamental knowledges that include
                            <span class="underline font-bold"> Java (as an introductory language), HTML5, CSS, JavaScript, PHP, SQL and APIs. </span>
                            Additionally, I have worked with tools such as <span class="underline font-bold">VSCode, TailwindCSS and XAMPP.</span>
                        </p>
                        </p>
                        <p class="text-xl md:text-2xl my-4"> If given the opportunity to work in this field, I am eager to improve my programming skills along with learn additional languages and technologies that will be useful to the company.
                            I am looking forward to gain the valuable work experience in this field to improve my potential and advance my career.
                        </p>
                    </div>
                </article>
                <!-- Modal toeic -->
                <div class="absolute p-8 md:bg-slate-600/60 top-1/4 md:top-0 w-fit h-fit md:h-full md:w-full z-30 justify-center transition-all duration-500 ease-in-out opacity-0 hidden" id="modal-toeic">
                    <div class="flex flex-col content-center justify-center md:w-1/2 bg-slate-600 rounded-xl p-5">
                        <div class="my-2">
                            <h2 class="font-semibold md:text-2xl w-[50vw] text-white">My TOEIC score :</h2>
                        </div>
                        <div class="my-2">
                            <img src="./img/toeic.jpg" class="rounded-xl shadow-slate-500 shadow-imageShadow" alt="">
                        </div>
                        <div class="my-2 text-center">
                            <button class=" md:text-2xl rounded-md p-2 bg-skyBlue text-white inline-block" dat-close-modal="modal-toeic" id="close-modal">Close</button>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Skills -->
            <main class="py-6 px-4 grid md:grid-cols-2 bg-waterBlue">
                <!-- Technical -->
                <article data-faded-left class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-1 md:row-span-2 m-2 rounded-xl  shadow-imageShadow shadow-black/60 opacity-0 h-fit self-center">
                    <!-- Programming skills -->
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-skyBlue text-deepBlue w-full p-3">Programming skills</h1>
                    <div class="justify-self-center flex justify-evenly flex-wrap">
                        <img src="./png/java icon.png" title="Java" alt="" class="size-[15%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/html5 icon.png" title="HTML5" alt="" class="size-[15%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/css icon.png" title="CSS3" alt="" class="size-[15%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/Javascript icon.png" title="JavaScript" alt="" class="size-[15%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/php icon.png" title="PHP" alt="" class="size-[15%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                    </div>
                    <!-- Tools -->
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold bg-skyBlue text-deepBlue w-full p-3">Tools</h1>
                    <div class="justify-self-center flex gap-3 justify-evenly flex-wrap">
                        <img src="./png/vscode logo.png" title="VS code" alt="" class="size-[12%] my-1 hover:scale-[1.10] duration-200 place-self-center">
                        <img src="./png/tailwind logo.png" title="Tailwind CSS" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center">
                        <img src="./png/bootstrap logo.png" title="Bootstrap" alt="" class="size-[10%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/mysql icon.png" title="MySQL" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center">
                        <img src="./png/chatgpt logo.png" title="ChatGPT" alt="" class="size-[10%] my-1 hover:scale-[1.10] duration-200 place-self-center">
                        <img src="./png/xampp logo.png" title="XAMPP" alt="" class="size-[10%] my-1 hover:scale-[1.10] duration-200 place-self-center">
                        <img src="./png/firebase logo2.png" title="Firebase" alt="" class="size-[10%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                    </div>
                    <!-- Other programs -->
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold  bg-skyBlue text-deepBlue w-full p-3">Other programs</h1>
                    <div class="justify-self-center flex gap-5 justify-center flex-wrap ">
                        <img src="./png/obs icon.png" title="OBS studio" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/premiere logo.png" title="Adobe PremierePro" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/canva logo.png" title="Canva" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/Word.png" title="Microsoft Word" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/Powerpoint.png" title="Microsoft PowerPoint" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                        <img src="./png/Excel.png" title="Microsoft Excel" alt="" class="size-[13%] my-1 hover:scale-[1.10] duration-200 place-self-center rounded-full">
                    </div>
                </article>
                <!-- Soft -->
                <article data-faded-right class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-1 md:row-span-1 m-2 rounded-xl  shadow-imageShadow shadow-black/60 opacity-0 h-fit ">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-skyBlue text-deepBlue w-full p-3">Soft skills</h1>
                    <div class="flex justify-evenly my-2 flex-wrap gap-2">
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/fast learning.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Fast Learning</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png//collaborative.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Collaboration</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/Critical thinking.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Critical Thinking</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/negotiation.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Negotiation</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/adaptation.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Adaptation</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/problem solving.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-deepBlue text-white rounded-md">Problem Solving</h2>
                        </div>
                    </div>
                </article>
                <!-- Special -->
                <article data-faded-right class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-1 md:row-span-1 m-2 rounded-xl  shadow-imageShadow shadow-black/60 opacity-0 h-fit ">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-skyBlue text-deepBlue w-full p-3">Special skills</h1>
                    <div class="flex justify-evenly my-2 flex-wrap gap-2">
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/touch typing.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-skyBlue rounded-md">Touch typing</h2>
                        </div>
                        <div class="md:w-1/4 w-1/3 justify-items-center">
                            <img src="./png/computer hardware.png" alt="" class="my-1 w-1/2">
                            <h2 class="text-center font-bold md:text-xl p-1 bg-skyBlue rounded-md">PC D.I.Y building</h2>
                        </div>
                    </div>
                </article>
            </main>

            <!-- Working experience -->
            <main class="py-6 px-4 grid md:grid-cols-5 bg-grayBlue">
                <article data-faded-top class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-3 m-2 rounded-xl  shadow-imageShadow shadow-black/60 opacity-0 ">
                    <h1 class="text-center text-3xl md:text-4xl mb-2 font-bold rounded-t-lg bg-seaBlue text-white w-full p-3">Working experiences</h1>
                    <h2 class="text-center text-3xl md:text-4xl font-bold text-waterBlue">Medical Science Research & Innovation Institute</h2>
                    <h2 class="text-center text-xl md:text-2xl font-bold">Sep 2021 - Present</h2>
                    <ol class="justify-self-center list-disc text-xl md:text-2xl flex-wrap list-inside p-4 mx-6 text-deepBlue">
                        <li>Prepared the laboratory for ISO/IEC 17025: 2017 accreditation.</li>
                        <li>Participated in Proficiency Testing programs (PT) to assess and enhance laboratory performance.</li>
                        <li>Verified testing methods to ensure accuracy and reliability.</li>
                        <li>Managed quality control of testing processes from start to finish in the laboratory.</li>
                        <li>Perform microbiological analysis according to the British Pharmacopoeia 2022 standards.</li>
                        <li>Prepared documentation for pathogen acquisition in compliance with the Communicable Disease and Animal Toxins Act (2015).</li>
                        <li>Developed and documented testing procedures by translating standards from the British Pharmacopoeia 2022.</li>
                        <li>Reviewed and verified calibration results to ensure compliance with laboratory acceptance criteria.</li>
                        <li>Improve the testing procedures to make them simpler, more convenient, and faster, while maintaining compliance with standards.</li>
                    </ol>
                </article>

                <article data-faded-top class="bg-white/70 hover:bg-white transition-all duration-700 backdrop-blur-md md:col-span-2 m-2 rounded-xl  shadow-imageShadow shadow-black/60 opacity-0 ">
                </article>
            </main>
        <?php } ?>
    </main>

    <!-- Footer -->
    <footer class="container-fluid bg-black z-50 ">

    </footer>


    <script src="app.js"></script>
    <script src="api.js"></script>
</body>

</html>