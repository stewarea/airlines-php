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

    class CityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          City::deleteAll();
        //   Task::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Portland";
            $test_City = new City($name);
            $test_City->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals($test_City, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Portland";
            $name2 = "Los Angeles";
            $test_City = new City($name);
            $test_City->save();
            $test_City2 = new City($name2);
            $test_City2->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals([$test_City, $test_City2], $result);
        }
        function test_find()
        {
            //Arrange
            $name = "Portland";
            $name2 = "Los Angeles";
            $test_City = new City($name);
            $test_City->save();
            $test_City2 = new City($name2);
            $test_City2->save();
            //Act
            $result = City::find($test_City->getId());

            //Assert
            $this->assertEquals($test_City, $result);
        }
    }
?>
