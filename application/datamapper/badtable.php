<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Table Extension for DataMapper classes.
 *
 * Quickly turn DM Objects into HTML Tables
 *
 * @license 	MIT License
 * @category	DataMapper Extensions
 * @author  	Jim Wardlaw
 * @link    	http://www.stucktogetherwithtape.com/code/
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_Badtable Class
 */
class DMZ_Badtable {

	#####################################
	## METHODS TO GENERATE HTML TABLES ##
	#####################################

   /**
	* Method will return records currently in
	* '$object->all' array as an html table
	*
	* @access	public
	* @param	obj		-	instance of the DM Object calling this extension
	* @param	object	-	reference to instance of badtable object
	* @param	array	-	array of fields to add to table as columns
	* @return	obj
	*/
	public function table($object, &$badtable, $columns='')
	{
		if(empty($columns))
			// extract all fields from validation array
			// into the columns array if it is empty
			$columns = $object->fields;
			
		// add table heading
		$this->table_heading($object, $badtable, $columns);
		
		$this->table_body($object, $badtable, $columns);
		//$badtable->from_dmz($object, $columns);
		
		return TRUE;
	}

   /**
	* Constructs the table heading
	*
	* @access	private
	* @param	string
	* @return	string
	*/
	private function table_heading($object, &$badtable, $columns='')
	{
		// array of head cell strings
		$header = array();
	
		// loop through column array
		foreach($columns as $key => $field)
		{
			// look to see if this column has a heading
			// defined in the key
			if (!is_numeric($key))
			{
				$header[] = $key;
			}
			// see if field is present in validation array
			else if (isset($object->validation[$field]['label']))
			{
				$header[] = $object->validation[$field]['label'];
			}
			else
			{
				// add blank heading
				$header[] = NULL;
			}
		}
		
		// add headers
		$badtable->set_heading($header);
	}

   /**
	* Constructs the table body
	*
	* @access	private
	* @param	string
	* @return	string
	*/
	private function table_body($object, &$badtable, $columns='')
	{
		// blast through dm all array
		foreach($object->all as $obj)
		{
			// ini row array
			$row = array();
			
			foreach($columns as $field)
			{
				$row[] = $badtable->get_cell_value($obj, $field);
			}
			
			$badtable->add_row($row, array('id' => $obj->id));
		}
	}
}