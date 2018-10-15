<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOSplitter extends IPSModule
{

    public function Create()
    {
//Never delete this line!
        parent::Create();
		
		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		$this->RequireParent("{82347F20-F541-41E1-AC5B-A636FD3AE2D8}"); // AIO Gateway UDP Socket
		//$this->RequireParent("{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}"); //Multicast Socket

        $this->RegisterPropertyString("Host", "");
		$this->RegisterPropertyInteger("Port", 1902);
        $this->RegisterPropertyBoolean("Open", false);
		$this->RegisterPropertyBoolean("GatewayLED", false);
		$this->RegisterPropertyString("Passwort", "");
        $this->RegisterPropertyInteger("gatewaytype", 4);
    }

    public function ApplyChanges()
    {
//Never delete this line!
        parent::ApplyChanges();
        $change = false;
		
		$this->RegisterVariableString("BufferIN", "BufferIN", "", 1);
        $this->RegisterVariableString("CommandOut", "CommandOut", "", 2);
		$this->RegisterVariableString("HomematicIN", "Letzter Homematic Befehl", "", 3);
		$this->RegisterVariableString("IRIN", "Letzter IR Befehl", "", 4);
		$this->RegisterVariableString("FS20IN", "Letzter FS20 Befehl", "", 5);
		$this->RegisterVariableString("ITIN", "Letzter Intertechno Befehl", "", 6);
		$this->RegisterVariableString("ELROIN", "Letzter ELRO Befehl", "", 7);
		
//IP Prüfen
		$ip = $this->ReadPropertyString('Host');
		$GatewayLED = $this->ReadPropertyBoolean("GatewayLED");
		if ($GatewayLED)
		{
			//Profil anlegen
			$this->RegisterProfileLEDGateway("LED.AIOGateway", "Bulb", "", "");
			
		
			//Variablen anlegen
			//Farbe
				$stateID = $this->RegisterVariableInteger("Farbe", "Farbe", "LED.AIOGateway", 1);
				$this->EnableAction("Farbe");
		}
		if (!filter_var($ip, FILTER_VALIDATE_IP) === false)
			{
						
			// Zwangskonfiguration des ClientSocket
			$ParentID = $this->GetParent();
				if (!($ParentID === false))
				{
					if (IPS_GetProperty($ParentID, 'Host') <> $this->ReadPropertyString('Host'))
					{
						IPS_SetProperty($ParentID, 'Host', $this->ReadPropertyString('Host'));
						$change = true;
					}
					if (IPS_GetProperty($ParentID, 'Port') <> $this->ReadPropertyInteger('Port'))
					{
						IPS_SetProperty($ParentID, 'Port', $this->ReadPropertyInteger('Port'));
						IPS_SetProperty($ParentID, 'BindPort', $this->ReadPropertyInteger('Port'));
						//IPS_SetProperty($ParentID, 'BindPort', true); // Reuse Adress			
						$change = true;
					}
					$ParentOpen = $this->ReadPropertyBoolean('Open');
					
					
				// Keine Verbindung erzwingen wenn IPAIOGateway leer ist, sonst folgt später Exception.
					if (!$ParentOpen)
						$this->SetStatus(104);

					if ($this->ReadPropertyString('Host') == '')
					{
						if ($ParentOpen)
							$this->SetStatus(202);
						$ParentOpen = false;
					}
					if (IPS_GetProperty($ParentID, 'Open') <> $ParentOpen)
					{
						IPS_SetProperty($ParentID, 'Open', $ParentOpen);
						$change = true;
					}
					if ($change)
						@IPS_ApplyChanges($ParentID);
				}
		
		}
		else
			{
			$this->SetStatus(203); //IP Adresse ist ungültig
			}	
		

		// Wenn I/O verbunden ist
        if (($this->ReadPropertyBoolean('Open'))
                and ( $this->HasActiveParent($ParentID)))
        {
            //Instanz aktiv
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
		
    public function RequestAction($Ident, $Value)
		{
			
			switch($Ident) {
				case "Farbe":
					switch($Value) {
						case 0: //Weiß
							$this->White();
							break;
						case 1: //Blue
							$this->Blue();
							break;
						case 2: //Green
							$this->Green();
							break;
						case 3: //Red
							$this->Red();
							break;
						case 4: //Off
							$this->LEDOff();
							break;
					}
					break;	
				default:
					throw new Exception("Invalid ident");
			}
		}	


    private function RegisterHook($WebHook, $TargetID)
    {
        $ids = IPS_GetInstanceListByModuleID("{015A6EB8-D6E5-4B93-B496-0D3F77AE9FE1}");
        if (sizeof($ids) > 0)
        {
            $hooks = json_decode(IPS_GetProperty($ids[0], "Hooks"), true);
            $found = false;
            foreach ($hooks as $index => $hook)
            {
                if ($hook['Hook'] == $WebHook)
                {
                    if ($hook['TargetID'] == $TargetID)
                        return;
                    $hooks[$index]['TargetID'] = $TargetID;
                    $found = true;
                }
            }
            if (!$found)
            {
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
        return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;
    }

    protected function HasActiveParent($ParentID)
    {
        if ($ParentID > 0)
        {
            $parent = IPS_GetInstance($ParentID);
            if ($parent['InstanceStatus'] == 102)
            {
                $this->SetStatus(102);
				//Task auslesen
				$this->GetTasksGateway();
                return true;
            }
        }
        $this->SetStatus(203);
        return false;
    }

    private function SetValueBoolean($Ident, $value)
    {
        $id = $this->GetIDForIdent($Ident);
        if (GetValueBoolean($id) <> $value)
        {
            SetValueBoolean($id, $value);
            return true;
        }
        return false;
    }

    private function SetValueInteger($Ident, $value)
    {
        $id = $this->GetIDForIdent($Ident);
        if (GetValueInteger($id) <> $value)
        {
            SetValueInteger($id, $value);
            return true;
        }
        return false;
    }

    private function SetValueString($Ident, $value)
    {
        $id = $this->GetIDForIdent($Ident);
        if (GetValueString($id) <> $value)
        {
            SetValueString($id, $value);
            return true;
        }
        return false;
    }


	protected function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize) {
        
        if(!IPS_VariableProfileExists($Name)) {
            IPS_CreateVariableProfile($Name, 1);
        } else {
            $profile = IPS_GetVariableProfile($Name);
            if($profile['ProfileType'] != 1)
            throw new Exception("Variable profile type does not match for profile ".$Name);
        }
        
        IPS_SetVariableProfileIcon($Name, $Icon);
        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
        
    }
    
	protected function GetTasksGateway()
	{
		$adress = $this->ReadPropertyString("Host");
		$password = $this->ReadPropertyString("Passwort");
		if ($password !== "")
		{
			$response = file_get_contents("http://".$adress."/command?XC_User=user&XC_PASS=".$password."&XC_FNC=GetStates");
		}
		else
		{
			$response = file_get_contents("http://".$adress."/command?XC_FNC=GetAll"); 
		}
	}
	
	protected function ActivateTask(integer $Tasknumber) //Tasknummer 2stellig 01 
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://".$adress."/command?XC_FNC=saveGroup&id=".$Tasknumber."&active=1"); 
	}
	
	protected function DeactiveTask(integer $Tasknumber)
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://".$adress."/command?XC_FNC=saveGroup&id=".$Tasknumber."&active=0"); 
	}
	
	protected function DelTask(integer $Tasknumber)
	{
				$adress = $this->ReadPropertyString("Host");
				file_get_contents("http://".$adress."/command?XC_FNC=DelTask&id=".$Tasknumber); 
	}
	protected function StartTask(integer $Tasknumber)
	{
		$adress = $this->ReadPropertyString("Host");
		file_get_contents("http://".$adress."/command?XC_FNC=doGroup&id=".$Tasknumber); 
	}
	
	protected function DelAllTasks()
	{
        $adress = $this->ReadPropertyString("Host");
	    file_get_contents("http://".$adress."/command?XC_FNC=fEEPReset&type=01");
	}
	
	protected function RegisterProfileLEDGateway($Name, $Icon, $Prefix, $Suffix) {
        
        if(!IPS_VariableProfileExists($Name)) {
            IPS_CreateVariableProfile($Name, 1);
        } else {
            $profile = IPS_GetVariableProfile($Name);
            if($profile['ProfileType'] != 1)
            throw new Exception("Variable profile type does not match for profile ".$Name);
        }
        $MinValue = 0;
		$MaxValue = 4;
		$StepSize = 1;
        IPS_SetVariableProfileIcon($Name, $Icon);
        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
		// boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe ) Farbwert im HTML Farbcode (z.b. 0x0000FF f�r Blau). Sonderfall: -1 f�r transparent
		IPS_SetVariableProfileAssociation($Name, 0, "Weiß", "", 0xFFFFFFF);
		IPS_SetVariableProfileAssociation($Name, 1, "Blau", "", 0x013ADF);
		IPS_SetVariableProfileAssociation($Name, 2, "Grün", "", 0x088A08);
		IPS_SetVariableProfileAssociation($Name, 3, "Rot", "", 0xFE2E2E);
		IPS_SetVariableProfileAssociation($Name, 4, "Aus", "", 0x585858);     
    }
	
	//LED White
	public function White()
		{
			$adress = $this->ReadPropertyString("Host");
			$command = "0105";
			SetValueInteger($this->GetIDForIdent('Farbe'), 0);
			$this->SendDebug("AIO Gateway","LED weiß",0);
			return $this->Set_LEDGW($adress, $command);
		}
	
	//LED Blue
	public function Blue()
		{
			$adress = $this->ReadPropertyString("Host");
			$command = "0102";
			SetValueInteger($this->GetIDForIdent('Farbe'), 1);
			$this->SendDebug("AIO Gateway","LED blau",0);
			return $this->Set_LEDGW($adress, $command);
		}
	
	//LED Green
	public function Green()
		{
			$adress = $this->ReadPropertyString("Host");
			$command = "0103";
			SetValueInteger($this->GetIDForIdent('Farbe'), 2);
			$this->SendDebug("AIO Gateway","LED grün",0);
			return $this->Set_LEDGW($adress, $command);
		}
	
	//LED Red
	public function Red()
		{
			$adress = $this->ReadPropertyString("Host");
			$command = "0106";
			SetValueInteger($this->GetIDForIdent('Farbe'), 3);
			$this->SendDebug("AIO Gateway","LED rot",0);
			return $this->Set_LEDGW($adress, $command);
		}
	
	//LED Off
	public function LEDOff()
		{
			$adress = $this->ReadPropertyString("Host");
			$command = "0101";
			SetValueInteger($this->GetIDForIdent('Farbe'), 4);
			$this->SendDebug("AIO Gateway","LED aus",0);
			return $this->Set_LEDGW($adress, $command);
		}	
	
	protected function Set_LEDGW($adress, $command)
		{
			file_get_contents("http://".$adress."/command?XC_FNC=SendSC&type=RGB&data=".$command);
			//$status = "power";
			//return $status;
		}
		
		
	// Data an Child weitergeben
	public function ReceiveData($JSONString)
	{
	 
	 
		// Empfangene Daten vom I/O
		$data = json_decode($JSONString);
		$this->SendDebug("ReceiveData AIO Gateway",utf8_decode($data->Buffer),0);
			 
		// Hier werden die Daten verarbeitet und in Variablen geschrieben
		
		$this->UpdateLastResponse($data->Buffer);
			 
		//echo utf8_decode($data->Buffer);
	 
		// Weiterleitung zu allen Gerät-/Device-Instanzen
		$this->SendDataToChildren(json_encode(Array("DataID" => "{1ED9A538-909B-44A6-A4C3-36D8EEB5A38A}", "Buffer" => $data->Buffer))); //AIOSplitter Interface GUI
	}

	
	################## DATAPOINT RECEIVE FROM CHILD

    // Type String, Declaration can be used when PHP 7 is available
    //public function ForwardData(string $JSONString)
    public function ForwardData($JSONString)
	{
	 
		// Empfangene Daten von der Device Instanz
		$data = json_decode($JSONString);
		$this->SendDebug("ForwardData AIO Gateway Splitter",utf8_decode($data->Buffer),0);
			 
		// Hier würde man den Buffer im Normalfall verarbeiten
		// z.B. CRC prüfen, in Einzelteile zerlegen
		try
		{
			//
		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
			echo ' in '.$ex->getFile().' line: '.$ex->getLine().'.';
		}
	 
		// Weiterleiten zur I/O Instanz
		$resultat = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => $data->Buffer))); //TX GUID
	 
		// Weiterverarbeiten und durchreichen
		return $resultat;
	 
	}
	
	protected function UpdateLastResponse($payload)
	{
		$pos = stripos($payload, '{"type"');

        if ($pos)
        {
            $json = substr($payload, 8, strlen($payload));
            $payload = json_decode($json);

            $type = $payload->type;
            $data = $payload->data;

            switch ($type)
            {
                case "HM": //Homematic
                    SetValue($this->GetIDForIdent("HomematicIN"), $data);
                    break;
                case "IR": //IR
                    //$irdatacode = strstr($data, '00010');
                    $num_of_timing = hexdec(substr($data,16, 2));
                    $start = $num_of_timing*8+17;
                    $irdatacode = substr($data, $start);
                    SetValue($this->GetIDForIdent("IRIN"), $irdatacode);
                    $this->SendDebug("Received IR Code",$irdatacode,0);
                    break;
                case "IT": //Intertechno
                    SetValue($this->GetIDForIdent("ITIN"), $data);
                    break;
                case "FS20": //FS20
                    SetValue($this->GetIDForIdent("FS20IN"), $data);
                    break;
                case "EL": //ELRO
                    SetValue($this->GetIDForIdent("ELROIN"), $data);
                    break;
            }
        }
	}
	
}

?>