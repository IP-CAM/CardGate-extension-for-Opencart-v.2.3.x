![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate extensie voor Opencart 2.3

## Support

Deze extensie is geschikt voor OpenCart versie **2.3**.

## Voorbereiding

Voor het gebruik van deze module zijn CardGate RESTful gegevens nodig.  
Bezoek hiervoor [Mijn CardGate](https://my.cardgate.com/) en haal daar je  
gegevens op, of neem contact op met je accountmanager.  

## Installatie

1. Download en unzip de meest recente [source code](https://github.com/cardgate/opencart23/releases/) op je bureaublad.

2. Upload de **inhoud** van de zipfile naar de **gelijknamige mappen** op je webshop.

## Configuratie

1. Ga naar het **admin** gedeelte van je webshop en kies **Extenties, Betaalmethoden**.

2. Scroll naar de **CardGate betaalmethode** die je wenst te installeren en kies **Installeren**.

3. Klik nu op de knop **Wijzigen** van deze betaalmethode en ga naar het tabblad **Algemeen**. 

4. Vul de **site ID** en de **hash key** in.

5. Deze variabelen zijn te vinden bij **Sites** op [Mijn CardGate](https://my.cardgate.com/).

6. Vul de andere waarden in en zet de **status** van de extensie op **Actief**.

7. Ga naar het tabblad **Order Status** en vul de juiste status waarden in.

8. Klik nu op de knop **Bewaren**.

9. Herhaal de stappen **2 tot en met 8** voor iedere betaalmethode die je wenst te activeren.

10. Ga naar [Mijn CardGate](https://my.cardgate.com/), kies Sites en selecteer de juiste site.
 
11. Vul bij **Technische koppeling** de **Callback URL** in, bijvoorbeeld:  
    **http://mijnwebshop.com/index.php?route=payment/cardgategeneric/control**  
    (Vervang **http://mijnwebshop.com** met de URL van je webshop**)    
    
12. Als je klaar bent met **testen** schakel dan alle **geactiveerde betaalmethoden** van **Test Mode** naar **Live mode** en sla het op (**Save**).

## Vereisten

Geen verdere vereisten.
