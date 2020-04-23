<?php
declare(strict_types=1);

require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . '/../libs/ProfileHelper.php';
require_once __DIR__ . '/../libs/ConstHelper.php';

use Fonzo\Mediola\AIOGateway;
use Fonzo\Mediola\FS20;

class AIOFS20Device extends IPSModule
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


		$this->RegisterPropertyString("HC1", "");
		$this->RegisterPropertyString("HC2", "");
		$this->RegisterPropertyString("Adresse", "");
		$this->RegisterPropertyString("AIOAdresse", "");
		$this->RegisterPropertyString("FS20Type", "Switch");
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
		$HC1 = $this->ReadPropertyString("HC1");
		$HC2 = $this->ReadPropertyString("HC2");
		$FS20Adresse = $this->ReadPropertyString("Adresse");
		$AIOFS20Adresse = $this->ReadPropertyString("AIOAdresse");
		$address = $this->ReadPropertyString("address");


		if ($address != "") {
			$this->SetupVar();
			// Status aktiv
			$this->SetStatus(IS_ACTIVE);
		}

		if ($AIOFS20Adresse != '') {
			//AIOFS20Adresse prüfen
			if (strlen($AIOFS20Adresse) < 6 or strlen($AIOFS20Adresse) > 6)//Länge prüfen
			{
				$this->SetStatus(207);
			} else {
				$this->SetupVar();
				// Status aktiv
				$this->SetStatus(IS_ACTIVE);
			}

		} elseif ($HC1 == '' || $HC2 == '' || $FS20Adresse == '') {
			// Status inaktiv
			$this->SetStatus(202);
		} else {


			//Eingabe überprüfen Länge 4 Zeichen nur Zahlen
			if (strlen($HC1) < 4 or strlen($HC1) > 4)//Länge prüfen
			{
				$this->SetStatus(204);
			} elseif (strlen($HC2) < 4 or strlen($HC2) > 4)//Länge prüfen
			{
				$this->SetStatus(205);
			} elseif (strlen($FS20Adresse) < 4 or strlen($FS20Adresse) > 4)//Länge prüfen
			{
				$this->SetStatus(206);
			} elseif (!ctype_digit($HC1))//Nur Zahlen
			{
				$this->SetStatus(204);
			} elseif (!ctype_digit($HC2))//Nur Zahlen
			{
				$this->SetStatus(205);
			} elseif (!ctype_digit($FS20Adresse))//Nur Zahlen
			{
				$this->SetStatus(206);
			} else {
				// Status aktiv
				$this->SetStatus(IS_ACTIVE);
				$this->SetupVar();
			}

		}


	}


	protected function SetupVar()
	{
		$FS20Type = $this->ReadPropertyString("FS20Type");
		//Status-Variablen anlegen
		$this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
		$this->EnableAction("Status");

		// Variablen bei Dimmer anlegen
		if ($FS20Type === "Dimmer") {
			//  register profiles
			$this->RegisterProfileAssociation(
				'Dimmer.AIOFS20',
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

			$this->RegisterVariableInteger("Dimmer", "Dimmer", "Dimmer.AIOFS20", 2);
			$this->EnableAction("Dimmer");
		}
	}


	public function RequestAction($Ident, $Value)
	{
		switch ($Ident) {
			case "Status":
				$this->SetPowerState($Value);
				break;
			case "Dimmer":
				switch ($Value) {
					case 0: //0
						$this->Set0();
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


	protected function SetPowerState($state)
	{
		if ($state === true) {
			$action = "1000";
			return $this->SendCommand($action);
		} else {
			$action = "0000";
			return $this->SendCommand($action);
		}
	}

	public function On()
	{
		return $this->SendCommand(FS20::On);
	}

	public function Off()
	{
		return $this->SendCommand(FS20::Off);
	}

	public function Last()
	{
		return $this->SendCommand(FS20::Last);
	}

	public function Toggle()
	{
		return $this->SendCommand(FS20::Toggle);
	}

	public function DimUp()
	{
		return $this->SendCommand(FS20::DimUp);
	}

	public function DimDown()
	{
		return $this->SendCommand(FS20::DimDown);
	}

	// DIM0 - Auf 0% dimmen
	public function Set0()
	{
		return $this->SendCommand(FS20::Set0);
	}

	// 0100 - Auf 6,25% dimmen
	public function Set6()
	{
		return $this->SendCommand(FS20::Set6);
	}

	// 0200 - Auf 12,50% dimmen (im Creator ~10%)
	public function Set10()
	{
		return $this->SendCommand(FS20::Set10);
	}

	// 0300 - Auf 18,75% dimmen (im Creator ~20%)
	public function Set20()
	{
		return $this->SendCommand(FS20::Set20);
	}

	// 0400 - Auf 25,00% dimmen
	public function Set25()
	{
		return $this->SendCommand(FS20::Set25);
	}

	// 0500 - Auf 31,25% dimmen (im Creator ~30%)
	public function Set30()
	{
		return $this->SendCommand(FS20::Set30);
	}

	// 0600 - Auf 37,50% dimmen (im Creator ~40%)
	public function Set40()
	{
		return $this->SendCommand(FS20::Set40);
	}

	// 0700 - Auf 43,75% dimmen
	public function Set44()
	{
		return $this->SendCommand(FS20::Set44);
	}

	// 0800 - Auf 50,00% dimmen (im Creator ~50%)
	public function Set50()
	{
		return $this->SendCommand(FS20::Set50);
	}

	// 0900 - Auf 59,25% dimmen (im Creator ~60%)
	public function Set60()
	{
		return $this->SendCommand(FS20::Set60);
	}

	// 0A00 - Auf 62,50% dimmen
	public function Set63()
	{
		return $this->SendCommand(FS20::Set63);
	}

	// 0B00 - Auf 68,75% dimmen (im Creator ~70%)
	public function Set70()
	{
		return $this->SendCommand(FS20::Set70);
	}

	// 0C00 - Auf 75,00% dimmen
	public function Set75()
	{
		return $this->SendCommand(FS20::Set75);
	}

	// 0D00 - Auf 81,25% dimmen (im Creator ~80%)
	public function Set80()
	{
		return $this->SendCommand(FS20::Set80);
	}

	// 0E00 - Auf 87,50% dimmen (im Creator ~90%)
	public function Set90()
	{
		return $this->SendCommand(FS20::Set90);
	}

	// 0F00 - Auf 93,75% dimmen
	public function Set94()
	{
		return $this->SendCommand(FS20::Set94);
	}

	// DIM100 - Auf 100% dimmen
	public function Set100()
	{
		return $this->SendCommand(FS20::Set100);
	}

	//Senden eines Befehls an FS20
	// Sendestring FS20 {IP Gateway}/command?XC_FNC=SendSC&type=FS20&data={FS20 Send Adresse}{Command} 
	private $response = false;

	protected function SendCommand($command)
	{
		$aiogateway = new AIOGateway($this->InstanceID);
		$gatewaytype = $aiogateway->GetGatewaytype();
		$GatewayPassword = $aiogateway->GetPassword();
		$aiogatewayip = $aiogateway->GetIPGateway();
		$FS20 = $this->Calculate();
		$this->SendDebug("AIO Gateway:", "Send to FS20 address " . $FS20, 0);
		$this->SendDebug("AIO Gateway:", "Send Command " . $command, 0);

		switch ($command) {
			case "1000": //An
				SetValueBoolean($this->GetIDForIdent('Status'), true);

				if (@$this->GetIDForIdent("Dimmer")) {
					SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
				}
				break;
			case "0000": //Aus
				SetValueBoolean($this->GetIDForIdent('Status'), false);
				if (@$this->GetIDForIdent("Dimmer")) {
					SetValueInteger($this->GetIDForIdent('Dimmer'), 0);
				}
				break;
			case "DIM0": //0
				SetValueBoolean($this->GetIDForIdent('Status'), false);
				SetValueInteger($this->GetIDForIdent('Dimmer'), 0);
				$command = "0000";
				break;
			case "0200": //10
				SetValueInteger($this->GetIDForIdent('Dimmer'), 1);
				break;
			case "0300": //20
				SetValueInteger($this->GetIDForIdent('Dimmer'), 2);
				break;
			case "0500": //30
				SetValueInteger($this->GetIDForIdent('Dimmer'), 3);
				break;
			case "0600": //40
				SetValueInteger($this->GetIDForIdent('Dimmer'), 4);
				break;
			case "0800": //50
				SetValueInteger($this->GetIDForIdent('Dimmer'), 5);
				break;
			case "0900": //60
				SetValueInteger($this->GetIDForIdent('Dimmer'), 6);
				break;
			case "0B00": //70
				SetValueInteger($this->GetIDForIdent('Dimmer'), 7);
				break;
			case "0D00": //80
				SetValueInteger($this->GetIDForIdent('Dimmer'), 8);
				break;
			case "0E00": //90
				SetValueInteger($this->GetIDForIdent('Dimmer'), 9);
				break;
			case "DIM100": //100
				SetValueBoolean($this->GetIDForIdent('Status'), true);
				SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
				$command = "1000";
				break;
		}

		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$gwcheck = file_get_contents("http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command);
				$this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command, 0);
			} else {
				$gwcheck = file_get_contents("http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command);
				$this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command, 0);
			}
		} else {
			$gwcheck = file_get_contents("http://" . $aiogatewayip . "/command?XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command);
            $this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_FNC=SendSC&type=" . FS20::Type . "&data=" . $FS20 . $command, 0);
		}
		$this->SendDebug("AIO Gateway Recieve", $gwcheck, 0);
		if ($gwcheck == "{XC_SUC}") {
			$this->response = true;
		} elseif ($gwcheck == "{XC_AUTH}") {
			$this->response = false;
			echo "Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch.";
		}
		return $this->response;
	}


	//Anmelden eines FS20 Geräts an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=LearnSC&type=FS20
	public function Learn()
	{
		$aiogateway = new AIOGateway($this->InstanceID);
		$gatewaytype = $aiogateway->GetGatewaytype();
		$GatewayPassword = $aiogateway->GetPassword();
		$aiogatewayip = $aiogateway->GetIPGateway();

		if ($GatewayPassword !== "") {
			if ($gatewaytype == AIOGateway::V5 || $gatewaytype == AIOGateway::V5PLUS || $gatewaytype == AIOGateway::V6MINI || $gatewaytype == AIOGateway::V6MINIE || $gatewaytype == AIOGateway::V6 || $gatewaytype == AIOGateway::V6E) {
				$address = file_get_contents("http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=LearnSC&type=" . FS20::Type);
				$this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?auth=" . $GatewayPassword . "&XC_FNC=LearnSC&type=" . FS20::Type, 0);
			} else {
				$address = file_get_contents("http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=LearnSC&type=" . FS20::Type);
				$this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?XC_USER=user&XC_PASS=" . $GatewayPassword . "&XC_FNC=LearnSC&type=" . FS20::Type, 0);
			}
		} else {
			$address = file_get_contents("http://" . $aiogatewayip . "/command?&XC_FNC=LearnSC&type=" . FS20::Type);
			$this->SendDebug("String to AIO Gateway", "http://" . $aiogatewayip . "/command?&XC_FNC=LearnSC&type=" . FS20::Type, 0);
		}
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($address == "{XC_ERR}Failed to learn code")//Bei Fehler
		{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			IPS_LogMessage("FS20 Adresse:", $address);
			echo "Die Adresse vom FS20 Gerät konnte nicht angelernt werden.";
			IPS_SetProperty($instance, "LearnFS20Address", false); //Haken entfernen.			
		} else {
			//Adresse auswerten {XC_SUC}
			//bei Erfolg {XC_SUC}{"CODE":"123403"}
			$address = strval(substr($address, 17, 6));
			IPS_LogMessage("FS20 Adresse:", $address);
			//echo "Adresse des FS20 Geräts: ".$address;
			$this->AddAddress($address);
			$this->response = true;
		}

		return $this->response;
	}

	//IT Adresse hinzufügen
	protected function AddAddress($address)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "AIOAdresse", $address); //FS20 Adresse setzten.
		IPS_SetProperty($instance, "LearnFS20Address", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage("FS20 Adresse hinzugefügt:", $address);
		// Status aktiv
		$this->SetStatus(102);
		$this->SetupVar();
	}


	//Berechnung des FS20 Codes
	protected function Calculate()
	{
		$HC1 = $this->ReadPropertyString("HC1");
		$HC2 = $this->ReadPropertyString("HC2");
		$FS20Adresse = $this->ReadPropertyString("Adresse");
		$AIOFS20Adresse = $this->ReadPropertyString("AIOAdresse");
		if ($AIOFS20Adresse != "") {
			$FS20_send = $AIOFS20Adresse;
			return $FS20_send;
		} else {
			$FS20_Code = $HC1 . $HC2 . $FS20Adresse;
			//print_r($FS20_Code);
			$arr1 = str_split($FS20_Code);
			//print_r($arr1);
			/* Stelle um 1 reduzieren */
			for ($i = 0; $i <= 11; $i++) {
				$arr1[$i] = $arr1[$i] - 1;
			}
			/* Aufteilung in Zweierblöcke */
			/* Die jeweils erste Zahl eines Blocks wird mit 4 multipliziert und mit der zweiten Zahl addiert */
			for ($i = 0; $i <= 10; $i = $i + 2) {
				$arr2[$i] = $arr1[$i] * 4 + $arr1[$i + 1];
			}
			/* Jeder Block wird nun in seine Hexadezimaldarstellung überführt (0-9, A-F) */
			for ($i = 0; $i <= 10; $i = $i + 2) {
				$arr2[$i] = dechex($arr2[$i]);
			}
			$FS20_send = $arr2[0] . $arr2[2] . $arr2[4] . $arr2[6] . $arr2[8] . $arr2[10];
			return $FS20_send;
		}

	}

	public function SendCommandKey(int $list_number)
	{
		$command_name = $this->GetListCommandName($list_number);
		$command = $this->GetListCommand($command_name);
		if ($command_name != false) {
			$this->SendDebug("FS20 Send:", "send command name " . $command_name, 0);
			$this->SendCommand($command);
		}
	}

	protected function GetListCommandName($list_number)
	{
		$commands = $this->GetAvailableCommands();
		$i = 1;
		foreach ($commands as $key => $command) {
			if ($list_number == $i) {
				return $key;
			}
			$i++;
		}
		return false;
	}

	protected function GetListCommand($command_name)
	{
		$command = false;
		$commands = [
			"On" => FS20::On,
			"Off" => FS20::Off
		];
		if(key_exists($command_name, $commands))
		{
			$command = $commands[$command_name];
		}
		return $command;
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
						'caption' => 'FS20 address',
						'items' => [
							[
								'type' => 'Label',
								'caption' => 'Look up values in the AIO NEO'
							],
							[
								'name' => 'HC1',
								'type' => 'ValidationTextBox',
								'caption' => 'HC 1'
							],
							[
								'name' => 'HC2',
								'type' => 'ValidationTextBox',
								'caption' => 'HC 2'
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
						'caption' => 'FS20 type',
						'items' => [
							[
								'type' => 'Select',
								'name' => 'FS20Type',
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
		} else {
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'AIO FS20 device'
					],
					[
						'name' => 'AIOAdresse',
						'type' => 'ValidationTextBox',
						'caption' => 'AIO FS20 address'
					],
					[
						'type' => 'ExpansionPanel',
						'caption' => 'FS20 type',
						'items' => [
							[
								'type' => 'Select',
								'name' => 'FS20Type',
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
		if ($address == "") {
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
								'onClick' => 'AIOFS20_Learn($id);'
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
							'onClick' => 'AIOFS20_SendCommandKey($id, $sendkey);'
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
		$FS20Type = $this->ReadPropertyString("FS20Type");
		$commands = [];
		if ($FS20Type == "Switch") {
			$commands["On"] = 1;
			$commands["Off"] = 2;
		} else {
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
				'code' => IS_CREATING,
				'icon' => 'inactive',
				'caption' => 'Creating instance.'
			],
			[
				'code' => IS_ACTIVE,
				'icon' => 'active',
				'caption' => 'AIO FS20 device created'
			],
			[
				'code' => IS_INACTIVE,
				'icon' => 'inactive',
				'caption' => 'AIO Fs20 device is inactive'
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
