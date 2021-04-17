# cmservice/openwrt

Provides device data from routers with OpenWRT

## Installation

Install via Composer.

```
composer require cmservice/openwrt
```

## Usage

```
<?php

use OpenWRT\Device;

echo Device::getIp(); // returns device's local ip address
echo Device::getMac(); // returns device's eth0 mac 
echo Device::getNetworkId(); // returns device's network ID
echo Device::getSshKey(); // returns device's public SSH key
```