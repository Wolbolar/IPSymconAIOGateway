<?php
declare(strict_types=1);

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ProfileHelper.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "ConstHelper.php");

use Fonzo\Mediola\AIOGateway;

class AIOIRDevice extends IPSModule
{
	use ProfileHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();

		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        // 1. Verfügbarer AIO-Splitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		$this->RegisterPropertyString("name", "");
		$this->RegisterPropertyString("room_name", "");
		$this->RegisterPropertyString("type", "");
		$this->RegisterPropertyInteger("room_id", 0);
		$this->RegisterPropertyString("device_id", "");
		$this->RegisterPropertyString("address", "");
		$this->RegisterPropertyString("ircodes", "[]");
		$this->RegisterPropertyString("AIOIRCommands", "[]");
		$this->RegisterPropertyString("IRLabel1", "");
		$this->RegisterPropertyString("IRCode1", "");
		$this->RegisterPropertyString("IRLabel2", "");
		$this->RegisterPropertyString("IRCode2", "");
		$this->RegisterPropertyString("IRLabel3", "");
		$this->RegisterPropertyString("IRCode3", "");
		$this->RegisterPropertyString("IRLabel4", "");
		$this->RegisterPropertyString("IRCode4", "");
		$this->RegisterPropertyString("IRLabel5", "");
		$this->RegisterPropertyString("IRCode5", "");
		$this->RegisterPropertyString("IRLabel6", "");
		$this->RegisterPropertyString("IRCode6", "");
		$this->RegisterPropertyString("IRLabel7", "");
		$this->RegisterPropertyString("IRCode7", "");
		$this->RegisterPropertyString("IRLabel8", "");
		$this->RegisterPropertyString("IRCode8", "");
		$this->RegisterPropertyString("IRLabel9", "");
		$this->RegisterPropertyString("IRCode9", "");
		$this->RegisterPropertyString("IRLabel10", "");
		$this->RegisterPropertyString("IRCode10", "");
		$this->RegisterPropertyString("IRLabel11", "");
		$this->RegisterPropertyString("IRCode11", "");
		$this->RegisterPropertyString("IRLabel12", "");
		$this->RegisterPropertyString("IRCode12", "");
		$this->RegisterPropertyString("IRLabel13", "");
		$this->RegisterPropertyString("IRCode13", "");
		$this->RegisterPropertyString("IRLabel14", "");
		$this->RegisterPropertyString("IRCode14", "");
		$this->RegisterPropertyString("IRLabel15", "");
		$this->RegisterPropertyString("IRCode15", "");
		$this->RegisterPropertyString("IRLabel16", "");
		$this->RegisterPropertyString("IRCode16", "");
		$this->RegisterPropertyString("IRLabel17", "");
		$this->RegisterPropertyString("IRCode17", "");
		$this->RegisterPropertyString("IRLabel18", "");
		$this->RegisterPropertyString("IRCode18", "");
		$this->RegisterPropertyString("IRLabel19", "");
		$this->RegisterPropertyString("IRCode19", "");
		$this->RegisterPropertyString("IRLabel20", "");
		$this->RegisterPropertyString("IRCode20", "");
		$this->RegisterPropertyString("IRLabel21", "");
		$this->RegisterPropertyString("IRCode21", "");
		$this->RegisterPropertyString("IRLabel22", "");
		$this->RegisterPropertyString("IRCode22", "");
		$this->RegisterPropertyString("IRLabel23", "");
		$this->RegisterPropertyString("IRCode23", "");
		$this->RegisterPropertyString("IRLabel24", "");
		$this->RegisterPropertyString("IRCode24", "");
		$this->RegisterPropertyString("IRLabel25", "");
		$this->RegisterPropertyString("IRCode25", "");
		$this->RegisterPropertyString("IRLabel26", "");
		$this->RegisterPropertyString("IRCode26", "");
		$this->RegisterPropertyString("IRLabel27", "");
		$this->RegisterPropertyString("IRCode27", "");
		$this->RegisterPropertyString("IRLabel28", "");
		$this->RegisterPropertyString("IRCode28", "");
		$this->RegisterPropertyString("IRLabel29", "");
		$this->RegisterPropertyString("IRCode29", "");
		$this->RegisterPropertyString("IRLabel30", "");
		$this->RegisterPropertyString("IRCode30", "");
		$this->RegisterPropertyString("IRLabel31", "");
		$this->RegisterPropertyString("IRCode31", "");
		$this->RegisterPropertyString("IRLabel32", "");
		$this->RegisterPropertyString("IRCode32", "");
		$this->RegisterPropertyString("IRLabel33", "");
		$this->RegisterPropertyString("IRCode33", "");
		$this->RegisterPropertyString("IRLabel34", "");
		$this->RegisterPropertyString("IRCode34", "");
		$this->RegisterPropertyString("IRLabel35", "");
		$this->RegisterPropertyString("IRCode35", "");
		$this->RegisterPropertyString("IRLabel36", "");
		$this->RegisterPropertyString("IRCode36", "");
		$this->RegisterPropertyString("IRLabel37", "");
		$this->RegisterPropertyString("IRCode37", "");
		$this->RegisterPropertyString("IRLabel38", "");
		$this->RegisterPropertyString("IRCode38", "");
		$this->RegisterPropertyString("IRLabel39", "");
		$this->RegisterPropertyString("IRCode39", "");
		$this->RegisterPropertyString("IRLabel40", "");
		$this->RegisterPropertyString("IRCode40", "");
		$this->RegisterPropertyString("IRLabel41", "");
		$this->RegisterPropertyString("IRCode41", "");
		$this->RegisterPropertyString("IRLabel42", "");
		$this->RegisterPropertyString("IRCode42", "");
		$this->RegisterPropertyString("IRLabel43", "");
		$this->RegisterPropertyString("IRCode43", "");
		$this->RegisterPropertyString("IRLabel44", "");
		$this->RegisterPropertyString("IRCode44", "");
		$this->RegisterPropertyString("IRLabel45", "");
		$this->RegisterPropertyString("IRCode45", "");
		$this->RegisterPropertyString("IRLabel46", "");
		$this->RegisterPropertyString("IRCode46", "");
		$this->RegisterPropertyString("IRLabel47", "");
		$this->RegisterPropertyString("IRCode47", "");
		$this->RegisterPropertyString("IRLabel48", "");
		$this->RegisterPropertyString("IRCode48", "");
		$this->RegisterPropertyString("IRLabel49", "");
		$this->RegisterPropertyString("IRCode49", "");
		$this->RegisterPropertyString("IRLabel50", "");
		$this->RegisterPropertyString("IRCode50", "");
		$this->RegisterPropertyString("IRLabel51", "");
		$this->RegisterPropertyString("IRCode51", "");
		$this->RegisterPropertyString("IRLabel52", "");
		$this->RegisterPropertyString("IRCode52", "");
		$this->RegisterPropertyString("IRLabel53", "");
		$this->RegisterPropertyString("IRCode53", "");
		$this->RegisterPropertyString("IRLabel54", "");
		$this->RegisterPropertyString("IRCode54", "");
		$this->RegisterPropertyString("IRLabel55", "");
		$this->RegisterPropertyString("IRCode55", "");
		$this->RegisterPropertyString("IRLabel56", "");
		$this->RegisterPropertyString("IRCode56", "");
		$this->RegisterPropertyString("IRLabel57", "");
		$this->RegisterPropertyString("IRCode57", "");
		$this->RegisterPropertyString("IRLabel58", "");
		$this->RegisterPropertyString("IRCode58", "");
		$this->RegisterPropertyString("IRLabel59", "");
		$this->RegisterPropertyString("IRCode59", "");
		$this->RegisterPropertyString("IRLabel60", "");
		$this->RegisterPropertyString("IRCode60", "");
		$this->RegisterPropertyString("IRLabel61", "");
		$this->RegisterPropertyString("IRCode61", "");
		$this->RegisterPropertyString("IRLabel62", "");
		$this->RegisterPropertyString("IRCode62", "");
		$this->RegisterPropertyString("IRLabel63", "");
		$this->RegisterPropertyString("IRCode63", "");
		$this->RegisterPropertyString("IRLabel64", "");
		$this->RegisterPropertyString("IRCode64", "");
		$this->RegisterPropertyString("IRLabel65", "");
		$this->RegisterPropertyString("IRCode65", "");
		$this->RegisterPropertyString("IRLabel66", "");
		$this->RegisterPropertyString("IRCode66", "");
		$this->RegisterPropertyString("IRLabel67", "");
		$this->RegisterPropertyString("IRCode67", "");
		$this->RegisterPropertyString("IRLabel68", "");
		$this->RegisterPropertyString("IRCode68", "");
		$this->RegisterPropertyString("IRLabel69", "");
		$this->RegisterPropertyString("IRCode69", "");
		$this->RegisterPropertyString("IRLabel70", "");
		$this->RegisterPropertyString("IRCode70", "");
		$this->RegisterPropertyString("IRLabel71", "");
		$this->RegisterPropertyString("IRCode71", "");
		$this->RegisterPropertyString("IRLabel72", "");
		$this->RegisterPropertyString("IRCode72", "");
		$this->RegisterPropertyString("IRLabel73", "");
		$this->RegisterPropertyString("IRCode73", "");
		$this->RegisterPropertyString("IRLabel74", "");
		$this->RegisterPropertyString("IRCode74", "");
		$this->RegisterPropertyString("IRLabel75", "");
		$this->RegisterPropertyString("IRCode75", "");
		$this->RegisterPropertyString("IRLabel76", "");
		$this->RegisterPropertyString("IRCode76", "");
		$this->RegisterPropertyString("IRLabel77", "");
		$this->RegisterPropertyString("IRCode77", "");
		$this->RegisterPropertyString("IRLabel78", "");
		$this->RegisterPropertyString("IRCode78", "");
		$this->RegisterPropertyString("IRLabel79", "");
		$this->RegisterPropertyString("IRCode79", "");
		$this->RegisterPropertyString("IRLabel80", "");
		$this->RegisterPropertyString("IRCode80", "");
		$this->RegisterPropertyString("IRLabel81", "");
		$this->RegisterPropertyString("IRCode81", "");
		$this->RegisterPropertyString("IRLabel82", "");
		$this->RegisterPropertyString("IRCode82", "");
		$this->RegisterPropertyString("IRLabel83", "");
		$this->RegisterPropertyString("IRCode83", "");
		$this->RegisterPropertyString("IRLabel84", "");
		$this->RegisterPropertyString("IRCode84", "");
		$this->RegisterPropertyString("IRLabel85", "");
		$this->RegisterPropertyString("IRCode85", "");
		$this->RegisterPropertyString("IRLabel86", "");
		$this->RegisterPropertyString("IRCode86", "");
		$this->RegisterPropertyString("IRLabel87", "");
		$this->RegisterPropertyString("IRCode87", "");
		$this->RegisterPropertyString("IRLabel88", "");
		$this->RegisterPropertyString("IRCode88", "");
		$this->RegisterPropertyString("IRLabel89", "");
		$this->RegisterPropertyString("IRCode89", "");
		$this->RegisterPropertyString("IRLabel90", "");
		$this->RegisterPropertyString("IRCode90", "");
		$this->RegisterPropertyString("IRLabel91", "");
		$this->RegisterPropertyString("IRCode91", "");
		$this->RegisterPropertyString("IRLabel92", "");
		$this->RegisterPropertyString("IRCode92", "");
		$this->RegisterPropertyString("IRLabel93", "");
		$this->RegisterPropertyString("IRCode93", "");
		$this->RegisterPropertyString("IRLabel94", "");
		$this->RegisterPropertyString("IRCode94", "");
		$this->RegisterPropertyString("IRLabel95", "");
		$this->RegisterPropertyString("IRCode95", "");
		$this->RegisterPropertyString("IRLabel96", "");
		$this->RegisterPropertyString("IRCode96", "");
		$this->RegisterPropertyString("IRLabel97", "");
		$this->RegisterPropertyString("IRCode97", "");
		$this->RegisterPropertyString("IRLabel98", "");
		$this->RegisterPropertyString("IRCode98", "");
		$this->RegisterPropertyString("IRLabel99", "");
		$this->RegisterPropertyString("IRCode99", "");
		$this->RegisterPropertyString("IRLabel100", "");
		$this->RegisterPropertyString("IRCode100", "");


