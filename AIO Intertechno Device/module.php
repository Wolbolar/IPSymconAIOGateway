<?php
declare(strict_types=1);

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ProfileHelper.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ConstHelper.php");

use Fonzo\Mediola\AIOGateway;

class AIOITDevice extends IPSModule
{
	use ProfileHelper;
   
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

		$this->RegisterPropertyString("ITFamilyCode", "");
		$this->RegisterPropertyString("ITDeviceCode", "");
		$this->RegisterPropertyString("ITType", "Switch");
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		// ITFamilyCode und ITDeviceCode prüfen
        $ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$ITDeviceCode = $this->ReadPropertyString('ITDeviceCode');
		$address = $this->ReadPropertyString("address");


		if ( ($ITFamilyCode == '' or $ITDeviceCode == '') && $address == "")
        {
            // Status Error Felder dürfen nicht leer sein
            $this->SetStatus(202);
        }
		elseif($address != "")
		{
			$this->SetupProfiles();
			$this->SetupVar();
			// Status aktiv
			$this->SetStatus(IS_ACTIVE);
		}
		elseif($ITFamilyCode != '' && $ITDeviceCode != '' && $address != "")
		{
			//Eingabe überprüfen
			if (strlen($ITFamilyCode)<1)
				{
					$this->SetStatus(203);	
				}
			elseif (strlen($ITDeviceCode)<1 or strlen($ITDeviceCode)>2)
				{
					$this->SetStatus(204);	
				}
			elseif (!ctype_digit($ITDeviceCode))
				{
					$this->SetStatus(205);
				}
			else
				{
					$this->SetupProfiles();
					$this->SetupVar();
					// Status aktiv
					$this->SetStatus(IS_ACTIVE);
				}		
			
		}
	}
		

	protected function SetupVar()
	{
		//Generelle-Variablen anlegen
		$this->RegisterVariableBoolean("STATE", "Status", "~Switch", 1);
		$this->EnableAction("STATE");
					
		// Variablen bei Dimmer anlegen
		$ITType = $this->ReadPropertyString('ITType');
		if ($ITType === "Dimmer ITLR-300")
			{
			$this->RegisterVariableInteger("Dimmer", "Dimmer", "IntertechnoDimmer.AIOIT", 2);
			$this->EnableAction("Dimmer");
			}
	}
	
	protected function SetupProfiles()
	{
		// Profile anlegen
		//  register profiles
		$this->RegisterProfileAssociation(
			'IntertechnoDimmer.AIOIT',
			'Intensity',
			'',
			' %',
			0,
			10,
			0,
			0,
			VARIABLETYPE_INTEGER,
			[
				[0, '0', '', -1],
				[1, '10', '', -1],
				[2, '20', '', -1],
				[3, '30', '', -1],
				[4, '40', '', -1],
				[5, '50', '', -1],
				[6, '60', '', -1],
				[7, '70', '', -1],
				[8, '80', '', -1],
				[9, '90', '', -1],
				[10, '100', '', -1]
			]
		);
	}
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "STATE":
                $this->SetPowerState($Value);
				break;
			case "Dimmer":
                switch($Value) {
                    case 0: //0
						$this->PowerOff();
                        break;
                    case 1: //10
                        $this->Set10();
						break;
                    case 2: //20
                        $this->Set20();
						break;
                    case 3: //30
                        $this->Set30();
                        break;
                    case 4: //40
                        $this->Set40();
                        break;
					case 5: //50
                        $this->Set50();
                        break;
					case 6: //60
                        $this->Set60();
                        break;
					case 7: //70
                        $this->Set70();
                        break;
					case 8: //80
                        $this->Set80();
                        break;
					case 9: //90
                        $this->Set90();
                        break;
					case 10: //100
                        $this->Set100();
                        break;		
                }
                break;	
            default:
				$this->SendDebug(__FUNCTION__, "Invalid ident", 0);
        }
    }
	
	//Berechnet den Sendecode aus Familien und Devicecode 
	// Umrechnung in Hexadezimal Code A entspricht 0, Device 1 entspricht 0
	
	protected function Calculate()
	{
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$ITDeviceCode = $this->ReadPropertyString('ITDeviceCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
		{
			$ITFamilyCode = ord(strtoupper($ITFamilyCode)) - ord('A');
			$ITDeviceCode = intval($ITDeviceCode)-1;
			$ITDeviceCode = strtoupper(dechex($ITDeviceCode));
		}
		$IT_send = $ITFamilyCode.$ITDeviceCode;
		return $IT_send;
	}

	protected function GetActionCommand($type)
	{
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$ITDeviceCode = $this->ReadPropertyString('ITDeviceCode');
		$ITAddress =  $ITFamilyCode.$ITDeviceCode;
		$ITaction = substr($ITAddress, 6, 2);
		$action = false;
		if($ITaction == Intertechno::IT_ACTION_1)
			{
				if($type == "off")
				{
					$action = Intertechno::IT_ACTION_1_OFF;
				}
				elseif($type == "on")
				{
					$action = Intertechno::IT_ACTION_1_ON;
				}
			}
		elseif($ITaction == Intertechno::IT_ACTION_2)
			{
				if($type == "off")
				{
					$action = Intertechno::IT_ACTION_2_OFF;
				}
				elseif($type == "on")
				{
					$action = Intertechno::IT_ACTION_2_ON;
				}	
			}
		elseif($ITaction == Intertechno::IT_ACTION_3)
			{
				if($type == "off")
				{
					$action = Intertechno::IT_ACTION_3_OFF;
				}
				elseif($type == "on")
				{
					$action = Intertechno::IT_ACTION_3_ON;
				}	
			}	
		return $action;
	}	
	
	protected function SetPowerState($state)
	{
		$ITType = $this->ReadPropertyString('ITType');
		if ($state === true && $ITType === "Dimmer")
			{
			SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
			}
		elseif ($state === false && $ITType === "Dimmer")
			{
			SetValueInteger($this->GetIDForIdent('Dimmer'), 0);
			}
		SetValueBoolean($this->GetIDForIdent('STATE'), $state);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if ($state === true)
		{		
			if($lengthITFamilyCode == 1)
			{
				$action = Intertechno::ON;
			}
			else
			{
				$action = $this->GetActionCommand("on");
			}	
			return $this->SendCommand($action);
		}
		else
		{
			if($lengthITFamilyCode == 1)
			{
				$action = Intertechno::OFF;
			}
			else
			{
				$action = $this->GetActionCommand("off");
			}	
			return $this->SendCommand($action);
		}
	}
	
	   	
	//IT Befehl E bzw. 90 schaltet an
	public function PowerOn()
	{
		if ($this->ReadPropertyString('ITType') == "Dimmer")
		{
			SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
		}
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$action = Intertechno::ON;
			}
			else
			{
				$action = $this->GetActionCommand("on");
			}	
		return $this->SendCommand($action);
	}
		
	//IT Befehl 6 bzw. 80 schaltet aus
	public function PowerOff()
	{                
		if ($this->ReadPropertyString('ITType') == "Dimmer")
		{
			SetValueInteger($this->GetIDForIdent('Dimmer'), 0);
		}
		SetValueBoolean($this->GetIDForIdent('STATE'), false);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$action = Intertechno::OFF;
			}
			else
			{
				$action = $this->GetActionCommand("off");
			}	
		return $this->SendCommand($action);
	}
		
	//Senden eines Befehls an Intertechno
	// Sendestring IT /command?XC_FNC=SendSC&type=IT&data=
	private $response = false;
    protected function SendCommand($action)
    {
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $IT_send = $this->Calculate();
        $ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
        $lengthITFamilyCode = strlen($ITFamilyCode);
        if($lengthITFamilyCode == 7)
        {
            $IT_send = substr($IT_send, 0, 6);
        }
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
        if ($GatewayPassword !== "")
        {
            if($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E)
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=IT&data=".$IT_send.$action);
                $this->SendDebug("Address",$IT_send,0);
                $this->SendDebug("Action",$action,0);
                $this->SendDebug("AIOGateway","Senden an Gateway mit Passwort",0);
                $this->SendDebug("Send to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=IT&data=".$IT_send.$action,0);
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=IT&data=".$IT_send.$action);
                $this->SendDebug("Address",$IT_send,0);
                $this->SendDebug("Action",$action,0);
                $this->SendDebug("AIOGateway","Senden an Gateway mit Passwort",0);
                $this->SendDebug("Send to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=IT&data=".$IT_send.$action,0);
            }
        }
        else
        {
            $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=IT&data=".$IT_send.$action);
            $this->SendDebug("Address",$IT_send,0);
            $this->SendDebug("Action",$action,0);
            $this->SendDebug("Send to AIO Gateway","http://".$aiogatewayip."/command?XC_FNC=SendSC&type=IT&data=".$IT_send.$action,0);
        }

        if ($gwcheck == "{XC_SUC}")
        {
            $this->response = true;
        }
        elseif ($gwcheck == "{XC_AUT}")
        {
            //Passwort falsch
            $this->SendDebug("AIOGateway","Keine Authentizifierung möglich. Gateway Passwort ist falsch.",0);
        }
        return $this->response;
    }

	// ? - Auf 10% dimmen
	public function Set10()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 1);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_10_1;
			}
			else
			{
				$command = Intertechno::SET_10_2;
			}	
        return $this->SendCommand($command);
    }
	
	// ? - Auf 20% dimmen
	public function Set20()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 2);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
                $command = Intertechno::SET_20_1;
			}
			else
			{
				$command = Intertechno::SET_20_2;
			}	
        return $this->SendCommand($command);
    }
		
	// ? - Auf 30% dimmen
	public function Set30()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 3);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_30_1;
			}
			else
			{
				$command = Intertechno::SET_30_2;
			}	
        return $this->SendCommand($command);
    }

	// ? - Auf 40% dimmen
	public function Set40()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 4);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_40_1;
			}
			else
			{
				$command = Intertechno::SET_40_2;
			}	
        return $this->SendCommand($command);
    }

	// ? - Auf 50% dimmen
	public function Set50()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 5);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_50_1;
			}
			else
			{
				$command = Intertechno::SET_50_2;
			}	
        return $this->SendCommand($command);
    }

	// ? - Auf 60% dimmen
	public function Set60()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 6);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_60_1;
			}
			else
			{
				$command = Intertechno::SET_60_2;
			}	
        return $this->SendCommand($command);
    }

	// ? - Auf 70% dimmen
	public function Set70()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 7);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_70_1;
			}
			else
			{
				$command = Intertechno::SET_70_2;
			}
        return $this->SendCommand($command);
    }

	// ? - Auf 80% dimmen
	public function Set80()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 8);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_80_1;
			}
			else
			{
				$command = Intertechno::SET_80_2;
			}
        return $this->SendCommand($command);
    }

	// ? - Auf 90% dimmen
	public function Set90()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 9);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_90_1;
			}
			else
			{
				$command = Intertechno::SET_90_2;
			}
        return $this->SendCommand($command);
    }	
	
	// ? - Auf 100% dimmen
	public function Set100()
	{
		SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
		SetValueBoolean($this->GetIDForIdent('STATE'), true);
		$ITFamilyCode = $this->ReadPropertyString('ITFamilyCode');
		$lengthITFamilyCode = strlen($ITFamilyCode);
		if($lengthITFamilyCode == 1)
			{
				$command = Intertechno::SET_100_1;
			}
			else
			{
				$command = Intertechno::SET_100_2;
			}
        return $this->SendCommand($command);
    }
		
	
	//Anmelden eines IT Geräts an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=LearnSC&type=IT
    public function Learn()
    {
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
        if ($GatewayPassword !== "")
        {
            if($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E)
            {
                $address = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=LearnSC&type=IT");
                $this->SendDebug("AIOGateway","Senden an Gateway mit Passwort",0);
                $this->SendDebug("Send to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=LearnSC&type=IT",0);
            }
            else
            {
                $address = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=LearnSC&type=IT");
                $this->SendDebug("AIOGateway","Senden an Gateway mit Passwort",0);
                $this->SendDebug("Send to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=LearnSC&type=IT",0);
            }
        }
        else
        {
            $address = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=LearnSC&type=IT");
        }

        //kurze Pause während das Gateway im Lernmodus ist
        IPS_Sleep(1000); //1000 ms
        if ($address == "{XC_ERR}Failed to learn code")//Bei Fehler
        {
            $this->response = false;
            $address = "Das Gateway konnte keine Adresse empfangen.";
            $this->SendDebug("IT Adresse",$address,0);
            $this->SendDebug("AIO Gateway","Die Adresse vom IT Gerät konnte nicht angelernt werden.",0);
        }
        else
        {
            //Adresse auswerten {XC_SUC}
            //bei Erfolg {XC_SUC}{"CODE":"03"}
            //bei machen Rückmeldung {XC_SUC}{"CODE":"010006"}	 //FC 01 = B DC 00 = 1 und an/aus
            $length = strlen($address);
			$ITFamilyCode = false;
			$ITDeviceCode = false;
            if ($length == 25)
            {
                $address = strval(substr($address, 17, 4));
                $this->SendDebug("IT Adresse",$address,0);
                // Anpassen der Daten
                $address = explode(".", $address);
                $ITDeviceCode = $address[1]; // Devicecode
                $ITFamilyCode = $address[0]; // Familencode
                $this->SendDebug("IT Device Code",$ITDeviceCode,0);
                $this->SendDebug("IT Family Code",$ITFamilyCode,0);
            }
            elseif ($length == 21)
            {
                $address = strval(substr($address, 17, 2));
                $this->SendDebug("IT Adresse",$address,0);
                // Anpassen der Daten
                $address = explode(".", $address);
                $ITDeviceCode = ($address[1])+1; //Devicecode auf Original umrechen +1
                $ITFamilyCode = $address[0]; // Zahlencode in Buchstaben Familencode umwandeln


                $ITFamilyCode = ord(strtoupper($ITFamilyCode)) - ord('A');
				$ITFamilyCode = strtoupper(dechex($ITFamilyCode));
				$ITDeviceCode = intval($ITDeviceCode)-1;
				$ITDeviceCode = strtoupper(dechex($ITDeviceCode));
                $this->SendDebug("IT Device Code",$ITDeviceCode,0);
                $this->SendDebug("IT Family Code",$ITFamilyCode,0);
            }
            if($ITFamilyCode != false && $ITDeviceCode != false)
			{
				$this->AddAddress($ITFamilyCode, $ITDeviceCode);
			}

            $this->response = true;
        }

        return $this->response;
    }
	
	//IT Adresse hinzufügen
	protected function AddAddress($ITFamilyCode, $ITDeviceCode)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "ITFamilyCode", $ITFamilyCode); //ITFamilyCode setzten.
		IPS_SetProperty($instance, "ITDeviceCode", $ITDeviceCode); //ITDeviceCode setzten.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		$this->SendDebug("IT Device Code",$ITDeviceCode." hinzugefügt",0);
		$this->SendDebug("IT Family Code",$ITFamilyCode." hinzugefügt",0);
		$this->SetupVar();
		$this->SetupProfiles();
		// Status aktiv
		$this->SetStatus(102);
	}

	public function SendCommandKey(int $list_number)
	{
		$command_name = $this->GetListCommand($list_number);
		if($command_name != false)
		{
			$this->SendDebug("FS20 Send:", "send for command name ".$command_name, 0);
			$this->SendCommand($command_name);
		}
	}

	protected function GetListCommand($list_number)
	{
		$commands = $this->GetAvailableCommands();
		$i = 1;
		foreach ($commands as $key => $command) {
			if($list_number == $i)
			{
				return $key;
			}
			$i++;
		}
		return false;
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
		$address = $this->ReadPropertyString("address");
		$form = [];
		if($address == "")
		{
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'AIO Intertechno device'
					],
					[
						'type' => 'ExpansionPanel',
						'caption' => 'Intertechno address',
						'items' => [
							[
								'type' => 'Label',
								'caption' => 'Look up values in the AIO NEO'
							],
							[
								'name' => 'ITFamilyCode"',
								'type' => 'ValidationTextBox',
								'caption' => 'family code'
							],
							[
								'name' => 'ITDeviceCode',
								'type' => 'ValidationTextBox',
								'caption' => 'device cdde'
							],
							[
								'name' => 'Adresse',
								'type' => 'ValidationTextBox',
								'caption' => 'FS20 address'
							],
							[
								'type' => 'Label',
								'caption' => 'The AIO Gateway FS 20 address is calculated automatically.'
							],
							[
								'type' => 'Label',
								'caption' => 'Alternatively, only the AIO Gateway FS 20 address can be entered, then HC1, HC2, address can be empty.'
							],
							[
								'name' => 'AIOAdresse',
								'type' => 'ValidationTextBox',
								'caption' => 'AIO FS20 address'
							]
						]
					],
					[
						'type' => 'ExpansionPanel',
						'caption' => 'Intertechno device type',
						'items' => [
							[
								'type' => 'Select',
								'name' => 'ITType',
								'caption' => 'key',
								'options' => [
									[
										'caption' => 'Switch',
										'value' => 'Switch'
									],
									[
										'caption' => 'Dimmer',
										'value' => 'Dimmer'
									]
								]
							],
						]
					]
				]
			);
		}
		else
		{
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'AIO Intertechno device'
					],
					[
						'name' => 'address',
						'type' => 'ValidationTextBox',
						'caption' => 'AIO Intertechno address'
					],
					[
						'type' => 'ExpansionPanel',
						'caption' => 'Intertechno device type',
						'items' => [
							[
								'type' => 'Select',
								'name' => 'ITType',
								'caption' => 'key',
								'options' => [
									[
										'caption' => 'Switch',
										'value' => 'Switch'
									],
									[
										'caption' => 'Dimmer',
										'value' => 'Dimmer'
									]
								]
							],
						]
					]
				]
			);
		}
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
		if($address == "")
		{
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'ExpansionPanel',
						'caption' => 'Learn key',
						'items' => [
							[
								'type' => 'Button',
								'caption' => 'Learn',
								'onClick' => 'AIOIT_Learn($id);'
							]
						]
					]
				]
			);
		}

		$form = array_merge_recursive(
			$form,
			[
				[
					'type' => 'ExpansionPanel',
					'caption' => 'Send key',
					'items' => [
						[
							'type' => 'Select',
							'name' => 'sendkey',
							'caption' => 'key',
							'options' => $this->GetSendListCommands()
						],
						[
							'type' => 'Button',
							'caption' => 'Send',
							'onClick' => 'AIOIT_SendCommandKey($id, $sendkey);'
						]
					]
				]
			]
		);
		return $form;
	}

	protected function GetSendListCommands()
	{
		$form = [
			[
				'label' => 'Please Select',
				'value' => -1
			]
		];
		$commands = $this->GetAvailableCommands();
		$i = 1;
		foreach ($commands as $key => $command) {
			$form = array_merge_recursive(
				$form,
				[
					[
						'label' => $key,
						'value' => $i
					]
				]
			);
			$i++;
		}
		return $form;
	}

	public function GetAvailableCommands()
	{
		$ITType = $this->ReadPropertyString("ITType");
		$commands = [];
		if($ITType == "Switch")
		{
			$commands["On"] = 1;
			$commands["Off"] = 2;
		}
		else
		{
			$commands["On"] = 1;
			$commands["Off"] = 2;
		}
		return $commands;
	}

	/**
	 * return from status
	 * @return array
	 */
	protected function FormStatus()
	{
		$form = [
			[
				'code' => 101,
				'icon' => 'inactive',
				'caption' => 'Creating instance.'
			],
			[
				'code' => 102,
				'icon' => 'active',
				'caption' => 'AIO Intertechno device created'
			],
			[
				'code' => 104,
				'icon' => 'inactive',
				'caption' => 'AIO Intertechno device is inactive'
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
				'caption' => 'Family code consists of a letter or a string of 7 characters.'
			],
			[
				'code' => 204,
				'icon' => 'error',
				'caption' => 'Device code consists of a digit.'
			],
			[
				'code' => 205,
				'icon' => 'error',
				'caption' => 'Device code is not made of letters but of a number.'
			]
		];

		return $form;
	}
}

