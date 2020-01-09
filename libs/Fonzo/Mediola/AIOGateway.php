<?php

namespace Fonzo\Mediola;

class AIOGateway
{
	public $DeviceInstanceID;

	function __construct($DeviceInstanceID)
	{

		$this->DeviceInstanceID = $DeviceInstanceID;
	}

	public function GetParent()
	{
		$instance = IPS_GetInstance($this->DeviceInstanceID);//array
		return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
	}

	//IP Gateway
	public function GetIPGateway()
	{
		$ParentID = $this->GetParent();
		$IPGateway = IPS_GetProperty($ParentID, 'Host');
		return $IPGateway;
	}

	public function GetPassword()
	{
		$ParentID = $this->GetParent();
		$GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
		return $GatewayPassword;
	}

	public function GetGatewaytype()
	{
		$ParentID = $this->GetParent();
		$Gatewaytype = IPS_GetProperty($ParentID, 'gatewaytype');
		return $Gatewaytype;
	}


	// API V5 A minimum firmware version of 1.0.17 is required.

	public function GetRoot()
	{
		$gatewaytype = $this->GetGatewaytype();
		$GatewayPassword = $this->GetPassword();
		$aiogatewayip = $this->GetIPGateway();
		if ($GatewayPassword !== "") {
			if ($gatewaytype == 6 || $gatewaytype == 7) {
				$root = "http://" . $aiogatewayip . "/cmd?auth=" . $GatewayPassword . "&";
			} else {
				$root = "http://" . $aiogatewayip . "/cmd?XC_USER=user&XC_PASS=" . $GatewayPassword . "&";
			}
		} else {
			$root = "http://" . $aiogatewayip . "/cmd?";
		}
		return $root;
	}

	public function SendAIOCommand($url)
	{
		$response = file_get_contents($url);
		return $response;
	}




	public function Learn($devicetype)
	{
		$gatewaytype = $this->GetGatewaytype();
		$GatewayPassword = $this->GetPassword();
		$aiogatewayip = $this->GetIPGateway();
		if ($GatewayPassword !== "") {
			if ($gatewaytype == 6 || $gatewaytype == 7) {
				$response = file_get_contents("http://" . $aiogatewayip . "/cmd?auth=" . $GatewayPassword . "&XC_FNC=learnSc&type=" . $devicetype);
			} else {
				$response = file_get_contents("http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=learnSc&type=" . $devicetype);
			}
		} else {
			$response = file_get_contents("http://" . $aiogatewayip . "/command?XC_FNC=learnSc&type=" . $devicetype);
		}
		return $response;
	}


// Sets configuration parameter
	/*config
	Parameter
	name	Gateway name. Max. 16 chars
	ntp	IPv4 address of the ntp server
	dhcp	0 or 1. Enable/disable DHCP
	ip	Set the IP address (IPv4 only)
	sn	Set the subnet
	gw	Set the network gateway address (IPv4 only)
	dns	Set the DNS server (IPv4 only)
	pwd	Set the user password (plain text)
	apwd	Set the admin password (plain text)
	*/

// Sets the timezone
//XC_FNC	setTZ
// data	Timezone in HEX (i.e. 21 for UTC+1). See GetSI

// Sets the geolocation
// cmd?XC_FNC=setLocation&lat=LATITUDE&long=LONGITUDE
	/*
	 * lat	2 Byte Hex (i.e. 13.5° east = 0087)
	long	2 Byte Hex (i.e. 52.5° north = 020D)

	 */

// Setting sensormode
// /cmd?XC_FNC=setRFM&data=SENSORMODE

	/*
	 * Data Sensormode
	Homematic	0D
	FS20	13
	KOPP	14
	ABUS	15
	RS2W	16
	WIR	80
	 */

	/*
	 * Setting LED color
	 * Data color
	off	00
	green	01
	blue	02
	red	03
	yellow	04
	white	05
	purple	06
	cyan	07
	Setting red LED color:

	GET /cmd?XC_FNC=SendSC&type=RGB&data=0103
	 */

// udp socket (udp4) on port 1901
// broadcast address 255.255.255.255 and the multicast address 239.255.255.250

// Discovering available wifi networks
//  /scan
	/*
	Response Code: 200 Type : text/html

	{"XC_SUC":
	[
	{"ssid":"mediola","enc":8,"rssi":-98},
	{"ssid":"mediola-gast","enc":4,"rssi":-36}
	]
	}
	*/




	public function SetGatewayPassword(string $password)
	{

	}

// Before the cloud access can be used a password needs to be set on the gateway
// /config?apwd=PASSWORD&pwd=PASSWORD

// A gateway is registered at the cloud service with its public key
	/*
	 *  { "XC_SUC":
		{
		  "key":"b26445463718a9e09f3b241e2b354a5b61718299167dde269407ea2b9184602",
		  "cloud":"ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff"
		}
	  }
	 */

// Registers a gateway at the mediola cloud service

	/*
	 * { "XC_SUC":
		{
		  "sid":"123456EE74563A8A89120FA674C7982C",
		  "pk":"0a412e63884d5b6c7b87930f5f007949d1138415a6e78879c1824a596b788699314"
		}
	  }
	 */

