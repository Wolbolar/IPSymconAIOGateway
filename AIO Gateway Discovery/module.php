<?php
declare(strict_types=1);

class AIOGatewayDiscovery extends IPSModule
{

    private const V1 = 1;
    private const V2 = 2;
    private const V3 = 3;
    private const V4 = 4;
    private const V4PLUS = 5;
    private const V5 = 6;
    private const V5PLUS = 7;
    private const V6MINI = 8;
    private const V6MINIE = 9;
    private const V6 = 10;
    private const V6E = 11;

	public function Create()
	{
		//Never delete this line!
		parent::Create();
		$this->RegisterAttributeString("devices", "[]");

		//we will wait until the kernel is ready
		$this->RegisterMessage(0, IPS_KERNELMESSAGE);
		$this->RegisterMessage(0, IPS_KERNELSTARTED);
		$this->RegisterTimer('Discovery', 0, 'AIOGatewayDiscovery_Discover($_IPS[\'TARGET\']);');
	}

	/**
	 * Interne Funktion des SDK.
	 */
	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();

		if (IPS_GetKernelRunlevel() !== KR_READY) {
			return;
		}

		$this->WriteAttributeString("devices", json_encode($this->DiscoverDevices()));
		$this->SetTimerInterval('Discovery', 300000);

