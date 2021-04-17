<?php

namespace Cmservice\OpenWRT;

class Device {

    private static $instance;

    private $ip;
    
    private $mac;

    private $networkId;

    private $sshKey;

    private function __construct() {
        $this->ip = strtoupper(preg_replace("/\r|\n/", "", shell_exec("ip r | grep br-lan | awk '{print $7}'")));
        $this->mac = strtoupper(preg_replace("/\r|\n/", "", file_get_contents('/sys/class/net/eth0/address')));
        $this->networkId = $this->getNetworkIdFromIp($this->ip);
        $this->sshKey = $this->createOrGetSSHKey();
    }

    private function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    private static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function getIp() {
        $instance = self::getInstance();
        return $instance->ip;
    }

    public static function getMac() {
        $instance = self::getInstance();
        return $instance->mac;
    }

    public static function getNetworkId() {
        $instance = self::getInstance();
        return $instance->networkId;
    }

    public static function getSshKey() {
        $instance = self::getInstance();
        return $instance->sshKey;
    }

    private function getNetworkIdFromIp(string $ip) {
        $ipParts = explode('.', $ip);
        array_pop($ipParts);
        return implode('.', $ipParts);
    }

    private function createOrGetSSHKey() {
        $output = shell_exec("dropbearkey -y -f /etc/dropbear/id_rsa || dropbearkey -t rsa -f /etc/dropbear/id_rsa;");
        $startPos = strripos($output, 'ssh-rsa');
        $endPos = strripos($output, 'Fingerprint');
        return removeNewLineInTheEnd(substr($output, $startPos, $endPos-$startPos));
    }
}