document.addEventListener("DOMContentLoaded", function() {
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                let res = JSON.parse(this.responseText);
                
                if (res.logado) {
          
                    let botoesLogin = document.querySelectorAll('.btn-login, .login-btn');
                    
                    botoesLogin.forEach(function(btnLogin) {
      
                        btnLogin.innerHTML = "<span style='color: var(--primary-gold, #c79419); margin-right: 15px; font-weight: bold;'>Olá, " + res.nome + "</span>" +
                                             "<a href='javascript:void(0)' onclick='fazerLogout()' style='color: #e74c3c; text-decoration: none; font-weight: bold; border: 1px solid #e74c3c; padding: 5px 10px; border-radius: 4px; display: inline-block;'>Sair</a>";
                        
                       
                        btnLogin.removeAttribute("href");
                        btnLogin.style.background = "none";
                        btnLogin.style.border = "none";
                    });
                }
            } catch (e) {
                console.error("Erro ao verificar sessão: ", e);
            }
        }
    };
    
    xhttp.open("GET", "verificaSessao.php", true);
    xhttp.send();
});


function fazerLogout() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        
            window.location.href = "index.html"; 
        }
    };
    xhttp.open("GET", "logout.php", true);
    xhttp.send();
}