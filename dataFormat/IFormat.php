<?php

interface IFormat
{
   function cliFormat($players);
   function htmlFormat($players);
   function disp($cli,$players);
}

?>