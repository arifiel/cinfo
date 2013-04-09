<?php
/*************************************************************************************
 * mumps.php
 ************************************************************************************/

$language_data = array (
	'LANG_NAME' => 'MUMPS',
	'COMMENT_SINGLE' => array(1 => '///', 2 => ' ;'),
    	//'COMMENT_SINGLE' => array(),
    
	'COMMENT_MULTI' => array(),
	//'COMMENT_MULTI' => array('/*' => '*/'),
        //'COMMENT_MULTI' => array('/*' => '*/'),


        'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
	'QUOTEMARKS' => array('"'),
	//'ESCAPE_CHAR' => '\\',
        'ESCAPE_CHAR' => '',


    'KEYWORDS' => array(
                1 => array(
			'method', 'as', 'while', 'case', 'continue', 'default', 'quit', //Операторы
			'do', 'else', 'for', 'switch', 'class'
			),
		2 => array(
			'|','.',"'", 'false', 'break', 'true', 'function', 'enum', 'extern', 'inline' //префиксы
			),
		3 => array(
			'write', 'cout' //стандартные функции
			),
		4 => array(
			'auto', 'char', 'const', 'double',  'float', 'int', 'long', //типы
			'register', 'short', 'signed', 'sizeof', 'static', 'string', 'struct',
			'typedef', 'union', 'unsigned', 'void', 'volatile', 'wchar_t'
			),
		),

    /*
        'KEYWORDS' => array(
                1 => array(
			'if', 'return', 'while', 'case', 'continue', 'default',
			'do', 'else', 'for', 'switch', 'goto'
			),
		2 => array(
			'null', 'false', 'break', 'true', 'function', 'enum', 'extern', 'inline'
			),
		3 => array(
			'printf', 'cout'
			),
		4 => array(
			'auto', 'char', 'const', 'double',  'float', 'int', 'long',
			'register', 'short', 'signed', 'sizeof', 'static', 'string', 'struct',
			'typedef', 'union', 'unsigned', 'void', 'volatile', 'wchar_t'
			),
		),
         *
         */
	'SYMBOLS' => array(
		'(', ')', '{', '}', '[', ']', '=','!', ',','"', '+', '-', '*', '/', '!', '%', '^', '&', ':'
		),
	'CASE_SENSITIVE' => array(
		GESHI_COMMENTS => true,
		1 => false,
		2 => false,
		3 => false,
		4 => false,
		),
	'STYLES' => array(
		'KEYWORDS' => array(
			1 => 'color: #0000b1;',
			2 => 'color: #000000; font-weight: bold;',
			3 => 'color: #000066;',
			4 => 'color: #993333;'
			),
		'COMMENTS' => array(
			1 => 'color: #808080; font-style: italic;',
			2 => 'color: #339933;',
			'MULTI' => 'color: #808080; font-style: italic;'
			),
		'ESCAPE_CHAR' => array(
			0 => 'color: #000099; font-weight: bold;'
			),
		'BRACKETS' => array(
			0 => 'color: #66cc66;'
			),
		'STRINGS' => array(
			0 => 'color: #ff0000;'
			),
		'NUMBERS' => array(
			0 => 'color: #cc66cc;'
			),
		'METHODS' => array(
			1 => 'color: #202020;',
			2 => 'color: #202020;'
			),
		'SYMBOLS' => array(
			0 => 'color: #66cc66;'
			),
		'REGEXPS' => array(
			),
		'SCRIPT' => array(
			)
		),
	'URLS' => array(
		1 => '',
		2 => '',
		3 => '',
		4 => ''
		),
	'OOLANG' => true,
	'OBJECT_SPLITTERS' => array(
		1 => '.',
		2 => '::'
		),
	'REGEXPS' => array(
		),
	'STRICT_MODE_APPLIES' => GESHI_NEVER,
	'SCRIPT_DELIMITERS' => array(
		),
	'HIGHLIGHT_STRICT_BLOCK' => array(
		)
);

?>
