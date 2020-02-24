<?php
if(isset($_GET['page'])) {
    switch(htmlspecialchars($_GET['page'])) {
        case "visi":
            include ('templates/' . activeTemplate . '/pages/all_films.page.php');
            break;
        case "apie":
            include ("templates/" . activeTemplate . "/pages/about.page.php");
            break;
        case "paieska":
            include ("templates/" . activeTemplate . "/pages/search.page.php");
            break;
        case "zanrai":
            include ("templates/" . activeTemplate . "/pages/filter_films_by_genre.page.php");
            break;
        case '/':
            include ("templates/" . activeTemplate . "/pages/home.page.php");
            break;
        case "filmu-valdymas":
            include ("templates/" . activeTemplate . "/pages/movie_mode.page.php");
            break;
        case "zanru-valdymas":
            include ("templates/" . activeTemplate . "/pages/edit_genre.page.php");
            break;
        case "profilio-valdymas":
            include ("templates/" . activeTemplate . "/pages/login.page.php");
            break;
        default:
            break;
    }
} else {
    include ("templates/" . activeTemplate . "/pages/home.page.php");
}