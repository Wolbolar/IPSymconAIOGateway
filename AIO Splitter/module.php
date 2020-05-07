<?php
declare(strict_types=1);

require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . '/../libs/ProfileHelper.php';
require_once __DIR__ . '/../libs/ConstHelper.php';

use Fonzo\Mediola\AIOGateway;

class AIOSplitter extends IPSModule
{
	use ProfileHelper;

	// helper properties
	private $position = 0;

	public function Create()
	{
//Never delete this line!
		parent::Create();

		//These lines are parsed on Symcon Startup or Instance creation
		//You cannot use variables here. Just static values.
		$this->ConnectMultiCastSocket(); // AIO Gateway Multicast Socket

        $this->RegisterPropertyString('mac', '');
        $this->RegisterPropertyString('model', '');
        $this->RegisterPropertyString('version', '');
		$this->RegisterPropertyString("Host", "");
		$this->RegisterPropertyInteger("Port", 1902);
		$this->RegisterPropertyBoolean("Open", false);
        $this->RegisterPropertyString("User", "user");
		$this->RegisterPropertyString("Password", "");
		$this->RegisterPropertyString("gatewaytype", "V5");
		$this->RegisterPropertyString("IPSHost", "");
        $this->RegisterPropertyInteger("index", 0);
        $this->RegisterPropertyString("gatewayname", "");
        $this->RegisterPropertyString("firmware", "");
        $this->RegisterPropertyString("sid", "");

        $this->RegisterPropertyString("name", "");
        $this->RegisterPropertyString("dhcp", "");
        $this->RegisterPropertyString("sn", "");
        $this->RegisterPropertyString("gw", "");
        $this->RegisterPropertyString("dns", "");
        $this->RegisterPropertyString("swv", "");
        $this->RegisterPropertyString("rfv", "");
        $this->RegisterPropertyString("rff", "");
        $this->RegisterPropertyString("rfm", "");
        $this->RegisterPropertyString("eid", "");
        $this->RegisterPropertyString("ff", "");
        $this->RegisterPropertyString("tz", "");
        $this->RegisterPropertyString("vid", "");

        $this->RegisterAttributeString('gatewayindex', '');
        $this->RegisterAttributeString('mac', '');
        $this->RegisterAttributeString("Hardware_Version", "");
        $this->RegisterAttributeString("Hardware_Revision", "");
        $this->RegisterAttributeString("Firmware_Version", "");
        $this->RegisterAttributeString("Build", "");
        $this->RegisterAttributeString("Timezone", "");
        $this->RegisterAttributeString("Systemtime", "");
        $this->RegisterAttributeString("Longitude", "");
        $this->RegisterAttributeString("Latitude", "");
        $this->RegisterAttributeString("RGB", "");

        $this->RegisterPropertyString("mhv", "");
        $this->RegisterPropertyString("msv", "");
        $this->RegisterPropertyString("hwv", "");
        $this->RegisterPropertyString("mem", "");
        $this->RegisterPropertyString("serial", "");
        $this->RegisterPropertyString("io", "");
        $this->RegisterPropertyString("cfg", "");
	}

	public function ApplyChanges()
	{
//Never delete this line!
		parent::ApplyChanges();
		$change = false;

		$this->RegisterVariableString("BufferIN", "BufferIN", "", $this->_getPosition());
		$this->RegisterVariableString("CommandOut", "CommandOut", "", $this->_getPosition());
		$this->RegisterVariableString("HomematicIN", "Letzter Homematic Befehl", "", $this->_getPosition());
		$this->RegisterVariableString("IRIN", "Letzter IR Befehl", "", $this->_getPosition());
		$this->RegisterVariableString("FS20IN", "Letzter FS20 Befehl", "", $this->_getPosition());
		$this->RegisterVariableString("ITIN", "Letzter Intertechno Befehl", "", $this->_getPosition());
		$this->RegisterVariableString("ELROIN", "Letzter ELRO Befehl", "", $this->_getPosition());

//IP Prüfen
		$ip = $this->ReadPropertyString('Host');
        $gatewaytype = $this->GetGatewayType();
        if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
            //Profil anlegen
            $this->RegisterProfileLEDGateway("LED.AIOGateway", "Bulb", "", "");


            //Variablen anlegen
            //Color
            $this->RegisterVariableInteger("Color", $this->Translate("Color"), "LED.AIOGateway", $this->_getPosition());
            $this->EnableAction("Color");
        }
		if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $this->SendDebug("AIO Gateway", "IP valid", 0);

		} else {
            $this->SendDebug("AIO Gateway", "IP not valid", 0);
            $this->SetStatus(203); //IP Adresse ist ungültig
		}

        $this->GetConfigurationForParent();

		// Wenn I/O verbunden ist
		if ($this->HasActiveParent()) {
			$this->SetStatus(IS_ACTIVE);
		}
// Eigene Profile

