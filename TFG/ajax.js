$(document).ready(function() {
    console.log("Document is ready.");
    $('#messageForm').submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"controller/chatController.php",
            type:"post",
            data:$('#messageForm').serialize(),
            success: function(resultado) {
                $('#messageInput').val('');
                updateChat(scrollToBottom); // Llama a updateChat con scrollToBottom como callback
            
            },
            error: function(xhr, status, error) {
                // Errores
                console.error(error);
            }	
        });
    });
});

function scrollToBottom() {
    var chatContainer = document.getElementById('chat');
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function updateChat(callback) {
    var chatContainer = document.getElementById('chat');
    var isScrolledToBottom = chatContainer.scrollHeight - chatContainer.clientHeight <= chatContainer.scrollTop + 1;

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if  (req.readyState == 4 && req.status == 200){
            chatContainer.innerHTML = req.responseText;
            if (callback && typeof callback === "function") {
                callback(); // Llama al callback si existe y es una función
            }

            if (isScrolledToBottom) {
                // Si el usuario ya está en la parte inferior, desplazar hacia abajo para mostrar el nuevo mensaje
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }
    }
    req.open('GET', 'chat.php', true);
    req.send();
}

var imagesCache = {};

function updateContacts() {
    var reqContacts = new XMLHttpRequest();

    reqContacts.onreadystatechange = function() {
        if (reqContacts.readyState == 4 && reqContacts.status == 200) {
            var contactsList = document.getElementById('contactsList');
            var newContacts = reqContacts.responseText;
            var parser = new DOMParser();
            var newDoc = parser.parseFromString(newContacts, 'text/html');

            // Iterar sobre los nuevos elementos de contacto
            var newContactElements = newDoc.querySelectorAll('li');
            newContactElements.forEach(function(newContactEl) {
                var newImg = newContactEl.querySelector('img');
                var userid = newImg.getAttribute('src').match(/userid=(\d+)/)[1];

                // Verifica si hay un cambio en el hash de la imagen
                if (imagesCache[userid] && newImg && imagesCache[userid].src.split('&hash=')[1] !== newImg.getAttribute('src').split('&hash=')[1]) {
                    imagesCache[userid] = {
                        src: newImg.src,
                        hash: newImg.getAttribute('src').split('&hash=')[1]
                    };
                }
            });

            // Actualizar el DOM solo si es necesario
            if (contactsList.innerHTML !== newDoc.body.innerHTML) {
                contactsList.innerHTML = newDoc.body.innerHTML;
            }
        }
    };
    reqContacts.open('GET', 'contacts.php', true);
    reqContacts.send();
}

function updateProfile() {
    var reqProfile = new XMLHttpRequest();

    reqProfile.onreadystatechange = function() {
        if (reqProfile.readyState == 4 && reqProfile.status == 200) {
            var newUserProfile = reqProfile.responseText;
            var profileDiv = document.getElementById('divProfile');

                // Extraer la nueva información
                var parser = new DOMParser();
                var newDoc = parser.parseFromString(newUserProfile, 'text/html');
                var newImg = newDoc.querySelector('.img_cont img');
                
                var newUserName = newDoc.querySelector('.user_info span') ? newDoc.querySelector('.user_info span').textContent.trim() : null;

                // Actualizar selectivamente los elementos que han cambiado
                var currentImg = profileDiv.querySelector('.img_cont img');
                var currentUserName = profileDiv.querySelector('.user_info span');

                if (currentImg && newImg && currentImg.getAttribute('src').split('&hash=')[1] !== newImg.getAttribute('src').split('&hash=')[1]) {
                    currentImg.src = newImg.src;
                }
                if (currentUserName && newUserName && currentUserName.textContent !== newUserName) {
                    currentUserName.textContent = newUserName;
                }
                console.log(currentUserName);
                console.log(newUserName);

            console.log(newUserProfile);
        }
    };

    reqProfile.open('GET', 'profileData.php', true);
    reqProfile.send();
}

setInterval(updateProfile, 500);
setInterval(updateChat, 300); 
setInterval(updateContacts, 500);
