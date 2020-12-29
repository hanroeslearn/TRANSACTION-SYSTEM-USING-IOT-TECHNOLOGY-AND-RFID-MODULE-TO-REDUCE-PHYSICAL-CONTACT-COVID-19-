//#include<WiFi.h>

#include <WebServer.h>
#include <HTTPClient.h>

//----------------------------------------Include the SPI and MFRC522 libraries-------------------------------------------------------------------------------------------------------------//
//----------------------------------------Download the MFRC522 / RC522 library here: https://github.com/miguelbalboa/rfid
#include <SPI.h>
#include <MFRC522.h>
#include <LiquidCrystal_PCF8574.h> //library show LCD
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

LiquidCrystal_PCF8574 lcd(0x27); //0x3f (Can find with I2C Scanner)

#define RST_PIN 4  //--> RST is connected to pinout D1                    // 5    // 17
#define SS_PIN 5  //--> SDA / SS is connected to pinout D2               // 21   // 5
MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance.

const int pinBuzzer = 13;

#define ON_Board_LED 2  //--> Defining an On Board LED, used for indicators when the process of connecting to a wifi router

//----------------------------------------SSID and Password of your WiFi router-------------------------------------------------------------------------------------------------------------//
const char* ssid = "Redmi4A";                // Rahman11       // Redmi4A
const char* password = "hanif1234";         // illiyiin@11    // hanif1234
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//============================================================================================================================== URL ADDRESS
String IP = "https://marimembantu.000webhostapp.com/";
//========= "http://103.52.213.109/"
//========= "http://saltransp.com/"
//========= "http://192.168.0.9/"
//========= "http://192.168.43.210/"
//========= "http.begin("http://192.168.1.100/NodeMCU-and-RFID-RC522-IoT-Projects/getUID.php");  //Specify request destination
//========= "https://marimembantu.000webhostapp.com/"

String folder = "";
//========= "RFID/"
//========= ""

String Server = "getUID2.php";
//========= "getUID2.php"
//========= "getUID.php"
String begin_srvr = IP + folder + Server;

String Trig = "trigger2.txt";
//========= "trigger.php"
//========= "trigger2.php"
String trigger_srvr = IP + folder + Trig;

String Name = "name2.txt";
//========= "name2.php"
//========= "name.php"
String name_srvr = IP + folder + Name;

String Balance = "balance2.txt";
//========= "balance2.php"
//========= "balance.php"
String balance_srvr = IP + folder + Balance;
//============================================================================================================================== URL ADDRESS

//=========================================== Security Admin
String Admin = "17EF20B5";
int trigger_Admin = 0;
String check_Admin;
//=========================================== Security Admin

//=========================================== Security Admin - Registration
int trigger_Regist = 0;
int time_regist1;
int time_regist2;
int interval_regist = 5000;   // (millisecond)
String ID_Regist;
//=========================================== Security Admin - Registration

int timeout = 15000;           // (millisecond)
int time_out1;
int time_out2;
int interval;

int Time1;
int Time2;
int Delay;
    
String triggerID;
String triggerID2;
String nameID;
String balanceID;

int balance;
int price = 200000;

//=========================================== SEND ID CARD
String UIDresultSend, postData;
int httpCode;
String payload;
//=========================================== SEND ID CARD

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//ESP8266WebServer server(80);  //--> Server on port 80
WiFiServer server(80);

int readsuccess;
int readsucces_trigger;

byte readcard[4];
char str[32] = "";
String StrUID;

int i=0,j=0,k=0,m=0,n=0;

//==========================================================================================================================================================================================//
//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
  pinMode(pinBuzzer, OUTPUT);
  buzzer_start();
  Serial.begin(115200);                                   //--> Initialize serial communications with the PC
  lcd.begin(16,2);                                        //Size of LCD 16 x 2
  lcd.setBacklight(255);                                  //On Background Lamp LCD
  lcd.setCursor (0,0);
  SPI.begin();                                            //--> Init SPI bus
  mfrc522.PCD_Init();                                     //--> Init MFRC522 card
  delay(500);
  WiFi.begin(ssid, password);                             //--> Connect to your WiFi router
  Serial.println("");
  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH);                       //--> Turn off Led On Board
  //---------------------------------------------------------------------------------- Wait for connection
  lcd_serialprint_startConnecting();
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    lcd_connect();
    //---------------------------------------------------------------------------------- Make the On Board Flashing LED on the process of connecting to the wifi router.
    Blinky_Wifi_Connect();
  }
  digitalWrite(ON_Board_LED, HIGH);                       //--> Turn off the On Board LED when it is connected to the wifi router.
  //------------------------------------------------------------------- If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  lcd_serialprint_Connected();
  Serial.println("Please tag a card or keychain to see the UID !");
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//==========================================================================================================================================================================================//

