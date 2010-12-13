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
 * A simpel benchmark class to messure the frameworks speed.
 *
 * @since 0.1.0
 * @access public
 */
class Benchmark extends SingletonObject {

    /**
     * Set the current microtime for the give Leg.
     *
     * Invokes the setInOrder method and adds the microtime as an value.
     *
     * @access public
     * @param string $name The name of the leg to be messured.
     */
    static public function set($name) {
        return self::setInOrder($name, microtime(true)*1000);
    }

    /**
     * Displays the recorded messurments.
     *
     * Set the "End" messurment and render a simpel html table with the
     * benchmarks result.
     *
     * @access public
     * @return string returns the renderd html to be displayed.
     */
    public static function display() {
        Benchmark::set('End');
        $_this =& self::getInstance();

        $out = '<div id="benchmark-container">';
        $out .= '<h3>Benchmark</h3>';
        $out .= '<table>';
        $out .= '<tr>';
        $out .= '<th>Name</th>';
        $out .= '<th>Time</th>';
        $out .= '<th>Leg Time</th>';
        $out .= '</tr>' . "\n";
        
        $start = $last = $_this->values[0]['Start'];

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