class Intertechno
{

    const IT_ACTION_1 = '80';
    const IT_ACTION_2 = '81';
    const IT_ACTION_3 = '00';
    const IT_ACTION_1_ON = '90';
    const IT_ACTION_1_OFF = '80';
    const IT_ACTION_2_ON = '91';
    const IT_ACTION_2_OFF = '81';
    const IT_ACTION_3_ON = '10';
    const IT_ACTION_3_OFF = '00';
    const ON = 'E';
    const OFF = '6';
    const SET_10_1 = 'E00'; // dim to 10%
    const SET_10_2 = '00'; // dim to 10%
    const SET_20_1 = 'E10'; // dim to 20%
    const SET_20_2 = '10'; // dim to 20%
    const SET_30_1 = 'E20'; // dim to 30%
    const SET_30_2 = '20'; // dim to 30%
    const SET_40_1 = 'E30'; // dim to 40%
    const SET_40_2 = '30'; // dim to 40%
    const SET_50_1 = 'E40'; // dim to 50%
    const SET_50_2 = '50'; // dim to 50%
    const SET_60_1 = 'E50'; // dim to 60%
    const SET_60_2 = '70'; // dim to 60%
    const SET_70_1 = 'E60'; // dim to 70%
    const SET_70_2 = '90'; // dim to 70%
    const SET_80_1 = 'E70'; // dim to 80%
    const SET_80_2 = 'B0'; // dim to 80%
    const SET_90_1 = 'E80'; // dim to 90%
    const SET_90_2 = 'D0'; // dim to 90%
    const SET_100_1 = 'E'; // dim to 100%
    const SET_100_2 = 'F0'; // dim to 100%
}
