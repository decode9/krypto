<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Krypto Group') }}</title>

        <!-- Styles -->
        <style media="screen">
        @import url(https://fonts.googleapis.com/css?family=Expletus+Sans);

/* Basic resets */

* {
margin:0; padding:0;
box-sizing: border-box;
}

body {
    min-height: 700px;
margin: 50px auto 0;
max-width: 800px;

font-family: "Expletus Sans", sans-serif;
    background: url({{url('/')}}/img/underconstruc.jpg) no-repeat fixed center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

li {

width: 50%;
float: left;
list-style-type: none;

padding-right: 5.3333333%;
}

li:nth-child(even) { margin-bottom: 5em;}

h2 {
color: white;
}

/* Styling an indeterminate progress bar */

progress:not(value) {
/* Add your styles here. As part of this walkthrough we will focus only on determinate progress bars. */
}

/* Styling the determinate progress element */

progress[value] {
/* Get rid of the default appearance */
appearance: none;

/* This unfortunately leaves a trail of border behind in Firefox and Opera. We can remove that by setting the border to none. */
border: none;

/* Add dimensions */
width: 100%; height: 20px;

/* Although firefox doesn't provide any additional pseudo class to style the progress element container, any style applied here works on the container. */
  background-color: whiteSmoke;
  border-radius: 3px;
  box-shadow: 0 2px 3px rgba(0,0,0,.5) inset;

/* Of all IE, only IE10 supports progress element that too partially. It only allows to change the background-color of the progress value using the 'color' attribute. */
color: royalblue;

position: relative;
margin: 0 0 1.5em;
}
#content{
    position: relative;
    top:500px;
}
/*
Webkit browsers provide two pseudo classes that can be use to style HTML5 progress element.
-webkit-progress-bar -> To style the progress element container
-webkit-progress-value -> To style the progress element value.
*/

progress[value]::-webkit-progress-bar {
background-color: whiteSmoke;
border-radius: 3px;
box-shadow: 0 2px 3px rgba(0,0,0,.5) inset;
}

progress[value]::-webkit-progress-value {
position: relative;

background-size: 35px 20px, 100% 100%, 100% 100%;
border-radius:3px;

/* Let's animate this */
animation: animate-stripes 5s linear infinite;
}

@keyframes animate-stripes { 100% { background-position: -100px 0; } }

/* Let's spice up things little bit by using pseudo elements. */

progress[value]::-webkit-progress-value:after {
/* Only webkit/blink browsers understand pseudo elements on pseudo classes. A rare phenomenon! */
content: '';
position: absolute;

width:5px; height:5px;
top:7px; right:7px;

background-color: white;
border-radius: 100%;
}

/* Firefox provides a single pseudo class to style the progress element value and not for container. -moz-progress-bar */

progress[value]::-moz-progress-bar {
/* Gradient background with Stripes */
background-image:
-moz-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-moz-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -moz-linear-gradient( left, #09c, #f44);

background-size: 35px 20px, 100% 100%, 100% 100%;
border-radius:3px;

/* Firefox doesn't support CSS3 keyframe animations on progress element. Hence, we did not include animate-stripes in this code block */
}

/* Fallback technique styles */
.progress-bar {
background-color: whiteSmoke;
border-radius: 3px;
box-shadow: 0 2px 3px rgba(0,0,0,.5) inset;

/* Dimensions should be similar to the parent progress element. */
width: 100%; height:20px;
}

.progress-bar span {
background-color: royalblue;
border-radius: 3px;

display: block;
text-indent: -9999px;
}

p[data-value] {

position: relative;
}

/* The percentage will automatically fall in place as soon as we make the width fluid. Now making widths fluid. */

p[data-value]:after {
content: attr(data-value) '%';
position: absolute; right:0;
}





.html5::-webkit-progress-value,
.python::-webkit-progress-value  {
/* Gradient background with Stripes */
background-image:
-webkit-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-webkit-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -webkit-linear-gradient( left, #09c, #f44);
}

.css3::-webkit-progress-value,
.php::-webkit-progress-value
{
/* Gradient background with Stripes */
background-image:
-webkit-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-webkit-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -webkit-linear-gradient( left, #09c, #ff0);
}

.jquery::-webkit-progress-value,
.node-js::-webkit-progress-value
{
/* Gradient background with Stripes */
background-image:
-webkit-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-webkit-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -webkit-linear-gradient( left, #09c, #690);
}

/* Similarly, for Mozillaa. Unfortunately combining the styles for different browsers will break every other browser. Hence, we need a separate block. */

.html5::-moz-progress-bar,
.php::-moz-progress-bar {
/* Gradient background with Stripes */
background-image:
-moz-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-moz-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -moz-linear-gradient( left, #09c, #f44);
}

.css3::-moz-progress-bar,
.php::-moz-progress-bar {
{
/* Gradient background with Stripes */
background-image:
-moz-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-moz-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -moz-linear-gradient( left, #09c, #ff0);
}

.jquery::-moz-progress-bar,
.node-js::-moz-progress-bar {
/* Gradient background with Stripes */
background-image:
-moz-linear-gradient( 135deg,
                                                 transparent,
                                                 transparent 33%,
                                                 rgba(0,0,0,.1) 33%,
                                                 rgba(0,0,0,.1) 66%,
                                                 transparent 66%),
-moz-linear-gradient( top,
                                                    rgba(255, 255, 255, .25),
                                                    rgba(0,0,0,.2)),
 -moz-linear-gradient( left, #09c, #690);
}


        </style>
</head>
<body>
        <div id="content">
            <h2>In Progress 20%</h2>
            <progress max="100" value="20" class="html5">
                <!-- Browsers that support HTML5 progress element will ignore the html inside `progress` element. Whereas older browsers will ignore the `progress` element and instead render the html inside it. -->
                <div class="progress-bar">
                    <span style="width: 80%">20%</span>
                </div>
            </progress>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/mainFront.js') }}"></script>
</body>
</html>
