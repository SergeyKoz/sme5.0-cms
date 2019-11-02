<?php
/**
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Stat
 * @subpackage classes.web.controls
 * @access public
 */
class StatCollectorControl extends Control {
    var $ClassName = "StatCollectorControl";
    var $Version = "1.0";

    /**
    * Method executes on control load
    * @access   public
    **/
    function ControlOnLoad()
    {
        DataFactory::GetStorage(&$this, "StatTable", "statStorage", true, "stat");
        $remote_host = $this->get_client_info();
        $st_host = (strlen($remote_host['client_hostname']) > 0) ?
            $remote_host['client_hostname'] : $remote_host['client_ip'];
        $st_ref = $_SERVER['HTTP_REFERER'];
        $st_ua = $_SERVER['HTTP_USER_AGENT'];
        $st_uri = $_SERVER['REQUEST_URI'];
        preg_match('/^(.*?:\/\/.*?\/)/i', $st_ref, $matches);
        $st_ref_domain = (isset($matches[1])) ?
            $matches[1] : $st_ref;

        $SQL = sprintf("
            INSERT INTO %s
            (
                remote_host, request_url, referer_domain,
                referer, user_agent, visit_date
            )
            VALUES (
                '%s', '%s', '%s',
                '%s', '%s', NOW()

            )",
            $this->statStorage->getTable("StatTable"),
            $st_host, addslashes($st_uri), addslashes($st_ref_domain),
            addslashes($st_ref), addslashes($st_ua)
        );
        $this->statStorage->Connection->ExecuteNonQuery($SQL);
    }

     /**
     * @desc Client info
     * @return array
    */
    function get_client_info()
    {
        $result = array();
        $result['client_ip'] = null;
        $result['client_hostname'] = null;
        $result['proxy_ip'] = null;
        $result['proxy_hostname'] = null;
        if (isset( $_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $result['client_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $result['proxy_ip'] = $_SERVER['REMOTE_ADDR'];
            //$result['client_hostname'] = gethostbyaddr($result['client_ip']);
            //$result['proxy_hostname'] = gethostbyaddr($result['proxy_ip']);

            $result['client_hostname'] = $result['client_ip'];
            $result['proxy_hostname'] = $result['proxy_ip'];

        } else {
            $result['client_ip'] = $_SERVER['REMOTE_ADDR'];
            //$result['client_hostname'] = gethostbyaddr($result['client_ip']);

            $result['client_hostname'] = $result['client_ip'];
        }
        return $result;
    }
} // class

?>