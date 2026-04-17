#include <Arduino.h>
#include <WiFiManager.h>
#include <HTTPClient.h>
#include <ArtronShop_LineNotify.h>
#include <SPIFFS.h> 
#include <FS.h>

#define BLYNK_TEMPLATE_ID "TMPL6td8JZ90X"
#define BLYNK_TEMPLATE_NAME "Testmini"
#define BLYNK_AUTH_TOKEN "qlZCShfXZs1pkAkq7or0PzwNNOOynARc"

#include <BlynkSimpleEsp32.h> 

#define SensorAna 34
#define Relay 12
#define ResetButton 25
#define Buzzer 33

void WiFiSetup();
IRAM_ATTR void checkResetButton();
String getTimestamp();
void sendStoredData();
void logData(int lightValue, String status, String timestamp);
void sendDataToGoogleSheets(int lightValue, String status, String timestamp);

#define LINE_TOKEN "r0WYHAV5tTwbrYkT0MWPofTFULVeKBnH94FTa8vow2l"
String GOOGLE_SHEETS_ID = "AKfycbxaRw4i0yg36ZFNlu9udFcHpMIMFn19k66hmKNGIPSpImKYIkH1g7tQclJ27nDmWf7RiA";
LINE_Notify_Massage_Option_t lightON;
LINE_Notify_Massage_Option_t lightOFF;

const int MODE_AUTO = 0;
const int MODE_MANUAL = 1;
int state;
int LightValue; 
int ValueRelay;
int ValueMode;
bool ledState = LOW;
String timestamp;

void setup() {
  Serial.begin(115200);

  if (!SPIFFS.begin(true)) {
    Serial.println("SPIFFS Mount Failed");
    return;
  } Serial.println("SPIFFS Mount Success");

  pinMode(SensorAna, INPUT);
  pinMode(Relay, OUTPUT);
  pinMode(ResetButton, INPUT_PULLUP);
  pinMode(Buzzer, OUTPUT);

  attachInterrupt(digitalPinToInterrupt(ResetButton), checkResetButton, FALLING);

  WiFiSetup();

  configTime(7 * 3600, 0, "pool.ntp.org", "time.nist.gov");   // ตั้งเวลาเป็น UTC+7 (GMT+7)

  Blynk.config(BLYNK_AUTH_TOKEN);
  if (Blynk.connect()) {
    Serial.println("Connected to Blynk!");
  } else {
    Serial.println("Failed to connect to Blynk.");
  }

  LINE.begin(LINE_TOKEN);
  lightON.sticker.package_id = 789;
  lightON.sticker.id = 10857;
  lightOFF.sticker.package_id = 789;
  lightOFF.sticker.id = 10881;

  state = MODE_AUTO;
}

void loop() {
  LightValue = analogRead(SensorAna);
  timestamp = getTimestamp();
    
  if (state == MODE_AUTO) {
    if (LightValue <= 2047 && ledState == HIGH) {
      digitalWrite(Relay, LOW);
      ledState = LOW;
      Serial.println("Auto : LED is off");
      if (WiFi.status() == WL_CONNECTED) {
        LINE.send("ปิดไฟแล้ว", &lightOFF);
        sendDataToGoogleSheets(LightValue, "off", timestamp);
        delay(1000);
      } else {
        logData(LightValue, "off", timestamp);
        Serial.println("WiFi disconnected, attempting to reconnect...");
        WiFi.reconnect();
      }
    } else if (LightValue > 2047 && ledState == LOW) {
      digitalWrite(Relay, HIGH);
      ledState = HIGH;
      Serial.println("Auto : LED is on");
      if (WiFi.status() == WL_CONNECTED) {
        LINE.send("เปิดไฟแล้ว", &lightON);
        sendDataToGoogleSheets(LightValue, "on", timestamp);
        delay(1000);
      } else {
        logData(LightValue, "on", timestamp);
        Serial.println("WiFi disconnected, attempting to reconnect...");
        WiFi.reconnect();
      }
    }
    checkResetButton();
    if(ValueMode == 1) {
      Serial.println("Mode : Manual");
      state = MODE_MANUAL;
    }
  } 
  
  else if (state == MODE_MANUAL) {
    if (ValueRelay == HIGH && ledState == LOW) {
      digitalWrite(Relay, HIGH);
      ledState = HIGH;
      Serial.println("Manual : LED is on.");
    } else if (ValueRelay == LOW && ledState == HIGH) {
      digitalWrite(Relay, LOW);
      ledState = LOW;
      Serial.println("Manual : LED is off.");
    }
    checkResetButton();
    if(ValueMode == 0) {
      Serial.println("Mode : Auto");
      state = MODE_AUTO;
    }
  }

  if (WiFi.status() == WL_CONNECTED) {
    Blynk.run();
    sendStoredData();  // ส่งข้อมูลที่เก็บไว้ (ถ้ามี) เมื่อมีการเชื่อมต่ออินเทอร์เน็ต
  }
}