		$this->RegisterPropertyBoolean("IRStatus", false);
		$this->RegisterPropertyString("IRDiode", "01");
		$this->RegisterPropertyString("EXTIRDiode", "00");
		$this->RegisterPropertyInteger("PowerOnCode", 1);
		$this->RegisterPropertyInteger("PowerOffCode", 2);
		$this->RegisterPropertyInteger("NumberIRCodes", 0);
		$this->RegisterPropertyBoolean("LearnIRCode", false);
		$this->RegisterPropertyInteger("LearnIRCodeID", 1);

		//we will wait until the kernel is ready
		$this->RegisterMessage(0, IPS_KERNELMESSAGE);

    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();

		if (IPS_GetKernelRunlevel() !== KR_READY) {
			return;
		}


		$IRCode1 = $this->ReadPropertyString("IRCode1");
		$IRCode2 = $this->ReadPropertyString("IRCode2");
		$IRLabel1 = $this->ReadPropertyString("IRLabel1");
		$IRLabel2 = $this->ReadPropertyString("IRLabel2");
		$ircodes = $this->ReadPropertyString("ircodes");
		$NumberIRCodes = $this->ReadPropertyInteger("NumberIRCodes");


		if ( ($IRCode1 == '' or $IRCode2 == '' or $IRLabel1 == '' or $IRLabel2 == '') && ($ircodes == "[]" || $ircodes == ""))
        {
            // Status Error Felder dürfen nicht leer sein
            $this->SetStatus(202);
        }
		else
		{
			if ($NumberIRCodes == 0) //bei Manueller Eingabe von IR Codes wenn die Anzahl der Codes nicht gesetzt wurde Anzahl berechnen
			{
				$ircodes = $this->ArrIRCodes();
				//Anzahl an IR Codes
				for ($i = 0; $i <= 99; $i++)
				{
					if (empty($ircodes[$i][1]))
					{
						$NumberIRCodes = $i; //Anzahl der IRCodes mit Inhalt beim ersten leeren Feld wird abgebrochen
						break;
					}

				}
				$this->CreateProfileIR($NumberIRCodes);

			}
			else
			{
					$this->CreateProfileIR($NumberIRCodes);
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
        if ($this->ReadPropertyBoolean("IRStatus")){
            $this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
			$this->EnableAction("Status");
        }else{
            $this->removeVariableAction("Status", $links);
        }
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

			default:
				break;
		}
	}

	//IR Code zufügen
	protected function IRAddCode($InsID, $ircodes, $count)
	{
		for ($i = 0; $i <= $count - 1; $i++) {
			$IRLabel = (string)"IRLabel" . ($i + 1);
			$IRCode = (string)"IRCode" . ($i + 1);
			$InsID = (int)$InsID;
			$label = $ircodes[$i][0];
			$code = $ircodes[$i][1];
			IPS_SetProperty($InsID, $IRLabel, $label); //IR Label setzten.
			IPS_SetProperty($InsID, $IRCode, $code); //IR Code setzten.
			$this->SendDebug("AIO IR:", "IR Code hinzugefügt Name: " . $label, 0);
		}
		IPS_SetProperty($InsID, "NumberIRCodes", $count); //Anzahl IR Codes setzten.
		IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
	}