	/*
	 * When accessing the gateway over the internet any request can be executed. Simply the host has to be changed from the local IP address to https://CLOUD_SERVER/rapi/live/SID and the user has to authorized using Basic Auth using the username "user" and the gateway password.
	 */

// Enabling/disabling cloud access
	/*
	 * /config?cloud=VALUE&cserver=CLOUD_SERVER&cport=PORT&auth=PASSWORD
	 *
	 * cloud	Enable cloud access: 1
	Disable cloud access: 0
	cserver	Cloud server: v5ws.mediola.com
	cport	Cloud port: 80
	auth	Gateway password
	 */
}

class V6 extends AIOGateway
{

}

class V6E extends V6
{

}

class V6Mini extends V6
{

}

class V6MiniE extends V6
{

}

class V5 extends \stdClass
{
	const Reserved = '01';
}

class V5Plus extends V5
{

}

class V4 extends AIOGateway
{

}

class V4Plus extends V4
{

}

class V3 extends AIOGateway
{

}

class V2 extends AIOGateway
{

}

class V1 extends AIOGateway
{

}

class AIODevice
{

}

class BarthelmeChromoFlex extends \stdClass
{

}

class BeckerCentronic extends \stdClass
{
	const Reserved = '01';
	const On = '00';
	const Off = '02';
	const Up = '00';
	const Down = '00';
	const Open = '01';
	const Stop = '02';
	const Position1 = '03';
	const Position2 = '04';
	const Down3S = '05';
	const Up3S = '06';
	const Delete = '07';
	const Darker = '09';
	const Brighter = '08';
	const MaxBrightness = '03';
	const MediumBrightness = '04';
}

class Brennenstuhl extends \stdClass
{
	const Stop = '0000';
	const DimDown = '0101';
	const StepDown = '0102';
	const Off = '0102';
	const MoveDown = '0103';
	const DimUp = '0201';
	const StepUp = '0202';
	const On = '0202';
	const MoveUp = '0203';
	const DoScene = '0302';
}


class ConradRSL extends \stdClass
{

}

class Dooya extends \stdClass
{
	const MoveUp = '22';
	const MoveDown = '44';
	const StepUp = '11';
	const StepDown = '22';
	const Stop = '55';
}

class Dooya2 extends \stdClass // Kaiser Nienhaus
{

}

class GiraFunkbus extends \stdClass
{

}

class Elero extends \stdClass
{
	const Down = '00';
	const Up = '01';
	const On = '01';
	const Off = '00';
	const Stop = '02';
	const UpStepBit = '03';
	const DownStepBit = '04';
	const ManuMode = '05';
	const AutoMode = '06';
	const ToggleMode = '07';
	const Up3S = '08';
	const Down3S = '09';
	const DoubletapUp = '0A';
	const DoubletapDown = '0B';
	const StartLearning = '0C';
	const OnPulseMove = '0D';
	const OffPulseMove = '0E';
	const ASClose = '0F';
	const ASMove = '10';
}

class EnOcean extends \stdClass
{

}

class FHT80B extends \stdClass
{

}

class FS20 extends \stdClass
{
	const On = '1000';
	const Off = '0000';
	const Last = '1100';
	const Toggle = '1200';
	const DimUp = '1300';
	const DimDown = '1400';
	const Set0 = 'DIM0';
	const Set6 = '0100';
	const Set10 = '0200';
	const Set20 = '0300';
	const Set25 = '0400';
	const Set30 = '0500';
	const Set40 = '0600';
	const Set44 = '0700';
	const Set50 = '0800';
	const Set60 = '0900';
	const Set63 = '0A00';
	const Set70 = '0B00';
	const Set75 = '0C00';
	const Set80 = '0D00';
	const Set90 = '0E00';
	const Set94 = '0F00';
	const Set100 = 'DIM100';
}

class GreenteqFunk extends \stdClass
{

}

class HOMEeasy extends \stdClass
{

}

class Homematic extends \stdClass
{

}

class Instabus extends \stdClass
{
	const Stop = '0000';
	const DimDown = '0101';
	const StepDown = '0102';
	const Off = '0102';
	const MoveDown = '0103';
	const DimUp = '0201';
	const StepUp = '0202';
	const On = '0202';
	const MoveUp = '0203';
	const DoScene = '0302';
}

class Internorm extends \stdClass
{

}

class KoppFreeControl extends \stdClass
{

}

class LEDController extends \stdClass
{

}

class Nueva extends \stdClass // Temperatur-/ Feuchtigkeitssensor
{

}

class PCA301 extends \stdClass
{

}

class SchalkFX3 extends \stdClass
{

}

class SomfyRTS extends \stdClass
{

}

class systeQ extends \stdClass // qleverADAPTER
{

}

class WIR extends \stdClass
{
	const MotorControl = '01';
	const LightingControl = '02';
	const Reserved = '01';
	const On = '01';
	const Off = '02';
	const Stop = '03';
	const OnEndpoint = '04';
	const StopEndpoint = '05';
	const OffEndpoint = '06';
	const DrivePosition = '07';
	const DrivePositionDusk = '08';
	const DrivepositionSun = '09';
	const DrivePositionVentilation = '0A';
	const DrivePositionStorage = '0B';
	const AutoOn = '0C';
	const AutoOff = '0D';
}

?>