<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ranking</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <style media="screen">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/pawel-relinski-ranking/assets/css/main.css'; ?>
  </style>
</head>
<body>
  <div id="container" class="container">
  	<div class="sidebar">
  		<div class="sidebar-header">
  			<h1>Ranking</h1>
  			<button id="toggle-button" class="toggle-button">
  				<svg viewBox="0 0 20 20" width="1em" xmlns="http://www.w3.org/2000/svg">
  					<path d="M0 5 L20 5" stroke="currentColor" fill="none" stroke-width="1.5" />
  					<path d="M0 10 L20 10" stroke="currentColor" fill="none" stroke-width="1.5" />
  					<path d="M0 15 L20 15" stroke="currentColor" fill="none" stroke-width="1.5" />
  				</svg>
  			</button>
  		</div>
  		<div id="sidebar-content" class="sidebar-content">
  			<nav>
  				<ul class="nav-list">
  					<li>
  						<a href="./athletesview.php"
                 class="nav-link">
                Sportowcy
              </a>
  					</li>
            <li>
              <a href="./DisciplinesView.php" class="nav-link">
                Dyscypliny
              </a>
            </li>
            <li>
  						<a href="./ContactView.php" class="nav-link">
                Kontakt
              </a>
  					</li>
  				</ul>
  			</nav>
  		</div>
  	</div>
  	<div class="content">
  		<main>
