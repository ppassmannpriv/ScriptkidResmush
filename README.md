# Resmush all the things (in Magento)

My little extension here will put your uploaded images through the resmush.it API. There are of course some limitations:

  - Max. filesize is 5mb (resmush.it has this limit)
  - It will only work for images uploaded through adminhtml
  - Tests and extensive logging will have to wait a while, you're of course welcome to chime in!

The whole thing works on its own, no config needed for now. Logs will go into a seperate file, so you can have a fighting chance to debug this, if something goes wrong. If you import products via your own API or something else, you can try to adapt my code and integrate the Webservice model. It is not hard to pull off. It is just a cURL to resmush and your result is an object (->dest is your resulting file btw)

Should you have an idea to improve upon, please do! Should we ever meet, let's have a chat and some booze or coffee!

FYI: cURL is needed for this to work, you need to have the regular permissions in place for /media and it will definitely work for Magento 1.9 (also on hhvm! woo!)
