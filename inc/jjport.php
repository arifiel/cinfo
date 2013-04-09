<?php
/** 
 * Include xmlrpc library
 * 
 * Site of the project: http://phpxmlrpc.sourceforge.net/
 * 
 */
include('xmlrpc.inc');

/** 
 * LiveJournal Port
 * 
 * @author: Andrey Nikishaev
 * @site: http://andreynikishaev.livejournal.com
 */
class port {
	var $POST;
	var $cli;

	/**
	 * Create XML-RPC Client
	 *
	 */
	public function __construct() {
		//create XML-RPC Client
		$this->cli= new xmlrpc_client("/interface/xmlrpc", "www.livejournal.com", 80);
		//set connection encoding to UTF-8
		$this->cli->request_charset_encoding = "UTF-8";
		//set data encoding to UTF-8
		$GLOBALS['xmlrpc_internalencoding']='UTF-8';
	}
	/**
	 * Add value to the post array
	 *
	 * @param string $key
	 * @param string $value
	 * @param string $type
	 */
	public function add($key, $value, $type) {
		$this->POST[$key]=new xmlrpcval($value, $type);
	}
	/**
	 * Send data to the server.
	 *
	 * @return array
	 */
	public function send() {
			//making tag "struct"
            $struct = array(new xmlrpcval($this->POST, "struct"));
			//start event "LJ.XMLRPC.postevent"
			$f = new xmlrpcmsg('LJ.XMLRPC.postevent', $struct);
			//send data
			$r = $this->cli->send($f);
			//check ansver
			if(!$r->faultCode())
			{
				$v = php_xmlrpc_decode($r->value());
				return $v;
			}
			else
			{
                $err=Array(
	                'errorcode'=>$r->faultCode(),
	                'errortext'=>$r->faultString()
                );
                return $err;
			}
			
		
	}
}