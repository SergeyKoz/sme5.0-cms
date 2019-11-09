<?php
/**
 * $Id: IPAuthenticator.php,v 1.2 2010/11/29 09:33:33 skozin Exp $
 *
 * @package IPAuthenticator
 * @author Moxiecode
 * @copyright Copyright � 2007, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class handles MCImageManager IPAuthenticator stuff.
 *
 * @package IpAuthenticator
 */
class Moxiecode_IPAuthenticator extends Moxiecode_ManagerPlugin {
	/**#@+
	 * @access public
	 */

	/**
	 * ..
	 */
	function IPAuthenticator() {
	}

	/**
	 * ..
	 */
	function onAuthenticate(&$man) {
		$config = $man->getConfig();
		$ipNums = split(',', $config['IPAuthenticator.ip_numbers']);
		$currentIP = $this->_ip2int($_SERVER["REMOTE_ADDR"]);

		foreach ($ipNums as $ip) {
			$ipRange = split('-', $ip);

			if (count($ipRange) == 1 && $this->_ip2int($ipRange[0]) == $currentIP)
				return true;

			if (count($ipRange) == 2 && $currentIP >= $this->_ip2int($ipRange[0]) && $currentIP <= $this->_ip2int($ipRange[1]))
				return true;
		}

		return false;
	}

	function _ip2int($addr) {
		$ips = split("\.", $addr);
		return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
	}
}

// Add plugin to MCManager
$man->registerPlugin("IPAuthenticator", new Moxiecode_IPAuthenticator());
?>