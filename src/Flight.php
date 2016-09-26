<?php
class Flight

    {


    private $id;
    private $depart;
    private $arrive;
    private $dtime;
    private $duration;

    function __construct($id = null, $depart, $arrive, $dtime, $duration)
    {

        $this->id = $id;
        $this->depart = $depart;
        $this->arrive = $arrive;
        $this->dtime = $dtime;
        $this->duration = $duration;

    }

    function setDepart()
    {
        $this->depart = $depart;
    }

    function getDepart()
    {
        return $this->depart;
    }

    function setId()
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setArrive()
    {
        $this->arrive = $arrive;
    }

    function getArrive()
    {
        return $this->arrive;
    }
    function setDTime()
    {
        $this->dtime = $dtime;
    }

    function getDTime()
    {
        return $this->dtime;
    }
    function setDuration()
    {
        $this->duration = $duration;
    }

    function getDuration()
    {
        return $this->duration;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO flights (depart, arrive, dtime, duration) VALUES  ('{$this->getDepart()}', '{$this->getArrive()}', '{$this->getDTime()}', {$this->getDuration()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_flights = $GLOBALS['DB']->query("SELECT * FROM flights;");
        $flights = array();
        foreach($returned_flights as $flight) {
            $id = $flight['id'];
            $depart= $flight['depart'];
            $arrive= $flight['arrive'];
            $dtime= $flight['dtime'];
            $duration= $flight['duration'];
            $new_flight= new Flight($id, $depart, $arrive, $dtime, $duration);
            array_push($flights, $new_flight);
        }
        return $flights;
    }
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM flights;");
    }

    static function find($search_id)
        {
            $found_flight = null;
            $flights = Flight::getAll();
            foreach($flights as $flight) {
                $flight_id = $flight->getId();
                if ($flight_id == $search_id) {
                  $found_flight = $flight;
                }
            }
            return $found_flight;
        }
}
 ?>
