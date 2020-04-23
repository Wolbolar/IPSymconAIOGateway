<?php

namespace Fonzo\Mediola;

class AIOGateway
{
	public $DeviceInstanceID;

    const V1 = 1;
    const V2 = 2;
    const V3 = 3;
    const V4 = 4;
    const V4PLUS = 5;
    const V5 = 6;
    const V5PLUS = 7;
    const V6MINI = 8;
    const V6MINIE = 9;
    const V6 = 10;
    const V6E = 11;

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
		$GatewayPassword = IPS_GetProperty($ParentID, 'Password');
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

class V5 extends AIOGateway
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

class BarthelmeChromoFlex extends AIOGateway
{
	const Type = 'CF4';
}

/*
 * Barthelme Chromoflex 4 (Pro)
Gateway Login
CMD

Learning a system component

GET /cmd?XC_FNC=addSensor&type=CF4&adr=0001000010
Device type	Group Address
0x0001	0x000010
Device types
0x0001	1-canal
0x0002	2-canal
0x0003	3-canal
0x0004	4-canal
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set Color
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF4&data=02000010FAFBFCFD
Parameter
canal 1	canal 2	canal 3	canal 4
Command	Group Address	Red	Green	Blue	White
0x02	0x000010	0xFA	0xFB	0xFC	0xFD
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set Brightness
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF4&data=010000103
Parameter
Command	Group Address	Brightness
0x01	0x000010	0xFD
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Other Commands
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF4&data=0B000010
Command	Command	Group Address	Command	Command	Group Address
On

0x4

0x000010

LSD

0x14

0x000010

Off

0x05

0x000010

Fire

0x15

0x000010

Off & Save

0x06

0x000010

Flashes

0x16

0x000010

UserEffect1

0x07

0x000010

Bursts

0x17

0x000010

UserEffect2

0x08

0x000010

UserEffect3

0x09

0x000010

EffectUp

0x0A

0x000010

EffectDown

0x0B

0x000010

ColorUp

0x0C

0x000010

ColorDown

0x0D

0x000010

BrightnessUp

0x0E

0x000010

BrightnessDown

0x0F

0x000010

Normal Col Ch

0x10

0x000010

Medium Col Ch

0x11

0x000010

slow Col CH

0x12

0x000010

Blob

0x13

0x000010

Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set single Color
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF4&data=1800001032
Befehl	Befehl	Group Address	Brightness
red	0x18	0x000010	0x32
green	0x19	0x000010	0x32
blue	0x1A	0x000010	0x32
white	0x1B	0x000010	0x32
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Color Table for Color+ and Color
Nr	R	G	B	W	Hex
1

241

216

173

255

0xf1d8adff

2

120

122

184

169

0x787ab8a9

3

63

63

203

107

0x3f3fcb6b

4

26

26

255

0

0x1a1aff00

5

0

0

255

0

0x0000ff00

6

0

143

255

0

0x008fff00

7

0

255

255

0

0x00ffff00

8

0

255

134

0

0x00ff8600

9

0

255

0

0

0x00ff0000

10

123

255

0

0

0x7bff0000

11

255

255

0

0

0xffff0000

12

255

172

0

0

0xffac0000

13

255

93

0

0

0xff5d0000

14

255

0

0

0

0xff000000

15

255

0

134

0

0xff008600

16

255

0

255

0

0xff00ff00


Barthelme Chromoflex 3 (RC)
Gateway Login
CMD

Learning a system component

GET /cmd?XC_FNC=addSensor&type=CF3&adr=08
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set Color
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF3&data=0208FAFBFC
Parameter
Command	Net/Canal	R	G	B
0x02	0x08	0xFA	0xFB	0xFC
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set Brightness
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF3&data=010832
Parameter
Command	Group Address	Brightness
0x01	0x08	0x01 - 0xFF
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Other Commands
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF3&data=0B08
Command	Command	Group Address
On

0x4

0x08

Off

0x05

0x08

Off & Save

0x06

0x08

UserEffect1

0x07

0x08

UserEffect2

0x08

0x08

UserEffect3

0x09

0x08

EffectUp

0x0A

0x08

EffectDown

0x0B

0x08

ColorUp

0x0C

0x08

ColorDown

0x0D

0x08

BrightnessUp

0x0E

0x08

BrightnessDown

0x0F

0x08

Response Code: 200 Type : text/html
{"XC_SUC":{}}
Set single Color
CMD

Learning a system component

GET /cmd?XC_FNC=SendSC&type=CF3&data=180832
Befehl	Befehl	Group Address	Brightness
red	0x18	0x08	0x32
green	0x19	0x08	0x32
blue	0x1A	0x08	0x32
Response Code: 200 Type : text/html
{"XC_SUC":{}}
 */

class BeckerCentronic extends AIOGateway
{

