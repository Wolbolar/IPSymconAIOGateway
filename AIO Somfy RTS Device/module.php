<?

require_once(__DIR__ . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."AIOGatewayClass.php");  // diverse Klassen

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
                $this->SetupProfiles();
                $this->SetupVar();
                // Status aktiv
                $this->SetStatus(102);
            }

        }
        elseif ($AIORTSAdresse == '')
        {
            // Status inaktiv
            $this->SetStatus(202);
        }
        else
        {


            //Eingabe überprüfen Länge 4 Zeichen nur Zahlen

            // Status aktiv
            $this->SetStatus(102);
            $this->SetupVar();
        }




    }

    protected function SetupVar()
    {
        //Status-Variablen anlegen
        $stateId = $this->RegisterVariableInteger("Somfy", "Somfy", "~ShutterMoveStop", 1);
        $this->EnableAction("Somfy");


    }



    public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Somfy":
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
            default:
                throw new Exception("Invalid ident");
        }
    }

    public function Up() {
        $command = "20";
        return $this->SendCommand($command);
    }

    public function Down() {
        $command = "40";
        return $this->SendCommand($command);
    }

    public function Stop() {
        $command = "10";
        return $this->SendCommand($command);
    }

    //Senden eines Befehls an Somfy RTS
    // Sendestring RTS {IP Gateway}/command?XC_FNC=SendSC&type=RT&data={RTS Send Adresse}{Command}
    private $response = false;
    protected function SendCommand(string $command)
    {
        $address = $this->ReadPropertyString('Adresse');
        $aiogateway = new AIOGateway($this->InstanceID);
        $gatewaytype = $aiogateway->GetGatewaytype();
        $GatewayPassword = $aiogateway->GetPassword();
        $aiogatewayip = $aiogateway->GetIPGateway();
        switch($command)
        {
            case "20": // Up, Öffnen
				SetValueInteger($this->GetIDForIdent('Somfy'), 0);
				break;
            case "40": // Down, Schließen
                SetValueInteger($this->GetIDForIdent('Somfy'), 4);
				break;
			case "10": //Stop
				SetValueInteger($this->GetIDForIdent('Somfy'), 2);
                break;
        }


        IPS_LogMessage( "Adresse:" , $address );
        IPS_LogMessage( "RTS Command:" , $command );
        //IPS_LogMessage( "AIO Gateway:" , "http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=RT&data=".$command.$address );
        if ($GatewayPassword !== "")
        {
            if($gatewaytype == 6 || $gatewaytype == 7)
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=SendSC&type=RT&data=".$command.$address);
            }
            else
            {
                $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=RT&data=".$command.$address);
            }
        }
        else
        {
            $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=SendSC&type=RT&data=".$command.$address);
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

    // Befehle 20 auf / 40 ab / 10 stop



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

    protected function RegisterProfileIntegerEx($Name, $Icon, $Prefix, $Suffix, $Associations) {
        if ( sizeof($Associations) === 0 ){
            $MinValue = 0;
            $MaxValue = 0;
        } else {
            $MinValue = $Associations[0][0];
            $MaxValue = $Associations[sizeof($Associations)-1][0];
        }

        $this->RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, 0);

        foreach($Associations as $Association) {
            IPS_SetVariableProfileAssociation($Name, $Association[0], $Association[1], $Association[2], $Association[3]);
        }

    }


}

?>