	public function ConvertIRCodesList()
	{
		$this->SendDebug("IR Convert", "Start Conversion", 0);
		$current_ircodes = $this->ArrIRCodes();
		$ircodes = [];
		foreach($current_ircodes as $key => $ircode)
		{
			if($ircode[1] != "")
			{
				$ircodes[] = ["key" => $ircode[0], "code" => $ircode[1]];
				$this->SendDebug("IR Convert", "convert key ".$ircode[0]." with code ".$ircode[1], 0);
			}
		}
		IPS_SetProperty($this->InstanceID, "AIOIRCommands", json_encode($ircodes));
		IPS_ApplyChanges($this->InstanceID);
	}


	/**
	 * @param $NumberIRCodes
	 */
	protected function CreateProfileIR($NumberIRCodes)
	{
		//$irprofilname = str_replace(' ','',(trim(IPS_GetName(IPS_GetInstance($this->InstanceID)["InstanceID"])))); //Profilname darf keine Leerzeichen enthalten !!!!
		$irprofilname = str_replace(' ','',(trim(IPS_GetName($this->InstanceID)))); //Profilname darf keine Leerzeichen enthalten !!!!
		// Sonderzeichen entfernen
		$irprofilname = $this->clear_string($irprofilname);
		$profilname1 = $irprofilname."1.AIOIR";
		$profilname2 = $irprofilname."2.AIOIR";
		$profilname3 = $irprofilname."3.AIOIR";
		$profilname4 = $irprofilname."4.AIOIR";

		// Start create profiles
		if ($NumberIRCodes <=32)
			{
			$end = ($NumberIRCodes-1);

			$this->RegisterProfileIRCodes($profilname1, "Keyboard", 0, $end, $NumberIRCodes);


			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("IRCODES1", "IR Codes", $profilname1, 29);
			$this->EnableAction("IRCODES1");
			}
		elseif	($NumberIRCodes <=64 && $NumberIRCodes >32 )
			{
			$end = ($NumberIRCodes-33);
			$this->RegisterProfileIRCodes($profilname1, "Keyboard", 0, 31, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname2, "Keyboard", 32, $end, $NumberIRCodes);

			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("IRCODES1", "IR Codes", $profilname1, 29);
			$this->EnableAction("IRCODES1");
			$this->RegisterVariableInteger("IRCODES2", "IR Codes", $profilname2, 30);
			$this->EnableAction("IRCODES2");
			}
		elseif	($NumberIRCodes <=96 && $NumberIRCodes >64)
			{
			$end = ($NumberIRCodes-65);
			$this->RegisterProfileIRCodes($profilname1, "Keyboard", 0, 31, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname2, "Keyboard", 32, 63, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname3, "Keyboard", 64, $end, $NumberIRCodes);

			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("IRCODES1", "IR Codes", $profilname1, 29);
			$this->EnableAction("IRCODES1");
			$this->RegisterVariableInteger("IRCODES2", "IR Codes", $profilname2, 30);
			$this->EnableAction("IRCODES2");
			$this->RegisterVariableInteger("IRCODES3", "IR Codes", $profilname3, 31);
			$this->EnableAction("IRCODES3");
			}
		elseif	($NumberIRCodes <=100 && $NumberIRCodes >96)
			{
			$end = ($NumberIRCodes-97);
			$this->RegisterProfileIRCodes($profilname1, "Keyboard", 0, 31, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname2, "Keyboard", 32, 63, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname3, "Keyboard", 64, 95, $NumberIRCodes);
			$this->RegisterProfileIRCodes($profilname4, "Keyboard", 96, $end, $NumberIRCodes);


			//Variablen anlegen
			//Generelle Variablen
			$this->RegisterVariableInteger("IRCODES1", "IR Codes", $profilname1, 29);
			$this->EnableAction("IRCODES1");
			$this->RegisterVariableInteger("IRCODES2", "IR Codes", $profilname2, 30);
			$this->EnableAction("IRCODES2");
			$this->RegisterVariableInteger("IRCODES3", "IR Codes", $profilname3, 31);
			$this->EnableAction("IRCODES3");
			$this->RegisterVariableInteger("IRCODES4", "IR Codes", $profilname4, 32);
			$this->EnableAction("IRCODES4");
			}
	}

	protected function clear_string($str, $how = '_')
	{
	$search = array("ä", "ö", "ü", "ß", "Ä", "Ö", 
					"Ü", "&", "é", "á", "ó", 
					" :)", " :D", " :-)", " :P", 
					" :O", " ;D", " ;)", " ^^", 
					" :|", " :-/", ":)", ":D", 
					":-)", ":P", ":O", ";D", ";)", 
					"^^", ":|", ":-/", "(", ")", "[", "]", 
					"<", ">", "!", "\"", "§", "$", "%", "&", 
					"/", "(", ")", "=", "?", "`", "´", "*", "'", 
					"_", ":", ";", "²", "³", "{", "}", 
					"\\", "~", "#", "+", ".", ",", 
					"=", ":", "=)");
	$replace = array("ae", "oe", "ue", "ss", "Ae", "Oe", 
					 "Ue", "und", "e", "a", "o", "", "", 
					 "", "", "", "", "", "", "", "", "", 
					 "", "", "", "", "", "", "", "", "", 
					 "", "", "", "", "", "", "", "", "", 
					 "", "", "", "", "", "", "", "", "", 
					 "", "", "", "", "", "", "", "", "", 
					 "", "", "", "", "", "", "", "", "", "");
	$str = str_replace($search, $replace, $str);
	//$str = strtolower(preg_replace("/[^a-zA-Z0-9]+/", trim($how), $str));
	$str = preg_replace("/[^a-zA-Z0-9]+/", trim($how), $str);
	return $str;
	}


