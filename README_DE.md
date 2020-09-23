![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)


# CardGate Erweiterung für Opencart 2.3

[![Build Status](https://travis-ci.org/cardgate/opencart23.svg?branch=master)](https://travis-ci.org/cardgate/opencart23)

## Support

Diese Erweiterung is geeignet für OpenCart Version **2.3**

## Vorbereitung

Für die Verwendung dieses Moduls sind CardGate RESTful-Daten erforderlich.  
Besuchen Sie dazu [Mein CardGate](https://my.cardgate.com/) und rufen Sie dort Ihre Daten ab,  
oder wenden Sie sich an Ihren Account Manager.

## Installation

1. Laden Sie die neueste Datei [cardgate.zip](https://github.com/cardgate/opencart23/releases/) auf Ihren Desktop herunter und entpacken Sie sie.

2. Laden Sie die Ordner **admin, catalog und image** aus der Zip-Datei in die **gleichnamigen Ordne** Ihres Webshops hoch.

## Configuratie

1. Gehen Sie zum **Admin** Bereich Ihres Webshops und wählen Sie **Erweiterungen, Zahlungsmethoden**.

2. Scrollen Sie zu der **CardGate-Zahlungsmethode**, die Sie installieren möchten, und wählen Sie **Installieren**.

3. Klicken Sie nun auf den Button **Anpassen** dieser Zahlungsmethode und wechseln Sie zum Tab **Allgemein**.

4. Geben Sie die **Site-ID**, den **Hash-Key**, die **Merchant-ID** und den **API-Key** ein.

5. Diese Daten finden Sie unter **Sites** auf [Mein CardGate](https://my.cardgate.com/).

6. Geben Sie die anderen Daten ein und setzen Sie den **Status** der Erweiterung auf **Aktiv**.

7. Gehen Sie zum Tab **Order-Status** und geben Sie die richtigen Statuswerte ein.

8. Klicken Sie nun auf den Button **Speichern**.

9. Wählen Sie nun die **CardGate-Zahlungsmethode** aus, die Sie verwenden möchten, und klicken Sie auf **Installieren**

10. Klicken Sie auf den Button **Ändern** der Zahlungsmethode und setzen Sie den **Plugin-Status** auf **Aktiv**.

11. Wiederholen Sie die Schritte **9 und 10** für jede Zahlungsmethode, die Sie aktivieren möchten.

12. Gehen Sie zu [Mein CardGate](https://my.cardgate.com/), wählen Sie **Webseiten** und wählen Sie die richtige Webseite aus.

13. Geben Sie unter **Technischer Schnittstelle** die **Callback-URL** ein, zum Beispiel:  
    **http://mijnwebshop.com/index.php?route=payment/cardgategeneric/control**  
    (Ersetzen Sie **http://mijnwebshop.com** durch die URL Ihres Webshops.)

14. Wenn Sie mit dem **Testen** abgeschlossen haben, schalten Sie alle **aktivierten Zahlungsmethoden** vom **Testmodus** in den **Live-Modus** und speichern Sie ihn (**Save**)

## Anforderungen
Keine weiteren Anforderungen
