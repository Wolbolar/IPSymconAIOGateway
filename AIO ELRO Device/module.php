<?php
declare(strict_types=1);

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ProfileHelper.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ConstHelper.php");

use Fonzo\Mediola\AIOGateway;

class AIOELRODevice extends IPSModule
{

   
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		$this->RegisterPropertyString("name", "");
		$this->RegisterPropertyString("room_name", "");
		$this->RegisterPropertyString("type", "");
		$this->RegisterPropertyInteger("room_id", 0);
		$this->RegisterPropertyString("device_id", "");
		$this->RegisterPropertyString("address", "");
		$this->RegisterPropertyString("ELROAddress", "");
		$this->RegisterPropertyBoolean("LearnAddressELRO", false);
		
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		// ELROAddress prüfen
        $ELROAddress = $this->ReadPropertyString('ELROAddress');
        $LearnAddressELRO = $this->ReadPropertyBoolean('LearnAddressELRO');
				
		if ($LearnAddressELRO)
		{
			$this->Learn();
		}
		elseif ( $ELROAddress == '')
        {
            // Status inaktiv
            $this->SetStatus(IS_INACTIVE);
        }
		else 
		{
			//Eingabe überprüfen
			
			
			// Status aktiv
            $this->SetStatus(IS_ACTIVE);
			//Status-Variablen anlegen
			$stateId = $this->RegisterVariableBoolean("STATE", "Status", "~Switch", 1);
			$this->EnableAction("STATE");
		}	
		
				
        // Profile anlegen

        
	}
	
	/**
    * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
    * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
    *
    * ABC_MeineErsteEigeneFunktion($id);
    *
    */
		
	public function RequestAction($Ident, $Value)
		{
			switch($Ident) {
				case "STATE":
					$this->ELROPowerSetState($Value);
					break;
				default:
					throw new Exception("Invalid ident");
			}
		}	
	
	protected function GetParent()
    {
        $instance = IPS_GetInstance($this->InstanceID);//array
		return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
    }
	
	public function PowerOn()
    {
            $ELROAddress = $this->ReadPropertyString("ELROAddress");
			$action = "1";
            SetValueBoolean($this->GetIDForIdent('STATE'), true);
			return $this->Send_ELRO($ELROAddress, $action);	
    }
		
	public function PowerOff()
    {
			$ELROAddress = $this->ReadPropertyString("ELROAddress");
			$action = "4";
            SetValueBoolean($this->GetIDForIdent('STATE'), false);
			return $this->Send_ELRO($ELROAddress, $action);	
    }

	protected function ELROPowerSetState ($state)
    {
	SetValueBoolean($this->GetIDForIdent('STATE'), $state);
	return $this->SetPowerState($state);	
	}
	
	protected function SetPowerState($state) {
		$ELROAddress = $this->ReadPropertyString("ELROAddress");
		if ($state === true)
		{
		$action = "1";
		return $this->Send_ELRO($ELROAddress, $action);	
		}
		else
		{
		$action = "4";
		return $this->Send_ELRO($ELROAddress, $action);	
		}
	}
	
		
	//Senden eines Befehls an Elro
    protected function Send_ELRO($ELRO_send, $action)
    {
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
        //ELRO Befehl, erste 5 Zeichen Adresse letzes Zeichen Command
        $ELRO_send = substr($ELRO_send, 0, 5);
        if ($action === "1")
        {
            // Sendestring ELRO /command?XC_FNC=SendSC&type=ELRO&data=
            if ($GatewayPassword !== "")
            {
                if($gatewaytype == 6 || $gatewaytype == 7)
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1",0);
                }
                else
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1",0);
                }
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1");
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."1",0);
            }

            $status = true;
            return $status;
        }
        else
        {
            if ($GatewayPassword != "")
            {
                if($gatewaytype == 6 || $gatewaytype == 7)
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4",0);
                }
                else
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4",0);
                }
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4");
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_FNC=SendSC&type=ELRO&data=".$ELRO_send."4",0);
            }

            $status = false;
            return $status;
        }

    }
	
	private $response = false;
	//Anmelden eines ELRO Geräts an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=LearnSC&type=ELRO
	public function Learn()
		{
            $aiogateway = new AIOGateway($this->InstanceID);
		    $GatewayPassword = $aiogateway->GetPassword();
		    $gatewaytype = $aiogateway->GetGatewaytype();
            $aiogatewayip = $aiogateway->GetIPGateway();
		if ($GatewayPassword !== "")
			{
                if($gatewaytype == 6 || $gatewaytype == 7)
                {
                    $address = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=LearnSC&type=ELRO");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=LearnSC&type=ELRO",0);
                    $this->SendDebug("ELRO Adress",$address,0);
                }
                else
                {
                    $address = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=LearnSC&type=ELRO");
                    $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=LearnSC&type=ELRO",0);
                    $this->SendDebug("ELRO Adress",$address,0);
                }
			}
			else
			{
				$address = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=LearnSC&type=ELRO");
				$this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_FNC=LearnSC&type=ELRO",0);
				$this->SendDebug("ELRO Adress",$address,0);
			}
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($address == "{XC_ERR}Failed to learn code")//Bei Fehler
			{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			$this->SendDebug("ELRO Adresse:",$address,0);
			IPS_LogMessage( "ELRO Adresse:" , $address );
			echo "Die Adresse vom ELRO Gerät konnte nicht angelernt werden.";
			IPS_SetProperty($instance, "LearnAddressELRO", false); //Haken entfernen.			
			}
		else
			{
				//Adresse auswerten {XC_SUC}
				//bei Erfolg {XC_SUC}{"CODE":"414551"} 
				$address = strval(substr($address, 17, 6));
				IPS_LogMessage( "ELRO Adresse:" , $address );
				//echo "Adresse des ELRO Geräts: ".$address;
				$this->AddAddress($address);
				$this->response = true;	
			}
		
		return $this->response;
		}
	
	//Adresse hinzufügen
	protected function AddAddress($address)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "ELROAddress", $address); //Adresse setzten.
		IPS_SetProperty($instance, "LearnAddressELRO", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage( "ELRO Adresse hinzugefügt:" , $address );
		// Status aktiv
        $this->SetStatus(102);
		//Status-Variablen anlegen
		$stateId = $this->RegisterVariableBoolean("STATE", "Status", "~Switch", 1);
		$this->EnableAction("STATE");	
	}

    public function DebugConfigurationForm()
    {
        $form = $this->GetConfigurationForm();
        return $form;
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
        $form = [
            [
                'type' => 'Label',
                'caption' => 'AIO ELRO device'
            ],
            [
                'name' => 'ELROAddress',
                'type' => 'ValidationTextBox',
                'caption' => 'ELRO Address'
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
        $address = $this->ReadPropertyString("address");
        $form = [];
        if ($address == "") {
            $form = array_merge_recursive(
                $form,
                [
                    [
                        'type' => 'Label',
                        'caption' => 'AIO FS20 device'
                    ],
                    [
                        'type' => 'ExpansionPanel',
                        'caption' => 'Learn key',
                        'items' => [
                            [
                                'type' => 'Button',
                                'caption' => 'Learn',
                                'onClick' => 'AIOELRO_Learn($id);'
                            ]
                        ]
                    ],
                    [
                        'type' => 'Button',
                        'caption' => 'On',
                        'onClick' => 'AIOELRO_PowerOn($id);'
                    ],
                    [
                        'type' => 'Button',
                        'caption' => 'Off',
                        'onClick' => 'AIOELRO_PowerOff($id);'
                    ]
                ]
            );
        }
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
                'caption' => 'ELRO device created'
            ],
            [
                'code' => IS_INACTIVE,
                'icon' => 'inactive',
                'caption' => 'ELRO device is inactive'
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
            ]
        ];

        return $form;
    }

}