	protected function ArrIRCodes()
	{
		$ircodes = array();
		$ircodes[0][0] = $this->ReadPropertyString("IRLabel1");
		$ircodes[0][1] = $this->ReadPropertyString("IRCode1");
		$ircodes[1][0] = $this->ReadPropertyString("IRLabel2");
		$ircodes[1][1] = $this->ReadPropertyString("IRCode2");
		$ircodes[2][0] = $this->ReadPropertyString("IRLabel3");
		$ircodes[2][1] = $this->ReadPropertyString("IRCode3");
		$ircodes[3][0] = $this->ReadPropertyString("IRLabel4");
		$ircodes[3][1] = $this->ReadPropertyString("IRCode4");
		$ircodes[4][0] = $this->ReadPropertyString("IRLabel5");
		$ircodes[4][1] = $this->ReadPropertyString("IRCode5");
		$ircodes[5][0] = $this->ReadPropertyString("IRLabel6");
		$ircodes[5][1] = $this->ReadPropertyString("IRCode6");
		$ircodes[6][0] = $this->ReadPropertyString("IRLabel7");
		$ircodes[6][1] = $this->ReadPropertyString("IRCode7");
		$ircodes[7][0] = $this->ReadPropertyString("IRLabel8");
		$ircodes[7][1] = $this->ReadPropertyString("IRCode8");
		$ircodes[8][0] = $this->ReadPropertyString("IRLabel9");
		$ircodes[8][1] = $this->ReadPropertyString("IRCode9");
		$ircodes[9][0] = $this->ReadPropertyString("IRLabel10");
		$ircodes[9][1] = $this->ReadPropertyString("IRCode10");
		$ircodes[10][0] = $this->ReadPropertyString("IRLabel11");
		$ircodes[10][1] = $this->ReadPropertyString("IRCode11");
		$ircodes[11][0] = $this->ReadPropertyString("IRLabel12");
		$ircodes[11][1] = $this->ReadPropertyString("IRCode12");
		$ircodes[12][0] = $this->ReadPropertyString("IRLabel13");
		$ircodes[12][1] = $this->ReadPropertyString("IRCode13");
		$ircodes[13][0] = $this->ReadPropertyString("IRLabel14");
		$ircodes[13][1] = $this->ReadPropertyString("IRCode14");
		$ircodes[14][0] = $this->ReadPropertyString("IRLabel15");
		$ircodes[14][1] = $this->ReadPropertyString("IRCode15");
		$ircodes[15][0] = $this->ReadPropertyString("IRLabel16");
		$ircodes[15][1] = $this->ReadPropertyString("IRCode16");
		$ircodes[16][0] = $this->ReadPropertyString("IRLabel17");
		$ircodes[16][1] = $this->ReadPropertyString("IRCode17");
		$ircodes[17][0] = $this->ReadPropertyString("IRLabel18");
		$ircodes[17][1] = $this->ReadPropertyString("IRCode18");
		$ircodes[18][0] = $this->ReadPropertyString("IRLabel19");
		$ircodes[18][1] = $this->ReadPropertyString("IRCode19");
		$ircodes[19][0] = $this->ReadPropertyString("IRLabel20");
		$ircodes[19][1] = $this->ReadPropertyString("IRCode20");
		$ircodes[20][0] = $this->ReadPropertyString("IRLabel21");
		$ircodes[20][1] = $this->ReadPropertyString("IRCode21");
		$ircodes[21][0] = $this->ReadPropertyString("IRLabel22");
		$ircodes[21][1] = $this->ReadPropertyString("IRCode22");
		$ircodes[22][0] = $this->ReadPropertyString("IRLabel23");
		$ircodes[22][1] = $this->ReadPropertyString("IRCode23");
		$ircodes[23][0] = $this->ReadPropertyString("IRLabel24");
		$ircodes[23][1] = $this->ReadPropertyString("IRCode24");
		$ircodes[24][0] = $this->ReadPropertyString("IRLabel25");
		$ircodes[24][1] = $this->ReadPropertyString("IRCode25");
		$ircodes[25][0] = $this->ReadPropertyString("IRLabel26");
		$ircodes[25][1] = $this->ReadPropertyString("IRCode26");
		$ircodes[26][0] = $this->ReadPropertyString("IRLabel27");
		$ircodes[26][1] = $this->ReadPropertyString("IRCode27");
		$ircodes[27][0] = $this->ReadPropertyString("IRLabel28");
		$ircodes[27][1] = $this->ReadPropertyString("IRCode28");
		$ircodes[28][0] = $this->ReadPropertyString("IRLabel29");
		$ircodes[28][1] = $this->ReadPropertyString("IRCode29");
		$ircodes[29][0] = $this->ReadPropertyString("IRLabel30");
		$ircodes[29][1] = $this->ReadPropertyString("IRCode30");
		$ircodes[30][0] = $this->ReadPropertyString("IRLabel31");
		$ircodes[30][1] = $this->ReadPropertyString("IRCode31");
		$ircodes[31][0] = $this->ReadPropertyString("IRLabel32");
		$ircodes[31][1] = $this->ReadPropertyString("IRCode32");
		$ircodes[32][0] = $this->ReadPropertyString("IRLabel33");
		$ircodes[32][1] = $this->ReadPropertyString("IRCode33");
		$ircodes[33][0] = $this->ReadPropertyString("IRLabel34");
		$ircodes[33][1] = $this->ReadPropertyString("IRCode34");
		$ircodes[34][0] = $this->ReadPropertyString("IRLabel35");
		$ircodes[34][1] = $this->ReadPropertyString("IRCode35");
		$ircodes[35][0] = $this->ReadPropertyString("IRLabel36");
		$ircodes[35][1] = $this->ReadPropertyString("IRCode36");
		$ircodes[36][0] = $this->ReadPropertyString("IRLabel37");
		$ircodes[36][1] = $this->ReadPropertyString("IRCode37");
		$ircodes[37][0] = $this->ReadPropertyString("IRLabel38");
		$ircodes[37][1] = $this->ReadPropertyString("IRCode38");
		$ircodes[38][0] = $this->ReadPropertyString("IRLabel39");
		$ircodes[38][1] = $this->ReadPropertyString("IRCode39");
		$ircodes[39][0] = $this->ReadPropertyString("IRLabel40");
		$ircodes[39][1] = $this->ReadPropertyString("IRCode40");
		$ircodes[40][0] = $this->ReadPropertyString("IRLabel41");
		$ircodes[40][1] = $this->ReadPropertyString("IRCode41");
		$ircodes[41][0] = $this->ReadPropertyString("IRLabel42");
		$ircodes[41][1] = $this->ReadPropertyString("IRCode42");
		$ircodes[42][0] = $this->ReadPropertyString("IRLabel43");
		$ircodes[42][1] = $this->ReadPropertyString("IRCode43");
		$ircodes[43][0] = $this->ReadPropertyString("IRLabel44");
		$ircodes[43][1] = $this->ReadPropertyString("IRCode44");
		$ircodes[44][0] = $this->ReadPropertyString("IRLabel45");
		$ircodes[44][1] = $this->ReadPropertyString("IRCode45");
		$ircodes[45][0] = $this->ReadPropertyString("IRLabel46");
		$ircodes[45][1] = $this->ReadPropertyString("IRCode46");
		$ircodes[46][0] = $this->ReadPropertyString("IRLabel47");
		$ircodes[46][1] = $this->ReadPropertyString("IRCode47");
		$ircodes[47][0] = $this->ReadPropertyString("IRLabel48");
		$ircodes[47][1] = $this->ReadPropertyString("IRCode48");
		$ircodes[48][0] = $this->ReadPropertyString("IRLabel49");
		$ircodes[48][1] = $this->ReadPropertyString("IRCode49");
		$ircodes[49][0] = $this->ReadPropertyString("IRLabel50");
		$ircodes[49][1] = $this->ReadPropertyString("IRCode50");
		$ircodes[50][0] = $this->ReadPropertyString("IRLabel51");
		$ircodes[50][1] = $this->ReadPropertyString("IRCode51");
		$ircodes[51][0] = $this->ReadPropertyString("IRLabel52");
		$ircodes[51][1] = $this->ReadPropertyString("IRCode52");
		$ircodes[52][0] = $this->ReadPropertyString("IRLabel53");
		$ircodes[52][1] = $this->ReadPropertyString("IRCode53");
		$ircodes[53][0] = $this->ReadPropertyString("IRLabel54");
		$ircodes[53][1] = $this->ReadPropertyString("IRCode54");
		$ircodes[54][0] = $this->ReadPropertyString("IRLabel55");
		$ircodes[54][1] = $this->ReadPropertyString("IRCode55");
		$ircodes[55][0] = $this->ReadPropertyString("IRLabel56");
		$ircodes[55][1] = $this->ReadPropertyString("IRCode56");
		$ircodes[56][0] = $this->ReadPropertyString("IRLabel57");
		$ircodes[56][1] = $this->ReadPropertyString("IRCode57");
		$ircodes[57][0] = $this->ReadPropertyString("IRLabel58");
		$ircodes[57][1] = $this->ReadPropertyString("IRCode58");
		$ircodes[58][0] = $this->ReadPropertyString("IRLabel59");
		$ircodes[58][1] = $this->ReadPropertyString("IRCode59");
		$ircodes[59][0] = $this->ReadPropertyString("IRLabel60");
		$ircodes[59][1] = $this->ReadPropertyString("IRCode60");
		$ircodes[60][0] = $this->ReadPropertyString("IRLabel61");
		$ircodes[60][1] = $this->ReadPropertyString("IRCode61");
		$ircodes[61][0] = $this->ReadPropertyString("IRLabel62");
		$ircodes[61][1] = $this->ReadPropertyString("IRCode62");
		$ircodes[62][0] = $this->ReadPropertyString("IRLabel63");
		$ircodes[62][1] = $this->ReadPropertyString("IRCode63");
		$ircodes[63][0] = $this->ReadPropertyString("IRLabel64");
		$ircodes[63][1] = $this->ReadPropertyString("IRCode64");
		$ircodes[64][0] = $this->ReadPropertyString("IRLabel65");
		$ircodes[64][1] = $this->ReadPropertyString("IRCode65");
		$ircodes[65][0] = $this->ReadPropertyString("IRLabel66");
		$ircodes[65][1] = $this->ReadPropertyString("IRCode66");
		$ircodes[66][0] = $this->ReadPropertyString("IRLabel67");
		$ircodes[66][1] = $this->ReadPropertyString("IRCode67");
		$ircodes[67][0] = $this->ReadPropertyString("IRLabel68");
		$ircodes[67][1] = $this->ReadPropertyString("IRCode68");
		$ircodes[68][0] = $this->ReadPropertyString("IRLabel69");
		$ircodes[68][1] = $this->ReadPropertyString("IRCode69");
		$ircodes[69][0] = $this->ReadPropertyString("IRLabel70");
		$ircodes[69][1] = $this->ReadPropertyString("IRCode70");
		$ircodes[70][0] = $this->ReadPropertyString("IRLabel71");
		$ircodes[70][1] = $this->ReadPropertyString("IRCode71");
		$ircodes[71][0] = $this->ReadPropertyString("IRLabel72");
		$ircodes[71][1] = $this->ReadPropertyString("IRCode72");
		$ircodes[72][0] = $this->ReadPropertyString("IRLabel73");
		$ircodes[72][1] = $this->ReadPropertyString("IRCode73");
		$ircodes[73][0] = $this->ReadPropertyString("IRLabel74");
		$ircodes[73][1] = $this->ReadPropertyString("IRCode74");
		$ircodes[74][0] = $this->ReadPropertyString("IRLabel75");
		$ircodes[74][1] = $this->ReadPropertyString("IRCode75");
		$ircodes[75][0] = $this->ReadPropertyString("IRLabel76");
		$ircodes[75][1] = $this->ReadPropertyString("IRCode76");
		$ircodes[76][0] = $this->ReadPropertyString("IRLabel77");
		$ircodes[76][1] = $this->ReadPropertyString("IRCode77");
		$ircodes[77][0] = $this->ReadPropertyString("IRLabel78");
		$ircodes[77][1] = $this->ReadPropertyString("IRCode78");
		$ircodes[78][0] = $this->ReadPropertyString("IRLabel79");
		$ircodes[78][1] = $this->ReadPropertyString("IRCode79");
		$ircodes[79][0] = $this->ReadPropertyString("IRLabel80");
		$ircodes[79][1] = $this->ReadPropertyString("IRCode80");
		$ircodes[80][0] = $this->ReadPropertyString("IRLabel81");
		$ircodes[80][1] = $this->ReadPropertyString("IRCode81");
		$ircodes[81][0] = $this->ReadPropertyString("IRLabel82");
		$ircodes[81][1] = $this->ReadPropertyString("IRCode82");
		$ircodes[82][0] = $this->ReadPropertyString("IRLabel83");
		$ircodes[82][1] = $this->ReadPropertyString("IRCode83");
		$ircodes[83][0] = $this->ReadPropertyString("IRLabel84");
		$ircodes[83][1] = $this->ReadPropertyString("IRCode84");
		$ircodes[84][0] = $this->ReadPropertyString("IRLabel85");
		$ircodes[84][1] = $this->ReadPropertyString("IRCode85");
		$ircodes[85][0] = $this->ReadPropertyString("IRLabel86");
		$ircodes[85][1] = $this->ReadPropertyString("IRCode86");
		$ircodes[86][0] = $this->ReadPropertyString("IRLabel87");
		$ircodes[86][1] = $this->ReadPropertyString("IRCode87");
		$ircodes[87][0] = $this->ReadPropertyString("IRLabel88");
		$ircodes[87][1] = $this->ReadPropertyString("IRCode88");
		$ircodes[88][0] = $this->ReadPropertyString("IRLabel89");
		$ircodes[88][1] = $this->ReadPropertyString("IRCode89");
		$ircodes[89][0] = $this->ReadPropertyString("IRLabel90");
		$ircodes[89][1] = $this->ReadPropertyString("IRCode90");
		$ircodes[90][0] = $this->ReadPropertyString("IRLabel91");
		$ircodes[90][1] = $this->ReadPropertyString("IRCode91");
		$ircodes[91][0] = $this->ReadPropertyString("IRLabel92");
		$ircodes[91][1] = $this->ReadPropertyString("IRCode92");
		$ircodes[92][0] = $this->ReadPropertyString("IRLabel93");
		$ircodes[92][1] = $this->ReadPropertyString("IRCode93");
		$ircodes[93][0] = $this->ReadPropertyString("IRLabel94");
		$ircodes[93][1] = $this->ReadPropertyString("IRCode94");
		$ircodes[94][0] = $this->ReadPropertyString("IRLabel95");
		$ircodes[94][1] = $this->ReadPropertyString("IRCode95");
		$ircodes[95][0] = $this->ReadPropertyString("IRLabel96");
		$ircodes[95][1] = $this->ReadPropertyString("IRCode96");
		$ircodes[96][0] = $this->ReadPropertyString("IRLabel97");
		$ircodes[96][1] = $this->ReadPropertyString("IRCode97");
		$ircodes[97][0] = $this->ReadPropertyString("IRLabel98");
		$ircodes[97][1] = $this->ReadPropertyString("IRCode98");
		$ircodes[98][0] = $this->ReadPropertyString("IRLabel99");
		$ircodes[98][1] = $this->ReadPropertyString("IRCode99");
		$ircodes[99][0] = $this->ReadPropertyString("IRLabel100");
		$ircodes[99][1] = $this->ReadPropertyString("IRCode100");

		return $ircodes;
	}


