import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faX } from '@fortawesome/free-solid-svg-icons';

function ModalWindow() {
  return (
    <div className="modalWindow" id="modalWindow">
      <div className="modal">
        <FontAwesomeIcon icon={faX} id="close" className="fa-m" />
        <h1>Añadir switch</h1>
        <input type="text" placeholder="nombre" required />
        <input type="text" placeholder="duracion" required />
        <button id="createSwitch" type="submit" className="GenericButton">
          <span>Crear</span>
        </button>
      </div>
    </div>
  );
}

export default ModalWindow;
