<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Toggle.php");
require_once(__DIR__."/../model/ToggleMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

class ToggleController extends BaseController {
    private $toggleMapper;

    public function __construct() {
		parent::__construct();

		$this->toggleMapper = new ToggleMapper();

		$this->view->setLayout("auth");
	}

    public function view() {
        $this->view->render("dashboard", "dashboard");
    }

    /**
	* Action to list posts
	*
	* Loads all the posts from the database.
	* No HTTP parameters are needed.
	*
	* The views are:
	* <ul>
	* <li>posts/index (via include)</li>
	* </ul>
	*/
	public function index() {

        // Obtain UserID
        $userID = $this->getCurrentUserId();
       

		$toggles = $this->toggleMapper->findAll($userID);

		// put the array containing Post object to the view
		$this->view->setVariable("toggles", $toggles);

		// render the view (/view/dashboard/dashboard.php)
		$this->view->render("dashboard", "dashboard");
	}

    public function suscribed() {
        // Obtain UserID
        $userID = $this->getCurrentUserId();

		$suscribedToggles = $this->toggleMapper->findSuscribed($userID);

		// put the array containing Post object to the view
		$this->view->setVariable("suscribedToggles", $suscribedToggles);

		// render the view (/view/dashboard/dashboard.php)
		$this->view->render("dashboard", "suscritos");
    }

/**
 * Action to view the details of a toggle switch using either public or private URI
 *
 * This action should only be called via GET.
 *
 * The expected HTTP parameters are:
 * <ul>
 * <li>id: ID of the switch (via HTTP GET), which can be either public or private</li>
 * </ul>
 *
 * The views are:
 * <ul>
 * <li>toggles/view: If the switch is successfully loaded (via include). Includes these view variables:</li>
 * <ul>
 *   <li>switch: The current Switch retrieved</li>
 * </ul>
 * </ul>
 *
 * @throws Exception If no such switch with the given ID is found
 * @return void
 */
public function toggleInformation(){

    if (!isset($_GET["uri"])) {
        throw new Exception("URI is mandatory");
    }

    $toggleURI = $_GET["uri"];

    // Retrieve the switch information using the provided public or private ID
    $toggle = $this->toggleMapper->findByPublicOrPrivateURI($toggleURI);

    if ($toggle == NULL) {
        throw new Exception("No switch found with the given URI: ".$toggleURI);
    }

    // Put the Switch object into the view
    $this->view->setVariable("toggle", $toggle);

    $this->view->renderWithoutLayout("dashboard", "information");
}


    public function add() {
        if (!$this->checkSession()) {
            return;
        }
        
        $toggle = new Toggle();
    
        $toggle->setUserId($this->getCurrentUserId());
        $toggle->setPrivateId($this->generateUUID());
        $toggle->setPublicId($this->generateUUID());
        $toggle->setToggleName($_POST["name"]);
        $toggle->setState(filter_var($_POST['state'], FILTER_VALIDATE_BOOLEAN));
        
        // Establece la fecha predeterminada si el estado es "encendido" y no se proporciona una fecha en el formulario
        if ($toggle->getState()) {
            $shutdownDate = !empty($_POST['shutdown_date']) ? $_POST['shutdown_date'] : $toggle->defaultShutdownDate();
        } else {
            $shutdownDate = NULL;
        }

        
        $toggle->setShutdownDate($shutdownDate);
        $toggle->setDescription($_POST['description']);
    
        try {
            $toggle->isValidToggle();
            $this->toggleMapper->save($toggle);
            $this->view->setFlash(i18n("toggleAdded"));
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setFlash("Error: " . implode(", ", $errors), "error");
        }
    
        $this->view->redirect("toggle", "index");
    }
    


    private function generateUUID(){
        return trim(file_get_contents('/proc/sys/kernel/random/uuid'));
    }

    public function onUser(){
        if (!$this->checkSession()) return;

        $toggle = new Toggle();

        $toggle->setUserId($this->getCurrentUserId());
        $toggle->setShutdownDate(
            !empty($_POST['shutdown_date']) ? $_POST['shutdown_date'] : $toggle->defaultShutdownDate()
        );
        $toggle->setState(true);
        $toggle->setToggleId($_POST['id']);
        $toggle->setTurnOnDate($this->getActualDateTime());

        try{
            $toggle->canTurnOn();
            $this->toggleMapper->turnOnUser($toggle);
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            print_r($ex);
        }

        $this->view->setFlash("toggle on");
        $this->view->redirect("toggle", "index");
    }

    private function getActualDateTime(){
        $dateTime = new DateTime();
        return $dateTime->format('Y-m-d H:i:s');
    }



    public function onLink() {
        if (!$this->checkSession()) return;
    
        // Obtén la URI pública del toggle desde el formulario
        $publicUri = isset($_GET['uri']) ? $_GET['uri'] : null;
        $previousUrl = $_SERVER['HTTP_REFERER'];

        if ($publicUri) {
            // Realiza una consulta en la base de datos para verificar si la URI es pública
            $isPublic = $this->toggleMapper->isUriPublic($publicUri);
    
            if ($isPublic) {
                $this->view->setFlash(i18n("errorToggleOn"));
                header("Location: $previousUrl");
                exit;
            } else {
                // El toggle no es público, puedes continuar con la acción
                $toggle = new Toggle();
    
                $toggle->setUserId($this->getCurrentUserId());
                $toggle->setShutdownDate(
                    !empty($_POST['shutdown_date']) ? $_POST['shutdown_date'] : $toggle->defaultShutdownDate()
                );
                $toggle->setState(true);
                $toggle->setToggleId($_POST['id']);
                $toggle->setTurnOnDate($this->getActualDateTime());
    
                try {
                    $toggle->canTurnOn();
                    $this->toggleMapper->turnOnUser($toggle);
                    $this->view->setFlash(i18n("toggleOn"));
                    header("Location: $previousUrl");
                    exit;
                } catch (ValidationException $ex) {
                    $errors = $ex->getErrors();
                    print_r($ex);
                }
            }
    
            
        }
    }


    public function offLink() {
        if (!$this->checkSession()) return;
    
        // Obtén la URI pública del toggle desde el formulario
        $publicUri = isset($_GET['uri']) ? $_GET['uri'] : null;
        $previousUrl = $_SERVER['HTTP_REFERER'];

        if ($publicUri) {
            // Realiza una consulta en la base de datos para verificar si la URI es pública
            $isPublic = $this->toggleMapper->isUriPublic($publicUri);
    
            if ($isPublic) {
                $this->view->setFlash(i18n("errorToggleOff"));
                header("Location: $previousUrl");
                exit;
            } else {
                // El toggle no es público, puedes continuar con la acción
                $toggle = new Toggle();
    
                $toggle->setUserId($this->getCurrentUserId());
                $toggle->setShutdownDate(NULL);
                $toggle->setState(false);
                $toggle->setToggleId($_POST['id']);
    
                try {
                    $toggle->canTurnOff();
                    $this->toggleMapper->turnOffUser($toggle);
                    $this->view->setFlash(i18n("toggleOff"));
                    header("Location: $previousUrl");
                    exit;
                } catch (ValidationException $ex) {
                    $errors = $ex->getErrors();
                    print_r($ex);
                }
            }
    
            
        }
    }
    
    





    /*
    public function onLink(){
        $toggle = new Toggle();

        $toggle->setPrivateId($_POST['private_id']);
        $toggle->setShutdownDate(
            isset($_POST['shutdown_date']) ? $_POST['shutdown_date'] : $this->defaultShutdownDate()
        );
        $toggle->setState(true);
        $toggle->setTurnOnDate($this->getActualDateTime());

        try{
            $toggle->canTurnOn();
            $this->toggleMapper->turnOnLink($toggle);
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            print_r($ex);
        }
    }
    */

    public function offUser(){
        if (!$this->checkSession()) return;

        $toggle = new Toggle();

        $toggle->setUserId($this->getCurrentUserId());
        $toggle->setState(false);
        $toggle->setToggleId($_POST['id']);
        $toggle->setShutdownDate(NULL);

        try{
            $toggle->canTurnOff();
            $this->toggleMapper->turnOffUser($toggle);
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            print_r($ex);
        }
        
        $this->view->setFlash(i18n("toggleOn2"));
        $this->view->redirect("toggle", "index");
    }

    /*
    public function offLink(){
        $toggle = new Toggle();

        $toggle->setPrivateId($_POST['private_id']);
        $toggle->setShutdownDate(NULL);
        $toggle->setState(false);

        try{
            $toggle->canTurnOff();
            $this->toggleMapper->turnOffLink($toggle);
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            print_r($ex);
        }
    }
    */


    /**
 * Action to delete a toggle
 */
public function delete() {
    // Check if the user is logged in
    if (!$this->checkSession()) {
        throw new Exception("Not in session. Deleting toggles requires login");
    }

    // Get the current user from the session or your authentication system
    $currentUserId = $_SESSION['user_id']; // Adjust this based on your actual session structure

    // Get the ID of the toggle to be deleted
    $toggleId = (int)$_GET["id"];
    
    // Check if a valid toggle ID was provided
    if (!$toggleId) {
        throw new Exception("Invalid toggle ID provided");
    }

    // Get the Toggle object from the database
    $toggle = $this->toggleMapper->getToggleById($toggleId); // Adjust based on your data retrieval method

    if (!$toggle) {
        throw new Exception("No such toggle with ID: " . $toggleId);
    }

    // Check if the Toggle owner is not the current user
    if ($toggle['user_id'] !== $currentUserId) { // Assuming the user ID is stored in the 'user_id' field
        throw new Exception("You are not the owner of this toggle. Access denied.");
    }

    // Delete the Toggle object from the database
    $this->toggleMapper->delete($toggleId);
    $this->view->setFlash("toggle " .$toggleId . " " . i18n("deleted"));
    // After deleting the toggle, you can redirect to a suitable location.
    $this->view->redirect("toggle", "index");
}







    

    private function checkSession(){
        /*if (!isset($_SESSION["user_id"])){
		    $this->view->render("users", "login");
            return false;
		}*/
        return true;
    }

    public function checkUriAccessibility() {
        // Obtén la URI de la solicitud (puedes usar $_GET o $_POST según cómo se pasó la URI)
        $uri = isset($_GET['uri']) ? $_GET['uri'] : null;
    
        if ($uri) {
            // Realiza una consulta en la base de datos para verificar si la URI es pública o no
            $isPublic = $this->toggleMapper->isUriPublic($uri);
    
            if ($isPublic) {
                echo "La URI es pública.";
            } else {
                echo "La URI no es pública.";
            }
        } else {
            echo "URI no especificada.";
        }
    }
    

    public function getCurrentUserId() {
		session_start();
        
		if (isset($_SESSION["user_id"])) {
			return $_SESSION["user_id"];
		} else {
			return 0;
		}
	}
}   