	public function RequestAction($Ident, $Value)
    {
		if($Ident == "Status")
		{
			$this->SetPowerState($Value);
		}
		elseif(!null == ($this->GetIDForIdent('IRCODES1')) && $Ident == "IRCODES1" )
		{
			switch($Value)
				{
                    case 0: //IR 1
                        $this->SendIRCode(($Value+1));
						break;
                    case 1: //IR 2
                        $this->SendIRCode(($Value+1));
                        break;
					case 2: //IR 3
                        $this->SendIRCode(($Value+1));
                        break;
                    case 3: //IR 4
                        $this->SendIRCode(($Value+1));
                        break;
					case 4: //IR 5
                        $this->SendIRCode(($Value+1));
                        break;
                    case 5: //IR 6
                        $this->SendIRCode(($Value+1));
                        break;
					case 6: //IR 7
                        $this->SendIRCode(($Value+1));
                        break;
                    case 7: //IR 8
                        $this->SendIRCode(($Value+1));
                        break;
					case 8: //IR 9
                        $this->SendIRCode(($Value+1));
                        break;
					case 9: //IR 10
                        $this->SendIRCode(($Value+1));
                        break;
					case 10: //IR 11
                        $this->SendIRCode(($Value+1));
                        break;
					case 11: //IR 12
                        $this->SendIRCode(($Value+1));
                        break;
					case 12: //IR 13
                        $this->SendIRCode(($Value+1));
                        break;
					case 13: //IR 14
                        $this->SendIRCode(($Value+1));
                        break;
					case 14: //IR 15
                        $this->SendIRCode(($Value+1));
                        break;
					case 15: //IR 16
                        $this->SendIRCode(($Value+1));
                        break;
					case 16: //IR 17
                        $this->SendIRCode(($Value+1));
                        break;
					case 17: //IR 18
                        $this->SendIRCode(($Value+1));
                        break;
					case 18: //IR 19
                        $this->SendIRCode(($Value+1));
                        break;
					case 19: //IR 20
                        $this->SendIRCode(($Value+1));
                        break;
					case 20: //IR 21
                        $this->SendIRCode(($Value+1));
                        break;
					case 21: //IR 22
                        $this->SendIRCode(($Value+1));
                        break;
					case 22: //IR 23
                        $this->SendIRCode(($Value+1));
                        break;
					case 23: //IR 24
                        $this->SendIRCode(($Value+1));
                        break;
					case 24: //IR 25
                        $this->SendIRCode(($Value+1));
                        break;
					case 25: //IR 26
                        $this->SendIRCode(($Value+1));
                        break;
					case 26: //IR 27
                        $this->SendIRCode(($Value+1));
                        break;
					case 27: //IR 28
                        $this->SendIRCode(($Value+1));
                        break;
					case 28: //IR 29
                        $this->SendIRCode(($Value+1));
                        break;
					case 29: //IR 30
                        $this->SendIRCode(($Value+1));
                        break;
					case 30: //IR 31
                        $this->SendIRCode(($Value+1));
                        break;
					case 31: //IR 32
                        $this->SendIRCode(($Value+1));
                        break;
                }
		}
		elseif(!null == ($this->GetIDForIdent('IRCODES2')) && $Ident == "IRCODES2" )
		{
			switch($Value) {
						case 0: //IR 33
							$this->SendIRCode(($Value+33));
							break;
						case 1: //IR 34
							$this->SendIRCode(($Value+33));
							break;
						case 2: //IR 35
							$this->SendIRCode(($Value+33));
							break;
						case 3: //IR 36
							$this->SendIRCode(($Value+33));
							break;
						case 4: //IR 37
							$this->SendIRCode(($Value+33));
							break;
						case 5: //IR 38
							$this->SendIRCode(($Value+33));
							break;
						case 6: //IR 39
							$this->SendIRCode(($Value+33));
							break;
						case 7: //IR 40
							$this->SendIRCode(($Value+33));
							break;
						case 8: //IR 41
							$this->SendIRCode(($Value+33));
							break;
						case 9: //IR 42
							$this->SendIRCode(($Value+33));
							break;
						case 10: //IR 43
							$this->SendIRCode(($Value+33));
							break;
						case 11: //IR 44
							$this->SendIRCode(($Value+33));
							break;
						case 12: //IR 45
							$this->SendIRCode(($Value+33));
							break;
						case 13: //IR 46
							$this->SendIRCode(($Value+33));
							break;
						case 14: //IR 47
							$this->SendIRCode(($Value+33));
							break;
						case 15: //IR 48
							$this->SendIRCode(($Value+33));
							break;
						case 16: //IR 49
							$this->SendIRCode(($Value+33));
							break;
						case 17: //IR 50
							$this->SendIRCode(($Value+33));
							break;
						case 18: //IR 51
							$this->SendIRCode(($Value+33));
							break;
						case 19: //IR 52
							$this->SendIRCode(($Value+33));
							break;
						case 20: //IR 53
							$this->SendIRCode(($Value+33));
							break;
						case 21: //IR 54
							$this->SendIRCode(($Value+33));
							break;
						case 22: //IR 55
							$this->SendIRCode(($Value+33));
							break;
						case 23: //IR 56
							$this->SendIRCode(($Value+33));
							break;
						case 24: //IR 57
							$this->SendIRCode(($Value+33));
							break;
						case 25: //IR 58
							$this->SendIRCode(($Value+33));
							break;
						case 26: //IR 59
							$this->SendIRCode(($Value+33));
							break;
						case 27: //IR 60
							$this->SendIRCode(($Value+33));
							break;
						case 28: //IR 61
							$this->SendIRCode(($Value+33));
							break;
						case 29: //IR 62
							$this->SendIRCode(($Value+33));
							break;
						case 30: //IR 63
							$this->SendIRCode(($Value+33));
							break;
						case 31: //IR 64
							$this->SendIRCode(($Value+33));
							break;
				}
		}
		elseif(!null == ($this->GetIDForIdent('IRCODES3')) && $Ident == "IRCODES3" )
		{
			switch($Value) {
						case 0: //IR 65
							$this->SendIRCode(($Value+65));
							break;
						case 1: //IR 66
							$this->SendIRCode(($Value+65));
							break;
						case 2: //IR 67
							$this->SendIRCode(($Value+65));
							break;
						case 3: //IR 68
							$this->SendIRCode(($Value+65));
							break;
						case 4: //IR 69
							$this->SendIRCode(($Value+65));
							break;
						case 5: //IR 70
							$this->SendIRCode(($Value+65));
							break;
						case 6: //IR 71
							$this->SendIRCode(($Value+65));
							break;
						case 7: //IR 72
							$this->SendIRCode(($Value+65));
							break;
						case 8: //IR 73
							$this->SendIRCode(($Value+65));
							break;
						case 9: //IR 74
							$this->SendIRCode(($Value+65));
							break;
						case 10: //IR 75
							$this->SendIRCode(($Value+65));
							break;
						case 11: //IR 76
							$this->SendIRCode(($Value+65));
							break;
						case 12: //IR 77
							$this->SendIRCode(($Value+65));
							break;
						case 13: //IR 78
							$this->SendIRCode(($Value+65));
							break;
						case 14: //IR 79
							$this->SendIRCode(($Value+65));
							break;
						case 15: //IR 80
							$this->SendIRCode(($Value+65));
							break;
						case 16: //IR 81
							$this->SendIRCode(($Value+65));
							break;
						case 17: //IR 82
							$this->SendIRCode(($Value+65));
							break;
						case 18: //IR 83
							$this->SendIRCode(($Value+65));
							break;
						case 19: //IR 84
							$this->SendIRCode(($Value+65));
							break;
						case 20: //IR 85
							$this->SendIRCode(($Value+65));
							break;
						case 21: //IR 86
							$this->SendIRCode(($Value+65));
							break;
						case 22: //IR 87
							$this->SendIRCode(($Value+65));
							break;
						case 23: //IR 88
							$this->SendIRCode(($Value+65));
							break;
						case 24: //IR 89
							$this->SendIRCode(($Value+65));
							break;
						case 25: //IR 90
							$this->SendIRCode(($Value+65));
							break;
						case 26: //IR 91
							$this->SendIRCode(($Value+65));
							break;
						case 27: //IR 92
							$this->SendIRCode(($Value+65));
							break;
						case 28: //IR 93
							$this->SendIRCode(($Value+65));
							break;
						case 29: //IR 94
							$this->SendIRCode(($Value+65));
							break;
						case 30: //IR 95
							$this->SendIRCode(($Value+65));
							break;
						case 31: //IR 96
							$this->SendIRCode(($Value+65));
							break;
				}
		}
		elseif(!null == ($this->GetIDForIdent('IRCODES4')) && $Ident == "IRCODES4" )
		{
			switch($Value)
				{
						case 0: //IR 97
							$this->SendIRCode(($Value+97));
							break;
						case 1: //IR 98
							$this->SendIRCode(($Value+97));
							break;
						case 2: //IR 99
							$this->SendIRCode(($Value+97));
							break;
						case 3: //IR 100
							$this->SendIRCode(($Value+97));
							break;
				}
		}
		else
		{
			$this->SendDebug(__FUNCTION__, "Invalid ident", 0);
		}

    }