// Eigene Variablen
		//Firmware und Featureset vom Gateway auslesen
		//$this->RegisterVariableString("Firmware", "");
		//$this->RegisterVariableString("Featureset", "");
		/*
		// Eigene Scripte
		$ID = $this->RegisterScript("WebHookAIOGateway", "WebHookAIOGateway", $this->CreateWebHookScript(), -8);
		IPS_SetHidden($ID, true);
		$this->RegisterHook('/hook/AIOGateway' . $this->InstanceID, $ID);
		*/
	}

	/**
	 * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
	 * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
	 *
	 *
	 */

	private function ConnectMultiCastSocket()
	{
		$Multicast_Sockets = IPS_GetInstanceListByModuleID("{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}"); // Multicast Socket
		foreach($Multicast_Sockets as $Multicast_Socket)
		{
			$ident = IPS_GetObject($Multicast_Socket)['ObjectIdent'];
			if($ident == 'AIO_GATEWAY_DISCOVERY')
			{
				$this->SendDebug('AIO Gateway IO', 'Multicast Socket is already created', 0);
			}
			else
			{
				$this->RequireParent("{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}"); // AIO Gateway Multicast Socket
                $parent = IPS_GetObject($this->InstanceID)['ParentID'];
                if($parent > 0)
                {
                    IPS_SetIdent($parent, 'AIO_GATEWAY_DISCOVERY');
                }
			}
		}
	}

	public function GetConfigurationForParent()
	{
		$gatewaytype = $this->GetGatewayType();
		if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
            $Config['Open'] = true;
			$Config['Host'] = $this->GetHostIP();
			$Config['Port'] = 1901;
			$Config['MulticastIP'] = "239.255.255.250";
			$Config['BindPort'] = 1901;
			$Config['EnableBroadcast'] = true;
			$Config['EnableReuseAddress'] = true;
			$Config['EnableLoopback'] = false;
		} else {
            $Config['Open'] = true;
			$Config['Host'] = $this->GetHostIP();
			$Config['Port'] = 1902;
			$Config['MulticastIP'] = "239.255.255.250";
			$Config['BindPort'] = 1902;
			$Config['EnableBroadcast'] = true;
			$Config['EnableReuseAddress'] = true;
			$Config['EnableLoopback'] = false;
		}
		return json_encode($Config);
	}

	private function GetGatewayType()
    {
        $gatewaytype = $this->ReadPropertyString("gatewaytype");
        return $gatewaytype;
    }

    protected function GetHostIP()
    {
        $ip = exec("sudo ifconfig eth0 | grep 'inet Adresse:' | cut -d: -f2 | awk '{ print $1}'");
        if ($ip == "") {
            $ipinfo = Sys_GetNetworkInfo();
            foreach($ipinfo as $networkcard)
            {
                $hyper_v = strpos($networkcard['Description'], 'Virtual Ethernet Adapter');
                if($networkcard['IP'] != '0.0.0.0' && $hyper_v == false)
                {
                    $ip = $networkcard['IP'];
                }
            }
        }
        return $ip;
    }


	/* System Information
	 * @return string
	 */
	public function GetSystemInformation()
	{
		$command = "XC_FNC=GetSI";
		$response = $this->SendAIOCommand($command);
		$data = json_decode($response);
		if (isset($data->XC_SUC)) {
			$info = $data->XC_SUC;
			$hardware_version = $info->HWV; // Hardware Version. Always E1 for V5 Gateways
			$this->SendDebug("AIO Gateway", "hardware version: " . $hardware_version, 0);
			$this->WriteAttributeString('Hardware_Version', $hardware_version);
			$hardware_revision = $info->HWRV; // Hardware Revision
			$this->SendDebug("AIO Gateway", "hardware_revision: " . $hardware_revision, 0);
            $this->WriteAttributeString('Hardware_Revision', $hardware_revision);
			$firmware = $info->FWV; // Firmware Version
			$this->SendDebug("AIO Gateway", "firmware: " . $firmware, 0);
            $this->WriteAttributeString('Firmware_Version', $firmware);
			$build = $info->BUILD; // Build
			$this->SendDebug("AIO Gateway", "build: " . $build, 0);
            $this->WriteAttributeString('Build', $build);
			$timezone = $info->TZ; // Timezone (in HEX)
			$this->SendDebug("AIO Gateway", "timezone: " . $timezone, 0);
            $this->WriteAttributeString('Timezone', $timezone);
			/*
			Bit
		7-6	reserved (must be kept zero)
		5	Daylight saving time
		4	1 = timezone positive, 0 = timezone negative
		3-0	Timezone
		Example: UTC+1, daylight saving enabled	100001 (21)
		*/
			$systemtime = $info->TIME; // Systemtime
			$this->SendDebug("AIO Gateway", "systemtime: " . $systemtime, 0);
            $this->WriteAttributeString('Systemtime', $systemtime);
			$longitude = $info->LONG; // Longitude (Hex) 0x020D = 52.5°
			$this->SendDebug("AIO Gateway", "longitude: " . $longitude, 0);
            $this->WriteAttributeString('Longitude', $longitude);
			$latitude = $info->LAT; // Latitude (Hex) 0x020D = 52.5°
			$this->SendDebug("AIO Gateway", "latitude: " . $latitude, 0);
            $this->WriteAttributeString('Latitude', $latitude);
			$rgb = $info->RGB; // RGB	LED Color
			$this->SendDebug("AIO Gateway", "rgb: " . $rgb, 0);
            $this->WriteAttributeString('RGB', $rgb);
			$info = ["response" => $info, "hardware_version" => $hardware_version, "hardware_revision" => $hardware_revision, "firmware" => $firmware, "build" => $build, "timezone" => $timezone, "systemtime" => $systemtime, "longitude" => $longitude, "latitude" => $latitude, "rgb" => $rgb];
			return $info;
		} else {
			$info = $data->XC_ERR;
			return $info;
		}
	}


	public function GetRoot()
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
            if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
                $root = "http://" . $aiogatewayip . "/cmd?auth=" . $GatewayPassword . "&";
            } else {
                $root = "http://" . $aiogatewayip . "/cmd?XC_USER=user&XC_PASS=" . $GatewayPassword . "&";
            }
		} else {
            if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
                $root = "http://" . $aiogatewayip . "/cmd?";
            } else {
                $root = "http://" . $aiogatewayip . "/command?";
            }
		}
		return $root;
	}

	public function SendAIOCommand($command)
	{
        $root = $this->GetRoot();
        $url = $root . $command;
        $response = file_get_contents($url);
        $this->SendDebug("Send to AIO Gateway", $url, 0);
		return $response;
	}

	/** Info Used to read the gateway's network information
	 * @return array
	 */
	public function GetInfo()
	{
	    $gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$data = file_get_contents("http://" . $aiogatewayip . "/info?auth=" . $GatewayPassword);
			} else {
				$data = file_get_contents("http://" . $aiogatewayip . "/info?XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$data = file_get_contents("http://" . $aiogatewayip . "/info");
		}
		$data = json_decode($data);
		if (isset($data->XC_SUC)) {
			$info = $data->XC_SUC;
			if (isset($info->name)) {
				$name = $info->name;
				$this->SendDebug("AIO Gateway", "Name: " . $name, 0);
                IPS_SetProperty($this->InstanceID, 'name', $name);
			}
			if (isset($info->mhv)) {
				$mhv = $info->mhv;
				$this->SendDebug("AIO Gateway", "mhv: " . $mhv, 0);
			}
			if (isset($info->msv)) {
				$msv = $info->msv;
				$this->SendDebug("AIO Gateway", "msv: " . $msv, 0);
				// $this->SetValue("Firmware_Version", $msv);
			}
			if (isset($info->hwv)) {
				$hwv = $info->hwv;
				$this->SendDebug("AIO Gateway", "hwv: " . $hwv, 0);
				// $this->SetValue("Hardware_Version", $hwv);
			}
			if (isset($info->vid)) {
				$vid = $info->vid;
				$this->SendDebug("AIO Gateway", "vid: " . $vid, 0);
                IPS_SetProperty($this->InstanceID, 'vid', $vid);
			}
			if (isset($info->mem)) {
				$mem = $info->mem;
				$this->SendDebug("AIO Gateway", "mem: " . $mem, 0);
			}
			if (isset($info->ip)) {
				$ip = $info->ip;
				$this->SendDebug("AIO Gateway", "ip: " . $ip, 0);
				// $this->SetValue("Gateway_IP", $ip);
			}
			if (isset($info->sn)) {
				$sn = $info->sn;
				$this->SendDebug("AIO Gateway", "sn: " . $sn, 0);
                IPS_SetProperty($this->InstanceID, 'sn', $sn);
			}
			if (isset($info->gw)) {
				$gw = $info->gw;
				$this->SendDebug("AIO Gateway", "gw: " . $gw, 0);
                IPS_SetProperty($this->InstanceID, 'gw', $gw);
			}
			if (isset($info->dns)) {
				$dns = $info->dns;
				$this->SendDebug("AIO Gateway", "dns: " . $dns, 0);
                IPS_SetProperty($this->InstanceID, 'dns', $dns);
			}
			if (isset($info->mac)) {
				$mac = $info->mac;
				$this->SendDebug("AIO Gateway", "mac: " . $mac, 0);
				$this->WriteAttributeString('mac', $mac);
			}
			if (isset($info->ntp)) {
				$ntp = $info->ntp;
				$this->SendDebug("AIO Gateway", "ntp: " . $ntp, 0);
			}
			if (isset($info->start)) {
				$start = $info->start;
				$this->SendDebug("AIO Gateway", "start: " . $start, 0);
			}
			if (isset($info->time)) {
				$time = $info->time;
				$this->SendDebug("AIO Gateway", "time: " . $time, 0);
			}
			if (isset($info->loc)) {
				$loc = $info->loc;
				$this->SendDebug("AIO Gateway", "loc: " . $loc, 0);
			}
			if (isset($info->serial)) {
				$serial = $info->serial;
				$this->SendDebug("AIO Gateway", "serial: " . $serial, 0);
				// $this->SetValue("Gateway_Serial", $serial);
			} else {
				$serial = "unknown";
			}
			if (isset($info->io)) {
				$io = $info->io;
				$this->SendDebug("AIO Gateway", "io: " . $io, 0);
			}
			if (isset($info->cfg)) {
				$cfg = $info->cfg;
				$this->SendDebug("AIO Gateway", "cfg: " . $cfg, 0);
			}
			if (isset($info->server)) {
				$server = $info->server;
				$this->SendDebug("AIO Gateway", "server: " . $server, 0);
			}
			if (isset($info->sid)) {
				$sid = $info->sid;
				$this->SendDebug("AIO Gateway", "sid: " . $sid, 0);
				// $this->SetValue("Gateway_SID", $sid);
			}
			if (isset($info->wifi)) {
				$wifi = $info->wifi;
				$this->SendDebug("AIO Gateway", "wifi: " . $wifi, 0);
				// $this->SetValue("Gateway_WIFI", $wifi);;
			}
            IPS_ApplyChanges($this->InstanceID);

			$device = ["name" => $name, "serial" => $serial, "mac" => $mac];
			return $device;
		} else {
			$info = $data->XC_ERR;
			$code = $info->CODE;
			$device = ["info" => $info, "code" => $code];
			return $device;
		}
	}

	/** Set Gateway Name
	 * Gateway name. Max. 16 chars
	 * @param $name
	 * @return bool|string
	 */
	public function SetName(string $name)
	{
		$response = $this->SetsConfigurationParameter("name", $name);
		return $response;
	}

	/** Set Gateway NTP
	 * IPv4 address of the ntp server
	 * @param $ntp
	 * @return bool|string
	 */
	public function SetNTP(string $ntp)
	{
		$response = $this->SetsConfigurationParameter("ntp", $ntp);
		return $response;
	}

	/** Set DHCP Server
	 * 0 or 1. Enable/disable DHCP
	 * @param string $dhcp
	 * @return bool|string
	 */
	public function SetDHCP(int $dhcp)
	{
		$response = $this->SetsConfigurationParameter("dhcp", $dhcp);
		return $response;
	}

	/** Set the IP address (IPv4 only)
	 * @param string $ip
	 * @return bool|string
	 */
	public function SetIPAddress(string $ip)
	{
		$response = $this->SetsConfigurationParameter("ip", $ip);
		return $response;
	}

	/** Set Subnet
	 * @param $subnet
	 * @return bool|string
	 */
	public function SetSubnet($subnet)
	{
		$response = $this->SetsConfigurationParameter("sn", $subnet);
		return $response;
	}


	/** Set the network gateway address (IPv4 only)
	 * @param $gateway
	 * @return bool|string
	 */
	public function SetGateway($gateway)
	{
		$response = $this->SetsConfigurationParameter("gw", $gateway);
		return $response;
	}

	/** Set the DNS server (IPv4 only)
	 * @param $dns
	 * @return bool|string
	 */
	public function SetDNS($dns)
	{
		$response = $this->SetsConfigurationParameter("dns", $dns);
		return $response;
	}

	/** Set the user password (plain text)
	 * @param $password
	 * @return bool|string
	 */
	public function SetUserpassword($password)
	{
		$response = $this->SetsConfigurationParameter("pwd", $password);
		return $response;
	}

	/** Set the admin password (plain text)
	 * @param $adminpassword
	 * @return bool|string
	 */
	public function SetAdminPassword($adminpassword)
	{
		$response = $this->SetsConfigurationParameter("apwd", $adminpassword);
		return $response;
	}

	protected function SetsConfigurationParameter($parameter, $value)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$response = file_get_contents("http://" . $aiogatewayip . "/config?" . $parameter . "=" . $value . "&auth=" . $GatewayPassword);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/config?" . $parameter . "=" . $value . "&XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/config?" . $parameter . "=" . $value);
		}
		return $response;
	}

	/** Sets Timezone
	 * @param $timezone
	 * @return bool|string
	 */
	protected function SetTimezone($timezone)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setTZ&data=" . $timezone . "&auth=" . $GatewayPassword);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setTZ&data=" . $timezone . "&XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setTZ&data=" . $timezone);
		}
		return $response;
	}

	/** Set Gateway Location
	 * @param $latitude
	 * @param $longitude
	 * @return bool|string
	 */
	protected function SetLocation($latitude, $longitude)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setLocation&lat=" . $latitude . "&long=" . $longitude . "&auth=" . $GatewayPassword);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setLocation&lat=" . $latitude . "&long=" . $longitude . "&XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/XC_FNC=setLocation&lat=" . $latitude . "&long=" . $longitude);
		}
		return $response;
	}

	/** Discovering available wifi networks
	 * @return bool|string
	 */
	public function ScanNetwork()
	{
		$aiogatewayip = $this->ReadPropertyString("Host");
		$info = file_get_contents("http://" . $aiogatewayip . "/scan");
		return $info;
	}

	/** Connecting a gateway to a wifi network
	 * @param string $ssid
	 * @param string $password
	 * @return bool|string
	 */
	public function ConnectWLAN(string $ssid, string $password)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$response = file_get_contents("http://" . $aiogatewayip . "/connect?ssid=" . $ssid . "&pwd=" . $password . "&auth=" . $GatewayPassword);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/connect?ssid=" . $ssid . "&pwd=" . $password . "&XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/connect?ssid=" . $ssid . "&pwd=" . $password);
		}
		return $response;
	}

	/** Sets the 868Mhz sensor mode
	 * @param $sensormode
	 * @return string
	 */
	protected function SetSensorMode($sensormode)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$response = file_get_contents("http://" . $aiogatewayip . "/cmd?XC_FNC=setRFM&data=" . $sensormode . "&auth=" . $GatewayPassword);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/cmd?XC_FNC=setRFM&data=" . $sensormode . "&XC_USER=user&XC_PASS=" . $GatewayPassword);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/cmd?XC_FNC=setRFM&data=" . $sensormode);
		}
		return $response;
	}


	/** Discovery
	 * @return string
	 */
	public function GatewayDiscovery()
	{
		// GET\n
		$response = "";
		return $response;
	}

	protected function GetSensorMode()
	{
		$sensormode = [];
		$sensormode[] = ["sensor_name" => "Sensor_Homematic", "sensortype" => "0D", "sensorid" => 1];
		$sensormode[] = ["sensor_name" => "Sensor_FS20", "sensortype" => "13", "sensorid" => 2];
		$sensormode[] = ["sensor_name" => "Sensor_Kopp", "sensortype" => "14", "sensorid" => 3];
		$sensormode[] = ["sensor_name" => "Sensor_Abus", "sensortype" => "15", "sensorid" => 4];
		$sensormode[] = ["sensor_name" => "Sensor_RS2W", "sensortype" => "16", "sensorid" => 5];
		$sensormode[] = ["sensor_name" => "Sensor_WIR", "sensortype" => "80", "sensorid" => 6];
		return $sensormode;
	}

	public function RequestAction($Ident, $Value)
	{

		switch ($Ident) {
			case "Color":
				switch ($Value) {
					case 0: //Off
						$this->LEDOff();
						break;
					case 1: //Green
						$this->Green();
						break;
					case 2: //Blue
						$this->Blue();
						break;
					case 3: //Red
						$this->Red();
						break;
					case 4: //Yellow
						$this->Yellow();
						break;
					case 5: //Weiß
						$this->White();
						break;
					case 6: //Purple
						$this->Purple();
						break;
					case 7: //Cyan
						$this->Cyan();
						break;
				}
				break;
			default:
				$this->SendDebug("AIOGateway", "Invalid ident", 0);
		}
	}


	private function RegisterHook($WebHook, $TargetID)
	{
		$ids = IPS_GetInstanceListByModuleID("{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}");
		if (sizeof($ids) > 0) {
			$hooks = json_decode(IPS_GetProperty($ids[0], "Hooks"), true);
			$found = false;
			foreach ($hooks as $index => $hook) {
				if ($hook['Hook'] == $WebHook) {
					if ($hook['TargetID'] == $TargetID)
						return;
					$hooks[$index]['TargetID'] = $TargetID;
					$found = true;
				}
			}
			if (!$found) {
				$hooks[] = Array("Hook" => $WebHook, "TargetID" => $TargetID);
			}
			IPS_SetProperty($ids[0], "Hooks", json_encode($hooks));
			IPS_ApplyChanges($ids[0]);
		}
	}

	private function CreateWebHookScript()
	{
		$Script = '<?
		//Test
           ?>
';
		return $Script;
	}


