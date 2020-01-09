<?php

require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . '/../libs/ProfileHelper.php';

use Fonzo\Mediola\AIOGateway;

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
						$this->SetupVar();
						// Status aktiv
						$this->SetStatus(IS_ACTIVE);
						}
						
					}
			elseif ($AIODooyaAdresse == '')
			{
				// Status inaktiv
				$this->SetStatus(202);
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
			//  register profiles
			$this->RegisterProfileAssociation(
				'Dooya.AIO',
				'Shutter',
				'',
				' %',
				0,
				4,
				1,
				0,
				vtInteger,
				[
					[0, $this->Translate('Move Down'), '', -1],
					[1, $this->Translate('Step down'), '', -1],
					[2, $this->Translate('Stop'), '', -1],
					[3, $this->Translate('Step up'), '', -1],
					[4, $this->Translate('Move up'), '', -1]
				]
			);
			$this->RegisterVariableInteger("Dooya", "Dooya", "Dooya.AIO", 1);
			$this->EnableAction("Dooya");
		}
	
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Dooya":
                switch($Value) {
                    case 0: // Move Down
						$this->MoveDown();
                        break;
                    case 1: // Step down
                        $this->StepDown();
                        break;
					case 2: // Stop
                        $this->Stop();
                        break;
					case 3: // Step Up
						$this->StepUp();
						break;
					case 4: // Move Up
						$this->MoveUp();
						break;
                }
                break;	
            default:
            	$this->SendDebug(__FUNCTION__, "Invalid ident", 0);
        }
    }

	public function MoveUp() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 4);
		return $this->SendCommand(\Fonzo\Mediola\Dooya::MoveUp);
	}

	public function MoveDown() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 0);
		return $this->SendCommand(\Fonzo\Mediola\Dooya::MoveDown);
	}

	public function StepUp() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 3);
		return $this->SendCommand(\Fonzo\Mediola\Dooya::StepUp);
        }
	
	public function StepDown() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 1);
		return $this->SendCommand(\Fonzo\Mediola\Dooya::StepDown);
        }
	
	public function Stop() {
		SetValueInteger($this->GetIDForIdent('Dooya'), 2);
		return $this->SendCommand(\Fonzo\Mediola\Dooya::Stop);
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
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address,0);
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address);
                $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address,0);
            }
		}
		else
		{
			$gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address);
            $this->SendDebug("String to AIO Gateway","http://".$aiogatewayip."/command?&XC_FNC=SendSC&type=". \Fonzo\Mediola\Dooya::Type ."&data=".$command.$address,0);
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
}