	//IR Diode abfragen
	protected function GetIRDiode(){
		$IRDiode = $this->ReadPropertyString("IRDiode");
		return $IRDiode;
	}

	//Extender abfragen
	protected function GetExtIRDiode(){
		$EXTIRDiode = $this->ReadPropertyString("EXTIRDiode");
		return $EXTIRDiode;
	}


	public function SetPowerState(bool $state)
	{
		if ($state === true)
		{
		SetValueBoolean($this->GetIDForIdent('Status'), $state);
		//PowerOn abfragen
		$PowerOnCode = $this->ReadPropertyInteger("PowerOnCode");
		return $this->SendIRCode($PowerOnCode);
		}
		else
		{
		SetValueBoolean($this->GetIDForIdent('Status'), $state);
		//PowerOff abfragen
		$PowerOffCode = $this->ReadPropertyInteger("PowerOffCode");
		return $this->SendIRCode($PowerOffCode);
		}
	}


	//Senden eines IR Befehls über das a.i.o. Gateway
	public function SendIR1()
	{
            $IR_send = $this->ReadPropertyString("IRCode1");
			return $this->Send_IR($IR_send, $this->GetIRDiode(), $this->GetExtIRDiode());
    }

	public function SendIR2()
	{
            $IR_send = $this->ReadPropertyString("IRCode2");
			return $this->Send_IR($IR_send, $this->GetIRDiode(), $this->GetExtIRDiode());
    }


