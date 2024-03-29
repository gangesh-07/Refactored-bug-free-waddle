<?php

/*
    Development Exercise

      The following code is poorly designed and error prone. Refactor the objects below to follow a more SOLID design.
      Keep in mind the fundamentals of MVVM/MVC and Single-responsibility when refactoring.

      Further, the refactored code should be flexible enough to easily allow the addition of different display
        methods, as well as additional read and write methods.

      Feel free to add as many additional classes and interfaces as you see fit.

      Note: Please create a fork of the https://github.com/BrandonLegault/exercise repository and commit your changes
        to your fork. The goal here is not 100% correctness, but instead a glimpse into how you
        approach refactoring/redesigning bad code. Commit often to your fork.

*/

$dir = dirname(__DIR__, 1);
//$dir .='/data/Helper.php'
include_once $dir.'/data/Helper.php';
include_once 'IPlayer.php';
include_once $dir.'/dataFormat/CliFormat.php';
include_once $dir.'/dataFormat/HtmlFormat.php';

class PlayersObject implements IPlayer {

  
    //helper class for reading data
    private $helper; 

    // For Formatting data or views
    //private $dataFormat; removing this style
    private $cliFormat;
    private $htmlFormat;
    

    public function __construct() {

        // getting the instance
        $this->helper = new Helper();
        $this->cliFormat = new CliFormat();
        $this->htmlFormat = new HtmlFormat();
    }

    /**
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading players in 'file' mode.
     * @return string json
     */

     //This function only returns static values for array and json(because initialized by those values)
     //if($this->datasource is not null, meaning the object already has Json values. which can be used to read)
    function readPlayers($source, $filename = null) {

        $playerData = [];
        try {
                $playerData =  $this->helper->getdata($source,$filename);
          }
          //catch exception of unknown source
          catch(Exception $e) {
            return throw new Exception ("Unknown Source");
          }
        return $playerData;
    }

    /**
     * @param $source string Where to write the data. 'json', 'array' or 'file'
     * @param $filename string Only used if we're writing in 'file' mode
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     */
    function writePlayer($source, $player, $filename = null) {
        
        try 
        {
            $this->helper->writedata($source, $player, $filename);
        }
      //catch exception of unknown source
        catch(Exception $e)
        {
            return throw new Exception ("Unknown Source");
        }
    }

    function display($isCLI, $source, $filename = null) {

        try
        {
            $players = $this->readPlayers($source, $filename);
        }
          //catch exception of unknown source
        catch(Exception $e) 
        {
            echo 'Message: ' .$e->getMessage();
            return;
        }
       
        //echo $this->dataFormat->disp($isCLI,$players);
        // changed the design for displaying content;

        if ($isCLI) 
        {
          echo $this->cliFormat->display($players);
        } 
        else
        {
          echo $this->htmlFormat->display($players);
        }
    }

}

?>