[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-5.0%20%3E-green.svg)](https://www.symcon.de/forum/threads/37412-IP-Symcon-5-0-%28Testing%29)


# IPSymconAIOGateway

Modul für IP-Symcon ab Version 5. Ermöglicht das Senden von Befehlen an das Mediola AIO Gateway.

## Documentation

**Table of Contents**

1. [Features](#1-features)
2. [Requirements](#2-requirements)
3. [Installation](#3-installation)
4. [Function reference](#4-functionreference)
5. [Configuration](#5-configuration)
6. [Annex](#6-annex)

## 1. Features

With the help of the AIO Gateway, devices can be operated that are otherwise controllable via IR remote controls or with radio 433/868 MHz.
For more information on controllable devices via the AIO gateway, go to  [Research Tool from Mediola.](http://www.mediola.com/recherche-tool-gesamt)

### Supported manufacturers

The devices that can be controlled via an AIO gateway depend on the AIO gateway model used. Compatibility can be search in the Tool from the manufacturer [Research_Tool from Mediola.](http://www.mediola.com/recherche-tool-gesamt) 
If the AIO gateway supports the device, it can also be controlled via IP-Symcon.

- Dooya
- ELRO
- FS20
- Homematic
- Intertechno
- LED controller
- SomfyRTS
- IR commands

### Send IR code:

 - Send an IR signal via the AIO Gateway
 - Import of the IR devices from the AIO Creator and AIO Creator NEO
 - Learning IR codes via the AIO Gateway from IP-Symcom
 
### Send radio code:

 - Sending a radio signal via the AIO Gateway
 - Import of radio (RF) devices from the AIO Creator NEO
 - Teaching of radio codes via the AIO Gateway from IP-Symcom

### Intertechno sockets:

 - Switching Intertechno sockets via the AIO Gateway
 - Import of the Intertechno devices from the AIO Creator and AIO Creator NEO
 - Learning of the family and device code via the AIO Gateway from IP-Symcom
 - On off.

### ELRO sockets:

 - Switching ELRO sockets via the AIO Gateway
 - Import of the ELRO devices from the AIO Creator and AIO Creator NEO
 - Learning the address via the AIO Gateway from IP-Symcom
 - On off.

### FS20 dimmer:

 - Switching of FS20 dimmers via the AIO Gateway.
 - Import of the FS20 devices from the AIO Creator and AIO Creator NEO
 - Teaching of the FS20 address via the AIO Gateway from IP-Symcom
 - ** Commands **: On, Off, Last, Toggle, Dimup, DimDown, 6.25%, 12.50%, 18.75%, 25.00%, 31.25%, 37.50%, 43 , 75%, 50.00%, 59.25%, 62.50%, 68.75%, 75.00%, 81.25%, 87.50%, 93.75%.

### FS20 switch:

 - Switching from an FS20 switch via the AIO Gateway.
 - Import of the FS20 devices from the AIO Creator and AIO Creator NEO
 - Teaching of the FS20 address via the AIO gateway from IP-Symcom
 - On off

### LED controller 1:

 - Switching from an LED controller via the AIO Gateway.
 - Import of the LED Controller 1 devices from the AIO Creator and AIO Creator NEO
 - Teaching the device address via the AIO Gateway from IP-Symcom
 - ** Commands **: power, up, down, play_pause, red, green, blue, white, orange, yellow, cyan, purple, auto, jump3, fade3, flash, jump7, fade7, speedUp, speedDown.
 
### LED Controller 2:

 - Switching from an LED controller via the AIO Gateway.
 - Import of the LED controller 2 devices from the AIO Creator and AIO Creator NEO
 - Teaching the device address via the AIO gateway from IP-Symcom
 - ** Commands **: Switch on, switch off, Cursor Left, Cursor Right, Cursor Up, Cursor Down, red, purple, blue, cyan, green, yellow, white, orange, color selection via color wheel

### Somfy RTS:

 - Switching from a Somfy RTS device via the AIO Gateway.
 - ** Commands **: Up, Down, Stop

### Dooya:

 - Switching from a Dooya device via the AIO Gateway.
 - ** Commands **: Up, Down, Stop


## 2. Requirements

- IPS > 5.2
- AIO Gateway accessible via IP address from IP-Symcon

## 3. Installation

### a. Loading the module

Open the IP Console's web console with _http://{IP-Symcon IP}:3777/console/_.

Then click on the module store icon in the upper right corner.

![Store](img/store_icon.png?raw=true "open store")

In the search field type

```
Mediola AIO Gateway
```  


![Store](img/module_store_search_en.png?raw=true "module search")

Then select the module and click _Install_

![Store](img/install_en.png?raw=true "install")

### b. Einrichtung in IPS

   In IP-Symcon das gewünschte Device anlegen. Sollte noch kein AIO Gateway
	angelegt worden sein, wird dies automatisch mit angelegt.
	Bei dem entsprechenden Device sind jeweils die Werte die im AIO Creator
	NEO eingetragen sind zu übernehmen.
	
	Der Port ist 1902 und darf nicht verstellt werden.
	
## 4. Import

Um Geräte die bereits im AIO Creator oder AIO Creator NEO nagelegt worden sind in IP-Symcon zu importieren ist zunächst ein
Import Instanz anzulegen. Dazu Instanz hinzufügen und als Hersteller *Mediola* auswählen und als Instanz **AIO Device Import**. 

*Instanzauswahl:*

![Instanz Auswahl](docs/Instanzauswahl.png?raw=true "Instanzauswahl")

*Importmodul*

![Import](docs/importmodul.png?raw=true "Import")
 
Auswahlfelder:
- Verzeichnis der Datei (Das Verzeichnis muss für IPS lesbar sein)
- Version Creator (Auswahl zwischen AIO Creator / AIO Creator NEO)
- zu importiernde Geräte (Haken setzten wenn Import gewünscht)
  - [ ] Infrarot Geräte importieren
  - [ ] Intechno Geräte importieren
  - [ ] ELRO Geräte importieren
  - [ ] FS20 Geräte importieren
  - [ ] Lightmanager 1 Geräte importieren
  - [ ] Lightmanager 2 Geräte importieren
  - [ ] Somfy RTS Geräte importieren
  - [ ] Funk (RF) Geräte importieren
- Kategorie zum Import (Vor dem Import eine Kategorie anlegen die hier dann auszuwählen ist)

## 5. Funktionsreferenz

### aioGatewaySplitter:

### IR Codes
 Die IR Codes sind aus dem AIO Creator zu kopieren
 
### Funk (RF) Codes
 Die Funk Codes sind aus dem AIO Creator zu kopieren 
 
### Intertechno
 Zum Ansteuern der Intertechno Steckdosen ist der Familycode und Devicecode einzutragen.
 
### ELRO
 Zum Ansteuern der ELRO Steckdosen ist der Familycode und Devicecode einzutragen. 

### FS20
 Zum Ansteuern von FS20 ist der HC1, HC2 Wert und die FS20 Adresse aus dem AIO Creator einzutragen.

## 6. Konfiguration

### aioGatewaySplitter:

| Eigenschaft | Typ     | Standardwert | Funktion                                  |
| :---------: | :-----: | :----------: | :---------------------------------------: |
| Open        | boolean | true         | Verbindung zum aioGateway aktiv / deaktiv |
| Host        | string  |              | Adresse des aioGateway                    |


### FS20:  

| Eigenschaft    | Typ     | Standardwert | Funktion                                                              |
| :------------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| HC1            | string  |              | HC1 Wert des FS20 Geräts abzulesen im Gerätemanager des AIO Creator   |
| HC2            | string  |              | HC1 Wert des FS20 Geräts abzulesen im Gerätemanager des AIO Creator   |
| FS20Adresse    | string  |              | FS20Adresse des FS20 Geräts abzulesen im Gerätemanager des AIO Creator|
| AIOFS20Adresse | string  |              | interne Sendeadresse für das AIO Gateway                              |

Wenn die interne Adresse ausgefüllt ist können die Felder HC1, HC2, FS20Adresse leer bleiben

### Intertechno:  

| Eigenschaft | Typ     | Standardwert | Funktion                                                              |
| :---------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| FamilyCode  | string  |              | Familien Code des Geräts abzulesen im Gerätemanager des AIO Creator   |
| DeviceCode  | string  |              | Geräte Code des Geräts abzulesen im Gerätemanager des AIO Creator     |

### ELRO:  

| Eigenschaft | Typ     | Standardwert | Funktion                                                              |
| :---------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| ELRO Adresse| string  |              | Adresse des Geräts abzulesen im Gerätemanager des AIO Creator         |

### Lightmanager:  

| Eigenschaft | Typ     | Standardwert | Funktion                                                              |
| :---------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| Adresse     | string  |              | Adresse des Geräts abzulesen im Gerätemanager des AIO Creator         |

### Somfy RTS:  

| Eigenschaft | Typ     | Standardwert | Funktion                                                              |
| :---------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| Adresse     | string  |              | Adresse des Geräts abzulesen im Gerätemanager des AIO Creator         |

### Dooya:  

| Eigenschaft | Typ     | Standardwert | Funktion                                                              |
| :---------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| Adresse     | string  |              | Adresse des Geräts abzulesen im Gerätemanager des AIO Creator         |

### IR Gerät:  

| Eigenschaft| Typ     | Standardwert | Funktion                                                              |
| :--------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| IRCode[i]  | string  |              | IR Code des Geräts abzulesen im Gerätemanager des AIO Creator         |
| IRLabel[i] | string  |              | Beschriftung des IR Codes                                             |

### RF Gerät:  

| Eigenschaft| Typ     | Standardwert | Funktion                                                              |
| :--------: | :-----: | :----------: | :-------------------------------------------------------------------: |
| RFCode[i]  | string  |              | IR Code des Geräts abzulesen im Gerätemanager des AIO Creator         |
| RFLabel[i] | string  |              | Beschriftung des IR Codes                                             |

## 7. Anhang

###  a. Funktionen:

#### ELRO:

`AIOELRO_PowerOn(integer $InstanceID)`
Einschalten

`AIOELRO_PowerOff(integer $InstanceID)`
Ausschalten

#### Intertechno:

`AIOIT_PowerOn(integer $InstanceID)`
Einschalten

`AIOIT_PowerOff(integer $InstanceID)`
Ausschalten

#### FS20:

`AIOFS20_On(integer $InstanceID)`
Einschalten

`AIOFS20_Off(integer $InstanceID)`
Ausschalten

`AIOFS20_Last(integer $InstanceID)`
Zuletzt gewählter Zustand des Dimmers

`AIOFS20_Toggle(integer $InstanceID)`
Toggle

`AIOFS20_DimUp(integer $InstanceID)`
Dimmer hochdimmen

`AIOFS20_DimDown(integer $InstanceID)`
Dimmer runterdimmen

`AIOFS20_Set10(integer $InstanceID)`
Dimmen auf 10%

`AIOFS20_Set20(integer $InstanceID)`
Dimmen auf 20%

`AIOFS20_Set30(integer $InstanceID)`
Dimmen auf 30%

`AIOFS20_Set40(integer $InstanceID)`
Dimmen auf 40%

`AIOFS20_Set50(integer $InstanceID)`
Dimmen auf 50%

`AIOFS20_Set60(integer $InstanceID)`
Dimmen auf 60%

`AIOFS20_Set70(integer $InstanceID)`
Dimmen auf 70%

`AIOFS20_Set80(integer $InstanceID)`
Dimmen auf 80%

`AIOFS20_Set90(integer $InstanceID)`
Dimmen auf 90%

#### AIO Lightmanager 1:

`AIOLight1_Power(integer $InstanceID)`
Ein/Aus Schalten

`AIOLight1_Up(integer $InstanceID)`
Helligkeit hoch

`AIOLight1_Down(integer $InstanceID)`
Helligkeit runter

`AIOLight1_Play_Pause(integer $InstanceID)`
Play/Pause

`AIOLight1_Red(integer $InstanceID)`
Rot

`AIOLight1_Green(integer $InstanceID)`
Grün

`AIOLight1_Blue(integer $InstanceID)`
Blau

`AIOLight1_White(integer $InstanceID)`
Weiß

`AIOLight1_Orange(integer $InstanceID)`
Orange

`AIOLight1_Yellow(integer $InstanceID)`
Gelb

`AIOLight1_Cyan(integer $InstanceID)`
Cyan

`AIOLight1_Purple(integer $InstanceID)`
Purple

`AIOLight1_Auto(integer $InstanceID)`
Automatik

`AIOLight1_Jump3(integer $InstanceID)`
3 Farben Wechsel

`AIOLight1_Fade3(integer $InstanceID)`
3 Farben Fade

`AIOLight1_Jump7(integer $InstanceID)`
7 Farben Wechsel

`AIOLight1_Fade7(integer $InstanceID)`
7 Farben Fade

`AIOLight1_Flash(integer $InstanceID)`
Flash

`AIOLight1_SpeedUp(integer $InstanceID)`
Geschwindigkeit schneller

`AIOLight1_SpeedDown(integer $InstanceID)`
Geschwindigkeit langsamer

#### AIO Lightmanager 2:

`AIOLight2_PowerOn(integer $InstanceID)`
Einschalten

`AIOLight2_PowerOff(integer $InstanceID)`
Ausschalten

`AIOLight2_Left(integer $InstanceID)`
Cursor Left

`AIOLight2_Right(integer $InstanceID)`
Cursor Right

`AIOLight2_Up(integer $InstanceID)`
Cursor Up

`AIOLight2_Down(integer $InstanceID)`
Cursor Down

`AIOLight2_Red(integer $InstanceID)`
Rot

`AIOLight2_Purple(integer $InstanceID)`
Lila

`AIOLight2_Blue(integer $InstanceID)`
Blau

`AIOLight2_Cyan(integer $InstanceID)`
Cyan

`AIOLight2_Green(integer $InstanceID)`
Green

`AIOLight2_Yellow(integer $InstanceID)`
Yellow

`AIOLight2_White(integer $InstanceID)`
Weiß

`AIOLight2_Orange(integer $InstanceID)`
Orange

#### IR Device:
`AIOIR_SendIRCode(integer $InstanceID, integer $IRCodenumber)`
Sendet einen IR Code der Instanz mit der InstanceID und dem IR Code [Nummer]

`AIOIR_Learn(integer $irid)`
Setzt das Gateway in den Lernzustand und trägt den angelernten Wert unter IR Code mit Nummer $irid ein

#### Funk (RF) Device:
`AIORF_SendIRCode(integer $InstanceID, integer $RFCodenumber)`
Sendet einen IR Code der Instanz mit der InstanceID und dem IR Code [Nummer]

`AIORF_Learn(integer $irid)`
Setzt das Gateway in den Lernzustand und trägt den angelernten Wert unter RF Code mit Nummer $irid ein

#### Somfy RTS Device:
`AIOSOMFYRTS_Up(integer $InstanceID)`
Up

`AIOSOMFYRTS_Stop(integer $InstanceID)`
Stop

`AIOSOMFYRTS_Down(integer $InstanceID)`
Down

###  b. GUIDs und Datenaustausch:

#### AIOGatewaySplitter:

GUID: `{7E03C651-E5BF-4EC6-B1E8-397234992DB4}` 

#### AIOSplitter Interface GUI:

GUID: `{1ED9A538-909B-44A6-A4C3-36D8EEB5A38A}`

#### AIOITDevice:

GUID: `{C45FF6B3-92E9-4930-B722-0A6193C7FFB5}`

#### AIOITDevice Interface GUI:

GUID: `{2E262F47-7706-479D-B826-CCCA503A59E2}`

#### AIOFS20Device:

GUID: `{8C7554CA-2530-4E6B-98DB-AC59CD6215A6}`

#### AIOFS20Device Interface GUI:

GUID: `{C6CF8A66-60D5-4181-9760-10924229C898}`

#### AIOELRODevice:

GUID: `{1B755DCC-7F12-4136-8D14-2ED86E6609B7}`

#### AIOELRODevice Interface GUI:

GUID: `{84F51839-8056-4E3D-AB29-FEFE9D300036}`  

#### AIOIRDevice:

GUID: `{4B0D8167-2932-4AD0-8455-26DC0C74485C}`

#### AIOIRDevice Interface GUI: 

GUID: `{35DE1449-FED2-4DE5-9E2C-13A619ACC210}`

#### Lightmanager 1:

GUID: `{488F8C6E-9448-44AD-8015-DF9DAD3232F3}` 

#### Lightmanager 1 Interface GUI:

GUID: `{8086DAFF-9DB4-4E74-9F1E-451C03C73522}`

#### Lightmanager 2:

GUID: `{12E05C8F-C409-4061-8838-492744227EFF}` 

#### Lightmanager 2 Interface GUI:

GUID: `{CFB217C9-DA27-4FB4-A1B2-33E42C9EE4F6}` 

#### AIOGateway:

GUID: `{CDA80465-AFB3-48E2-A237-B682335A4699}`

#### AIO Somfy RTS Device:

GUID: `{0F83D875-4737-4244-8234-4CF08E6F2626}` 

#### AIO Somfy RTS Device Interface GUI:

GUID: `{96D852F3-845B-4BAA-AF02-171C7CF33039}` 

#### AIO Dooya Device:

GUID: `{BFD0DE8E-5A3C-458C-828B-C26B53220B8C}` 

#### AIO Dooya Device Interface GUI:

GUID: `{EED83D19-52A7-4714-8ADE-899159EEAF3B}` 

#### AIO Homematic Device:

GUID: `{484B3E98-4395-4E65-A0D3-BDEE013A4B1A}` 

#### AIO Homematic Device Interface GUI:

GUID: `{2C55C259-F00F-4020-9386-FC3E783B8AA7}` 