	const Type = 'BK';
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

/*
 * Becker Centronic
Learning Becker Centronic devices
To learn a Becker Centronic device the learning mode must be enabled on the the device. After the learning mode has been enabled the LearnSC must be called twice. This also registers the actuator as a sensor at the gateway

When learning a Becker Centronic device a special Becker ID (serialnumber) is required. Five groups can be learned with each serial number. If you would like to use Becker Centronic in commercial applications please contact mediola first

CMD

Learning a system component

GET /cmd?XC_FNC=LearnSc&type=BK&adr=GROUP+SERIAL
Parameter
XC_FNC	LearnSC
type	BK
adr	Group + Becker serial
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Adr (Address)

Byte

offset

Size

(Byte)

Value

0

1

0x02

Group (1…5)

1

3

0x0B956E

Serial (provided by mediola or Becker)

Example: Learning a Becker Centronic device

GET /cmd?XC_FNC=LearnSc&type=BK&adr=020B956E
Controlling Becker Centronic devices
CMD

Learning a system component

GET /cmd?XC_FNC=SendSc&type=BK&data=01020B956E00
Parameter
XC_FNC	SendSC
type	BK
data	data
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Data

Byte

offset

Size

(Byte)

Value

0

1

0x01

Reserved

1

1

0x02

Group

2

3

0x0B956E

Serial

5

1

0x00

Command

Becker Centronic Command list

Commands

Value

Blind

Dimmer

0x00

Up

On

0x01

Open

On

0x02

Stop

Off

0x03

Position 1

Max. brightness

0x04

Position 2

Miedium brightness

0x05

3s Down

On

0x06

3s Up

On

0x07

Delete

Delete

0x08

Brighter

0x09

Darker

Remove Becker Centronic devices
To remove an actuator, press the teach-in-button on the master transmitter for 3 seconds and call the following URL:

GET /cmd?XC_FNC=SendSc&type=BK&data=01020B956E07
Receiving this command the Gateway sends the radio command "teach-in button 3s pressed" and immediately afterwards the radio command "teach-in button 10s pressed"
If the last actuator / last group of a serial number has been deleted, the serial number can be removed from the gateway by calling the following URL:

GET /cmd?XC_FNC=DelSensor&type=BK&adr=0B956E
A sensor is automatically created during the teach-in-process to store the counter for the copy guard.The sensor can also be applied manually for test purposes.

GET /cmd?XC_FNC=AddSensor&type=BK&adr=0B956E&config=1234
  {

 "type": "BK",

 "adr": "0B956E",

 "state": "1234"

 }
 */

class Brennenstuhl extends AIOGateway
{
	const Type = 'DY';
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


class ConradRSL extends AIOGateway
{
	const Type = 'CR';
}

/*
 * Conrad RSL
Learning components
CMD

Learning a system component

GET /cmd?XC_FNC=LearnSC&type=CR
Response Code: 200 Type : text/html
{"XC_SUC":{"6DC8D603"}}
If only 3 bytes (6 characters) are returned as code, it must be treated as multicomfort, because there are two different types of RSL products that are not compatible with each other.

Control components
CMD

Control a system component


On (Kanal 1)

GET /cmd?XC_FNC=SendSC&type=CR&data=6DC8D603
Off (Kanal 1)

GET /cmd?XC_FNC=SendSC&type=CR&data=7DC8D603
Start dimming

GET /cmd?XC_FNC=SendSC&type=CR&data=6DC8D6030A
Response Code: 200 Type : text/html
{"XC_SUC":{}}
Last byte(0x0A): Number of repetitions.

Instead of learning the remote control, you can choose aswell from the 16 the channels available.

Other Commands
Canal	On	Off
1

6DC8D603

7DC8D603

2

71C8D603

81C8D603

3

65C8D603

75C8D603

4

69C8D603

79C8D603

5

9DC8D603

ADC8D603

6

A1C8D603

B1C8D603

7

95C8D603

A5C8D603

8

99C8D603

A9C8D603

9

0DC8D603

1DC8D603

10

11C8D603

21C8D603

11

05C8D603

15C8D603

12

09C8D603

19C8D603

13

3DC8D603

4DC8D603

14

41C8D603

51C8D603

15

35C8D603

45C8D603

16

39C8D603

49C8D603
 */



class Dooya2 extends AIOGateway // Kaiser Nienhaus
{
	const Type = 'DY2';
}

class GiraFunkbus extends AIOGateway
{
	const Type = 'DY';
}

class Elero extends AIOGateway
{
	const Type = 'ER';
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

class EnOcean extends AIOGateway
{
	const Type = 'EO';
}

class FHT80B extends AIOGateway
{
	const Type = 'FHT80b';
}

class GreenteqFunk extends AIOGateway
{
	const Type = 'GQ';
}

/*
 * Greenteq Funk
Create components
CMD

Create a System component

GET/cmd?XC_FNC=learnSc&type=GQ
Response Code: 200 Type : text/html
{“XC_SUC”:{"CODE":"6440C63411"}
Control components
CMD

Control a System component

11	Up
55	Stop
33	Down
GET/cmd?XC_FNC=SendSC&type=GQ&data=6440C63455
 */

class HOMEeasy extends AIOGateway
{
	const Type = 'DY';
}

class Homematic extends AIOGateway
{
	const Type = 'HM';
}

class Instabus extends AIOGateway
{
	const Type = 'IA';
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

class Internorm extends AIOGateway
{
	const Type = 'IN';
    const InternormSearch = 'inSearchBlinds';
    // Command for shutter
    const Down = '000D'; // Down , Off
    const Up = '000C'; // Up / On
    const Stop = '0007'; // Stop
    // 0x0040 - 0x004F	slat positions
    // 0x0140 - 0x0047	Save position
    // 0x0148 - 0x014F	Approach position
    // 0x1800 - 0x1864	0-100% drive

