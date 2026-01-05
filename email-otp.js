function sendOTP() {
    const email= document.getElementById('email');
    const otpverify = document.getElementsByClassName('otpverify')[0];

    let otp_val = Math.floor(Math.random() * 10000) ;

    let emailbody = `<h2> Your OTP is </h2>${otp_val}` ;
    email.send({
    SecureToken : "e80c0e02-daed-4cad-956e-5a02684d326b",
    To : email.value,
    From : "jhastinemercede@gmail.com",
    Subject : "Email OTP using JavaScript",
    Body :emailbody,
}).then(
 
 
    message => {
        if (message === "OK") { 
            alert("OTP sent to your email" + email.value);
        otpverify.style.display = "flex";
        const otp_inp = document.getElementById('otp_inp');
        const otp_btn = document.getElementById('otp_btn'); 

        otp_btn.addEventListener('click', () => {
            if (otp_inp.value == otp_val) {
                alert("Email address varified...");
        }
        else { 
         alert("invalid OTP");
        }
        })
    }
   } 
);
}