<?php
/**
 * p12t PHP Framework : /system/core/benchmark.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Description of benchmark
 *
 * @author hepper
 */
class Benchmark extends SingeltonObject{

    static public function set($name) {
        return self::setInOrder($name, microtime(true)*1000);
    }

    public static function display() {
        Benchmark::set('end');
        $_this =& self::getInstance();

        $out = '<div id="benchmark-container">';
        $out .= '<h3>Benchmark</h3>';
        $out .= '<table>';
        $out .= '<tr>';
        $out .= '<th>Name</th>';
        $out .= '<th>Time</th>';
        $out .= '<th>Leg Time</th>';
        $out .= '</tr>' . "\n";
        
        $start = $_this->values[0]['start'];
        $last  = $_this->values[0]['start'];
        

        foreach ($_this->values as $value) {
            $out .= '<tr>';
            foreach ($value as $name => $time) {
                $out .= '<td>' . $name . '</td>';
                $out .= '<td>' . ($time - $start) . ' ms</td>';
                $out .= '<td>' . ($time - $last) . ' ms</td>';
                $last = $time;

            }
            $out .= '</tr>' . "\n";

        }

        $out .= '</table>';
        $out .= '</div>';

        return $out;
    }
}
?>