//==========================================================================================================================================================================================//
//-----------------------------------------------------------------------------------------------LOOP---------------------------------------------------------------------------------------//
void loop() {
  // put your main code here, to run repeatedly
  Back_First:
  
  readsuccess = getid();
  lcd_card(); //--------------------> LCD Display Looping Card

  //==========================================================================================================================================
  //========================================================================================= SECURITY ADMIN
  if (readsuccess) 
  {
    digitalWrite(ON_Board_LED, LOW);
    buzzer_detect_card();
    lcd.setCursor(0,1);
    check_Admin = StrUID;
    if (check_Admin == Admin )
    {
      lcd_serialprint_adminCorrect();
      buzzer_true();
      delay(500);
      lcd.setCursor(0,0);
      //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
      //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> REGISTRATION
      time_regist1 = millis();
      while(1 && trigger_Admin == 0)
      {
        //Serial.println("+");
        time_regist2 = millis();
        if (time_regist2 - time_regist1 >= interval_regist)
        {
          // NOT REGISTER
          //Serial.println("Not Register");
          break;
        }
        readsucces_trigger = getid();
        if(readsucces_trigger)
        {
          buzzer_detect_card();
          
          check_Admin = StrUID;
          if (check_Admin == Admin )
          {
            trigger_Regist +=1;
            lcd_serialprint_registration();
            break;
          }
        }
      }
      //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> REGISTRATION
      //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
      trigger_Admin += 1;
      j = 0;
      k = 0;
      if(trigger_Admin == 1)
      {
        lcd_serialprint_welcome();
        goto Back_First;
      }
      else if (trigger_Admin == 2)
      {
        lcd_serialprint_close();
        trigger_Admin = 0;       // Back to Zero
        trigger_Regist = 0;
      }
    }
    else if (trigger_Admin == 0)
    {
      lcd_serialprint_adminFalse();
      buzzer_false();
      delay(500);
      lcd.clear();
      j = 0;
      k = 0;
      goto Back_First;
    }
  }
  //========================================================================================= SECURITY ADMIN
  //==========================================================================================================================================
  
  //==========================================================================================================================================
  //========================================================================================= REGIST CARD
  if (readsuccess == 1 && trigger_Admin == 1 && trigger_Regist == 1)
  {
    digitalWrite(ON_Board_LED, LOW);
    buzzer_detect_card();
    ID_Regist = StrUID;
    j=0;
    lcd_detected();   //--------------------> LCD Display Card Detected
    SEND_ID_CARD();
    lcd_serialprint_statusRegist();    
  }
  //========================================================================================= REGIST CARD
  //==========================================================================================================================================

  //==========================================================================================================================================
  //========================================================================================= REAL TAG CARD
  if (readsuccess == 1 && trigger_Admin == 1 && trigger_Regist == 0)
  {
    digitalWrite(ON_Board_LED, LOW);
    Time1 = millis();
    buzzer_detect_card();
    j=0;
    lcd_detected();   //--------------------> LCD Display Card Detected
    SEND_ID_CARD();
    serial_print_address();
    // -------------------------------------- First Trigger
    triggerID = httpGETRequest(trigger_srvr);
    Serial.print(" => Trigger 1 = "); Serial.println(triggerID);
    triggerID2 = triggerID;
    time_out1 = millis();
    lcd_status_http(httpCode);    //--------------------> LCD Display Status 
    if(httpCode == 200)
    {
      Serial.println();
      triggerID2 = httpGETRequest(trigger_srvr);
      Serial.print(" => Trigger 2 = "); Serial.println(triggerID2);
      time_out2 = millis();
      while(triggerID == triggerID2)
      {
//============================================================
//==================================================== TIMEOUT
        interval = time_out2 - time_out1;
        if(interval >= timeout)            
        {
          lcd_serialprint_timeout();
          buzzer_false();
          goto Time_out;
        }
//==================================================== TIMEOUT
//============================================================
        triggerID2 = httpGETRequest(trigger_srvr);
        time_out2 = millis();
        Serial.print(" => Trigger 2 = "); Serial.println(triggerID2);
        lcd.setCursor(0,1);
        lcd.print("Please Wait");
        lcd_wait_trigger();
      }
      lcd.clear();
      nameID = httpGETRequest(name_srvr);
      lcd.setCursor(0,0);
      if(nameID == "--------")
      {
        lcd.print("Not Registered");
        buzzer_false();
        serial_print_notRegister();
      }
      else
      {
        lcd.print(nameID);
        lcd.setCursor(0,1);
        Serial.println();
        balanceID = httpGETRequest(balance_srvr);
        balance = balanceID.toInt();
        serial_print_Name(); 
        if(balance < price)
        {
          lcd.print("Fail Withdraw");
          Serial.print(" =>Fail Withdraw<= ");
          buzzer_false();   
        }
        else
        {
          balance = balance - price;
          lcd.print("Success Withdraw");
          Serial.print(" =>Success Withdraw<= ");
          buzzer_true();
        }
        delay(3000);
        lcd_serialprint_Saldo();
      }
      Time2 = millis();
      Delay = Time2 - Time1;
      Serial.print("=> Time: "); Serial.println(Delay);
    }
    Time_out:
    Serial.println(); Serial.println("Please tag a card or keychain to see the UID !");
    delay(3000);
    lcd.clear();
  }
  //========================================================================================= REAL TAG CARD
  //==========================================================================================================================================
  
  //==========================================================================================================================================
  //========================================================================================= CHECK THE CONNECTION
  i=0;
  while (WiFi.status() != WL_CONNECTED)     //Check for the connection
  { 
      buzzer_disconnect();
      WiFi.disconnect();
      WiFi.begin(ssid, password); 
      lcd.clear();
      Serial.print("Wifi: ");
      Serial.print(ssid);
      Serial.println(" => Disconnected");
      Serial.println("Connecting");
      while (WiFi.status() != WL_CONNECTED) {
          Serial.print(".");
          lcd_disconnect();
          lcd_connect();
          //----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router.
          Blinky_Wifi_Connect();
      }
      lcd.clear(); 
      j = 0;
      k = 0;
      Serial.println("Successfully Connected");
      Serial.print("IP address: "); Serial.println(WiFi.localIP());
  }
  //========================================================================================= CHECK THE CONNECTION
  //==========================================================================================================================================
  digitalWrite(ON_Board_LED, HIGH);
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//==========================================================================================================================================================================================//

//========================================================          EVERY FUNCTION "void"           ========================================================================================//
//----------------------------------------Procedure for reading and obtaining a UID from a card or keychain---------------------------------------------------------------------------------//
int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }

  Serial.println("Card Detected!");
  Serial.println();
  Serial.print("THE UID OF THE SCANNED CARD IS : ");

  for (int i = 0; i < 4; i++) {
    readcard[i] = mfrc522.uid.uidByte[i]; //storing the UID of the tag in readcard
    array_to_string(readcard, 4, str);
    StrUID = str;
  }
  mfrc522.PICC_HaltA();
  return 1;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Procedure to change the result of reading an array UID into a string------------------------------------------------------------------------------//
