<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIORFDevice extends IPSModule
{

    public function Create()
    {
        //Never delete this line!
        parent::Create();
		
		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        // 1. Verfügbarer AIO-Splitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		
		$this->RegisterPropertyString("RFLabel1", "");
		$this->RegisterPropertyString("RFCode1", "");
		$this->RegisterPropertyString("RFLabel2", "");
		$this->RegisterPropertyString("RFCode2", "");
		$this->RegisterPropertyString("RFLabel3", "");
		$this->RegisterPropertyString("RFCode3", "");
		$this->RegisterPropertyString("RFLabel4", "");
		$this->RegisterPropertyString("RFCode4", "");
		$this->RegisterPropertyString("RFLabel5", "");
		$this->RegisterPropertyString("RFCode5", "");
		$this->RegisterPropertyString("RFLabel6", "");
		$this->RegisterPropertyString("RFCode6", "");
		$this->RegisterPropertyString("RFLabel7", "");
		$this->RegisterPropertyString("RFCode7", "");
		$this->RegisterPropertyString("RFLabel8", "");
		$this->RegisterPropertyString("RFCode8", "");
		$this->RegisterPropertyString("RFLabel9", "");
		$this->RegisterPropertyString("RFCode9", "");
		$this->RegisterPropertyString("RFLabel10", "");
		$this->RegisterPropertyString("RFCode10", "");
		$this->RegisterPropertyString("RFLabel11", "");
		$this->RegisterPropertyString("RFCode11", "");
		$this->RegisterPropertyString("RFLabel12", "");
		$this->RegisterPropertyString("RFCode12", "");
		$this->RegisterPropertyString("RFLabel13", "");
		$this->RegisterPropertyString("RFCode13", "");
		$this->RegisterPropertyString("RFLabel14", "");
		$this->RegisterPropertyString("RFCode14", "");
		$this->RegisterPropertyString("RFLabel15", "");
		$this->RegisterPropertyString("RFCode15", "");
		$this->RegisterPropertyString("RFLabel16", "");
		$this->RegisterPropertyString("RFCode16", "");
		$this->RegisterPropertyString("RFLabel17", "");
		$this->RegisterPropertyString("RFCode17", "");
		$this->RegisterPropertyString("RFLabel18", "");
		$this->RegisterPropertyString("RFCode18", "");
		$this->RegisterPropertyString("RFLabel19", "");
		$this->RegisterPropertyString("RFCode19", "");
		$this->RegisterPropertyString("RFLabel20", "");
		$this->RegisterPropertyString("RFCode20", "");
		$this->RegisterPropertyString("RFLabel21", "");
		$this->RegisterPropertyString("RFCode21", "");
		$this->RegisterPropertyString("RFLabel22", "");
		$this->RegisterPropertyString("RFCode22", "");
		$this->RegisterPropertyString("RFLabel23", "");
		$this->RegisterPropertyString("RFCode23", "");
		$this->RegisterPropertyString("RFLabel24", "");
		$this->RegisterPropertyString("RFCode24", "");
		$this->RegisterPropertyString("RFLabel25", "");
		$this->RegisterPropertyString("RFCode25", "");
		$this->RegisterPropertyString("RFLabel26", "");
		$this->RegisterPropertyString("RFCode26", "");
		$this->RegisterPropertyString("RFLabel27", "");
		$this->RegisterPropertyString("RFCode27", "");
		$this->RegisterPropertyString("RFLabel28", "");
		$this->RegisterPropertyString("RFCode28", "");
		$this->RegisterPropertyString("RFLabel29", "");
		$this->RegisterPropertyString("RFCode29", "");
		$this->RegisterPropertyString("RFLabel30", "");
		$this->RegisterPropertyString("RFCode30", "");
		$this->RegisterPropertyString("RFLabel31", "");
		$this->RegisterPropertyString("RFCode31", "");
		$this->RegisterPropertyString("RFLabel32", "");
		$this->RegisterPropertyString("RFCode32", "");
		$this->RegisterPropertyString("RFLabel33", "");
		$this->RegisterPropertyString("RFCode33", "");
		$this->RegisterPropertyString("RFLabel34", "");
		$this->RegisterPropertyString("RFCode34", "");
		$this->RegisterPropertyString("RFLabel35", "");
		$this->RegisterPropertyString("RFCode35", "");
		$this->RegisterPropertyString("RFLabel36", "");
		$this->RegisterPropertyString("RFCode36", "");
		$this->RegisterPropertyString("RFLabel37", "");
		$this->RegisterPropertyString("RFCode37", "");
		$this->RegisterPropertyString("RFLabel38", "");
		$this->RegisterPropertyString("RFCode38", "");
		$this->RegisterPropertyString("RFLabel39", "");
		$this->RegisterPropertyString("RFCode39", "");
		$this->RegisterPropertyString("RFLabel40", "");
		$this->RegisterPropertyString("RFCode40", "");
		$this->RegisterPropertyString("RFLabel41", "");
		$this->RegisterPropertyString("RFCode41", "");
		$this->RegisterPropertyString("RFLabel42", "");
		$this->RegisterPropertyString("RFCode42", "");
		$this->RegisterPropertyString("RFLabel43", "");
		$this->RegisterPropertyString("RFCode43", "");
		$this->RegisterPropertyString("RFLabel44", "");
		$this->RegisterPropertyString("RFCode44", "");
		$this->RegisterPropertyString("RFLabel45", "");
		$this->RegisterPropertyString("RFCode45", "");
		$this->RegisterPropertyString("RFLabel46", "");
		$this->RegisterPropertyString("RFCode46", "");
		$this->RegisterPropertyString("RFLabel47", "");
		$this->RegisterPropertyString("RFCode47", "");
		$this->RegisterPropertyString("RFLabel48", "");
		$this->RegisterPropertyString("RFCode48", "");
		$this->RegisterPropertyString("RFLabel49", "");
		$this->RegisterPropertyString("RFCode49", "");
		$this->RegisterPropertyString("RFLabel50", "");
		$this->RegisterPropertyString("RFCode50", "");
		$this->RegisterPropertyString("RFLabel51", "");
		$this->RegisterPropertyString("RFCode51", "");
		$this->RegisterPropertyString("RFLabel52", "");
		$this->RegisterPropertyString("RFCode52", "");
		$this->RegisterPropertyString("RFLabel53", "");
		$this->RegisterPropertyString("RFCode53", "");
		$this->RegisterPropertyString("RFLabel54", "");
		$this->RegisterPropertyString("RFCode54", "");
		$this->RegisterPropertyString("RFLabel55", "");
		$this->RegisterPropertyString("RFCode55", "");
		$this->RegisterPropertyString("RFLabel56", "");
		$this->RegisterPropertyString("RFCode56", "");
		$this->RegisterPropertyString("RFLabel57", "");
		$this->RegisterPropertyString("RFCode57", "");
		$this->RegisterPropertyString("RFLabel58", "");
		$this->RegisterPropertyString("RFCode58", "");
		$this->RegisterPropertyString("RFLabel59", "");
		$this->RegisterPropertyString("RFCode59", "");
		$this->RegisterPropertyString("RFLabel60", "");
		$this->RegisterPropertyString("RFCode60", "");
		$this->RegisterPropertyString("RFLabel61", "");
		$this->RegisterPropertyString("RFCode61", "");
		$this->RegisterPropertyString("RFLabel62", "");
		$this->RegisterPropertyString("RFCode62", "");
		$this->RegisterPropertyString("RFLabel63", "");
		$this->RegisterPropertyString("RFCode63", "");
		$this->RegisterPropertyString("RFLabel64", "");
		$this->RegisterPropertyString("RFCode64", "");
		$this->RegisterPropertyString("RFLabel65", "");
		$this->RegisterPropertyString("RFCode65", "");
		$this->RegisterPropertyString("RFLabel66", "");
		$this->RegisterPropertyString("RFCode66", "");
		$this->RegisterPropertyString("RFLabel67", "");
		$this->RegisterPropertyString("RFCode67", "");
		$this->RegisterPropertyString("RFLabel68", "");
		$this->RegisterPropertyString("RFCode68", "");
		$this->RegisterPropertyString("RFLabel69", "");
		$this->RegisterPropertyString("RFCode69", "");
		$this->RegisterPropertyString("RFLabel70", "");
		$this->RegisterPropertyString("RFCode70", "");
		$this->RegisterPropertyString("RFLabel71", "");
		$this->RegisterPropertyString("RFCode71", "");
		$this->RegisterPropertyString("RFLabel72", "");
		$this->RegisterPropertyString("RFCode72", "");
		$this->RegisterPropertyString("RFLabel73", "");
		$this->RegisterPropertyString("RFCode73", "");
		$this->RegisterPropertyString("RFLabel74", "");
		$this->RegisterPropertyString("RFCode74", "");
		$this->RegisterPropertyString("RFLabel75", "");
		$this->RegisterPropertyString("RFCode75", "");
		$this->RegisterPropertyString("RFLabel76", "");
		$this->RegisterPropertyString("RFCode76", "");
		$this->RegisterPropertyString("RFLabel77", "");
		$this->RegisterPropertyString("RFCode77", "");
		$this->RegisterPropertyString("RFLabel78", "");
		$this->RegisterPropertyString("RFCode78", "");
		$this->RegisterPropertyString("RFLabel79", "");
		$this->RegisterPropertyString("RFCode79", "");
		$this->RegisterPropertyString("RFLabel80", "");
		$this->RegisterPropertyString("RFCode80", "");
		$this->RegisterPropertyString("RFLabel81", "");
		$this->RegisterPropertyString("RFCode81", "");
		$this->RegisterPropertyString("RFLabel82", "");
		$this->RegisterPropertyString("RFCode82", "");
		$this->RegisterPropertyString("RFLabel83", "");
		$this->RegisterPropertyString("RFCode83", "");
		$this->RegisterPropertyString("RFLabel84", "");
		$this->RegisterPropertyString("RFCode84", "");
		$this->RegisterPropertyString("RFLabel85", "");
		$this->RegisterPropertyString("RFCode85", "");
		$this->RegisterPropertyString("RFLabel86", "");
		$this->RegisterPropertyString("RFCode86", "");
		$this->RegisterPropertyString("RFLabel87", "");
		$this->RegisterPropertyString("RFCode87", "");
		$this->RegisterPropertyString("RFLabel88", "");
		$this->RegisterPropertyString("RFCode88", "");
		$this->RegisterPropertyString("RFLabel89", "");
		$this->RegisterPropertyString("RFCode89", "");
		$this->RegisterPropertyString("RFLabel90", "");
		$this->RegisterPropertyString("RFCode90", "");
		$this->RegisterPropertyString("RFLabel91", "");
		$this->RegisterPropertyString("RFCode91", "");
		$this->RegisterPropertyString("RFLabel92", "");
		$this->RegisterPropertyString("RFCode92", "");
		$this->RegisterPropertyString("RFLabel93", "");
		$this->RegisterPropertyString("RFCode93", "");
		$this->RegisterPropertyString("RFLabel94", "");
		$this->RegisterPropertyString("RFCode94", "");
		$this->RegisterPropertyString("RFLabel95", "");
		$this->RegisterPropertyString("RFCode95", "");
		$this->RegisterPropertyString("RFLabel96", "");
		$this->RegisterPropertyString("RFCode96", "");
		$this->RegisterPropertyString("RFLabel97", "");
		$this->RegisterPropertyString("RFCode97", "");
		$this->RegisterPropertyString("RFLabel98", "");
		$this->RegisterPropertyString("RFCode98", "");
		$this->RegisterPropertyString("RFLabel99", "");
		$this->RegisterPropertyString("RFCode99", "");
		$this->RegisterPropertyString("RFLabel100", "");
		$this->RegisterPropertyString("RFCode100", "");

		
		$this->RegisterPropertyBoolean("RFStatus", false);
		$this->RegisterPropertyInteger("PowerOnCode", 1);
		$this->RegisterPropertyInteger("PowerOffCode", 2);
		$this->RegisterPropertyInteger("NumberRFCodes", 0);
		$this->RegisterPropertyBoolean("LearnRFCode", false);
		$this->RegisterPropertyInteger("LearnRFCodeID", 1);
       
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		
		$RFCode1 = $this->ReadPropertyString("RFCode1");
		$RFCode2 = $this->ReadPropertyString("RFCode2");
		$RFLabel1 = $this->ReadPropertyString("RFLabel1");
		$RFLabel2 = $this->ReadPropertyString("RFLabel2");
		$LearnRFCode = $this->ReadPropertyBoolean('LearnRFCode');
		$NumberRFCodes = $this->ReadPropertyString("NumberRFCodes");
		$RFStatus = $this->ReadPropertyString("RFStatus");
		
		//Mögliche Prüfungen durchführen
		if ($LearnRFCode)
		{
			$irid = $this->ReadPropertyInteger("LearnRFCodeID");
			$this->Learn($irid);
		}
		//elseif ( $RFCode1 == '' or $RFCode2 == '' or $RFLabel1 == '' or $RFLabel2 == '')
		elseif ( $RFCode1 == '' or $RFLabel1 == '')
        {
            // Status Error Felder dürfen nicht leer sein
            $this->SetStatus(202);
        }
		/*
		elseif ($RFStatus == true && ($RFCode1 == '' or $RFCode2 == '' or $RFLabel1 == '' or $RFLabel2 == ''))
		{
            // Status Error Feld 1 und Feld 2 müssen  dürfen nicht leer sein
            $this->SetStatus(202);
        }
		*/
		else 
		{
			if ($NumberRFCodes == 0) //bei Manueller Eingabe von RF Codes wenn die Anzahl der Codes nicht gesetzt wurde Anzahl berechnen
			{
				$RFCodes = $this->ArrRFCodes();
				//Anzahl an IR Codes
				for ($i = 0; $i <= 99; $i++)
				{
					if (empty($RFCodes[$i][1]))
					{
						$NumberRFCodes = $i; //Anzahl der RFCodes mit Inhalt beim ersten leeren Feld wird abgebrochen
						break;	
					}
					
				}
				$this->CreateProfileRF($NumberRFCodes);
				
			}
			else
			{
					$this->CreateProfileRF($NumberRFCodes);
			}
			
			// Status aktiv
            $this->SetStatus(102);
		}	
		
		
		
		//Variablen bei Bedarf
		//Add/Remove according to feature activation
		// create link list for deletion of liks if target is deleted
        $links = Array();
        foreach( IPS_GetLinkList() as $key=>$LinkID ){
            $links[] =  Array( ('LinkID') => $LinkID, ('TargetID') =>  IPS_GetLink($LinkID)['TargetID'] );
        }
		
		// Statusanzeige
        if ($this->ReadPropertyBoolean("RFStatus")){
            $stateIR = $this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
			$this->EnableAction("Status");
        }else{
            $this->removeVariableAction("Status", $links);
        }
		
       		
	}
	
	/**
    * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
    * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
    *
	* 
    */
	protected function CreateProfileRF($NumberRFCodes)
	{
		//$irprofilname = str_replace(' ','',(trim(IPS_GetName(IPS_GetInstance($this->InstanceID)["InstanceID"])))); //Profilname darf keine Leerzeichen enthalten !!!!
		$rfprofilname = str_replace(' ','',(trim(IPS_GetName($this->InstanceID)))); //Profilname darf keine Leerzeichen enthalten !!!!
		$profilname1 = $rfprofilname."1.AIORF";	
		$profilname2 = $rfprofilname."2.AIORF";
		$profilname3 = $rfprofilname."3.AIORF";
		$profilname4 = $rfprofilname."4.AIORF";	
		
		// Start create profiles
		if ($NumberRFCodes <=32)
			{
			$end = ($NumberRFCodes-1);
			
			$this->RegisterProfileRFCodes($profilname1, "Keyboard", 0, $end, $NumberRFCodes);
		
		
			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("RFCODES1", "RF Codes", $profilname1, 29);
			$this->EnableAction("RFCODES1");	
			}
		elseif	($NumberRFCodes <=64 && $NumberRFCodes >32 )
			{
			$end = ($NumberRFCodes-33);	
			$this->RegisterProfileRFCodes($profilname1, "Keyboard", 0, 31, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname2, "Keyboard", 32, $end, $NumberRFCodes);
			
			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("RFCODES1", "RF Codes", $profilname1, 29);
			$this->EnableAction("RFCODES1");	
			$this->RegisterVariableInteger("RFCODES2", "RF Codes", $profilname2, 30);
			$this->EnableAction("RFCODES2");	
			}
		elseif	($NumberRFCodes <=96 && $NumberRFCodes >64)
			{
			$end = ($NumberRFCodes-65);
			$this->RegisterProfileRFCodes($profilname1, "Keyboard", 0, 31, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname2, "Keyboard", 32, 63, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname3, "Keyboard", 64, $end, $NumberRFCodes);
			
			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("RFCODES1", "RF Codes", $profilname1, 29);
			$this->EnableAction("RFCODES1");	
			$this->RegisterVariableInteger("RFCODES2", "RF Codes", $profilname2, 30);
			$this->EnableAction("RFCODES2");
			$this->RegisterVariableInteger("RFCODES3", "RF Codes", $profilname3, 31);
			$this->EnableAction("RFCODES3");				
			}
		elseif	($NumberRFCodes <=100 && $NumberRFCodes >96)
			{
			$end = ($NumberRFCodes-97);	
			$this->RegisterProfileRFCodes($profilname1, "Keyboard", 0, 31, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname2, "Keyboard", 32, 63, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname3, "Keyboard", 64, 95, $NumberRFCodes);
			$this->RegisterProfileRFCodes($profilname4, "Keyboard", 96, $end, $NumberRFCodes);
			
			
			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("RFCODES1", "RF Codes", $profilname1, 29);
			$this->EnableAction("RFCODES1");	
			$this->RegisterVariableInteger("RFCODES2", "RF Codes", $profilname2, 30);
			$this->EnableAction("RFCODES2");
			$this->RegisterVariableInteger("RFCODES3", "RF Codes", $profilname3, 31);
			$this->EnableAction("RFCODES3");
			$this->RegisterVariableInteger("RFCODES4", "RF Codes", $profilname4, 32);
			$this->EnableAction("RFCODES4");		
			}
	}
			
	
	
	
	protected function ArrRFCodes()
	{
		$RFCodes = array();
		$RFCodes[0][0] = $this->ReadPropertyString("RFLabel1");
		$RFCodes[0][1] = $this->ReadPropertyString("RFCode1");
		$RFCodes[1][0] = $this->ReadPropertyString("RFLabel2");
		$RFCodes[1][1] = $this->ReadPropertyString("RFCode2");
		$RFCodes[2][0] = $this->ReadPropertyString("RFLabel3");
		$RFCodes[2][1] = $this->ReadPropertyString("RFCode3");
		$RFCodes[3][0] = $this->ReadPropertyString("RFLabel4");
		$RFCodes[3][1] = $this->ReadPropertyString("RFCode4");
		$RFCodes[4][0] = $this->ReadPropertyString("RFLabel5");
		$RFCodes[4][1] = $this->ReadPropertyString("RFCode5");
		$RFCodes[5][0] = $this->ReadPropertyString("RFLabel6");
		$RFCodes[5][1] = $this->ReadPropertyString("RFCode6");
		$RFCodes[6][0] = $this->ReadPropertyString("RFLabel7");
		$RFCodes[6][1] = $this->ReadPropertyString("RFCode7");
		$RFCodes[7][0] = $this->ReadPropertyString("RFLabel8");
		$RFCodes[7][1] = $this->ReadPropertyString("RFCode8");
		$RFCodes[8][0] = $this->ReadPropertyString("RFLabel9");
		$RFCodes[8][1] = $this->ReadPropertyString("RFCode9");
		$RFCodes[9][0] = $this->ReadPropertyString("RFLabel10");
		$RFCodes[9][1] = $this->ReadPropertyString("RFCode10");
		$RFCodes[10][0] = $this->ReadPropertyString("RFLabel11");
		$RFCodes[10][1] = $this->ReadPropertyString("RFCode11");
		$RFCodes[11][0] = $this->ReadPropertyString("RFLabel12");
		$RFCodes[11][1] = $this->ReadPropertyString("RFCode12");
		$RFCodes[12][0] = $this->ReadPropertyString("RFLabel13");
		$RFCodes[12][1] = $this->ReadPropertyString("RFCode13");
		$RFCodes[13][0] = $this->ReadPropertyString("RFLabel14");
		$RFCodes[13][1] = $this->ReadPropertyString("RFCode14");
		$RFCodes[14][0] = $this->ReadPropertyString("RFLabel15");
		$RFCodes[14][1] = $this->ReadPropertyString("RFCode15");
		$RFCodes[15][0] = $this->ReadPropertyString("RFLabel16");
		$RFCodes[15][1] = $this->ReadPropertyString("RFCode16");
		$RFCodes[16][0] = $this->ReadPropertyString("RFLabel17");
		$RFCodes[16][1] = $this->ReadPropertyString("RFCode17");
		$RFCodes[17][0] = $this->ReadPropertyString("RFLabel18");
		$RFCodes[17][1] = $this->ReadPropertyString("RFCode18");
		$RFCodes[18][0] = $this->ReadPropertyString("RFLabel19");
		$RFCodes[18][1] = $this->ReadPropertyString("RFCode19");
		$RFCodes[19][0] = $this->ReadPropertyString("RFLabel20");
		$RFCodes[19][1] = $this->ReadPropertyString("RFCode20");
		$RFCodes[20][0] = $this->ReadPropertyString("RFLabel21");
		$RFCodes[20][1] = $this->ReadPropertyString("RFCode21");
		$RFCodes[21][0] = $this->ReadPropertyString("RFLabel22");
		$RFCodes[21][1] = $this->ReadPropertyString("RFCode22");
		$RFCodes[22][0] = $this->ReadPropertyString("RFLabel23");
		$RFCodes[22][1] = $this->ReadPropertyString("RFCode23");
		$RFCodes[23][0] = $this->ReadPropertyString("RFLabel24");
		$RFCodes[23][1] = $this->ReadPropertyString("RFCode24");
		$RFCodes[24][0] = $this->ReadPropertyString("RFLabel25");
		$RFCodes[24][1] = $this->ReadPropertyString("RFCode25");
		$RFCodes[25][0] = $this->ReadPropertyString("RFLabel26");
		$RFCodes[25][1] = $this->ReadPropertyString("RFCode26");
		$RFCodes[26][0] = $this->ReadPropertyString("RFLabel27");
		$RFCodes[26][1] = $this->ReadPropertyString("RFCode27");
		$RFCodes[27][0] = $this->ReadPropertyString("RFLabel28");
		$RFCodes[27][1] = $this->ReadPropertyString("RFCode28");
		$RFCodes[28][0] = $this->ReadPropertyString("RFLabel29");
		$RFCodes[28][1] = $this->ReadPropertyString("RFCode29");
		$RFCodes[29][0] = $this->ReadPropertyString("RFLabel30");
		$RFCodes[29][1] = $this->ReadPropertyString("RFCode30");
		$RFCodes[30][0] = $this->ReadPropertyString("RFLabel31");
		$RFCodes[30][1] = $this->ReadPropertyString("RFCode31");
		$RFCodes[31][0] = $this->ReadPropertyString("RFLabel32");
		$RFCodes[31][1] = $this->ReadPropertyString("RFCode32");
		$RFCodes[32][0] = $this->ReadPropertyString("RFLabel33");
		$RFCodes[32][1] = $this->ReadPropertyString("RFCode33");
		$RFCodes[33][0] = $this->ReadPropertyString("RFLabel34");
		$RFCodes[33][1] = $this->ReadPropertyString("RFCode34");
		$RFCodes[34][0] = $this->ReadPropertyString("RFLabel35");
		$RFCodes[34][1] = $this->ReadPropertyString("RFCode35");
		$RFCodes[35][0] = $this->ReadPropertyString("RFLabel36");
		$RFCodes[35][1] = $this->ReadPropertyString("RFCode36");
		$RFCodes[36][0] = $this->ReadPropertyString("RFLabel37");
		$RFCodes[36][1] = $this->ReadPropertyString("RFCode37");
		$RFCodes[37][0] = $this->ReadPropertyString("RFLabel38");
		$RFCodes[37][1] = $this->ReadPropertyString("RFCode38");
		$RFCodes[38][0] = $this->ReadPropertyString("RFLabel39");
		$RFCodes[38][1] = $this->ReadPropertyString("RFCode39");
		$RFCodes[39][0] = $this->ReadPropertyString("RFLabel40");
		$RFCodes[39][1] = $this->ReadPropertyString("RFCode40");
		$RFCodes[40][0] = $this->ReadPropertyString("RFLabel41");
		$RFCodes[40][1] = $this->ReadPropertyString("RFCode41");
		$RFCodes[41][0] = $this->ReadPropertyString("RFLabel42");
		$RFCodes[41][1] = $this->ReadPropertyString("RFCode42");
		$RFCodes[42][0] = $this->ReadPropertyString("RFLabel43");
		$RFCodes[42][1] = $this->ReadPropertyString("RFCode43");
		$RFCodes[43][0] = $this->ReadPropertyString("RFLabel44");
		$RFCodes[43][1] = $this->ReadPropertyString("RFCode44");
		$RFCodes[44][0] = $this->ReadPropertyString("RFLabel45");
		$RFCodes[44][1] = $this->ReadPropertyString("RFCode45");
		$RFCodes[45][0] = $this->ReadPropertyString("RFLabel46");
		$RFCodes[45][1] = $this->ReadPropertyString("RFCode46");
		$RFCodes[46][0] = $this->ReadPropertyString("RFLabel47");
		$RFCodes[46][1] = $this->ReadPropertyString("RFCode47");
		$RFCodes[47][0] = $this->ReadPropertyString("RFLabel48");
		$RFCodes[47][1] = $this->ReadPropertyString("RFCode48");
		$RFCodes[48][0] = $this->ReadPropertyString("RFLabel49");
		$RFCodes[48][1] = $this->ReadPropertyString("RFCode49");
		$RFCodes[49][0] = $this->ReadPropertyString("RFLabel50");
		$RFCodes[49][1] = $this->ReadPropertyString("RFCode50");
		$RFCodes[50][0] = $this->ReadPropertyString("RFLabel51");
		$RFCodes[50][1] = $this->ReadPropertyString("RFCode51");
		$RFCodes[51][0] = $this->ReadPropertyString("RFLabel52");
		$RFCodes[51][1] = $this->ReadPropertyString("RFCode52");
		$RFCodes[52][0] = $this->ReadPropertyString("RFLabel53");
		$RFCodes[52][1] = $this->ReadPropertyString("RFCode53");
		$RFCodes[53][0] = $this->ReadPropertyString("RFLabel54");
		$RFCodes[53][1] = $this->ReadPropertyString("RFCode54");
		$RFCodes[54][0] = $this->ReadPropertyString("RFLabel55");
		$RFCodes[54][1] = $this->ReadPropertyString("RFCode55");
		$RFCodes[55][0] = $this->ReadPropertyString("RFLabel56");
		$RFCodes[55][1] = $this->ReadPropertyString("RFCode56");
		$RFCodes[56][0] = $this->ReadPropertyString("RFLabel57");
		$RFCodes[56][1] = $this->ReadPropertyString("RFCode57");
		$RFCodes[57][0] = $this->ReadPropertyString("RFLabel58");
		$RFCodes[57][1] = $this->ReadPropertyString("RFCode58");
		$RFCodes[58][0] = $this->ReadPropertyString("RFLabel59");
		$RFCodes[58][1] = $this->ReadPropertyString("RFCode59");
		$RFCodes[59][0] = $this->ReadPropertyString("RFLabel60");
		$RFCodes[59][1] = $this->ReadPropertyString("RFCode60");
		$RFCodes[60][0] = $this->ReadPropertyString("RFLabel61");
		$RFCodes[60][1] = $this->ReadPropertyString("RFCode61");
		$RFCodes[61][0] = $this->ReadPropertyString("RFLabel62");
		$RFCodes[61][1] = $this->ReadPropertyString("RFCode62");
		$RFCodes[62][0] = $this->ReadPropertyString("RFLabel63");
		$RFCodes[62][1] = $this->ReadPropertyString("RFCode63");
		$RFCodes[63][0] = $this->ReadPropertyString("RFLabel64");
		$RFCodes[63][1] = $this->ReadPropertyString("RFCode64");
		$RFCodes[64][0] = $this->ReadPropertyString("RFLabel65");
		$RFCodes[64][1] = $this->ReadPropertyString("RFCode65");
		$RFCodes[65][0] = $this->ReadPropertyString("RFLabel66");
		$RFCodes[65][1] = $this->ReadPropertyString("RFCode66");
		$RFCodes[66][0] = $this->ReadPropertyString("RFLabel67");
		$RFCodes[66][1] = $this->ReadPropertyString("RFCode67");
		$RFCodes[67][0] = $this->ReadPropertyString("RFLabel68");
		$RFCodes[67][1] = $this->ReadPropertyString("RFCode68");
		$RFCodes[68][0] = $this->ReadPropertyString("RFLabel69");
		$RFCodes[68][1] = $this->ReadPropertyString("RFCode69");
		$RFCodes[69][0] = $this->ReadPropertyString("RFLabel70");
		$RFCodes[69][1] = $this->ReadPropertyString("RFCode70");
		$RFCodes[70][0] = $this->ReadPropertyString("RFLabel71");
		$RFCodes[70][1] = $this->ReadPropertyString("RFCode71");
		$RFCodes[71][0] = $this->ReadPropertyString("RFLabel72");
		$RFCodes[71][1] = $this->ReadPropertyString("RFCode72");
		$RFCodes[72][0] = $this->ReadPropertyString("RFLabel73");
		$RFCodes[72][1] = $this->ReadPropertyString("RFCode73");
		$RFCodes[73][0] = $this->ReadPropertyString("RFLabel74");
		$RFCodes[73][1] = $this->ReadPropertyString("RFCode74");
		$RFCodes[74][0] = $this->ReadPropertyString("RFLabel75");
		$RFCodes[74][1] = $this->ReadPropertyString("RFCode75");
		$RFCodes[75][0] = $this->ReadPropertyString("RFLabel76");
		$RFCodes[75][1] = $this->ReadPropertyString("RFCode76");
		$RFCodes[76][0] = $this->ReadPropertyString("RFLabel77");
		$RFCodes[76][1] = $this->ReadPropertyString("RFCode77");
		$RFCodes[77][0] = $this->ReadPropertyString("RFLabel78");
		$RFCodes[77][1] = $this->ReadPropertyString("RFCode78");
		$RFCodes[78][0] = $this->ReadPropertyString("RFLabel79");
		$RFCodes[78][1] = $this->ReadPropertyString("RFCode79");
		$RFCodes[79][0] = $this->ReadPropertyString("RFLabel80");
		$RFCodes[79][1] = $this->ReadPropertyString("RFCode80");
		$RFCodes[80][0] = $this->ReadPropertyString("RFLabel81");
		$RFCodes[80][1] = $this->ReadPropertyString("RFCode81");
		$RFCodes[81][0] = $this->ReadPropertyString("RFLabel82");
		$RFCodes[81][1] = $this->ReadPropertyString("RFCode82");
		$RFCodes[82][0] = $this->ReadPropertyString("RFLabel83");
		$RFCodes[82][1] = $this->ReadPropertyString("RFCode83");
		$RFCodes[83][0] = $this->ReadPropertyString("RFLabel84");
		$RFCodes[83][1] = $this->ReadPropertyString("RFCode84");
		$RFCodes[84][0] = $this->ReadPropertyString("RFLabel85");
		$RFCodes[84][1] = $this->ReadPropertyString("RFCode85");
		$RFCodes[85][0] = $this->ReadPropertyString("RFLabel86");
		$RFCodes[85][1] = $this->ReadPropertyString("RFCode86");
		$RFCodes[86][0] = $this->ReadPropertyString("RFLabel87");
		$RFCodes[86][1] = $this->ReadPropertyString("RFCode87");
		$RFCodes[87][0] = $this->ReadPropertyString("RFLabel88");
		$RFCodes[87][1] = $this->ReadPropertyString("RFCode88");
		$RFCodes[88][0] = $this->ReadPropertyString("RFLabel89");
		$RFCodes[88][1] = $this->ReadPropertyString("RFCode89");
		$RFCodes[89][0] = $this->ReadPropertyString("RFLabel90");
		$RFCodes[89][1] = $this->ReadPropertyString("RFCode90");
		$RFCodes[90][0] = $this->ReadPropertyString("RFLabel91");
		$RFCodes[90][1] = $this->ReadPropertyString("RFCode91");
		$RFCodes[91][0] = $this->ReadPropertyString("RFLabel92");
		$RFCodes[91][1] = $this->ReadPropertyString("RFCode92");
		$RFCodes[92][0] = $this->ReadPropertyString("RFLabel93");
		$RFCodes[92][1] = $this->ReadPropertyString("RFCode93");
		$RFCodes[93][0] = $this->ReadPropertyString("RFLabel94");
		$RFCodes[93][1] = $this->ReadPropertyString("RFCode94");
		$RFCodes[94][0] = $this->ReadPropertyString("RFLabel95");
		$RFCodes[94][1] = $this->ReadPropertyString("RFCode95");
		$RFCodes[95][0] = $this->ReadPropertyString("RFLabel96");
		$RFCodes[95][1] = $this->ReadPropertyString("RFCode96");
		$RFCodes[96][0] = $this->ReadPropertyString("RFLabel97");
		$RFCodes[96][1] = $this->ReadPropertyString("RFCode97");
		$RFCodes[97][0] = $this->ReadPropertyString("RFLabel98");
		$RFCodes[97][1] = $this->ReadPropertyString("RFCode98");
		$RFCodes[98][0] = $this->ReadPropertyString("RFLabel99");
		$RFCodes[98][1] = $this->ReadPropertyString("RFCode99");
		$RFCodes[99][0] = $this->ReadPropertyString("RFLabel100");
		$RFCodes[99][1] = $this->ReadPropertyString("RFCode100");

		return $RFCodes;		
	}
	
	
	public function RequestAction($Ident, $Value)
    {
		if($Ident == "Status")
		{
			$this->SetPowerState($Value);
		}
		elseif(!null == ($this->GetIDForIdent('RFCODES1')) && $Ident == "RFCODES1" )
		{
			switch($Value)
				{
                    case 0: //IR 1
                        $this->SendRFCode(($Value+1));
						break;
                    case 1: //IR 2
                        $this->SendRFCode(($Value+1));
                        break;
					case 2: //IR 3
                        $this->SendRFCode(($Value+1));
                        break;
                    case 3: //IR 4
                        $this->SendRFCode(($Value+1));
                        break;
					case 4: //IR 5
                        $this->SendRFCode(($Value+1));
                        break;
                    case 5: //IR 6
                        $this->SendRFCode(($Value+1));
                        break;
					case 6: //IR 7
                        $this->SendRFCode(($Value+1));
                        break;
                    case 7: //IR 8
                        $this->SendRFCode(($Value+1));
                        break;
					case 8: //IR 9
                        $this->SendRFCode(($Value+1));
                        break;
					case 9: //IR 10
                        $this->SendRFCode(($Value+1));
                        break;
					case 10: //IR 11
                        $this->SendRFCode(($Value+1));
                        break;
					case 11: //IR 12
                        $this->SendRFCode(($Value+1));
                        break;
					case 12: //IR 13
                        $this->SendRFCode(($Value+1));
                        break;
					case 13: //IR 14
                        $this->SendRFCode(($Value+1));
                        break;
					case 14: //IR 15
                        $this->SendRFCode(($Value+1));
                        break;
					case 15: //IR 16
                        $this->SendRFCode(($Value+1));
                        break;
					case 16: //IR 17
                        $this->SendRFCode(($Value+1));
                        break;
					case 17: //IR 18
                        $this->SendRFCode(($Value+1));						
                        break;
					case 18: //IR 19
                        $this->SendRFCode(($Value+1));
                        break;
					case 19: //IR 20
                        $this->SendRFCode(($Value+1));
                        break;
					case 20: //IR 21
                        $this->SendRFCode(($Value+1));
                        break;
					case 21: //IR 22
                        $this->SendRFCode(($Value+1));
                        break;
					case 22: //IR 23
                        $this->SendRFCode(($Value+1));
                        break;
					case 23: //IR 24
                        $this->SendRFCode(($Value+1));
                        break;
					case 24: //IR 25
                        $this->SendRFCode(($Value+1));
                        break;
					case 25: //IR 26
                        $this->SendRFCode(($Value+1));
                        break;
					case 26: //IR 27
                        $this->SendRFCode(($Value+1));
                        break;
					case 27: //IR 28
                        $this->SendRFCode(($Value+1));
                        break;
					case 28: //IR 29
                        $this->SendRFCode(($Value+1));
                        break;
					case 29: //IR 30
                        $this->SendRFCode(($Value+1));
                        break;
					case 30: //IR 31
                        $this->SendRFCode(($Value+1));
                        break;
					case 31: //IR 32
                        $this->SendRFCode(($Value+1));
                        break;			
                }
		}
		elseif(!null == ($this->GetIDForIdent('RFCODES2')) && $Ident == "RFCODES2" )
		{
			switch($Value) {
						case 0: //IR 33
							$this->SendRFCode(($Value+33));
							break;
						case 1: //IR 34
							$this->SendRFCode(($Value+33));
							break;
						case 2: //IR 35
							$this->SendRFCode(($Value+33));
							break;
						case 3: //IR 36
							$this->SendRFCode(($Value+33));
							break;
						case 4: //IR 37
							$this->SendRFCode(($Value+33));
							break;
						case 5: //IR 38
							$this->SendRFCode(($Value+33));
							break;
						case 6: //IR 39
							$this->SendRFCode(($Value+33));
							break;
						case 7: //IR 40
							$this->SendRFCode(($Value+33));
							break;
						case 8: //IR 41
							$this->SendRFCode(($Value+33));
							break;
						case 9: //IR 42
							$this->SendRFCode(($Value+33));
							break;
						case 10: //IR 43
							$this->SendRFCode(($Value+33));
							break;
						case 11: //IR 44
							$this->SendRFCode(($Value+33));
							break;
						case 12: //IR 45
							$this->SendRFCode(($Value+33));
							break;
						case 13: //IR 46
							$this->SendRFCode(($Value+33));
							break;
						case 14: //IR 47
							$this->SendRFCode(($Value+33));
							break;
						case 15: //IR 48
							$this->SendRFCode(($Value+33));
							break;
						case 16: //IR 49
							$this->SendRFCode(($Value+33));
							break;
						case 17: //IR 50
							$this->SendRFCode(($Value+33));
							break;
						case 18: //IR 51
							$this->SendRFCode(($Value+33));
							break;
						case 19: //IR 52
							$this->SendRFCode(($Value+33));
							break;
						case 20: //IR 53
							$this->SendRFCode(($Value+33));
							break;
						case 21: //IR 54
							$this->SendRFCode(($Value+33));
							break;
						case 22: //IR 55
							$this->SendRFCode(($Value+33));
							break;
						case 23: //IR 56
							$this->SendRFCode(($Value+33));
							break;
						case 24: //IR 57
							$this->SendRFCode(($Value+33));
							break;
						case 25: //IR 58
							$this->SendRFCode(($Value+33));
							break;
						case 26: //IR 59
							$this->SendRFCode(($Value+33));
							break;
						case 27: //IR 60
							$this->SendRFCode(($Value+33));
							break;
						case 28: //IR 61
							$this->SendRFCode(($Value+33));
							break;
						case 29: //IR 62
							$this->SendRFCode(($Value+33));
							break;
						case 30: //IR 63
							$this->SendRFCode(($Value+33));
							break;
						case 31: //IR 64
							$this->SendRFCode(($Value+33));
							break;
				}
		}
		elseif(!null == ($this->GetIDForIdent('RFCODES3')) && $Ident == "RFCODES3" )
		{
			switch($Value) {
						case 0: //IR 65
							$this->SendRFCode(($Value+65));
							break;
						case 1: //IR 66
							$this->SendRFCode(($Value+65));
							break;
						case 2: //IR 67
							$this->SendRFCode(($Value+65));
							break;
						case 3: //IR 68
							$this->SendRFCode(($Value+65));
							break;
						case 4: //IR 69
							$this->SendRFCode(($Value+65));
							break;
						case 5: //IR 70
							$this->SendRFCode(($Value+65));
							break;
						case 6: //IR 71
							$this->SendRFCode(($Value+65));
							break;
						case 7: //IR 72
							$this->SendRFCode(($Value+65));
							break;
						case 8: //IR 73
							$this->SendRFCode(($Value+65));
							break;
						case 9: //IR 74
							$this->SendRFCode(($Value+65));
							break;
						case 10: //IR 75
							$this->SendRFCode(($Value+65));
							break;
						case 11: //IR 76
							$this->SendRFCode(($Value+65));
							break;
						case 12: //IR 77
							$this->SendRFCode(($Value+65));
							break;
						case 13: //IR 78
							$this->SendRFCode(($Value+65));
							break;
						case 14: //IR 79
							$this->SendRFCode(($Value+65));
							break;
						case 15: //IR 80
							$this->SendRFCode(($Value+65));
							break;
						case 16: //IR 81
							$this->SendRFCode(($Value+65));
							break;
						case 17: //IR 82
							$this->SendRFCode(($Value+65));
							break;
						case 18: //IR 83
							$this->SendRFCode(($Value+65));
							break;
						case 19: //IR 84
							$this->SendRFCode(($Value+65));
							break;
						case 20: //IR 85
							$this->SendRFCode(($Value+65));
							break;
						case 21: //IR 86
							$this->SendRFCode(($Value+65));
							break;
						case 22: //IR 87
							$this->SendRFCode(($Value+65));
							break;
						case 23: //IR 88
							$this->SendRFCode(($Value+65));
							break;
						case 24: //IR 89
							$this->SendRFCode(($Value+65));
							break;
						case 25: //IR 90
							$this->SendRFCode(($Value+65));
							break;
						case 26: //IR 91
							$this->SendRFCode(($Value+65));
							break;
						case 27: //IR 92
							$this->SendRFCode(($Value+65));
							break;
						case 28: //IR 93
							$this->SendRFCode(($Value+65));
							break;
						case 29: //IR 94
							$this->SendRFCode(($Value+65));
							break;
						case 30: //IR 95
							$this->SendRFCode(($Value+65));
							break;
						case 31: //IR 96
							$this->SendRFCode(($Value+65));
							break;
				}
		}
		elseif(!null == ($this->GetIDForIdent('RFCODES4')) && $Ident == "RFCODES4" )
		{
			switch($Value)
				{
						case 0: //IR 97
							$this->SendRFCode(($Value+97));
							break;
						case 1: //IR 98
							$this->SendRFCode(($Value+97));
							break;
						case 2: //IR 99
							$this->SendRFCode(($Value+97));
							break;
						case 3: //IR 100
							$this->SendRFCode(($Value+97));
							break;
				}
		}
		else
		{
			throw new Exception("Invalid ident");
		}
		
    }
	
	
	
	protected function GetParent()
    {
        $instance = IPS_GetInstance($this->InstanceID);//array
		return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
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
		
	
	public function SetPowerState(boolean $state) {
		if ($state === true)
		{
		SetValueBoolean($this->GetIDForIdent('Status'), $state);
		//PowerOn abfragen
		$PowerOnCode = $this->ReadPropertyInteger("PowerOnCode");
		return $this->SendRFCode($PowerOnCode);
		}
		else
		{
		SetValueBoolean($this->GetIDForIdent('Status'), $state);
		//PowerOff abfragen
		$PowerOffCode = $this->ReadPropertyInteger("PowerOffCode");
		return $this->SendRFCode($PowerOffCode);
		}
	}
	
	
	//Senden eines IR Befehls über das a.i.o. Gateway
	public function SendRF1() {
            $RF_send = $this->ReadPropertyString("RFCode1");
			return $this->Send_RF($RF_send);
        }
		
	public function SendIR2() {
            $RF_send = $this->ReadPropertyString("RFCode2");
			return $this->Send_RF($RF_send);
        }
		
	public function SendRFCode(integer $Value) {
			//RF Code auslesen Value 0 entspricht RFCode 1
			$RFCode = "RFCode".$Value;
			if($Value <= 32 && !null == ($this->GetIDForIdent('RFCODES1')))
			{
			$setvalue = $Value-1;	
			SetValueInteger($this->GetIDForIdent('RFCODES1'), $setvalue);
			}
			elseif($Value <=64 && $Value >32 && !null == ($this->GetIDForIdent('RFCODES2')))
			{
			$setvalue = $Value-33;	
			SetValueInteger($this->GetIDForIdent('RFCODES2'), $setvalue);	
			}
			elseif($Value <=96 && $Value >64 && !null == ($this->GetIDForIdent('RFCODES3')))
			{
			$setvalue = $Value-65;
			SetValueInteger($this->GetIDForIdent('RFCODES3'), $setvalue);	
			}
			elseif($Value <=100 && $Value >96 && !null == ($this->GetIDForIdent('RFCODES4')))
			{
			$setvalue = $Value-97;	
			SetValueInteger($this->GetIDForIdent('RFCODES4'), $setvalue);	
			}
			$RF_send = $this->ReadPropertyString($RFCode);
			return $this->Send_RF($RF_send);
        }	
	
	//RF Code senden
	private	$response = false;
	protected function Send_RF($rf_code)
		{
		//Sendestring zum Senden eines RF Befehls {IP Gateway}/command?code={RF Code}&XC_FNC=Send2&ir=00&rf=01			
		$GatewayPassword = $this->GetPassword();	
		if ($GatewayPassword !== "")
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&code=".$rf_code."&XC_FNC=Send2&ir=00&rf=01");
		}
		else
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?code=".$rf_code."&XC_FNC=Send2&ir=00&rf=01");
		}
		if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		elseif ($gwcheck == "{XC_AUTH}")
			{
			$this->response = false;
			echo "Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch."
			}
		return $this->response;

		}
		
	protected function removeVariable($name, $links){
        $vid = @$this->GetIDForIdent($name);
        if ($vid){
            // delete links to Variable
            foreach( $links as $key=>$value ){
                if ( $value['TargetID'] === $vid )
                     IPS_DeleteLink($value['LinkID']);
            }
            $this->UnregisterVariable($name);
        }
    }

    protected function removeVariableAction($name, $links){
        $vid = @$this->GetIDForIdent($name);
        if ($vid){
            // delete links to Variable
            foreach( $links as $key=>$value ){
                if ( $value['TargetID'] === $vid )
                     IPS_DeleteLink($value['LinkID']);
            }
            $this->DisableAction($name);
            $this->UnregisterVariable($name);
        }
    }	


	
    
	protected function RegisterProfileIntegerIR($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize)
	{
        
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
   
		
	protected function IRProfileAssociation($Name, $MinValue, $MaxValue, $start)
	{
			//echo "Start: ".$start." MinVal: ".$MinValue." MaxVal: ".$MaxValue."<br>";
			$RFCodes = $this->ArrRFCodes();
			for ($i = $MinValue; $i <= $MaxValue; $i++)
			{
				if (!empty($RFCodes[($start+$i)][1]))
				{	
					//boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe ) //Float Wert stimmt nicht
					// IR Codes nicht im Profil hinterlegt statt dessen die ID der RFCodes der Wert muss beim Senden abgefragt werden.
					IPS_SetVariableProfileAssociation( (string)$Name, (float)$i, (string)$RFCodes[($start+$i)][0], "", -1 );//max 32 möglich
				}
				
			}
	}
	
	protected function RegisterProfileRFCodes($Name, $Icon, $start, $end, $NumberRFCodes)
	{
       	(integer)$nameid = substr($Name, -7, 1); // Nummer des Vergebnen Profilnamens
		if ($NumberRFCodes == 0 )
				{
				$MinValue = 0;
				$MaxValue = 0;
				}
		elseif($end == 31 || $end == 63 || $end == 95)
			{
					$MinValue = 0;
					$MaxValue = 31; //max 32 Werte pro Profil
			}
		else
				{
				$MinValue = 0;
				$MaxValue = $end; 
				}
			$Prefix = "";
			$Suffix = "";
			
			$this->RegisterProfileIntegerIR($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, 0);
			$this->IRProfileAssociation($Name, $MinValue, $MaxValue, $start);
    }
	
	
	//Anlernen eines IR Codes über das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=Learn
	public function Learn(integer $irid)
		{
		$ip_aiogateway = $this->GetIPGateway();
		$GatewayPassword = $this->GetPassword();	
		if ($GatewayPassword !== "")
		{
			$RFCode = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=Learn");
		}
		else
		{
			$RFCode = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=Learn");
		}
		
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($RFCode == "{XC_ERR}Failed to learn code")//Bei Fehler
			{
			$this->response = false;
			//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$RFCode = "Das Gateway konnte keinen RFCode empfangen.";
			IPS_LogMessage( "RFCode:" , $RFCode );
			echo "Der RFCode konnte nicht angelernt werden.";
			//IPS_SetProperty($instance, "LearnRFCode", false); //Haken entfernen.
			IPS_SetProperty($this->InstanceID, "LearnRFCode", false); //Haken entfernen.
			}
		else
			{
				//Adresse auswerten bei Erfolg {XC_SUC}{"CODE":"1234455667789123456789123456789"}
				(string)$RFCode = substr($RFCode, 17);
				$length = strlen($RFCode);
				$RFCode = substr($RFCode, 0, ($length-2));
				IPS_LogMessage( "RF Code:" , $RFCode );
				$this->AddRFCode($RFCode, $irid);
				echo "RF Code: ".$RFCode;
				$this->response = true;	
			}
		
		return $this->response;
		}
	
	//IR Code und Label hinzufügen
	protected function AddRFCode($RFCode, $rfid)
	{
		$code = "RFCode".$rfid;
		$label = "RFLabel".$rfid;
		//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($this->InstanceID, $code, $RFCode); //RFCode setzten.
		$RFLabel = $this->ReadPropertyString($label);
		if (empty($RFLabel))
			{
				IPS_SetProperty($this->InstanceID, $label, "Neuer Code"); //RFLabel provisorisch setzten.
			}
		$NumberRFCodes = $this->ReadPropertyString("NumberRFCodes");
		$NumberRFCodes = $NumberRFCodes + 1;
		$this->CreateProfileIR($NumberRFCodes);
		IPS_SetProperty($this->InstanceID, "NumberRFCodes", $NumberRFCodes); //RFCode setzten.	
		IPS_SetProperty($this->InstanceID, "LearnRFCode", false); //Haken entfernen.
		IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
		IPS_LogMessage( "RFCode".$rfid." hinzugefügt:" , $RFCode );
		// Status aktiv
        $this->SetStatus(102);	
	}
	
	
   
	
	
}

?>