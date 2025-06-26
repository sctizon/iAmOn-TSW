import Footer from '../components/footer'
import '../styles/styles.css';
function SignIn() {


  return (
        <div className="signUpIn">
          <div className="container">
            <div className="formContainer">
              <div className="registerContainer">
                <div className="logo">
                  <h1 href="./signIn.html">Iam</h1>
                  <label className="switchLogo">
                    <input type="checkbox" />
                    <span className="slider round"></span>
                  </label>
                  <h1>N</h1>
                </div>
              </div>
              <div className="ejemplo">
                <form className="loginForm">
                  <input id="user" type="text" placeholder="usuario" required />
                  <input
                    id="password"
                    type="password"
                    placeholder="contraseña"
                    required
                  />
                  <button id="btn" className="submitButton" type="submit">
                    <span>Iniciar Sesion</span>
                  </button>
                </form>
              </div>
              <div className="loginLinks">
                <a href="./forgotPassword.html">Contraseña olvidada?</a>
                <a href="./signUp.html">No tienes cuenta?</a>
              </div>
            </div>
          </div>
          <Footer></Footer>
        </div>
  );
}

export default SignIn