	public function SendIRCode(int $Value) {
			//IR Code auslesen Value 0 entspricht IRCode 1
			$IRCode = "IRCode".$Value;
			if($Value <= 32 && !null == ($this->GetIDForIdent('IRCODES1')))
			{
			$setvalue = $Value-1;
			SetValueInteger($this->GetIDForIdent('IRCODES1'), $setvalue);
			}
			elseif($Value <=64 && $Value >32 && !null == ($this->GetIDForIdent('IRCODES2')))
			{
			$setvalue = $Value-33;
			SetValueInteger($this->GetIDForIdent('IRCODES2'), $setvalue);
			}
			elseif($Value <=96 && $Value >64 && !null == ($this->GetIDForIdent('IRCODES3')))
			{
			$setvalue = $Value-65;
			SetValueInteger($this->GetIDForIdent('IRCODES3'), $setvalue);
			}
			elseif($Value <=100 && $Value >96 && !null == ($this->GetIDForIdent('IRCODES4')))
			{
			$setvalue = $Value-97;
			SetValueInteger($this->GetIDForIdent('IRCODES4'), $setvalue);
			}
			$IR_send = $this->ReadPropertyString($IRCode);
			$this->Send_IR($IR_send, $this->GetIRDiode(), $this->GetExtIRDiode());
			return true;
        }

	//IR Code senden
	private	$response = false;
	protected function Send_IR($ir_code, $IRDiode, $EXTIRDiode)
		{
            $aiogateway = new AIOGateway($this->InstanceID);
            $gatewaytype = $aiogateway->GetGatewaytype();
            $GatewayPassword = $aiogateway->GetPassword();
            $aiogatewayip = $aiogateway->GetIPGateway();
			//Sendestring zum Senden eines IR Befehls {IP Gateway}/command?code={IR Code}&XC_FNC=Send2&ir={Sendediode}&rf=00
			switch ($EXTIRDiode)
				{
				case "02":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 1 Interne Sendediode senden",0);
					break;

				case "12":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 1 Externe Sendediode 1 senden",0);
					break;

				case "22":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 1 Externe Sendediode 2 senden",0);
					break;

				case "32":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 1 Externe Sendediode 3 senden",0);
					break;

				case "03":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 2 Interne Sendediode senden",0);
					break;

				case "13":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 2 Externe Sendediode 1 senden",0);
					break;

				case "23":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 2 Externe Sendediode 2 senden",0);
					break;

				case "33":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 2 Externe Sendediode 3 senden",0);
					break;

				case "04":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 3 Interne Sendediode senden",0);
					break;

				case "14":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 3 Externe Sendediode 1 senden",0);
					break;

				case "24":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 3 Externe Sendediode 2 senden",0);
					break;

				case "34":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 3 Externe Sendediode 3 senden",0);
					break;

				case "05":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 4 Interne Sendediode senden",0);
					break;

				case "15":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 4 Externe Sendediode 1 senden",0);
					break;

				case "25":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 4 Externe Sendediode 2 senden",0);
					break;

				case "35":
					$IRDiode = "00";
					$this->SendDebug("AIO IR Device","IR Command über Extender 4 Externe Sendediode 3 senden",0);
					break;

				case "00":
					$this->SendDebug("AIO IR Device","IR Command über AIO Gateway senden mit Sendediode ".$IRDiode,0);
					break;
				}
			if ($GatewayPassword !== "")
			{
                if($gatewaytype == 6 || $gatewaytype == 7)
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&code=".$ir_code."&XC_FNC=Send2&ir=".$IRDiode."&rf=".$EXTIRDiode);
                    $this->SendDebug("AIO IR Device","IRCode: ".$ir_code,0);
                    $this->SendDebug("AIO IR Device","Senden an Gateway mit Passwort",0);
                }
                else
                {
                    $gwcheck = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&code=".$ir_code."&XC_FNC=Send2&ir=".$IRDiode."&rf=".$EXTIRDiode);
                    $this->SendDebug("AIO IR Device","IRCode: ".$ir_code,0);
                    $this->SendDebug("AIO IR Device","Senden an Gateway mit Passwort",0);
                }
			}
			else
			{
				$gwcheck = file_get_contents("http://".$aiogatewayip."/command?code=".$ir_code."&XC_FNC=Send2&ir=".$IRDiode."&rf=".$EXTIRDiode);
				$this->SendDebug("AIO IR Device","IRCode: ".$ir_code,0);
			}
			if ($gwcheck == "{XC_SUC}")
				{
				$this->response = true;
				}
			elseif ($gwcheck == "{XC_AUTH}")
			{
			$this->response = false;
			$this->SendDebug("AIO IR Device","Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch.",0);
			echo "Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch.";
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
				$this->SendDebug("AIO IR Profile","Variable profile type does not match for profile ".$Name,0);
        }

