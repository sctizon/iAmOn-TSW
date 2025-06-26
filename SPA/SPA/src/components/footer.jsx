import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import '../styles/styles.css';

function Footer() {
  return (
    <footer>
      <div className="footerContainer">
        <h4 className="inferior__titulo">Siguenos</h4>
        <a href="https://google.com" target="_blank" rel="noreferrer">
          <FontAwesomeIcon icon="fa-brands fa-instagram" />
        </a>
        <a href="https://google.com" target="_blank" rel="noreferrer">
          <FontAwesomeIcon icon="fa-brands fa-twitter" />
        </a>
        <a href="https://google.com" target="_blank" rel="noreferrer">
          <FontAwesomeIcon icon="fa-brands fa-linkedin" />
        </a>
        <a href="https://google.com" target="_blank" rel="noreferrer">
          <FontAwesomeIcon icon="fa-brands fa-github" />
        </a>
        <p>Todos los derechos reservados 2023</p>
      </div>
    </footer>
  );
}

export default Footer;
