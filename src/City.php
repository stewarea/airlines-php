<?php
class City

    {

    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;

    }

    function setName()
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }

    function setId()
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO cities (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
        $cities = array();
        foreach($returned_cities as $city) {
            $name = $city['name'];
            $id = $city['id'];
            $new_city= new City($name, $id);
            array_push($cities, $new_city);
        }
        return $cities;
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM cities;");
    }

    static function find($search_id)
        {
            $found_city = null;
            $cities = City::getAll();
            foreach($cities as $city) {
                $city_id = $city->getId();
                if ($city_id == $search_id) {
                  $found_city = $city;
                }
            }
            return $found_city;
        }
    function getFlights()
    {
        $query = $GLOBALS['DB']->query("SELECT flight_id FROM trips WHERE arrive_city = {$this->getId()};");
        $query2 = $GLOBALS['DB']->query("SELECT flight_id FROM trips WHERE depart_city = {$this->getId()};");
        $arrive_ids = $query->fetchAll(PDO::FETCH_ASSOC);
        $depart_ids = $query2->fetchAll(PDO::FETCH_ASSOC);

        $flights = array();
        foreach($arrive_ids as $id) {
            $flight_id = $id['flight_id'];
            $result = $GLOBALS['DB']->query("SELECT * FROM flights WHERE id = {$flight_id};");
            $returned_flight = $result->fetchAll(PDO::FETCH_ASSOC);

            $id = $returned_flight[0]['id'];
            $depart = $returned_flight[0]['depart'];
            $arrive = $returned_flight[0]['arrive'];
            $time = $returned_flight[0]['time'];
            $duration = $returned_flight[0]['duration'];
            $new_flight = new Flight($id, $depart, $arrive, $dtime, $duration);
            array_push($flights, $new_flight);
        }
        foreach($depart_ids as $id) {
            $flight_id = $id['flight_id'];
            $result = $GLOBALS['DB']->query("SELECT * FROM flights WHERE id = {$flight_id};");
            $returned_flight = $result->fetchAll(PDO::FETCH_ASSOC);

            $id = $returned_flight[0]['id'];
            $depart = $returned_flight[0]['depart'];
            $arrive = $returned_flight[0]['arrive'];
            $time = $returned_flight[0]['time'];
            $duration = $returned_flight[0]['duration'];
            $new_flight = new Flight($id, $depart, $arrive, $dtime, $duration);
            array_push($flights, $new_flight);
        }
        return $flights;
    }

}
 ?>
