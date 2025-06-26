import Footer from "../components/footer";

function Register() {
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
          <form className="loginForm">
            <input id="name" type="text" placeholder="usuario" required />
            <input id="email" type="email" placeholder="email" />
            <input
              id="password"
              type="password"
              placeholder="contraseña"
              required
            />
            <button className="submitButton" type="submit">
              <span>Registrarse</span>
            </button>
            <a href="./signIn.html">Volver a la página principal</a>
          </form>
        </div>
      </div>
      <Footer></Footer>
    </div>
  );
}

export default Register;
