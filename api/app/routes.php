<?php
//Complete list of application routes

$app->get("/tweets/{screen_name:[a-zA-Z]+}/{count:[0-9]+}", "IndexController:viewFeedAction");