<?php
declare(strict_types=1);

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ProfileHelper.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ConstHelper.php");

use Fonzo\Mediola\AIOGateway;

class AIOSomfyRTSDevice extends IPSModule
{
	
    public function Create()
    {
        //Never delete this line!
        parent::Create();
		
		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		$this->RegisterPropertyString("name", "");
		$this->RegisterPropertyString("room_name", "");
		$this->RegisterPropertyString("type", "switch");
		$this->RegisterPropertyInteger("room_id", 0);
		$this->RegisterPropertyString("device_id", "");
		$this->RegisterPropertyString("address", "");
		$this->RegisterPropertyString("Adresse", "");
		$this->RegisterAttributeString('address', "");
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		$this->ValidateConfiguration();

    }


	 /**
     * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
     * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
     *
     *
     */
	protected function ValidateConfiguration()
		{
			
			$AIORTSAdresse = $this->ReadPropertyString("Adresse");
			if ($AIORTSAdresse != '')
					{
						//AIORTSAdresse prüfen
						if (strlen($AIORTSAdresse)<6 or strlen($AIORTSAdresse)>6)//Länge prüfen
						{
						    $this->SetStatus(207);
						}
						else
						{
                            $this->WriteAttributeString('address', $AIORTSAdresse);
                            $this->SetupVar();
                            // Status aktiv
                            $this->SetStatus(IS_ACTIVE);
						}
						
					}
			elseif ($AIORTSAdresse == '')
			{
                $AIORTS_address = $this->ReadPropertyString("address");
                if($AIORTS_address == "")
                {
                    // Status inaktiv
                    $this->SetStatus(202);
                }
                else{
                    $this->WriteAttributeString('address', $AIORTSAdresse);
                    $this->SetupVar();
                    // Status aktiv
                    $this->SetStatus(IS_ACTIVE);
                }

			}
			else 
			{
				//Eingabe überprüfen Länge 4 Zeichen nur Zahlen
				
						// Status aktiv
						$this->SetStatus(IS_ACTIVE);
			}
		}

