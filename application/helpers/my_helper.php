<?php 

/**
 * Usage: $results = searcharray('searchvalue', searchkey, $array);
 **/

function searcharray($value, $key, $array) 
{
   foreach ($array as $k => $val) {
       if ($val[$key] == $value) {
           return $k;
       }
   }
   return NULL;
}

function nf($str)
{
    return number_format($str, DECIMAL_PLACES, '.', ',');
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

function decimal($str)
{
    return (bool)preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
}

function date_convert_to_mysql($date, $format = "Y-m-d")
{
    // Now convert the date field(s)
    $date = date($format, strtotime($date));
    return $date;
}

function date_convert_to_php($date, $format = "m-d-Y")
{
    // Now convert the date field(s)
    $date = date($format, strtotime($date));
    return $date;
}

function to_decimal($str)
{
    return str_replace(',', '', $str);
}
