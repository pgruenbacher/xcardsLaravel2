<?php 
return array(
/**
 * Model title
 *
 * @type string
 */
'title' => 'Cards',
/**
 * The singular name of your model
 *
 * @type string
 */
'single' => 'card',
/**
 * The class name of the Eloquent model that this config represents
 *
 * @type string
 */
'model' => 'Cards',
/**
 * The columns array
 *
 * @type array
 */
'columns' => array(
	'id' => array(
	        'title' => 'Id'
	    ),
    'id' =>array(
		'title' => 'Image',
		'output' => function($value){
			$card=Cards::find($value);
			return '<div style="width:150px">'.$card->renderThumbnail().'</div>';
		}
	),
	'setting' =>array(
		'title' => 'Type',
		'relationship'=>'cardSetting',
		'select' => "(:table).type",
	),
	'email' => array(
	        'title' => 'User Email',
	        'relationship'=>'user',
         	'select' => "(:table).email"
	    ),
    'back_text' => array(
        'title' => 'Text'
    ),
    'created_at' => array(
        'title' => 'created'
    ),
    'finished_at' => array(
        'title' => 'finished',
        'output' => function($value){
        	if($value==0){
        		return 'incomplete';
        	}
        	return date('d-m-Y',$value);
        },
    ),
),
/**
 * The edit fields array
 *
 * @type array
 */
'edit_fields' => array(
    'back_text' => array(
        'title' => 'Text',
        'type' => 'wysiwyg'
    )
),
/**
 * The filter fields
 *
 * @type array
 */
'filters' => array(
    'id',
    'setting',
    'email' => array(
        'title' => 'Email',
    ),
    'created_at' => array(
        'title' => 'Created',
        'type' => 'date',
    ),
),
);
