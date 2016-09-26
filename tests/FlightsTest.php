<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";
    require_once 'src/Flight.php';

    $server = 'mysql:host=localhost;dbname=airlines_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class FlightTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          City::deleteAll();
          Flight::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $id = null;
            $arrive = "Portland";
            $depart = "LA";
            $dtime = "12:00:00";
            $duration = '3';


            $test_Flight = new Flight($id, $arrive, $depart, $dtime, $duration);
            $test_Flight->save();

            //Act
            $result = Flight::getAll();

            //Assert
            $this->assertEquals($test_Flight, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $id = null;
            $arrive = "Portland";
            $depart = "LA";
            $dtime = 5;
            $duration = 3;
            $id2 = null;
            $arrive2 = "NY";
            $depart2 = "Portland";
            $dtime2 = 7;
            $duration2 = 8;
            $test_City = new City($id, $arrive, $depart, $dtime, $duration);
            $test_City->save();
            $test_City2 = new City($id2, $arrive2, $depart2, $dtime2, $duration2 );
            $test_City2->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals([$test_City, $test_City2], $result);
        }

        function test_find()
        {
            //Arrange
            $id = null;
            $arrive = "Portland";
            $depart = "LA";
            $dtime = "12:00:00";
            $duration = 3;
            $id2 = null;
            $arrive2 = "NY";
            $depart2 = "Portland";
            $dtime2 = "15:00:00";
            $duration2 = 8;
            $test_Flight = new Flight($id, $arrive, $depart, $dtime, $duration);
            $test_Flight->save();
            $test_Flight2 = new Flight($id2, $arrive2, $depart2, $dtime2, $duration2 );
            $test_Flight2->save();
            //Act
            $result = Flight::find($test_Flight->getId());

            //Assert
            $this->assertEquals($test_Flight, $result);
        }
    }
?>