################## DUMMYS / WOARKAROUNDS - protected

	protected function GetParent()
	{
		$instance = IPS_GetInstance($this->InstanceID);
		return $instance['ConnectionID'];
	}

	protected function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize)
	{

		if (!IPS_VariableProfileExists($Name)) {
			IPS_CreateVariableProfile($Name, 1);
		} else {
			$profile = IPS_GetVariableProfile($Name);
			if ($profile['ProfileType'] != 1)
				$this->SendDebug("AIOGateway", "Variable profile type does not match for profile " . $Name, 0);
		}

		IPS_SetVariableProfileIcon($Name, $Icon);
		IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
		IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);

	}

	public function GetStates()
	{
        $command = "XC_FNC=GetStates";
        $response = $this->SendAIOCommand($command);
		return $response;
	}

	public function GetDevices()
	{
        $command = "XC_FNC=GetStates&Config=1";
        $response = $this->SendAIOCommand($command);
		return $response;
	}

	protected function GetTasksGateway()
	{
        $command = "XC_FNC=GetAll";
        $response = $this->SendAIOCommand($command);
		return $response;
	}

	protected function ActivateTask(int $Tasknumber) //Tasknummer 2stellig 01
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://" . $adress . "/command?XC_FNC=saveGroup&id=" . $Tasknumber . "&active=1");
	}

	protected function DeactiveTask(int $Tasknumber)
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://" . $adress . "/command?XC_FNC=saveGroup&id=" . $Tasknumber . "&active=0");
	}

	protected function DelTask(int $Tasknumber)
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://" . $adress . "/command?XC_FNC=DelTask&id=" . $Tasknumber);
	}

	protected function StartTask(int $Tasknumber)
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://" . $adress . "/command?XC_FNC=doGroup&id=" . $Tasknumber);
	}

	protected function DelAllTasks()
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://" . $adress . "/command?XC_FNC=fEEPReset&type=01");
	}

	protected function RegisterProfileLEDGateway($Name, $Icon, $Prefix, $Suffix)
	{

		if (!IPS_VariableProfileExists($Name)) {
			IPS_CreateVariableProfile($Name, 1);
		} else {
			$profile = IPS_GetVariableProfile($Name);
			if ($profile['ProfileType'] != 1)
				$this->SendDebug("AIOGateway", "Variable profile type does not match for profile " . $Name, 0);
		}
		$MinValue = 0;
		$MaxValue = 7;
		$StepSize = 1;
		IPS_SetVariableProfileIcon($Name, $Icon);
		IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
		IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
		// boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Color ) Farbwert im HTML Farbcode (z.b. 0x0000FF für Blau). Sonderfall: -1 f�r transparent
		IPS_SetVariableProfileAssociation($Name, 0, "Aus", "", 0x585858);
		IPS_SetVariableProfileAssociation($Name, 1, "Grün", "", 0x088A08);
		IPS_SetVariableProfileAssociation($Name, 2, "Blau", "", 0x013ADF);
		IPS_SetVariableProfileAssociation($Name, 3, "Rot", "", 0xFE2E2E);
		IPS_SetVariableProfileAssociation($Name, 4, "Gelb", "", 0xFFFF00);
		IPS_SetVariableProfileAssociation($Name, 5, "Weiß", "", 0xFFFFFFF);
		IPS_SetVariableProfileAssociation($Name, 6, "Violett", "", 0x8A2BE2);
		IPS_SetVariableProfileAssociation($Name, 7, "Cyan", "", 0x44D9E6);
	}

	//LED Off
	public function LEDOff()
	{
		$command = "0100";
		SetValueInteger($this->GetIDForIdent('Color'), 0);
		$this->SendDebug("AIO Gateway", "LED aus", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Green
	public function Green()
	{
		$command = "0101";
		SetValueInteger($this->GetIDForIdent('Color'), 1);
		$this->SendDebug("AIO Gateway", "LED grün", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Blue
	public function Blue()
	{
		$command = "0102";
		SetValueInteger($this->GetIDForIdent('Color'), 2);
		$this->SendDebug("AIO Gateway", "LED blau", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Red
	public function Red()
	{
		$command = "0103";
		SetValueInteger($this->GetIDForIdent('Color'), 3);
		$this->SendDebug("AIO Gateway", "LED rot", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Yellow
	public function Yellow()
	{
		$command = "0104";
		SetValueInteger($this->GetIDForIdent('Color'), 4);
		$this->SendDebug("AIO Gateway", "LED gelb", 0);
		return $this->Set_LEDGW($command);
	}

	//LED White
	public function White()
	{
		$command = "0105";
		SetValueInteger($this->GetIDForIdent('Color'), 5);
		$this->SendDebug("AIO Gateway", "LED weiß", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Purple
	public function Purple()
	{
		$command = "0106";
		SetValueInteger($this->GetIDForIdent('Color'), 6);
		$this->SendDebug("AIO Gateway", "LED violett", 0);
		return $this->Set_LEDGW($command);
	}

	//LED Cyan
	public function Cyan()
	{
		$command = "0107";
		SetValueInteger($this->GetIDForIdent('Color'), 7);
		$this->SendDebug("AIO Gateway", "LED cyan", 0);
		return $this->Set_LEDGW($command);
	}

	protected function Set_LEDGW($command)
	{
		$gatewaytype = $this->GetGatewayType();
		$GatewayPassword = $this->ReadPropertyString("Password");
		$aiogatewayip = $this->ReadPropertyString("Host");
		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS) {
				$status = file_get_contents("http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=SendSC&type=RGB&data=" . $command);
				$this->SendDebug("AIOGateway", "Senden an Gateway mit Passwort", 0);
				$this->SendDebug("Send to AIO Gateway", "http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=SendSC&type=RGB&data=" . $command, 0);
			} else {
				$status = file_get_contents("http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=RGB&data=" . $command);
				$this->SendDebug("AIOGateway", "Senden an Gateway mit Passwort", 0);
				$this->SendDebug("Send to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=RGB&data=" . $command, 0);
			}
		} else {
			$status = file_get_contents("http://" . $aiogatewayip . "/command?XC_FNC=SendSC&type=RGB&data=" . $command);
			$this->SendDebug("AIOGateway", "Senden an Gateway ohne Passwort", 0);
			$this->SendDebug("Send to AIO Gateway", "http://" . $aiogatewayip . "/command?&XC_FNC=SendSC&type=RGB&data=" . $command, 0);
		}
		return $status;
	}


	// Data an Child weitergeben
	public function ReceiveData($JSONString)
	{


		// Empfangene Daten vom I/O
		$data = json_decode($JSONString);
		$this->SendDebug("ReceiveData AIO Gateway", utf8_decode($data->Buffer), 0);

		// Hier werden die Daten verarbeitet und in Variablen geschrieben

		$this->UpdateLastResponse($data->Buffer);

		//echo utf8_decode($data->Buffer);

		// Weiterleitung zu allen Gerät-/Device-Instanzen
		$this->SendDataToChildren(json_encode(Array("DataID" => "{C8D0BA3C-CB15-A3B6-A032-C7631E324E87}", "Buffer" => $data->Buffer))); //AIOSplitter Interface GUI
	}


	################## DATAPOINT RECEIVE FROM CHILD

	// Type String, Declaration can be used when PHP 7 is available
	//public function ForwardData(string $JSONString)
	public function ForwardData($JSONString)
	{

		// Empfangene Daten von der Device Instanz
		$data = json_decode($JSONString);
		$this->SendDebug("ForwardData AIO Gateway Splitter", utf8_decode($data->Buffer->Method), 0);
		$data = $data->Buffer;
		$result = false;
		if (property_exists($data, 'Method')) {
			$method = $data->Method;
			$this->SendDebug('Method:', $method, 0);

			if ($method == "GetDevices") {
				$result = $this->GetDevices();
				$this->SendDebug('Get Devices:', $result, 0);
			}
		}
		return $result;
	}

	protected function UpdateLastResponse($payload)
	{
		$pos = stripos($payload, '{"type"');

		if ($pos) {
			$json = substr($payload, 8, strlen($payload));
			$payload = json_decode($json);

			$type = $payload->type;
			$data = $payload->data;

			switch ($type) {
				case "HM": //Homematic
					$this->SetValue("HomematicIN", $data);
					break;
				case "IR": //IR
					//$irdatacode = strstr($data, '00010');
					$num_of_timing = hexdec(substr($data, 16, 2));
					$start = $num_of_timing * 8 + 17;
					$irdatacode = substr($data, $start);
					$this->SetValue("IRIN", $data);
					$this->SendDebug("Received IR Code", $irdatacode, 0);
					break;
				case "IT": //Intertechno
					$this->SetValue("ITIN", $data);
					break;
				case "FS20": //FS20
					$this->SetValue("FS20IN", $data);
					break;
				case "EL": //ELRO
					$this->SetValue("ELROIN", $data);
					break;
			}
		}
	}

	public function RenameIO()
	{
		$parentid = $this->GetParent();
		if ($parentid > 0) {
			$aiogatewayname = IPS_GetName($this->InstanceID);
			IPS_SetName($parentid, $aiogatewayname . " IO");
		}
	}

    /***********************************************************
     * Configuration Form
     ***********************************************************/

    /**
     * build configuration form
     * @return string
     */
    public function GetConfigurationForm()
    {
        // return current form
        $Form = json_encode([
                                'elements' => $this->FormHead(),
                                'actions' => $this->FormActions(),
                                'status' => $this->FormStatus()
                            ]);
        $this->SendDebug('FORM', $Form, 0);
        $this->SendDebug('FORM', json_last_error_msg(), 0);
        return $Form;
    }

    /**
     * return form configurations on configuration step
     * @return array
     */
    protected function FormHead()
    {
        $mac = $this->ReadPropertyString('mac');
        if($mac == "")
        {
            $list_visible = false;
        }
        else{
            $list_visible = true;
        }
        $form = [
            [
                'type' => 'Image',
                'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAABLCAYAAAA1fMjoAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjY2QUI2MjE1REVGMzExRThCMzJGRjEwMzUxRUM2N0I3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjY2QUI2MjE2REVGMzExRThCMzJGRjEwMzUxRUM2N0I3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjZBQjYyMTNERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjZBQjYyMTRERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6GmGzYAAAM4UlEQVR42uxd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'
            ],
            [
                'type' => 'Select',
                'name' => 'gatewaytype',
                'caption' => 'gateway type',
                'options' => [
                    [
                        'caption' => 'Please select a gateway',
                        'value' => "Select"
                    ],
                    [
                        'caption' => 'Telefunken Gateway V1',
                        'value' => AIOGateway::V1
                    ],
                    [
                        'caption' => 'AIO Gateway V2',
                        'value' => AIOGateway::V2
                    ],
                    [
                        'caption' => 'AIO Gateway V3',
                        'value' => AIOGateway::V3
                    ],
                    [
                        'caption' => 'AIO Gateway V4',
                        'value' => AIOGateway::V4
                    ],
                    [
                        'caption' => 'AIO Gateway V4 +',
                        'value' => AIOGateway::V4PLUS
                    ],
                    [
                        'caption' => 'AIO Gateway V5',
                        'value' => AIOGateway::V5
                    ],
                    [
                        'caption' => 'AIO Gateway V5 +',
                        'value' => AIOGateway::V5PLUS
                    ],
                    [
                        'caption' => 'AIO Gateway V6 Mini',
                        'value' => AIOGateway::V6MINI
                    ],
                    [
                        'caption' => 'AIO Gateway V6 Mini E',
                        'value' => AIOGateway::V6MINIE
                    ],
                    [
                        'caption' => 'AIO Gateway V6',
                        'value' => AIOGateway::V6
                    ],
                    [
                        'caption' => 'AIO Gateway V6 E',
                        'value' => AIOGateway::V6E
                    ]
                ]
            ],
            [
                'type' => 'Label',
                'caption' => 'IP address AIO Gateway'
            ],
            [
                'name'    => 'Host',
                'type'    => 'ValidationTextBox',
                'caption' => 'IP AIO Gateway'],
            [
                'type' => 'Label',
                'caption' => 'AIO Gateway User'
            ],
            [
                'name'    => 'User',
                'type'    => 'ValidationTextBox',
                'caption' => 'AIO Gateway User'],
            [
                'type' => 'Label',
                'caption' => 'AIO Gateway Password'
            ],
            [
                'name'    => 'Password',
                'type'    => 'PasswordTextBox',
                'caption' => 'AIO Gateway Password'],
            [
                'type'     => 'List',
                'name'     => 'GatewayInformation',
                'caption'  => 'Gateway Information',
                'visible' => $list_visible,
                'rowCount' => 2,
                'add'      => false,
                'delete'   => false,
                'sort'     => [
                    'column'    => 'dhcp',
                    'direction' => 'ascending'
                ],
                'columns' => [
                    [
                        'name'    => 'dhcp',
                        'caption' => 'dhcp',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'sn',
                        'caption' => 'sn',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'gwn',
                        'caption' => 'gwn',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'dns',
                        'caption' => 'dns',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'swv',
                        'caption' => 'swv',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'rfv',
                        'caption' => 'rfv',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'rff',
                        'caption' => 'rff',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'rfm',
                        'caption' => 'rfm',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'eid',
                        'caption' => 'eid',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'ff',
                        'caption' => 'ff',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'tz',
                        'caption' => 'tz',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'vid',
                        'caption' => 'vid',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ]
                ],
                'values' => $this->GatewayListValues()
            ]
        ];
        return $form;
    }

    private function GatewayListValues()
    {
        $dhcp = $this->ReadPropertyString('dhcp');
        $sn = $this->ReadPropertyString('sn');
        $gwn = $this->ReadPropertyString('gw');
        $dns = $this->ReadPropertyString('dns');
        $swv = $this->ReadPropertyString('swv');
        $rfv = $this->ReadPropertyString('rfv');
        $rfm = $this->ReadPropertyString('rfm');
        $eid = $this->ReadPropertyString('eid');
        $ff = $this->ReadPropertyString('ff');
        $tz = $this->ReadPropertyString('tz');
        $vid = $this->ReadPropertyString('vid');
        $form =  [
            [
                'dhcp'  => $dhcp,
                'sn' => $sn,
                'gwn' => $gwn,
                'dns' => $dns,
                'swv' => $swv,
                'rfv' => $rfv,
                'rfm' => $rfm,
                'eid' => $eid,
                'ff' => $ff,
                'tz' => $tz,
                'vid' => $vid
            ]
        ];
        return $form;
    }

    private function SystemListValues()
    {
        $hardware_version = $this->ReadAttributeString('Hardware_Version');
        $hardware_revision = $this->ReadAttributeString('Hardware_Revision');
        $firmware = $this->ReadAttributeString('Firmware_Version');
        $build = $this->ReadAttributeString('Build');
        $timezone = $this->ReadAttributeString('Timezone');
        $systemtime = $this->ReadAttributeString('Systemtime');
        $longitude = $this->ReadAttributeString('Longitude');
        $latitude = $this->ReadAttributeString('Latitude');
        $rgb = $this->ReadAttributeString('RGB');
        $form =  [
            [
                'Hardware_Version'  => $hardware_version,
                'Hardware_Revision' => $hardware_revision,
                'Firmware_Version' => $firmware,
                'Build' => $build,
                'Timezone' => $timezone,
                'Systemtime' => $systemtime,
                'Longitude' => $longitude,
                'Latitude' => $latitude,
                'RGB' => $rgb
            ]
        ];
        return $form;
    }

    /**
     * return form actions by token
     * @return array
     */
    protected function FormActions()
    {
        $mac = $this->ReadAttributeString('mac');
        if($mac == "")
        {
            $listsystem_visible = false;
        }
        else{
            $listsystem_visible = true;
        }
        $gatewaytype = $this->GetGatewayType();
        if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
            $led_visible = true;
        }
        else{
            $led_visible = false;
        }

        $form = [
            [
                'type'     => 'List',
                'name'     => 'SystemInformation',
                'caption'  => 'System Information',
                'visible' => $listsystem_visible,
                'rowCount' => 2,
                'add'      => false,
                'delete'   => false,
                'sort'     => [
                    'column'    => 'Hardware_Version',
                    'direction' => 'ascending'
                ],
                'columns' => [
                    [
                        'name'    => 'Hardware_Version',
                        'caption' => 'Hardware Version',
                        'width'   => '180px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Hardware_Revision',
                        'caption' => 'Hardware Revision',
                        'width'   => '150px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Firmware_Version',
                        'caption' => 'Firmware Version',
                        'width'   => '150px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Build',
                        'caption' => 'Build',
                        'width'   => '80px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Timezone',
                        'caption' => 'Timezone',
                        'width'   => '200px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Systemtime',
                        'caption' => 'Systemtime',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Longitude',
                        'caption' => 'Longitude',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'Latitude',
                        'caption' => 'Latitude',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ],
                    [
                        'name'    => 'RGB',
                        'caption' => 'RGB',
                        'width'   => '100px',
                        'visible' => true,
                        'save' => true
                    ]
                ],
                'values' => $this->SystemListValues()
            ],
            [
                'type' => 'Label',
                'caption' => 'rename IO multicast socket with proper AIO Gateway name'
            ],
            [
                'type' => 'Button',
                'caption' => 'Rename IO Socket',
                'onClick' => 'AIOG_RenameIO($id);'
            ],
            [
                'type' => 'Label',
                'caption' => 'Get AIO Gateway Information'
            ],
            [
                'type' => 'Button',
                'caption' => 'Gateway Information',
                'onClick' => 'AIOG_GetInfo($id);'
            ],
            [
                'type' => 'Label',
                'caption' => 'AIO Gateway Get System Infomation'
            ],
            [
                'type' => 'Button',
                'caption' => 'System Information',
                'onClick' => 'AIOG_GetSystemInformation($id);'
            ],
            [
                'type' => 'Label',
                'visible' => $led_visible,
                'caption' => 'AIO Gateway LED'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Off',
                'onClick' => 'AIOG_LEDOff($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Green',
                'onClick' => 'AIOG_Green($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Blue',
                'onClick' => 'AIOG_Blue($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Red',
                'onClick' => 'AIOG_Red($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Yellow',
                'onClick' => 'AIOG_Yellow($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED White',
                'onClick' => 'AIOG_White($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Purple',
                'onClick' => 'AIOG_Purple($id);'
            ],
            [
                'type' => 'Button',
                'visible' => $led_visible,
                'caption' => 'LED Cyan',
                'onClick' => 'AIOG_Cyan($id);'
            ]
            /*
            [
                'type' => 'TestCenter'
            ]
            */
        ];
        return $form;
    }

    /**
     * return from status
     * @return array
     */
    protected function FormStatus()
    {
        $form = [
            [
                'code' => IS_CREATING,
                'icon' => 'inactive',
                'caption' => 'Creating instance.'
            ],
            [
                'code' => IS_ACTIVE,
                'icon' => 'active',
                'caption' => 'AIO gateway active.'
            ],
            [
                'code' => IS_INACTIVE,
                'icon' => 'inactive',
                'caption' => 'Interface closed.'
            ],
            [
                'code' => 201,
                'icon' => 'inactive',
                'caption' => 'Please follow the instructions.'
            ],
            [
                'code' => 202,
                'icon' => 'inactive',
                'caption' => 'AIO Gateway IP address must not be empty.'
            ],
            [
                'code' => 203,
                'icon' => 'inactive',
                'caption' => 'No valid IP address.'
            ],
            [
                'code' => 204,
                'icon' => 'error',
                'caption' => 'Connection lost to AIO Gateway.'
            ]
        ];
        return $form;
    }

	/**
	 * return incremented position
	 * @return int
	 */
	private function _getPosition()
	{
		$this->position++;
		return $this->position;
	}

	/***********************************************************
	 * Migrations
	 ***********************************************************/

	/**
	 * Polyfill for IP-Symcon 4.4 and older
	 * @param string $Ident
	 * @param mixed $Value
	 */
	protected function SetValue($Ident, $Value)
	{
		if (IPS_GetKernelVersion() >= 5) {
			parent::SetValue($Ident, $Value);
		} else if ($id = @$this->GetIDForIdent($Ident)) {
			SetValue($id, $Value);
		}
	}
}