	protected function SetupVar()
		{
			//Status-Variablen anlegen
            $type = $this->ReadPropertyString("type");
            if($type == "shutter")
            {
                $this->RegisterVariableInteger("CONTROL", $this->Translate("Control"), "~ShutterMoveStop", 1);
                $this->EnableAction("CONTROL");
            }
            if($type == "switch")
            {
                $this->RegisterVariableBoolean("STATE", $this->Translate("State"), "~Switch", 1);
                $this->EnableAction("STATE");
            }
            if($type == "blind")
            {
                $this->RegisterVariableInteger("CONTROL", $this->Translate("Control"), "~ShutterMoveStop", 1);
                $this->EnableAction("CONTROL");
            }
		}
	
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "CONTROL":
                switch($Value) {
                    case 4: // Down, Schließen
						$this->Down();
						break;
                    case 2: // Stop
					    $this->Stop();
						break;
					case 0: // Up, Öffnen
					    $this->Up();
						break;	
                }
                break;
            case "STATE":
                if($Value)
                {
                    $this->On();
                }
                else{
                    $this->Off();
                }
                break;
            default:
                throw new Exception("Invalid ident");
        }
    }

    public function On() {
        $command = SomfyRTS::ON;
        return $this->SendCommand($command);
    }

    public function Off() {
        $command = SomfyRTS::OFF;
        return $this->SendCommand($command);
    }

	public function Up() {
        $command = SomfyRTS::UP;
		return $this->SendCommand($command);
        }
	
	public function Down() {
        $command = SomfyRTS::DOWN;
		return $this->SendCommand($command);
        }
	
	public function Stop() {
        $command = SomfyRTS::STOP;
		return $this->SendCommand($command);
        }
	
	//Senden eines Befehls an Somfy RTS
	// Sendestring RTS {IP Gateway}/command?XC_FNC=SendSC&type=RT&data={RTS Send Adresse}{Command} 
	private $response = false;
	protected function SendCommand(string $command)
    {
        $address = $this->ReadPropertyString('address');
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
		switch($command) 
		{
            case SomfyRTS::UP: // Up, Öffnen
                SetValueInteger($this->GetIDForIdent('CONTROL'), 0);
                break;
            case SomfyRTS::DOWN: // Down, Schließen
                SetValueInteger($this->GetIDForIdent('CONTROL'), 4);
                break;
            case SomfyRTS::STOP: // Stop
                SetValueInteger($this->GetIDForIdent('CONTROL'), 2);
                break;
            case SomfyRTS::ON: // On
                SetValueBoolean($this->GetIDForIdent('STATE'), true);
                break;
            case SomfyRTS::OFF: // Off
                SetValueBoolean($this->GetIDForIdent('STATE'), false);
                break;
		}
		
		
		IPS_LogMessage( "Adresse:" , $address );
		IPS_LogMessage( "RTS Command:" , $command );
        $this->SendDebug("AIO Gateway", "Password set " . $GatewayPassword, 0);
        if ($GatewayPassword !== "")
		{
            if($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E)
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=".SomfyRTS::Type."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . SomfyRTS::Type . "&data=" . $command.$address, 0);
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=".SomfyRTS::Type."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . SomfyRTS::Type . "&data=" . $command.$address, 0);
            }
		}
		else
		{
			$gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=".SomfyRTS::Type."&data=".$command.$address);
            $this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_FNC=SendSC&type=" . SomfyRTS::Type . "&data=" . $command.$address, 0);
		}
        $this->SendDebug("AIO Gateway Recieve", $gwcheck, 0);
		if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		elseif ($gwcheck == "{XC_AUTH}")
			{
			$this->response = false;
			echo "Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch.";
			}
		return $this->response;
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
        return json_encode([
                               'elements' => $this->FormElements(),
                               'actions' => $this->FormActions(),
                               'status' => $this->FormStatus()
                           ]);
    }

    /**
     * return form configurations on configuration step
     * @return array
     */
    protected function FormElements()
    {
        $address = $this->ReadAttributeString("address");
        $address_old = $this->ReadPropertyString("Adresse");
        if($address == "" && $address_old == "")
        {
            $address_visibility = true;
            $address_old_visibility = false;
        }
        elseif($address != "")
        {
            $address_visibility = true;
            $address_old_visibility = false;
        }
        else{
            $address_visibility = false;
            $address_old_visibility = true;
        }

        $form = [
            [
                'type' => 'Label',
                'caption' => 'AIO Somfy device'
            ],
            [
                'name' => 'Adresse',
                'type' => 'ValidationTextBox',
                'visible' => $address_old_visibility,
                'caption' => 'Somfy address'
            ],
            [
                'name' => 'address',
                'visible' => $address_visibility,
                'type' => 'ValidationTextBox',
                'caption' => 'Somfy address'
            ],
            [
                'type' => 'ExpansionPanel',
                'caption' => 'Somfy type',
                'items' => [
                    [
                        'type' => 'Select',
                        'name' => 'type',
                        'caption' => 'device type',
                        'options' => [
                            [
                                'caption' => 'Blind',
                                'value' => 'blind'
                            ],
                            [
                                'caption' => 'Shutter',
                                'value' => 'shutter'
                            ],
                            [
                                'caption' => 'Switch',
                                'value' => 'switch'
                            ]
                        ]
                    ],
                ]
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
                'type' => 'TestCenter',
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
                'caption' => 'Somfy device created'
            ],
            [
                'code' => IS_INACTIVE,
                'icon' => 'inactive',
                'caption' => 'Somfy device is inactive'
            ],
            [
                'code' => 201,
                'icon' => 'inactive',
                'caption' => 'Please follow the instructions.'
            ],
            [
                'code' => 202,
                'icon' => 'error',
                'caption' => 'Information invalid. Fields can not be empty.'
            ],
            [
                'code' => 203,
                'icon' => 'error',
                'caption' => 'No active AIO I/O.'
            ],
            [
                'code' => 204,
                'icon' => 'error',
                'caption' => 'HC1 can only consist of 4 numbers.'
            ],
            [
                'code' => 205,
                'icon' => 'error',
                'caption' => 'HC2 can only consist of 4 numbers.'
            ],
            [
                'code' => 206,
                'icon' => 'error',
                'caption' => 'address can only consist of 4 numbers.'
            ],
            [
                'code' => 207,
                'icon' => 'error',
                'caption' => 'address may only consist of 6 characters.'
            ],
            [
                'code' => 208,
                'icon' => 'error',
                'caption' => 'Calculated address and input do not match.'
            ]
        ];

        return $form;
    }
}

class SomfyRTS
{
    const Type = 'RT';
    const UP = '20';
    const DOWN = '40';
    const STOP = '10';
    const ON = 'A0'; // ?
    const OFF = 'B0'; // ?
}