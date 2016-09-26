<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/City.php";
    require_once __DIR__."/../src/Flight.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=airlines';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cities' => City::getAll()));
    });


    $app->post("/", function() use ($app) {
        $new_name = $_POST['new_city'];
        $new_city = new City ($new_name);
        $new_city->save();
        return $app['twig']->render('index.html.twig', array('cities' => City::getAll()));
    });

    $app->get("/cities", function() use ($app) {
        $selected_city = City::find($city_id);
        return $app['twig']->render('city.html.twig', array('flights' => $selected_city->getFlights, 'city' => $selected_city));
    });

    $app->post("/cities", function() use ($app) {
        $city_id = $_POST['city_id'];
        $selected_city = City::find($city_id);
        return $app['twig']->render('city.html.twig', array('flights' => $selected_city->getFlights(), 'city' => $selected_city));
    });

    return $app;
?>
