<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo constant('URL');?>public/css/error.css">
</head>

<!-- <body>
<main class="bsod container">
  <h1 class="neg title"><span class="bg">Error - 404</span></h1>
  <p>An error has occured, to continue:</p>
  <p>* Return to our homepage.<br />
  * Send us an e-mail about this error and try later.</p>
  <nav class="nav">
    <a href="#" class="link">index</a>&nbsp;|&nbsp;<a href="#" class="link">webmaster</a>
  </nav>
</main>
</body> -->




<body>
    <section class="notFound">
        <div class="img">
        <img src="https://assets.codepen.io/5647096/backToTheHomepage.png" alt="Back to the Homepage"/>
        <img src="https://assets.codepen.io/5647096/Delorean.png" alt="El Delorean, El Doc y Marti McFly"/>
        </div>
        <div class="text">
        <h1>404</h1>
        <h2>PAGE NOT FOUND</h2>
        <h3>BACK TO HOME?</h3>
        <a href="<?php echo constant('URL');?>/bodegas" class="yes">YES</a>
        <a href="">NO</a>
        </div>
    </section>
</body>
</html>