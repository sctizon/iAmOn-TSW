import Footer from "../components/footer";

function PasswordRecovery() {
  return (
        <div className="signUpIn">
          <div className="container">
            <div className="formContainer">
              <div className="registerContainer">
                <div className="logo">
                  <h1>Iam</h1>
                  <label className="switchLogo">
                    <input type="checkbox" />
                    <span className="slider round"></span>
                  </label>
                  <h1>N</h1>
                </div>
              </div>
              <form className="loginForm">
                <input
                  id="email"
                  type="email"
                  placeholder="email"
                  required
                />
                <button className="submitButton" type="submit">
                  <span>Recuperar Contraseña</span>
                </button>
                <a href="./signIn.html">Volver a la página principal</a>
              </form>
            </div>
          </div>
          <Footer></Footer>
        </div>
  );
}

export default PasswordRecovery;