    //Command for ventilator:
    const increase = '011B'; // increase
    const reduce = '011D'; // reduce
    const level_1 = '0040'; // level 1
    const level_2 = '0041'; // level 2
    const level_3 = '0042'; // level 3
    const standby = '0043'; // standby
    const automatic = '0044'; // automatic
    const manual = '0045'; // manual
    const turbo = '0046'; // turbo
    const Blow_on_Mode_1 = '0054'; // Night Mode / Blow on Mode 1
    const Blow_on_Mode_2 = '0055'; // Night Mode / Blow on Mode 2
    const Blow_on_Mode_3 = '0056'; // Night Mode / Blow on Mode 3
    const Blow_off_Mode_1 = '0057'; // Night Mode / Blow off Mode 1
    const Blow_off_Mode_2 = '0058'; // Night Mode / Blow off Mode 2
    const Blow_off_Mode_3 = '0059'; // Night Mode / Blow off Mode 3


}

class KoppFreeControl extends AIOGateway
{
	const Type = 'KOPP';
}

class LEDController extends AIOGateway
{
	const Type = 'LS';
}

class Nueva extends AIOGateway // Temperatur-/ Feuchtigkeitssensor
{
	const Type = 'NTH';
}

class PCA301 extends AIOGateway
{
	const Type = 'PE';
}

class SchalkFX3 extends AIOGateway
{
	const Type = 'FX3';
}



class systeQ extends AIOGateway // qleverADAPTER
{
	const Type = 'QA';
}

class Sygonix extends AIOGateway // Renkforce Sygonix
{
	const Type = 'R2';
	const Switch = '40';
	const Dimmer = '41';
	const On = '0001';
	const Off = '0002';
	const Set10 = '0A';
	const Set20 = '14';
	const Set30 = '1E';
	const Set40 = '28';
	const Set50 = '32';
	const Set60 = '3C';
	const Set70 = '46';
	const Set80 = '50';
	const Set90 = '5A';
	const Set100 = '0A';
}

class WIR extends AIOGateway
{
	const Type = 'WR';
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
