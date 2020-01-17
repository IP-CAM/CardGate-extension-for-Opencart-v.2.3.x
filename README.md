![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate extension for Opencart 2.3

[![Build Status](https://travis-ci.org/cardgate/opencart23.svg?branch=master)](https://travis-ci.org/cardgate/opencart23)

## Support

This extension supports Opencart version **2.3**

## Preparation

The usage of this module requires that you have obtained CardGate RESTful API credentials.  
Please visit [My CardGate](https://my.cardgate.com/) and retrieve your credentials, or contact your accountmanager.

## Installation

1. Download and unzip the most recent [source code](https://github.com/cardgate/opencart23/releases/) file on your desktop.

2. Upload the **admin and catalog** folders of the zip file to the **folders with the same name** on your webshop.

## Configuration

1. Go to the **admin** section of your webshop and select **Extensions, Payments**.  

2. Scroll to the **CardGate Generic payment method** and select **Install**.  

3. Now click on the **Edit** button of the payment method and go to the **General** tab. 

4. Enter the **site ID**, the **hash key**, the **merchant ID**, and the **API key**.  

5. You can find these variables under **Sites** on [My CardGate](https://my.cardgate.com/).  

6. Enter the other values and set the **Plugin Status** to **Active**.  

7. Go to the **Order Status** tab and enter the correct **status values**.  

8. Now click on the **Save** button.  

9. Now choose the **CardGate payment method** you wish to use and choose **Install**.  

10. Click on the **Edit** button of this payment method and set the **Plugin Status** to **Active**.

11. Repeat steps 9 through 10 for each payment method you wish to activate.

12. Go to [My CardGate](https://my.cardgate.com/), choose **Sites** and select the appropriate site.  
 
13. Go to **Connection to the website** and enter the **hash key**, if you did so in the **CardGate Generic payment method**.

14. When you are **finished testing** make sure that you switch **all activated payment methods** from **Test mode** to **Live mode** and save it (**Save**).

## Requirements

No further requirements.
