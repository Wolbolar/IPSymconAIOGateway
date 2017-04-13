<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOHomematicSwitch extends IPSModule
{

   
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		
		$this->RegisterPropertyString("HomematicAddress", "");
		$this->RegisterPropertyString("HomematicData", "");
		$this->RegisterPropertyString("HomematicType", "");
		$this->RegisterPropertyString("HomematicTypeName", "");
		$this->RegisterPropertyString("HomematicSNR", "");
		$this->RegisterPropertyBoolean("LearnAddressHomematic", false);
		
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		// HomematicAddress prüfen
        $HomematicAddress = $this->ReadPropertyString('HomematicAddress');
        $LearnAddressHomematic = $this->ReadPropertyBoolean('LearnAddressHomematic');
		$HomematicType = $this->ReadPropertyString('HomematicType');
		$HomematicTypeName = $this->ReadPropertyString('HomematicTypeName');
				
		if ($LearnAddressHomematic)
		{
			$this->Learn();
		}
		elseif ( $HomematicAddress == '')
        {
            // Status inaktiv
            $this->SetStatus(104);
        }
		else 
		{
			//Eingabe überprüfen
			
			
			// Status aktiv
            $this->SetStatus(102);
			//Status-Variablen anlegen
			/*
			•	error
			•	state
			*/
			$ErrorId = $this->RegisterVariableBoolean("Error", "Error", "~Switch", 1);
			//$this->EnableAction("Error");
			$stateId = $this->RegisterVariableBoolean("STATE", "Status", "~Switch", 2);
			$this->EnableAction("STATE");
			if($HomematicTypeName == "HM-LC-Sw4-WM")
			{
				$stateId = $this->RegisterVariableBoolean("STATE2", "Status Kanal 2", "~Switch", 3);
				$this->EnableAction("STATE2");
				$stateId = $this->RegisterVariableBoolean("STATE3", "Status Kanal 3", "~Switch", 4);
				$this->EnableAction("STATE3");
				$stateId = $this->RegisterVariableBoolean("STATE4", "Status Kanal 4", "~Switch", 5);
				$this->EnableAction("STATE4");
			}
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
					$Channel = "01";
					$this->HomematicPowerSetState($Value, $Channel);
					break;
				case "STATE2":
					$Channel = "02";
					$this->HomematicPowerSetState($Value, $Channel);
					break;
				case "STATE3":
					$Channel = "03";
					$this->HomematicPowerSetState($Value, $Channel);
					break;
				case "STATE4":
					$Channel = "04";
					$this->HomematicPowerSetState($Value, $Channel);
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
	
	public function PowerOn() {
            $HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
		
	public function PowerOff() {
			$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
	
	public function Channel1On() {
            $HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."01";
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
		
	public function Channel1Off() {
			$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."01";
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
	
	public function Channel2On() {
            $HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."02";
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
		
	public function Channel2Off() {
			$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."02";
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }	
	
	public function Channel3On() {
            $HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."03";
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
		
	public function Channel3Off() {
			$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."03";
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
	
	public function Channel4On() {
            $HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."04";
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
		
	public function Channel4Off() {
			$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
			$HomematicAddress = substr($HomematicAddress, 0, 6)."04";
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
        }
	
	//IP Gateway 
	protected function GetIPGateway(){
		$ParentID = $this->GetParent();
		$IPGateway = IPS_GetProperty($ParentID, 'Host');
		return $IPGateway;
	}
	
	protected function GetPassword(){
		$ParentID = $this->GetParent();
		$GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
		return $GatewayPassword;
	}
	
	protected function HomematicPowerSetState ($state, $channel)
	{
		if($channel == "01")
		{
			SetValueBoolean($this->GetIDForIdent('STATE'), $state);
		}
		elseif($channel == "02")
		{
			SetValueBoolean($this->GetIDForIdent('STATE2'), $state);
		}
		elseif($channel == "03")
		{
			SetValueBoolean($this->GetIDForIdent('STATE3'), $state);
		}
		elseif($channel == "04")
		{
			SetValueBoolean($this->GetIDForIdent('STATE4'), $state);
		}
	return $this->SetPowerState($state, $channel);	
	}
	
	protected function SetPowerState($state, $channel)
	{
		$HomematicAddress = $this->ReadPropertyString("HomematicAddress");
		if($channel == "01")
		{
			$HomematicAddress = substr($HomematicAddress, 0, 6)."01";
		}
		elseif($channel == "02")
		{
			$HomematicAddress = substr($HomematicAddress, 0, 6)."02";
		}
		elseif($channel == "03")
		{
			$HomematicAddress = substr($HomematicAddress, 0, 6)."03";
		}
		elseif($channel == "04")
		{
			$HomematicAddress = substr($HomematicAddress, 0, 6)."04";
		}
		if ($state === true)
		{	
			$action = "01";
			return $this->Send_Homematic($HomematicAddress, $action);	
		}
		else
		{
			$action = "02";
			return $this->Send_Homematic($HomematicAddress, $action);	
		}
	}
	
		
	//Senden eines Befehls an Homematic
	protected function Send_Homematic($HomematicAddress, $action)
		{
		$GatewayPassword = $this->GetPassword();
		$Homematic_send = $HomematicAddress.$action;
		if ($action === "01")
			{
			// Sendestring Homematic XC_FNC=SendSC&type=HM&data=[Adresse][Kanal][Befehl]  z.B. 130B990101
			if ($GatewayPassword !== "")
			{
				$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=HM&data=".$Homematic_send); 
				$this->SendDebug("String to AIO Gateway","http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=HM&data=".$Homematic_send,0);
			}
			else
			{
				$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=HM&data=".$Homematic_send);
				$this->SendDebug("String to AIO Gateway","http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=HM&data=".$Homematic_send,0);
			}
			
			$status = true;
			return $status;
			}
		else
			{
			if ($GatewayPassword != "")
			{
				$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=HM&data=".$Homematic_send);
				$this->SendDebug("String to AIO Gateway","http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=HM&data=".$Homematic_send,0);
			}
			else
			{
				$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=HM&data=".$Homematic_send);
				$this->SendDebug("String to AIO Gateway","http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=HM&data=".$Homematic_send,0);
			}
			
			$status = false;
			return $status;
			}

		}
	
	private $response = false;
	//Anmelden eines Homematic Geräts an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=LearnSC&type=ELRO
	public function Learn()
		{
		$HomematicSNR = $this->ReadPropertyString('HomematicSNR');	
		$GatewayPassword = $this->GetPassword();	
		if ($GatewayPassword !== "")
			{
				$aioresponse = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=learnSC&adr=".$HomematicSNR);
				$this->SendDebug("String to AIO Gateway","/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=learnSC&adr=".$HomematicSNR,0);
				$this->SendDebug("Homematic Adress",$address,0);
			}
			else
			{
				$aioresponse = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=learnSC&adr=".$HomematicSNR);
				$this->SendDebug("String to AIO Gateway","http://".$this->GetIPGateway()."/command?XC_FNC=learnSC&adr=".$HomematicSNR,0);
				$this->SendDebug("Homematic Adress",$address,0);
			}
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($aioresponse == "{XC_ERR}Failed to learn code")//Bei Fehler
			{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			$this->SendDebug("Homematic Adresse:",$address,0);
			IPS_LogMessage( "Homematic Adresse:" , $address );
			echo "Die Adresse vom Homematic Gerät konnte nicht angelernt werden.";
			IPS_SetProperty($instance, "LearnAddressHomematic", false); //Haken entfernen.			
			}
		else
			{
				//Adresse auswerten {XC_SUC}
				//bei Erfolg {XC_SUC}{"adr":"130B99", "type":"0011"} 
				$length = strlen($aioresponse);
				(string)$jsonresponse = substr($aioresponse, 8, $length);
				$data = json_decode($jsonresponse);
				$adress = $data->adr;
				$type = $data->type;
				IPS_LogMessage( "Homematic Adresse:" , $address );
				$this->AddAddress($address, $type);
				$this->response = true;	
			}
		
		return $this->response;
		}
	
	//Adresse hinzufügen
	protected function AddAddress($address, $type)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "HomematicAddress", $address); //Adresse setzten.
		IPS_SetProperty($instance, "HomematicType", $type); // Typ setzten.
		IPS_SetProperty($instance, "LearnAddressHomematic", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage( "Homematic Adresse hinzugefügt:" , $address );
		// Status aktiv
        $this->SetStatus(102);
		//Status-Variablen anlegen
		$stateId = $this->RegisterVariableBoolean("STATE", "Status", "~Switch", 1);
		$this->EnableAction("STATE");	
	}

}

?>