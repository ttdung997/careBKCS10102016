<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
        <script type="text/javascript">
            window.onload = function()
            {
                // get ref to the 'div' on the page that will display message
                var msgEle = document.getElementById('messageDiv');
                // a function to process message received by the window.
                function receivedMsg(ev)
                {
                    // check to make sure that this message came from the correct domain.
                    var origin = ev.origin || ev.originalEvent.origin;
                    // update the 'div' element to display the message.
                    msgEle.innerHTML = "Message received: " + ev.data;
                    // send response
                    var status;
                    var client_id = getSttFromCookie('session_state').split('%7C')[1]; // dấu '|' bị mã hóa thành '%7C'
                    var origin = ev.origin;
                    var stt = getSttFromCookie('session_state').split('%7C')[0];
                    // ev.data = mes
                    // mes = sha256(client_id + origin + opss + salt) + "." + salt
                    var message = ev.data;
                    
                    if(message.split('.').length != 2)
                    {
                        ev.source.postMessage('error', ev.origin);
                        return;
                    }
                    var salt = message.split('.')[1];
                    var ss = CryptoJS.SHA256(client_id + origin + stt + salt) + "." + salt;

                    if(ss == message)
                    {
                        console.log('so sanh true');
                        status = "unchanged";
                    }
                    else
                    {
                        console.log('so sanh false');
                        status = "changed";
                    }
                    ev.source.postMessage(status, ev.origin);                                                  
                    
                }
                
                function getSttFromCookie(name)
                {
                    var allCookie = document.cookie;
                    var cookieArray = allCookie.split('; ');

                    // now take key-value pair of this array
                    for (var i = 0; i < cookieArray.length; i++) 
                    {
                        var key = cookieArray[i].split('=')[0];
                        if (key == name)
                        {
                            return cookieArray[i].split('=')[1];
                            break;
                        }
                    }
                    return null;
                }
                // setup an event listener that calls receivedMsg() when the window received new msg
                if (window.addEventListener) 
                {
                    window.addEventListener('message', receivedMsg, false);
                }
                else
                {
                    window.attachEvent('onmessage', receivedMsg);
                }
                
            }
        </script>
    </head>
    <body>
        <h3>
            This is Receiver Window
        </h3>
        <p>
            This document is on the {{ config('app.name') }}.
        </p>
        <div id="messageDiv">
            
        </div>
        
    </body>
</html>