        IPS_SetVariableProfileIcon($Name, $Icon);
        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);

    }


	protected function IRProfileAssociation($Name, $MinValue, $MaxValue, $start)
	{
			//echo "Start: ".$start." MinVal: ".$MinValue." MaxVal: ".$MaxValue."<br>";
			$ircodes = $this->ArrIRCodes();
			for ($i = $MinValue; $i <= $MaxValue; $i++)
			{
				if (!empty($ircodes[($start+$i)][1]))
				{
					//boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe ) //Float Wert stimmt nicht
					// IR Codes nicht im Profil hinterlegt statt dessen die ID der IRCodes der Wert muss beim Senden abgefragt werden.
					IPS_SetVariableProfileAssociation( (string)$Name, (float)$i, (string)$ircodes[($start+$i)][0], "", -1 );//max 32 möglich
				}

			}
	}

	protected function RegisterProfileIRCodes($Name, $Icon, $start, $end, $NumberIRCodes)
	{
       	// $nameid = intval(substr($Name, -7, 1)); // Nummer des Vergebnen Profilnamens
		if ($NumberIRCodes == 0 )
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

	public function LearnDeviceCode(string $command_name)
	{
		$result = $this->Learn($command_name);
		return $result;
	}

	public function LearnCommandKey(int $list_number)
	{
		$command_name = $this->GetListCommand($list_number);
		if($command_name != false)
		{
			$this->SendDebug("AIO IR Learn:", "learn for command name ".$command_name , 0);
			$result = $this->Learn($command_name);
			return $result;
		}
		return "could not find command";
	}

	public function SendCommandKey(int $list_number)
	{
		$command_name = $this->GetListCommand($list_number);
		if($command_name != false)
		{
			$this->SendDebug("AIO IR Send:", "send for command name ".$command_name, 0);
			// $this->SendCommand($command_name);
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

	//Anlernen eines IR Codes über das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=Learn
	private function Learn($command_name)
		{
            $aiogateway = new AIOGateway($this->InstanceID);
            $gatewaytype = $aiogateway->GetGatewaytype();
            $GatewayPassword = $aiogateway->GetPassword();
            $aiogatewayip = $aiogateway->GetIPGateway();
			if ($GatewayPassword !== "")
			{
                if($gatewaytype == 6 || $gatewaytype == 7)
                {
                    $ircode = file_get_contents("http://".$aiogatewayip."/command?auth=".$GatewayPassword."&XC_FNC=Learn");
                }
                else
                {
                    $ircode = file_get_contents("http://".$aiogatewayip."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=Learn");
                }
			}
			else
			{
				$ircode = file_get_contents("http://".$aiogatewayip."/command?XC_FNC=Learn");
			}

		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($ircode == "{XC_ERR}Failed to learn code")//Bei Fehler
			{
			$this->response = false;
			//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$this->SendDebug("AIO Gateway","{XC_ERR}Failed to learn code.",0);
			$this->SendDebug("AIO IR Device","Das Gateway konnte keinen IRCode empfangen.",0);
			echo "Der IRCode konnte nicht angelernt werden.";
			//IPS_SetProperty($instance, "LearnIRCode", false); //Haken entfernen.
			IPS_SetProperty($this->InstanceID, "LearnIRCode", false); //Haken entfernen.
			}
		else
			{
				//Adresse auswerten bei Erfolg {XC_SUC}{"CODE":"1234455667789123456789123456789"}
				$ircode = strval(substr($ircode, 17));
				$length = strlen($ircode);
				$ircode = substr($ircode, 0, ($length-2));
				$this->SendDebug("AIO IR Device","IR Code: ".$ircode,0);
				$this->AddIRCode($ircode, $command_name);
				$this->response = true;
			}

		return $this->response;
		}

	//IR Code und Label hinzufügen
	protected function AddIRCode($ircode, $command_name)
	{
		$commands = $this->GetAvailableCommands();
		$NumberIRCodes = count($commands);
		$this->CreateProfileIR($NumberIRCodes);
		$newcode = ["key" => "huhu", "code" => "XXXX"];
		array_push($commands, $newcode);
		$this->SendDebug("AIO IR Device","IRCode".$command_name." hinzugefügt: ".$ircode,0);
		IPS_SetProperty($this->InstanceID, "AIOIRCommands", json_encode($commands));
		IPS_ApplyChanges($this->InstanceID);
	}

	public function Send(string $Text)
		{
			$this->SendDataToParent(json_encode(Array("DataID" => "{B87AC955-F258-468B-92FE-F4E0866A9E18}", "Buffer" => $Text)));
		}

	public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			$this->SendDebug("AIO IR Device",utf8_decode($data->Buffer),0);
			
			//Parse and write values to our variables

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
		$commands = $this->GetAvailableCommands();
		$number = count($commands);
		$IRCode1 = $this->ReadPropertyString("IRCode1");
		$IRCode2 = $this->ReadPropertyString("IRCode2");
		$AIOIRCommands = $this->ReadPropertyString("AIOIRCommands");
		$form = [];
		if($AIOIRCommands == "[]" && ($IRCode1 != "" || $IRCode2 != ""))
		{
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'IR Codes found, press button to convert IR codes to ir code list'
					],
					[
						'type' => 'Button',
						'caption' => 'Convert',
						'onClick' => 'AIOIR_ConvertIRCodesList($id);'
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
						'caption' => 'AIO IR device'
					],
					[
						'type' => 'List',
						'name' => 'AIOIRCommands',
						'caption' => 'available commands',
						'rowCount' => $number,
						'add' => true,
						'delete' => true,
						'sort' => [
							'column' => 'key',
							'direction' => 'ascending'
						],
						'columns' => [
							[
								'name' => 'key',
								'caption' => 'key label',
								'width' => '250px',
								'visible' => true,
								'add' => 'key label',
								'edit' => [
									'type' => 'ValidationTextBox'
								],
								'save' => true
							],
							[
								'name' => 'code',
								'caption' => 'code',
								'width' => 'auto',
								'visible' => true,
								'add' => '0',
								'edit' => [
									'type' => 'ValidationTextBox'
								],
								'save' => true
							]
						],
						'values' => $this->CommandListValues($commands)
					]
				]
			);
		}
		return $form;
	}

	private function CommandListValues($commands)
	{
		$form = [];
		$number = count($commands);
		if ($number == 0) {
			$this->SendDebug("AIO IR Form:", "empty no commands available", 0);
		} else {
			foreach ($commands as $key => $command) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'key' => $key,
							'code' => $command
						]
					]
				);
			}
		}
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
				'type' => 'ExpansionPanel',
				'caption' => 'Learn key',
				'items' => [
					[
						'type' => 'Select',
						'name' => 'learnkey',
						'caption' => 'key',
						'options' => $this->GetSendListCommands()
					],
					[
						'type' => 'Button',
						'caption' => 'Learn',
						'onClick' => 'AIOIR_LearnCommandKey($id, $learnkey);'
					]
				]
			],
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
						'onClick' => 'AIOIR_SendCommandKey($id, $sendkey);'
					]
				]
			]
		];
		return $form;
	}

	protected function GetSendListCommands()
	{
		$form = [
			[
				'caption' => 'Please Select',
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
						'caption' => $key,
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
		$current_valuesjson = $this->ReadPropertyString("ircodes");
		$AIOIRCommands = $this->ReadPropertyString("AIOIRCommands");
		if($current_valuesjson == "" && $AIOIRCommands == "[]")
		{
			$current_valuesjson = "[]";
		}
		elseif($current_valuesjson == "[]" && $AIOIRCommands != "[]")
		{
			$current_valuesjson = $AIOIRCommands;
		}
		$current_values = json_decode($current_valuesjson, true);
		$commands = [];
		foreach($current_values as $value)
			{
				// $commands[$value[0]] = $value[1];
                $commands[$value["key"]] = $value["code"];
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
				'caption' => 'AIO IR device created'
			],
			[
				'code' => 104,
				'icon' => 'inactive',
				'caption' => 'AIO IR device is inactive'
			],
			[
				'code' => 201,
				'icon' => 'inactive',
				'caption' => 'Please follow the instructions.'
			],
			[
				'code' => 202,
				'icon' => 'error',
				'caption' => 'special errorcode.'
			],
			[
				'code' => 203,
				'icon' => 'error',
				'caption' => 'No active AIO I/O.'
			]
		];

		return $form;
	}


}
