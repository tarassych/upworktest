<?php

class Network {

	private $network_size = null; // count of network elements
	private $matrix = array(); // incidence matrix

	function __construct($network_size = null) {

		if (!$network_size) throw new Exception('Network size param is empty');
		elseif ( !is_int($network_size) ) throw new Exception('Network Size must be integer');
		elseif ( is_int($network_size) && intval($network_size) <= 0 ) throw new Exception('Network Size must be integer and positive value');
		else {
			// all good, network size is bigger than 0 and integer
			// lets init network elements

			$this->network_size = intval($network_size);
			$this->init_matrix();
		}
	}


	// init matrix, list elements, no connection between elements on start
	private function init_matrix()
	{
		if ( $this->network_size > 0 ) {
			for( $i = 1; $i <= $this->network_size; $i++ ){
				$this->matrix[$i] = array();
			}
		}
		else throw new Exception('Init failed. Wrong network size value.');
	}

	// connect two elements, set connection to 1 in the matrix
	public function connect($first_el, $second_el)
	{
		if ( !is_int($first_el) || intval($first_el) <= 0 ) throw new Exception('Connect failed. First element number must be integer and positive');
		else if ( !is_int($second_el) || intval($second_el) <= 0 ) throw new Exception('Connect failed. Second element number must be integer and positive');

		$this->matrix[$first_el][] = $second_el;
		$this->matrix[$second_el][] = $first_el;

		return true;
	}

	// check connection between elements
	// returns true or false
	public function query($first_el, $second_el)
	{
		if ( !is_int($first_el) || intval($first_el) <= 0 ) throw new Exception('Query failed. First element number must be integer and positive');
		else if ( !is_int($second_el) || intval($second_el) <= 0 ) throw new Exception('Query failed. Second element number must be integer and positive');


		if ( intval($first_el) > $this->network_size ) throw new Exception('Query failed. First element number can not be bigger than network size');
		else if ( intval($second_el) > $this->network_size ) throw new Exception('Query failed. Second element number can not be bigger than network size');

		if ( intval($first_el) ==  intval($second_el) ) throw new Exception('Query failed. First and second elements numbers can not be same value');

		return $this->find_path($first_el, $second_el);
	}

	// recursive path search function
	private function find_path($start_el, $stop_el, $checked_elements = array())
	{
	    //echo 'testing '.$start_el.' '.$stop_el.' '.implode('-', $checked_elements)."<br>";

	    if ( $start_el == $stop_el ) return true; // path found


        if ( isset($this->matrix[$start_el]) && is_array($this->matrix[$start_el]) && sizeof($this->matrix[$start_el]) > 0 )
        {
	        // start element exists and it has some connections with other elements
            $start_el_connections = $this->matrix[$start_el];

            if ( in_array($stop_el, $start_el_connections) )
            {
                return true; // connection between two elements found
            }
            else
            {
                $checked_elements[] = $start_el; // add checked elements into list to prevent dead loops

                foreach ( $start_el_connections as $next_el )
                {
                    if ( in_array($next_el, $checked_elements) ) continue; // skip checked elements

                    if ( $this->find_path($next_el, $stop_el, $checked_elements) )
                    {
                        return true; // path found somwhere deep inside recursive functions
                    }
                    else
                    {
                        continue; // continue checking other element connections
                    }
                }

                return false;
            }

        }
        else
        {
            return false; // element has no connections
        }

	}

	// print matrix variable
	public function print_network()
	{
        print_r($this->matrix);
	}



}

?>