BLYNK_WRITE(V1) {  //ปุ่มเปิดปิดไฟ
  ValueRelay = param.asInt();
}

BLYNK_WRITE(V2) {  // ปุ่มเปลี่ยนโหมด
  ValueMode = param.asInt();
}

void logData(int lightValue, String status, String timestamp) {  // เก็บข้อมูลขณะไม่มีอินเตอร์เน็ต
  File file = SPIFFS.open("/log.txt", FILE_APPEND);
  if (file) {
    file.printf("%s,%d,%s\n", timestamp.c_str(), lightValue, status.c_str()); // ใช้ timestamp ที่ส่งมา
    file.close();
    Serial.println("Logged data locally.");
  } else {
    Serial.println("Failed to open log file.");
  }
}

void sendStoredData() {  // ส่งข้อมูลที่ถูกเก็บไว้ขณะไม่มีอินเตอร์เน็ต
  if (WiFi.status() == WL_CONNECTED) {
    if (SPIFFS.exists("/log.txt")) {
      File file = SPIFFS.open("/log.txt", FILE_READ);
      if (file) {
        while (file.available()) {
          String line = file.readStringUntil('\n');
          int commaIndex1 = line.indexOf(',');
          int commaIndex2 = line.indexOf(',', commaIndex1 + 1);
          String timestamp = line.substring(0, commaIndex1);
          String lightValue = line.substring(commaIndex1 + 1, commaIndex2);
          String status = line.substring(commaIndex2 + 1);

          // ส่งข้อมูลพร้อม timestamp
          sendDataToGoogleSheets(lightValue.toInt(), status, timestamp);
        }
        file.close();
        SPIFFS.remove("/log.txt");
        Serial.println("All data sent.");
      }
    }
  }
}

void sendDataToGoogleSheets(int lightValue, String status, String timestamp) {  // ส่งข้อมูลไปที่ Google Sheets
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String url = "https://script.google.com/macros/s/" + GOOGLE_SHEETS_ID + 
                 "/exec?light=" + String(lightValue) + "&status=" + status + "&timestamp=" + timestamp;

    http.begin(url);
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.println("Data sent to Google Sheets successfully.");
    } else {
      Serial.print("Error sending data: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  } else {
    Serial.println("WiFi disconnected.");
  }
}

String getTimestamp() {  // แปลงเวลาเพื่อเป็นเวลาบันทึกข้อมูลขณะที่ไมีมีอินเตอร์เน็ต
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo)) {
    Serial.println("Failed to obtain time");
    return ""; // คืนค่าเป็นสตริงว่างถ้าไม่สามารถดึงเวลาได้
  }
  // แปลงเวลาที่ได้เป็น timestamp (วินาที)
  return String(mktime(&timeinfo));
}

IRAM_ATTR void checkResetButton() { // ปุ่มรีเซ็ตอินเตอร์เน็ต
  if (digitalRead(ResetButton) == HIGH) {
    Serial.println("Resetting WiFi settings...");
    tone(Buzzer, 1000, 300); // เล่นเสียงที่ความถี่ 1000 Hz เป็นเวลา 300ms
    delay(500);  // หน่วงเวลาเพื่อป้องกันการกดซ้ำ

    WiFiManager wm;
    wm.resetSettings();  // ล้างข้อมูล WiFi ที่เก็บไว้
    ESP.restart();  // รีสตาร์ทบอร์ด
  }
}

void WiFiSetup() {  // เชื่อมต่ออินเตอร์เน็ต    
    WiFiManager wm;

    bool res;
     res = wm.autoConnect("NommeawAP");

    if(!res) {
        Serial.println("Failed to connect");
        ESP.restart();
    } 
    else {  
        Serial.println("connected...yeey :)");
        tone(Buzzer, 1000, 300);
    }
}