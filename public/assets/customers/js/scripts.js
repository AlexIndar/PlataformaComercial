
$('document').ready(function(){


        var loop = 1;
        setInterval(function() {
            if(loop == 1){
                document.getElementById('img-dashboard-large').src = "https://scontent.fgdl10-1.fna.fbcdn.net/v/t1.6435-9/243937895_3100923426896194_5845392087450481642_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=e3f864&_nc_ohc=zH_BBwRPG9YAX-VAfpo&_nc_ht=scontent.fgdl10-1.fna&oh=eee16d624b471fdccbf182517fc668be&oe=6195594F";
            }
            else if (loop == 2){
                document.getElementById('img-dashboard-large').src = "https://scontent.fgdl10-1.fna.fbcdn.net/v/t1.6435-9/242323508_3091716341150236_1045406851031920209_n.jpg?_nc_cat=102&ccb=1-5&_nc_sid=e3f864&_nc_ohc=lNoYV-MS8g8AX8ia_8a&_nc_ht=scontent.fgdl10-1.fna&oh=06f4234ce5c2a46b4838f3ef012aed21&oe=61978681";
            }
            else{
                document.getElementById('img-dashboard-large').src = "https://scontent.fgdl10-1.fna.fbcdn.net/v/t1.6435-9/241447777_3078645065790697_4540716823988862953_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=e3f864&_nc_ohc=426IN6lm2YYAX8vYT1_&tn=FOolqII-9jtV7H_R&_nc_ht=scontent.fgdl10-1.fna&oh=745ea3bd8c9cc03619261275e64f2094&oe=6195C800";
            }

            if(loop == 3){
                loop = 1;
            }
            else{
                loop++;
            }


        }, 3000);

});

function conocerMas(){
    console.log("Conocer mas");
}

function validateLogin(){
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    if(email == 'alejandro.jimenez@indar.com.mx' && password == '211098'){
        window.location.href = '/main';
    }
    else{
        console.log('Usuario o contraseña incorrectos');
    }
}

function login(){
    document.getElementById("btnLogin").click();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    document.cookie = "iU="+email;
    document.cookie = "iP="+password;
}