		// Status Error Kategorie zum Import auswählen
		$this->SetStatus(102);
	}

	public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
	{

		switch ($Message) {
			case IM_CHANGESTATUS:
				if ($Data[0] === IS_ACTIVE) {
					$this->ApplyChanges();
				}
				break;

			case IPS_KERNELMESSAGE:
				if ($Data[0] === KR_READY) {
					$this->ApplyChanges();
				}
				break;
			case IPS_KERNELSTARTED:
				$this->WriteAttributeString("devices", json_encode($this->DiscoverDevices()));
				break;

			default:
				break;
		}
	}

	/**
	 * Liefert alle Geräte.
	 *
	 * @return array configlist all devices
	 */
	private function Get_ListConfiguration()
	{
		$config_list = [];
		$DeviceIDList = IPS_GetInstanceListByModuleID('{7E03C651-E5BF-4EC6-B1E8-397234992DB4}'); // AIO Gateway Splitter
		$devices = json_decode($this->Discover(), true);
		$this->SendDebug('AIO Gateway discovered devices', json_encode($devices), 0);
		if (!empty($devices)) {
			foreach ($devices as $key => $device) {
				$instanceID = 0;
				$name = $device["NAME"];
                $host = $device["IP"];
				$mac = $device["MAC"];
				$model = $device["HWV"];
                $version = $device["VER"];
                $port = 0;
                if(isset($device["PT"]))
                {
                    $port = $device["PT"];
                }
                $dhcp = "";
                if(isset($device["DHCP"]))
                {
                    $dhcp = $device["DHCP"];
                }
                $sn = "";
                if(isset($device["SN"]))
                {
                    $sn = $device["SN"];
                }
                $gw = "";
                if(isset($device["GW"]))
                {
                    $gw = $device["GW"];
                }
                $dns = "";
                if(isset($device["DNS"]))
                {
                    $dns = $device["DNS"];
                }
                $swv = "";
                if(isset($device["SWV"]))
                {
                    $swv = $device["SWV"];
                }
                $rfv = "";
                if(isset($device["RFV"]))
                {
                    $rfv = $device["RFV"];
                }
                $rff = "";
                if(isset($device["RFF"]))
                {
                    $rff = $device["RFF"];
                }
                $rfm = "";
                if(isset($device["RFM"]))
                {
                    $rfm = $device["RFM"];
                }
                $eid = "";
                if(isset($device["EID"]))
                {
                    $eid = $device["EID"];
                }
                $ff = "";
                if(isset($device["FF"]))
                {
                    $ff = $device["FF"];
                }
                $tz = "";
                if(isset($device["TZ"]))
                {
                    $tz = $device["TZ"];
                }
                $vid = "";
                if(isset($device["VID"]))
                {
                    $vid = $device["VID"];
                }

				$device_id = 0;
				foreach ($DeviceIDList as $DeviceID) {
					if ($host == IPS_GetProperty($DeviceID, 'Host')) {
						$device_name = IPS_GetName($DeviceID);
						$this->SendDebug('AIO Gateway Discovery', 'device found: ' . utf8_decode($device_name) . ' (' . $DeviceID . ')', 0);
						$instanceID = $DeviceID;
					}
				}

                if ($model == 'EA' || $model == 7) {
                    $config_list[] = [
                        "instanceID" => $instanceID,
                        "id" => $device_id,
                        "name" => $name,
                        "host" => $host,
                        "mac" => $mac,

                        "model" => $this->GetModelType($model),
                        "create" => [
                            [
                                'moduleID' => '{35B16C2A-1B3C-42A7-8580-A4E9E4AE9CF5}',
                                'configuration' => [
                                    'mac' => $mac,
                                    'model' => $model,
                                    'version' => $version,
                                ]
                            ],
                            [
                                'moduleID' => '{7E03C651-E5BF-4EC6-B1E8-397234992DB4}',
                                'configuration' => [
                                    'name' => $name,
                                    'Host' => $host,
                                    'mac' => $mac,
                                    'model' => $model,
                                    'version' => $version,
                                    'Port' => $port,
                                    'dhcp' => $dhcp,
                                    'sn' => $sn,
                                    'gw' => $gw,
                                    'dns' => $dns,
                                    'swv' => $swv,
                                    'rfv' => $rfv,
                                    'rff' => $rff,
                                    'rfm' => $rfm,
                                    'eid' => $eid,
                                    'ff' => $ff,
                                    'tz' => $tz,
                                    'vid' => $vid,
                                    'gatewaytype' => $this->GetModelNumber($model)
                                ]
                            ],
                            [
                                'moduleID' => '{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}',
                                'configuration' => [
                                    'Host' => $this->GetHostIP(),
                                    'Port' => 1901,
                                    'MulticastIP' => "239.255.255.250",
                                    'BindPort' => 1901,
                                    'EnableBroadcast' => true,
                                    'EnableReuseAddress' => true,
                                    'EnableLoopback' => false,
                                    'Open' => true
                                ]
                            ]
                        ]
                    ];
                } else {
                    $config_list[] = [
                        "instanceID" => $instanceID,
                        "id" => $device_id,
                        "name" => $name,
                        "host" => $host,
                        "mac" => $mac,

                        "model" => $this->GetModelType($model),
                        "create" => [
                            [
                                'moduleID' => '{35B16C2A-1B3C-42A7-8580-A4E9E4AE9CF5}',
                                'configuration' => [
                                    'mac' => $mac,
                                    'model' => $model,
                                    'version' => $version
                                ]
                            ],
                            [
                                'moduleID' => '{7E03C651-E5BF-4EC6-B1E8-397234992DB4}',
                                'configuration' => [
                                    'name' => $name,
                                    'Host' => $host,
                                    'mac' => $mac,
                                    'model' => $model,
                                    'version' => $version,
                                    'Port' => $port,
                                    'dhcp' => $dhcp,
                                    'sn' => $sn,
                                    'gw' => $gw,
                                    'dns' => $dns,
                                    'swv' => $swv,
                                    'rfv' => $rfv,
                                    'rff' => $rff,
                                    'rfm' => $rfm,
                                    'eid' => $eid,
                                    'ff' => $ff,
                                    'tz' => $tz,
                                    'vid' => $vid,
                                    'gatewaytype' => $this->GetModelNumber($model)
                                ]
                            ],
                            [
                                'moduleID' => '{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}',
                                'configuration' => [
                                    'Host' => $this->GetHostIP(),
                                    'Port' => 1902,
                                    'MulticastIP' => "239.255.255.250",
                                    'BindPort' => 1901,
                                    'EnableBroadcast' => true,
                                    'EnableReuseAddress' => true,
                                    'EnableLoopback' => false,
                                    'Open' => true
                                ]
                            ]
                        ]
                    ];
                }
			}
		}
		return $config_list;
	}

    private function GetModelNumber($model)
    {
        if($model == 'F1?') // Telefunken Gateway V1
        {
            $typenumber = self::V1;
        }
        elseif($model == 'F2?') // AIO Gateway V2
        {
            $typenumber = self::V2;
        }
        elseif($model == 'F3?') // AIO Gateway V3
        {
            $typenumber = self::V3;
        }
        elseif($model == 'F3') // AIO Gateway V4
        {
            $typenumber = self::V4;
        }
        elseif($model == 'F4') // AIO Gateway V4 +
        {
            $typenumber = self::V4PLUS;
        }
        elseif($model == 'EA?') // AIO Gateway V5
        {
            $typenumber = self::V5;
        }
        elseif($model == 'EA') // AIO Gateway V5 +
        {
            $typenumber = self::V5PLUS;
        }
        elseif($model == 'B0?') // AIO Gateway V6 Mini
        {
            $typenumber = self::V6MINI;
        }
        elseif($model == 'B1?') // AIO Gateway V6 Mini E
        {
            $typenumber = self::V6MINIE;
        }
        elseif($model == 'C4') // AIO Gateway V6
        {
            $typenumber = self::V6;
        }
        elseif($model == 'C1') // AIO Gateway V6 E
        {
            $typenumber = self::V6E;
        }
        else
        {
            $typenumber = self::V4;
        }
        return $typenumber;
    }

	private function GetModelType($model)
    {
        if($model == 'F3')
        {
            $type = 'AIO Gateway V4';
        }
        if($model == 'A1')
        {
            $type = 'NEO Server';
        }
        if($model == 'EA')
        {
            $type = 'AIO Gateway V5+';
        }
        return $type;
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

	private function DiscoverDevices(): array
	{
		$devices = $this->Search();
        $devices = $this->delete_duplictates($devices);
		$this->SendDebug("Discover Response:", json_encode($devices), 0);
		return $devices;
	}

	private function delete_duplictates($devices){
        $mac_adresses = [];
        foreach($devices as $key => $device)
        {
            $mac_adresses[$key] = $device['MAC'];
        }

        $unique = array_unique($mac_adresses);
        $keys = array_keys(array_diff_assoc($mac_adresses, $unique));
        foreach($keys as $duplicate)
        {
            unset($devices[$duplicate]);
        }
        return $devices;
    }

	protected function Search()
	{
		// BUILD MESSAGE
		$msg = "GET\n";
		// MULTICAST MESSAGE
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		if (!$socket) {
			return [];
		}
		socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, true);
		socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, true);
		// SET TIMEOUT FOR RECIEVE
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 2, "usec" => 100000));
		if (@socket_sendto($socket, $msg, strlen($msg), 0, '239.255.255.250', 1901) === false) {
			return [];
		}
		$IPAddress = '';
		$Port = 1901;
		// RECIEVE RESPONSE
		$response = array();
		do {
			$buf = null;
			$bytes = @socket_recvfrom($socket, $buf, 2048, 0, $IPAddress, $Port);
			if (!is_null($buf)) {
				$response[] = $this->parseMSearchResponse($buf);
			}
		} while (!is_null($buf));
		// CLOSE SOCKET
		socket_close($socket);
		return $response;
	}

	protected function parseMSearchResponse( $response )
	{
		$responseArr = explode( "\n", $response );
		$parsedResponse = array();
		foreach( $responseArr as $key => $row ) {
			if( stripos( $row, 'DHCP' ) === 0 )
            {
                $parsedResponse['DHCP'] = str_ireplace( 'DHCP:', '', $row );
                $this->SendDebug('DHCP', $parsedResponse['DHCP'], 0);
            }
			if( stripos( $row, 'HWV' ) === 0 )
            {
                $parsedResponse['HWV'] = str_ireplace( 'HWV:', '', $row );
                $this->SendDebug('HWV', $parsedResponse['HWV'], 0);
            }
			if( stripos( $row, 'VER') === 0 )
            {
                $parsedResponse['VER'] = str_ireplace( 'VER:', '', $row );
                $this->SendDebug('VER', $parsedResponse['VER'], 0);
            }
			if( stripos( $row, 'VID') === 0 )
            {
                $parsedResponse['VID'] = str_ireplace( 'VID:', '', $row );
                $this->SendDebug('VID', $parsedResponse['VID'], 0);
            }
			if( stripos( $row, 'NAME') === 0 )
            {
                $parsedResponse['NAME'] = str_ireplace( 'NAME:', '', $row );
                $this->SendDebug('NAME', $parsedResponse['NAME'], 0);
            }
			if( stripos( $row, 'IP') === 0 )
            {
                $parsedResponse['IP'] = str_ireplace( 'IP:', '', $row );
                $this->SendDebug('IP', $parsedResponse['IP'], 0);
            }
			if( stripos( $row, 'PT') === 0 )
            {
                $parsedResponse['PT'] = str_ireplace( 'PT:', '', $row );
                $this->SendDebug('PT', $parsedResponse['PT'], 0);
            }
			if( stripos( $row, 'SN') === 0 )
            {
                $parsedResponse['SN'] = str_ireplace( 'SN:', '', $row );
                $this->SendDebug('SN', $parsedResponse['SN'], 0);
            }
			if( stripos( $row, 'GW') === 0 )
            {
                $parsedResponse['GW'] = str_ireplace( 'GW:', '', $row );
                $this->SendDebug('GW', $parsedResponse['GW'], 0);
            }
			if( stripos( $row, 'DNS:') === 0 )
            {
                $parsedResponse['DNS'] = str_ireplace( 'DNS:', '', $row );
                $this->SendDebug('DNS', $parsedResponse['DNS'], 0);
            }
			if( stripos( $row, 'MAC') === 0 )
            {
                $parsedResponse['MAC'] = str_ireplace( 'MAC:', '', $row );
                $this->SendDebug('MAC', $parsedResponse['MAC'], 0);
            }
			if( stripos( $row, 'SWV:') === 0 )
            {
                $parsedResponse['SWV'] = str_ireplace( 'SWV:', '', $row );
                $this->SendDebug('SWV', $parsedResponse['SWV'], 0);
            }
			if( stripos( $row, 'RFV:') === 0 )
            {
                $parsedResponse['RFV'] = str_ireplace( 'RFV:', '', $row );
                $this->SendDebug('RFV', $parsedResponse['RFV'], 0);
            }
			if( stripos( $row, 'RFF:') === 0 )
            {
                $parsedResponse['RFF'] = str_ireplace( 'RFF:', '', $row );
                $this->SendDebug('RFF', $parsedResponse['RFF'], 0);
            }
			if( stripos( $row, 'RFM:') === 0 )
            {
                $parsedResponse['RFM'] = str_ireplace( 'RFM:', '', $row );
                $this->SendDebug('RFM', $parsedResponse['RFM'], 0);
            }
			if( stripos( $row, 'EID:') === 0 )
            {
                $parsedResponse['EID'] = str_ireplace( 'EID:', '', $row );
                $this->SendDebug('EID', $parsedResponse['EID'], 0);
            }

			if( stripos( $row, 'FF:') === 0 )
            {
                $parsedResponse['FF'] = str_ireplace( 'FF:', '', $row );
                $this->SendDebug('FF', $parsedResponse['FF'], 0);
            }
			if( stripos( $row, 'TZ') === 0 )
            {
                $parsedResponse['TZ'] = str_ireplace( 'TZ:', '', $row );
                $this->SendDebug('TZ', $parsedResponse['TZ'], 0);
            }
		}

		return $parsedResponse;
	}

	public function GetDevices()
	{
		$devices = $this->ReadAttributeString("devices");
		return $devices;
	}

	public function Discover()
	{
		$this->LogMessage($this->Translate('Background Discovery of AIO Gateway'), KL_NOTIFY);
		$devices = json_encode($this->DiscoverDevices());
		if($devices != '[]')
        {
            $this->WriteAttributeString("devices", $devices);
        }
		else
        {
            $devices = $this->GetDevices();
        }
		return $devices;
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
		$form = [
            [
                'type' => 'Image',
                'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAABLCAYAAAA1fMjoAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjY2QUI2MjE1REVGMzExRThCMzJGRjEwMzUxRUM2N0I3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjY2QUI2MjE2REVGMzExRThCMzJGRjEwMzUxRUM2N0I3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjZBQjYyMTNERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjZBQjYyMTRERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6GmGzYAAAM4UlEQVR42uxd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'
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
		$form = [
			[
				'name' => 'AIOGatewayDiscovery',
				'type' => 'Configurator',
				'rowCount' => 20,
				'add' => false,
				'delete' => true,
				'sort' => [
					'column' => 'name',
					'direction' => 'ascending'
				],
				'columns' => [
					[
						'caption' => 'ID',
						'name' => 'id',
						'width' => '200px',
						'visible' => false
					],
					[
						'caption' => 'name',
						'name' => 'name',
						'width' => 'auto'
					],
                    [
                        'caption' => 'host',
                        'name' => 'host',
                        'width' => '250px'
                    ],
                    [
                        'caption' => 'mac',
                        'name' => 'mac',
                        'width' => '400px'
                    ],
					[
						'caption' => 'model',
						'name' => 'model',
						'width' => '250px'
					],
					[
						'caption' => 'version',
						'name' => 'host',
						'width' => '250px'
					]
				],
				'values' => $this->Get_ListConfiguration()
			]
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
				'caption' => 'AIO Gateway Discovery created.'
			],
			[
				'code' => IS_INACTIVE,
				'icon' => 'inactive',
				'caption' => 'interface closed.'
			],
			[
				'code' => 201,
				'icon' => 'inactive',
				'caption' => 'Please follow the instructions.'
			]
		];

		return $form;
	}
}
