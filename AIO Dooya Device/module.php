<?php
declare(strict_types=1);

require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . '/../libs/ProfileHelper.php';
require_once __DIR__ . '/../libs/ConstHelper.php';

use Fonzo\Mediola\AIOGateway;
use Fonzo\Mediola\Dooya;

class AIODooyaDevice extends IPSModule
{
	use ProfileHelper;

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
		$this->RegisterPropertyString("type", "");
		$this->RegisterPropertyInteger("room_id", 0);
		$this->RegisterPropertyString("device_id", "");
		$this->RegisterPropertyString("address", "");
        $this->RegisterAttributeString('address', "");
        $this->RegisterPropertyString("Adresse", "");
		    
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
			
			$AIODooyaAdresse = $this->ReadPropertyString("Adresse");
			if ($AIODooyaAdresse != '')
					{
						//AIODooyaAdresse prüfen
						if (strlen($AIODooyaAdresse)<8 or strlen($AIODooyaAdresse)>8)//Länge prüfen
						{
							$this->SetStatus(207);	
						}
						else
						{
                            $this->WriteAttributeString('address', $AIODooyaAdresse);
                            $this->SetupVar();
                            // Status aktiv
                            $this->SetStatus(IS_ACTIVE);
						}
						
					}
			elseif ($AIODooyaAdresse == '')
			{
                $AIODooya_address = $this->ReadPropertyString("address");
                if($AIODooya_address == "")
                {
                    // Status inaktiv
                    $this->SetStatus(202);
                }
                else{
                    $this->WriteAttributeString('address', $AIODooyaAdresse);
                    $this->SetupVar();
                    // Status aktiv
                    $this->SetStatus(IS_ACTIVE);
                }
			}
			else 
			{
				$this->SetupVar();
				// Status aktiv
				$this->SetStatus(IS_ACTIVE);
			}
        }

	protected function SetupVar()
		{
			$this->RegisterVariableInteger("Dooya", "Dooya", "~ShutterMoveStep", 1);
			$this->EnableAction("Dooya");
		}

    public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Dooya":
                switch($Value) {
                    case 0: // Move Up
                        $this->MoveUp();
                        break;
                    case 1: // Step Up
                        $this->StepUp();
                        break;
					case 2: // Stop
                        $this->Stop();
                        break;
					case 3: // Step down
                        $this->StepDown();
						break;
					case 4: // Move Down
                        $this->MoveDown();
						break;
                }
                break;	
            default:
            	$this->SendDebug(__FUNCTION__, "Invalid ident", 0);
        }
    }

	public function MoveUp() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 0);
		return $this->SendCommand(Dooya::MoveUp);
	}

	public function MoveDown() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 4);
		return $this->SendCommand(Dooya::MoveDown);
	}

	public function StepUp() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 1);
		return $this->SendCommand(Dooya::StepUp);
        }
	
	public function StepDown() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 3);
		return $this->SendCommand(Dooya::StepDown);
        }
	
	public function Stop() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 2);
		return $this->SendCommand(Dooya::Stop);
        }
	
	//Senden eines Befehls an Dooya
	// Sendestring {IP Gateway}/command?XC_FNC=SendSC&type=DY&data={Dooya Send Adresse 8 stellig}{Command} 
	private $response = false;
	protected function SendCommand($command)
    {
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
        $address = $this->ReadPropertyString('Adresse');
		IPS_LogMessage( "Adresse:" , $address );
		IPS_LogMessage( "Dooya Command:" , $command );
		if ($GatewayPassword !== "")
		{
            if($gatewaytype == 6 || $gatewaytype == 7)
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address,0);
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address,0);
            }
		}
		else
		{
			$gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address);
            $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?&XC_FNC=SendSC&type=". Dooya::Type ."&data=".$command.$address,0);
		}
		
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
                'caption' => 'Dooya device'
            ],
            [
                'name' => 'Adresse',
                'type' => 'ValidationTextBox',
                'visible' => $address_old_visibility,
                'caption' => 'Dooya address'
            ],
            [
                'name' => 'address',
                'visible' => $address_visibility,
                'type' => 'ValidationTextBox',
                'caption' => 'Dooya address'
            ],
        ];
        return $form;
    }

    /**
     * return form actions by token
     * @return array
     */
    protected function FormActions()
    {
        $address = $this->ReadAttributeString("address");
        if($address == "")
        {
            $button_visibility = false;
        }
        else{
            $button_visibility = true;
        }
        $form = [
            [
                'type' => 'Button',
                'caption' => 'Move up',
                'visible' => $button_visibility,
                'onClick' => 'AIODooya_MoveUp($id);'
            ],
            [
                'type' => 'Button',
                'caption' => 'Step up',
                'visible' => $button_visibility,
                'onClick' => 'AIODooya_StepUp($id);'
            ],
            [
                'type' => 'Button',
                'caption' => 'Stop',
                'visible' => $button_visibility,
                'onClick' => 'AIODooya_Stop($id);'
            ],
            [
                'type' => 'Button',
                'caption' => 'Stop',
                'visible' => $button_visibility,
                'onClick' => 'AIODooya_StepDown($id);'
            ],
            [
                'type' => 'Button',
                'caption' => 'Down',
                'visible' => $button_visibility,
                'onClick' => 'AIODooya_MoveDown($id);'
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
                'caption' => 'Dooya device created'
            ],
            [
                'code' => IS_INACTIVE,
                'icon' => 'inactive',
                'caption' => 'Dooya device is inactive'
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