void array_to_string(byte array[], unsigned int len, char buffer[]) {
  for (unsigned int i = 0; i < len; i++)
  {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1  < 0xA ? '0' + nib1  : 'A' + nib1  - 0xA;
    buffer[i * 2 + 1] = nib2  < 0xA ? '0' + nib2  : 'A' + nib2  - 0xA;
  }
  buffer[len * 2] = '\0';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------SEND ID CARD VIA HTTP---------------------------------------------------------------------------------------------------------------//
void SEND_ID_CARD()
{
  HTTPClient http;    //Declare object of class HTTPClient

  UIDresultSend = StrUID;
  Serial.println(UIDresultSend);

  //Post Data
  postData = "UIDresult=" + UIDresultSend;

  http.begin(begin_srvr);

  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header

  httpCode = http.POST(postData);   //Send the request
  payload = http.getString();    //Get the response payload

  Serial.print("httpCode: ");
  Serial.println(httpCode);   //Print HTTP return code
  //Serial.print("payload = ");
  //Serial.println(payload);    //Print request response payload

  http.end();  //Close connection
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------BLINKY WIFI CONNECTION--------------------------------------------------------------------------------------------------------------//
void Blinky_Wifi_Connect()
{
  digitalWrite(ON_Board_LED, LOW);
  delay(250);
  digitalWrite(ON_Board_LED, HIGH);
  delay(250);
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//====================================================== LCD SERIAL PRINT ==================================================================================================================//
//-------------------------------------------------------------------------//
void lcd_serialprint_startConnecting()
{
  Serial.println(ssid);
  Serial.print("Connecting");
  lcd.setCursor (0,0);
  lcd.print("=> ");
  lcd.print(ssid);
  lcd.setCursor (0,1);
  lcd.println("Connecting");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_connect()
{
  if(i == 6)
    {
      i=0;
      lcd.setCursor (0,1);
      lcd.print("Connecting      ");
      //lcd.setCursor(10,1);
    }
    else
    {
      lcd.setCursor(10+i,1);
      lcd.print(".");
      i++;
    }
  Serial.print(".");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_Connected()
{
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  lcd.setCursor(0,1);
  lcd.print("== Connected! ==");
  delay(1000);
  lcd.clear();
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_adminCorrect()
{
  lcd.print("=> Admin Correct");
  Serial.println("Admin Card Correct");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_adminFalse()
{
  lcd.print("=>Admin False   ");
  Serial.println("Admin Card False");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_statusRegist()
{
  lcd.setCursor(0,0);
    lcd.print("==> ID: ");
    lcd.print(ID_Regist);

    lcd.setCursor(0,1);
    if(httpCode == 200)
    {
      lcd.print("Regist Complete!");
      Serial.println("Registration Complete");
    }
    else
    {
      lcd.print("Regist Fail!!!");
      Serial.println("Registration Fail");
    }
    j = 0;
    k = 0;
    delay(2500);
    lcd.clear();
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_welcome ()
{
  Serial.println("==> Welcome <==");
  lcd.print("===> WELCOME <==");
  lcd_serialprint_module();
  delay(2500);
  lcd.clear();
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_close()
{
  Serial.println("=> CLOSE NOW <=");
  lcd.print("==> CLOSE NOW <=");
  lcd_serialprint_module();
  delay(2500);
  lcd.clear();
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_registration()
{
  Serial.println("READY REGISTRATION");
  lcd.setCursor(0,0);
  lcd.print("==> REGISTRATION");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_module()
{
  lcd.setCursor(0,1);
  if(Server == "getUID.php")
  {
    Serial.println("MODULE 1");
    lcd.print("==> MODULE 1 <==");
  }
  else if (Server == "getUID2.php")
  {
    Serial.println("MODULE 2");
    lcd.print("==> MODULE 2 <==");
  }
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_timeout()
{
  Serial.println();
  Serial.print("TIMEOUT!, => ");
  Serial.println(interval);

  lcd.setCursor(0,1);
  lcd.print("   TIMEOUT!!!   ");
}
//-------------------------------------------------------------------------//

//-------------------------------------------------------------------------//
void lcd_serialprint_Saldo()
{
  lcd.setCursor(0,1);
  lcd.print("                ");
  lcd.setCursor(0,1);
  lcd.print("Saldo:");
  lcd.print(balance);

  Serial.print(", Saldo: ");
  Serial.println(balance);
}
//-------------------------------------------------------------------------//
//====================================================== LCD SERIAL PRINT ==================================================================================================================//

//======================================================     LCD      ======================================================================================================================//
//==========================================================================//
void lcd_card()
{
  lcd.setCursor(0,0);

  if(trigger_Admin == 0 && trigger_Regist == 0)
    lcd.print("Admin Tag Card!!");
  else if (trigger_Regist == 1)
    lcd.print("Regist The Card!");
  else
    lcd.print("Please Tag Card!");
  
  if(j == 16)
  {
    lcd.setCursor(k,1);
    lcd.print(" ");
    k++;
    if(k == 16)
    {
      j = 0;
      k = 0;
    }
  }
  else
  {
    lcd.setCursor(j,1);
    lcd.print(".");
    j++;
  }
}
//==========================================================================//

//==========================================================================//
void lcd_detected()
{
  lcd.clear();
  lcd.setCursor (0,0);
  lcd.print("Card Detected!");
  lcd.setCursor (0,1);
  lcd.print("Please wait");
}
//==========================================================================//

//==========================================================================//
void lcd_status_http(int error_msg)
{
  lcd.clear();
  lcd.setCursor(0,0);
  if(error_msg == 200)
  {
    lcd.print("=> Detected!    ");
  }
  else
  {
    lcd.print("=> Error: ");
    lcd.print(error_msg);
  }
}
//==========================================================================//

//==========================================================================//
void lcd_disconnect()
{
  lcd.setCursor (0,0);
  lcd.print("=> Disconnected!");
  lcd.setCursor (0,1);
  lcd.print("Connecting");
}
//==========================================================================//

//==========================================================================//
void lcd_wait_trigger()
{
  if(m == 5)
  {
    lcd.setCursor(n+11,1);
    lcd.print(" ");
    n++;
    if(n == 5)
    {
      m = 0;
      n = 0;
    }
  }
  else
  {
    lcd.setCursor(m+11,1);
    lcd.print(".");
    m++;
  }
}
//==========================================================================//

//==========================================================================//
void serial_print_address()
{
  Serial.println("==> Address");
  Serial.print("Server: ");
  Serial.println(begin_srvr);
  Serial.println();
  Serial.print("Trigger: ");
  Serial.println(trigger_srvr);
  Serial.print("Name: ");
  Serial.println(name_srvr);
  Serial.print("Balance: ");
  Serial.println(balance_srvr);
  Serial.println(); 
}
//==========================================================================//

//==========================================================================//
void serial_print_notRegister()
{
  Serial.println();
  Serial.println();
  Serial.print(StrUID);
  Serial.println(" ==> Not Registered");
}
//==========================================================================//

//==========================================================================//
void serial_print_Name()
{
  Serial.println();
  Serial.println();
  Serial.print(StrUID);
  Serial.print(" ==> Name: ");
  Serial.print(nameID);
}
//==========================================================================//
//======================================================     LCD      ======================================================================================================================//

//====================================================== BUZZER ============================================================================================================================//
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
void buzzer_start()
{
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
void buzzer_detect_card()
{
   digitalWrite(pinBuzzer, HIGH);
   delay(50);
   digitalWrite(pinBuzzer, LOW);
   delay(50);
   digitalWrite(pinBuzzer, HIGH);
   delay(50);
   digitalWrite(pinBuzzer, LOW);
   delay(50);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
void buzzer_true()
{
  digitalWrite(pinBuzzer, HIGH);
  delay(250);
  digitalWrite(pinBuzzer, LOW);
  delay(250);
  digitalWrite(pinBuzzer, HIGH);
  delay(250);
  digitalWrite(pinBuzzer, LOW);
  delay(250);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
void buzzer_false()
{
  digitalWrite(pinBuzzer, HIGH);
  delay(1400);
  digitalWrite(pinBuzzer, LOW);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
void buzzer_disconnect()
{
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
  digitalWrite(pinBuzzer, HIGH);
  delay(50);
  digitalWrite(pinBuzzer, LOW);
  delay(50);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//====================================================== BUZZER ============================================================================================================================//

//===================================================== HTTP GET STRING ======================================
String httpGETRequest(String serverName) {
  HTTPClient http;   
    
  // Your IP address with path or Domain name with URL path 
  http.begin(serverName);
  
  // Send HTTP POST request
  int httpResponseCode = http.GET();
  
  String payload = "--------"; 
  
  if (httpResponseCode>0) {
    Serial.print("HTTP Response code: ");
    Serial.print(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.print("Error code: ");
    Serial.print(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}
//===================================================== HTTP GET STRING ======================================
//========================================================          EVERY FUNCTION "void"           ========================================================================================//
